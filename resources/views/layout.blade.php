<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('./css/app.css')}}">
    <title>
        @yield('title')
    </title>
</head>
<body class="prof-body">

<header class="prof-header">
    <div class="prof-logo">
        <img src="{{asset('./assets/images/profiduciaria_logo_white.png')}}" alt="Profiduciaria Logo" width="200"/>
    </div>
    <nav class="prof-navigation">
        <ul class="prof-navigation-list">
            <li>
                <a href="tel:+40314378315" class="prof-navigation-link">
                    <i class="fa fa-phone"></i>
                    <span>(+40) 31 437 8315</span>
                </a>
            </li>
            <li>
                <a href="mailto:office@profiduciaria.ro" class="prof-navigation-link">
                    <i class="fa fa-envelope"></i>
                    suportclienti@profiduciaria.ro
                </a>
            </li>
        </ul>
    </nav>
</header>

<div class="prof-content">
    @yield('content')
</div>

<footer class="prof-footer">

</footer>
</body>
</html>
