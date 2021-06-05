<?php
require('top.inc.php');

//active and deactive
if(isset($_GET['type']) && $_GET['type']!=''){
   $type=get_safe_value($con,$_GET['type']);
   
   $id=get_safe_value($con,$_GET['id']);
   if($type=='status'){
      $operation=get_safe_value($con,$_GET['operation']);
      if($operation=='active'){
         $status='1';
      }else{
         $status='0';
      }
      $update_status_sql="update product set status='$status' where id='$id'";
      mysqli_query($con,$update_status_sql);
   }
   
   if($type=='delete'){
      $id=get_safe_value($con,$_GET['id']);
      $delete_sql="delete from product where id='$id'";
      mysqli_query($con,$delete_sql);
   }
}

$employee_id=$_SESSION['EMP_ID'];

$row1=mysqli_fetch_assoc(mysqli_query($con,"select *
      from employee where id=$eid"));

$company_id=$row1['company_id'];

$sql="select product.*,category.cat_name from product,category where product.category_id=category.id and product.company_id=$company_id and product.employee_id=$employee_id order by product.id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
   <div class="orders">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
                  <h3>Post List
                  <a class="btn btn-success float-sm-right" href="post_add.php"><i class="fa fa-plus-circle"></i>Add Post</a>
                </h3>
            </div>
            <div class="card-body--">
               <div class="table-stats order-table ov-h">
                 <table class="table ">
                   <thead>
                     <tr>
                        <th class="serial">SL</th>
          						  <th>ID</th>
          						  <th>Name</th>
          						  <th>Category</th>
          						  <th>Image</th>
          						  <th>Selling Price</th>
          						  <th>Qty In</th>
                        <th>Qty Out</th>
                        <th>Stock</th>
          						  <th>Action</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php 
                     $i=0;
                     while($row=mysqli_fetch_assoc($res)){
                        $i++;
                        ?>
                     <tr>
                        <td class="serial"><?php echo $i?></td>
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['name']?></td>
                        <td><?php echo $row['cat_name']?></td>
                        <td><img src="<?php echo $row['image']?>"height="40px" width="40px"/></td>
                        <td><?php echo $row['price']?></td>
                        <td><?php echo $row['qty']?></td>
                        <?php
                          $productSoldQtyByProductId=productSoldQtyByProductId($con,$row['id']);
                          $pneding_qty=$row['qty']-$productSoldQtyByProductId;
                        ?>
                        <td><?php 
                        if($productSoldQtyByProductId > 0){
                          echo $productSoldQtyByProductId;
                        }else{
                          echo 0;
                        }
                        ?></td>
                        <td><?php echo $pneding_qty?></td>
                        <td>
                        <?php
                        if($row['status']==1){
                           echo "<button class='btn btn-success'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></button>&nbsp;";
                        }else{
                           echo "<button class='btn btn-warning'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></button>&nbsp;";
                        }
                        echo "<button class='btn btn-success'><a href=post_edit.php?id=".$row['id']."'>Edit</a></button>&nbsp;";
                        
                        echo "<button class='btn btn-danger'><a href='?type=delete&id=".$row['id']."'>Delete</a></button>";
                        
                        ?>
                        </td>
                     </tr>
                     <?php } ?>
                   </tbody>
                 </table>
               </div>
            </div>
          </div>
        </div>
      </div>
   </div>
</div>
<?php
require('footer.inc.php');
?>