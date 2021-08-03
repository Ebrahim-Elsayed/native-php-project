<?php
/*  CRUD => CREATE RECORD UPDATE DELETE
    SPA => SINGLE PAGE APPLICATION
    ----------
    *= IF CONDITON TO CHECK ANA F ANHE PAGE BZBT (CREATE WLA DELETE WLA UPDATE KDA Y3NI )
    => SOME ONE TO CHECK OUR CHOICE (get request).
*/

// handling logic error
// $action= '';
// ---------
// if (isset($_GET['do'])) {
//     // record (a7tfzt) the get request in action variable
//     $action = $_GET['do'];
// }else{
//     // echo 'the get request is not right' . '</br>';
//     $action = 'index';
// };

// short if
$action = isset($_GET['do'])?$_GET['do']:'index';
?>
<!-- include files operation -->
<?php session_start(); ?>
<?php require 'includes/config.php' ?>
<?php include 'includes/header.php'?>
<?php include 'includes/navbar.php' ?>
<!-- start crud operation -->
<?php if($action == 'index'): ?>
<!-- show all users page -->
<?php
        $stmt= $connection->prepare('SELECT * from users where role=3') ;
        $stmt->execute();
        $users = $stmt->fetchAll();
    ?>
<div class="container">
    <table class="table table-secondary">
        <thead>
            <tr>
                <th>username</th>
                <th>created at</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['username'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                        <a href="members.php?do=show&user_id=<?= $user['user_id'] ?>" class="btn btn-info">show</a>
                    <?php $isAdmin = 1; if($_SESSION['ROLE'] == $isAdmin): ?>
                        <a href="members.php?do=edit&user_id=<?= $user['user_id'] ?>" class="btn btn-warning">edit</a>
                        <a href="members.php?do=delete&user_id=<?= $user['user_id'] ?>" class="btn btn-danger">delete</a>
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="members.php?do=create" class="btn btn-primary">add user</a>
</div>
<!-- SPA create page ------------------------------------------------------------------------------------------------------------------>
<?php elseif($action == 'create') :?>
<!-- this form displayed to end user -->
<div class="container">
    <h1>Add User</h1>
    <form class="row g-3 mt-3" method="POST" action="members.php?do=store">
        <div>
            <label class="form-label">username</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div>
            <label class="form-label">fullname</label>
            <input type="text" class="form-control" name="fullname">
        </div>
        <div>
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">submit</button>
        </div>
    </form>
</div>
<!-- SPA store page ------------------------------------------------------------------------------------------------------------------>
<?php elseif($action == 'store') :?>
<!-- this form for coding operation bst2bl el data -->
<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $stmt = $connection->prepare("INSERT INTO users (username , fullname , email , created_at , password , role ) 
                                    VALUES (? ,? ,? ,now(), ?, 3) ");
        $stmt->execute(array( $username , $fullname , $email , $password ));
        header('location:members.php?');
    }
    ?>
<!-- SPA show page -------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'show') :?>
    <?php $userid = isset($_GET['user_id']) && is_numeric($_GET['user_id'])?intval($_GET['user_id']) : 0;
                $stmt = $connection->prepare('SELECT * FROM users WHERE user_id=? ');
                $stmt->execute(array($userid));
                $user = $stmt->fetch();
                $count = $stmt->rowCount();
            ?>
    <?php if ($count == 1):?>
    <div class="container">
        <h1>show User</h1>
        <form class="row g-3 mt-3  btn-danger rounded" method="POST" action="members.php?do=store">
            <div>
                <label class="form-label">username</label>
                <input type="text" class="form-control btn-warning" readonly value=<?= $user['username']?>>
            </div>
            <div>
                <label class="form-label">fullname</label>
                <input type="text" class="form-control btn-warning" readonly value=<?= $user['fullname']?>>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" class="form-control btn-warning" readonly value=<?= $user['email']?>>
            </div>
            <div>
                <label class="form-label">Password</label>
                <input type="password" class="form-control btn-warning" readonly value=<?= $user['password']?>>
            </div>
            <div class="col-12">
                <a href="members.php" class="btn btn-dark mb-3">BACK</a>
            </div>
        </form>
    </div>
<?php else :?>
<?php header('location:members.php?do=show')?>
<?php endif?>
<!-- SPA edit page --------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'edit') :?>
    <?php $userid = isset($_GET['user_id']) && is_numeric($_GET['user_id'])?intval($_GET['user_id']) : 0;
        $stmt = $connection->prepare('SELECT * FROM users WHERE user_id=? ');
        $stmt->execute(array($userid));
        $user = $stmt->fetch();
        $count = $stmt->rowCount();
    ?>
    <!-- if condition that display user in DB -->
    <?php   $inDB = 1 ;
            if ($count == $inDB):
    ?>
        <div class="container">
        <h1>Edit User</h1>
        <form class="row g-3 mt-3 " method="POST" action="members.php?do=update">
            <input type="text" class="form-control " name="userid" value=<?= $user['user_id']?> hidden>
            <div>
                <label class="form-label">username</label>
                <input type="text" class="form-control " name="username" value=<?= $user['username']?>>
            </div>
            <div>
                <label class="form-label">fullname</label>
                <input type="text" class="form-control " name="fullname" value=<?= $user['fullname']?>>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" class="form-control " name="email" value=<?= $user['email']?>>
            </div>
            <div>
                <label class="form-label">Password</label>
                <input type="password" class="form-control " name="password"  value=<?= $user['password']?>>
            </div>
            <div class="col-12">
            <button type="submit" class="btn btn-primary">update</button>
            <a href="members.php" class="btn btn-dark">BACK</a>
            </div>
        </form>
    </div>
    <?php else :?>
        <?php header('location:members.php?')?>
    <?php endif?>
<!-- SPA update page ------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'update') :?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userid = $_POST['userid'];
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = sha1($_POST['password']);

            $stmt = $connection->prepare('UPDATE users SET username=? , fullname=? , email=? , password=? WHERE user_id=?');
            $stmt->execute(array( $username , $fullname , $email , $password , $userid ));
            header('location:members.php?do=edit');
        }
    ?>
<!-- SPA delete page ------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'delete') :?>
    <?php
        $userid = isset($_GET['user_id']) && is_numeric($_GET['user_id'])?intval($_GET['user_id']) : 0 ;
        // if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) {
        //     $userid = intval($_GET['user_id']);
        // }else{
        //     echo 'this is wrong id ';
        // }
        
        $stmt = $connection->prepare('DELETE FROM users WHERE user_id=?');
        $stmt->execute(array($userid));
        header('location:members.php');


    ?>
<?php else:?>
<h1 style="text-align:center">404 page not found</h1>
<?php endif ?>
<!-- end crud operation -->
<!-- include file operation -->
<?php include 'includes/footer.php'?>