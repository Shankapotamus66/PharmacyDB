<?php
	include_once('connect.php');
	session_start();
	//connecting to the DB and saving the connection into dbconn
	//$connection_string = "host = localhost port = 5432 dbname = pharmacydb user = pharmacy password = CMPS3420";
	//$dbconn = pg_connect($connection_string);
	//if(!$dbconn){
	//	echo '<p> error connecting</p>';
	//}else {
	//	echo '<p>connected</p>';
	//}

	if (!empty($_SESSION['c_id'])) {
        header("Location: ./index.php?error=loggedin");
        //echo "empty: ".$_SESSION['c_id'];
    }

	$accountExists = 0;
	$missingInfo = 0;
	//$_SESSION['accountExists'] = TRUE;

	//$query = "SELECT * FROM customer LIMIT 50";

	//$rs = pg_query($dbconn, $query) or die("stop\n");
	//while($row = pg_fetch_row($rs)){
		//echo "CID: $row[0] FNAME: $row[1] LNAME: $row[2] PNUM: $row[3] EMAIL: $row[4] PASS: $row[5] DOC: $row[6] DOB: $row[7]\n";
	//}
	//pg_close($dbconn);
	
	//echo '<p> before if</p>';
	//registering data into the database
	if(isset($_POST['register'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$dname = $_POST['dname'];
		$state = $_POST['state'];
		$address = $_POST['address'];
		$number = $_POST['number'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$dob = $_POST['dob'];
		$city = $_POST['city'];
		$zip = $_POST['zip'];
		/*
		echo '<p>fname: '.$fname.'</p>';
		echo '<p>lname: '.$lname.'</p>';
		echo '<p>dname: '.$dname.'</p>';
		echo '<p>state: '.$state.'</p>';
		echo '<p>address: '.$address.'</p>';
		echo '<p>number: '.$number.'</p>';
		echo '<p>email: '.$email.'</p>';
		echo '<p>password: '.$password.'</p>';
		echo '<p>dob: '.$dob.'</p>';
		echo '<p>city: '.$city.'</p>';
		echo '<p>zip: '.$zip.'</p>';
		*/

		if (strlen($fname) == 0 || strlen($lname) == 0 || strlen($number) == 0 || strlen($password) == 0 
				|| strlen($dname) == 0 || strlen($dob) == 0 || strlen($address) == 0 || strlen($city) == 0 
				||  strlen($state) == '' || strlen($zip) == 0) {
			$missingInfo = 1;
		}
		else {
			//ADDRESS FORMAT - address, City, State, ZIP
			$addy = $address . ", " . $city . ", " . $state . ", " . $zip;
			//echo '<p>addy: '.$addy.'</p>';

			//echo '<p> before query</p>';
			//$query = pg_query($dbconn, "INSERT INTO customer
			//	(c_fname, c_lname, c_phonenum, c_email, c_password, c_doctor, c_dob, c_address) VALUES
			//	('$fname','$lname','$number','$email','$password','$dname','$dob','$addy');");

			$emailCheck = pg_query($dbconn, "SELECT c_email FROM Customer WHERE c_email = '$email';");
			$row = pg_fetch_assoc($emailCheck);
			if ($row['c_email'] == $email) {
				//echo '<p> EMAIL EXISTS: '.$row['c_email'].'</p>';
				$accountExists = 1;
			}
			else {
				
				$query = pg_query($dbconn, "SELECT registerCustomer('$fname','$lname','$number','$email','$password','$dname','$dob','$addy');");
		
				//$query = "INSERT INTO customer (c_fname,c_lname,c_phonenum,c_email,c_password,c_doctor,c_dob,c_address) VALUES
					//					('test','test','6611234567','test@test.com','1141282','testdoc','08271995')";
			
				$val = pg_fetch_result($query, 1, 0);
				//echo "Test: ".$val;
				//pg_query($query);
				//echo '<script>alert($query)</script>';	
				if($query){
					//echo '<p> Success </p>';
				}else {
					//echo '<p> Failed to add </p>';
				}
			}
		}	
	}
	//echo'<p> after if</p>';
	//closing the connection to the database
	pg_close($dbconn);
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
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop<br></a></li>
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
    <section class="register-clean" style="background: rgba(241,247,252,0);box-shadow: 7px 0px;padding: 40px;">
        <form method="post" style="text-align: left;">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" style="color: rgb(28,151,179);">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6569 2.75736C15 0.414213 18.799 0.414214 21.1421 2.75736C23.4853 5.1005 23.4853 8.8995 21.1421 11.2426L11.2426 21.1421C8.89949 23.4853 5.1005 23.4853 2.75736 21.1421C0.414214 18.799 0.414213 15 2.75736 12.6569L12.6569 2.75736ZM19.7279 9.82843L15.4853 14.0711L9.82843 8.41421L14.0711 4.17157C15.6332 2.60948 18.1658 2.60948 19.7279 4.17157C21.29 5.73367 21.29 8.26633 19.7279 9.82843Z" fill="currentColor"></path>
                </svg>
                <h1></h1>
				<h1 style="color: rgb(28,151,179);">Register Account</h1>
				<?php
					if ($accountExists == 1) {
						echo '<h6 style="color: rgb(252, 101, 71);">Account with this email already exists.</h6>';
					}
					if ($missingInfo == 1) {
						echo '<h6 style="color: rgb(252, 101, 71);">Must fill out all fields.</h6>';
					}

				?>
                <div class="container"><a class="forgot"></a></div>
            </div>
            <div class="container" style="padding: 0px;">
                <div class="form-row">
                    <div class="col-md-6">
			    <input class="form-control" type="text" name="fname" placeholder="First Name"   id="fname" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" type="text" name="email" placeholder="Email"       id="email" style="box-shadow: 2px 2px 4px rgb(156,156,156);margin: 12px 0px;width: 300px;">
			    <input class="form-control" type="text" name="number" placeholder="Phone Number" id="number" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" type="text" name="address" placeholder="Address"    id="address" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" type="text" name="state" placeholder="State"        id="state" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" type="text" name="dname" placeholder="Doctor Name" id="dname" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;"></div>
                    <div class="col-md-6" style="padding: 0px 0px 0px 20px;">
			    <input class="form-control" type="text" name="lname" placeholder="Last Name"       id="lname" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" type="text" name="password" placeholder="Password"id="password" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" name="dob" placeholder="Date of Birth"           id="dob" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;padding: 0px;" type="date">
			    <input class="form-control" type="text" name="city" placeholder="City"            id="city" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;">
			    <input class="form-control" type="text" name="zip" placeholder="Zip"              id = "zip" style="box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 12px 0px;"></div>
                </div>
            </div>
	    <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name ="register" id="register" style="background: rgb(28,151,179);margin: 14px 170px 0px;color: rgb(255,255,255);box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;">
		Register</button></div>
		<a class="btn btn-primary btn-block" role="button" href="login.php" style="background: rgb(224, 224, 224);text-shadow: 0px 0px;box-shadow: 2px 2px 4px rgb(156,156,156);width: 300px;margin: 14px 170px 0px;color: rgb(28,151,179);">
			Log In
		</a>
		<a class="forgot" href="login.php">
			Already have an account? Then log in!
		</a>
        </form>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/quantity.js"></script>
</body>

</html>
