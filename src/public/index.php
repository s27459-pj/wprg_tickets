<?php
require_once __DIR__ . "/../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit("Unsupported HTTP method");
}

$ticketRepository = $entityManager->getRepository("Ticket");
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
</body>

</html>
