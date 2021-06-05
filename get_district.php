<?php
require('connection.inc.php');
require('function.inc.php');

$division_id=get_safe_value($con,$_POST['division_id']);
$dist_id=get_safe_value($con,$_POST['dist_id']);
$res=mysqli_query($con,"select * from district where division_id='$division_id'");
if(mysqli_num_rows($res)>0){
	$html='';
	while($row=mysqli_fetch_assoc($res)){
			
		$html.="<option value=".$row['id'].">".$row['name']."</option>";
	}
	echo $html;
}else{
	echo "<option value=''>No District found</option>";
}
?>