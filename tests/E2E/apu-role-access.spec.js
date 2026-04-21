// @ts-check
const { test, expect } = require('@playwright/test');

/**
 * Verifica accesos y visibilidad del flujo de creación de APU según rol
 */

async function loginAsAdmin(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', 'admin@abc.com');
    await page.fill('input[name="_password"]', 'Admin123!');
    await page.click('button[type="submit"]');
    await Promise.race([
        page.waitForURL(/\/(dashboard|2fa|$)/, { timeout: 30000 }),
        page.waitForSelector('a[href="/logout"], nav, [data-theme]', { timeout: 30000 }),
    ]);
}

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

test.describe('APU role access', () => {
    test('Admin should receive 403 when fetching /apu/create', async ({ page }) => {
        await loginAsAdmin(page);
        const resp = await page.request.get('/apu/create');
        expect(resp.status()).toBe(403);
        const text = await resp.text();
        // El mensaje lanzado desde el controller contiene 'Admins cannot create APUs'
        expect(text).toContain('Admins cannot create APUs');
    });

    test('User can open create form but add-buttons are not visible', async ({ page }) => {
        await loginAsUser(page);
        await page.goto('/apu/create');
        await page.waitForLoadState('networkidle');

        // Page should not redirect to login or show 403
        expect(page.url()).not.toContain('/login');

        // Ensure main form is present
        await expect(page.locator('form#apuForm')).toBeVisible({ timeout: 5000 });

        // Buttons that add rows must NOT be visible for plain users
        const equipBtn = page.locator('button[onclick*="addEquipmentRow"]');
        const laborBtn = page.locator('button[onclick*="addLaborRow"]');
        const materialBtn = page.locator('button[onclick*="addMaterialRow"]');
        const transportBtn = page.locator('button[onclick*="addTransportRow"]');

        await expect(equipBtn).toHaveCount(0);
        await expect(laborBtn).toHaveCount(0);
        await expect(materialBtn).toHaveCount(0);
        await expect(transportBtn).toHaveCount(0);
    });
});
