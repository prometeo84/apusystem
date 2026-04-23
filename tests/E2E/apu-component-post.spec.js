// @ts-check
const { test, expect } = require('@playwright/test');

async function loginAsUser(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', 'user@abc.com');
    await page.fill('input[name="_password"]', 'Admin123!');
    await page.click('button[type="submit"]');
    await Promise.race([
        page.waitForURL(/\/(dashboard|2fa|$)/, { timeout: 30000 }),
        page.waitForSelector('a[href="/logout"], nav, [data-theme]', { timeout: 30000 }),
    ]);
}

test('User POST with equipment should not persist components', async ({ page }) => {
    await loginAsUser(page);

    // Get current APUs count so we can detect the newly created row later
    await page.goto('/apu/');
    // Use main content table, not the hidden Symfony toolbar table
    await page
        .waitForSelector('main table, .table-responsive table, #apu-list, [data-entity="apu"]', {
            timeout: 15000,
        })
        .catch(() => {});
    const initialCount = await page
        .locator('main table tbody tr, .table tbody tr')
        .first()
        .locator('xpath=ancestor::tbody')
        .locator('tr')
        .count()
        .catch(() => 0);

    // Open create page to obtain CSRF token and session cookies
    await page.goto('/apu/create');
    await page.waitForSelector('form#apuForm');
    const token = await page.locator('input[name="_token"]').inputValue();

    const unique = `E2E-POST-EQUIP-${Date.now()}`;

    // Fill visible form fields normally (to pass client-side validation)
    await page.fill('input[name="description"]', unique);
    try {
        await page.selectOption('select[name="unit"]', { label: 'm²' });
    } catch (e) {}
    await page.fill('input[name="khu"]', '1');
    await page.fill('input[name="rendimiento_uh"]', '1');
    await page.fill('input[name="utilidad_pct"]', '5');
    await page.fill('input[name="precio_ofertado"]', '10');

    // Inject hidden equipment inputs (simulate a malicious client adding equipment)
    const postData = {
        'equipment[0][description]': 'InjectedEquip',
        'equipment[0][numero]': '2',
        'equipment[0][tarifa]': '123.45',
    };

    await page.evaluate((data) => {
        const form = document.querySelector('form#apuForm');
        for (const [k, v] of Object.entries(data)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = k;
            input.value = v;
            form.appendChild(input);
        }
    }, postData);

    // Ensure select values are set to satisfy client-side validation
    try {
        await page.selectOption('select[name="unit"]', { label: 'm²' });
    } catch (e) {
        // ignore if select not found
    }

    // Submit (force to avoid pointer interception issues on some device profiles)
    await page.locator('button[type="submit"]').click({ force: true });
    // Allow server to process briefly
    await page.waitForTimeout(1500);

    // If still on create page, capture body for debugging (likely validation errors)
    const currentUrl = page.url();
    if (currentUrl.includes('/apu/create')) {
        const bodyText = await page.locator('body').innerText();
        throw new Error(
            `Submit appears to have failed (still on create). Page body:\n${bodyText.slice(0, 4000)}`
        );
    }

    // Navigate to index and verify new row count increased
    await page.goto('/apu/');
    await page
        .waitForSelector('main table, .table-responsive table', { timeout: 10000 })
        .catch(() => {});
    await page.waitForLoadState('networkidle');

    const finalCount = await page
        .locator('main table tbody tr, .table tbody tr')
        .count()
        .catch(() => 0);
    if (finalCount !== initialCount + 1) {
        const tableText = await page.locator('table').allInnerTexts();
        throw new Error(
            `Row count did not increase as expected. before=${initialCount} after=${finalCount} table=${JSON.stringify(tableText).slice(0, 3000)}`
        );
    }

    // Assume newest row is first in table body
    const newRow = page.locator('main table tbody tr, .table tbody tr').first();
    await expect(newRow).toBeVisible({ timeout: 5000 });
    const editLink = newRow.locator('xpath=.//a[contains(@href, "/edit")]').first();
    const href = await editLink.getAttribute('href');
    expect(href).toBeTruthy();

    // Go to edit page and verify there are no equipment rows
    await page.goto(href);
    await page.waitForLoadState('networkidle');

    // On edit, equipment table id is #equipmentTable — should have zero rows for user-created APU
    const equipmentRows = page.locator('#equipmentTable tbody tr');
    await expect(equipmentRows).toHaveCount(0);
});
