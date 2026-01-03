<?php

session_start();
$_SESSION = [];
session_destroy();

header('Location: /GCETxODOO/index.php');
exit();

?>