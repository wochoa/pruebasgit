@extends('layouts.loginp')

@section('content')


    <!-- /.login-logo -->
    <p class="principal">
      <img src="/img/logo.png" alt="" width="340" tabindex="10000">
    </p>

    <div class="card" style="background: #ffffff59 !important">
        {{-- <div class="card-header text-center"> --}}
          {{-- <a href="../../index2.html" class="h1">Iniciar Sesión</a> --}}
          
        {{-- </div> --}}
        <div class="card-body">
          <p class="login-box-msg text-white">Ingresa tus credencias para iniciar session</p>
    
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
                <input class="form-control {{ $errors->has('adm_email')|| $errors->has('adm_email') ? 'is-invalid':''}}" id="adm_email" type="text" name="adm_email" placeholder="Usuario..." aria-describedby="login-email" autofocus tabindex="1" value="{{ old('adm_email')?:old('adm_email') }}" onkeyup="javascript:this.value=this.value.toUpperCase();" required style="background-color: #ffffff0d !important; color:#ffffff"/>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
              @if($errors->has('adm_email')|| $errors->has('adm_email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('adm_email')?: $errors->first('adm_email') }}</strong>
                                    </span>
                                @endif
            </div>
            <div class="input-group mb-3">
              <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" style="background-color: #ffffff0d !important; color:#ffffff"/>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-6">
                <div class="icheck-primary">
                  
                  <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label for="remember text-white">
                    Recordarme
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-6">
                <button type="submit" class="btn btn-danger btn-block"><i class="fa-solid fa-circle-arrow-right"></i> Iniciar Sessión</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
    
          {{-- <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
          </div>
          <!-- /.social-auth-links --> --}}
    
          {{-- <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
          </p> --}}
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      {{-- <div class="card mt-1" style="background: #ffffff97 !important;">
        <div class="card-body">
          <div class="row">
            <div class="col-6 p-0 pr-1">
              
                <a href="/mesapartes" class="btn btn-block btn-secondary">
                  <i class="fa-solid fa-desktop"></i> Mesa de parte virtual
                </a>
                
            </div>
            <div class="col-6 p-0">
              <a href="/seguimientodetramite" class="btn btn-block btn-danger">
                <i class="fa-solid fa-users-gear"></i> Seguimiento de trámites
              </a>
            </div>
          </div>
        </div>
      </div> --}}
@endsection
