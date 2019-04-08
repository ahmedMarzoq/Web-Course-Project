<?php
    session_start();
    if(!isset($_SESSION["user_id"])){
        header("location: /new/login.php");
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
        <title>Home</title>
    </head>
    <body>
        <h1>Welcome <?= $user["fName"] ?></?></h1>
        <form method="post" action="">
            <input type="submit" value="Logout" name="logout">
        </form>
    </body>
</html>