import { test, expect } from '@playwright/test';

const BASE_URL = process.env.BASE_URL || 'http://apache:80';

test.describe('Catalog integration in APU', () => {
    test('login, adds rows and shows catalog selects', async ({ page }) => {
        // Login
        await page.goto(`${BASE_URL}/login`);
        await page.fill('input[name="_username"]', 'admin@demo.com');
        await page.fill('input[name="_password"]', 'password123');
        await Promise.all([
            page.click(
                'button:has-text("Iniciar sesión") , button:has-text("Login") , button[type="submit"]'
            ),
            page.waitForNavigation({ url: '**/' }),
        ]);

        // Navigate to APU create
        await page.goto(`${BASE_URL}/apu/create`);

        // Add equipment row (button may vary)
        await page
            .click('button:has-text("Agregar") , button[onclick*="addEquipmentRow"]', {
                timeout: 5000,
            })
            .catch(() => {});

        // Wait for a select.catalog-select to appear
        const sel = await page.locator('select.catalog-select').first();
        await expect(sel).toBeVisible({ timeout: 5000 });

        // Ensure the select has at least one option
        const options = await sel.locator('option').allTextContents();
        expect(options.length).toBeGreaterThan(0);
    });
});
