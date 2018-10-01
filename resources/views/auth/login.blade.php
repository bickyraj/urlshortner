<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: Bicky
Website: http://www.innologysolution.com/
Contact: bickyrajkayastha@gmail.com
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Url Shortner - Admin</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Yenkii world number 1 business." name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('assets/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">

        <link href="{{ asset('css/login-style.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <!-- END HEAD -->

    <body class="">
        <div class="fluid-container login-container">
            <div class="">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 login-form-div">
                    <form class="login-form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                        <div class="form-title">
                            <span class="form-title">Welcome.</span>
                            <span class="form-subtitle">Please login.</span>
                        </div>
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span> Enter any username and password. </span>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                            <label class="control-label visible-ie8 visible-ie9">Email</label>
                            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" value="{{ old('email') }}" placeholder="email" name="email" /> 
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label visible-ie8 visible-ie9">Password</label>
                            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn red btn-block uppercase">Login</button>
                        </div>
                        <div class="form-actions">
                            <div class="pull-left">
                                <label class="rememberme mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} /> Remember me
                                    <span></span>
                                </label>
                            </div>
                            <div class="pull-right forget-password-block">
                                <a href="{{ route('password.request') }}" id="forget-password" class="forget-password">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 padding-0 trump-login-right-container">
                    <div class="overlay">
                        
                    </div>
                    <div class="login-title animated fadeInRight">Trump</div>
                    <div class="login-bg">
                        <img src="{{ asset('img/login-bg.jpg') }}" alt="login">
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    </body>
</html>