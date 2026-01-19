<?php
require_once __DIR__.'/../Others/init.php';
$_SESSION = array();
session_destroy();
StaffData::close();
header("Location: index.php");