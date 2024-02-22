@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6 style="width:200px">Lịch Support Cá Nhân</h6>
                    </div>
                    <div style="margin-left:-30px"class="col text-end mb-2">
                        <button class="text-center btn btn-danger" v-on:click="type--; loadData()"><i
                                style="padding-left: 5px" class="fa-solid fa-backward"></i></button>
                        <button class="text-center btn btn-primary" v-on:click="type = -1; loadData()"><i
                                style="padding-left: 5px" class="fa-sharp fa-solid fa-house"></i></button>
                        <button class="text-center btn btn-success" v-on:click="type++; loadData()"><i
                                style="padding-left: 6px" class="fa-solid fa-forward"></i></button>
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
                            <tr v-for="(value_hour, index_hour) in hours" style="height: 80px">
                                <td class="align-middle text-center">Buổi @{{ value_hour }}</td>
                                <template v-for="(value, index) in data">
                                    <template v-for="(v, i) in value" v-if="i == index_hour">
                                        <template v-if="v.id" class="text-center align-middle">
                                            <template v-for='(v_ids, k_ids) in v.ids' v-if="v_ids[0] == v.id">
                                                <td v-on:click="updateBuoiLamViec(v.id)"
                                                    class="bg-info"></td>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <td class="text-center align-middle"
                                                v-on:click="themBuoiLamViec(index_hour, index)"></td>
                                        </template>
                                    </template>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6>Lịch Support Công Ty</h6>
                    </div>
                    <div class="col text-end mb-2">
                        <button class="text-center btn btn-danger" v-on:click="type--; loadData()"><i
                                style="padding-left: 5px" class="fa-solid fa-backward"></i></button>
                        <button class="text-center btn btn-primary" v-on:click="type = -1; loadData()"><i
                                style="padding-left: 5px" class="fa-sharp fa-solid fa-house"></i></button>
                        <button class="text-center btn btn-success" v-on:click="type++; loadData()"><i
                                style="padding-left: 6px" class="fa-solid fa-forward"></i></button>
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
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                days: [],
                hours: ['Sáng', 'Chiều', 'Tối', 'Khuya'],
                color: ['white', 'primary', 'warning', 'danger'],
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
                        .get('/admin/dang-ky-support/dang-ky-support-tuan/data/' + this.type)
                        .then((res) => {
                            this.days = res.data.days;
                            this.data = res.data.data;

                            this.loadNhanVien();
                        });
                },
                loadNhanVien() {
                    axios
                        .get('/admin/lich-lam-viec/data-nv')
                        .then((res) => {
                            this.list_nv = res.data.data;
                            // console.log(this.list_nv);
                        });
                },
                updateBuoiLamViec(id) {
                    var payload = {
                        'id'    : id
                    };
                    axios
                        .post('/admin/dang-ky-support/dang-ky-support-tuan/update', payload)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                themBuoiLamViec(buoi_lam_viec, ngay_lam_viec) {
                    const payload = {
                        'buoi_lam_viec': buoi_lam_viec,
                        'ngay_lam_viec': ngay_lam_viec,
                        'is_trang_thai': 1,
                    };

                    axios
                        .post('/admin/dang-ky-support/dang-ky-support-tuan/store', payload)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });

                },
                dataBuoiLamViec(id_buoi_lam_viec) {
                    this.id_buoi_lam_viec = id_buoi_lam_viec;
                    axios
                        .get('/admin/dang-ky-support/buoi-lam/data/' + this.id_buoi_lam_viec)
                        .then((res) => {
                            this.update_buoi_lam = res.data.dataBuoiLamViec,
                                this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
            }
        });
    </script>
@endsection
