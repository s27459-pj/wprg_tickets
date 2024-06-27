<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/ticket.php";

function handleDelete($entityManager)
{
    $ticket = getTicket($entityManager);
    $assignee = $ticket->getAssignee();
    if ($assignee !== null) {
        $assignee->removeAssignedTicket($ticket);
    }
    $entityManager->remove($ticket);
    $entityManager->flush();

    echo "<p>Deleted Ticket with ID {$ticket->getId()}";
    echo "<a href=\"index.php\">Back to Index</a>";
    echo "</p>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleDelete($entityManager);
    return;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit("Unsupported HTTP method");
}

$ticket = getTicket($entityManager);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete <?php echo $ticket->getTitle() ?></title>
</head>

<body>
    <h2>Are you sure you want to delete '<?php echo $ticket->getTitle() ?>'?</h2>
    <form action="delete_ticket.php?id=<?php echo $ticket->getId() ?>" method="post">
        <button type="submit">Yes</button>
        <button type="button" onclick="window.location.href = 'ticket.php?id=<?php echo $ticket->getId() ?>'">
            No
        </button>
    </form>
</body>

</html>
