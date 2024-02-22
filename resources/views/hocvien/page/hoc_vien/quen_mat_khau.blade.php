<!doctype html>
<html lang="en">

<head>
	@include('hocvien.share.css')
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
					<div class="col mx-auto">
						<div class="my-4 text-center">
							<img src="/assets/images/logo-img.png" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-5 rounded">
									<div class="text-center">
										<h3 class="">Quên Mật Khẩu</h3>
									</div>
									<div class="form-body">
										<form class="row g-3" action="/quen-mat-khau" method="post">
                                            @csrf
											<div class="col-12">
												<label for="inputFirstName" class="form-label">Nhập Email Của Bạn</label>
												<input type="email" class="form-control" name="email" placeholder="Nhập vào email">
											</div>

											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class='bx bx-user'></i>Xác Nhận</button>
												</div>
											</div>
                                            <div class="col-12 mt-3">
                                                {!! NoCaptcha::renderJs() !!}
                                                {!! NoCaptcha::display() !!}
                                            </div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	@include('hocvien.share.js')
    <script>
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
</body>

</html>
