<?php
    include_once('connect.php');
    session_start();


    if (empty($_SESSION['c_id'])) {
        header("Location: ./index.php?error=notloggedin");
        //echo "empty: ".$_SESSION['c_id'];
    }
    //print_r($_SESSION['qty']);

    if (!isset($_SESSION['totalPrice'])) {
        $_SESSION['totalPrice'] = 0;
        $_SESSION['totalProduct'] = 0;
        for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
            $_SESSION['qty'][$i] = 0;
            $_SESSION['amounts'][$i] = 0;
        }
    }

    if (isset($_POST['purchase-cart']) && $_POST['randcheck']==$_SESSION['rand']) {
        if ($_SESSION['totalProduct'] == 0) {
            echo '<script>alert("Can\'t make a purchase with an empty cart!")</script>';
        }
        else {
            $result = pg_query($dbconn,"INSERT INTO Orders (c_id, o_id, o_shipDate) VALUES (".$_SESSION['c_id'].", DEFAULT, '".date('Y-m-d')."');");
            //echo "<p>INSERT INTO Orders (c_id, o_id, o_shipDate) VALUES (".$_SESSION['c_id'].", DEFAULT, '".date('Y-m-d')."');</p>";
            $result = pg_query($dbconn,"SELECT * FROM Orders ORDER BY o_id DESC LIMIT 1;");
            $row = pg_fetch_assoc($result);
            
            //INSERT INTO Contains (o_id, p_id, p_quantity) VALUES (75, 3, 2);
            $result = pg_query($dbconn,"SELECT * FROM product;");
            for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
                if ($_SESSION['qty'][$i] > 0) {
                    $result = pg_query($dbconn,"INSERT INTO Contains (o_id, p_id, p_quantity) VALUES (".$row['o_id'].", ".$i.", ".$_SESSION['qty'][$i].");");
                    //echo "<p> INSERT INTO Contains (o_id, p_id, p_quantity) VALUES (".$row['o_id'].", ".$i.", ".$_SESSION['qty'][$i].");</p>";
                }
            }

            $_SESSION['totalPrice'] = 0;
            $_SESSION['totalProduct'] = 0;
            for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
                $_SESSION['qty'][$i] = 0;
                $_SESSION['amounts'][$i] = 0;
            }

            header("Location: ./order.php");
            exit();
        }
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
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
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
    <div class="container-fluid" style="background: rgba(248,249,252,0);width: 1130px;">
        <h3 class="text-dark mb-4"></h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Cart</p>
            </div>
            <div class="card-body" style="padding: 0px 20px;">
                <div class="table-responsive table mt-2" id="dataTable-2" role="grid" aria-describedby="dataTable_info" style="margin: 0px 0px 16px 0px;">
                    <table class="table my-0" id="Cart">
                        <thead>
                            <tr>
                                <th style="width: 750px;">Item Name</th>
                                <th style="opacity: 1;width: 45px;padding: 12px 8px;">Quantity</th>
                                <th style="width: 100px;padding: 12px 8px;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = pg_query($dbconn,"SELECT * FROM product;");
                                for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
                                    $row = pg_fetch_assoc($result);
                                    if ($_SESSION['qty'][$i] > 0) {
                                        //echo "<p>Product ID: '$i', has ".$_SESSION['qty'][$i]."</p>";
                                        //$result = pg_query($dbconn,"SELECT * FROM product WHERE p_id = '$i';");
                                        //$row = pg_fetch_assoc($result);
                                        $price = $row['p_price'] * $_SESSION['qty'][$i];
                                        //$_SESSION['total'] = $_SESSION['total'] + $price;
                                        echo '
                                        <tr class="navigation-clean-button" style="height: 36px;text-align: left;padding: 4px;margin: 2px;border-width: 2px;border-top-color: rgb(33,;border-bottom-color: 41);border-left-color: 37,;">
                                            <td style="border-right-width: 10px;border-right-color: rgb(0,119,238);text-align: left;padding: 12px 8px;width: 100px;">
                                                '.$row['p_name'].'
                                            </td>
                                            <td style="padding: 12px 8px;">
                                                '.$_SESSION['qty'][$i].'
                                            </td>
                                            <td style="padding: 12px 8px;">
                                                $'.$price.'
                                            </td>
                                        </tr>
                                ';

                                    }
                                    //$_SESSION['totalProduct'] = $_SESSION['totalProduct'] + $_SESSION['qty'][$i];
                                
                                } 
                            
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <?php
                                    echo '
                                        <td style="width: 100px;">
                                            <strong>
                                                Item Count: '.$_SESSION['totalProduct'].'
                                            </strong>
                                        </td>
                                        ';
                                ?>
                                <td><strong>Total Price:</strong></td>
                                <?php
                                    echo '
                                        <td>
                                            <strong>
                                                $'.$_SESSION['totalPrice'].'
                                            </strong>
                                        </td>
                                        ';
                                ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <footer class="footer-basic" style="text-align: center;">
                    <?php
                        $rand=rand();
                        $_SESSION['rand'] = $rand;
                        echo "
                            <form method='post' action='' style='height: 60px; padding: 0px;'>
                                <input type='hidden' value='".$rand."' name='randcheck' />
                                <button class='btn btn-primary' type='submit' name='purchase-cart' style='margin: 0px 0px 30px;'>
                                    Purchase
                                </button>
                            </form>
                            ";
                    ?>
                    <p class="copyright">Medicine Dealers © 2021</p>
                </footer>
                <script>
$(document).ready(function() {
    $('#Orders tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {
            window.location = href;
        }
    });

});
</script>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/hoverclick.js"></script>
    <script src="assets/js/quantity.js"></script>
</body>

</html>