<!doctype html>
<html lang="en">

<head>
	@include('admin.share.css')
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
										<h3 class="">Đăng Nhập Admin</h3>
									</div>
									<div class="form-body">
										<form class="row g-3" action="/admin/login" method="POST">
                                            @csrf
											<div class="col-12">
												<label for="inputFirstName" class="form-label">Email</label>
												<input type="email" class="form-control" name="email" placeholder="Nhập vào email của bạn">
											</div>
											<div class="col-12">
												<label for="inputLastName" class="form-label">Mật Khẩu</label>
												<input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class='bx bx-user'></i>Đăng Nhập</button>
												</div>
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
	@include('admin.share.js')
</body>

</html>
