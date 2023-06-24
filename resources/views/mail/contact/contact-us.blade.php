<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact us</title>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td width="640">
            <table border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody>
                <tr>
                    <td width="640">
                        <div class="content-block">
                            <p>Salut, ai primit o noua solicitare de la {{ $data['name'] }}, cu urmatorul mesaj: </p>
                            <p>{{ $data['message'] }}</p>
                            <p>Raspunde-i pe adresa de mail lasata ca si contact: {{ $data['email'] }}</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="40" width="640"> </td>
                </tr>
                <tr>
                    <td>
                        <p align="center">Multumesc, <em>Aplicatia mobila</em></p>
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
