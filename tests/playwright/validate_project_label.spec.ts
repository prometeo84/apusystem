import { test, expect } from '@playwright/test';

const BASE_URL = process.env.BASE_URL || 'http://localhost:8080';

test('material edit shows project optional label in Spanish', async ({ page }) => {
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

    // Go to the specific material edit page
    await page.goto(`${BASE_URL}/catalog/material/6/edit`);

    // Wait for the project label to be visible and get its text
    const label = page.locator('#project-select-group label.form-label');
    await expect(label).toBeVisible({ timeout: 5000 });
    const text = await label.innerText();

    console.log('Label text:', text);

    // Assert the Spanish translation is present
    expect(text).toContain('Proyecto');
    expect(text).toContain('si aplica');
});
