<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gehit</title>

</head>

<body style="background-color: #ffffff;">
    <div style="width: 100%; text-align: center; color: #808080; font-family: Geneva;">
        <div style="margin-left: 20%; margin-right: 20%;">
            <div style="width: 100%;">
                <img style="width: 30%;" src={{ config('app.front_end_domain', 'http://localhost:8080/') }}img/gehitlogo.868ce717.jpeg />
            </div>
            <div style="text-align: justify;">
                <p>
                    A new password has been generated for you. Your new password is:
                </p>
            </div>
            <h2> {{ $newPassword }} </h2>

            <br /><br />
            <div style="text-align: justify;">
                <b>
                    The Gehit Team
                </b>
                <p>
                    If you received this email by mistake, you can safely ignore it.
                </p>
            </div>
        </div>

        <div style="position:fixed; left: 0; width: 100%; background-color: #cc4400; color: #e6e6e6; text-align:center; padding: 25px; bottom: 0;">
            <p>&copy; {{ date('Y') }} Gehit.com</p>
        </div>

    </div>



</body>

</html>