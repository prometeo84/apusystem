const lighthouse = require('lighthouse');
const chromeLauncher = require('chrome-launcher');

async function run(url) {
    const chrome = await chromeLauncher.launch({ chromeFlags: ['--headless'] });
    const options = { port: chrome.port, onlyCategories: ['accessibility'] };
    const runnerResult = await lighthouse(url, options);

    const a11yScore = runnerResult.lhr.categories.accessibility.score * 100;
    console.log(`Accessibility score: ${a11yScore}`);

    await chrome.kill();
}

if (require.main === module) {
    const url = process.argv[2] || 'http://localhost:8080/';
    run(url).catch((err) => {
        console.error(err);
        process.exit(1);
    });
}
