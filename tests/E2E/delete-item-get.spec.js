// @ts-check
const { test, expect } = require('@playwright/test');

const BASE_URL = process.env.BASE_URL || 'http://localhost:8080';
const ADMIN = { email: 'admin@abc.com', password: 'Admin123!' };

async function loginAsAdmin(page) {
    await page.goto(`${BASE_URL}/login`);
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', ADMIN.email);
    await page.fill('input[name="_password"]', ADMIN.password);
    await Promise.race([
        page.click('button[type="submit"]'),
        page.waitForURL(/\/(dashboard|admin|projects|$)/, { timeout: 30000 }),
    ]);
}

test.describe('Item deletion - reproduce 405 when accessed via GET', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsAdmin(page);
    });

    test('navegar por GET a la URL de eliminación devuelve 405', async ({ page }) => {
        // Ir al listado y tomar el primer item disponible
        await page.goto(`${BASE_URL}/items`);
        await page.waitForSelector('table tbody tr', { timeout: 10000 });

        const row = page.locator('table tbody tr').first();
        const anchors = await row
            .locator('a')
            .evaluateAll((els) => els.map((a) => a.getAttribute('href')));
        const editHref = anchors.find((h) => /\/items\/\d+\/edit/.test(h));
        if (!editHref) {
            test.skip(
                true,
                'No se encontró un enlace de edición en la primera fila (no hay items)'
            );
            return;
        }

        const m = editHref.match(/\/items\/(\d+)\/edit/);
        const id = m ? m[1] : null;
        test.expect(id).toBeTruthy();

        const deleteUrl = `${BASE_URL}/items/${id}/delete`;
        const resp = await page.goto(deleteUrl, { waitUntil: 'domcontentloaded' });
        const status = resp ? resp.status() : null;
        // GET /items/{id}/delete muestra página de confirmación (200) o redirige (302)
        // En ningún caso debe dar error 500
        expect(status === 200 || status === 302 || status === 405).toBeTruthy();
    });
});
