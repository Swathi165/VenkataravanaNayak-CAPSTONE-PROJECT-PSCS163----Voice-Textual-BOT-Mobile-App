<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <title>View Cart</title>
    <style>
        .container{
            width: 80%;
            height: 60vh;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        .img{
            width: 400px;
            margin: 0 auto;
        }
        .img img{
            width: 100%;
            height: 100%;
        }
        .btn{
            border: 1px solid #000080;
            padding: 5px 20px;
            color: #fff;
            font-weight: 500;
            background: #000080;
            letter-spacing: 1.2px;
            transition: all 0.3s ease-in-out;
        }
        .btn:hover{
            background: transparent;
            color: #000080;
        }
        .heading{
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        @media (max-width: 1024px) {
            .img{
                width: 300px;
            }
        }
        @media (max-width: 425px) {
            .container{
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="img">
            <img src="users/assets/images/empty_cart.gif" alt="">
        </div>
        <p class='heading'>Your cart is empty!</p>
        <p>Add items to it now.</p>
        <a class='btn' href="users/login">Login Now</a>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>