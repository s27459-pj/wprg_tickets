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
    echo "You're already logged in. ";
    echo "<a href=\"index.php\">Go back</a> ";
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <div class="form-field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="form-field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Login</button>
    </form>
</body>

</html>
