<?php
require('top.inc.php');

$employee_id=$_SESSION['EMP_ID'];

$row1=mysqli_fetch_assoc(mysqli_query($con,"select company_id
      from employee where id=$eid"));

$company_id=$row1['company_id'];


$category_id='';
$name='';
$price='';
$qty='';
$description='';
$color='';
$size	='';
$image='';
$meta_title	='';
$meta_description='';
$meta_keyword='';
$best_seller='';
$image_required='required';
$msg='';

//insert data
if(isset($_POST['submit'])){
	$name=get_safe_value($con,$_POST['name']);
	$category_id=get_safe_value($con,$_POST['category_id']);
	$qty=get_safe_value($con,$_POST['qty']);
	$description=get_safe_value($con,$_POST['description']);
	$color=get_safe_value($con,$_POST['color']);
	$size=get_safe_value($con,$_POST['size']);
	$price=get_safe_value($con,$_POST['price']);
	$best_seller=get_safe_value($con,$_POST['best_seller']);
	$meta_title=get_safe_value($con,$_POST['meta_title']);
	$meta_description=get_safe_value($con,$_POST['meta_description']);
	$meta_keyword=get_safe_value($con,$_POST['meta_keyword']);

	$productck = "select * from product WHERE name = '$name'";
	$result = mysqli_query($con,$productck);
	$check=mysqli_num_rows($result);

	if($check==0) {
	    $permited  = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_temp = $_FILES['image']['tmp_name'];

	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

	    if(empty($name) || empty($file_name)){
	    		$msg  = "Field must not emplty !";

	    }else if ($file_size >1048567) {
	     	$msg  = "Image Size should be less then 1MB!";

	    } else if (in_array($file_ext, $permited) === false) {
	     	$msg  = "You can upload only:-".implode(', ', $permited);

	    } else {
		    	move_uploaded_file($file_temp, $uploaded_image);
		    	$query = "insert into product(name,category_id,employee_id,company_id,qty,description,color,size,price,best_seller,meta_title,meta_description,meta_keyword,image,status) 
		    	values('$name','$category_id','$employee_id','$company_id','$qty','$description','$color','$size','$price','$best_seller','$meta_title','$meta_description','$meta_keyword','$uploaded_image','1')";
				$inserted_row = mysqli_query($con,$query);
				if($inserted_row) {
					$msg = "Post inserted successfully.";
				} else{
					$msg = "Post not inserted.";				
				}
	    }
	    
	}else{

			$msg2 = "Post already exist !";
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
        <h3>Post Form
          <a class="btn btn-success float-sm-right" href="posts.php"><i class="fa fa-list"></i>Post List</a>
        </h3>
        </div>
        <form method="post" enctype="multipart/form-data">
			<div class="card-body card-block">

			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Name</label>
				<input type="text" name="name" placeholder="Enter product name" class="form-control" required>
			</div>

		   <div class="form-group">
				<label for="categories" class=" form-control-label">Categories</label>
				<select class="form-control" name="category_id" id="category_id">
					<option>Select Category</option>
					<?php
						$res=mysqli_query($con,"select id,cat_name from category order by cat_name asc");
							while($row=mysqli_fetch_assoc($res)){
								echo "<option value=".$row['id'].">".$row['cat_name']."</option>";
							}
					?>
				</select>
			</div>
	
			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Color</label>
				<input type="text" name="color" data-role="tagsinput" placeholder="Enter product color" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Size</label>
				<input type="text" name="size" data-role="tagsinput" placeholder="Enter product size" class="form-control" required>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Selling Price</label>
				<input type="text" name="price" placeholder="Enter product price" class="form-control" required>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Qty</label>
				<input type="text" name="qty" placeholder="Enter qty" class="form-control" required>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Product Details</label>
				<textarea name="description" placeholder="Enter product short description" class="form-control" required></textarea>
			</div>
											
			<div class="form-group">
				<label for="categories" class=" form-control-label">Meta Title</label>
				<textarea name="meta_title" placeholder="Enter product meta title" class="form-control"></textarea>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Meta Description</label>
				<textarea name="meta_description" placeholder="Enter product meta description" class="form-control"></textarea>
			</div>
			
			<div class="form-group">
				<label for="categories" class=" form-control-label">Meta Keyword</label>
				<textarea name="meta_keyword" placeholder="Enter product meta keyword" class="form-control"></textarea>
			</div>
								
			<div class="form-group">
				<label for="categories" class=" form-control-label">Best Seller</label>
				<select class="form-control" name="best_seller" required>
					<option value=''>Select</option>
						<option value="1">Yes</option>
						<option value="0">No</option>
				</select>
			</div>

            <div class="col-lg-4">
            <div class="form-group">
              <label for="profile_image">Image</label>
                  <input type="file" class="form-control" name="image" id="image" onchange="readURL(this);" accept="image">
            </div>
            <div class="form-group">
             <div class="row">
                <div class="col-md-4">
                  <img id="one"/>
                </div>
              </div>
            </div> 
          </div>	

		   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
		   <span id="payment-button-amount">Submit</span>
		   </button>
		   <div class="field_error"><?php echo $msg?></div>
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
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#one')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }
</script>
     
<?php
require('footer.inc.php');
?>
