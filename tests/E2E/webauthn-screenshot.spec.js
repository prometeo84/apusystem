// @ts-check
const { test, expect } = require('@playwright/test');

async function loginAsAdmin(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', 'admin@demo.com');
    const adminPassword = process.env.ADMIN_PASSWORD || 'Admin123!';
    await page.fill('input[name="_password"]', adminPassword);
    await page.click('button[type="submit"]');
    await Promise.race([
        page.waitForURL(/\/(dashboard|2fa|system|admin|projects|$)/, { timeout: 30000 }),
        page.waitForSelector('a[href="/logout"], nav, [data-theme]', { timeout: 30000 }),
    ]);
}

test('Captura pantalla WebAuthn (credenciales)', async ({ page }) => {
    await loginAsAdmin(page);
    await page.goto('/webauthn/credentials');
    await page.waitForLoadState('networkidle');

    // Esperar a que el listado de credenciales o el formulario esté visible
    await Promise.race([
        page
            .waitForSelector('#webauthn-credentials, .webauthn-list, form#webauthn-register', {
                timeout: 8000,
            })
            .catch(() => null),
        page
            .waitForSelector(
                'button:has-text("Register"), button:has-text("Registrar"), button:has-text("Add key")',
                { timeout: 8000 }
            )
            .catch(() => null),
    ]);

    // Tomar captura de pantalla completa
    await page.screenshot({ path: 'test-results/webauthn-credentials.png', fullPage: true });
});
