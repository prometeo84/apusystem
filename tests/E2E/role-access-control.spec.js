// @ts-check
const { test, expect } = require('@playwright/test');

/**
 * role-access-control.spec.js
 * Valida que las rutas de escritura de rubros, proyectos y reportes macro
 * están restringidas a ROLE_ADMIN y los usuarios ROLE_USER no tienen acceso.
 */

const ADMIN = { email: 'admin@abc.com', password: 'Admin123!' };
const USER = { email: 'user@abc.com', password: 'Admin123!' };

async function login(page, creds) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', creds.email);
    await page.fill('input[name="_password"]', creds.password);
    await page.click('button[type="submit"]');
    // Esperar a que la navegación post-login complete (cualquier URL)
    await page.waitForLoadState('networkidle', { timeout: 15000 });
}

// ─────────────────────────────────────────────────────────────────────────────
// ROLE_ADMIN — acceso permitido a rutas de escritura
// ─────────────────────────────────────────────────────────────────────────────
test.describe('ROLE_ADMIN — rutas de escritura accesibles', () => {
    test.beforeEach(async ({ page }) => {
        await login(page, ADMIN);
    });

    test('Admin puede ver formulario de nuevo rubro', async ({ page }) => {
        await page.goto('/rubros/create');
        await expect(page).not.toHaveURL(/login/);
        await expect(page.locator('input[name="codigo"]').first()).toBeVisible();
    });

    test('Admin puede ver formulario de nuevo proyecto', async ({ page }) => {
        await page.goto('/projects/create');
        await expect(page).not.toHaveURL(/login/);
        await expect(page.locator('input[name="nombre"]').first()).toBeVisible();
    });

    test('Admin ve botón Nuevo Proyecto en listado', async ({ page }) => {
        await page.goto('/projects/');
        await expect(page.locator('a[href*="/projects/create"]').first()).toBeVisible();
    });

    test('Admin ve botón Nuevo Rubro en listado', async ({ page }) => {
        await page.goto('/rubros/');
        await expect(page.locator('a[href*="/rubros/create"]').first()).toBeVisible();
    });

    test('Admin puede acceder a reporte macro del proyecto (primero que encuentre)', async ({
        page,
    }) => {
        // Obtener un ID de proyecto existente
        await page.goto('/projects/');
        const firstLink = page.locator('a[href*="/projects/"]').first();
        const href = await firstLink.getAttribute('href');
        if (href) {
            const match = href.match(/\/projects\/(\d+)/);
            if (match) {
                const projectId = match[1];
                await page.goto(`/reports/project/${projectId}/full`);
                await expect(page).not.toHaveURL(/login|403|access/i);
                // Debe renderizar la página sin error
                const status = page.url();
                expect(status).not.toMatch(/login/);
            }
        }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// ROLE_USER — acceso denegado a rutas de escritura
// ─────────────────────────────────────────────────────────────────────────────
test.describe('ROLE_USER — rutas de escritura bloqueadas', () => {
    test.beforeEach(async ({ page }) => {
        await login(page, USER);
    });

    test('Usuario ROLE_USER no puede acceder a crear rubro (403 o redirect)', async ({ page }) => {
        const response = await page.goto('/rubros/create');
        // Debe retornar 403 o redirigir fuera
        const isBlocked =
            (response && response.status() === 403) ||
            page.url().includes('/login') ||
            page.url().includes('/dashboard') ||
            (await page.locator('text=403, text=Access Denied, text=acceso denegado').count()) > 0;
        expect(isBlocked).toBeTruthy();
    });

    test('Usuario ROLE_USER no puede acceder a crear proyecto (403 o redirect)', async ({
        page,
    }) => {
        const response = await page.goto('/projects/create');
        const isBlocked =
            (response && response.status() === 403) ||
            page.url().includes('/login') ||
            page.url().includes('/dashboard') ||
            (await page.locator('text=403, text=Access Denied, text=acceso denegado').count()) > 0;
        expect(isBlocked).toBeTruthy();
    });

    test('Usuario ROLE_USER no puede acceder a reporte macro', async ({ page }) => {
        // Intentar con un ID arbitrario; si no existe 404, si existe pero sin rol 403
        const response = await page.goto('/reports/project/1/full');
        const isBlocked =
            (response && (response.status() === 403 || response.status() === 404)) ||
            page.url().includes('/login') ||
            (await page.locator('text=403, text=Access Denied').count()) > 0;
        expect(isBlocked).toBeTruthy();
    });

    test('Usuario ROLE_USER no ve botón Nuevo Proyecto en listado', async ({ page }) => {
        await page.goto('/projects/');
        // El usuario sí puede ver el listado, pero no el botón de crear
        await expect(page).not.toHaveURL(/login/);
        const createBtn = page.locator('a[href="/projects/create"]');
        await expect(createBtn).toHaveCount(0);
    });

    test('Usuario ROLE_USER no ve botón Nuevo Rubro en listado', async ({ page }) => {
        await page.goto('/rubros/');
        await expect(page).not.toHaveURL(/login/);
        const createBtn = page.locator('a[href="/rubros/create"]');
        await expect(createBtn).toHaveCount(0);
    });

    test('Usuario ROLE_USER puede ver listado de proyectos (read-only)', async ({ page }) => {
        await page.goto('/projects/');
        await expect(page).not.toHaveURL(/login/);
        // Debe cargarse la tabla o mensaje vacío
        const hasList = (await page.locator('table, .text-center').count()) > 0;
        expect(hasList).toBeTruthy();
    });

    test('Usuario ROLE_USER puede ver listado de rubros (read-only)', async ({ page }) => {
        await page.goto('/rubros/');
        await expect(page).not.toHaveURL(/login/);
        const hasList = (await page.locator('table, .text-center').count()) > 0;
        expect(hasList).toBeTruthy();
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// HTTP — test de script shell (rutas directas con curl)
// ─────────────────────────────────────────────────────────────────────────────
test.describe('Control de acceso sin sesión', () => {
    test('GET /rubros/create sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/rubros/create');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /projects/create sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/projects/create');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /reports/project/1/full sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/reports/project/1/full');
        await expect(page).toHaveURL(/\/login/);
    });
});
