<?php
    session_start();
    if(!isset($_SESSION["user_id"])){
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
    $con = mysqli_connect("localhost","root","","native");
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
		  			<button type="submit" class="btn btn-danger  text-white" name="logout">Sign out</button>
	  			</form>
		  	</div>
		</nav>
		<br><br><br>	
		<div class="container">
			<div class="card " >
	  			<div class="card-header text-white text-uppercase shadow-sm " style="background-color: #77ae29; border-color: #77ae29;">
	   				 NEW
	  			</div>
	  			<div class="card-body">
	  				<a class="btn btn-info btn-lg btn-block" href="newStudent.php" role="button" name="newStudent">New Student</a>
	  				<a class="btn btn-info btn-lg btn-block" href="newTeacher.php" role="button" name="newTeacher">New Teacher</a>
	  				<a class="btn btn-info btn-lg btn-block" href="newCourse.php" role="button" name="newCourse">New Course</a>
	  				<!-- <form method="post" action="newStudent.php">
					  	<button type="submit" class="btn btn-info btn-lg btn-block" name="newStudent">New Student</button>
					</form>
					<form method="post" action="newTeacher.php">
					    <button type="submit" class="btn btn-info btn-lg btn-block" name="newTeacher">New Teacher</button>
					</form>
					<form method="post" action="newCourse.php">
						<button type="submit" class="btn btn-info btn-lg btn-block" name="newCourse">New Course</button>
					</form> -->
			    </div>
			    <br>
			</div>
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>



