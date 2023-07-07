<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 50px">
    <tbody>
    <tr>
        <td width="640">
            <table border="0" cellpadding="0" cellspacing="0" width="640" style="margin:auto;background: white;padding: 20px;border-radius: 8px;">
                <tbody>
                <tr style="text-align: center">
                    <td width="100%">
                        <img src="{{URL::asset('assets/images/logo_profiduciaria_black.png')}}" alt="Pro Fiduciaria" style="width:200px" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h2>@yield('salutation')</h2>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid rgba(0,0,0,0.2);border-radius: 8px; padding: 10px;text-align: center;">
                            @yield('content')
                    </td>
                </tr>
                <tr style="text-align: center">
                    <td>
                        <p>Suntem mereu alaturi de tine</p>
                        <p><b>Echipa Pro Fiduciaria</b></p>
                    </td>
                </tr>
                <tr style="text-align: center;margin-bottom: 10px;">
                    <td style="background-color: #151948;color:#ffffff;border-radius: 8px;">
                        <h4 style="margin-top:5px;">Fii parte din comunitatea noastra</h4>
                    </td>
                </tr>
                <tr style="text-align: center">
                    <td style="padding-top: 20px">
                        <a href="https://www.facebook.com/ProFiduciaria/" style="margin-right: 10px;text-decoration: none;">
                            <img src="{{URL::asset('assets/icons/social/Facebook-48x48.png')}}" alt="Facebook" style="width:30px;height:30px"/>
                        </a>
                        <a href="" style="margin-right: 10px;text-decoration: none;">
                            <img src="{{URL::asset('assets/icons/social/YouTube-48x48.png')}}" alt="Youtube" style="width:30px;height:30px"/>
                        </a>
                        <a href="https://www.youtube.com/channel/UCx1k768KMZh61g5dsHOez5Q" style="margin-right: 10px;text-decoration: none;">
                            <img src="{{URL::asset('assets/icons/social/LinkedIn-48x48.png')}}" alt="Linkedin" style="width:30px;height:30px"/>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
