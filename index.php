<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">

<title>Sign up Page</title>

<style>
.error {color: #FF0000;}

input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>

</head>
    <body>
    
	    <?php
		include "subscription.php";
	    
		// define variables
		$fNameErr = $lNameErr = $mNumberErr = $emailErr = "";
		$firstName = $lastName = $mobileNumber = $email = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$firstName = $_POST["firstName"];
			if (empty($firstName)){
				$fNameErr = "First Name is required";
			} else {
				$firstName = input($_POST["firstName"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
				$fNameErr = "Only letters and white space allowed."; 
			}
		}}
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$lastName = $_POST["lastName"];
			if (empty($lastName)){
				$lNameErr = "Last Name is required";
			} else {
				$lastName = input($_POST["lastName"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
				$lNameErr = "Only letters and white space allowed"; 
			}
		}}
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$mobileNumber = $_POST["mobileNumber"];
			if (empty($mobileNumber)){
			$mNumberErr = "Mobile Number is required";
			} else {
				$mobileNumber = input($_POST["mobileNumber"]);
				// check if mobile number is digits
				if (!preg_match("/^\d{10}$/",$mobileNumber)) {
				$mNumberErr = "Please enter 10 digit mobile number"; 
			}
		}}		
		
		if ($_SERVER["REQUEST_METHOD"] = "POST") {
			$email = $_POST["email"];
			if(empty($email)){
			$emailErr = "Email is required";
			}
		} else {
			$email = input($_POST["email"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
			$emailErr = "Invalid email format";
			}
		}

		// strip data of special characters
		function input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		if(!is_null($firstName) && !empty($firstName)) {
			subscription($firstName, $lastName, $mobileNumber, $email);
		}
		
		?>

		<h2>WELCOME TO THE SIGN UP PAGE!</h2>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			First Name <span class="error"> <?php echo $fNameErr;?></span><br>
				<input type="text" name="firstName">
			<br><br>
			Last Name <span class="error"> <?php echo $lNameErr;?></span><br>
				<input type="text" name="lastName">
			<br><br>
			Mobile Number +1 <span class="error"> <?php echo $mNumberErr;?></span><br>
				<input type="text" name="mobileNumber">
			<br><br>
			Email Address <span class="error"> <?php echo $emailErr;?></span><br>
				<input type="text" name="email">
			<br><br>
			
			<input type="submit" name="submit" value="Submit">
		</form>
		
		<?php
		echo "<h2>Your input</h2>";
		echo $fName;
		echo "<br>";
		echo $lName;
		echo "<br>";
		echo $mNumber;
		echo "<br>";
		echo $email;
		?>

    </body>
</html>