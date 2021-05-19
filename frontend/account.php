<?php
    include_once('connect.php');
    session_start();
    //
    if (empty($_SESSION['c_id'])) {
        header("Location: ./index.php?error=notloggedin");
        //echo "empty: ".$_SESSION['c_id'];
    }
    else {
        //echo "<p>testing</p>";
        $data = pg_query($dbconn, "SELECT * FROM CustomerInfo WHERE ID = ".$_SESSION['c_id'].";");
        $row = pg_fetch_assoc($data);
        //echo "<p>First Name: ".$row["First"]."</p>";
    }
    //$ID = $_SESSION['c_id']

    //echo "<p>".$_SESSION['c_id']."</p>";
    //echo "<p>".$_SESSION['c_email']."</p>";
    //$email = $_SESSION['c_email'];
    //echo "<p>".$email."</p>";
    if (isset($_POST['delete-submit'])) {
        //echo "<p>".$_SESSION['c_id']."</p>";
        $email = $_SESSION['c_email'];
        //echo "<p>".$email."</p>";
        $query = pg_query($dbconn, "SELECT deleteCustomerTest('$email');");
        $_SESSION = array();
        header("Location: ./index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Medicine Dealers</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/hoverclick.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background: rgb(138,188,188);">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="background: rgb(220, 220, 220);opacity: 1;filter: invert(0%);border-bottom-style: inset;border-bottom-color: var(--gray);">
        <div class="container"><a class="navbar-brand" href="index.php" style="color: rgb(28,151,179);font-size: 20px;opacity: 1;">Medicine Dealers</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1" style="opacity: 1;">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php">Orders</a></li>
                </ul>
                <?php
                    if (empty($_SESSION['c_id'])) {
                        //header("Location: ./index.php?error=notloggedin");
                        //echo "empty: ".$_SESSION['c_id'];
                        echo '
                            <span class="navbar-text actions">
                                <a class="login" href="login.php">
                                    Log In
                                </a>
                                <a class="btn btn-light action-button" role="button" href="register.php" style="background: rgb(28,151,179);">
                                    Sign Up
                                </a>
                            </span>
                        ';
                    }
                    else {
                        echo '
                            <span class="navbar-text actions">
                                <a class="login" href="cart.php" style="padding: 8px;">
                                    <i class="fas fa-shopping-cart" style="color: rgb(28,151,179);"></i>
                                </a>
                                <a class="btn btn-light action-button" role="button" href="account.php" style="background: rgb(28,151,179);">
                                    Account
                                </a> 
                            </span>
                            <form method="post" action="logout.php"> 
                                <a>
                                    <button class="btn btn-link" type="submit" name="logout-submit" role="button" style="background: rgba(28,151,179,0); margin-left: 10px; margin-right: 10px;">
                                        Sign Out
                                    </button>
                                </a>
                            </form>
                            ';
                    }
                ?>
            </div>
        </div>
    </nav>
    <section class="register-clean" style="background: rgba(241,247,252,0);box-shadow: 7px 0px;padding: 40px;border-style: none;">
        <form method="post" style="text-align: left;">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <div class="container" style="border: 1px solid rgb(28,151,179);border-radius: 15px;">
                    <div class="form-row">
                        <div class="col-md-6" style="width: 304px;">
                            <i class="far fa-user-circle" style="color: rgb(28,151,179);border-color: rgb(28,151,179);"></i>
                            <?php
                                if (empty($_SESSION['c_id'])) {
                                    echo '
                                        <h1 style="margin: 0px;color: rgb(28,151,179);font-size: 32px;padding: 0px 0px 4px 0px;">
                                            Employee
                                        </h1>
                                        ';
                                }
                                else {
                                    echo '
                                        <h1 style="margin: 0px;color: rgb(28,151,179);font-size: 32px;padding: 0px 0px 4px 0px;">
                                            Customer
                                        </h1>
                                        ';
                                }
                            ?>
                            
                        </div>
                        <div class="col-md-6" style="padding: 40px 25px;">
                            <p style="font-size: 25px;border-color: rgb(35,35,35);border-top-color: rgb(244,;border-right-color: 71,;border-bottom-color: 107);border-left-color: 71,;color: rgb(28,151,179);text-align: left;margin: 0px;">
                                <strong>
                                    Account:
                                </strong>
                            </p>
                            <?php
                                echo '
                                    <p style="font-size: 25px;border-color: rgb(35,35,35);border-top-color: rgb(244,;border-right-color: 71,;border-bottom-color: 107);border-left-color: 71,;color: rgb(64,62,63);text-align: left;margin: 0px;">
                                        '.$row["First"].' '.$row["Last"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                    </div>
                </div>
                <h1></h1>
                <div class="container"><a class="forgot"></a></div>
            </div>
            <div class="container" style="padding: 0px;">
                <div class="form-row">
                    <div class="col-md-6">
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">First Name:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["First"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">Email:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["Email"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">DOB:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["DOB"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">Address:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["Address"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding: 0px 10px 0px 5px;">
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">Last Name:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["Last"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">Phone Number:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["Phone"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                        <div style="padding: 2px 5px;background: #f7f9fc;margin: 10px 0px;border: 1px solid rgb(28,151,179);">
                            <h1 style="font-size: 16px;">Doctor Name:</h1>
                            <?php
                                echo '
                                    <p style="font-size: 14px;margin: -8px 0px 0px 0px;">
                                        '.$row["Doctor"].'
                                    </p>
                                    ';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" style="text-align: center;" action="delete.php">
                <a>
                    <button class="btn btn-primary" type="submit" name="delete-submit" role="button" style="padding: 10px 10px;margin: 20px 245px 5px;width: 143px;">
                        Delete Account
                    </button>
                </a>
            </form>
        </form>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/hoverclick.js"></script>
    <script src="assets/js/quantity.js"></script>
</body>

</html>