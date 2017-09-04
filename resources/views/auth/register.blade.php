<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="http://localhost/Seminar/formstyle.css"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Anmelden</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
                <div class="panel-body">
                <form id="auftrag_form" class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <center><h3>Anmelden</h3></center><br />
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-7">
                            <input id="name" type="text"  name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Addresse</label>

                        <div class="col-md-7">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Passwort</label>

                        <div class="col-md-7">
                            <input id="password" type="password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Password bestätigen</label>

                        <div class="col-md-7">
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-4">
                            <button type="submit" >
                                Jetzt anmelden!
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</html>
