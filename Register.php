<?php
require_once('connect.php'); 

if ($_SERVER['REQUEST_METHOD']==='POST') {

	$username=$_POST['username'];
	$password=$_POST['password'];
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$age=$_POST['age'];
	$country=$_POST['country'];
	$gender=$_POST['gender'];
	$email=$_POST['email']; 

	if (empty($username)||empty($password)||empty($f_name)||empty($l_name)||empty($age)||empty($country)||empty($gender)||empty($email)) {
		$error="Please fill in all fields";
	} else{
		$hashedpassword= password_hash($password, PASSWORD_DEFAULT);

		$sql="INSERT INTO users (username, password, f_name, l_name, age, country, gender, email) VALUES (?,?,?,?,?,?,?,?)";
		$stmt=$conn->prepare($sql);
		$stmt=bind_param("sids", $username,$password,$f_name,$l_name,$age,$country, $gender,$email);

		if ($stmt->execute()) {
			$success="Successfully registered, you can now log in";

		} else{
			$error="Error during registration";
		}

		$stmt->close;

	}
}

?>
<html>
<head>
<style>
 body{ 
 	background-image: url('pup.jpg');
 	background-size: cover;
 	background-position: center center;
 	background-repeat: no-repeat;
 	height: 100vh}
</style>
</head>
<body>
	<h1 style=" color: black; font-size: 36px; font-style:italic; text-align: center;"> WOOFS </h1>
	<h2 style="font-size: 24px; font-style:italic; text-align: center">Register</h2>
	<?php
	if (isset($error)) {
		echo '<p style= "color: red;">'.$error.'</p>';	 	
	 } elseif (isset($sucess)) {
	 	echo '<p style="color:green;">'.$success.'</p>';
	 }
	?>

	<form method="post" action="Register.php">
		<label for="username">Username:</label>
		<input type="text" name="username" required>
		<label for="password"> Passwrd: </label>
		<input type="password" name="password">
		<label for="f_name">Fist Name:</label>
		<input type="text" name="f_name">
		<label for="l_name">Last Name:</label>
		<input type="text" name="l_name">
		<label for="age">Age:</label>
		<input type="number" name="age" required>
		<label for="country">Country:</label>
		<select class="" name="country" required>
			<option value="" selected hidden>Selected Country</option>
			<option value="Kenya">Kenya</option>
			<option value="Uganda">Uganda</option>
			<option value="Tanzania">Tanzania</option>
		</select>
		<label for="gender">Gender:</label>
		<input type="radio" name="gender" value="male" required>Male
		<input type="radio" name="gender" value="female" required>Female
		<label for="email">Email:</label>
		<input type="email" name="email" required>

		<button type="submit">Register</button>
	</form>

	<p>Already have an account? <a href="Login.php">Log in here</a></p>

</body>
</html>


