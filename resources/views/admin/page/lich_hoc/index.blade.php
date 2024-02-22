@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="card border-primary border-bottom border-3 border-0">
        <div class="card-header mt-3 mb-3">
            <div class="row">
                <div class="col mt-2">
                    <h6>Danh Sách Học Viên</h6>
                </div>
                <div class="col text-end mb-2">
                    <button class="btn btn-success" v-on:click="shareVideo()">SHARE VIDEO</button>
                    <div class="btn-group">
                        <button style="width: 150px;" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" aria-expanded="false">
                           Chọn
                        </button>
                        <ul class="dropdown-menu">
                            {{-- <li><a class="dropdown-item">SHARE VIDEO</a></li> --}}
                            <li><a class="dropdown-item" v-on:click="AllHocVien()">TẤT CẢ HỌC VIÊN</a></li>
                            <li><a class="dropdown-item" v-on:click="baiTap()">HV Chưa Làm BT</a></li>
                            <li><a class="dropdown-item" v-on:click="checkDiHoc()">CHECK ĐI HỌC</a></li>
                            <li><a class="dropdown-item" v-on:click="checkVangPhep()">CHECK VẮNG PHÉP</a></li>
                            <li><a class="dropdown-item" v-on:click="checkVangKhong()">CHECK VĂNG KHÔNG PHÉP</a></li>
                        </ul>
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
                            <th class="text-center">Họ lót</th>
                            <th class="text-center">Tên</th>
                            <th class="text-center">Tình trạng</th>
                            <th class="text-center">Lý do vắng</th>
                            <th class="text-center">Ảnh Minh Chứng</th>
                            <th class="text-center">Nhân viên đánh giá</th>
                            <th class="text-center">Học viên đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(value, index) in list">
                            {{-- <template v-if="addDay(value.start) == true"> --}}
                                <tr>
                                    <th class="text-center align-middle">
                                        <input class="form-check-input" name="checkbox" type="checkbox" v-model="value.is_share" v-on:click="updateShareVideo(value)">
                                    </th>
                                    <td class="align-middle">@{{ value.ho_lot }}</td>
                                    <td class="align-middle">@{{ value.ten }}</td>
                                    <td class="align-middle text-center">
                                        {{-- <div class="form-check form-check-inline">
                                            <input class="'form-check-input'" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio1' + value.id" v-bind:value="0" v-on:click="diemDanh(value.id , $event)">
                                            <label class="form-check-label" v-bind:for="'inlineRadio1' + value.id" v-on:click="diemDanh(value.id , $event)">Chưa Điểm Danh</label>
                                        </div> --}}
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio2' + value.id" v-bind:value="1"  v-on:click="diemDanh(value.id , $event)">
                                            <label class="form-check-label" v-bind:for="'inlineRadio2' + value.id" v-on:click="diemDanh(value.id , $event)">Đi Học</label>
                                        </div>
                                        {{-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio3' + value.id" v-bind:value="2" data-bs-toggle="modal" data-bs-target="#vangCoPhep" v-on:click="edit = Object.assign({}, value)">
                                            <label class="form-check-label" v-bind:for="'inlineRadio3' + value.id"  data-bs-toggle="modal" data-bs-target="#vangCoPhep" v-on:click="edit = Object.assign({}, value)">Vắng Có Phép</label>
                                        </div> --}}
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio4' + value.id" v-bind:value="3"  v-on:click="diemDanh(value.id , $event)">
                                            <label class="form-check-label" v-bind:for="'inlineRadio4' + value.id" v-on:click="diemDanh(value.id , $event)">Vắng</label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @{{ value.ly_do_vang }}
                                    </td>
                                    <td>
                                        <template v-if="value.anh_minh_chung">
                                            <button class="btn btn-primary" style="width: 100%;" v-on:click="edit = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#anhMinhChung">Ảnh Minh Chứng</button>
                                        </template>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" style="width: 100%;" v-on:click="edit = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#nhanVienDanhGia">@{{ danhGia(value.danh_gia_bai_tap) }}</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" style="width: 100%;" v-on:click="edit = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#hocVienDanhGia" disabled>@{{ danhGia(value.hoc_vien_danh_gia_buoi_hoc) }}</button>
                                    </td>
                                </tr>
                            {{-- </template> --}}
                            {{-- <template v-else>
                                <tr>
                                    <th class="text-center align-middle">
                                        <input class="form-check-input" name="checkbox" type="checkbox" v-model="value.is_share" v-on:click="updateShareVideo(value)">
                                    </th>
                                    <td class="align-middle">@{{ value.ho_va_ten }}</td>
                                    <td class="align-middle">
                                        <div class="form-check form-check-inline">
                                            <input class="'form-check-input'" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio1' + value.id" v-bind:value="0" disabled>
                                            <label class="form-check-label" v-bind:for="'inlineRadio1' + value.id" disabled>Chưa Điểm Danh</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio2' + value.id" v-bind:value="1"  disabled>
                                            <label class="form-check-label" v-bind:for="'inlineRadio2' + value.id" disabled>Đi Học</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio3' + value.id" v-bind:value="2" data-bs-toggle="modal" data-bs-target="#vangCoPhep" disabled>
                                            <label class="form-check-label" v-bind:for="'inlineRadio3' + value.id"  data-bs-toggle="modal" data-bs-target="#vangCoPhep" disabled>Vắng Có Phép</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" v-model="value.tinh_trang" type="radio" v-bind:name="index" v-bind:id="'inlineRadio4' + value.id" v-bind:value="3"  disabled>
                                            <label class="form-check-label" v-bind:for="'inlineRadio4' + value.id" disabled>Vắng Không Phép</label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @{{ value.ly_do_vang }}
                                    </td>
                                    <td>
                                        <template v-if="value.anh_minh_chung">
                                            <button class="btn btn-primary" style="width: 100%;" v-on:click="edit = value" data-bs-toggle="modal" data-bs-target="#anhMinhChung">Ảnh Minh Chứng</button>
                                        </template>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" style="width: 100%;" v-on:click="edit = value" data-bs-toggle="modal" data-bs-target="#nhanVienDanhGia">@{{ danhGia(value.danh_gia_bai_tap) }}</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" style="width: 100%;" disabled>@{{ danhGia(value.hoc_vien_danh_gia_buoi_hoc) }}</button>
                                    </td>
                                </tr>
                            </template> --}}
                        </template>
                    </tbody>
                    <div class="modal fade" id="vangCoPhep" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Vắng Có Phép</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col">
                                        <label class="form-label">Lý do vắng</label>
                                        <textarea v-model="edit.ly_do_vang" class="form-control" placeholder="lý do vắng học" name="" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateLyDoVang()">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="nhanVienDanhGia" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Nhân Viên Đánh Giá</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col">
                                        <label class="form-label">Đánh Giá Học Viên</label>
                                        <input v-model="edit.danh_gia_bai_tap" type="number" min="10" max="100" class="form-control" placeholder="%" v-on:keyup.enter="updateNhanVienDanhGia()">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateNhanVienDanhGia()" >Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="anhMinhChung" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ảnh Minh Chứng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col">
                                        <img v-bind:src="edit.anh_minh_chung" alt="" width="470px" height="600px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </div>
            <div style="font-size: 15px">
                <b>Tỷ Số:</b> @{{count}}/@{{so_luong}}
            </div>
        </div>
        <div class="card-footer">
            <div class="table-responsive">
                <table class="table table-bordered table-drop">
                    <tr>
                        <th style="width: 100px" class="align-middle">
                            <span v-on:click="copyEmails('all')">Tất cả học viên</span>
                        </th>
                        <td id="all">
                            <template v-for="(value, key) in list">
                                <span v-if="key < list.length - 1">@{{value.email}},</span>
                                <span v-else >@{{value.email}}</span>
                                <template v-if="key == Math.floor(list.length / 2 ) - 1">
                                    <br>
                                </template>
                            </template>
                        </td>
                    </tr>
                    <tr>
                        <th v-on:click="copyEmails('di_hoc')" style="width: 100px" class="align-middle">Học viên đi học</th>
                        <td id="di_hoc">
                            <template v-for="(value, key) in list">
                                <template v-if="value.tinh_trang == 1">
                                    <span  v-if="key < list.length - 1">@{{value.email}},</span>
                                    <span  v-else >@{{value.email}}</span>
                                    <template v-if="key == Math.floor(list.length / 2 ) - 1">
                                        <br>
                                    </template>
                                </template>
                            </template>
                        </td>
                    </tr>
                    <tr>
                        <th v-on:click="copyEmails('vang_hoc')" style="width: 100px" class="align-middle">Học viên vắng</th>
                        <td id="vang_hoc">
                            <template v-for="(value, key) in list">
                                <template v-if="value.tinh_trang == 3">
                                    <span  v-if="key < list.length - 1">@{{value.email}},</span>
                                    <span  v-else >@{{value.email}}</span>
                                    <template v-if="key == Math.floor(list.length / 2 ) - 1">
                                        <br>
                                    </template>
                                </template>
                            </template>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    new Vue({
        el      :  '#app',
        data    :  {
            list        :   [],
            edit        :   {},
            destroy     :   {},
            count       :   [],
            so_luong    :   [],
        },
        created() {
            this.id_lop_hoc = window.trimSlash(window.location.pathname).substring(15);
            this.loadData();
        },
        methods :   {
            copyEmails(type) {
                var tdContent = document.getElementById(type).innerText;
                var inp = document.createElement('input');
                document.body.appendChild(inp);
                inp.value = tdContent;
                inp.select();
                document.execCommand('copy', false);
                inp.remove();
            },
            addDay(date) {
                var now  = new moment();
                var day = moment(date).add(2, 'days');
                // console.log(new moment().format('DD/MM/yyyy'));
                // console.log(day >= now);
                return day >= now;
            },
            loadSoLuongHocVien() {
                axios
                    .get('/admin/lich-hoc/data/' + this.id_lop_hoc)
                    .then((res) => {
                        this.count      = res.data.count;
                        this.so_luong   = this.list.length;
                    });
            },
            loadData() {
                axios
                    .get('/admin/lich-hoc/data/' + this.id_lop_hoc)
                    .then((res) => {
                        this.list       = res.data.data;
                        this.count      = res.data.count;
                        this.so_luong   = this.list.length;
                    });
            },
            danhGia(v) {
                return v == null ? "Chưa đánh giá" : v;
            },
            diemDanh(id, e) {
                var tinh_trang = e.target.value;
                const payload = {
                    'id'              : id,
                    'tinh_trang'      : tinh_trang,
                };
                axios
                    .post('/admin/lich-hoc/diem-danh', payload)
                    .then((res) => {
                        this.loadSoLuongHocVien();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });

            },
            updateNhanVienDanhGia() {
                axios
                    .post('/admin/lich-hoc/update-nhan-vien-danh-gia', this.edit)
                    .then((res) => {
                        if(res.data.status) {
                            displaySuccess(res);
                            $('#nhanVienDanhGia').modal('hide');
                            this.baiTap();
                        } else {
                            displaySuccess(res);
                        }
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            updateHocVienDanhGia() {
                axios
                    .post('/admin/lich-hoc/update-hoc-vien-danh-gia', this.edit)
                        .then((res) => {
                            if(res.data.status) {
                                displaySuccess(res);
                                $('#hocVienDanhGia').modal('hide');
                                this.loadData();
                            } else {
                                displaySuccess(res);
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
            },
            updateLyDoVang() {
                this.edit.tinh_trang = 2;
                axios
                    .post('/admin/lich-hoc/update-ly-do-vang', this.edit)
                        .then((res) => {
                            if(res.data.status) {
                                displaySuccess(res);
                                $('#vangCoPhep').modal('hide');
                                this.loadData();
                            } else {
                                displaySuccess(res);
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
            },
            updateShareVideo(v) {
                axios
                    .post('/admin/lich-hoc/update-share-video', v)
                        .then((res) => {
                            if(res.data.status) {
                                // displaySuccess(res);
                                // this.loadData();
                            } else {
                                displaySuccess(res);
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
            },
            // turnOffAll() {
            //     axios
            //     .get('/admin/lich-hoc/data/' + this.id_lop_hoc)
            //     .then((res) => {
            //         var checkboxes = $("input[name='checkbox']");
            //         for (var i = 0; i < checkboxes.length; i++){
            //             checkboxes[i].checked = false;
            //         }
            //     });
            // },
            // checkAll() {
            //     axios
            //     .get('/admin/lich-hoc/data/' + this.id_lop_hoc)
            //     .then((res) => {
            //         var checkboxes = $("input[name='checkbox']");
            //         for (var i = 0; i < checkboxes.length; i++){
            //             checkboxes[i].checked = true;
            //         }
            //     });
            // },
            AllHocVien() {
                this.loadData();
            },
            checkDiHoc() {
                // console.log(this.id_lop_hoc);
                axios
                    .get('/admin/lich-hoc/data/di-hoc/' + this.id_lop_hoc)
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },
            checkVangPhep() {
                axios
                    .get('/admin/lich-hoc/data/vang-phep/' + this.id_lop_hoc)
                    .then((res) => {
                        this.list = res.data.data;
                        // var checkboxes = $("input[name='checkbox']");
                        // console.log(checkboxes);
                        // for (var i = 0; i < checkboxes.length; i++) {
                        //     checkboxes[i].value == 2 ? checkboxes[i].checked = true : checkboxes[i].checked = false;
                        // }
                    });
            },
            checkVangKhong() {
                axios
                    .get('/admin/lich-hoc/data/vang-khong/' + this.id_lop_hoc)
                    .then((res) => {
                        this.list = res.data.data;
                        // var checkboxes = $("input[name='checkbox']");
                        // console.log(checkboxes);
                        // for (var i = 0; i < checkboxes.length; i++) {
                        //     checkboxes[i].value == 3 ? checkboxes[i].checked = true : checkboxes[i].checked = false;
                        // }
                    });
            },
            shareVideo() {
                axios
                    .post('/admin/lich-hoc/share-video', this.list)
                    .then((res) => {
                        displaySuccess(res);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            baiTap() {
                axios
                    .get('/admin/lich-hoc/data/chua-lam-bt/' + this.id_lop_hoc)
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },
        }
    });
</script>
@endsection
