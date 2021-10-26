
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choose Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="otp.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="choose.php" method="POST" autocomplete="off">
                    <h2 class="text-center">What do you want to register as</h2>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="customer" value="Customer">
                        <?php
                            if(isset($_POST['customer'])){
                                header('location: custreg.php');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <input class="form-control button" type="submit" name="trader" value="Trader">
                        <?php
                            if(isset($_POST['trader'])){
                                header('location: traderreg.php');
                            }
                        ?> 
                    </div>
                </form>
            </div>
        </div>
    </div>  
  
</body>
</html>