<?php

require_once "function.php";
$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");
