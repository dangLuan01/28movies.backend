<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In</title>
    @include('partial.head')
    @include('partial.scripts')
</head>
<body>
   <!-- sign in -->
    <div class="sign section--bg" data-bg="/assets/img/bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">
                        <!-- authorization form -->
                        <form method="POST" class="sign__form" action="{{ route('login') }}">
                            @csrf
                            <div class="sign__logo">
                                <img src="/assets/img/logo.svg" alt="" />
                            </div>
                            <div class="sign__group">
                                <input id="email" type="email" class="sign__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="sign__group">
                            <input id="password" type="password" class="sign__input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                                @error('password')
                                    <span class="invalid-feedback" style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="sign__group sign__group--checkbox">
                                <input id="remember" name="remember" type="checkbox" checked="checked" />
                                <label for="remember">Remember me</label>
                            </div>
                            <button class="sign__btn" type="submit">Sign in</button>
                        </form>
                        <!-- end authorization form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end sign in -->
</body>
</html>
