<!doctype html>
<html ng-app="website">
<head>
<meta charset="utf-8">
<title>EXdeliver - PlayList</title>

<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Lato:400,300,700,900' rel='stylesheet' type='text/css' />

<!-- Styles -->
<link href="/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/themify-icons.css" type="text/css" /><!-- Icons -->
<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" /><!-- Bootstrap -->
<link rel="stylesheet" href="/css/website.css" type="text/css">
<link rel="stylesheet" href="/css/responsive.css" type="text/css" /><!-- Responsive -->
<link rel="stylesheet" href="/css/perfect-scrollbar.css" type="text/css" /><!-- Responsive -->

</head>
<body>
    @yield('background')
    <div class="header show">
<header>

<section class="ng-scope">
    <div class="organisation organisation-name">
        <h2>@yield('name')</h2>
    </div>

    <div class="logo ng-scope">
        <span>Powered by:</span> <a href="/" title="">EXdeliver - PlayList</a>
    </div>

<div class="accountservice">
    @if(Sentry::check()))
    <a href="/logoff" class="btn btn-warning">Sign out</a>
    @else
    <a href="/login" class="btn btn-primary">Login</a> <a href="/signup" class="btn btn-success">Register</a>
    @endif
</div>
<div class="dropdown profile ng-scope">
	<a title="">
	</a>
</div>
</section>
	</header>
</div>
	<div class="mian">
	    <div class="view-container">
	        <div id="container">
            @yield('content')
            </div>
        </div>
    </div>
<script type="text/javascript" src="/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="/js/jqueryui-1.10.3.min.js"></script>
@yield('bottomscripts')

<?php
$cookielaw = Cookie::get('dontallowcookies');
$cookievenster = Cookie::get('dontshowvenster');
?>

@if(!isset($cookievenster))
    <div class="cookiemelding">
    Wij gebruiken cookies om uw gebruikerservaring te verbeteren.<br />
        <a href="/dontshowcookie" style="color: black;" rel="nofollow">Sluit venster [ X ]</a>
    </div>
@endif
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33276780-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
