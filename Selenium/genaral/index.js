const crypto = require('crypto');

const KEY_CAP = '03c5426ca03789e9c68c03b6ac7f91c0'

async function sleepTime(time) {
    time = time * 1000;
    return new Promise(resolve => setTimeout(resolve, time));
}



module.exports = {
    KEY_CAP,
    sleepTime
};
