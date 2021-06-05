<?php
require('top.inc.php');
$msg2='';
$image_required='required';
//edit value show
if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id=get_safe_value($con,$_GET['id']);
	$res=mysqli_query($con,"select * from products where id='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$product_name=$row['product_name'];
		$category_id=$row['category_id'];
		$sub_categories_id=$row['sub_categories_id'];
		$brand_id=$row['brand_id'];
		$product_quantity=$row['product_quantity'];
		$product_details=$row['product_details'];
		$product_color=$row['product_color'];
		$product_size=$row['product_size'];
		$selling_price=$row['selling_price'];
		$hot_deal=$row['hot_deal'];
		$best_rated=$row['best_rated'];
		$hot_new=$row['hot_new'];
		$trend=$row['trend'];
		$buyone_getone=$row['buyone_getone'];
		$best_seller=$row['best_seller'];
		$meta_title=$row['meta_title'];
		$meta_description=$row['meta_description'];
		$meta_keyword=$row['meta_keyword'];
		$image=$row['image'];
	}else{
		header('location:products.php');
		die();
	}
}

//update
if(isset($_POST['submit'])){
	$product_name=get_safe_value($con,$_POST['product_name']);
	$category_id=get_safe_value($con,$_POST['category_id']);
	$sub_categories_id=get_safe_value($con,$_POST['sub_categories_id']);
	$brand_id=get_safe_value($con,$_POST['brand_id']);
	$product_quantity=get_safe_value($con,$_POST['product_quantity']);
	$product_details=get_safe_value($con,$_POST['product_details']);
	$product_color=get_safe_value($con,$_POST['product_color']);
	$product_size=get_safe_value($con,$_POST['product_size']);
	$selling_price=get_safe_value($con,$_POST['selling_price']);
	$hot_deal=get_safe_value($con,$_POST['hot_deal']);
	$best_rated=get_safe_value($con,$_POST['best_rated']);
	$hot_new=get_safe_value($con,$_POST['hot_new']);
	$trend=get_safe_value($con,$_POST['trend']);
	$buyone_getone=get_safe_value($con,$_POST['buyone_getone']);
	$best_seller=get_safe_value($con,$_POST['best_seller']);
	$meta_title=get_safe_value($con,$_POST['meta_title']);
	$meta_description=get_safe_value($con,$_POST['meta_description']);
	$meta_keyword=get_safe_value($con,$_POST['meta_keyword']);
	$id=get_safe_value($con,$_GET['id']);

	    $permited  = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_temp = $_FILES['image']['tmp_name'];

	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

    	if(!empty($file_name)){
		    if($file_size >1048567) {
				$msg  = "Image Size should be less then 1MB!";

			}else if (in_array($file_ext, $permited) === false) {
				$msg  = "You can upload only:-".implode(', ', $permited);

			}else{
	    	move_uploaded_file($file_temp, $uploaded_image);
	    	$query = "update products set product_name='$product_name',category_id='$category_id',sub_categories_id='$sub_categories_id',brand_id='$brand_id',product_quantity='$product_quantity',product_details='$product_details',product_color='$product_color',product_size='$product_size',selling_price='$selling_price',hot_deal='$hot_deal',best_rated='$best_rated', hot_new='$hot_new',trend='$trend',buyone_getone='$buyone_getone',best_seller='$best_seller', meta_title='$meta_title',meta_description='$meta_description',meta_keyword='$meta_keyword', image='$uploaded_image' where id='$id'";
			$inserted_row = mysqli_query($con,$query);
			if($inserted_row) {
				$msg2  = "Product Updated successfully.";
			} else{
				$msg2  = "Product not inserted.";				
			}
		}	
	    } else {

	    	$query = "update products set product_name='$product_name',category_id='$category_id',sub_categories_id='$sub_categories_id',brand_id='$brand_id',product_quantity='$product_quantity',product_details='$product_details',product_color='$product_color',product_size='$product_size',selling_price='$selling_price',hot_deal='$hot_deal',best_rated='$best_rated', hot_new='$hot_new',trend='$trend',buyone_getone='$buyone_getone',best_seller='$best_seller', meta_title='$meta_title',meta_description='$meta_description',meta_keyword='$meta_keyword' where id='$id'";
			$inserted_row = mysqli_query($con,$query);
			if($inserted_row) {
				$msg2  = "Product Updated successfully Without image.";
			} else{
				$msg2  = "Product not inserted.";				
			}
	    }
	    
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">

<div class="content pb-0">
<div class="animated fadeIn">
<div class="row">
  <div class="col-lg-12">
     <div class="card">
        <div class="card-header">
        <h3>Product Edit Form
          <a class="btn btn-success float-sm-right" href="products.php"><i class="fa fa-list"></i>Product List</a>
        </h3>
        </div>
        <form method="post" enctype="multipart/form-data">
			<div class="card-body card-block">

			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Name</label>
				<input type="text" name="product_name" placeholder="Enter product name" class="form-control" required value="<?php echo $product_name?>">
			</div>

		   <div class="form-group">
				<label for="categories" class=" form-control-label">Categories</label>
				<select class="form-control" name="category_id" id="category_id" onchange="get_sub_cat('')">
					<option>Select Category</option>
					<?php
					$res=mysqli_query($con,"select id,categories_name from categories order by categories_name asc");
					while($row=mysqli_fetch_assoc($res)){
						if($row['id']==$category_id){
							echo "<option selected value=".$row['id'].">".$row['categories_name']."</option>";
						}else{
							echo "<option value=".$row['id'].">".$row['categories_name']."</option>";
						}
						
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="categories" class=" form-control-label">Sub Categories</label>
				<select class="form-control" name="sub_categories_id" id="sub_categories_id">
					<option>Select Sub Category</option>
				</select>
			</div>
		   <div class="form-group">
				<label for="brands" class=" form-control-label">Brands</label>
				<select class="form-control" name="brand_id">
					<option>Select Brand</option>
					<?php
					$res=mysqli_query($con,"select id,brands_name from brands order by brands_name asc");
					while($row=mysqli_fetch_assoc($res)){
						if($row['id']==$brand_id){
							echo "<option selected value=".$row['id'].">".$row['brands_name']."</option>";
						}else{
							echo "<option value=".$row['id'].">".$row['brands_name']."</option>";
						}
						
					}
					?>
				</select>
			</div>	

			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Color</label>
				<input type="text" name="product_color" data-role="tagsinput" placeholder="Enter product color" class="form-control" required value="<?php echo $product_color?>">
			</div>

			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Size</label>
				<input type="text" name="product_size" data-role="tagsinput" placeholder="Enter product size" class="form-control" required value="<?php echo $product_size?>">
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Selling Price</label>
				<input type="text" name="selling_price" placeholder="Enter product price" class="form-control" required value="<?php echo $selling_price?>">
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Qty</label>
				<input type="text" name="product_quantity" placeholder="Enter qty" class="form-control" required value="<?php echo $product_quantity?>">
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Details</label>
				<textarea name="product_details" placeholder="Enter product short description" class="form-control" required><?php echo $product_details?></textarea>
			</div>
											
			<div class="form-group">
				<label for="categories" class=" form-control-label">Meta Title</label>
				<textarea name="meta_title" placeholder="Enter product meta title" class="form-control"><?php echo $meta_title?></textarea>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Meta Description</label>
				<textarea name="meta_description" placeholder="Enter product meta description" class="form-control"><?php echo $meta_description?></textarea>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Meta Keyword</label>
				<textarea name="meta_keyword" placeholder="Enter product meta keyword" class="form-control"><?php echo $meta_keyword?></textarea>
			</div>
								
            <div class="row">

                <div class="col-lg-4">
                    <label class="ckbox">
                        <input type="checkbox" name="best_seller" value="1"<?php if ($hot_deal == 1) {
					  	echo "checked";
					  }?>>
                        <span>Best Seller</span>
                    </label>
                </div>

                <div class="col-lg-4">
                    <label class="ckbox">
                        <input type="checkbox" name="hot_deal" value="1"<?php if ($hot_deal == 1) {
					  	echo "checked";
					  }?>>
                        <span>Hot Deal</span>
                   </label>
                </div>

                <div class="col-lg-4">
                    <label class="ckbox">
                    <input type="checkbox" name="best_rated" value="1"<?php if ($best_rated == 1) {
					  	echo "checked";
					  }?>>
                    <span>Best Rated</span>
                    </label>
                </div>

                <div class="col-lg-4">
                    <label class="ckbox">
                        <input type="checkbox" name="trend" value="1"<?php if ($trend == 1) {
					  	echo "checked";
					  }?>>
                        <span>Trend Product</span>
                     </label>
                </div>

                <div class="col-lg-4">
                    <label class="ckbox">
                        <input type="checkbox" name="hot_new" value="1"<?php if ($hot_new == 1) {
					  	echo "checked";
					  }?>>
                        <span>Hot New</span>
                    </label>
                </div>

                <div class="col-lg-4">
                    <label class="ckbox">
                        <input type="checkbox" name="buyone_getone" value="1"<?php if ($buyone_getone == 1) {
					  	echo "checked";
					  }?>>
                        <span>Buy One Get One</span>
                    </label>
                </div>
            </div>

            <div class="col-lg-4">
            <div class="form-group">
              <label for="profile_image">Image</label>
                  <input type="file" class="form-control" name="image" id="image" >
                  <input type="hidden" name="old_image" value="<?php echo $image?>">
            </div>
            <div class="form-group">
             <div class="row">
                <div class="col-md-4">
                  <img id="showImage" src="<?php echo $image?>" height="110px" width="100px"/>
                </div>
              </div>
            </div> 
          </div>								
		   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
		   <span id="payment-button-amount">Update</span>
		   </button>
		   <div class="field_error"><?php echo $msg2?></div>
		</div>
	</form>
 </div>
</div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#image').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src',e.target.result);
      }
      reader.readAsDataURL(e.target.files['0']);
    });
  });
</script>

 <script>
	function get_sub_cat(sub_cat_id){
		var category_id=jQuery('#category_id').val();
		jQuery.ajax({
			url:'get_sub_cat.php',
			type:'post',
			data:'category_id='+category_id+'&sub_cat_id='+sub_cat_id,
			success:function(result){
				jQuery('#sub_categories_id').html(result);
			}
		});
	}
 </script>      
<?php
require('footer.inc.php');
?>
<script>
<?php
if(isset($_GET['id'])){
?>
get_sub_cat('<?php echo $sub_categories_id?>');
<?php } ?>
</script>