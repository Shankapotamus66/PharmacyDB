<?php
		
		include_once('connect.php');

		session_start();
	//	if(!empty($_SESSION['e_id'])) {
	//		header("Location: ./index_employee.php?error=loggedin");
	//`	}
		


		$sql = "SELECT * FROM public.employee WHERE e_email = '".pg_escape_string($_POST['email'])."' and e_password = '".pg_escape_string($_POST['password'])."'";
		$data = pg_query($dbconn,$sql);
		$row = pg_fetch_assoc($data);
		$login_check = pg_num_rows($data);
		
		if($login_check > 0){
			echo "logged in";
			$_SESSION['e_id'] = $row['e_id'];
			$_session['e_email'] = $row['e_email'];
			header("Location: ./index_employee.php");
		}else {
			//echo "invalid log in";
		}
		$_SESSION['e_id'];
	

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>test</title>
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
                    <li class="nav-item"><a class="nav-link" href="shop.php" style="color: rgb(70,87,101);">Shop<br></a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php">Orders</a></li>
                </ul><span class="navbar-text actions"> <a class="login" href="login.html">Log In</a><a class="btn btn-light action-button" role="button" href="register.html" style="background: rgb(28,151,179);">Sign Up</a></span>
            </div>
        </div>
    </nav>
    <section class="login-clean" style="background: rgba(241,247,252,0);box-shadow: 7px 0px;padding: 80px 0px;">
        <form method="post" style="padding: 40px 40px 20px;">
            <h2 class="sr-only">Login Form</h2>
            <h1 style="font-size: 32px;text-align: center;color: rgb(28,151,179);height: 15px;">Employee</h1>
            <div class="illustration"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" style="color: rgb(28,151,179);">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6569 2.75736C15 0.414213 18.799 0.414214 21.1421 2.75736C23.4853 5.1005 23.4853 8.8995 21.1421 11.2426L11.2426 21.1421C8.89949 23.4853 5.1005 23.4853 2.75736 21.1421C0.414214 18.799 0.414213 15 2.75736 12.6569L12.6569 2.75736ZM19.7279 9.82843L15.4853 14.0711L9.82843 8.41421L14.0711 4.17157C15.6332 2.60948 18.1658 2.60948 19.7279 4.17157C21.29 5.73367 21.29 8.26633 19.7279 9.82843Z" fill="currentColor"></path>
                </svg></div>
            <div class="form-group"><input class="form-control" type="email" name="email" id="email" placeholder="Email" style="box-shadow: 2px 2px 4px rgb(156,156,156);"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" id="password" placeholder="Password" style="box-shadow: 2px 2px 4px rgb(156,156,156);"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: rgb(28,151,179);text-shadow: 0px 0px;box-shadow: 2px 2px 4px rgb(156,156,156);">Log In</button></div><a class="btn btn-primary btn-block" role="button" href="login.html" style="background: rgb(224,224,224);text-shadow: 0px 0px;box-shadow: 2px 2px 4px rgb(156,156,156);padding: 8px;width: 158px;font-size: 14px;height: 37px;margin: 31px 8px 0px 40px;color: rgb(28,151,179);">Customer Login Here</a>
        </form>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/hoverclick.js"></script>
    <script src="assets/js/quantity.js"></script>
</body>

</html>
