<?php
require('connection.inc.php');
require('function.inc.php');

$email=get_safe_value($con,$_POST['email']);
$password=get_safe_value($con,$_POST['password']);

$res=mysqli_query($con,"select * from employee where email='$email' and password='$password'");
$check_user=mysqli_num_rows($res);
if($check_user>0){
	$row=mysqli_fetch_assoc($res);
	$_SESSION['EMP_LOGIN']='yes';
	$_SESSION['EMP_ID']=$row['id'];
	$_SESSION['EMP_NAME']=$row['name'];
	echo "valid";
}else{
	echo "wrong";
}
?>