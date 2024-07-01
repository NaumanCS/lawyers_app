<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Rejected</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            background: linear-gradient(to bottom, #007bff, #0056b3);
            border-radius: 10px;
            overflow: hidden;
            color: #ffffff;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .button {
            background-color: #ffffff;
            color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        img {
            max-width: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h2>Dear {{ $userName->name }},</h2>
            <p>{{ $messageOne }}</p>
            @isset($orderMessage)
            <p>{{ $orderMessage }}</p>   
            @endisset
           
            <br>
            <p>{{ $messageTwo }}</p>
            <p>
                Regards,<br>
                {{ $fromName }}
            </p>
            <p>
                <a href="{{ $url }}" class="button">Go to Website</a>
            </p>
        </div>
        <div class="footer">
            <img src="{{ asset('admin/assets/img/al-wakeel-logo.png') }}" alt="Logo">
        </div>
    </div>
</body>

</html>
