<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($con,$str){
	if($str!=''){
		$str=trim($str);
  		$str = stripcslashes($str);
  		$str = htmlspecialchars($str);
		return mysqli_real_escape_string($con,$str);
	}
}

function get_product($con,$cat_id='',$product_id='',$is_best_seller='',$limit='',$search_str='',$sort_order=''){
	$sql="select product.*,category.cat_name from product,category where product.status=1 ";
	//category wise product show
	if($cat_id!=''){
		$sql.=" and product.category_id=$cat_id ";
	}
	//product details show
	if($product_id!=''){
		$sql.=" and product.id=$product_id ";
	}
	//best seller product show
	if($is_best_seller!=''){
		$sql.=" and product.best_seller=1 ";
	}
	$sql.=" and product.category_id=category.id ";
	if($search_str!=''){
		$sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%') ";
	}
	if($sort_order!=''){
		$sql.=$sort_order;
	}else{
		$sql.=" order by product.id desc ";
	}
	if($limit!=''){
		$sql.=" limit $limit";
	}
	
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function productSoldQtyByProductId($con,$pid){
	$sql="select sum(order_detail.qty) as qty from order_detail,`order` where `order`.id=order_detail.order_id and order_detail.product_id=$pid and `order`.order_status!=4 and (`order`.payment_type='COD' and `order`.payment_status!='')";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function productQty($con,$pid){
	$sql="select qty from product where id='$pid'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function wishlist_add($con,$uid,$pid){
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($con,"insert into wishlist(user_id,product_id,added_on) values('$uid','$pid','$added_on')");
}


?>