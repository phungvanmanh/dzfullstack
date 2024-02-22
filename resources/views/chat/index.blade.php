<html>

<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js"
        integrity="sha512-QTnb9BQkG4fBYIt9JGvYmxPpd6TBeKp6lsUrtiVQsrJ9sb33Bn9s0wMQO9qVBFbPX3xHRAsBHvXlcsrnJjExjg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/chat.css">
</head>

<body>
    <div class="container-fluid h-100" id="app">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="/assets/images/ai.png" class="rounded-circle user_img">
                                <span class="online_icon"></span>
                            </div>
                            <div class="user_info">
                                <span>Chat with AI</span>
                                <p>DZFullStack Demo</p>
                            </div>
                        </div>
                    </div>
                    <div id="chatbody" class="card-body msg_card_body">
                        <template v-for="(value, key) in list">
                            <div v-if="value.id" class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="/assets/images/ai.png" class="rounded-circle user_img_msg">
                                </div>
                                <div class="msg_cotainer">
									<p style="white-space:pre-wrap;">@{{value.message}}</p>
                                    
                                </div>
                            </div>
                            <div v-else class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                    <p style="white-space:pre-wrap;">@{{value.message}}</p>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="/assets/images/me.png" class="rounded-circle user_img_msg">
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="card-footer">
                        <div class="input-group">
                            <input v-model="message" v-on:keyup.enter="sendRequest()" type="text"
                                class="form-control type_msg" placeholder="Type your message...">
                            <div class="input-group-append">
                                <span class="input-group-text send_btn">
                                    <div v-if="check" class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <i v-else class="fas fa-location-arrow" v-on:click="sendRequest()"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="/chat.js"></script>

</html>
