<?php
	include_once('connect.php');
    session_start();

    if (empty($_SESSION['c_id'])) {
        header("Location: ./index.php?error=notloggedin");
        //echo "empty: ".$_SESSION['c_id'];
    }
    $result = pg_query($dbconn, "SELECT COUNT(*) FROM Product;");
    $row = pg_fetch_row($result);
    $_SESSION['productcount'] = $row[0];
    //echo "<p> 123 ".$_SESSION['productcount']."</p>";
    if (!isset($_SESSION['totalPrice'])) {
        $_SESSION['totalPrice'] = 0;
        $_SESSION['totalProduct'] = 0;
        for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
            $_SESSION['qty'][$i] = 0;
            $_SESSION['amounts'][$i] = 0;
        }
    }

    if (isset($_POST['add-cart']) && $_POST['randcheck']==$_SESSION['rand']) {
        //echo "<p>TOTAL PRODUCTS: ".$_SESSION['totalPrice']."</p>";
        //if (isset($_SESSION['totalPrice'])) {
        //    $_SESSION['totalPrice'] = 0;
        //    for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
        //        $_SESSION['qty'][$i] = 0;
        //        $_SESSION['amounts'][$i] = 0;
        //    }
        //}
        for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
            $currQty = $_POST[$i];
            $totQty = $_SESSION['qty'][$i];
            $_SESSION['qty'][$i] = $totQty + $currQty;

            $price = $_POST['p'.$i];
            $totPrice = $_SESSION['totalPrice'];
            $_SESSION['totalPrice'] = $totPrice + ($price * $currQty);
            //$_SESSION['amounts'][$i] = 0;
            //echo "<p> Product Price: ".$price."</p>";
            //echo "<p> Product Amount: ".$_SESSION['qty'][$i]."</p>";
            //echo "<p> Product Amount: ".$totQty."</p>";
            //echo "<p> Product Post: ".$_POST[$i]."</p>";
        } 
        
        for ($i = 1; $i <= $_SESSION['productcount']; $i++ ) {
            $_SESSION['totalProduct'] = $_SESSION['totalProduct'] + $_SESSION['qty'][$i];
        
        } 
        //print_r($_SESSION['qty']);
        //echo "<p> Total Product Amount: ".$_SESSION['totalProduct']."</p>";
        $email = $_SESSION['c_email'];
        //echo "<p>".$email."</p>";
        $i = $_GET['add'];
        //$test = $_POST[1];
        //echo "<p> Product Amount: ".$test."</p>";
        //$query = pg_query($dbconn, "SELECT deleteCustomerTest('$email');");
        //$_SESSION = array();
        //header("Location: ./index.php");
        //exit();
    }
//	$result = pg_query($dbconn," SELECT * FROM product LIMIT 5;");
	
//	echo "<html><body><table><tr><th>ID</th><th>Name</th><th>quantity</th><th>Prescription</th></tr>";
	
//	while($row = pg_fetch_assoc($result)){
//		echo"<tr>
//			<td>".$row['p_id']."</td>
//			<td>".$row['p_name']."</td>
//			<td>".$row['p_quantity']."</td>
//			<td>".$row['p_prescriptionneeded']."</td>
//			</tr>";
//	}
//	echo "</table></body></html>";
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
                <p class="text-primary m-0 font-weight-bold">Products</p>
            </div>
            <div class="card-body" style="padding: 0px 20px;">
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info" style="margin: 0px 0px 16px 0px;">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width: 420px;">Product Name</th>
                                <th style="opacity: 1;width: 99px;padding: 12px 8px;">Price</th>
                                <th style="width: 163px;padding: 12px 8px;">Over the Counter</th>
                                <th style="padding: 12px 8px;">Quantity</th>
                                <th style="width: 160px;height: 56px;padding: 12px 8px;">Purchase Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
				
<!-- loops and enters the products one at a time -->                                     
<?php 
    $result = pg_query($dbconn,"SELECT * FROM product;");
    $rand=rand();
    $_SESSION['rand'] = $rand;
	while($row = pg_fetch_assoc($result)) {
        //$perscrip = "test";
        if ($row['p_prescriptionneeded'] == 'f') {
            $perscrip = "Yes";
        }
        else {
            $perscrip = "No";
        }

        echo "
        <form method='post' action='' style='height: 30px; padding: 5px;'>
            <tr style='height: 36px;text-align: left;padding: 4px;margin: 2px;border-width: 2px;border-top-color: rgb(33,;border-bottom-color: 41);border-left-color: 37,;'>
                <td style='border-right-width: 10px;border-right-color: rgb(0,119,238);text-align: left;padding: 20px 8px;width: 360px;'>".$row['p_name']."</td>
                <td style='padding: 20px 8px;'>$".$row['p_price']."</td>
                <td style='padding: 20px 8px;'>".$perscrip."</td>
                <td style='padding: 20px 8px;'>".$row['p_quantity']."</td>
                <td style='width: 150px;padding: 11px;'>
                    <div class='input-group' style='border: solid; border-width:1px;border-radius: 5px; border-color: rgb(170, 170, 170);  height: 40px;'>
                        <span class='input-group-btn'> 
                            <button type='button' class='btn btn-default btn-number' style='height: 38;' disabled='disabled' data-type='minus' data-field='".$row['p_id']."'>
                                <i class='icon ion-minus'></i>
                            </button>
                        </span>
                        <input type='hidden' value='".$row['p_price']."' name='p".$row['p_id']."' />
                        <input type='text' name='".$row['p_id']."' class='form-control input-number' value='0' min='0' max='".$row['p_quantity']."'>
                        <span class='input-group-btn'>
                            <button type='button' class='btn btn-default btn-number' style='height: 38;' data-type='plus' data-field='".$row['p_id']."'>
                                <i class='icon ion-plus'></i>
                            </button>
                        </span>
                    </div>
                <td style='padding: 12px;'>
                        <input type='hidden' value='".$rand."' name='randcheck' />
                        <button class='btn btn-primary' type='submit' name='add-cart' style='background: var(--success);width: 108px;'>
                            Add to Cart
                        </button>
                </td>
            </tr>
            </form>";
	}
?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Name</strong></td>
                                <td><strong>Position</strong></td>
                                <td><strong>Office</strong></td>
                                <td><strong>Age</strong></td>
                                <td><strong>Start date</strong></td>
                                <td><strong>Salary</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <footer class="footer-basic">
                    <p class="copyright">Medicine Dealers © 2021</p>
                </footer>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/quantity.js"></script>
</body>

</html>
