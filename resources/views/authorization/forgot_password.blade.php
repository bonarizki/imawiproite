<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Unza Vitalis | Forgot Password</title>
  @include('master/include/scriptHeader')
</head>
<link rel="stylesheet" href="{{asset('assets_admin_lte/assets/dist/css/customlogin.css')}}">
<body class="login-page2">
<div class="login-box">
 
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Insert your e-mail for change password.</p>

      <form action="{{ route('email') }}" method="post">
      {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ url('/')}}">Login</a>
      </p>
          @if(session('error'))
              <div class="alert alert-success">
                  {{ session('error') }}
              </div>
          @endif

          @if(session('succes'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

@include('master/include/scriptFooter')

</body>
</html>
