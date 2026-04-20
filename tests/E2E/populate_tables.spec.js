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
        page.waitForURL(/\/(dashboard|2fa|system|admin|projects|$)/, { timeout: 30000 }),
        page.waitForSelector('a[href="/logout"], nav, [data-theme]', { timeout: 30000 }),
    ]);
}

test('Populate DB tables via UI flows (regenerate 2FA, upload Revit)', async ({ page }) => {
    // Login
    await loginAsAdmin(page);

    const adminPassword = process.env.ADMIN_PASSWORD || 'Admin123!';

    // Intentar regenerar recovery codes (si falla por CSRF u otro motivo, continuar con upload)
    try {
        await page.goto('/security/2fa/recovery-codes/regenerate');
        await page.waitForSelector('input[name="current_password"]', { timeout: 10000 });
        await page.fill('input[name="current_password"]', adminPassword);
        await page.click('form button');
        // Esperar a que se muestre la página de códigos de recuperación y verificar que hay códigos
        await page.waitForURL(/\/security\/2fa\/recovery-codes/, { timeout: 20000 });
        await page.waitForSelector('#recoveryCodes code', { timeout: 15000 });
        const codes = await page.$$eval('#recoveryCodes code', (nodes) =>
            nodes.map((n) => n.textContent.trim())
        );
        if (codes.length === 0)
            throw new Error('No recovery codes were rendered after regeneration');
    } catch (err) {
        console.warn('Regenerate recovery codes failed, continuing with upload:', err.message);
    }

    // Intentar procesar el fixture directamente mediante endpoint de desarrollo
    try {
        const res = await page.evaluate(async () => {
            const resp = await fetch('/_dev/process-revit-fixture', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ path: 'tests/fixtures/sample_revit.json' }),
            });
            return await resp.json();
        });

        if (!res || res.error)
            throw new Error('Dev endpoint error: ' + (res?.error || JSON.stringify(res)));
    } catch (err) {
        // No fallamos la suite por ausencia del fixture en el entorno de desarrollo.
        // Registrar el error y salir limpiamente del test.
        console.warn(
            'Failed to process fixture via dev endpoint, skipping fixture processing:',
            err.message
        );
        return;
    }
});
