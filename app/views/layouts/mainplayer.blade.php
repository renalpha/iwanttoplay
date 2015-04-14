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

<a title="" class="slide-panel-btn gray ng-scope"><i class="fa fa-thumbs-up"></i> Support</a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $(window).scroll(
            {
                previousTop: 0
            },
            function () {
            // get current distance from top of viewport
            var currentTop = $(window).scrollTop();
            // define the header height here
            var headerHeight = 50;
            // if user has scrolled past header, initiate the scroll up/scroll down hide show effect
            if( $(window).scrollTop() > headerHeight ) {
              if (currentTop < this.previousTop) {
                $(".sidebar em").text("Up");
                $(".header").removeClass("hide");
                $(".header").addClass("show");
              } else {
                $(".sidebar em").text("Down");
                $(".header").removeClass("show");
                $(".header").addClass("hide");
              }
            }
            this.previousTop = currentTop;
        });
    });
</script>
@yield('bottomscripts')

</body>
</html>
