<?php
	$con = mysqli_connect("localhost","root","","native");
	$matchError = "";
    $m = "";
    $val = false;
    $v = true;
    $cou = "";
    $couID = "";
    session_start();
    if(!isset($_SESSION["user_id"]) ){
        header("location: /new/login.php");
    }elseif(strcmp($_SESSION['user_type'],"teacher")!=0){
    	header("location: /new/".$_SESSION["user_type"].".php");
    }
    if(isset($_POST["logout"])){
        $con = mysqli_connect("localhost","root","","native");
        $query = " UPDATE `users` SET `lastVisit` = '".date("Y-m-d h:i:sa")."' where id = '".$_SESSION["user_id"]."' ";
        $rs = mysqli_query($con,$query);
        session_destroy();
        header("location: /new/login.php");
    }
     if(isset($_POST["main"])){
        header("location: /new/register.php");
    }
    if(isset($_POST["insert"])){
    	$v = false;	 
    	$val = true;
    	$sQuery = "select * from courses WHERE id = '".$_POST["cousreId"]."'";
		$aResult = mysqli_query($con,$sQuery);
		$user = mysqli_fetch_assoc($aResult);
		$couID = $_POST["cousreId"];
    	$cou = $user["name"];
    }
    if(isset($_GET["submit"])){
    	$v = false;
    	$q = "select id from users WHERE userType= 'student' ";
		$s = mysqli_query($con,$q);
		while ( $u = mysqli_fetch_assoc($s)) {
			$G = $u["id"];
 			$Q = "INSERT INTO grades(studentId,courseId,grade) VALUES ('$G','".$_GET["couId"]."','".$_GET[$G]."')";
			$R = mysqli_query($con,$Q);
			echo $G."\n";
		}
		if($R){
			$m=" alert alert-primary";
            $matchError = "Done";
		}else{
			$m=" alert alert-danger";
            $matchError = mysqli_error($con);
		}
    }

    $query = "select * from users where id = '".$_SESSION["user_id"]."' ";
    $rs = mysqli_query($con,$query);
    $user = mysqli_fetch_assoc($rs);

?>
<html>
	<head>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/bootstrap-theme.css" rel="stylesheet" />
		<title>Register</title>
	</head>
	<body>
		<nav class="navbar sticky-top navbar-light bg-dark shadow-sm text">
			<div class="container">
		  		<span class="navbar-brand mb-0  text-white">Welcome : <?= $user["fName"]," ",$user["mName"]," ",$user["lName"] ?></span>
		  		<span class="navbar-brand my-2 my-sm-0 text-white" >Last visit : <?= $user["lastVisit"]?></span>

		  		<form method="post" action="" class="navbar-brand my-0 my-sm-0">
		  			<button type="submit" class="btn btn-light" name="main">Main</button>
		  			<button type="submit" class="btn btn-danger  text-white" name="logout">Sign out</button>
	  			</form>
		  	</div>
		</nav>
		<br><br><br>	
		<div class="container">
			<div class="card " >
	  			<div class="card-header text-white text-uppercase shadow-sm " style="background-color: #77ae29; border-color: #77ae29;">
	   				 Insert Grades
	  			</div>
	  			<div class="card-body">
	  				<div class = "<?= $m ?>" role="alert" >
                        <?= $matchError ?>
                    </div>
                    <?php
                     	if($v){ 
             			$query = "select * from users WHERE userType = 'student' ";
    					$result = mysqli_query($con,$query);
    					$num_rows = mysqli_num_rows($result);
    					$sQuery = "select * from courses";
    					$aResult = mysqli_query($con,$sQuery);
    					$sNum_rows = mysqli_num_rows($aResult);
    					if($num_rows>0){
    						if($sNum_rows>0){
                 	?>
                 		<form method="post" action="">
					 		 <div class="form-group row">
							    <label for="inputEmail3" class="col-sm-2 col-form-label">Select Course</label>
							    <div class="col-sm-10">
							      <select class="form-control" name="cousreId">
							      	<?php  
	    								while($user = mysqli_fetch_assoc($aResult))
	    									echo "<option value='".$user["id"]."'>".$user["name"]."</option>";
							    	?>
							    </select>
							    </div>
							  </div>
							  <br>
							  <div class="form-group row">
		                        <div class="col-sm-4"></div>
		                        <div class="col-sm-4">
		                          <button type="submit" class="btn btn-primary w-100" name="insert">Insert</button>
		                        </div>
		                        <div class="col-sm-4"></div>
		                      </div>
                 		</form>
                    <?php }else{?>
                    		<br>
							<div class="alert alert-warning" role="alert">
							  No Registered Courses
							</div>
                    <?php } }else{ ?>
                			<br>
							<div class="alert alert-warning" role="alert">
							  No Registered Students
							</div>
                	<?php } } ?>
                	<?php 
                		if($val){
                			$query = "select * from users WHERE userType = 'student' ";
    						$result = mysqli_query($con,$query);
					?>
						<div class="alert alert-dark" role="alert">
						 Course Name : <?= $cou ?> 
						</div>
						<form method="get" action="">
							<input type="hidden" name="couId" value="<?= $couID ?>"> 
							<table class="table">
							  <thead class="thead-dark" >
							    <tr>
							      <th scope="col">Student Name</th>
							      <th scope="col">Grade</th>
							    </tr>
							  	</thead>
							  	<tbody>
								<?php while($user = mysqli_fetch_assoc($result)){ ?>
							    	<tr>
							    		<td><?= $user["fName"]?>  <?= $user["lName"]?></td>
								    	<td><input type="text"  placeholder="Grade" name="<?= $user["id"]?>"></input></td>
								    </tr>
								<?php } ?>
						    	</tbody>
							</table>
							<br>
							<div class="form-group row">
		                        <div class="col-sm-4"></div>
		                        <div class="col-sm-4">
		                          <button type="submit" class="btn btn-primary w-100" name="submit">Submit</button>
		                        </div>
		                        <div class="col-sm-4"></div>
	                      	</div>
						</form>
					<?php }	?>
			    </div>
			</div>
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>