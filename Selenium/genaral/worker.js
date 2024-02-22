// File: worker.js
const { parentPort, workerData } = require('worker_threads');
const puppeteer = require('puppeteer');
const tokenManager = require('./token');

async function checkExits(page, xpathExpression) {
    const element = await page.$x(xpathExpression);
    if (element.length > 0) {
        const text = await page.evaluate(el => el.textContent, element[0]);
        return {
            'status': true,
            'message': text
        }
    } else {
        return {
            'status': false,
        }
    }
}

async function getPredictedRate(data, index) {
    var link = data.link;
    const clientToken = tokenManager.registerClient(); // Đăng ký client và lấy mã thông báo
    const clientInfo = tokenManager.getClient(clientToken); // Lấy thông tin client dựa trên mã thông báo
    // Setup chrome
    clientInfo.browser = await puppeteer.launch({
        headless: "new", args: ['--no-sandbox']
    });

    // Khởi Tạo Chrome
    [clientInfo.page] = await clientInfo.browser.pages();
    await clientInfo.page.goto(link, { waitUntil: 'load', timeout: 120000 });
    const page = clientInfo.page;
    let predicterdRate = null;
    let price = null;
    if(index < 2) {
        predicterdRate = await checkExits(page, '//*[@id="content"]/div/div[3]/div[3]/div[2]/div/div[1]/span[3]/span[2]/div/div'); // lấy getPredictedRate
        price = await checkExits(page, '//*[@id="content"]/div/div[3]/div[3]/div[1]/div/span'); //Lấy price
    } else if(index == 2) {
        predicterdRate = await checkExits(page, '//*[@id="__APP"]/div[3]/div[1]/div/div[2]/div[3]/div/div[2]/div/div/div/div/table/tbody/tr[3]/td[4]'); // lấy getPredictedRate
    } else {
        await page.waitForTimeout(3000);
        price = await checkExits(page, '//*[@id="__APP"]/div[3]/div/div[8]/div/div/div[1]/div/div[2]/div[1]'); //Lấy price
    }

    clientInfo.browser.close();
    return {
        'name'           : data.name,
        'predicterdRate' : predicterdRate != null ? predicterdRate.message : null,
        'price'          : price != null ? price.message : null
    };
}

(async () => {
    try {
        let link = workerData.link;
        let index = workerData.index;
        const data = await getPredictedRate(link, index);
        parentPort.postMessage(data);
    } catch (error) {
        parentPort.postMessage({ error: error.message });
    }
})();
