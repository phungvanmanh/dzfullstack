@extends('admin.share.master')
@section('content')
<div class="card border-primary border-bottom border-3 border-0" id="app">
    <div class="card-header mt-3 mb-3">
        <div class="row">
            <div class="col-5 mt-4">
                <h5>Chấm Công</h5>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-2"></div>
                    <div class="col">
                        <h6>Tháng</h6>
                        <select v-model="month" class="form-control">
                            <option value="">Chọn Tháng</option>
                            <template v-for="index in 12">
                                <option v-bind:value="index">Tháng @{{index}}</option>
                            </template>
                        </select>
                    </div>
                    <div class="col">
                        <h6>Năm</h6>
                        <select v-model="year" class="form-control">
                            <option value="">Chọn Năm</option>
                            <template v-for="index in (year - 2021)">
                                <option v-bind:value="2021 + index">Năm @{{2021 + index}}</option>
                            </template>
                        </select>
                    </div>
                    <div class="col mt-4" >
                        <button class="btn btn-success" v-on:click="searchByDay()"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-drop">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th style="width:50px" class="text-center align-middle">Tên Nhân Viên</th>
                            <template v-for="(value, key) in dem">
                                <th class="text-center align-middle">Tuần @{{key + 1}}</th>
                            </template>
                            <th class="text-center align-middle">Tổng Điểm</th>
                            <th class="text-center" v-on:click='sort()'>Tổng
                                <i  v-if="order_by == 2"  class="fa-solid fa-sort-up"></i>
                                <i v-else-if="order_by == 1" class="fa-solid fa-sort-down"></i>
                                <i v-else  class="fa-solid fa-sort"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(value, key) in data">
                            <template>
                                <tr>
                                    <th class="text-center">@{{key + 1}}</th>
                                    <td style="width:50px ;">@{{value.ho_va_ten}}</td>
                                    <template v-for="(value_cong, index_cong) in value.cham_cong">
                                        <td class="text-center" data-bs-toggle="modal" data-bs-target="#list_buoi_lam" v-on:click="getNgayLam(value_cong[0], value.id)">@{{ value_cong[1] }} / @{{ value_cong[2] }}</td>
                                        {{-- <td class="text-center" data-bs-toggle="modal" data-bs-target="#list_buoi_lam" v-on:click="getNgayLam(value.tuan[index -1 ], value.id)">@{{value.cong[index -1 ]}} / @{{value.cham_diem[index -1]}}</td> --}}
                                    </template>
                                    <td class="text-center">@{{value.tong_danh_gia}}</td>
                                    <th class="text-center">@{{value.tong_buoi_lam}}</th>
                                </tr>
                            </template>
                        </template>

                    </tbody>
                </table>
                <div class="modal fade" id="list_buoi_lam" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Danh Sách Lịch Làm Trong Tuần</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle">#</th>
                                                <th class="text-center align-middle">Ngày Làm Việc</th>
                                                <th class="text-center align-middle">Buổi Làm</th>
                                                <th class="text-center align-middle">Nội Dung Buổi Làm Việc</th>
                                                <th class="text-center align-middle">Đánh Giá Buổi Làm Việc</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(value, index) in list_ngay_lam">
                                                <tr>
                                                    <th class="text-center align-middle">@{{index + 1}}</th>
                                                    <td class="text-center align-middle">@{{date_format(value.ngay_lam_viec)}}</td>
                                                    <td>
                                                        <template v-if="value.buoi_lam_viec == 0">
                                                            SÁNG
                                                        </template>
                                                        <template v-if="value.buoi_lam_viec == 1">
                                                            CHIỀU
                                                        </template>
                                                        <template v-if="value.buoi_lam_viec == 2">
                                                            TỐI
                                                        </template>
                                                        <template v-if="value.buoi_lam_viec == 3">
                                                            KHUYA
                                                        </template>
                                                    </td>
                                                    <td>@{{value.noi_dung_buoi}}</td>
                                                    <td class="text-center align-middle">@{{value.danh_gia}}</td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>
@endsection
@section('js')
<script>
    new Vue({
        el      :  '#app',
        data    :  {
            month     : '',
            year      : '',
            data      : [],
            dem       : 0,
            list_ngay_lam : [],
            order_by : 0,
        },
        created() {
            // console.log(new Date().getFullYear());
            this.month_year_new();
        },
        methods :   {
            date_format(now) {
                return moment(now).format('DD/MM/yyyy');
            },
            month_year_new() {
                var y_now = new Date().getFullYear();
                var m_now = new Date().getMonth() + 1;
                var d_now = new Date().getDate();

                this.year = y_now;

                if(d_now > 5) {
                    this.month = m_now;
                } else {
                    if(m_now == 1) {
                        this.month = 12;
                        this.year = y_now - 1;
                    } else {
                        this.month = m_now - 1;
                    }
                }
                // console.log(this.month,this.year);
                this.searchByDay();
            },
            getNgayLam(tuan, id) {
                var payload = {
                    'week'           : tuan,
                    'year'           : this.year,
                    'month'          : this.month,
                    'id'             : id,
                };

                axios
                    .post('/admin/cham-cong/list-ngay-lam', payload)
                    .then((res) => {
                        this.list_ngay_lam = res.data.data;
                        // console.log(this.list_ngay_lam);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            searchByDay(){
                var payload = {
                    'month' :   this.month,
                    'year'   :   this.year,
                };
                // console.log(payload);
                // axios
                //     .post('/admin/cham-cong/search-by-day', payload)
                //     .then((res) => {
                //         this.data = res.data.data;
                //         this.dem = res.data.dem;
                //         // console.log(this.data);
                //     })
                //     .catch((err) => {
                //         displayErrors(err);
                //     });
                axios
                    .post('/admin/cham-cong/search-by-day', payload)
                    .then((res) => {
                        this.data = res.data.data;
                        this.dem  = res.data.weeks;
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            sort() {
                this.order_by = this.order_by + 1;
                if (this.order_by > 2) {
                    this.order_by = 0;
                }
                if (this.order_by == 1) {
                    this.data = this.data.sort(function(a, b) {
                        return a.tong_buoi_lam - b.tong_buoi_lam;
                    })
                } else if (this.order_by == 2) {
                    this.data = this.data.sort(function(a, b) {
                        return b.tong_buoi_lam - a.tong_buoi_lam;
                    })
                } else {
                    this.data = this.data.sort(function(a, b) {
                        return a.id - b.id;
                    })
                }
            },
        },
    });
</script>
@endsection
