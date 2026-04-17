// @ts-check
const { defineConfig, devices } = require('@playwright/test');

module.exports = defineConfig({
    testDir: './tests/E2E',
    fullyParallel: false,
    forbidOnly: !!process.env.CI,
    retries: process.env.CI ? 1 : 0,
    workers: 1,
    // Increase overall test timeout for slower mobile emulation
    timeout: 60000,
    reporter: [['list'], ['html', { outputFolder: 'tests/playwright-report', open: 'never' }]],
    use: {
        baseURL: process.env.APP_URL || 'http://localhost:8080',
        trace: 'on-first-retry',
        screenshot: 'only-on-failure',
        video: 'off',
        // Increase action/navigation timeouts to reduce click/timeouts on mobile
        actionTimeout: 15000,
        navigationTimeout: 30000,
        // Increase default expect timeout
        launchOptions: {},
    },
    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'] },
        },
        {
            name: 'Mobile Chrome',
            use: { ...devices['Pixel 5'] },
        },
        {
            name: 'Tablet iPad',
            use: { ...devices['iPad (gen 7)'] },
        },
        {
            name: 'Tablet Galaxy',
            use: { ...devices['Galaxy Tab S4'] },
        },
    ],
    // No webServer — app managed externally by Docker
});
