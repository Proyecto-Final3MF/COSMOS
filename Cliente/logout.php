<?php
session_start();
session_destroy();
header("Location:StartPage.php");
exit();
?>