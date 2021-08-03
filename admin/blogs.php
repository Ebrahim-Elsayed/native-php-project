<?php $action = isset($_GET['do'])?$_GET['do']:'index';?>

<?php session_start(); ?>
<?php require 'includes/config.php' ?>
<?php include 'includes/header.php'?>
<?php include 'includes/navbar.php' ?>
<!-- start crud operation -->
<?php if($action == 'index'): ?>
<!-- show all blogs page -->
<?php 
    $stmt = $connection->prepare('SELECT * FROM blogs WHERE  role=3');
    $stmt->execute();
    $blogs = $stmt->fetchAll();
    // echo "<pre>";
    // print_r($blogs);
    // echo "</pre>";
?>
<div class="container">
    <table class="table table-success">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($blogs as $blog) :?>
                <tr>
                    <td><?= $blog['title'] ?></td>
                    <td><textarea class="form-control table-info" rows="3"><?=  $blog['description'] ?></textarea></td>
                    <td>
                        <a href="#" class="btn btn-info">show</a>
                        <a href="#" class="btn btn-warning">edit</a>
                        <a href="#" class="btn btn-danger">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="blogs.php?do=create" type="button" class="btn btn-success">Add Post</a>

</div>

<!-- SPA create page ------------------------------------------------------------------------------------------------------------------>
<?php elseif($action == 'create') :?>
    <div class="container text-center fs-1 fw-bold">
        <form method="POST" action="blogs.php?do=store">
            <div class="mb-3 ">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="mb-3">
                <label class="form-label">Descrioption</label>
                <textarea class="form-control" name="desc" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">ADD</button>
            </div>
        </form>
    </div>
<!-- SPA store page -------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'store') :?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $blogtitle = $_POST['title'];
        $blogdesc = $_POST['desc'];
        $stmt=$connection->prepare("INSERT INTO blogs (title , description, role) VALUES ( ? , ? , 3)");
        $stmt->execute(array($blogtitle , $blogdesc));
        header('location:blogs.php');
    }
    ?>
    <?php ?>
<!-- SPA show page --------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'show') :?>
<!-- SPA edit page --------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'edit') :?>
<!-- SPA update page ------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'update') :?>
<!-- SPA delete page ------------------------------------------------------------------------------------------------------------------->
<?php elseif($action == 'delete') :?>
<?php else:?>
<h1 class="pt-5" style="text-align:center">404 page not found</h1>
<?php endif ?>
<!-- end crud operation -->
<!-- include file operation -->
<?php include 'includes/footer.php'?>