const { test, expect } = require('@playwright/test');

test('screenshot and check untranslated keys on 2FA enable page', async ({ page }) => {
  await page.goto('http://localhost:8080/security/2fa/enable', { waitUntil: 'networkidle' });
  await page.waitForLoadState('networkidle');

  // take screenshot
  const path = 'var/playwright/screenshots/2fa_enable.png';
  await page.screenshot({ path, fullPage: true });

  // get visible text
  const body = await page.locator('body').innerText();

  // patterns that look like untranslated keys (e.g., security_2fa.enable_2fa_title or security.secret_key)
  const untranslatedPatterns = [
    /\bsecurity_2fa\.[A-Za-z0-9_]+\b/g,
    /\bsecurity\.[A-Za-z0-9_\.]+\b/g,
    /\badmin\.[A-Za-z0-9_\.]+\b/g
  ];

  const found = [];
  for (const re of untranslatedPatterns) {
    const m = body.match(re);
    if (m) found.push(...m);
  }

  // log results
  console.log('screenshot:', path);
  if (found.length) {
    console.log('Found possible untranslated keys:', Array.from(new Set(found)).join(', '));
  } else {
    console.log('No untranslated key-like tokens found in page text.');
  }

  // assertions for test
  expect(found.length, 'No untranslated keys present').toBe(0);
});
