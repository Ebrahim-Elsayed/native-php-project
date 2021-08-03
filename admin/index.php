<?php session_start();?>
<?php require 'includes/config.php' ?>
<?php include 'includes/header.php'?>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['admin_username'];
        $paswword = sha1($_POST['admin_password']);

        $stmt = $connection->prepare("SELECT * FROM users WHERE username=? AND password=? AND role !=3");
        $stmt->execute(array($username,$paswword));
        $datafetched = $stmt->fetch();
            // echo "<pre>";
            // print_r($datafetched);
            // echo "</pre>";
        $count = $stmt->rowCount();
        // echo $count . "</br>";
        if($count == 1){
            $_SESSION['USERNAME'] = $username;
            $_SESSION['EMAIL'] = $datafetched['email'];
            $_SESSION['FULLNAME'] = $datafetched['fullname'];
            $_SESSION['ROLE'] = $datafetched['role'];
            header('location:dashboard.php');
        }else{
            echo "sorry ,you don't have access to this page";
        }
    }   
?>

<!-- start admin  -->

<div class="container">
    <form class="mt-5" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Username</label>
            <input type="text" class="form-control" name="admin_username">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="admin_password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


<!-- end admin -->

<?php include 'includes/footer.php'?>