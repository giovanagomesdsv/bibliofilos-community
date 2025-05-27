<?php
if(!isset($_SESSION)) {
    session_start();
}

// deixa de existir
session_destroy();

header ("Location: ../login/login.php");
?>