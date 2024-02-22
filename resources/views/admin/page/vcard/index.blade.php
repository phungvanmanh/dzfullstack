<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DZFullStack - VCard Student</title>
	<meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="HandheldFriendly" content="True">
	<link rel="stylesheet" href="/assets_vcard/css/materialize.css">
	<link rel="stylesheet" href="/assets_vcard/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets_vcard/css/normalize.css">
	<link rel="stylesheet" href="/assets_vcard/css/magnific-popup.css">
	<link rel="stylesheet" href="/assets_vcard/css/owl.carousel.css">
	<link rel="stylesheet" href="/assets_vcard/css/owl.theme.css">
	<link rel="stylesheet" href="/assets_vcard/css/owl.transitions.css">
	<link rel="stylesheet" href="/assets_vcard/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
	<link rel="shortcut icon" href="/assets_vcard/img/favicon.png">

</head>
<body>
	<!-- slider -->
	<div class="slider" style="margin-top: -10px">
		<ul class="slides">
			<li>
				<img src="/assets_vcard/img/noel-2022.jpg" alt="">
				<div class="caption slider-content">
					<div class="image-profil">
						<img src="{{$hocVien->anh_dai_dien}}" alt="">
					</div>
					<h2>{{$hocVien->ho_va_ten}}</h2>
					<h4>{{$hocVien->sologan}}</h4>
				</div>
			</li>
			<li>
				<img src="/assets_vcard/img/my_love.png" alt="">
				<div class="caption slider-content">
					<div class="image-profil">
						<img src="{{$hocVien->anh_dai_dien}}" alt="">
					</div>
					<h2>{{$hocVien->ho_va_ten}}</h2>
					<h4>{{$hocVien->sologan}}</h4>
				</div>
			</li>
			<li>
				<img src="/assets_vcard/img/new-year-2023-2.jpg" alt="">
				<div class="caption slider-content">
					<div class="image-profil">
						<img src="{{$hocVien->anh_dai_dien}}" alt="">
					</div>
					<h2>{{$hocVien->ho_va_ten}}</h2>
					<h4>{{$hocVien->sologan}}</h4>
				</div>
			</li>
		</ul>
	</div>
	<!-- end slider -->
	<!-- service -->
	<div class="section">
		<div class="container">
			<div class="section-head">
				<h3>SOCIAL NETWORK</h3>
				<div class="divider"></div>
			</div>
			<div class="row">
				<div class="col s6">
					<div class="service">
						<div class="icon">
                            <div class="row">
                                <div class="col ">
                                    <a href="{{$hocVien->facebook}}" target="_blank">
                                        <i class="fa-brands fa-square-facebook" style="color: #1773ea;margin-left:260px;"><h5>{{$hocVien->facebook}}</h5></i>
                                    </a>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<div class="col s6">
					<div class="service">
						<div class="icon">
                            <div class="row">
                                <div class="col">
                                    <a href="{{$hocVien->youtube}}" target="_blank">
                                        <i class="fa-brands fa-youtube" style="color: #f70000;margin-left:285px;"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{$hocVien->youtube}}">
                                        <h5 style="font-size:20px">{{$hocVien->youtube}}</h5>
                                    </a>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s6">
					<div class="service">
						<div class="icon">
                            <i class="fa-solid fa-envelope" style="color: #d64b40; margin-left:295px;"><h5 style="font-size:20px">{{$hocVien->email}}</h5></i>
                        </div>
					</div>
				</div>
				<div class="col s6">
					<div class="service">
						<div class="icon">
							<i class="fa-brands fa-telegram" style="color: #2f9dd7"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end service -->

	<!-- skill -->
	<div class="section bg-second">
		<div class="container">
			<div class="section-head">
				<h3>MY SKILL</h3>
				<div class="divider"></div>
			</div>
			<div class="row">
                @if($hocVien->skill_level != null)
                    @foreach (json_decode($hocVien->skill_level) as $key=>$value )
                        <div class="col s6 mt-2">
                            <div class="skill">
                                <div id="skill-{{ $key }}" class="skill-circle"></div>
                                <h5>{{ $value->name }}</h5>
                            </div>
                        </div>
                    @endforeach
                @endif
			</div>
		</div>
	</div>
	<!-- end skill -->

	<!-- portfolio -->
	<div class="section">
	    <div class="container">
	    	<div class="section-head">
				<h3>PORTFOLIO</h3>
				<div class="divider"></div>
			</div>
	        <div class="portfolio">
		        <div class="row">
		            <div class="filtr-container">
		                <div class="col s6 filtr-item col-pd" data-category="1, 3">
		                    <a href="/assets_vcard/img/1.png" class="image-popup"><img class="responsive-img" src="/assets_vcard/img/1.png" alt="sample image"></a>
		                </div>
                        <div class="col s6 filtr-item col-pd" data-category="1, 3">
		                    <a href="/assets_vcard/img/1.png" class="image-popup"><img class="responsive-img" src="/assets_vcard/img/1.png" alt="sample image"></a>
		                </div>
		            </div>
		        </div>
	        </div>
	    </div>
	</div>
	<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="about-us-foot">
				<h6><span>S</span>mith</h6>
				<p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			</div>
			<div class="social-media">
				<a href=""><i class="fa fa-facebook"></i></a>
				<a href=""><i class="fa fa-twitter"></i></a>
				<a href=""><i class="fa fa-google"></i></a>
				<a href=""><i class="fa fa-linkedin"></i></a>
				<a href=""><i class="fa fa-instagram"></i></a>
			</div>
			<div class="copyright">
				<p class="text-white">Copyright DZFullStack © @php echo date("Y") @endphp. All right reserved.</p>
			</div>
		</div>
	</div>
	<!-- end footer -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var hocVien = <?php echo($hocVien); ?>;
            var array_skill = JSON.parse(hocVien.skill_level)
            // AnimateCircle("skill-1", 0.95);
            // AnimateCircle("skill-2", 0.9);
            // AnimateCircle("skill-3", 0.8);
            // AnimateCircle("skill-4", 0.7);
            var name ='';
            $.each(array_skill, function(key, value) {
                name = "skill-" + key;
                AnimateCircle(name, value.percent /100 );
            });

            function AnimateCircle(container_id, animatePercentage) {
                var startColor = '#83acda';
                var endColor = '#83acda';

                var element = document.getElementById(container_id);
                var circle = new ProgressBar.Circle(element, {
                    color: '#333',
                    trailColor: '#eee',
                    trailWidth: 7,
                    duration: 2000,
                    easing: 'bounce',
                    strokeWidth: 7,
                    text: {
                        value: (animatePercentage * 100) + " %",
                        className: 'progressbar__label'
                    },
                    // Set default step function for all animate calls
                    step: function (state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                    }
                });

                circle.animate(animatePercentage, {
                    from: {
                        color: startColor
                    },
                    to: {
                        color: endColor
                    }
                });
            }
        });
    </script>

	<!-- scripts -->
	<script src="/assets_vcard/js/jquery.min.js"></script>
	<script src="/assets_vcard/js/materialize.min.js"></script>
	<script src="/assets_vcard/js/progressbar.js"></script>
	<script src="/assets_vcard/js/portfolio.js"></script>
	<script src="/assets_vcard/js/jquery.magnific-popup.min.js"></script>
	<script src="/assets_vcard/js/jquery.filterizr.min.js"></script>
	<script src="/assets_vcard/js/owl.carousel.min.js"></script>
	<script src="/assets_vcard/js/fakeLoader.min.js"></script>
	<script src="/assets_vcard/js/main.js"></script>



</body>
</html>
