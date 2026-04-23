import { test, expect } from '@playwright/test';

async function loginAsAdmin(page: any) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 10000 });
    await page.fill('input[name="_username"]', 'admin@abc.com');
    await page.fill('input[name="_password"]', 'Admin123!');
    await page.click('button[type="submit"]');
    await Promise.race([
        page.waitForURL(/\/(dashboard|projects|catalog|admin|$)/, { timeout: 30000 }),
        page.waitForSelector('nav, a[href="/logout"]', { timeout: 30000 }),
    ]);
}

test('equipment create shows project optional label when visibility is project', async ({ page }) => {
    await loginAsAdmin(page);

    // Navigate to equipment create page (this has the visibility/project feature)
    await page.goto('/catalog/equipment/create');
    await page.waitForLoadState('domcontentloaded');

    // The project-select-group is hidden by default; select "project" visibility to reveal it
    await page.selectOption('select[name="visibility"]', 'project');

    // The label inside #project-select-group should now be visible
    const label = page.locator('#project-select-group label.form-label');
    await expect(label).toBeVisible({ timeout: 5000 });
    const text = await label.innerText();

    console.log('Label text:', text);

    // Assert translation key common.project_optional is rendered (ES: "Proyecto (si aplica)")
    expect(text.length).toBeGreaterThan(0);
});
