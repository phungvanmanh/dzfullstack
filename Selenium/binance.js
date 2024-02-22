const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const puppeteer = require('puppeteer');
const axois = require('axios');
const tokenManager = require('../Selenium/genaral/token');
const action = require('../Selenium/genaral/index');
const moment = require('moment');
const { default: axios } = require('axios');
const https = require('https');
const crypto = require('crypto');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization, clientToken');
    next();
});

const allowLegacyRenegotiationforNodeJsOptions = {
    httpsAgent: new https.Agent({
      // for self signed you could also add
      // rejectUnauthorized: false,
      // allow legacy server
      secureOptions: crypto.constants.SSL_OP_LEGACY_SERVER_CONNECT,
    }),
};

LINK_API = "https://dzfullstack.com/api";
// LINK_API = "http://127.0.0.1:8000/api";

async function createData(data) {
    const res = await axios.post(LINK_API + '/create-data-binance', data)
    return res.data
}

async function resetData() {
    const res = await axios.get(LINK_API + '/reset-data')
    return res.data
}

const LIST_NAME = ['ETHUSDT', 'ETHUSD'];

app.get('/get-data-all', async (req, res) => {
    try {
        await resetData();
        let start = 0;
        for (let index = 0; index < 6; index++) {
            let array = [];
            for (let key = 0; key < LIST_NAME.length; key++) {
                console.log(start);
                let name = LIST_NAME[key];
                var link = `https://www.bitmex.com/api/v1/funding?count=500&start=${start}&reverse=true&filter=%7B%22symbol%22%3A%22${name}%22%7D`
                var respone = await axios({
                    ...allowLegacyRenegotiationforNodeJsOptions,
                    url : link,
                    method: 'GET',
                });
                array.push(respone.data);
            }
            var list_data = [];
            for (let num = 0; num < array[0].length; num++) {
                const ETHUSDT   = array[0][num];
                const ETHUSD    = array[1][num];
                var payload = {
                    'ETHUSDTFundingRate'        : ETHUSDT.fundingRate,
                    'ETHUSDTFundingRateDaily'   : ETHUSDT.fundingRateDaily,
                    'ETHUSDFundingRate'         : ETHUSD.fundingRate,
                    'ETHUSDFundingRateDaily'    : ETHUSD.fundingRateDaily,
                    'time'                      : moment(ETHUSDT.timestamp).format("YYYY-MM-DD HH:mm:ss")
                }
                list_data.push(payload);
            }
            var pay = {
                'data' : list_data
            }
            await createData(pay);
            start = start + 500;
        }

        res.status(200).send({
            'status' : true,
            'message' : "Success!"
        });
    } catch (error) {
        console.log(error.message);
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

