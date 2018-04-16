<?php
	session_start();
	unset($_SESSION["User"]);
	unset($_SESSION["Name"]);
	unset($_SESSION["Contact"]);
	unset($_SESSION["Address"]);
	header("Location: ../index.php");
?>