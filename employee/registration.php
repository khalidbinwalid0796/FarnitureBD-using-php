<?php
    require('connection.inc.php');
    require('function.inc.php');
?>
</!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
<style type="text/css">
    .register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
    }
    .register-left{
        text-align: center;
        color: #fff;
        margin-top: 4%;
    }
    .register-left input{
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        width: 60%;
        background: #f8f9fa;
        font-weight: bold;
        color: #383d41;
        margin-top: 30%;
        margin-bottom: 3%;
        cursor: pointer;
    }
    .register-right{
        background: #f8f9fa;
        border-top-left-radius: 10% 50%;
        border-bottom-left-radius: 10% 50%;
    }
    .register-left img{
        margin-top: 15%;
        margin-bottom: 5%;
        width: 25%;
        -webkit-animation: mover 2s infinite  alternate;
        animation: mover 1s infinite  alternate;
    }
    @-webkit-keyframes mover {
        0% { transform: translateY(0); }
        100% { transform: translateY(-20px); }
    }
    @keyframes mover {
        0% { transform: translateY(0); }
        100% { transform: translateY(-20px); }
    }
    .register-left p{
        font-weight: lighter;
        padding: 12%;
        margin-top: -9%;
    }
    .register .register-form{
        padding: 10%;
        margin-top: 10%;
    }
    .btnRegister{
        float: right;
        margin-top: 10%;
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        background: #0062cc;
        color: #fff;
        font-weight: 600;
        width: 50%;
        cursor: pointer;
    }
    .register .nav-tabs{
        margin-top: 3%;
        border: none;
        background: #0062cc;
        border-radius: 1.5rem;
        width: 28%;
        float: right;
    }
    .register .nav-tabs .nav-link{
        padding: 2%;
        height: 34px;
        font-weight: 600;
        color: #fff;
        border-top-right-radius: 1.5rem;
        border-bottom-right-radius: 1.5rem;
    }
    .register .nav-tabs .nav-link:hover{
        border: none;
    }
    .register .nav-tabs .nav-link.active{
        width: 100px;
        color: #0062cc;
        border: 2px solid #0062cc;
        border-top-left-radius: 1.5rem;
        border-bottom-left-radius: 1.5rem;
    }
    .register-heading{
        text-align: center;
        margin-top: 8%;
        margin-bottom: -15%;
        color: #495057;
    }
</style>
</head>
<body>
<div class="container register">
<div class="row">
    <div class="col-md-3 register-left">
        <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
        <h3>Welcome</h3>
        <p>You are 30 seconds away from earning your own money!</p>
        <input type="submit" name="" value="Login"/><br/>
    </div>
    <div class="col-md-9 register-right">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h3 class="register-heading">Apply as a Employee</h3>
        <form id="register-form" method="post">
            <div class="row register-form">
                
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name *" />
                            <span class="field_error" id="name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email *" />
                            <span class="field_error" id="email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password *" />
                            <span class="field_error" id="password_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company">Select Company Name</label>
                            <select class="form-control" name="company_id" id="company_id">
                            <option>Select Company</option>
                            <?php
                            $res=mysqli_query($con,"select id,com_name from company order by com_name asc");
                              while($row=mysqli_fetch_assoc($res)){
                                echo "<option value=".$row['id'].">".$row['com_name']."</option>";
                              }
                            ?>
                            </select>
                            <span class="field_error" id="company_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="cars">Select Division Name</label>
                            <select class="form-control" id="division_id" onchange="get_district('')">
                            <option>Select Division</option>
                            <?php
                            $res=mysqli_query($con,"select id,name from division order by name asc");
                              while($row=mysqli_fetch_assoc($res)){
                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                              }
                            ?>
                            </select>
                            <span class="field_error" id="division_error"></span>
                        </div>                        
                        <div class="form-group">
                            <label for="cars">Select District Name</label>
                            <select class="form-control" name="district_id" id="district_id">
                                <option>Select District</option>
                            </select>
                            <span class="field_error" id="district_error"></span>
                        </div>
                    </div>
                    <button type="button" class="btnRegister" onclick="user_register()">Register</button>
                </div>
            </form>
                    <div class="form-output register_msg">
                        <p class="form-messege field_error"></p>
                    </div>
                
            </div>
        </div>
    </div>
</div>

</div>

      
</body>
</html>
<script>
    function get_district(dist_id){
        var division_id=jQuery('#division_id').val();
        jQuery.ajax({
            url:'get_district.php',
            type:'post',
            data:'division_id='+division_id+'&dist_id='+dist_id,
            success:function(result){
                jQuery('#district_id').html(result);
            }
        });
    }
 </script>      

<script>
    <?php
    if(isset($_GET['id'])){
    ?>
    get_district('<?php echo $district_id?>');
    <?php } ?>
</script>
<script type="text/javascript">
    function user_register(){
    jQuery('.field_error').html('');
    var name=jQuery("#name").val();
    var email=jQuery("#email").val();
    var password=jQuery("#password").val();
    var company_id=jQuery("#company_id").val();
    var division_id=jQuery("#division_id").val();
    var district_id=jQuery("#district_id").val();
    var is_error='';
    if(name==""){
        jQuery('#name_error').html('Please enter name');
        is_error='yes';
    }if(email==""){
        jQuery('#email_error').html('Please enter email');
        is_error='yes';
    }if(password==""){
        jQuery('#password_error').html('Please enter password');
        is_error='yes';
    }if(company_id==""){
        jQuery('#company_error').html('Please enter company name');
        is_error='yes';
    }if(division_id==""){
        jQuery('#division_error').html('Please enter division name');
        is_error='yes';
    }if(district_id==""){
        jQuery('#district_error').html('Please enter district name');
        is_error='yes';
    }
    if(is_error==''){
        jQuery.ajax({
            url:'register_submit.php',
            type:'post',
            data:'name='+name+'&email='+email+'&password='+password+'&company_id='+company_id+'&division_id='+division_id+'&district_id='+district_id,
            success:function(result){
                if(result=='email_present'){
                    jQuery('#email_error').html('Email id already present');
                }
                if(result=='insert'){
                    jQuery('.register_msg p').html('Thank you for registeration');
                }
            }   
        });
    }
}
</script>