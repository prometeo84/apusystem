// @ts-check
const { test, expect } = require('@playwright/test');

async function loginAsAdmin(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 10000 });
    await page.fill('input[name="_username"]', 'admin@demo.com');
    const adminPassword = process.env.ADMIN_PASSWORD || 'Admin123!';
    await page.fill('input[name="_password"]', adminPassword);
    if (process.env.DIAG_INTERCEPT) {
        const box = await page.locator('button[type="submit"]').boundingBox();
        if (box) {
            const samples = await page.evaluate(
                ({ x, y, w, h }) => {
                    const out = [];
                    const cols = 5,
                        rows = 3;
                    for (let i = 0; i < cols; i++) {
                        for (let j = 0; j < rows; j++) {
                            const px = Math.round(x + (i + 0.5) * (w / cols));
                            const py = Math.round(y + (j + 0.5) * (h / rows));
                            const els = document
                                .elementsFromPoint(px, py)
                                .slice(0, 6)
                                .map((e) => {
                                    const cs = window.getComputedStyle(e);
                                    const r = e.getBoundingClientRect();
                                    return {
                                        tag: e.tagName,
                                        id: e.id || null,
                                        classes: e.className || null,
                                        pointerEvents: cs.pointerEvents,
                                        zIndex: cs.zIndex || null,
                                        rect: { x: r.x, y: r.y, width: r.width, height: r.height },
                                    };
                                });
                            out.push({ px, py, stack: els });
                        }
                    }
                    return out;
                },
                { x: box.x, y: box.y, w: box.width, h: box.height }
            );
            await require('fs')
                .promises.writeFile('/tmp/diag_points.json', JSON.stringify(samples, null, 2))
                .catch(() => {});
            console.log('WROTE /tmp/diag_points.json');
        }
    }
    if (process.env.DIAG_OVERLAP) {
        const box = await page.locator('button[type="submit"]').boundingBox();
        if (box) {
            const overlap = await page.evaluate(
                ({ x, y, w, h }) => {
                    function rectInter(a, b) {
                        const x1 = Math.max(a.left, b.left);
                        const y1 = Math.max(a.top, b.top);
                        const x2 = Math.min(a.right, b.right);
                        const y2 = Math.min(a.bottom, b.bottom);
                        return Math.max(0, x2 - x1) * Math.max(0, y2 - y1);
                    }
                    const btnRect = { left: x, top: y, right: x + w, bottom: y + h };
                    const found = [];
                    document.querySelectorAll('*').forEach((e) => {
                        if (!(e instanceof Element)) return;
                        const r = e.getBoundingClientRect();
                        if (r.width === 0 || r.height === 0) return;
                        const area = rectInter(btnRect, r);
                        if (
                            area > 0 &&
                            !e.matches('button[type="submit"], button[form="apuForm"]')
                        ) {
                            const cs = window.getComputedStyle(e);
                            found.push({
                                tag: e.tagName,
                                id: e.id || null,
                                classes: e.className || null,
                                pointerEvents: cs.pointerEvents,
                                zIndex: cs.zIndex || null,
                                rect: { x: r.x, y: r.y, w: r.width, h: r.height },
                                area,
                            });
                        }
                    });
                    return found.sort((a, b) => b.area - a.area);
                },
                { x: box.x, y: box.y, w: box.width, h: box.height }
            );
            await require('fs')
                .promises.writeFile('/tmp/overlap_diag.json', JSON.stringify(overlap, null, 2))
                .catch(() => {});
            console.log('WROTE /tmp/overlap_diag.json');
        }
    }
    if (process.env.DIAG_STACK) {
        const stack = await page.evaluate(() => {
            const out = [];
            document.querySelectorAll('*').forEach((e) => {
                const cs = window.getComputedStyle(e);
                if (
                    (cs.transform && cs.transform !== 'none') ||
                    (cs.willChange && cs.willChange !== 'auto') ||
                    (cs.zIndex && cs.zIndex !== 'auto')
                ) {
                    const r = e.getBoundingClientRect();
                    out.push({
                        tag: e.tagName,
                        id: e.id || null,
                        classes: e.className || null,
                        transform: cs.transform,
                        willChange: cs.willChange,
                        zIndex: cs.zIndex || null,
                        rect: { x: r.x, y: r.y, w: r.width, h: r.height },
                    });
                }
            });
            return out;
        });
        await require('fs')
            .promises.writeFile('/tmp/stacking_diag.json', JSON.stringify(stack, null, 2))
            .catch(() => {});
        console.log('WROTE /tmp/stacking_diag.json');
    }
    if (process.env.DIAG_FINAL) {
        const diag = await page.evaluate(() => {
            const out = {};
            const btn = document.querySelector('button[type="submit"]');
            if (btn) {
                const r = btn.getBoundingClientRect();
                const cs = window.getComputedStyle(btn);
                out.button = {
                    rect: { x: r.x, y: r.y, w: r.width, h: r.height },
                    pointerEvents: cs.pointerEvents,
                    zIndex: cs.zIndex,
                    classes: btn.className,
                };
                const samples = [];
                const cols = 3,
                    rows = 3;
                for (let i = 0; i < cols; i++) {
                    for (let j = 0; j < rows; j++) {
                        const px = Math.round(r.left + (i + 0.5) * (r.width / cols));
                        const py = Math.round(r.top + (j + 0.5) * (r.height / rows));
                        const stack = document
                            .elementsFromPoint(px, py)
                            .slice(0, 6)
                            .map((e) => ({
                                tag: e.tagName,
                                classes: e.className,
                                pointer: window.getComputedStyle(e).pointerEvents,
                            }));
                        samples.push({ px, py, stack });
                    }
                }
                out.samples = samples;
            }
            return out;
        });
        await require('fs')
            .promises.writeFile('/tmp/final_diag.json', JSON.stringify(diag, null, 2))
            .catch(() => {});
        console.log('WROTE /tmp/final_diag.json');
    }
    await page.click('button[type="submit"]');
    await Promise.race([
        page.waitForURL(/\/(dashboard|2fa|system|admin|projects|$)/, { timeout: 30000 }),
        page.waitForSelector('a[href="/logout"], nav, [data-theme]', { timeout: 30000 }),
    ]);
}

test('E2E: crear proyecto, plantilla, rubro y APU por UI', async ({ page }) => {
    await loginAsAdmin(page);

    // 1) Crear rubro (item)
    await page.goto('/items/create');
    await page.waitForSelector('input[name="codigo"]');
    const codigo = 'E2E-' + Date.now();
    const nombre = 'Rubro E2E ' + Math.floor(Math.random() * 10000);
    await page.fill('input[name="codigo"]', codigo);
    await page.fill('input[name="nombre"]', nombre);
    await page.selectOption('select[name="unidad"]', 'm²');
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/items/, { timeout: 10000 });

    // Confirmar que el rubro creado aparece en el listado y obtener su id
    await page.goto('/items');
    await page.waitForSelector('table');
    const itemRow = await page.locator(`table >> text=${codigo}`).first();
    await expect(itemRow).toBeVisible({ timeout: 10000 });
    // extraer id desde el enlace de editar si existe
    const editLink = await itemRow
        .locator('xpath=../..')
        .locator('a[href*="/items/" i]')
        .filter({ hasText: 'Editar' })
        .first()
        .getAttribute('href')
        .catch(() => null);
    let itemId = null;
    if (editLink) {
        const m = editLink.match(/\/items\/(\d+)\/edit/);
        if (m) itemId = m[1];
    }
    // fallback: buscar cualquier enlace dentro de la fila con /items/{id}
    if (!itemId) {
        const anyLink = await itemRow
            .locator('a[href*="/items/"]')
            .first()
            .getAttribute('href')
            .catch(() => null);
        if (anyLink) {
            const m2 = anyLink.match(/\/items\/(\d+)/);
            if (m2) itemId = m2[1];
        }
    }

    // 2) Crear proyecto
    await page.goto('/projects/create');
    await page.waitForSelector('input[name="nombre"]');
    const projectName = 'PTO E2E ' + Date.now();
    const projectCode = 'P-' + Math.floor(Math.random() * 10000);
    await page.fill('input[name="nombre"]', projectName);
    await page.fill('input[name="codigo"]', projectCode);
    await page.click('button[type="submit"]');
    // After create, redirect to /projects/{id}
    await page.waitForURL(/\/projects\/\d+/, { timeout: 15000 });
    const projectUrl = page.url();
    const projectIdMatch = projectUrl.match(/\/projects\/(\d+)/);
    expect(projectIdMatch).not.toBeNull();
    const projectId = projectIdMatch[1];

    // 3) Crear plantilla
    await page.goto(`/projects/${projectId}/templates/create`);
    await page.waitForSelector('input[name="nombre"]');
    const plantillaName = 'Plantilla E2E ' + Date.now();
    await page.fill('input[name="nombre"]', plantillaName);
    await page.click('button[type="submit"]');
    await page.waitForURL(new RegExp(`/projects/${projectId}/templates/\\d+`), { timeout: 15000 });
    const tplUrl = page.url();
    const tplMatch = tplUrl.match(new RegExp(`/projects/${projectId}/templates/(\\d+)`));
    expect(tplMatch).not.toBeNull();
    const plantillaId = tplMatch[1];

    // 4) Agregar rubro a plantilla
    // buscar opción que contenga el código del rubro creado
    await page.waitForLoadState('networkidle');
    const optionLocator = page
        .locator('select[name="rubro_id"] option')
        .filter({ hasText: codigo })
        .first();
    const exists = await optionLocator.count();
    if (exists) {
        const val = await optionLocator.getAttribute('value');
        await page.selectOption('select[name="rubro_id"]', val);
    } else {
        // guardar snapshot para diagnóstico y fallar con mensaje claro
        const html = await page.content();
        await require('fs')
            .promises.writeFile('/tmp/template_show_snapshot.html', html)
            .catch(() => {});
        throw new Error(
            'No available rubro option found in plantilla show page; saved /tmp/template_show_snapshot.html'
        );
    }
    await page.fill('input[name="cantidad"]', '2.00');
    await page.click('form[action*="add-item"] button[type="submit"]');
    await page.waitForURL(new RegExp(`/projects/${projectId}/templates/${plantillaId}`), {
        timeout: 10000,
    });

    // 5) Crear APU para el primer plantillaRubro (buscar enlace a /apu/create-for-rubro)
    const createApuLink = await page.locator('a[href^="/apu/create-for-rubro/"]').first();
    await expect(createApuLink).toBeVisible({ timeout: 5000 });
    const href = await createApuLink.getAttribute('href');
    await page.goto(href);
    await page.waitForSelector('input[name="description"]', { timeout: 5000 });

    // Llenar formulario APU mínimo
    await page.fill('input[name="description"]', 'APU E2E ' + Date.now());
    await page.selectOption('select[name="unit"]', 'm²');
    await page.fill('input[name="khu"]', '1');
    await page.fill('input[name="rendimiento_uh"]', '1');
    // Agregar material simple: usar botón que invoca addMaterialRow(); el template has JS which runs in browser
    await page.click('button[onclick*="addMaterialRow"]');
    // Fill last material row inputs
    await page.fill(
        '#materialTable tbody tr:last-of-type input[name^="materials"][name$="[descripcion]"]',
        'Cemento'
    );
    await page.fill(
        '#materialTable tbody tr:last-of-type input[name^="materials"][name$="[unidad]"]',
        'kg'
    );
    await page.fill(
        '#materialTable tbody tr:last-of-type input[name^="materials"][name$="[cantidad]"]',
        '500'
    );
    await page.fill(
        '#materialTable tbody tr:last-of-type input[name^="materials"][name$="[precio_unitario]"]',
        '0.5'
    );

    // Click by coordinates on the floating submit button to avoid locator interception
    const rect = await page.evaluate(() => {
        const sel = document.querySelector(
            '.apu-submit-floating button[form="apuForm"], .apu-submit-floating button[type="submit"]'
        );
        if (!sel) return null;
        const r = sel.getBoundingClientRect();
        return { x: r.left, y: r.top, w: r.width, h: r.height };
    });
    if (!rect) throw new Error('Floating submit button not found');
    await page.mouse.click(Math.round(rect.x + rect.w / 2), Math.round(rect.y + rect.h / 2));
    // Redirect back to plantilla show (click the floating submit button)
    await page.waitForURL(new RegExp(`/projects/${projectId}/templates/${plantillaId}`), {
        timeout: 15000,
    });

    // If we reached here without exceptions, expect DB has relevant rows (counts will be checked outside test)
});
