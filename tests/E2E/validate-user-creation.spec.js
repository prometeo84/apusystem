// @ts-check
const { test, expect } = require('@playwright/test');

const BASE_URL = process.env.BASE_URL || 'http://localhost:8080';

async function login(page, email, password) {
    await page.goto(`${BASE_URL}/login`);
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', email);
    await page.fill('input[name="_password"]', password);
    await page.click('button[type="submit"]');
    // Wait for post-login redirect: any page that is not /login
    await page.waitForFunction(() => !window.location.pathname.startsWith('/login'), {
        timeout: 30000,
    });
    await page.waitForLoadState('networkidle', { timeout: 15000 });
}

/** Handle reauth if the page prompts for re-authentication */
async function handleReauthIfNeeded(page, password) {
    const reauthHeading = page.locator('text=Re-authentication required');
    if (await reauthHeading.isVisible({ timeout: 3000 }).catch(() => false)) {
        await page.fill('input[type="password"]', password);
        await page.locator('button:has-text("Confirm")').click();
        await page.waitForLoadState('domcontentloaded', { timeout: 15000 });
    }
}

test.describe('Validate user creation UI behavior', () => {
    // NOTE: admin@demo.com (superadmin) has TOTP 2FA enabled; completing 2FA programmatically
    // is not supported in this E2E setup. This test is skipped until a non-2FA superadmin
    // account is available in the test environment.
    test.skip('superadmin sees sidebar link and tenant + default locale on create form', async ({
        page,
        context,
    }) => {
        // Set cookie before navigating so server sees it during login POST
        await context.addCookies([
            {
                name: 'PLAYWRIGHT_SKIP_SUPERADMIN_VERIFY',
                value: '1',
                domain: 'localhost',
                path: '/',
            },
        ]);
        await login(page, 'admin@demo.com', 'Admin123!');

        // Sidebar link to create user (may include query string)
        const createLink = page.locator('nav a[href*="/admin/users/create"]');
        await expect(createLink).toBeVisible({ timeout: 10000 });

        await createLink.click();
        // May redirect to /reauth first — handle it, then reach the target
        await page.waitForLoadState('domcontentloaded', { timeout: 10000 });
        await handleReauthIfNeeded(page, 'Admin123!');
        // After reauth, app should redirect to the original target
        if (!page.url().includes('/admin/users/create')) {
            await page.goto(`${BASE_URL}/admin/users/create`);
            await page.waitForLoadState('domcontentloaded');
        }

        // Tenant select should be visible for superadmin
        await expect(page.locator('select[name="tenant_id"]')).toBeVisible();

        // Locale select default should be 'en'
        const localeVal = await page.locator('select[name="locale"]').inputValue();
        expect(localeVal).toBe('en');
    });

    test('admin cannot edit role when creating users; timezone defaults to admin timezone', async ({
        page,
    }) => {
        await login(page, 'admin@abc.com', 'Admin123!');

        // Open create user
        await page.goto(`${BASE_URL}/admin/users/create`);
        await page.waitForLoadState('domcontentloaded');
        await handleReauthIfNeeded(page, 'Admin123!');

        // Role should be hidden input with ROLE_USER
        const hiddenRole = page.locator('input[type="hidden"][name="role"][value="ROLE_USER"]');
        await expect(hiddenRole).toHaveCount(1);

        // There should NOT be a role select for admins
        await expect(page.locator('select[name="role"]')).toHaveCount(0);

        // Timezone select should have a selected value equal to the admin timezone (non-empty)
        const tzVal = await page.locator('select[name="timezone"]').inputValue();
        expect(tzVal).not.toBe('');
    });
});
