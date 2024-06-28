<?php
require_once __DIR__ . "/../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit("Unsupported HTTP method");
}
if (!isset($_GET["id"])) {
    exit("Missing required parameter: id");
}
$ticketId = $_GET["id"];
if (!is_numeric($ticketId)) {
    exit("Invalid ticket ID");
}

$ticket = $entityManager->find("Ticket", $ticketId);
if ($ticket === null) {
    exit("Ticket not found");
}

$status = $ticket->getClosedAt() !== null ? "Closed" : "Open";
$assignee = $ticket->getAssignee();
$assigneeString = $assignee !== null ? $assignee->getUsername() : "Unassigned";
$closedAt = $ticket->getClosedAt();
?>


<?php $pageTitle = $ticket->getTitle();
include (__DIR__ . "/common/top.php"); ?>
<h1><?php echo $ticket->getTitle() ?></h1>
<a href="edit_ticket.php?id=<?php echo $ticket->getId() ?>">edit</a>
<a href="delete_ticket.php?id=<?php echo $ticket->getId() ?>">delete</a>

<p>Status: <?php echo $status ?></p>
<p>Priority: <?php echo ucwords($ticket->getPriority()->value) ?></p>
<p>Assignee: <?php echo $assigneeString ?></p>
<p>Created at: <?php echo $ticket->getCreatedAt()->format('Y-m-d H:i:s') ?></p>
<?php if ($closedAt !== null): ?>
    <p>Closed at: <?php echo $closedAt->format('Y-m-d H:i:s') ?></p>
<?php endif ?>
<p>Deadline: <?php echo $ticket->getDeadline()->format('Y-m-d H:i:s') ?></p>
