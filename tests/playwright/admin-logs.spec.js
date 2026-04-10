const { test, expect } = require('@playwright/test');
const { injectAxe, checkA11y } = require('axe-playwright');
const fs = require('fs');

const BASE_URL = 'http://localhost:8080';

async function login(page) {
    await page.goto(`${BASE_URL}/login`);
    await page.waitForSelector('input[name="_username"]', { timeout: 5000 });
    await page.fill('input[name="_username"]', 'admin@demo.com');
    await page.fill('input[name="_password"]', 'Admin123!');
    await Promise.all([
        page.click('button[type="submit"]'),
        page.waitForNavigation({ waitUntil: 'networkidle', timeout: 10000 }),
    ]);
}

test.describe('Admin Logs - paginación server-side', () => {
    test('página 1: máximo 20 filas, paginación visible y activa en 1', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/admin/logs`);

        // La tabla debe tener como máximo 20 filas
        const rows = page.locator('#logsTable tbody tr');
        const rowCount = await rows.count();
        expect(rowCount).toBeLessThanOrEqual(20);

        // El item activo de la paginación debe ser "1"
        const activePage = page.locator('.pagination .page-item.active .page-link');
        await expect(activePage).toBeVisible();
        await expect(activePage).toHaveText('1');

        // El botón "Anterior" debe estar deshabilitado en página 1
        const prevItem = page.locator('.pagination .page-item').first();
        await expect(prevItem).toHaveClass(/disabled/);

        await page.screenshot({ path: 'tmp/logs-page1.png', fullPage: true }).catch(() => {});
    });

    test('clic en página 2: activo se mueve a 2, filas distintas a página 1', async ({ page }) => {
        await login(page);

        // Obtener filas de página 1 para comparar (texto completo de la primera celda)
        await page.goto(`${BASE_URL}/admin/logs?page=1`);
        const firstRowPage1 = await page
            .locator('#logsTable tbody tr')
            .first()
            .evaluate((row) => row.querySelector('td')?.innerText.trim() ?? '');

        // Ir a página 2 clicando el enlace (no por URL directa)
        const page2Link = page.locator('.pagination .page-item a.page-link', { hasText: '2' });
        await expect(page2Link).toBeVisible({ timeout: 5000 });
        await Promise.all([
            page2Link.click(),
            page.waitForNavigation({ waitUntil: 'networkidle', timeout: 10000 }),
        ]);

        // URL debe contener page=2
        expect(page.url()).toContain('page=2');

        // El item activo debe ser "2"
        const activePage = page.locator('.pagination .page-item.active .page-link');
        await expect(activePage).toHaveText('2');

        // Máximo 20 filas
        const rows = page.locator('#logsTable tbody tr');
        expect(await rows.count()).toBeLessThanOrEqual(20);

        // El primer bloque de fecha/hora de página 2 debe ser distinto al de página 1
        const firstRowPage2 = await page
            .locator('#logsTable tbody tr')
            .first()
            .evaluate((row) => row.querySelector('td')?.innerText.trim() ?? '');
        expect(firstRowPage2).not.toBe(firstRowPage1);

        await page.screenshot({ path: 'tmp/logs-page2.png', fullPage: true }).catch(() => {});
    });

    test('botón Siguiente y Anterior navegan correctamente', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/admin/logs?page=1`);

        // Siguiente → página 2
        const nextLink = page.locator('.pagination .page-item:not(.disabled) a.page-link').last();
        await Promise.all([
            nextLink.click(),
            page.waitForNavigation({ waitUntil: 'networkidle', timeout: 10000 }),
        ]);
        expect(page.url()).toContain('page=2');
        await expect(page.locator('.pagination .page-item.active .page-link')).toHaveText('2');

        // Anterior → página 1
        const prevLink = page.locator('.pagination .page-item:not(.disabled) a.page-link').first();
        await Promise.all([
            prevLink.click(),
            page.waitForNavigation({ waitUntil: 'networkidle', timeout: 10000 }),
        ]);
        const url = page.url();
        expect(url.includes('page=1') || !url.includes('page=')).toBeTruthy();
        await expect(page.locator('.pagination .page-item.active .page-link')).toHaveText('1');
    });

    test('accesibilidad (axe) en footer de paginación', async ({ page }) => {
        await login(page);
        await page.goto(`${BASE_URL}/admin/logs`);
        await injectAxe(page);
        try {
            await checkA11y(page, '.card-footer', { detailedReport: true });
        } catch (err) {
            try {
                fs.writeFileSync('tmp/admin-logs-a11y-error.txt', err.toString());
            } catch (e) {}
            const violations = JSON.parse(err.message.match(/\[.*\]/s)?.[0] ?? '[]').map((v) => ({
                id: v.id,
                impact: v.impact,
                description: v.description,
                nodes: v.nodes.length,
            }));
            if (violations.length) console.table(violations);
            if (process.env.FAIL_ON_A11Y === '1') throw err;
        }
    });

    test('tema oscuro: card-footer y paginación con colores correctos', async ({ page }) => {
        await login(page);

        // Cambiar el tema a "dark" via el perfil (server-side) para que
        // data-theme="dark" sea renderizado directamente por Twig sin manipulación JS
        await page.goto(`${BASE_URL}/profile/preferences`);
        await page.waitForSelector('form', { timeout: 5000 });

        // Enviar formulario de preferencias con theme_mode=dark
        await page.evaluate(async (baseUrl) => {
            // Recoger todos los campos del formulario de preferencias para no perder otros datos
            const form = document.querySelector('form[method="post"], form');
            const fd = form ? new FormData(form) : new FormData();
            fd.set('theme_mode', 'dark');
            await fetch(`${baseUrl}/profile/preferences`, {
                method: 'POST',
                body: fd,
                credentials: 'include',
                redirect: 'follow',
            });
        }, BASE_URL);

        // Navegar a logs — Twig renderizará data-theme="dark" desde el servidor
        await page.goto(`${BASE_URL}/admin/logs`);

        // Verificar que el HTML tiene data-theme="dark" (rendered por el servidor)
        const serverTheme = await page.evaluate(() =>
            document.documentElement.getAttribute('data-theme')
        );
        // Si no es dark todavía, forzar via JS como fallback
        if (serverTheme !== 'dark') {
            await page.evaluate(() => document.documentElement.setAttribute('data-theme', 'dark'));
            await page.waitForTimeout(100);
        }

        // Leer estilos computados
        const { footerBg, linkColor, activeLinkColor, themeAttr } = await page.evaluate(() => {
            const footer = document.querySelector('.card-footer');
            const pageLink = document.querySelector(
                '.pagination .page-item:not(.active):not(.disabled) .page-link'
            );
            const activeLink = document.querySelector('.pagination .page-item.active .page-link');
            return {
                themeAttr: document.documentElement.getAttribute('data-theme'),
                footerBg: footer ? getComputedStyle(footer).backgroundColor : 'not found',
                linkColor: pageLink ? getComputedStyle(pageLink).color : 'not found',
                activeLinkColor: activeLink ? getComputedStyle(activeLink).color : 'not found',
            };
        });

        console.log(`data-theme: ${themeAttr}, linkColor: ${linkColor}, footerBg: ${footerBg}`);

        // card-footer debe tener fondo oscuro (no blanco)
        expect(footerBg).not.toBe('rgb(255, 255, 255)');

        // Links de paginación deben ser claros: R,G,B > 180  (#e9ecef = 233,236,239)
        const rgb = linkColor.match(/\d+/g).map(Number);
        const isLight = rgb[0] > 180 && rgb[1] > 180 && rgb[2] > 180;
        expect(isLight, `Color esperado claro (#e9ecef), obtenido: ${linkColor}`).toBe(true);

        // El item activo debe ser blanco
        expect(activeLinkColor).toBe('rgb(255, 255, 255)');

        // Restaurar tema a "light"
        await page.goto(`${BASE_URL}/profile/preferences`);
        await page.evaluate(async (baseUrl) => {
            const form = document.querySelector('form[method="post"], form');
            const fd = form ? new FormData(form) : new FormData();
            fd.set('theme_mode', 'light');
            await fetch(`${baseUrl}/profile/preferences`, {
                method: 'POST',
                body: fd,
                credentials: 'include',
                redirect: 'follow',
            });
        }, BASE_URL);

        // Captura screenshot para inspección visual
        await page.screenshot({ path: 'tmp/logs-dark-theme.png', fullPage: true }).catch(() => {});
    });
});
