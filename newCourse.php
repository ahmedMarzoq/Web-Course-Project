<?php
	$con = mysqli_connect("localhost","root","","native");
	$matchError = "";
    $m = "";
    $val = true;
    $v = true;
    session_start();
    if(!isset($_SESSION["user_id"]) ){
        header("location: /new/login.php");
    }elseif(strcmp($_SESSION['user_type'],"register")!=0){
    	header("location: /new/".$_SESSION["user_type"].".php");
    }
    if(isset($_POST["logout"])){
        $query = " UPDATE `users` SET `lastVisit` = '".date("Y-m-d h:i:sa")."' where id = '".$_SESSION["user_id"]."' ";
        $rs = mysqli_query($con,$query);
        session_destroy();
        header("location: /new/login.php");
    }
     if(isset($_POST["register"])){
        header("location: /new/register.php");
    }
    if(isset($_POST["signUp"])){
    	$cName = htmlspecialchars($_POST["cName"], ENT_QUOTES, 'UTF-8');
    	$teacherId = htmlspecialchars($_POST["teacherId"], ENT_QUOTES, 'UTF-8');
    	if(empty($cName)){
            $m=" alert alert-danger  ";
            $matchError = "Fill all boxes";
            $val = false;
        }
        if($val){
        	if(checkCourseName($cName)){
        		$m=" alert alert-danger";
	            $matchError = "Course Name has been existed";
	            $val = false;
        	}
        }
        if($val){
		   // $query = "select * from users where id = '".$_SESSION["user_id"]."' ";
		    $query = "INSERT INTO courses (name,teacherId) VALUES ('$cName','$teacherId')";
		    $rs = mysqli_query($con,$query);
		    if($rs){
	        	$m=" alert alert-primary";
	            $matchError = "Success";
	            $v = false;
		    }else{
		    	$m=" alert alert-danger";
	            $matchError = mysql_error();
		    }
        } 
    }
    function checkCourseName($n){ 
    	$con = mysqli_connect("localhost","root","","native");
	    $query = "select name from courses";
	    $rs = mysqli_query($con,$query);
	    while($user = mysqli_fetch_assoc($rs)){
	    	if(strcmp($n,$user["name"])==0)
	    		return true;
	    }
	    return false;
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
		  			<button type="submit" class="btn btn-light 	" name="register">Main</button>
		  			<button type="submit" class="btn btn-danger  text-white" name="logout">Sign out</button>
	  			</form>
		  	</div>
		</nav>
		<br><br><br>	
		<div class="container">
			<div class="card " >
	  			<div class="card-header text-white text-uppercase shadow-sm " style="background-color: #77ae29; border-color: #77ae29;">
	   				 NEW COURSE
	  			</div>
	  			<div class="card-body">
	  				<div class = "<?= $m ?>" role="alert" >
                        <?= $matchError ?>
                    </div>
                	<?php
                		if($v){ 
                		$query = "select id,fName,lName from users WHERE userType='teacher' ";
    					$result = mysqli_query($con,$query);
    					$num_rows = mysqli_num_rows($result);
    					if($num_rows>0){?>
		  				  <form method="post" action="">
			  				  <div class="form-group row">
		                        <label for="inputEmail3" class="col-sm-2 col-form-label">Course Name</label>
		                        <div class="col-sm-10">
		                          <input type="text" class="form-control" placeholder="Course Name" name="cName">
		                        </div>
		                      </div>
		                      <div class="form-group row">
		                        <label for="inputPassword3" class="col-sm-2 col-form-label">Course Teacher</label>
		                        <div class="col-sm-10">
		                          	<select class="form-control " name="teacherId">
		                          		<?php 
		    								while($user = mysqli_fetch_assoc($result))
		    									echo "<option value='".$user["id"]."'>".$user["fName"]." ".$user["lName"]." "."</option>"
		    							?>
									</select>
		                        </div>
		                      </div>
		                      <br>
		                      <div class="form-group row">
		                        <div class="col-sm-4"></div>
		                        <div class="col-sm-4">
		                          <button type="submit" class="btn btn-primary w-100" name="signUp">Sign Up</button>
		                        </div>
		                        <div class="col-sm-4"></div>
		                      </div>
		                    </form>
                    <?php }else{ ?>
                			<div class = "alert alert-danger" role="alert" >
		                        NO TEACHER
		                    </div>
                    <?php }} ?>
			    </div>
			</div>
			<?php 
				$query = "select * from courses";
			    $rs = mysqli_query($con,$query);
			    $num_rows = mysqli_num_rows($rs);
				if($num_rows>0){?>
					<br><br>
					<table class="table">
					  <thead class="thead-dark" >
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Cousre Name</th>
					      <th scope="col">Teacher Name</th>
					    </tr>
					  </thead>
					  <tbody>
					<?php
				    while($user = mysqli_fetch_assoc($rs)){?>
				    	<tr>
					      <th scope="row"><?= $user["id"]?></th>
					      <td><?= $user["name"]?></td>
					      <?php 
							$queryy = "select fName,lName from users where userType='teacher' and id='".$user["teacherId"]."' ";
						    $rss = mysqli_query($con,$queryy);
						    $userr = mysqli_fetch_assoc($rss);
					      ?>
					      <td><?= $userr["fName"]?> <?= $userr["lName"]?></td>
					    </tr>
					<?php
				    }?>
				    	</tbody>
					</table>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<?php
				}else{?>
				<br>
					<div class="alert alert-warning" role="alert">
					  No Registered Courses
					</div>
				<?php }
			?>
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>