<?php
    $matchError = "";
    $m = "";
    $empty="";
    session_start();
    if(isset($_SESSION["user_id"])){
        if(strcmp($_SESSION['user_type'],"register")==0)
                header("location: /new/register.php");
        elseif(strcmp($_SESSION['user_type'],"student")==0)
                header("location: /new/student.php");
        elseif(strcmp($_SESSION['user_type'],"teacher")==0)
                header("location: /new/teacher.php");
    }

    if(isset($_POST["login"])){
        $username = $_POST["un"];
        $password = $_POST["pw"];
        if(empty($username) or empty($password)){
            $m=" alert alert-danger  ";
            $matchError = "Fill all boxes";
        }else{
            $con = mysqli_connect("localhost","root","","native");
            $query = "select * from users where email = '$username' and password = '$password' ";
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) == 1){
                //good
                $user = mysqli_fetch_assoc($result);
                //session_start();
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_type"] = $user["userType"];
                if(strcmp($user['userType'],"register")==0)
                    header("location: /new/register.php");
                elseif(strcmp($_SESSION['user_type'],"student")==0)
                header("location: /new/student.php");
                elseif(strcmp($_SESSION['user_type'],"teacher")==0)
                header("location: /new/teacher.php");
            }else{
                //error
            $m=" alert alert-danger  ";
            $matchError = "Error Username OR Password";
            }
        }
    }
?>
<html>
    <head>
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="css/bootstrap-theme.css" rel="stylesheet" />
        <title>login</title>
    </head>
    <body>
        <nav class="navbar sticky-top navbar-light bg-dark shadow-sm text">
            <div class="container">
                <span class="navbar-brand mb-0 h1 text-white">Welcome</span>
            </div>
        </nav>
        <br><br><br>    
        <div class="container">
            <div class="card " >
                <div class="card-header text-white text-uppercase shadow-sm " style="background-color: #77ae29; border-color: #77ae29;">
                     Login
                </div>
                <div class="card-body">
                    <div class = "<?= $m ?>" role="alert" >
                        <?= $matchError ?>
                    </div>
                    <form method="post" action="">
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Email" name="un">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" placeholder="Password" name="pw">
                        </div>
                      </div>
                      <br>
                      <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                          <button type="submit" class="btn btn-primary w-100" name="login">Sign in</button>
                        </div>
                        <br>
                        <div class="col-sm-4"></div>
                      </div>
                    </form>
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>