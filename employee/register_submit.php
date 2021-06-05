<?php
require('connection.inc.php');
require('function.inc.php');

$name=get_safe_value($con,$_POST['name']);
$email=get_safe_value($con,$_POST['email']);
$password=get_safe_value($con,$_POST['password']);
$company_id=get_safe_value($con,$_POST['company_id']);
$division_id=get_safe_value($con,$_POST['division_id']);
$district_id=get_safe_value($con,$_POST['district_id']);

$check_user=mysqli_num_rows(mysqli_query($con,"select * from employee where email='$email'"));

if($check_user>0){
	echo "email_present";
}else{
	mysqli_query($con,"insert into employee(name,email,password,company_id,division_id,district_id) values('$name','$email','$password','$company_id','$division_id','$district_id')");
	echo "insert";
}
?>