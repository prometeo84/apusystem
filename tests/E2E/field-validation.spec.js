// @ts-check
const { test, expect } = require('@playwright/test');

async function loginAsAdmin(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 10000 });
    await page.fill('input[name="_username"]', 'admin@demo.com');
    const adminPassword = process.env.ADMIN_PASSWORD || 'Admin123!';
    await page.fill('input[name="_password"]', adminPassword);
    await page.click('button[type="submit"]');
    await Promise.race([
        page.waitForURL(/\/(dashboard|projects|items|$)/, { timeout: 30000 }),
        page.waitForSelector('a[href="/logout"], nav, [data-theme]', { timeout: 30000 }),
    ]);
}

async function hasValidationIndicator(page, fieldSelector) {
    const input = page.locator(fieldSelector).first();
    if ((await input.count()) === 0) return false;

    // aria-invalid
    const aria = await input.getAttribute('aria-invalid').catch(() => null);
    if (aria === 'true') return true;

    // class is-invalid
    const hasClass = await input
        .evaluate((el) => el.classList.contains('is-invalid'))
        .catch(() => false);
    if (hasClass) return true;

    // sibling feedback elements
    const fb = await page
        .locator(
            `${fieldSelector} + .invalid-feedback, ${fieldSelector} ~ .invalid-feedback, ${fieldSelector} + .form-error, ${fieldSelector} ~ .form-error`
        )
        .first();
    if ((await fb.count()) > 0) {
        const txt = (await fb.textContent()) || '';
        if (txt.trim().length > 0) return true;
    }

    // Generic page error text near the field
    const nearText = await page
        .locator(
            `${fieldSelector} >> xpath=ancestor::*[1]//*[contains(translate(text(), 'ERROR', 'error'), 'error') or contains(translate(text(), 'INVALID', 'invalid'), 'invalid') or contains(text(), 'requer') or contains(text(), 'obligatorio')]`
        )
        .first();
    if ((await nearText.count()) > 0) return true;

    return false;
}

test.describe('Field validation (E2E)', () => {
    test('Item create: nombre should reject numeric-only names', async ({ page }) => {
        await loginAsAdmin(page);
        await page.goto('/items/create');
        await page.waitForSelector('input[name="code"]');

        // valid code, invalid name
        const codigo = 'E2E-' + Date.now();
        await page.fill('input[name="code"]', codigo);
        await page.fill('input[name="name"]', '12345');
        await page.selectOption('select[name="unit"]', 'm²').catch(() => {});
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForSelector(
                'input[name="name"].is-invalid, input[name="name"][aria-invalid="true"]',
                { timeout: 3000 }
            ),
        ]);

        const hasErr = await hasValidationIndicator(page, 'input[name="name"]');
        expect(hasErr, 'Expected validation indicator for numeric-only name').toBeTruthy();
    });

    test('Item create: code should reject spaces or special chars', async ({ page }) => {
        await loginAsAdmin(page);
        await page.goto('/items/create');
        await page.waitForSelector('input[name="code"]');

        await page.fill('input[name="code"]', 'BAD CODE !!');
        await page.fill('input[name="name"]', 'Valid Name');
        await page.selectOption('select[name="unit"]', 'm²').catch(() => {});
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForSelector(
                'input[name="code"].is-invalid, input[name="code"][aria-invalid="true"]',
                { timeout: 3000 }
            ),
        ]);

        const hasErr = await hasValidationIndicator(page, 'input[name="code"]');
        expect(hasErr, 'Expected validation indicator for invalid code').toBeTruthy();
    });

    test('Project create: code should accept alphanumeric only', async ({ page }) => {
        await loginAsAdmin(page);
        await page.goto('/projects/create');
        await page.waitForSelector('input[name="name"]');

        await page.fill('input[name="name"]', 'Project E2E');
        await page.fill('input[name="code"]', 'CODE WITH SPACE');
        await page.click('button[type="submit"]');
        await page.waitForLoadState('domcontentloaded');

        // Should not throw 500
        const title = await page.title();
        expect(title).not.toContain('500');

        // The server sanitizes the code (spaces → dashes) and accepts it.
        // If still on create page, it's due to other required field validations
        // (start_date, end_date, total_budget) — not because the code was rejected.
        // In that case, the code field itself should NOT have an error indicator.
        const onCreatePage = page.url().includes('/projects/create');
        if (onCreatePage) {
            const codeHasErr = await hasValidationIndicator(page, 'input[name="code"]');
            expect(
                codeHasErr,
                'Code field should not have an error — server sanitizes spaces to dashes'
            ).toBeFalsy();
        }
        // If it redirected, the server accepted the sanitized code successfully.
    });
});
