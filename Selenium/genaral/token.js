// tokenManager.js
const crypto = require('crypto');

// Lưu thông tin client và token
const clients = new Map();

// Hàm tạo mã thông báo (token) ngẫu nhiên
function generateToken() {
    return crypto.randomBytes(16).toString('hex');
}

// Hàm đăng ký một client và trả về mã thông báo cho họ
function registerClient() {
    const token = generateToken();
    const client = { token };
    clients.set(token, client);
    return token;
}

// Hàm kiểm tra và lấy thông tin client dựa trên mã thông báo
function getClient(token) {
    return clients.get(token);
}

// Hàm xóa thông tin client khi họ hoàn thành công việc
function removeClient(token) {
    clients.delete(token);
}

module.exports = {
    registerClient,
    getClient,
    removeClient,
};
