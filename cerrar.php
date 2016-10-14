<?php 
session_start();
session_unset();
session_destroy();
echo "<script language='JavaScript'>parent.location.href='index.php';</script>";
?> 
 