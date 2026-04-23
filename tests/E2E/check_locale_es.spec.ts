import { test, expect } from '@playwright/test';

const BASE_URL = process.env.BASE_URL || 'http://localhost:8080';

test('set locale to es and check login button text', async ({ page }) => {
    await page.goto(`${BASE_URL}/set-locale/es`);
    await page.goto(`${BASE_URL}/login`);

    // Check for Spanish button text
    const btn = page.locator('button:has-text("Iniciar sesión")');
    const exists = await btn.count();
    console.log('Iniciar sesión button count:', exists);
    expect(exists).toBeGreaterThan(0);
});
