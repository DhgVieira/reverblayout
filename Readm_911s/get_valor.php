<?php
if (!isset( $_SESSION )) { 
   	session_start(); 
}
$_SESSION["clitemp"] = $_POST["c"];
?>