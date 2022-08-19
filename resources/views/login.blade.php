<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>I am A Wiproites | Log in</title>
	@include('master/include/scriptHeader')
	{!! RecaptchaV3::initJs() !!}
</head>
<link rel="stylesheet" href="{{asset('assets_admin_lte/assets/dist/css/customlogin.css')}}?version=51">

<body class="login-page2">
    <div class="login-box2" align="center" >
        <div class="card">
			<div class="card-body login-card-body card-lg text-white rounded-lg shadow-lg" style="background-color: #1c0038;">
				<h3 class="welcome"><b>welcome,</b></h3>
                <p class="welcome">Enter your personal login below.</p><br>

                <form id="formLogin" onkeypress="onEnter(event)">
					@csrf
                    <div class="input-group mb-3" id="groupUsername">
                        <div class="input-group-append color-white">
                            <div class="input-group-text">
                                <span class="fas fa-user icon-color"></span>
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username">
                    </div>
                    <div class="input-group mb-3" id="groupPassword">
                        <div class="input-group-append color-white">
                            <div class="input-group-text">
                                <span class="fas fa-lock icon-color" ></span>
                            </div>
                        </div>
						<input type="password" class="form-control" placeholder="Password" id="password" name="password" >
						<div class="input-group-append color-white">
							<div class="input-group-text">
								<a onclick="showpassword()">
									<span class="fas fa-eye-slash" id="iconpassword" style="color: gray;cursor: pointer;"></span>
								</a>
							</div>
						</div>
					</div>
					<div id="groupChaptaMaster" hidden>
					    {!! RecaptchaV3::field('login') !!}
					</div>
                    <div class="row" align="left">
						<div class="col-md-6">
						    <div class="icheck-primary smallSize">
						        <input type="checkbox" id="remember" name="remember">
						        <label for="remember">
						            Remember Me
						        </label>
						    </div>
						</div>
                        <!-- /.col -->
					</div>
					<div class="row mt-3" align="left">
						<div class="col mt-2">
						     <a href="{{ route('show_form') }}" style="text-decoration: none;color:white;"><i>Forgot Password?<i></a>
						</div>
						<div class="col ml-auto">
							<button type="button" class="btn btn-orange btn-block btn-md" onclick="Login(true)" id="login">Login</button>
						</div>
					</div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
	</div>
	<!-- /.login-box -->
	@include('master/include/scriptFooter')
	<script>

		function captchav3(){
			$('#groupChaptaMaster').empty();
			$('#groupChaptaMaster').append('{!! RecaptchaV3::fieldCustomBonBon('login') !!}');
			{!! RecaptchaV3::scriptBonBon('login') !!}
		}

		function onEnter(e){
			if(e.keyCode == 13){
				Login(false)
			}
		}

		function showpassword()
		{
			var x = document.getElementById("password");
			if (x.type === "password") {
				x.type = "text";
				$('#iconpassword').removeClass();
				$('#iconpassword').addClass('fas fa-eye');
			} else {
				x.type = "password";
				$('#iconpassword').removeClass();
				$('#iconpassword').addClass('fas fa-eye-slash');
			}
		}

		function Login(type) {
		    $('.alertGroupUsername').remove();
		    $('.alertGroupPassword').remove();
		    $('.alertGroupCaptcha').remove();
		    let username = $('#username').val();
		    let password = $('#password').val();
		    if (username == '' || password == '') {
		        showAlertInput(username, password, captcha);
		    } else {
				$('#login').attr("disabled", true);
		        LoginRequest(username, password,type);
		    }
		}

		function showAlertInput(username, password, captcha) {
		    $('.is-invalid').removeClass('is-invalid');
			$('#login').prop("disabled", false);
		    if (username == '' && password == '' && captcha == '') {
		        invalidPassword('Password cannot be empty');
		        invalidUsername('Username cannot be empty');
		        invalidCaptcha('Captcha cannot be empty');
		    } else if (username == '' && password == '') {
		        invalidPassword('Password cannot be empty');
		        invalidUsername('Username cannot be empty');
		    } else if (password == '') {
		        invalidPassword('Password cannot be empty');
		    } else if (username == '') {
		        invalidUsername('Username cannot be empty');
		    } else if (captcha == '') {
		        invalidCaptcha('Captcha cannot be empty')
		    }
		}

		function invalidUsername(message) {
		    $('#username').addClass('is-invalid');
			$("#groupUsername").append(`<span class="invalid-feedback text-white text-left alertGroupUsername" role="alert">
                                  <strong>${message}</strong
                                </span>`);
		}

		function invalidPassword(message) {
		    $('#password').addClass('is-invalid');
		    $("#groupPassword").append(`<span class="invalid-feedback text-white text-left alertGroupPassword" role="alert">
                                  <strong>${message}</strong
                                </span>`);
		}

		function invalidCaptcha(message) {
		    $('#captcha').addClass('is-invalid');
		    $("#groupCaptcha").append(`<span class="invalid-feedback text-white text-left alertGroupCaptcha" role="alert">
															<strong>${message}</strong
															</span>`);
		}

		function LoginRequest(username, password, type) {
			let data = $('#formLogin').serialize();
		    $.ajax({
		        async: type,
		        type: "POST",
		        data: data,
		        url: "{{url('/login')}}",
		        success: function (response) {
		            if (response.data == 'changePassword') {
		                window.location.href = `{{url('/ChangeDefault/Password')}}/${response.ilma}`;
		            } else {
		                window.location.href = `{{url('/home')}}`;
		            }
		        },
		        error: function (response) {
					captchav3()
		            $('#login').attr("disabled", false);
		            $('.is-invalid').removeClass('is-invalid');
		            let data = response.responseJSON.data;
		            if (data == 'username') {
		                invalidUsername(response.responseJSON.message)
		            } else if (data == 'password') {
		                invalidPassword(response.responseJSON.message);
		            } else if (response.responseJSON.hasOwnProperty('errors')) {
		                invalidCaptcha(response.responseJSON.errors['captcha']);
		            }
		        }
		    })
		}
	</script>
</body>

</html>
