const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const puppeteer = require('puppeteer');
const axois = require('axios');
const tokenManager = require('../Selenium/genaral/token');
const action = require('../Selenium/genaral/index');
const { Worker } = require('worker_threads');
const moment = require('moment');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization, clientToken');
    next();
});

const list_link = [
    {
        'name' : 'ETHUSDT',
        'link' : 'https://www.bitmex.com/app/trade/ETHUSDT'
    },
    {
        'name' : 'ETHUSD',
        'link' : 'https://www.bitmex.com/app/trade/ETHUSD',
    },
    {
        'name' : 'BINETH',
        'link' : 'https://www.binance.com/en/futures/funding-history/perpetual/real-time-funding-rate'
    },
    {
        'name' : 'BINETH',
        'link' : 'https://www.binance.com/vi/trade/ETH_USDT?_from=markets&type=spot'
    },
];

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

async function startBrowser() {
    const clientToken = tokenManager.registerClient(); // Đăng ký client và lấy mã thông báo
    const clientInfo = tokenManager.getClient(clientToken); // Lấy thông tin client dựa trên mã thông báo
    // Setup chrome
    clientInfo.browser = await puppeteer.launch({
        headless: true, args: ['--no-sandbox']
    });

    // Khởi Tạo Chrome
    return clientInfo.browser;
}

async function getPredictedRate(browser, data, index) {
    console.log(data.link, index);
    const page = await browser.newPage();
    await page.goto(data.link, { waitUntil: 'load', timeout: 120000 });

    let predicterdRate = null;
    let price = null;
    if(index < 2) {
        predicterdRate = await checkExits(page, '//*[@id="content"]/div/div[3]/div[3]/div[2]/div/div[1]/span[3]/span[2]/div/div'); // lấy getPredictedRate
        price = await checkExits(page, '//*[@id="content"]/div/div[3]/div[3]/div[1]/div/span'); //Lấy price
    } else if(index == 2) {
        await page.waitForTimeout(3000);
        predicterdRate = await checkExits(page, '//*[@id="__APP"]/div[3]/div[1]/div/div[2]/div[3]/div/div[2]/div/div/div/div/table/tbody/tr[3]/td[4]'); // lấy getPredictedRate
    } else {
        await page.waitForTimeout(3000);
        price = await checkExits(page, '//*[@id="__APP"]/div[3]/div/div[8]/div/div/div[1]/div/div[2]/div[1]'); //Lấy price
    }

    await page.close();
    return {
        'name'           : data.name,
        'predicterdRate' : predicterdRate != null ? predicterdRate.message : null,
        'price'          : price != null ? price.message : null
    };
}

app.get('/get-data', async (req, res) => {
    try {
        const browser = await startBrowser();
        const dataPromises = list_link.map((link, index) => getPredictedRate(browser, link, index));
        const results = await Promise.all(dataPromises);
        // return results; // Trả về mảng của dữ liệu thu thập từ mỗi URL
        await browser.close();
        let now = moment().format('YYYY-MM-DD HH:mm:ss');
        const data = {
            'data' : results,
            'time' : now
        }
        res.status(200).send(data);
    } catch (error) {
        console.log(error);
        res.status(500).send({
            'status' : false,
            'message' : 'Đã có lỗi hệ thống!',
            'error' : error.message
        });
    }
});
const port = 3020;
// const httpsServer = https.createServer(credentials, app);
app.listen(port, () => {
    console.log('Server is listening on port ' + port);
});
