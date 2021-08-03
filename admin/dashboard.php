<?php session_start(); ?>
<?php require 'includes/config.php' ?>
<?php include 'includes/header.php'?>
<?php include 'includes/navbar.php' ?>
<?php 
    echo '<pre>';
    print_r($_SESSION); 
    echo '</pre>';
?>
<?php include 'includes/footer.php'?>