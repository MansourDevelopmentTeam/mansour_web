<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Reset password</title>
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
    <style>
        
        
        
        .reset-password-holder {
            padding: 40px;
            font-family: 'Cairo', sans-serif;
            text-align: center;
            background-color: #fff;
            width: 80%;
            margin: auto;
        }
        
        .reset-password-holder img {
            max-width: 60px;
            margin: auto;
        }
        
        .reset-password-holder h1,
        h3 {
            color: #767676;
            font-weight: 500;
            margin-bottom: 25px;
        }
        
        .reset-password-holder h1 {
            font-size: 24px;
            margin-top: 30px;
        }
        
        .reset-password-holder h3 {
            margin: 30px 0 10px 0;
        }
        
        .reset-password-holder p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .reset-password-holder span {
            letter-spacing: 15px;
            background-color: #ff3b5c;
            color: #fff;
            text-align: left;
            display: inline-block;
            padding: 15px 35px;
            font-size: 20px;
            border-radius: 5px;
        }
        
        @media (max-width: 425px) {
            .reset-password-holder {
                width: 100%;
                padding: 25px;
            }
            .reset-password-holder h1 {
                font-size: 25px;
            }
            .reset-password-holder h3 {
                font-size: 18px;
            }
            .reset-password-holder p {
                font-size: 14px;
            }
        }

    </style>
</head>

<body>

    <!-- reset password section -->
    <div class="reset-password-holder">
        <!-- <img src="{{URL::asset('')}}" alt="hayah"> -->
        <h1>Reset Password</h1>
        <h3>Hello {{$user->name}}</h3>
        <p>Please visit the following link to reset your passwird</p>
        ,<span><a style="color: white;" href="http://52.174.22.188/trollyadmin/reset-password?token={{$token}}">Reset</a></span>
    </div>
</body>

</html>