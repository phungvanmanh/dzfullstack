@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5>Thêm Mới Lịch Đề Cương</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 mt-1">
                                    <label class="form-label">Mã Môn Học</label>
                                    <input v-model="them_moi.ma_mon_hoc" type="text" class="form-control"
                                        placeholder="VD: CS316">
                                </div>
                                <div class="col-md-4 mt-1">
                                    <label class="form-label">Loại</label>
                                    <select v-model="them_moi.loai_mon" class="form-control">
                                        <option selected="selected">Chọn loại</option>
                                        <option value="1">LEC</option>
                                        <option value="2">LAB</option>
                                        <option value="3">Đồ Án</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-1">
                                    <label class="form-label">Số Buổi Đề Cương</label>
                                    <input v-on:blur="so_luong()" id="so_buoi_de_cuong"
                                        v-model="them_moi.so_buoi_de_cuong" type="number" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <template v-if="so_buoi != 0">
                <div class="card border-primary border-bottom border-3 border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <th class="text-center text-nowrap align-middle">Buổi Thứ</th>
                                    <th class="text-center text-nowrap align-middle">Tiêu Đề</th>
                                    <th class="text-center text-nowrap align-middle">Nội Dung</th>
                                </thead>
                                <tbody>
                                    <template v-for="(value, key) in array_buoi">
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input v-model="value.buoi" type="number" class="form-control" placeholder="VD: 1" v-on:change="checkTrung(value.buoi)">
                                            </td>
                                            <td class="text-center align-middle">
                                                <input v-model="value.tieu_de" type="text" class="form-control">
                                            </td>
                                            <td class="text-center align-middle">
                                                <textarea v-model="value.noi_dung" class="form-control"></textarea>
                                                {{-- <input type="text" class="form-control"> --}}
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button v-if="check_trung == true" class="btn btn-primary" v-on:click="create()">Tạo mới</button>
                        <button v-else disabled class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                them_moi: {},
                list: [],
                edit: {},
                so_buoi: 0,
                array_buoi : [],
                check_trung : true,
            },
            created() {

            },

            methods: {
                so_luong() {
                    this.so_buoi = (this.them_moi.so_buoi_de_cuong * 1);
                    this.array_buoi = [];
                    for(var i = 1; i <= this.so_buoi ; i++ ) {
                        this.array_buoi.push({
                            buoi : i*1,
                            tieu_de : null,
                            noi_dung : null
                        })
                    }
                },

                checkTrung(value) {
                    var check = true;
                    $.each(this.array_buoi, function( index, v ) {
                        if(value == v.buoi) {
                            check = false;
                            toastr.error('Buổi thứ '+ value +' đã bị trùng!');
                            return false;
                        }
                    });
                    this.check_trung = check;
                },

                create() {
                    this.them_moi.array_buoi = this.array_buoi;
                    if(this.check_trung == true) {
                        axios
                            .post('/dtu/tao-lich-de-cuong', this.them_moi)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.messages);
                                    this.resetForm();
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    }
                },
                resetForm() {
                    this.them_moi.ma_mon_hoc        ='';
                    this.them_moi.loai_mon          ='';
                    this.them_moi.so_buoi_de_cuong  =''  ;
                    this.so_luong();
                },
            },
        });
    </script>
@endsection
