<?php
require_once __DIR__ . "/../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit("Unsupported HTTP method");
}

session_start();
if (isset($_SESSION["user"])) {
    $userId = $_SESSION["user"];
    $user = $entityManager->find(User::class, $userId);
} else {
    $user = null;
}

$ticketRepository = $entityManager->getRepository(Ticket::class);
$tickets = $ticketRepository->findAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backlog</title>
</head>

<body>
    <h1>Backlog</h1>
    <ul>
        <?php foreach ($tickets as $ticket):
            $assignee = $ticket->getAssignee();
            ?>
            <li>
                <a href="ticket.php?id=<?php echo $ticket->getId() ?>">
                    <?php echo $ticket->getId() ?>
                </a>
                <span><?php echo $ticket->getTitle() ?></span>
                <span><?php echo $ticket->getPriority()->value ?></span>
                <?php if ($assignee !== null): ?>
                    <span><?php echo $assignee->getUsername() ?></span>
                <?php endif ?>
            </li>
        <?php endforeach ?>
    </ul>
    <a href="new_ticket.php">New Ticket</a>
    <p>
        <?php if ($user !== null): ?>
            <span>Logged in as <?php echo $user->getUsername() ?> (<?php echo $user->getRole()->value ?>)</span>
            <span><a href="logout.php">Log out</a></span>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif ?>
    </p>
</body>

</html>
