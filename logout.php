<?php
// Inialize session
session_start();

// Delete certain session
unset($_SESSION['user_name']);
unset($_SESSION['user_id']);
 session_destroy();

 
// ob_end_flush();
 
 
 // Jump to login page
header("Location: index.php");

?>