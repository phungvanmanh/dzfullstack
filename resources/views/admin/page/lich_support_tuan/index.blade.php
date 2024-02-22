<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
    <link rel="icon" style="height: 100px; width: 100px;margin-top: 5px" href="/assets/images/logo-2.png" type="image/png" />

	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js" integrity="sha512-QTnb9BQkG4fBYIt9JGvYmxPpd6TBeKp6lsUrtiVQsrJ9sb33Bn9s0wMQO9qVBFbPX3xHRAsBHvXlcsrnJjExjg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>DZFullStack - Zero2Hero</title>

</head>

<body class="bg-login">
	<!-- wrapper -->
	<div class="wrapper" id="app">
		<nav class="navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
			<div class="row">
                <div class="col-md-5"></div>
                <div class="topbar-logo-header col-md-2">
                    <img style="height:60px;width:110px;margin-bottom: 5px" src="/assets/images/logo-1.png">
                    <h4 style="margin-top: 10px" class="text-dark logo-text">DZ Fullstack</h4>
                </div>
                <div class="col-md-5"></div>
            </div>
		</nav>
        <div class="page-wrapper">
            <div class="row">
                <div class="card border-primary border-bottom border-3 border-0">
                    <div class="card-header mt-3 mb-3">
                        <div class="row">
                            <div class="col mt-2">
                                <h6>Lịch Support Học Viên</h6>
                            </div>
                            <div class="col-10 mt-2 text-end">
                                <h6>SKY:<b>Duy Khánh </b> , KIN: <b>Quốc Huy </b>, PHONG:<b>Văn Phong</b> , MU: <b>Minh Tiến</b> , MID:<b>Thanh Trường</b> , SUBEO:<b>Văn Mạnh</b> , STONE:<b>Vũ Huy</b> , PAT:<b>Công Thạch</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-drop">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center">Thứ 2</th>
                                        <th class="text-center">Thứ 3</th>
                                        <th class="text-center">Thứ 4</th>
                                        <th class="text-center">Thứ 5</th>
                                        <th class="text-center">Thứ 6</th>
                                        <th class="text-center">Thứ 7</th>
                                        <th class="text-center">Chủ Nhật</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Ngày</th>
                                        <template v-for="(value, index) in days">
                                            <th class="text-center"> @{{ date_format(value) }} </th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="height: 80px" v-for="(value_hour, index_hour) in hours">
                                        <td class="align-middle text-center">Buổi @{{ value_hour }}</td>
                                        <template v-for="(value, index) in data">
                                            <template v-for="(v, i) in value" v-if="i == index_hour">
                                                <td class="text-center align-middle">
                                                    <template v-for="(value_nv, key_nv) in list_nv">
                                                        <template v-if="v.list[1].includes(value_nv.ten_goi_nho)">
                                                                <template v-for="(value_1, key_2) in v.list[1]">
                                                                    <template v-for="(v_ids, k_ids) in v.ids" v-if="k_ids == key_2">
                                                                        <template v-if="value_nv.ten_goi_nho === value_1">
                                                                            <template>
                                                                                <span class="text-primary" v-if="key_nv < list_nv.length - 1">@{{ value_nv.ten_goi_nho }},</span>
                                                                                <span class="text-primary" v-else>@{{ value_nv.ten_goi_nho }}</span>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </template>
                                                            <template v-else>
                                                                <span v-if="key_nv < list_nv.length - 1"
                                                                class="text-white">@{{ value_nv.ten_goi_nho }},</span>
                                                                <span v-else class="text-white">@{{ value_nv.ten_goi_nho }}</span>
                                                            </template>
                                                            <template v-if="key_nv == Math.floor(list_nv.length / 2 ) - 1">
                                                                <br>
                                                            </template>
                                                        </template>
                                                    <br><span><b>Số lượng làm việc: @{{ v.list[0].length }}</b> </span>
                                                </td>
                                            </template>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		<footer class="page-footer">
			<p class="mb-0">Copyright DZFullStack © @php echo date("Y") @endphp. All right reserved.</p>
		</footer>
	</div>
	<!-- end wrapper -->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                days: [],
                hours: ['Sáng', 'Chiều', 'Tối', 'Khuya'],
                data: [],
                type: -1,
                id_buoi_lam_viec: 0,
                update_buoi_lam: {},
                list_nv: [],
            },
            created() {
                this.loadData();
            },
            methods: {
                date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
                },
                number_format(number, decimals = 2, dec_point = ",", thousands_sep = ".") {
                    var n = number,
                        c = isNaN((decimals = Math.abs(decimals))) ? 2 : decimals;
                    var d = dec_point == undefined ? "," : dec_point;
                    var t = thousands_sep == undefined ? "." : thousands_sep,
                        s = n < 0 ? "-" : "";
                    var i = parseInt((n = Math.abs(+n || 0).toFixed(c))) + "",
                        j = (j = i.length) > 3 ? j % 3 : 0;

                    return (s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (
                        c ? d +
                        Math.abs(n - i)
                        .toFixed(c)
                        .slice(2) :
                        ""));
                },
                loadData() {
                    axios
                        .get('/lich-support/data/' + this.type)
                        .then((res) => {
                            this.days = res.data.days;
                            this.data = res.data.data;

                            this.loadNhanVien();
                        });
                },
                loadNhanVien() {
                    axios
                        .get('/lich-support/data-nv')
                        .then((res) => {
                            this.list_nv = res.data.data;
                            // console.log(this.list_nv);
                        });
                },
            }
        });
    </script>
</body>

</html>
