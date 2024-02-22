@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col-5">
                        Danh Sách Các Buổi Trong Tháng @{{id_thang_hoc}}
                    </div>
                    <div class="col-7 text-end">
                        <template v-for="index in so_thang_hoc*1">
                            <button v-on:click="start_end_month(index)" class="btn btn-primary" style="margin-left: 1%">Tháng @{{index}}</button>
                        </template>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Và Tên</th>
                                <template v-for="(value, index) in list_buoi_hoc">
                                    {{-- <template v-if="(index + 1) > count_buoi_da_hoc">
                                    </template> --}}
                                    <template >
                                        <th class="text-center">Buổi @{{index + 1}}</th>
                                    </template>
                                </template>
                                <th class="text-center">Số Buổi Đi Học</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in list_hoc_vien">
                                <tr>
                                    <th class="text-center text-nowrap">@{{ index + 1 }}</th>
                                    <td class="text-nowrap">@{{ value.ho_va_ten }}</td>
                                    <template v-for="(v,k) in list_buoi_hoc">
                                        <template v-for="(value_1, index_1) in list_buoi_hoc_hoc_vien">
                                            <template v-if="value.id_hoc_vien == value_1.id_hoc_vien && value_1.id_buoi_hoc == v">
                                                <td class="text-center" v-if="check_buoi_hoc(v) == true">
                                                    <template v-if="value_1.tinh_trang == 1">
                                                        <template v-if="value_1.danh_gia_bai_tap == null">
                                                            X / 000
                                                        </template>
                                                        <template v-else>
                                                            X / @{{value_1.danh_gia_bai_tap}}
                                                        </template>
                                                    </template>
                                                    <template v-if="value_1.tinh_trang == 2">
                                                        <template v-if="value_1.danh_gia_bai_tap == null">
                                                            P / 000
                                                        </template>
                                                        <template v-else>
                                                            P / @{{value_1.danh_gia_bai_tap}}
                                                        </template>
                                                    </template>
                                                    <template v-if="value_1.tinh_trang == 3">
                                                        <template v-if="value_1.danh_gia_bai_tap == null">
                                                            K / 000
                                                        </template>
                                                        <template v-else>
                                                            K / @{{value_1.danh_gia_bai_tap}}
                                                        </template>
                                                    </template>
                                                    <template v-if="value_1.tinh_trang == 0">
                                                        <template v-if="value_1.danh_gia_bai_tap == null">
                                                            - / 000
                                                        </template>
                                                        <template v-else>
                                                            - / @{{value_1.danh_gia_bai_tap}}
                                                        </template>
                                                    </template>
                                                </td>
                                            </template>
                                        </template>
                                        <template v-if="check_buoi_hoc(v) == false">
                                            <td class="text-center">
                                                - / 000
                                            </td>
                                        </template>
                                    </template>
                                    <td class="text-center">@{{ value.tong_buoi }} / @{{ so_luong_buoi_hoc }}</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $( document ).ready(function() {
            new Vue({
                el: '#app',
                data: {
                    danhSachLop             : [],
                    id_lop_hoc              : 0,
                    id_thang_hoc            : 1,
                    list_buoi               : [],
                    list_buoi_hoc           : [],
                    list_hoc_vien           : [],
                    list_buoi_hoc_hoc_vien  : [],
                    id_lop_hoc              : 0,
                    so_luong_buoi_hoc       : 0,
                    count_buoi_da_hoc       : 0,
                    so_thang_hoc            : 0,
                    list_id_buoi_hoc        : [],
                },
                created() {
                    this.id_lop_hoc         = window.trimSlash(window.location.pathname).substring(21).split("/")[0];
                    this.id_thang_hoc       = 1;
                },
                mounted: function() {
                    this.getDataKhoaHoc();
                },
                methods: {
                    getDataKhoaHoc() {
                        var payLoad = {
                            'id_lop_hoc' : this.id_lop_hoc
                        };

                        axios
                            .post('/admin/tong-ket-thang/get-data/khoa-hoc', payLoad)
                            .then((res) => {
                                this.so_thang_hoc       = res.data.data.so_thang_hoc;
                                this.so_luong_buoi_hoc  = res.data.data.so_buoi_trong_thang;
                                console.log(this.id_thang_hoc, this.so_thang_hoc, this.so_luong_buoi_hoc);
                                this.start_end_month(this.id_thang_hoc);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    check_buoi_hoc(index) {
                        console.log(index);
                        if (this.list_id_buoi_hoc.includes(index)) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    start_end_month(index) {
                        this.id_thang_hoc = index;
                        var start = ((this.id_thang_hoc - 1) * this.so_luong_buoi_hoc ) + 1;
                        var end = (this.id_thang_hoc) * this.so_luong_buoi_hoc;

                        var payload = {
                            'buoi_bat_dau'  : start,
                            'buoi_ket_thuc' : end,
                            'id_lop_hoc'    : this.id_lop_hoc * 1,
                        };

                        axios
                            .post('/admin/lich-hoc/data-khoa-hoc' , payload)
                            .then((res) => {
                                this.list_buoi_hoc          = res.data.list_buoi_hoc;
                                this.list_hoc_vien          =  res.data.list_hoc_vien;
                                this.list_buoi_hoc_hoc_vien = res.data.list_buoi_hoc_hoc_vien;
                                this.list_id_buoi_hoc       = res.data.list_id_buoi_hoc;
                                console.log(this.list_buoi_hoc, this.list_buoi_hoc_hoc_vien);
                                this.count_buoi_da_hoc = res.data.so_buoi_hoc;
                                var array_list = this.list_buoi_hoc_hoc_vien;
                                $.each(this.list_hoc_vien, function(key, value) {
                                    var x = 0;
                                    $.each(array_list, function(k, v) {
                                        if(v.id_hoc_vien == value.id_hoc_vien && v.tinh_trang == 1) {
                                            x = x + 1;
                                        }
                                    });
                                    value.tong_buoi = x;
                                });
                            });
                    },

                }
            });
        });
    </script>
@endsection
