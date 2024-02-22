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

async function getPredictedRate(link) {
    const clientToken = tokenManager.registerClient(); // Đăng ký client và lấy mã thông báo
    const clientInfo = tokenManager.getClient(clientToken); // Lấy thông tin client dựa trên mã thông báo
    // Setup chrome
    clientInfo.browser = await puppeteer.launch({
        headless: false, args: ['--no-sandbox']
    });

    // Khởi Tạo Chrome
    [clientInfo.page] = await clientInfo.browser.pages();
    await clientInfo.page.goto(link);
    const page = clientInfo.page;
    // let predicterdRate = await checkExits(page, '//*[@id="content"]/div/div[3]/div[3]/div[2]/div/div[1]/span[3]/span[2]/div/div'); // lấy getPredictedRate
    // let price = await checkExits(page, '//*[@id="content"]/div/div[3]/div[3]/div[1]/div/span'); //Lấy price
    // có thể đợi thêm một khoảng thời gian ngắn
    await page.waitForTimeout(3000);
    let price = await checkExits(page, '//*[@id="__APP"]/div[3]/div/div[8]/div/div/div[1]/div/div[2]/div[1]'); //Lấy price
    return {
        // 'predicterdRate' : predicterdRate,
        'price'          : price
    };
}

app.get('/get-data', async (req, res) => {
    try {
        const promises = list_link.map((link, index) => new Promise((resolve, reject) => {
            const worker = new Worker('../Selenium/genaral/worker.js', { workerData: {link, index} });
            worker.on('message', resolve);
            worker.on('error', reject);
            worker.on('exit', (code) => {
                if (code !== 0)
                    reject(new Error(`Worker stopped with exit code ${code}`));
            });
        }));

        const results = await Promise.all(promises);
        let now = moment().format('YYYY-MM-DD HH:mm:ss');
        const data = {
            'data' : results,
            'time' : now
        }
        res.status(200).send(data);
        // let data = await getPredictedRate(list_link[3].link);
        // console.log(data);
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
