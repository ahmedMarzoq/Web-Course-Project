<?php
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
        $con = mysqli_connect("localhost","root","","native");
        $query = " UPDATE `users` SET `lastVisit` = '".date("Y-m-d h:i:sa")."' where id = '".$_SESSION["user_id"]."' ";
        $rs = mysqli_query($con,$query);
        session_destroy();
        header("location: /new/login.php");
    }
     if(isset($_POST["register"])){
        header("location: /new/register.php");
    }
    if(isset($_POST["signUp"])){
    	$fName = htmlspecialchars($_POST["fName"], ENT_QUOTES, 'UTF-8');
    	$mName = htmlspecialchars($_POST["mName"], ENT_QUOTES, 'UTF-8');
    	$lName = htmlspecialchars($_POST["lName"], ENT_QUOTES, 'UTF-8');
    	$email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    	$password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
        $cPassword = htmlspecialchars($_POST["cPassword"], ENT_QUOTES, 'UTF-8');
    	if(empty($fName) or empty($mName) or empty($lName) or empty($email) or empty($password) or empty($cPassword)){
            $m=" alert alert-danger  ";
            $matchError = "Fill all boxes";
            $val = false;
        }
        if($val){
	        if(checkEmail($email)){
	            $m=" alert alert-danger";
	            $matchError = "Enter Correct Form For Email";
	            $val = false;
	        }
	        if($val){
	        	if(checkEmailE($email)){
	        		$m=" alert alert-danger";
		            $matchError = "Email has been existed";
		            $val = false;
	        	}
	        }
	        if($val){
		        if(checkPass($password,$cPassword)){
		            $m=" alert alert-danger";
		            $matchError = "Enter Correct Form For Password";
		            $val = false;
		        }
	    	}
    	}
        if($val){
            $con = mysqli_connect("localhost","root","","native");
		    $query = "select * from users where id = '".$_SESSION["user_id"]."' ";
		    $query = "INSERT INTO users (fName, mName, lName , email , password , userType) VALUES ('$fName', '$mName', '$lName' , '$email' , '$password','teacher')";
		    $rs = mysqli_query($con,$query);
		    if($rs){
		    	$m=" alert alert-primary";
		    	$matchError = "Success";
		    	$v=false;
		    }else{
		    	$m=" alert alert-danger";
		    	$matchError = mysql_error();
		    }

        }  
    }
    $con = mysqli_connect("localhost","root","","native");
    $query = "select * from users where id = '".$_SESSION["user_id"]."' ";
    $rs = mysqli_query($con,$query);
    $user = mysqli_fetch_assoc($rs);
    function checkPass($p,$cp){          
       if((!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/",$p)) and ($p==$cp)) return TRUE;
       return FALSE;
    }
    function checkEmail($n){          
       if(!preg_match("/^[a-z A-Z 0-9]+@[a-z A-Z]+\.[a-z A-Z]+$/",$n)) return TRUE;
       return FALSE;
    }
    function checkEmailE($n){ 
	    $con = mysqli_connect("localhost","root","","native");
	    $query = "select email from users ";
	    $rs = mysqli_query($con,$query);
	    while($user = mysqli_fetch_assoc($rs)){
	    	if(strcmp($n,$user["email"])==0)
	    		return true;
	    }
	    return false;
    }

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
	   				 NEW TEACHER
	  			</div>
	  			<div class="card-body">
	  				<div class = "<?= $m ?>" role="alert" >
                        <?= $matchError ?>
                    </div>
		  			<?php if($v){ ?>
	  				  <form method="post" action="">
		  				  <div class="form-group row">
	                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
	                        <div class="col-sm-4">
	                          <input type="text" class="form-control" placeholder="First Name" name="fName">
	                        </div>
	                        <div class="col-sm-3">
	                          <input type="text" class="form-control" placeholder="Middle Name" name="mName">
	                        </div>
	                        <div class="col-sm-3">
	                          <input type="text" class="form-control" placeholder="Last Name" name="lName">
	                        </div>
	                      </div>
	                      <div class="form-group row">
	                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" placeholder="Email" name="email">
	                        </div>
	                      </div>
	                      <div class="form-group row">
	                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
	                        <div class="col-sm-10">
	                          <input type="password" class="form-control" placeholder="Password" name="password">
	                        </div>
	                      </div>
	                      <div class="form-group row">
	                        <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
	                        <div class="col-sm-10">
	                          <input type="password" class="form-control" placeholder="Confirm Password" name="cPassword">
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
                    <?php } ?>
			    </div>
			</div>
			<?php 
				$query = "select * from users where userType = 'teacher' ";
			    $rs = mysqli_query($con,$query);
			    $num_rows = mysqli_num_rows($rs);
				if($num_rows>0){?>
					<br><br>
					<table class="table">
					  <thead class="thead-dark" >
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">First Name</th>
					      <th scope="col">Middle Name</th>
					      <th scope="col">Last Name</th>
					      <th scope="col">Email</th>
					    </tr>
					  </thead>
					  <tbody>
					<?php
				    while($user = mysqli_fetch_assoc($rs)){?>
				    	<tr>
					      <th scope="row"><?= $user["id"]?></th>
					      <td><?= $user["fName"]?></td>
					      <td><?= $user["mName"]?></td>
					      <td><?= $user["lName"]?></td>
					      <td><?= $user["email"]?></td>
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
					  No Registered Teachers
					</div>
				<?php }
			?>
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>