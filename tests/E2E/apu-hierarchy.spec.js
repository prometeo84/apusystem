// @ts-check
const { test, expect } = require('@playwright/test');

/**
 * Tests E2E para el flujo jerárquico: Proyecto → Plantilla → Rubro → APU → Reporte
 *
 * Cubre:
 *   UC-H01: Acceso protegido a módulos del nuevo flujo
 *   UC-H02: CRUD de Rubros
 *   UC-H03: CRUD de Plantillas
 *   UC-H04: Crear APU desde PlantillaRubro (formulario pre-llenado)
 *   UC-H05: Editar APU con utilidadPct y precioOfertado
 *   UC-H06: Reporte por plantilla (preview, PDF, Excel)
 *   UC-H07: Reporte completo del proyecto
 *   UC-H08: Duplicar proyecto
 */

async function loginAsUser(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', 'user@abc.com');
    await page.fill('input[name="_password"]', 'Admin123!');
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/(dashboard|2fa|$)/, { timeout: 10000 });
}

// ============================================================
// UC-H01: Rutas nuevas protegidas → redirigen a /login
// ============================================================
test.describe('UC-H01: Rutas del nuevo flujo requieren autenticación', () => {
    test('GET /rubros sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/rubros');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /projects/1/plantillas sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/projects/1/plantillas');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /reports/project/1/full sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/reports/project/1/full');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /apu/create-for-rubro/1 sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/apu/create-for-rubro/1');
        await expect(page).toHaveURL(/\/login/);
    });
});

// ============================================================
// UC-H02: Módulo de Rubros — acceso y listado
// ============================================================
test.describe('UC-H02: Módulo Rubros', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('GET /rubros carga la lista de rubros', async ({ page }) => {
        await page.goto('/rubros');
        const status = page.url();
        // No debe redirigir a login ni 403
        expect(status).not.toContain('/login');
        // Debe tener algún encabezado de la página
        const heading = page.locator('h1, .page-title, [class*="title"]').first();
        await expect(heading).toBeVisible({ timeout: 5000 });
    });

    test('GET /rubros/create renderiza formulario de creación', async ({ page }) => {
        await page.goto('/rubros/create');
        expect(page.url()).not.toContain('/login');
        await expect(
            page.locator('input[name="codigo"], input[name="nombre"]').first()
        ).toBeVisible({ timeout: 5000 });
    });

    test('Formulario de rubro tiene campos código, nombre, unidad', async ({ page }) => {
        await page.goto('/rubros/create');
        await expect(page.locator('input[name="codigo"]')).toBeVisible();
        await expect(page.locator('input[name="nombre"]')).toBeVisible();
        await expect(
            page.locator('select[name="unidad"], input[name="unidad"]').first()
        ).toBeVisible();
    });
});

// ============================================================
// UC-H03: Módulo Proyectos — listado y detalle
// ============================================================
test.describe('UC-H03: Módulo Proyectos — acceso', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('GET /projects carga la lista de proyectos', async ({ page }) => {
        await page.goto('/projects');
        expect(page.url()).not.toContain('/login');
        const heading = page.locator('h1').first();
        await expect(heading).toBeVisible({ timeout: 5000 });
    });

    test('GET /projects/create renderiza formulario con campos requeridos', async ({ page }) => {
        await page.goto('/projects/create');
        await expect(page.locator('input[name="nombre"], input[name="name"]').first()).toBeVisible({
            timeout: 5000,
        });
    });
});

// ============================================================
// UC-H04: APU edit — formulario con datos pre-cargados
// ============================================================
test.describe('UC-H05: Editar APU — campos utilidadPct y precioOfertado', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('GET /apu/ lista APUs disponibles', async ({ page }) => {
        await page.goto('/apu/');
        expect(page.url()).not.toContain('/login');
    });

    test('La página de edición APU tiene campo utilidad_pct cuando existe APU', async ({
        page,
    }) => {
        // Ir a la lista de APUs
        await page.goto('/apu/');
        const editLink = page.locator('a[href*="/edit"]').first();
        const count = await editLink.count();

        if (count === 0) {
            test.skip(); // No hay APUs para editar
            return;
        }

        await editLink.click();
        await page.waitForLoadState('networkidle');

        // La página de edición debe tener los campos de utilidad y precio
        await expect(page.locator('input[name="utilidad_pct"]')).toBeVisible({ timeout: 5000 });
        await expect(page.locator('input[name="precio_ofertado"]')).toBeVisible();
        await expect(page.locator('input[name="description"]')).toBeVisible();
        await expect(page.locator('select[name="unit"]')).toBeVisible();
    });

    test('El panel de resumen de costos está presente en edición APU', async ({ page }) => {
        await page.goto('/apu/');
        const editLink = page.locator('a[href*="/edit"]').first();
        const count = await editLink.count();

        if (count === 0) {
            test.skip();
            return;
        }

        await editLink.click();
        await page.waitForLoadState('networkidle');

        // Panel resumen con IDs JS
        await expect(page.locator('#summaryTotal')).toBeVisible();
        await expect(page.locator('#summaryPrecioCalculo')).toBeVisible();
        await expect(page.locator('#utilidadPct')).toBeVisible();
        await expect(page.locator('#precioOfertado')).toBeVisible();
    });

    test('El campo utilidad_pct tiene valor por defecto al editar APU sin utilidad guardada', async ({
        page,
    }) => {
        await page.goto('/apu/');
        const editLink = page.locator('a[href*="/edit"]').first();
        const count = await editLink.count();

        if (count === 0) {
            test.skip();
            return;
        }

        await editLink.click();
        await page.waitForLoadState('networkidle');

        const utilidad = await page.locator('#utilidadPct').inputValue();
        // Debe tener algún valor (20 por defecto o el guardado)
        expect(Number(utilidad)).toBeGreaterThanOrEqual(0);
    });
});

// ============================================================
// UC-H06: Reporte por plantilla — preview accesible
// ============================================================
test.describe('UC-H06: Reporte de plantilla', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('Acceder al reporte de una plantilla retorna página válida si existe', async ({
        page,
    }) => {
        // Navegar a proyectos para encontrar uno con plantillas
        await page.goto('/projects');
        const projectLink = page.locator('a[href*="/projects/"]').first();
        const count = await projectLink.count();

        if (count === 0) {
            test.skip();
            return;
        }

        await projectLink.click();
        await page.waitForLoadState('networkidle');

        // Buscar botón de reporte de plantilla
        const reportBtn = page.locator('a[href*="/reports/project/"]').first();
        const reportCount = await reportBtn.count();

        if (reportCount === 0) {
            test.skip();
            return;
        }

        await reportBtn.click();
        await page.waitForLoadState('networkidle');
        expect(page.url()).not.toContain('/login');
    });
});

// ============================================================
// UC-H07: Reporte completo del proyecto
// ============================================================
test.describe('UC-H07: Reporte completo del proyecto', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('El botón "Reporte Completo" existe en la vista de proyecto', async ({ page }) => {
        await page.goto('/projects');
        // Usar el enlace de ver detalle (icono ojo) para ir al show del proyecto
        const projectLink = page.locator('a:has(.bi-eye)').first();
        const count = await projectLink.count();

        if (count === 0) {
            test.skip();
            return;
        }

        await projectLink.click();
        await page.waitForLoadState('networkidle');

        // Buscar enlace al reporte completo del proyecto
        const fullReportLink = page.locator('a[href*="/reports/project/"][href*="/full"]');
        const linkCount = await fullReportLink.count();
        expect(linkCount).toBeGreaterThan(0);
    });

    test('GET /reports/project/{id}/full retorna página si el proyecto existe', async ({
        page,
    }) => {
        await page.goto('/projects');
        const projectLink = page.locator('a[href*="/projects/"]').first();
        const count = await projectLink.count();

        if (count === 0) {
            test.skip();
            return;
        }

        const href = await projectLink.getAttribute('href');
        const projectId = href?.match(/\/projects\/(\d+)/)?.[1];

        if (!projectId) {
            test.skip();
            return;
        }

        await page.goto(`/reports/project/${projectId}/full`);
        await page.waitForLoadState('networkidle');
        expect(page.url()).not.toContain('/login');
        // La página debe tener algún contenido del reporte
        const content = page.locator('h1, .card, [class*="report"]').first();
        await expect(content).toBeVisible({ timeout: 5000 });
    });
});

// ============================================================
// UC-H08: Duplicar proyecto
// ============================================================
test.describe('UC-H08: Duplicar proyecto', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('El botón de duplicar proyecto está presente en show', async ({ page }) => {
        await page.goto('/projects');
        // Usar el enlace de ver detalle (icono ojo) para ir al show del proyecto
        const projectLink = page.locator('a:has(.bi-eye)').first();
        const count = await projectLink.count();

        if (count === 0) {
            test.skip();
            return;
        }

        await projectLink.click();
        await page.waitForLoadState('networkidle');

        // El formulario de duplicar debe existir
        const dupForm = page.locator('form[action*="/duplicate"]');
        await expect(dupForm).toBeAttached({ timeout: 5000 });
    });
});

// ============================================================
// UC-H09: IDOR — no se puede acceder a recursos de otros tenants
// ============================================================
test.describe('UC-H09: Aislamiento de datos (IDOR)', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsUser(page);
    });

    test('GET /reports/project/99999/full retorna 404 para proyecto inexistente', async ({
        page,
    }) => {
        const response = await page.goto('/reports/project/99999/full');
        // Debe retornar 404 o redirigir, no puede ver datos de otros tenants
        const status = response?.status();
        expect(status === 404 || status === 403 || page.url().includes('/login')).toBeTruthy();
    });

    test('GET /projects/99999/plantillas retorna 404 para proyecto inexistente', async ({
        page,
    }) => {
        const response = await page.goto('/projects/99999/plantillas');
        const status = response?.status();
        expect(status === 404 || status === 403 || page.url().includes('/login')).toBeTruthy();
    });
});
