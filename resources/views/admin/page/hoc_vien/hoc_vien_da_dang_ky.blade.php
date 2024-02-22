@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col-md-10 mt-2">
                        <h6>Danh Sách Học Viên Đã Đăng Ký</h6>
                    </div>
                    <div class="col-md-2 mt-2 text-end">
                        <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#createHocVien">Thêm mới học
                            viên</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input v-on:keyup.enter="searchHocVien(1)" v-model="search" class="form-control" type="text"
                            name="search" placeholder="Search now...">
                        <button class="btn btn-success input-group-text" v-on:click="searchHocVien(1)">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Lót</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Tên Zalo</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Facebook</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Mô Tả Trình Độ</th>
                                <th class="text-center">Người Giới Thiệu</th>
                                <th class="text-center">Khóa</th>
                                <th class="text-center">Lớp</th>
                                <th class="text-center">IP Dăng Kí</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in list">
                                <tr>
                                    <th class="text-center align-middle">@{{ index + 1 }}</th>
                                    <td class="align-middle">@{{ value.ho_lot }}</td>
                                    <td class="align-middle">@{{ value.ten }}</td>
                                    <td class="align-middle">@{{ value.name_zalo }}</td>
                                    <td class="align-middle">@{{ value.email }}</td>
                                    <td class="text-center align-middle">
                                        <a v-bind:href="value.facebook" target="_blank" class="text-center">
                                            <i class="fa-brands fa-facebook fa-3x" style="padding: 10px"></i>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">@{{ value.so_dien_thoai }}</td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="modal = value" data-bs-toggle="modal"
                                            data-bs-target="#moTaTrinhDoModal" class="btn btn-primary"><i
                                                style="padding-left: 6px" class="fa-solid fa-info"></i></button>
                                    </td>
                                    <td class="align-middle text-wrap">@{{ value.nguoi_gioi_thieu }}</td>
                                    <td class="text-center align-middle">@{{ value.list_khoa }}</td>
                                    <td class="text-center align-middle">@{{ value.list_lop }}</td>
                                    <td class="text-center align-middle">
                                        <i class="fa-solid fa-location-dot fa-2x text-danger" v-on:click="modal = value" data-bs-toggle="modal"
                                        data-bs-target="#ipModal"></i>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="edit = Object.assign({}, value); loadLopHoc(); loadKhoaHoc()"
                                            data-bs-toggle="modal" data-bs-target="#editHocVien" class="btn btn-primary"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                style="padding-left: 4px" class="fa-solid fa-pen"></i></button>
                                        <button v-on:click="destroy = value" data-bs-toggle="modal"
                                            data-bs-target="#deleteHocVien" class="btn btn-danger" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i style="padding-left: 4px"
                                                class="fa-solid fa-trash"></i></button>
                                        <button class="btn btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#addHocVienModel" v-on:click="loadDuLieuKhoaDangKi(value)"><i
                                                class="fa-solid fa-plus"></i>Add</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <div class="modal fade" id="moTaTrinhDoModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Mô Tả Trình Độ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @{{ modal.mo_ta_trinh_do }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ip --}}
                    <div class="modal fade" id="ipModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Danh Sách Địa Chỉ IP Đăng Kí</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tr class="text-center" v-for="(value, key) in modal.ip_dang_ki">
                                           <th>@{{ key + 1 }}</th>
                                           <th>@{{ value }}</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteHocVien" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xoá Học Viên</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Ban chắc chắn là sẽ xoá học viên <b class="text-danger">@{{ destroy.ho_va_ten }}</b>
                                    này!<br>
                                    <b>Lưu ý: Hành động này không thể khôi phục!</b>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="deleteHocVien()" type="button" class="btn btn-primary">Xoá Học
                                        Viên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editHocVien" tabindex="-1" aria-hidden="true" style="display: none;"  >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập Nhật Học Viên</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" v-model="edit.id">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input type="text" v-model="edit.ho_va_ten" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Tên</label>
                                            <input type="text" v-model="edit.ten" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">Tên Zalo</label>
                                            <input type="text" v-model="edit.name_zalo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="email" v-model="edit.email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="form-group">
                                            <label class="form-label">Tài Khoản FB</label>
                                            <input type="text" v-model="edit.facebook" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="form-group">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input type="tel" v-model="edit.so_dien_thoai"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="form-group">
                                            <label class="form-label">Người Giới Thiệu</label>
                                            <select class="form-select" v-model="edit.nguoi_gioi_thieu">
                                                <template v-for="(value, index) in list_nhanvien">
                                                    <option v-bind:value="value.ho_va_ten">@{{ value.ho_va_ten }}
                                                    </option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3" style="width: 465px; margin-left: 2px; margin-bottom: -12px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Lớp</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="key in (edit.list_lop?.split(','))?.length">
                                                    <tr>
                                                        <th>
                                                            <select class="form-select" v-bind:id="'lop_hoc_' + key">
                                                                <template v-for="(value, index) in list_lop_hoc">
                                                                    <option v-if="edit.list_lop?.split(',')[key - 1] == value.ten_lop_hoc" selected v-bind:value="value.id">@{{ value.ten_lop_hoc }}</option>
                                                                    <option v-else v-bind:value="value.id">@{{ value.ten_lop_hoc }}</option>
                                                                </template>
                                                            </select>
                                                        </th>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                        {{-- <div class="col">
                                            <div class="form-group">
                                                <label class="form-label">Khóa Học</label>
                                                <select class="form-select" v-model="edit.id_khoa_hoc">
                                                    <template v-for="(value, index) in list_khoa_hoc">
                                                        <option v-bind:value="value.id">@{{ value.ten_khoa_hoc }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col">
                                            <div class="form-group">
                                                <label class="form-label">Người Giới Thiệu</label>
                                                <select class="form-select" v-model="edit.nguoi_gioi_thieu">
                                                    <template v-for="(value, index) in list_nhanvien">
                                                        <option v-bind:value="value.ho_va_ten">@{{ value.ho_va_ten }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button v-on:click="updateHocVien()" type="button" class="btn btn-primary">Cập Nhật
                                        Học Viên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="createHocVien" tabindex="-1" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm Mới Khoá Học</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input v-model="add.ho_va_ten" class="form-control"
                                                placeholder="Nhập họ và tên">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input v-model="add.email" class="form-control"
                                                placeholder="Nhập email cá nhân">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Link Facebook cá nhân</label>
                                            <input v-model="add.facebook" type="text" class="form-control"
                                                placeholder="Link facebook cá nhân ">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input v-model="add.so_dien_thoai" type="tel" class="form-control"
                                                placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label">Mô Tả Trình Độ</label>
                                            <textarea v-model="add.mo_ta_trinh_do" class="form-control" placeholder="Mô tả về trình độ của bản thân"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Người Giới Thiệu</label>
                                            <select v-model="add.nguoi_gioi_thieu" class="form-select">
                                                <option value="">Người giới thiệu...</option>
                                                @foreach ($nhanVien as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->ho_va_ten }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Chọn Khóa Học</label>
                                            <select v-model="add.id_lop_dang_ky" class="form-select">
                                                <option value="">Khóa học...</option>
                                                @foreach ($lopDangKy as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->ten_lop_hoc }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button v-on:click="ThemMoi()" type="button" class="btn btn-primary">Thêm
                                        Mới</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Add hocj viên vào lớp --}}
                    <div class="modal fade" id="addHocVienModel" tabindex="-1" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Danh Sách Khóa Đăng Kí</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead class="text-center align-middle">
                                            <th>STT</th>
                                            <th>Tên Lớp</th>
                                            <th>Tên Khóa</th>
                                            <th>Tình Trạng</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center align-middle"
                                                v-for="(value, index) in list_thong_tin_lop_dang_ki">
                                                <th>@{{ index + 1 }}</th>
                                                <td>@{{ value.ten_lop_hoc }}</td>
                                                <td>@{{ value.ten_khoa_hoc }}</td>
                                                <td>
                                                    <button v-if="value.check_add == false"
                                                        class="btn btn-success text-center">Đã vào lớp</button>
                                                    <button v-else class="btn btn-primary text-center">Chưa Vào
                                                        Lớp</button>
                                                </td>
                                                <td>
                                                    <button v-if="value.check_add" class="btn btn-primary text-center"
                                                        v-on:click="addToClass(value.id_hoc_vien, value.id, value)"><i
                                                            class="fa-regular fa-square-plus"
                                                            style="padding-left: 5px"></i></button>
                                                    <button v-else class="btn btn-primary text-center" disabled><i
                                                            class="fa-regular fa-square-plus"
                                                            style="padding-left: 5px"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="m-b-30" aria-label="Page navigation example">
                    <ul class="pagination justify-content-end pagination-primary">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" aria-label="Previous"
                                @click.prevent="changePage(pagination.current_page - 1)">
                                <span aria-hidden="true">Pre</span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']"
                            class="page-item">
                            <a class="page-link" href="javascript:void(0)"
                                @click.prevent="changePage(page)">@{{ page }}</a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a href="javascript:void(0)" class="page-link" aria-label="Next"
                                @click.prevent="changePage(pagination.current_page + 1)">
                                <span aria-hidden="true">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list: [],
                list_khoa_hoc: [],
                list_lop_hoc: [],
                list_thong_tin_lop_dang_ki: [],
                modal: {},
                destroy: {},
                list_nhanvien: [],
                edit: {},
                add: {},
                search: '',
                edit_lop_hoc: [],

                pagination: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
            },
            created() {
                this.loadLopHoc();
                this.loadData(this.pagination.current_page);
            },
            computed: {
                isActived: function() {
                    return this.pagination.current_page;
                },
                pagesNumber: function() {
                    if (!this.pagination.to) {
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
                    if (to >= this.pagination.last_page) {
                        to = this.pagination.last_page;
                    }
                    var pagesArray = [];
                    while (from <= to) {
                        pagesArray.push(from);
                        from++;
                    }
                    return pagesArray;
                }
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
                loadData: function(page) {
                    axios
                        .get('/admin/hoc-vien/data?page=' + page)
                        .then((res) => {
                            this.list = res.data.data.data.data;
                            this.list_nhanvien = res.data.data.data_nhanvien;
                            this.pagination = res.data.data.pagination;
                        });
                },
                changePage: function(page) {
                    this.pagination.current_page = page;
                    if (this.search == '') {
                        this.loadData(page);
                    } else {
                        this.searchHocVien(page);
                    }
                },

                loadLopHoc() {
                    axios
                        .get('/admin/lop-hoc/data')
                        .then((res) => {
                            this.list_lop_hoc = res.data.data;
                            // console.log(this.list_lop_hoc);
                        });
                },
                loadKhoaHoc() {
                    axios
                        .get('/admin/khoa-hoc/data')
                        .then((res) => {
                            this.list_khoa_hoc = res.data.data;
                        });
                },
                updateHocVien() {
                    var so_luong = this.edit.list_lop?.split(',');
                    this.edit.id_lop_dang_ky = '';
                    for(var i = 1 ; i <= so_luong.length ; i++) {
                        var lop_hoc = 'lop_hoc_' + i;
                        this.edit.id_lop_dang_ky += $("#" + lop_hoc).val() + ',';
                    }
                    this.edit.id_lop_dang_ky = this.edit.id_lop_dang_ky?.slice(0, -1);

                    axios
                        .post('/admin/hoc-vien/update', this.edit)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                            $('#editHocVien').modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                deleteHocVien() {
                    axios
                        .post('/admin/hoc-vien/delete', this.destroy)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                            $('#deleteHocVien').modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                addToClass(id_hoc_vien, id_lop_hoc, value) {
                    var payload = {
                        'id_hoc_vien': id_hoc_vien,
                        'id_lop_hoc': id_lop_hoc
                    };
                    axios
                        .post('/admin/hoc-vien/add-to-class', payload)
                        .then((res) => {
                            if (res.data.status) {
                                displaySuccess(res);
                                this.loadDuLieuKhoaDangKi(value)
                            } else {
                                displayErrors(res);
                                // toastr.error("Học viên đã tồn tại!");
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                ThemMoi() {
                    axios
                        .post('/dang-ky-khoa-hoc/create', this.add)
                        .then((res) => {
                            displaySuccess(res);
                            $('#createHocVien').modal('hide')
                            this.loadData();
                            this.add = {};
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                searchHocVien: function(page) {
                    var payload = {
                        'search': this.search,
                    }
                    axios
                        .post('/admin/hoc-vien/search?page=' + page, payload)
                        .then((res) => {
                            displaySuccess(res);
                            this.list = res.data.data.data.data;
                            this.list_nhanvien = res.data.data.data_nhanvien;
                            this.pagination = res.data.data.pagination;
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                loadDuLieuKhoaDangKi(value) {
                    var payload = {
                        'id_hoc_vien': value.id,
                        'list_lop': value.id_lop_dang_ky,
                    };
                    axios
                        .post('/admin/hoc-vien/lay-thong-tin-lop-dang-ki', payload)
                        .then((res) => {
                            this.list_thong_tin_lop_dang_ki = res.data.data;
                            // console.log(this.loadDuLieuKhoaDangKi);
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
            }
        });
    </script>
@endsection
