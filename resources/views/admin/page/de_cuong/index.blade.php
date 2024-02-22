@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10 mt-3">
                        <h4>Đề Cương</h4>
                    </div>
                    <div class="col-md-2 mt-2 text-end">
                        <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#createDeCuong">Thêm mới đề
                            cương</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Mã Môn Học</th>
                                <th class="text-center">Tên Môn Học</th>
                                <th class="text-center">Loại Môn Học</th>
                                <th class="text-center">Quy Tắc</th>
                                <th class="text-center">CLO</th>
                                <th class="text-center">CONT</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in list">
                                <th class="align-middle">@{{index+1}}</th>
                                <th class="align-middle text-center">@{{value.ma_mon_hoc}}</th>
                                <th class="align-middle">@{{value.ten_mon_hoc}}</th>
                                <th class="align-middle text-center">
                                    <template v-if="value.loai_mon_hoc">
                                        <button class="btn btn-primary">LEC</button>
                                    </template>
                                    <template v-else-if="value.loai_mon_hoc === 'LAB'">
                                        <button class="btn btn-warning">LAB</button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-danger">Đồ Án</button>
                                    </template>
                                </th>
                                <th class="align-middle">
                                    <template v-if="value.quy_tac">
                                        <a>Quy tắc Tính điểm Sau Đại Học của Đại học Duy Tân</a>
                                    </template>
                                    <template v-else>
                                        <a>Quy Tắc Tính Điểm của Đại Học Duy Tân</a>
                                    </template>
                                </th>
                                <th class="align-middle">@{{value.CLO}}</th>
                                <th class="align-middle">@{{value.CONT}}</th>
                                <td class="text-center align-middle">
                                    <button data-bs-toggle="modal" data-bs-target="#editHocVien" class="btn btn-primary"
                                        type="button"><i style="padding-left: 4px" class="fa-solid fa-pen"></i></button>
                                    <button data-bs-toggle="modal" data-bs-target="#watchLichTrinh" class="btn btn-warning text-white"
                                        type="button"><i style="padding-left: 4px" class="fa-sharp fa-solid fa-calendar-days" v-on:click = "de_cuong = value,loadLichTrinh(value)"></i></button>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteDeCuong" class="btn btn-danger" v-on:click="destroy = value"
                                        type="button"><i style="padding-left: 4px" class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="createDeCuong" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm Mới Đề Cương</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Mã Môn Học</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="add.ma_mon_hoc" class="form-control" placeholder="Mã Môn Học">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Tên Môn Học</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="add.ten_mon_hoc" class="form-control" placeholder="Tên Môn Học">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Loại Môn Học</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <select v-model="add.loai_mon_hoc" class="form-control">
                                                <option value="1">LEC</option>
                                                <option value="2">LAB</option>
                                                <option value="3">Đồ Án</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Quy Tắc</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <select v-model="add.quy_tac" class="form-control">
                                                <option value="1">Quy tắc Tính điểm Sau Đại Học của Đại học Duy Tân
                                                </option>
                                                <option value="2">Quy Tắc Tính Điểm của Đại Học Duy Tân</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Chuyên Cần</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="cc.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="cc.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Phát biểu & thảo luận</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="pbtl.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="pbtl.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Kiểm Tra Thường Kỳ</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="kttk.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="kttk.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Bài Tập Về Nhà</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="btvn.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="btvn.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Thực Hành & Thực Tế</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="thtt.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="thtt.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Kiểm Tra Giữa Kỳ</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="ktgk.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="ktgk.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Đồ Án Cá Nhân</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="dacn.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="dacn.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Đồ Án Nhóm</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="dan.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="dan.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <h5>Kiểm Tra Cuối kỳ</h5>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="ktck.math" class="form-control" placeholder="%">
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="ktck.name" class="form-control" placeholder="Chuyên Cần">
                                        </div>
                                    </div>

                                    <div class="row mb-2 mt-2">
                                        <div class="col-sm-3">
                                            <h5>CLO</h5>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" v-on:click="addClo()" type="button"><i
                                                    class="fa-solid fa-plus" style="margin-left: 5px"></i></button>
                                        </div>
                                        <div class="col-sm-8 text-secondary" id="text_skill">
                                            <template v-for="(value, index) in array_clo">
                                                <template v-if="index == 0">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                v-model="value.name" placeholder="Nhập CLO" />
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="row mt-2">
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                v-model="value.name" placeholder="Nhập CLO" />
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button class="btn btn-secondary" style="margin-right: 5px"
                                                                v-on:click="removeClo(index)" type="button"><i
                                                                    style="max-width: 10px"
                                                                    class="fa-solid fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </template>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h5>CONT</h5>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" v-on:click="addCont()" type="button"><i
                                                    class="fa-solid fa-plus" style="margin-left: 5px"></i></button>
                                        </div>
                                        <div class="col-sm-8 text-secondary" id="text_skill">
                                            <template v-for="(value, index) in array_cont">
                                                <template v-if="index == 0">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                v-model="value.name" placeholder="Nhập CONT" />
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="row mt-2">
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                v-model="value.name" placeholder="Nhập CONT" />
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button class="btn btn-secondary" style="margin-right: 5px"
                                                                v-on:click="removeCont(index)" type="button"><i
                                                                    style="max-width: 10px"
                                                                    class="fa-solid fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </template>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" v-on:click="themMoi()">Thêm
                                        Mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteDeCuong" tabindex="-1" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xoá Đề Cương</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Ban chắc chắn là sẽ xoá đề cương môn <b class="text-danger">@{{destroy.ma_mon_hoc}}</b>
                                    này!<br>
                                    <b>Lưu ý: Hành động này không thể khôi phục!</b>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="xoaDeCuong()" type="button"  class="btn btn-primary">Xoá Đề Cương</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="watchLichTrinh" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Lịch Trình @{{ de_cuong.ma_mon_hoc }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            {{-- <tr>
                                                <th class="align-middle">Mã Môn Học: @{{ de_cuong.ma_mon_hoc }} </th>
                                                <th class="align-middle">Loại Môn Học: @{{ de_cuong.loai_mon_hoc }}</th>
                                                <th class="align-middle">Buổi Đề Cương: </th>
                                            </tr> --}}
                                            <template v-for="(value, key) in lich_de_cuong">
                                                <tr v-if="key == 0">
                                                    <th class="align-middle">Mã Môn Học: @{{ value.ma_mon_hoc }} </th>
                                                    <th class="align-middle">Loại Môn Học: @{{ value.loai_mon }}</th>
                                                    <th class="align-middle">Buổi Đề Cương: @{{ value.so_buoi_de_cuong }} </th>
                                                </tr>
                                            </template>
                                            <tr>
                                                <th class="align-middle">Buổi thứ</th>
                                                <th class="align-middle">Tiêu Đề</th>
                                                <th class="align-middle">Nội Dung</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(value, key) in lich_de_cuong">
                                                <td class="align-middle">@{{value.buoi_thu}}</td>
                                                <td class="align-middle">@{{value.tieu_de}}</td>
                                                <td class="align-middle">@{{value.noi_dung}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </template>
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
                list:[],
                add: {},
                destroy:{},
                array_quytac: [],
                list_lich:'',
                cc: {
                    math: null,
                    name: "Chuyên Cần"
                },
                pbtl: {
                    math: null,
                    name: "Phát Biểu & Thảo Luận"
                },
                kttk: {
                    math: null,
                    name: "Kiểm Tra Thường Kỳ"
                },
                btvn: {
                    math: null,
                    name: "Bày Tập Về Nhà"
                },
                thtt: {
                    math: null,
                    name: "Thực Hành & Thực Tế"
                },
                ktgk: {
                    math: null,
                    name: "Kiểm Tra Giữa Kỳ"
                },
                dacn: {
                    math: null,
                    name: "Đồ Án Cá Nhân"
                },
                dan: {
                    math: null,
                    name: "Đồ Án Nhóm"
                },
                ktck: {
                    math: null,
                    name: "Kiểm Tra Cuối Kỳ"
                },
                array_clo: [{
                    name: null
                }],
                array_cont: [{
                    name: null
                }],

                count_clo:1,
                count_cont:1,
                de_cuong : [],
                lich_de_cuong : [],
            },
            created() {
                // console.log(this.add);
                this.loadData();
            },
            methods: {
                get_lich(v) {
                    console.log(v.ma_mon_hoc);
                },
                addCont() {
                    this.array_cont.push({
                        name: null
                    });
                    this.count_cont=this.count_cont*1+1;
                },

                removeCont(index) {
                    this.array_cont.splice(index, 1);
                    this.count_cont=this.count_cont*1-1;
                },
                addClo() {
                    this.array_clo.push({
                        name: null
                    });
                    this.count_clo=this.count_clo*1+1;
                },

                removeClo(index) {
                    this.array_clo.splice(index, 1);
                    this.count_clo=this.count_clo*1-1;
                },
                themMoi() {
                    this.array_quytac.push(this.cc, this.pbtl, this.kttk, this.btvn, this.thtt, this.ktgk, this.dacn, this.dan, this.ktck);
                    quytac = JSON.stringify(this.array_quytac);
                    var payload = {
                        'clo'       : this.array_clo,
                        'cont'      : this.array_cont,
                        'quytac'    : quytac,
                        'decuong'   : this.add,
                    };
                    axios
                        .post('/dtu/de-cuong/create', payload)
                        .then((res) => {
                            displaySuccess(res);
                            $("#createDeCuong").modal("hide");
                            this.resetForm();
                            this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                resetForm() {
                    this.add.ma_mon_hoc     ='';
                    this.add.ten_mon_hoc    ='';
                    this.add.loai_mon_hoc   ='';
                    this.add.quy_tac        ='';
                    this.cc.math            ='';
                    this.pbtl.math          ='';
                    this.kttk.math          ='';
                    this.btvn.math          ='';
                    this.thtt.math          ='';
                    this.ktgk.math          ='';
                    this.dacn.math          ='';
                    this.dan.math           ='';
                    this.ktck.math          ='';
                    for (let index = 0; index < this.count_cont; index++) {
                        this.array_cont[index].name='';
                    };
                    for (let index = 0; index < this.count_clo; index++) {
                        this.array_clo[index].name='';
                    }
                },
                loadData() {
                    axios
                    .get('/dtu/de-cuong/data')
                    .then((res) => {
                        this.list = res.data.data;
                        console.log(this.list);
                    });

                },
                xoaDeCuong(){
                    //console.log(this.destroy);
                    axios
                        .post('/dtu/de-cuong/delete', this.destroy)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                            $('#deleteDeCuong').modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                loadLichTrinh(v) {
                    console.log(v);
                    axios
                    .post('/dtu/de-cuong/lichTrinh', v)
                    .then((res) => {
                        this.lich_de_cuong = res.data.data;
                        console.log(this.lich_de_cuong);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            }
        });
    </script>
@endsection
