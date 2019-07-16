<?php
session_start();
include('classes/login.class.php');
$user = new login($_SESSION['login'], $_SESSION['mdp']);

$user->addTweet($_POST['tweet']);

/* header('location:home.php'); */
