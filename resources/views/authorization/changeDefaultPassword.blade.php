<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Unza Vitalis | Change Password</title>
    @include('master.include.scriptHeader')
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/dist/css/customlogin.css')}}">
    <style>
      .swal2-popup {
          font-size: 15px !important;
      }
    </style>
</head>

<body class="hold-transition login-page2">
    <div class="login-box">
        <div class="alert alert-light text-center" role="alert">
            <b>CHANGE DEFAULT PASSWORD</b>
            <div class="text-left">
                Your password must containt uppercase, lowercase, numbers,  minimal character 8, unique letters
                e.g (~!@#$%^&*)
            </div>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Insert new password.</p>

                <form id="formResetId">
                    {{csrf_field() }}
                    <div class="input-group mb-3" id="groupPassword">
                        <input type="text" name="mail" value="{{$mail}}" hidden>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                            autofocus>
                        {{-- <input type="hidden" name="email" value="@php echo $_GET['email']; @endphp"> --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <a onclick="showpassword('password')">
									<span class="fas fa-eye-slash" id="iconpassword" style="color: gray;cursor: pointer;"></span>
								</a>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3" id="groupPassword1">
                        <input type="password" name="password1" id="password1" class="form-control"
                            placeholder="Confirm Password" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <a onclick="showpassword('password1')">
									<span class="fas fa-eye-slash" id="iconpassword1" style="color: gray;cursor: pointer;"></span>
								</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary btn-block" onClick="savePassword()">Change
                                password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ url('/') }}">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    @include('master.include.scriptFooter')
</body>

</html>

<script>

    function showpassword(id) {
        var x = document.getElementById(`${id}`);
        if (x.type === "password") {
            x.type = "text";
            $(`#icon${id}`).removeClass();
            $(`#icon${id}`).addClass('fas fa-eye');
        } else {
            x.type = "password";
            $(`#icon${id}`).removeClass();
            $(`#icon${id}`).addClass('fas fa-eye-slash');
        }
    }

    function savePassword() {
        $('.alertGroupPassword1').remove();
        $('.alertGroupPassword').remove();
        let password1 = $('#password1').val()
        let password = $('#password').val()
        if (password1 == '' || password == '') {
            if (password1 == '' && password == '') {
                invalidPass1('password confirmation cannot be empty');
                invalidPass('password cannot be empty');
            } else if (password1 == '') {
                invalidPass1('password confirmation cannot be empty');
                $('.alertGroupPassword').removeClass('is-invalid');
            } else if (password == '') {
                invalidPass('password cannot be empty');
                $('.alertGroupPassword1').removeClass('is-invalid');
            }
        } else if (password1 != password) {
            invalidPass1('passwords not match');
            invalidPass('passwords not match');
        } else if (password1 == password) {
            let message = validatePassword(password)
            if (message != true) {
                invalidPass(message);
                $('.alertGroupPassword1').removeClass('is-invalid');
            } else {
                savePasswordToDataBase();
            }
        }
    }

    function validatePassword(p) {
        let errors = [];
        if (p.length < 8) {
            errors.push("Your password must be at least 8 characters,");
        }
        if (p.search(/[a-z]/i) < 0) {
            errors.push("Your password must contain at least one letter,");
        }
        if (p.search(/(?=.*[A-Z])/) < 0) {
            errors.push("Your password must contain at least one capital letter,");
        }
        if (p.search(/[0-9]/) < 0) {
            errors.push("Your password must contain at least one digit number,");
        }
        if (p.search(/[^a-zA-Z0-9]/) < 0) {
            errors.push("Your password must contain at least one unique letter,");
        }
        if (errors.length > 0) {
            return errors.join("\n");
        }
        return true;
    }

    function invalidPass1(message) {
        $('#password1').addClass('is-invalid');
        $("#groupPassword1").append(`<span class="invalid-feedback alertGroupPassword1" role="alert">
                                  <strong>${message}</strong>
                                </span>`);
    }

    function invalidPass(message) {
        $('#password').addClass('is-invalid');
        $("#groupPassword").append(`<span class="invalid-feedback alertGroupPassword" role="alert">
                                  <strong>${message}</strong>
                                </span>`);
    }

    function savePasswordToDataBase() {
        let data = $('#formResetId').serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: "{{url('/resetDefault/password')}}",
            success: function (response) {
                if (response.status == 'ok') {
                    Swal.fire({
                        backdrop: false,
                        title: 'Good job!',
                        text: response.message,
                        icon: 'success'
                    }).then(function () {
                        window.location.href = "{{url('/')}}";
                    });
                }
            },
            error: function (response) {
                console.log(response);
            }
        })
    }
</script>
