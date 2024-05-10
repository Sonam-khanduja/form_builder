
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('admin/css/fontawesome-free/all.min.css')}}">

  <link rel="stylesheet" href="{{url('admin/css/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{url('admin/css/adminlte.min.css')}}">
  <link href="{{url('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />  
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('login') }}"> {{ config('app.name') }}</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body ">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
     @endif
     <form method="POST" action="{{ route('password.email') }}">
      @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" required autocomplete="email" placeholder="Email"> @error('email')
            <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
         
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
           </span>
        @enderror
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('admin/js/adminlte.min.js')}}"></script>
</body>
</html>
