@extends('auth')
@section('content')

<div class="container mt--8 pb-2">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-3">
              <div class="text-center">
                <small>Connectez-vous avec vos identifiants</small>
              </div>
            </div>
            <div class="card-body px-lg-3 py-lg-3">
              <div class="text-center text-muted mb-4">
              </div>
              <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group ">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id=" customCheckLogin">
                            <label class="custom-control-label" for=" customCheckLogin">
                                <span class="text-muted">Remember me</span>
                            </label>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">Se connecter</button>
                        </div>
                    </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              @if (Route::has('password.request'))
                <a class="text-light" href="{{ route('password.request') }}">
                <small>{{ __('Mot de passe oublié?') }}</small>
                </a>
              @endif
            </div>
           
          </div>
        </div>
      </div>
    </div>
@endsection
