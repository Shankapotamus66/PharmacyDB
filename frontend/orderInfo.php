<?php
    include_once('connect.php');
    session_start();

    $orderID = $_GET['id'];
    $orderDate = $_GET['d'];
    if (empty($_SESSION['c_id'])) {
        header("Location: ./index.php?error=notloggedin");
        //echo "empty: ".$_SESSION['c_id'];
    }

    //This will kick the user out of the orderinfo screen if they try and 
    //select an order that does not belong to them.
    $result = pg_query($dbconn, 
                    "SELECT * FROM OrderInfo Where o_id = '$orderID';"
                );
    $row = pg_fetch_assoc($result);
    if ($row['c_id'] != $_SESSION['c_id'] || $row['o_ship'] != $orderDate) {
        header("Location: ./index.php?error=orderbelongstosomeoneelse");
        //DEBUG below
        //echo "<p>Order c_id: ".$row['c_id']."</p>";
        //echo "<p>Order o_id: ".$row['o_id']."</p>";
        //echo "<p>Order c_fname: ".$row['c_fname']."</p>";
        //echo "<p>Customer c_id: ".$_SESSION['c_id']."</p>";
    }
    //echo $_SESSION['orderID'];
    //while ($row = pg_fetch_assoc($result)) {
    //    echo "<p>".$row['c_fname']."</p>";
    //}
    $_SESSION['orderIDs'];

    //echo '<p>ID: '.$orderID.'</p>';
    //echo '<p>Date: '.$orderDate.'</p>';
    //echo '<p>ID: '.$_SESSION['orderIDs'].'</p>';
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
                <div style="height: 0px;">
                    <div class="row">
                        <div class="col">
                            <p></p>
                        </div>
                        <div class="col">
                            <p style="text-align: right;margin-bottom: 0px;">
                                <strong>
                                    DATE ORDERED: <?php echo "$orderDate" ?>&nbsp;&nbsp;
                                </strong>
                            </p>
                        </div>
                    </div>
                </div>
                <p class="text-primary m-0 font-weight-bold" style="text-align: left;">
                    Orders # <?php echo "$orderID"?> &nbsp;
                </p>
            </div>
            <div class="card-body" style="padding: 0px 20px;">
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info" style="margin: 0px 0px 16px 0px;">
                    <table class="table my-0" id="OrdersInfo">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Item ID</th>
                                <th style="opacity: 1;width: 300px;padding: 12px 8px;">Item Name</th>
                                <th style="width: 163px;padding: 12px 8px;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--Display the Orders-->
                            <?php
                                $result = pg_query($dbconn, 
                                    "SELECT Contains.*, Product.p_name 
                                    FROM Contains INNER JOIN Product 
                                    ON Contains.p_id = Product.p_id
                                    WHERE Contains.o_id = $orderID;"
                                );
                                while ($row = pg_fetch_assoc($result)) {
                                    echo "
                                    <tr class='navigation-clean-button' style='height: 36px;text-align: left;padding: 4px;margin: 2px;border-width: 2px;border-top-color: rgb(33,;border-bottom-color: 41);border-left-color: 37,;'>
                                        <td style='border-right-width: 10px;border-right-color: rgb(0,119,238);text-align: left;padding: 12px 8px;width: 100px;'>
                                            ".$row['p_id']."
                                        </td>
                                        <td style='padding: 12px 8px;'>
                                            ".$row['p_name']." ".$row['c_lname']."
                                        </td>
                                        <td style='padding: 12px 8px;'>
                                            ".$row['p_quantity']."
                                        </td>
                                    </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="width: 100px;"><strong>Item ID</strong></td>
                                <td><strong>Item Name</strong></td>
                                <td><strong>Quantity</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <footer class="footer-basic">
                    <p class="copyright">Medicine Dealers © 2021</p>
                </footer><script>
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