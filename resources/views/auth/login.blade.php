
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
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
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in your account</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">       
            <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
       
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">          
          <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>              
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class=" text-center mb-3"> 
      <p>- OR -</p>
      <p class="mb-1">
       @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Password?') }}
        </a>
         @endif
       
     
         
        @if (Route::has('register'))                            
            <a  class="btn btn-primary btn-block" href="{{ route('register') }}">{{ __('Register  a new User') }}</a>                              
        @endif        
      </p>
    </div>
    </div> 
    <!-- /.login-card-body -->
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
