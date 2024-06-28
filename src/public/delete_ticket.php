<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/auth.php";
require_once __DIR__ . "/../util/ticket.php";

$ticket = getTicket($entityManager);
authenticateTeamLead($entityManager, $ticket->getTeam());

function handleDelete($entityManager, Ticket $ticket)
{
    $assignee = $ticket->getAssignee();
    if ($assignee !== null) {
        $assignee->removeAssignedTicket($ticket);
    }
    $ticket->delete();
    $entityManager->remove($ticket);
    $entityManager->flush();

    echo "<p>Deleted Ticket with ID {$ticket->getId()}";
    echo "<a href=\"index.php\">Back to Index</a>";
    echo "</p>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleDelete($entityManager, $ticket);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}
?>


<?php $pageTitle = "Delete {$ticket->getTitle()}";
include (__DIR__ . "/common/top.php"); ?>
<h2>Are you sure you want to delete '<?php echo $ticket->getTitle() ?>'?</h2>
<form action="delete_ticket.php?id=<?php echo $ticket->getId() ?>" method="post">
    <button type="submit">Yes</button>
    <button type="button" onclick="window.location.href = 'ticket.php?id=<?php echo $ticket->getId() ?>'">
        No
    </button>
</form>
