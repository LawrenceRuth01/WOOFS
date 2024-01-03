<?php
session_start();
require 'connect.php';
if (isset($_POST['submit'])) {
	$username=$_POST['username'];
	$password=$_POST['password'];

	if (empty($name)|| empty($password)) {
		$error="Please enter both username and password"; 
	} else {
		$sql="SELECT u_id,username,password FROM woofsdata WHERE username= ?";
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
            	$_SESSION['userId']=$user['u_id'];
            	$_SESSION['username']=$user['username'];
            	header("Location: home.html");

            	exit();
            	
            } else {
            	$error="Invalid password.";
            }
            } 
            else {
            	$error="Invalid username.";

            }
            $stmt->close();
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
	<h2 style="font-size: 24px; font-style:italic; text-align: center">Login</h2>
	<?php
	if (isset($error)) {
		echo '<p style= "color: red;">'.$error.'</p>';	 	
	 } 
	?>

	<form method="post" action="Login.php">
		<label for="username">Username:</label>
		<input type="text" name="username" required>
		<label for="password"> Password:</label>
		<input type="password" name="password"><br>

		<button type="submit">Login</button>

	</form>

	<p>Don't have an account, <a href="register.php"> Register here</a></p>

</body>
</html>