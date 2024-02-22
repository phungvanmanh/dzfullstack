new Vue({
    el: '#app',
    data: {
        check: false,
        list: [{
                id: 1,
                message: 'Xin chào, bạn có thể đặt cho tôi câu hỏi?'
            },
        ],
        message: '',
    },
    updated() {
        this.scrollToBottom();
    },
    methods: {
        sendRequest() {
            if (this.message.length <= 10) {
                toastr.error("Câu hỏi phải trên 10 ký tự!");
            } else {
                if (!this.check) {
                    this.check = true;
                    const payload = {
                        'id': 1,
                        'message': this.message
                    };
                    this.list.push(payload);
                    this.message = '';
                    axios
                        .post('/ai', payload)
                        .then((res) => {
                            if(res.data.status) {
                                var x = {id: 0, message: res.data.message};
                                this.list.push(x);
                                this.check = false;
                            } else {
                                toastr.warning("Câu hỏi không thể xử lý");
                            }
                        })
                        .catch(() => {
                            toastr.error("Câu hỏi phải trên 10 ký tự!");
                        });;
                } else {
                    toastr.warning("Đang xử lý dữ liệu...");
                }
            }

        },
        async scrollToBottom() {
            $('#chatbody').animate({
                scrollTop: document.querySelector("#chatbody").scrollHeight
            }, 50)
            await setTimeout(function() {
                $('#chatbody').scrollTop(document.querySelector("#chatbody").scrollHeight);
            }, 50);
        },
    },
});