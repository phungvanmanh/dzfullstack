@extends('admin.share.master')
@section('content')
    <div class="row">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col">
                        <h6>Phân Quyền</h6>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createPhanQuyen">Thêm Mới Phân Quyền</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" style="width: 100%" role="presentation">
                                <a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab"
                                    aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Home</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" style="width: 100%" role="presentation">
                                <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-home" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Profile</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="primary-pills-home" role="tabpanel">
                                <p>
                                    <button class="btn btn-primary" style="width: 100%" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2"
                                        aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second
                                        element</button>
                                </p>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                                            <div class="card card-body">
                                                Some placeholder content for the second collapse component of this
                                                multi-collapse example. This panel is hidden by default but revealed when
                                                the user activates the relevant trigger.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary">Cập Nhật Quyền</button>
                </div>
            </div>
            <div class="modal fade" id="createPhanQuyen" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm Mới Phân Quyền</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tên Chức Vụ</label>
                                    <input name="name" class="form-control" type="text"
                                        placeholder="Nhập vào tên chức vụ">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label>Quản Lý Phòng Ban</label>
                                <div class="col">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault1">
                                        <label class="form-check-label" for="flexCheckDefault1">Default checkbox</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault3">
                                        <label class="form-check-label" for="flexCheckDefault3">Default checkbox</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault4">
                                        <label class="form-check-label" for="flexCheckDefault4">Default checkbox</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
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

            },
            created() {

            },
            methods: {

            }
        });
    </script>
@endsection
