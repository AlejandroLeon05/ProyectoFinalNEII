<?php
session_start();
session_destroy();
header("Location: /music-match/admin_login_form.php");
exit;
?>