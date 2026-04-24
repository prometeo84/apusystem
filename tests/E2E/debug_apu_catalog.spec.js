// @ts-check
const { test, expect } = require('@playwright/test');

/**
 * Diagnostic test: verifica que al hacer clic en "+ Add" de cada sección
 * el combobox de Description se llena con opciones del catálogo.
 */

async function login(page) {
    await page.goto('/logout');
    await page.waitForLoadState('domcontentloaded').catch(() => {});
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 10000 });
    await page.fill('input[name="_username"]', 'user@abc.com');
    await page.fill('input[name="_password"]', 'Admin123!');
    await page.click('button[type="submit"]');
    await page.waitForFunction(() => !window.location.pathname.startsWith('/login'), {
        timeout: 15000,
    });
}

test.describe('APU catalog combobox diagnosis', () => {
    test('catalog data is injected in page and combobox loads on +Add click', async ({ page }) => {
        // Capture all console messages and errors
        const consoleLogs = [];
        const consoleErrors = [];
        page.on('console', (msg) => {
            if (msg.type() === 'error') consoleErrors.push(msg.text());
            else consoleLogs.push(`[${msg.type()}] ${msg.text()}`);
        });
        page.on('pageerror', (err) => consoleErrors.push('PAGE ERROR: ' + err.message));

        await login(page);

        // Navigate to APU create for rubro 1
        await page.goto('/apu/create-for-rubro/1');
        await page.waitForLoadState('domcontentloaded');

        // 1. Check catalogData JS variable is present and has items
        // NOTE: 'const' does NOT attach to window, must evaluate in script scope
        const catalogCheck = await page.evaluate(() => {
            // Check via a catalog-select option count after populateSelects would have run
            // We check indirectly by inspecting what options exist after adding a row
            return { ok: true };
        });
        console.log('catalogData check (indirect):', JSON.stringify(catalogCheck));

        // 2. Click toolbar button to show equipment section
        const btnEquipment = page.locator('#btn-add-equipment');
        await expect(btnEquipment).toBeVisible({ timeout: 5000 });
        await btnEquipment.click();

        // Wait for section to be visible
        const sectionEquipment = page.locator('#section-equipment');
        await expect(sectionEquipment).toBeVisible({ timeout: 5000 });

        // 3. Check that a catalog-select was created in the equipment table
        const catalogSelect = page.locator('#equipmentTable tbody select.catalog-select').first();
        await expect(catalogSelect).toBeVisible({ timeout: 5000 });

        // 4. Check how many options the select has (should be > 1 if catalog loaded)
        const optionCount = await catalogSelect.evaluate((el) => el.options.length);
        const optionTexts = await catalogSelect.evaluate((el) =>
            Array.from(el.options).map((o) => ({ value: o.value, text: o.textContent }))
        );
        console.log('Equipment select option count:', optionCount);
        console.log('Equipment select options:', JSON.stringify(optionTexts));

        // 5. Click "+ Add" inside equipment section header (adds a second row)
        const addRowBtn = page.locator('#section-equipment .card-header button.btn-light').first();
        if (await addRowBtn.isVisible()) {
            await addRowBtn.click();
            const rows = page.locator('#equipmentTable tbody tr');
            const rowCount = await rows.count();
            console.log('Row count after second +Add:', rowCount);
        }

        // 6. Check JS errors
        console.log('JS errors:', JSON.stringify(consoleErrors));
        console.log('Console logs:', consoleLogs.slice(0, 20).join('\n'));

        // Assertions
        expect(optionCount).toBeGreaterThan(1); // at least placeholder + 1 item
        expect(consoleErrors).toHaveLength(0);
    });

    test('all 4 sections show catalog combobox options', async ({ page }) => {
        const errors = [];
        page.on('pageerror', (err) => errors.push(err.message));

        await login(page);
        await page.goto('/apu/create-for-rubro/1');
        await page.waitForLoadState('domcontentloaded');

        const sections = [
            { btn: '#btn-add-equipment', table: '#equipmentTable', name: 'equipment' },
            { btn: '#btn-add-labor', table: '#laborTable', name: 'labor' },
            { btn: '#btn-add-materials', table: '#materialTable', name: 'materials' },
            { btn: '#btn-add-transport', table: '#transportTable', name: 'transport' },
        ];

        for (const s of sections) {
            await page.locator(s.btn).click();
            await page.waitForSelector(`${s.table} tbody select.catalog-select`, { timeout: 5000 });

            const sel = page.locator(`${s.table} tbody select.catalog-select`).first();
            const count = await sel.evaluate((el) => el.options.length);
            const texts = await sel.evaluate((el) =>
                Array.from(el.options)
                    .map((o) => o.textContent.trim())
                    .join(' | ')
            );
            console.log(`[${s.name}] options: ${count} → ${texts.substring(0, 120)}`);

            // Should have more than just the placeholder
            expect(count, `${s.name} select should have options`).toBeGreaterThan(1);
        }

        expect(errors).toHaveLength(0);
    });
});
