@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="mt-2">
                        <select class="form-select digits" v-model="check" name="id_lop_hoc" v-on:change="getIDLopHoc($event)">
                            <option value="0">Chọn lớp học đã kết thúc...</option>
                            <template v-for="(value, index) in danhSachLop" v-if="value.is_done == 1">
                                <option v-bind:value="value.id">@{{ value.ten_lop_hoc }}</option>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="row mt-2"  v-if="check != 0 ">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input v-on:keyup.enter="searchHocVien()" v-model="search" class="form-control" type="text"
                                name="search" placeholder="Search now...">
                            <button class="btn btn-success input-group-text" v-on:click="searchHocVien()">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Và Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Tên Zalo</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Khóa Học</th>
                                <th class="text-center">Facehook</th>
                                <th class="text-center">TeamView/UltraView</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in danhSachHocVien">
                                <tr>
                                    <th class="">@{{ index + 1 }}</th>
                                    <td class="">@{{ value.ho_va_ten }}</td>
                                    <td class="">@{{ value.email }}</td>
                                    <td class="">@{{ value.name_zalo }}</td>
                                    <td class="text-center align-middle">
                                        <a v-on:click="changeStatusZalo(value.id)" v-if="value.is_add_zalo == 0"
                                            class="btn btn-danger">@{{ value.so_dien_thoai }}</a>
                                        <a v-on:click="changeStatusZalo(value.id)" v-else
                                            class="btn btn-info">@{{ value.so_dien_thoai }}</a>
                                    </td>
                                    <td class="text-center align-middle">@{{ value.ten_khoa_hoc }}</td>
                                    <td class="text-center align-middle">
                                        <a v-bind:href="value.facebook" target="_blank" class="btn btn-primary">LinkFB</a>
                                        <button v-on:click="changeStatus(value.id)" class="btn btn-danger"
                                            v-if="value.is_add_fb == 0">Chưa Add</button>
                                        <button v-on:click="changeStatus(value.id)" class="btn btn-info" v-else>Đã
                                            Add</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="updateTeamView = value" class="btn btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#TeamViewModel">Add
                                            TeamView/UtraView</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#supportModal"
                                            v-on:click="hienThiThongTinHocVien(value.id_hoc_vien)">Support</button>
                                        <button class="btn btn-danger" v-on:click="deleteHV = value" data-bs-toggle="modal"
                                            data-bs-target="#deleteHocVien">Xóa Học Viên</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <div class="modal fade" id="supportModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Support Học Viên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    Thông Tin Support
                                                </div>
                                                <div class="card-body">
                                                    <div class="col mt-2">
                                                        <label class="form-label">TeamView/UltraView</label>
                                                        <input v-bind:value="thongTinHocVien.danh_sach_teamview"
                                                            type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col mt-2">
                                                        <label class="form-label">Kiểm Tra Thông Tin Teamview</label>
                                                        <select v-model="support.is_dung_teamview" class="form-select">
                                                            <option value="1">Đúng Thông Tin</option>
                                                            <option value="0">Sai Thông Tin</option>
                                                        </select>
                                                    </div>
                                                    <div class="col mt-2">
                                                        <label class="form-label">Nơi Support</label>
                                                        <select v-model="support.noi_nhan_support" class="form-select">
                                                            <option value="0">Từ Group Facebook</option>
                                                            <option value="1">Từ Group Zalo</option>
                                                            <option value="2">Từ Inbox Facebook</option>
                                                            <option value="3">Từ Inbox Zalo</option>
                                                            <option value="4">Từ Học Viên Cũ</option>
                                                        </select>
                                                    </div>
                                                    <div class="col mt-2">
                                                        <label class="form-label">Nội Dung Support</label>
                                                        <textarea  v-model="support.noi_dung_support" class="form-control" cols="5" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button v-on:click="themMoiThongTinSupport()" type="button"
                                                        class="btn btn-primary">Đã Support</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    Nội Dung Support
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-drop">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Tên Người Support</th>
                                                                    <th class="text-center">Teamview</th>
                                                                    <th class="text-center">Nơi Nhận Support</th>
                                                                    <th class="text-center">Ngày Support</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(value, index) in danhSachDaSp"
                                                                    :key="index">
                                                                    <th class="text-center align-middle">
                                                                        @{{ index + 1 }}</th>
                                                                    <td class="align-middle">@{{ value.ho_va_ten }}</td>
                                                                    <td class="text-center align-middle">
                                                                        <button style="width: 75px;"
                                                                            v-if="value.is_dung_teamview"
                                                                            class="btn btn-primary">Đúng</button>
                                                                        <button style="width: 75px;" v-else
                                                                            class="btn btn-danger">Sai TT </button>
                                                                    </td>
                                                                    <td class="align-middle">@{{ noiNhanSupport[value.noi_nhan_support] }}</td>
                                                                    <td class="align-middle text-center">@{{ date_format(value.created_at)}}</td>
                                                                    <td class="align-middle">
                                                                        <button class="btn btn-danger"v-on:click="deleteNoiDung(value)" >Xóa</button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Thoát</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteHocVien" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Xóa Học Viên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6> Bạn có chắc chắn xóa học viên <b> @{{ deleteHV.ho_va_ten }} </b></h6><br>
                                    <h6>của lớp @{{ deleteHV.ten_lop_hoc }}</h6>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" v-on:click="deleteHocVien()" class="btn btn-primary">Đồng
                                        ý</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="TeamViewModel" tabindex="-1" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">TeamView / UltraView Học Viên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Nhập TeamView / UltraView Học Viên</label>
                                    <input type="text" class="form-control mt-3"
                                        v-model="updateTeamView.danh_sach_teamview">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" v-on:click="update_teamview_ultraview()"
                                        class="btn btn-primary">Đồng ý</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
            danhSachLop: [],
            danhSachHocVien: [],
            id_lop_hoc: 0,
            thongTinHocVien: {},
            support: {},
            deleteHV: {},
            updateTeamView: {},
            danhSachDaSp: [],
            noiNhanSupport: ['Group Facebook', 'Group Zalo', 'Inbox Facebook', 'Inbox Zalo', 'Học Viên Cũ'],
            search : '',
            check : 0,
        },
        created() {
            this.dataDanhSachLop();
            this.LoadSupport();
        },
        methods: {
            searchHocVien() {
                var payload = {
                    'search': this.search,
                    'id_lop_hoc': this.id_lop_hoc,

                }

                axios
                    .post('/admin/lop-dang-day/search/', payload)
                    .then((res) => {
                        displaySuccess(res);
                        this.danhSachHocVien = res.data.data;

                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
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

            dataDanhSachLop() {
                axios
                    .get('/admin/lop-dang-day/danh-sach-lop')
                    .then((res) => {
                        this.danhSachLop = res.data.danhSachLop;
                        // console.log(this.danhSachLop);
                    });
            },

            getIDLopHoc(e) {
                this.id_lop_hoc = e.target.value;
                this.getDanhSachHocVienLop();
            },

            getDanhSachHocVienLop() {
                axios
                    .get('/admin/lop-dang-day/danh-sach-lop/' + this.id_lop_hoc)
                    .then((res) => {
                        this.danhSachHocVien = res.data.data;
                        // console.log(this.danhSachHocVien);
                    });
            },

            async hienThiThongTinHocVien(id) {
                // console.log(id);
                await axios
                    .get('/admin/hoc-vien/thong-tin/' + id)
                    .then((res) => {
                        this.thongTinHocVien = res.data.data;
                        this.support.id_hoc_vien = res.data.data.id;
                        this.support.id_lop_hoc = id;
                    });

                await axios
                    .post('/admin/support-hoc-vien/thong-tin-da-support', this.support)
                    .then((res) => {
                        this.danhSachDaSp = res.data.data;
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            LoadSupport(){
                axios
                    .post('/admin/support-hoc-vien/thong-tin-da-support', this.support)
                    .then((res) => {
                        this.danhSachDaSp = res.data.data;
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            themMoiThongTinSupport() {
                this.support.danh_sach_teamview = this.thongTinHocVien.danh_sach_teamview;
                axios
                    .post('/admin/support-hoc-vien/create', this.support)
                    .then((res) => {
                        displaySuccess(res);
                        // $('#supportModal').modal('hide');
                        this.hienThiThongTinHocVien(this.support.id_lop_hoc);
                        this.support = {};

                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            changeStatus(id) {
                axios
                    .get('/admin/lop-dang-day/change-status/' + id)
                    .then((res) => {
                        toastr.success('Đã đổi trạng thái thành công!');
                        this.getDanhSachHocVienLop();
                    });
            },
            changeStatusZalo(id) {
                axios
                    .get('/admin/lop-dang-day/change-status-zalo/' + id)
                    .then((res) => {
                        toastr.success('Đã đổi trạng thái thành công!');
                        this.getDanhSachHocVienLop();
                    });
            },
            deleteHocVien() {
                axios
                    .post('/admin/lop-dang-day/delete-hoc-vien', this.deleteHV)
                    .then((res) => {
                        toastr.success('Đã xóa học viên thành công!');
                        $('#deleteHocVien').modal('hide');
                        this.getDanhSachHocVienLop();
                    });
            },
            update_teamview_ultraview() {
                var teamview = this.updateTeamView.danh_sach_teamview;
                var id_hoc_vien = this.updateTeamView.id_hoc_vien;
                var payload = {
                    danh_sach_teamview: teamview,
                    id: id_hoc_vien
                };
                axios
                    .post('/admin/lop-dang-day/update-teamview-ultraview-hoc-vien', payload)
                    .then((res) => {
                        displaySuccess(res);
                        $('#TeamViewModel').modal('hide');
                        // this.getDanhSachHocVienLop();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            deleteNoiDung(value) {
                axios
                    .post('/admin/support-hoc-vien/delete', value)
                    .then((res) => {
                        displaySuccess(res);
                        this.LoadSupport();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
        }
    });
</script>
@endsection
