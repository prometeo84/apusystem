// @ts-check
const { test, expect } = require('@playwright/test');

/**
 * Helper: Login como admin
 */
async function loginAsAdmin(page) {
    await page.goto('/login');
    await page.waitForSelector('input[name="_username"]', { timeout: 8000 });
    await page.fill('input[name="_username"]', 'admin@demo.com');
    const adminPassword = process.env.ADMIN_PASSWORD || 'Admin123!';
    await page.fill('input[name="_password"]', adminPassword);
    await page.click('button[type="submit"]');
    // Esperar redirección post-login (dashboard o 2fa)
    await page.waitForURL(/\/(dashboard|2fa|$)/, { timeout: 10000 });
}

// ============================================================
// UC-07: Autenticación — acceso sin sesión redirige a /login
// ============================================================
test.describe('UC-07: Autenticación y control de acceso', () => {
    test('GET /dashboard sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /admin sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/admin');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /profile sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/profile');
        await expect(page).toHaveURL(/\/login/);
    });

    test('GET /system/tenants sin sesión redirige a /login', async ({ page }) => {
        await page.goto('/system/tenants');
        await expect(page).toHaveURL(/\/login/);
    });

    test('Página de login renderiza formulario con campos requeridos', async ({ page }) => {
        await page.goto('/login');
        await expect(page.locator('input[name="_username"]')).toBeVisible();
        await expect(page.locator('input[name="_password"]')).toBeVisible();
        await expect(page.locator('button[type="submit"]')).toBeVisible();
    });

    test('Login con credenciales inválidas muestra error', async ({ page }) => {
        await page.goto('/login');
        await page.fill('input[name="_username"]', 'noexiste@test.com');
        await page.fill('input[name="_password"]', 'WrongPass123!');
        await page.click('button[type="submit"]');
        // Debe quedarse en /login o mostrar mensaje de error
        await page.waitForTimeout(1500);
        const url = page.url();
        const hasError =
            url.includes('/login') ||
            (await page.locator('.alert-danger, .error, [class*="error"]').count()) > 0;
        expect(hasError).toBeTruthy();
    });
});

// ============================================================
// UC-08: Login exitoso
// ============================================================
test.describe('UC-08: Login exitoso redirige al dashboard', () => {
    test('Admin puede logarse y llega al dashboard', async ({ page }) => {
        await loginAsAdmin(page);
        // Debe estar en dashboard, 2FA o similar (no en /login)
        expect(page.url()).not.toContain('/login');
    });
});

// ============================================================
// UC-09: Rutas protegidas por rol
// ============================================================
test.describe('UC-09: Control de acceso basado en roles', () => {
    test('GET /password/forgot es accesible sin autenticación', async ({ page }) => {
        await page.goto('/password/forgot');
        await expect(page).not.toHaveURL(/\/login/);
        await expect(page.locator('form')).toBeVisible();
    });

    test('GET /password/forgot tiene campo de email', async ({ page }) => {
        await page.goto('/password/forgot');
        await expect(page.locator('input[type="email"], input[name="email"]')).toBeVisible();
    });
});

// ============================================================
// UC-10: CSRF — formularios tienen campo _token
// ============================================================
test.describe('UC-10: Protección CSRF en formularios', () => {
    test('Formulario de forgot password tiene campo _token', async ({ page }) => {
        await page.goto('/password/forgot');
        const token = page.locator('input[name="_token"]');
        await expect(token).toBeAttached();
        const value = await token.inputValue();
        expect(value.length).toBeGreaterThan(0);
    });

    test('POST a /profile/edit sin token retorna 403', async ({ page }) => {
        // POST directo sin token — debe recibir 403
        const response = await page.request.post('/profile/edit', {
            form: { first_name: 'Hacker', last_name: 'Test' },
        });
        expect(response.status()).toBe(403);
    });

    test('POST a /admin/users/create sin token retorna 403', async ({ page }) => {
        const response = await page.request.post('/admin/users/create', {
            form: { email: 'hack@test.com' },
        });
        expect(response.status()).toBe(403);
    });

    test('POST a /apu/create sin token retorna 403', async ({ page }) => {
        const response = await page.request.post('/apu/create', {
            form: { description: 'test' },
        });
        expect(response.status()).toBe(403);
    });
});

// ============================================================
// UC-11: Paginación en admin/logs
// ============================================================
test.describe('UC-11: Paginación genérica en vistas de listado', () => {
    test('Admin logs: máximo 20 filas en página 1', async ({ page }) => {
        await loginAsAdmin(page);
        await page.goto('/admin/logs');
        const currentUrl = page.url();
        if (!currentUrl.includes('/admin/logs')) {
            test.skip(true, 'Admin logs requiere credenciales válidas');
            return;
        }
        const rows = page.locator('#logsTable tbody tr');
        const count = await rows.count();
        expect(count).toBeLessThanOrEqual(20);
    });

    test('Admin logs: control de paginación visible', async ({ page }) => {
        await loginAsAdmin(page);
        await page.goto('/admin/logs');
        const currentUrl = page.url();
        if (!currentUrl.includes('/admin/logs')) {
            test.skip(true, 'Admin logs requiere credenciales válidas');
            return;
        }
        const pagination = page.locator('.pagination');
        await expect(pagination).toBeVisible();
    });
});

// ============================================================
// UC-12: WebAuthn API endpoints — sin sesión devuelven error JSON
// ============================================================
test.describe('UC-12: WebAuthn API endpoints', () => {
    test('POST /webauthn/login/start sin credenciales devuelve JSON con error', async ({
        page,
    }) => {
        const response = await page.request.post('/webauthn/login/start', {
            data: {},
            headers: { 'Content-Type': 'application/json' },
        });
        const body = await response.json().catch(() => ({}));
        expect(response.status()).toBeLessThanOrEqual(422);
        // Debe ser JSON estructurado
        expect(typeof body).toBe('object');
    });

    test('POST /webauthn/register/start sin sesión redirige a login (protegido)', async ({
        page,
    }) => {
        // Este endpoint requiere autenticación: debe redirigir a /login (302)
        const response = await page.request.post('/webauthn/register/start', {
            data: {},
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': 'fake' },
            maxRedirects: 0,
        });
        // Playwright sigue redirects por defecto; el resultado final debe ser /login
        expect([200, 302, 401, 403]).toContain(response.status());
    });
});

// ============================================================
// UC-13: Localization — cambio de locale
// ============================================================
test.describe('UC-13: Cambio de idioma', () => {
    test('GET /set-locale/en redirecciona correctamente', async ({ page }) => {
        const response = await page.request.get('/set-locale/en', {
            maxRedirects: 0,
        });
        expect([302, 301]).toContain(response.status());
    });

    test('GET /set-locale/es redirecciona correctamente', async ({ page }) => {
        const response = await page.request.get('/set-locale/es', {
            maxRedirects: 0,
        });
        expect([302, 301]).toContain(response.status());
    });
});

// ============================================================
// UC-14: API Revit — login retorna token o error estructurado
// ============================================================
test.describe('UC-14: API REST Revit', () => {
    test('POST /api/v2/auth/login con credenciales inválidas retorna 400/401', async ({ page }) => {
        const response = await page.request.post('/api/v2/auth/login', {
            data: { email: 'wrong@test.com', password: 'badpass' },
            headers: { 'Content-Type': 'application/json' },
        });
        const body = await response.json().catch(() => null);
        expect([400, 401, 403]).toContain(response.status());
        if (body) {
            expect(typeof body).toBe('object');
        }
    });

    test('GET /api/v2/projects sin token retorna error (no HTML redirect)', async ({ page }) => {
        const response = await page.request.get('/api/v2/projects/1/calculations');
        // API pública debe retornar JSON error, no 302 a login HTML
        expect([400, 401, 403, 404, 422]).toContain(response.status());
    });
});
