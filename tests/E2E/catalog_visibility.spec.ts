import { test, expect } from '@playwright/test';

const BASE_URL = process.env.BASE_URL || 'http://apache:80';

async function login(page: any) {
    await page.goto(`${BASE_URL}/login`);
    await page.fill('input[name="_username"]', 'admin@demo.com');
    await page.fill('input[name="_password"]', 'password123');
    await Promise.all([
        page.click('button[type="submit"]'),
        page.waitForNavigation({ url: '**/' }),
    ]);
}

test.describe('Catalog Visibility — Equipment & Labor', () => {
    test('equipment create shows visibility select', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/catalog/equipment/create`);

        const visSelect = page.locator('select[name="visibility"]');
        await expect(visSelect).toBeVisible({ timeout: 5000 });

        const options = await visSelect.locator('option').allTextContents();
        expect(options.length).toBeGreaterThanOrEqual(2);
    });

    test('equipment create shows project select when visibility=project', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/catalog/equipment/create`);

        const projectGroup = page.locator('#project-select-group');
        await expect(projectGroup).toBeHidden({ timeout: 5000 });

        await page.selectOption('select[name="visibility"]', 'project');
        await expect(projectGroup).toBeVisible({ timeout: 3000 });
    });

    test('equipment create hides project select when visibility=tenant', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/catalog/equipment/create`);

        // Switch to project then back to tenant
        await page.selectOption('select[name="visibility"]', 'project');
        await page.selectOption('select[name="visibility"]', 'tenant');
        const projectGroup = page.locator('#project-select-group');
        await expect(projectGroup).toBeHidden({ timeout: 3000 });
    });

    test('labor create shows visibility select', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/catalog/labor/create`);

        const visSelect = page.locator('select[name="visibility"]');
        await expect(visSelect).toBeVisible({ timeout: 5000 });

        const options = await visSelect.locator('option').allTextContents();
        expect(options.length).toBeGreaterThanOrEqual(2);
    });

    test('labor create shows project select when visibility=project', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/catalog/labor/create`);

        const projectGroup = page.locator('#project-select-group');
        await expect(projectGroup).toBeHidden({ timeout: 5000 });

        await page.selectOption('select[name="visibility"]', 'project');
        await expect(projectGroup).toBeVisible({ timeout: 3000 });
    });
});
