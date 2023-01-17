
<?php

$conn = mysqli_connect('localhost', 'root', '', 'ecomm');
$type = 0;
$error = ['error' => ''];

if(isset($_POST['signup'])){

	$fname = $_POST['firstname'];
	$lname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword =($_POST['repassword']);
	if ($password == $repassword):
		$pass = password_hash($password, PASSWORD_DEFAULT);
		$sql = ("insert into users (firstname,lastname,email,password,type) values ('$fname','$lname','$email','$pass','$type')");
		$result = mysqli_query($conn,$sql);
	
		if ($result) { 
			$error['error'] ='Register successfully';
			header('location:login.php');
		}
		else{
			$error['error'] ='something wrong happened';
		}
	else:
		$error['error'] ="password didn't match";
	endif;

}
?>