// @ts-check
const { test, expect } = require('@playwright/test');

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

test('edit APU - combos de catálogo cargan en todas las secciones', async ({ page }) => {
    await login(page);

    // Ir al listado de APU
    await page.goto('/apu/');
    await page.waitForLoadState('networkidle');

    // Obtener el primer APU con botón de editar
    const editLinks = page.locator('a[href*="/apu/"][href*="/edit"]');
    const count = await editLinks.count();
    if (count === 0) {
        console.log('No hay APU con botón de editar visibles para este usuario.');
        return;
    }
    const editHref = await editLinks.first().getAttribute('href');
    await page.goto(editHref);
    await page.waitForLoadState('networkidle');

    // Verificar que la página carga sin error
    await expect(page.locator('h1')).toBeVisible();

    // Verificar selects existentes (filas de DB ya cargadas)
    const existingSelects = page.locator('select.catalog-select');
    const existingCount = await existingSelects.count();
    console.log(`[Existing rows] catalog selects found: ${existingCount}`);

    // Hacer click en cada botón Add y verificar el select del catálogo
    for (const [onclickFn, selectPrefix, sectionName] of [
        ['addEquipmentRow()', 'equipment[', 'Equipment'],
        ['addLaborRow()', 'labor[', 'Labor'],
        ['addMaterialRow()', 'materials[', 'Materials'],
        ['addTransportRow()', 'transport[', 'Transport'],
    ]) {
        const addBtn = page.locator(`button[onclick="${onclickFn}"]`);
        await expect(addBtn).toBeVisible({ timeout: 5000 });
        await addBtn.click();
        await page.waitForTimeout(300);

        const newSelect = page.locator(`select[name^="${selectPrefix}"]`).last();
        await expect(newSelect).toBeVisible();
        const opts = await newSelect.locator('option').count();
        console.log(`[${sectionName}] opciones en nuevo select: ${opts}`);
        expect(opts).toBeGreaterThan(1);
    }

    console.log('✅ Todos los combos del catálogo cargan correctamente en la pantalla de edición');
});
