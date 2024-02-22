@extends('hocvien.share.master')
@section('content')
    <div class="row" id="app">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-4">
                        <select class="form-control" v-on:change="getIdLopHoc($event)">
                            <template v-for="(value, key) in list">
                                <option value="">Chọn Lớp Học</option>
                                <option v-bind:value="value.id">@{{value.ten_lop_hoc}}</option>
                            </template>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Các Buổi Học
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle">Buổi Học</th>
                                            <th class="align-middle">Ngày Học</th>
                                            <th class="text-center align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(value, key) in list_buoi_hoc">
                                            <th class="align-middle">@{{ key + 1 }}</th>
                                            <td class="align-middle">Buổi @{{ value.thu_tu_buoi_khoa_hoc}}</td>
                                            <td class="align-middle">@{{ date_format(value.gio_bat_dau) }}</td>
                                            <td style="width: 350px" class="text-center align-middle">
                                                <template v-if="value.tinh_trang == 2">
                                                    <button class="btn btn-success" v-on:click="update = value" data-bs-toggle="modal" data-bs-target="#xinVang">Đã Xin Vắng</button>
                                                    <button class="btn btn-info text-white" disabled >Đánh Giá Buổi Học</button>
                                                </template>
                                                <template v-else>
                                                    <button class="btn btn-primary" v-on:click="update = value" data-bs-toggle="modal" data-bs-target="#xinVang">Xin Vắng</button>
                                                    <button class="btn btn-info text-white" v-on:click="update = value" data-bs-toggle="modal" data-bs-target="#danhGiaBuoiHoc">Đánh Giá Buổi Học</button>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="modal fade" id="xinVang" tabindex="-1" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title  text-white">Lý Do Xin Nghỉ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="">Lý Do Vắng</label>
                                                <textarea v-model="update.ly_do_vang" class="form-control mt-3" placeholder="Nhập lý do xin nghỉ" cols="30" rows="10"></textarea>
                                                <label class="mt-3">Ảnh Minh Chứng</label>
                                                <input class="form-control mt-3" type="file"  multiple="multiple"  v-on:change="getFile($event)">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button v-on:click="xinPhep()" type="button" class="btn btn-primary">Gửi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="danhGiaBuoiHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title  text-white">Đánh Giá Buổi Học</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label">Đánh Giá Buổi Học</label>
                                                <input v-model="update.hoc_vien_danh_gia_buoi_hoc" class="form-control" type="number" placeholder="%" max="100" min="0">
                                                <label class="form-label mt-3">Nội Dung Buổi Học</label>
                                                <textarea class="form-control" v-model="update.noi_dung_danh_gia"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button v-on:click="hocVienDanhGiaBuoiHoc()" type="button" class="btn btn-primary">Gửi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-10">

        </div>
    </div>
@endsection
@section('js')
<script>
    new Vue({
        el: '#app',
        data: {
            list            : [],
            list_buoi_hoc   : [],
            id_buoi_hoc     : 0,
            update          : {},
            id_lop_hoc      : 0,
        },
        created() {
            this.loadLopDangHoc();
            this.danhSachBuoiHoc();
        },
        methods: {
            date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
            },
            loadLopDangHoc() {
                axios
                    .get('/hocVien/don-xin-phep/get-lop-dang-hoc')
                    .then((res) => {
                        this.list = res.data.data;
                        // console.log(this.list);
                    });
            },

            getIdLopHoc(e){
                this.id_lop_hoc = e.target.value;
                this.danhSachBuoiHoc();
            },

            danhSachBuoiHoc() {
                axios
                    .get('/hocVien/don-xin-phep/get-buoi-hoc/' + this.id_lop_hoc)
                    .then((res) => {
                        this.list_buoi_hoc = res.data.data;
                    });
            },

            xinPhep() {
                const payload = new FormData();
                payload.append('id', this.update.id);
                if(this.update.ly_do_vang == undefined) {
                    payload.append('ly_do_vang', '');
                } else {
                    payload.append('ly_do_vang', this.update.ly_do_vang);
                }
                payload.append('anh_minh_chung', this.update.anh_minh_chung);
                axios
                    .post('/hocVien/don-xin-phep/update-ly-do-vang', payload,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },
                        }
                    )
                    .then((res) => {
                        displaySuccess(res);
                        $('#xinVang').modal('hide');
                        this.danhSachBuoiHoc();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            getFile(e)
            {
                this.update.anh_minh_chung = e.target.files[0];
            },
            hocVienDanhGiaBuoiHoc() {
                axios
                    .post('/hocVien/don-xin-phep/update-hoc-vien-danh-gia-buoi-hoc', this.update)
                    .then((res) => {
                        if(res.data.status) {
                            displaySuccess(res);
                            $('#danhGiaBuoiHoc').modal('hide');
                            this.loadLopDangHoc();
                        } else {
                            displaySuccess(res);
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
