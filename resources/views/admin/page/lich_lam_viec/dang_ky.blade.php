@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6 style="width:140px">Lịch Làm Cá Nhân</h6>
                        <select style="width:200px;margin-right:18px;margin-top:10px" class="form-select">
                            <option value="1">Admin</option>
                            <option value="2">Võ Đình Quốc Huy</option>
                            <option value="3">Hoàng Công Trường</option>
                            <option value="4">Nguyễn Văn Phong</option>
                            <option value="5">Phùng Văn Mạnh</option>
                            <option value="6">Phan Minh Tiến</option>
                            <option value="7">Lê Thanh Trường</option>
                        </select>
                    </div>
                    <div style="margin-left:-30px"class="col text-end mb-2">
                        <a class="text-center btn btn-warning text-white" href="/admin/cham-cong"><i
                                class="fa-solid fa-calculator"></i></a>
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
                                                <td v-on:click="updateBuoiLamViec(v.id,v_ids[1])"
                                                    v-bind:class="'bg-' + color[v_ids[1]]"></td>
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
                        <h6>Lịch Làm Công Ty</h6>
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
                                                                        <span v-bind:class="'text-'+ color[v_ids[1]]" v-if="key_nv < list_nv.length - 1"
                                                                            v-on:click="dataBuoiLamViec(v_ids[0])"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#updateNoiDung">@{{ value_nv.ten_goi_nho }},</span>
                                                                        <span v-bind:class="'text-' + color[v_ids[1]]" v-else v-on:click="dataBuoiLamViec(v_ids[0])"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#updateNoiDung">@{{ value_nv.ten_goi_nho }}</span>
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
                                                    <template v-if = "Math.floor(list_nv.length) % 2 == 1">
                                                        <template v-if="key_nv == Math.floor(list_nv.length / 2 )">
                                                            <br>
                                                        </template>
                                                    </template>
                                                    <template v-else = "Math.floor(list_nv.length) % 2 == 1">
                                                        <template v-if="key_nv == Math.floor(list_nv.length / 2 ) - 1">
                                                            <br>
                                                        </template>
                                                    </template>
                                                </template>
                                            <br><span><b>Số lượng làm việc: @{{ v.list[0].length }}</b> </span>
                                        </td>
                                    </template>
                                </template>
                            </tr>
                        </tbody>
                        <div class="modal fade" id="updateNoiDung" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                            style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nội Dung Buổi Làm Việc Của @{{ update_buoi_lam.ho_va_ten }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <label class="form-label">Nội Dung Buổi</label>
                                            <textarea v-model="update_buoi_lam.noi_dung_buoi" class="form-control" placeholder="Nội dung buổi" rows="3">@{{ update_buoi_lam.noi_dung_buoi }}</textarea>
                                        </div>
                                        @php
                                            $quyen = Auth::guard('nhanVien')->user();
                                        @endphp
                                        @if ($quyen->id_quyen == 0)
                                            <div class="col-md-12 mt-3">
                                                <label class="form-label">Đánh Giá</label>
                                                <input v-model="update_buoi_lam.danh_gia" type="number" min="0"
                                                    max="100" class="form-control">
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label class="form-label">Nội Dung Buổi Làm Việc</label>
                                                <textarea v-model="update_buoi_lam.noi_dung_buoi_danh_gia" class="form-control" placeholder="Nội dung buổi"
                                                    rows="3">@{{ update_buoi_lam.noi_dung_buoi_danh_gia }}</textarea>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button v-on:click="updateNoiDungBuoiLam()" type="button"
                                            class="btn btn-primary">Cập Nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                Disabled: false,
            },
            created() {
                this.loadData();
            },
            methods: {
                test(str) {
                    let fifthComma = str.indexOf(',', str.indexOf(',', str.indexOf(',', str.indexOf(',', str
                        .indexOf(',') + 1) + 1) + 1) + 1);
                    let newStr = str.slice(0, fifthComma) + "\n" + str.slice(fifthComma + 1);
                    return newStr;
                },
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
                        .get('/admin/lich-lam-viec/dang-ky/data/' + this.type)
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
                updateBuoiLamViec(id, is_trang_thai) {
                    var dem = is_trang_thai * 1 + 1;
                    // console.log(id,is_trang_thai);
                    var payload = {
                        'id': id,
                        'is_trang_thai': dem,
                    };

                    axios
                        .post('/admin/lich-lam-viec/dang-ky/update', payload)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                themBuoiLamViec(buoi_lam_viec, ngay_lam_viec) {
                    if (!this.Disabled) {
                        this.Disabled = true;
                        const payload = {
                                        'buoi_lam_viec': buoi_lam_viec,
                                        'ngay_lam_viec': ngay_lam_viec,
                                        'is_trang_thai': 1,
                                    };

                                    axios
                                        .post('/admin/lich-lam-viec/dang-ky/store', payload)
                                        .then((res) => {
                                            displaySuccess(res);
                                            this.loadData();
                                        })
                                        .catch((err) => {
                                            displayErrors(err);
                                        });

                        setTimeout(() => {
                            this.Disabled = false;
                        }, 1000);
                    }
                },
                dataBuoiLamViec(id_buoi_lam_viec) {
                    this.id_buoi_lam_viec = id_buoi_lam_viec;
                    axios
                        .get('/admin/lich-lam-viec/buoi-lam/data/' + this.id_buoi_lam_viec)
                        .then((res) => {
                            this.update_buoi_lam = res.data.dataBuoiLamViec,
                                this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                updateNoiDungBuoiLam() {
                    var payload = {
                        'id': this.id_buoi_lam_viec,
                        'noi_dung_buoi': this.update_buoi_lam.noi_dung_buoi,
                        'danh_gia': this.update_buoi_lam.danh_gia,
                        'id_nguoi_danh_gia': this.update_buoi_lam.id_nguoi_danh_gia,
                        'noi_dung_buoi_danh_gia': this.update_buoi_lam.noi_dung_buoi_danh_gia,
                    };

                    axios
                        .post('/admin/lich-lam-viec/buoi-lam/update', payload)
                        .then((res) => {
                            displaySuccess(res);
                            // console.log(res.data.status == 1);
                            if (res.data.status) {
                                $('#updateNoiDung').modal('hide');
                                this.loadData();
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
            }
        });
    </script>
@endsection
