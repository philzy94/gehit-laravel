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
                <img style="width: 30%;" src=https://images.unsplash.com/photo-1524224971825-8c690dec4b7c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80 />
            </div>
            <div style="text-align: justify;">
                <p>
                    In order to complete your registration, we need to confirm that your email address is valid. To confirm that you can get our emails, please click the Verify button below:
                </p>
            </div>

            <a href={{ $emailVerificationLink }}><button style="background-color: #cc4400; min-width:100px; color:aliceblue; border-radius: 25px; border: 2px solid #cc4400; width: 30%; height: 30px; font-weight: bold;">Verify</button></a><br /><br />
            <div style="text-align: justify;">
                <p>
                    Or you can visit <a href="{{ $emailVerificationLink }}" >{{ $emailVerificationLink }}</a> to verify your email <br /> Thanks.
                </p>
            </div>

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