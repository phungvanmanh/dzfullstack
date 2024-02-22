<!doctype html>
<html lang="en">
<head>
    @include('admin.share.css')
    <style>
        table {
            font-family: arial !important;
            max-width: 100% !important;
            background-color: transparent !important;
            border-collapse: collapse !important;
            border-spacing: 0 !important;
        }
        .table {
            width: 100% !important;
            margin-bottom: 20px !important;
        }
        .table-responsive .dropdown,
        .table-responsive .btn-group,
        .table-responsive .btn-group-vertical {
            position: static !important;
        }
        .modal {
            overflow-y:auto !important;
        }
        div.dataTables_scrollBody.dropdown-visible {
            overflow: visible !important;
        }
        table.dataTable thead th, tbody td th {
            white-space: nowrap
        }

        select {
            height: auto !important;
        }

        .dataTables_wrapper {
            font-family: Roboto !important;
            font-size: 14px !important;
            position: relative !important;
            clear: both;
            *zoom: 1;
            zoom: 1;
        }
        .dropdown-item{
            cursor: pointer;
        }
    </style>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
	 <!--start header wrapper-->
	  <div class="header-wrapper">
		<!--start header -->
		<header>
            @include('admin.share.header')
		</header>
		<!--end header -->
		<!--navigation-->
		<div class="nav-container primary-menu">
            @if ( Auth::guard('nhanVien')->check())
                @include('admin.share.menu')
            @endif
		</div>
		<!--end navigation-->
	   </div>
	   <!--end header wrapper-->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
                @yield('content')
            </div>
		</div>

		<div class="overlay toggle-icon"></div>
		<footer class="page-footer">
			<p class="mb-0">Copyright DZFullStack © @php echo date("Y") @endphp. All right reserved.</p>
		</footer>
	</div>
	<div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<h6 class="mb-0">Theme Styles</h6>
			<hr/>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
					<label class="form-check-label" for="semidark">Semi Dark</label>
				</div>
			</div>
			<hr/>
			<div class="form-check">
				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>
			</div>
			<hr/>
			<h6 class="mb-0">Header Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator headercolor1" id="headercolor1"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor2" id="headercolor2"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor3" id="headercolor3"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor4" id="headercolor4"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor5" id="headercolor5"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor6" id="headercolor6"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor7" id="headercolor7"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor8" id="headercolor8"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
    @include('admin.share.js')
    <script>
        (function () {
        var dropdownMenu;
        $(window).on('show.bs.dropdown', function (e) {
        dropdownMenu = $(e.target).find('.dropdown-menu');
        $('body').append(dropdownMenu.detach());
        var eOffset = $(e.target).offset();
        dropdownMenu.css({
            'display': 'block',
                'top': eOffset.top + $(e.target).outerHeight(),
                'left': eOffset.left
        });
        });
        $(window).on('hide.bs.dropdown', function (e) {
            $(e.target).append(dropdownMenu.detach());
            dropdownMenu.hide();
        });

        $('.tbData').on('show.bs.dropdown', function () {
            $('.dataTables_scrollBody').addClass('dropdown-visible');
        })
        .on('hide.bs.dropdown', function () {
            $('.dataTables_scrollBody').removeClass('dropdown-visible');
        });
    })();
</script>

    @yield('js')
</body>

</html>
