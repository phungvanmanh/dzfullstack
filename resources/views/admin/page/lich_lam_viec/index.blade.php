@extends('admin.share.master')
@section('content')
    <div class="row">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6>Lịch làm việc tuần</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">Ngày</th>
                                <th class="text-center">02/01/2023</th>
                                <th class="text-center">02/01/2023</th>
                                <th class="text-center">02/01/2023</th>
                                <th class="text-center">02/01/2023</th>
                                <th class="text-center">02/01/2023</th>
                                <th class="text-center">02/01/2023</th>
                                <th class="text-center">02/01/2023</th>
                            </tr>
                            <tr>
                                <th class="text-center">Buổi / Thứ</th>
                                <th class="text-center">Thứ 2</th>
                                <th class="text-center">Thứ 3</th>
                                <th class="text-center">Thứ 4</th>
                                <th class="text-center">Thứ 5</th>
                                <th class="text-center">Thứ 6</th>
                                <th class="text-center">Thứ 7</th>
                                <th class="text-center">Chủ Nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center align-middle">Sáng</th>
                                <td class="text-center align-middle">
                                    <div class="user-groups ms-auto">
                                        <img src="/assets/images/avatars/avatar-1.png" width="35" height="35" class="rounded-circle" alt="" />
                                        <img src="/assets/images/avatars/avatar-2.png" width="35" height="35" class="rounded-circle" alt="" />
										<img src="/assets/images/avatars/avatar-4.png" width="35" height="35" class="rounded-circle" alt="" />
                                        <img src="/assets/images/avatars/avatar-7.png" width="35" height="35" class="rounded-circle" alt="" />
										<img src="/assets/images/avatars/avatar-8.png" width="35" height="35" class="rounded-circle" alt="" />
                                    </td>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="user-groups ms-auto">
                                        <img src="/assets/images/avatars/avatar-1.png" width="35" height="35" class="rounded-circle" alt="" />
                                    </td>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="user-groups ms-auto">
                                        <img src="/assets/images/avatars/avatar-2.png" width="35" height="35" class="rounded-circle" alt="" />
                                    </td>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="user-groups ms-auto">
                                        <img src="/assets/images/avatars/avatar-7.png" width="35" height="35" class="rounded-circle" alt="" />
                                        <img src="/assets/images/avatars/avatar-8.png" width="35" height="35" class="rounded-circle" alt="" />
                                    </td>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="user-groups ms-auto">
                                        <img src="/assets/images/avatars/avatar-8.png" width="35" height="35" class="rounded-circle" alt="" />
                                    </td>
                                </td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Chiều</th>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Tối</th>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Khuya</th>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                                <td class="text-center align-middle">AAAAAA</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        toastr.success('OKkksdsd');
    </script>
@endsection
