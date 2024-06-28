<?php
session_start();
session_unset();
setcookie(session_name(), "", time() - 42000);
session_destroy();

header("Location: index.php");
exit;
