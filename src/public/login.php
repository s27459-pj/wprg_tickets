<?php
require_once __DIR__ . "/../../bootstrap.php";

function handleLogin($entityManager)
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = $entityManager->getRepository(User::class)->findOneBy(["username" => $username]);
    if ($user === null || !$user->verifyPassword($password)) {
        echo "Invalid credentials ";
        echo "<a href=\"login.php\">Try again</a>";
        exit;
    }

    $_SESSION["user"] = $user->getId();
    header("Location: index.php");
    exit;
}

session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleLogin($entityManager);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}
?>


<?php $pageTitle = "Login";
include (__DIR__ . "/common/top.php"); ?>
<h1>Login</h1>
<form action="login.php" method="post">
    <div class="form-field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autofocus>
    </div>
    <div class="form-field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit">Login</button>
</form>
