<?php
session_start();
session_unset();
session_destroy();
header("Location: dashboard_user.php");
exit();
?>