@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6>Danh Sách Buổi</h6>
                        <p>{{ $tenLopHoc }}</p>
                    </div>
                    <div class="col text-end mb-2">
                        {{-- <div class="btn-group" >
                            @for ($i = 1 ; $i <= $so_thang_hoc ; $i++)
                                <a style="margin-left: 5px" class="btn btn-primary" href="/admin/tong-ket-thang/{{$id_lop_hoc}}/{{$i}}/{{$so_buoi_hoc}}/{{$so_thang_hoc}}" target="_blank">Tháng {{$i}}</a>
                            @endfor
                        </div> --}}
                        <a class="btn btn-primary" v-bind:href="'/admin/tong-ket-thang/' + id_lop_hoc" target="_blank">Tổng Kết Tháng</a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBuoiHoc">Thêm Mới</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                {{-- <th class="text-center">#</th> --}}
                                <th class="text-center">Buổi</th>
                                <th class="text-center">Giờ Bắt Đầu</th>
                                <th class="text-center">Giờ Kết Thúc</th>
                                <th class="text-center">Link Video</th>
                                <th class="text-center">Link Notepad</th>
                                <th class="text-center">Bài Tập</th>
                                <th class="text-center">Giáo Viên</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in list">
                                {{-- in màu ngày hiện tại --}}
                                <tr v-if="isToday(value.start) == true" style="background-color: #72dff2" >
                                    <th class="text-center align-middle">@{{ value.thu_tu_buoi_khoa_hoc }}</th>
                                    <td class="text-center align-middle">@{{ value.bat_dau }}</td>
                                    <td class="text-center align-middle">@{{ value.ket_thuc }}</td>
                                    <td class="text-center align-middle">@{{ value.link_video }}</td>
                                    <td class="text-center align-middle">@{{ value.link_notepad }}</td>
                                    <td class="text-center align-middle">@{{ value.is_bai_tap == 0 ? 'Không' : 'Có' }}</td>
                                    <td class="text-center align-middle">@{{ value.ho_va_ten }}</td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" style="padding-right: 6px;" data-bs-toggle="modal"
                                            data-bs-target="#editBuoiHoc" v-on:click="getThongTinBuoiHoc(value.id)"><i
                                                class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-danger" style="padding-right: 6px;" data-bs-toggle="modal"
                                            data-bs-target="#deleteBuoiHoc" v-on:click="getIdBuoiHoc(value.id)"><i
                                                class="fa-solid fa-trash"></i></button>
                                        <a class="btn btn-success" style="padding-right: 6px;"
                                            v-bind:href="'/admin/lich-hoc/' + value.id" target="_blank"><i
                                                class="fa-solid fa-list-ul"></i>
                                        </a>
                                    </td>
                                </tr>

                                <template v-else>
                                    {{-- ngày hiện tại --}}
                                    <tr v-if="addDay(value.start) == true">
                                        <th class="text-center align-middle">@{{ value.thu_tu_buoi_khoa_hoc }}</th>
                                        <td class="text-center align-middle">@{{ value.bat_dau }}</td>
                                        <td class="text-center align-middle">@{{ value.ket_thuc }}</td>
                                        <td class="text-center align-middle">@{{ value.link_video }}</td>
                                        <td class="text-center align-middle">@{{ value.link_notepad }}</td>
                                        <td class="text-center align-middle">@{{ value.is_bai_tap == 0 ? 'Không' : 'Có' }}</td>
                                        <td class="text-center align-middle">@{{ value.ho_va_ten }}</td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-primary" style="padding-right: 6px;" data-bs-toggle="modal"
                                            data-bs-target="#editBuoiHoc" v-on:click="getThongTinBuoiHoc(value.id)"><i
                                                    class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger" style="padding-right: 6px;" data-bs-toggle="modal"
                                                data-bs-target="#deleteBuoiHoc" v-on:click="getIdBuoiHoc(value.id)"><i
                                                    class="fa-solid fa-trash"></i></button>
                                            <a class="btn btn-success" style="padding-right: 6px;"
                                                v-bind:href="'/admin/lich-hoc/' + value.id" target="_blank"><i
                                                    class="fa-solid fa-list-ul"></i></a>
                                        </td>
                                    </tr>
                                    {{-- ngày đã qua --}}
                                    <tr v-else style="background-color: #C0C0C0C0">
                                        <th class="text-center align-middle">@{{ value.thu_tu_buoi_khoa_hoc }}</th>
                                        <td class="text-center align-middle">@{{ value.bat_dau }}</td>
                                        <td class="text-center align-middle">@{{ value.ket_thuc }}</td>
                                        <td class="text-center align-middle">@{{ value.link_video }}</td>
                                        <td class="text-center align-middle">@{{ value.link_notepad }}</td>
                                        <td class="text-center align-middle">@{{ value.is_bai_tap == 0 ? 'Không' : 'Có' }}</td>
                                        <td class="text-center align-middle">@{{ value.ho_va_ten }}</td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-primary" style="padding-right: 6px;" data-bs-toggle="modal"
                                            data-bs-target="#editBuoiHoc" v-on:click="getThongTinBuoiHoc(value.id)"><i
                                                    class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-danger" disabled style="padding-right: 6px;" ><i
                                                    class="fa-solid fa-trash"></i></button>

                                            <a class="btn btn-success" style="padding-right: 6px;"
                                                v-bind:href="'/admin/lich-hoc/' + value.id" target="_blank"><i
                                                    class="fa-solid fa-list-ul"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>
                    <div class="modal fade" id="createBuoiHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-l">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm Mới Buổi Học</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formThemMoiBuoiHoc">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Giờ bắt đầu</label>
                                                <input name="gio_bat_dau" type="datetime-local" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Giờ kết thúc</label>
                                                <input name="gio_ket_thuc" type="datetime-local" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Link video</label>
                                                <input name="link_video" class="form-control"
                                                    placeholder="Nhập link video (nếu có)">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Link notepad</label>
                                                <input name="link_notepad" class="form-control"
                                                    placeholder="Nhập link notepad (nếu có)">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <label class="form-label">Giáo viên</label>
                                                <select name="id_nhan_vien_day" class="form-control">
                                                    <template v-for="(value, index) in list_nhan_vien">
                                                        <option v-bind:value="value.id">@{{ value.ho_va_ten }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Bài tập</label>
                                                <select name="is_bai_tap" class="form-control">
                                                    <option value="0">Không</option>
                                                    <option value="1">Có</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="themMoiBuoiHoc()" type="button" class="btn btn-primary">Thêm
                                        Mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteBuoiHoc" tabindex="-1" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xoá Buổi Học</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-wrap">
                                    <p class="text-danger">Bạn có chắc chắn là sẽ xoá buổi học này?</p>
                                    <p >Hành động này sẽ kèm theo việc xóa tất cả thông tin học viên của
                                        buổi học này!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="deleteBuoiHoc()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Xoá</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editBuoiHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-l">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Chỉnh Sửa Buổi Học</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <template  v-if="update.gio_bat_dau_1 < update.start">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Giờ bắt đầu</label>
                                                <input disabled v-model="update.gio_bat_dau" type="datetime-local"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Giờ kết thúc</label>
                                                <input disabled v-model="update.gio_ket_thuc" type="datetime-local"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Giờ bắt đầu</label>
                                                <input v-model="update.gio_bat_dau" type="datetime-local"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Giờ kết thúc</label>
                                                <input v-model="update.gio_ket_thuc" type="datetime-local"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </template>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Link video</label>
                                                <input v-model="update.link_video" class="form-control"
                                                    placeholder="Nhập link video (nếu có)">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Link notepad</label>
                                                <input v-model="update.link_notepad" class="form-control"
                                                    placeholder="Nhập link notepad (nếu có)">
                                            </div>
                                        </div>
                                    <template  v-if="update.gio_bat_dau_1 < update.start">
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <label class="form-label">Giáo viên</label>
                                                <select disabled v-model="update.id_nhan_vien_day" class="form-control">
                                                    <template v-for="(value, index) in list_nhan_vien">
                                                        <option v-bind:value="value.id">@{{ value.ho_va_ten }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Bài tập</label>
                                                <select disabled v-model="update.is_bai_tap" class="form-control">
                                                    <option value="0">Không</option>
                                                    <option value="1">Có</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <label class="form-label">Giáo viên</label>
                                                <select v-model="update.id_nhan_vien_day" class="form-control">
                                                    <template v-for="(value, index) in list_nhan_vien">
                                                        <option v-bind:value="value.id">@{{ value.ho_va_ten }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Bài tập</label>
                                                <select v-model="update.is_bai_tap" class="form-control">
                                                    <option value="0">Không</option>
                                                    <option value="1">Có</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="updateBuoiHoc()" type="button" class="btn btn-primary">Cập
                                        Nhật</button>
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
                add: {},
                list: [],
                list_nhan_vien: [],
                destroy: {},
                update: {},
                id_lop_hoc: 0,
                id_buoi_hoc: 0,
            },
            created() {
                this.id_lop_hoc = window.trimSlash(window.location.pathname).substring(15);
                this.loadData();
                this.getGiaoVien();
            },
            methods: {
                //so sánh 2 chuỗi với nhau
                isToday(date) {
                    return new Date(date).toDateString() === new Date().toDateString();
                },

                addDay(date)
                {
                    var now  = new moment();
                    var day = moment(date).add(2, 'days');
                    // console.log(new moment().format('DD/MM/yyyy'));
                    // console.log(day >= now);
                    return day >= now;
                },

                date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
                },
                loadData() {
                    axios
                        .get('/admin/buoi-hoc/data/' + this.id_lop_hoc)
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },
                getGiaoVien() {
                    axios
                        .get('/admin/nhan-vien/data')
                        .then((res) => {
                            this.list_nhan_vien = res.data.data;
                        });
                },
                themMoiBuoiHoc() {
                    const payload = window.getFormData($("#formThemMoiBuoiHoc"));
                    payload['id_lop_hoc'] = this.id_lop_hoc;
                    axios
                        .post('/admin/buoi-hoc/create', payload)
                        .then((res) => {
                            if (res.data.status) {
                                displaySuccess(res);
                                this.loadData();
                                $("#createBuoiHoc").modal('hide');
                                $('#formThemMoiBuoiHoc').trigger("reset");
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                getThongTinBuoiHoc(id_buoi_hoc) {
                    this.id_buoi_hoc = id_buoi_hoc;
                    axios
                        .get('/admin/buoi-hoc/data-buoi-hoc/' + this.id_buoi_hoc)
                        .then((res) => {
                            this.update = res.data.data;
                            this.update.gio_bat_dau_1 = date_format(this.update.gio_bat_dau)
                            this.update.start = new moment().format('DD/MM/yyyy');
                            // console.log(this.update);
                        });
                },
                updateBuoiHoc() {
                    this.update.id_buoi_hoc = this.id_buoi_hoc;
                    // console.log(this.update.gio_bat_dau);
                    axios
                        .post('/admin/buoi-hoc/update', this.update)
                        .then((res) => {
                            if (res.data.status) {
                                displaySuccess(res);
                                this.loadData();
                                $("#editBuoiHoc").modal('hide');
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                getIdBuoiHoc(id_buoi_hoc) {
                    this.id_buoi_hoc = id_buoi_hoc;
                },
                deleteBuoiHoc() {
                    axios
                        .get('/admin/buoi-hoc/delete/' + this.id_buoi_hoc)
                        .then((res) => {
                            if (res.data.status) {
                                displaySuccess(res);
                                this.loadData();
                                $("#deleteBuoiHoc").modal('hide');
                            }
                        });
                },
                tinhSoBuoi(index,so_buoi_trong_thang) {
                    if(index % so_buoi_trong_thang == 0) {
                        return true;
                    }
                },
            }
        });
    </script>
@endsection
