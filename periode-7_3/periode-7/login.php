<?php
require_once 'conn.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.scss">
    
</head>
<body>
    <div id="loginField">
            <div class="foreground"></div>
            <div class="container">
                <div class="row">
                <div class="col-12 col-md-7">
                    <form method="post" action="login_handler.php">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">
                                <i class="ph ph-envelope"></i>
                                <h2>Email address</h2></label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                            <div id="emailHelp" class="form-text">
                                <span>wij zullen nooit uw mail delen met andere.</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">
                                <i class="ph ph-password"></i>
                                <h2>Wachtwoord</h2>
                            </label>
                            <input  type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        </div>
                        
                        <div class="btn">
                            <input type="submit" name="submit" value="Login">
                        </div>
                        <div class="btn">
                            <a href="index.php">register</a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>