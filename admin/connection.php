<?php

	error_reporting(E_ALL ^ E_DEPRECATED);
	mysql_connect("localhost","root","") or die("cannot connect to server");
	mysql_select_db("mushroomsisigdb") or die ("cannot select database");

?>