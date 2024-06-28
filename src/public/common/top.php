<?php
require_once __DIR__ . "/../../../bootstrap.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["user"])) {
    $userId = $_SESSION["user"];
    $activeUser = $entityManager->find(User::class, $userId);
} else {
    $activeUser = null;
}

if (!isset($pageTitle)) {
    exit("Page title not set");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common/index.css">
    <title><?php echo $pageTitle ?></title>
</head>

<body>
    <header>
        <h2>TicketMajster</h2>
        <nav>
            <ul>
                <li><a href="index.php">Backlog</a></li>
                <?php if ($activeUser !== null): ?>
                    <?php if ($activeUser->isTeamLead()): ?>
                        <li><a href="new_ticket.php">New Ticket</a></li>
                    <?php endif ?>
                    <?php if ($activeUser->isAdmin()): ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php endif ?>
                    <li>Logged in as <?php echo $activeUser->getUsername() ?></li>
                    <li><a href="logout.php">Log out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log in</a></li>
                <?php endif ?>
            </ul>
        </nav>
    </header>

    <!-- Content -->
