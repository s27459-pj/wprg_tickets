<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";
require_once __DIR__ . "/../util/ticket.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}

$user = authenticateOptional($entityManager);
$ticket = getTicket($entityManager);

$status = $ticket->getStatus();
$assignee = $ticket->getAssignee();
$assigneeString = $assignee !== null ? $assignee->getUsername() : "Unassigned";
$closedAt = $ticket->getClosedAt();
?>


<?php $pageTitle = $ticket->getTitle();
include (__DIR__ . "/common/top.php"); ?>
<h1><?php echo $ticket->getTitle() ?></h1>

<?php if ($user !== null && $user->getTeam() === $ticket->getTeam()): ?>
    <a href="mark_ticket_done.php?id=<?php echo $ticket->getId() ?>">mark done</a>
    <?php if ($user->isTeamLead()): ?>
        <a href="edit_ticket.php?id=<?php echo $ticket->getId() ?>">edit</a>
        <a href="delete_ticket.php?id=<?php echo $ticket->getId() ?>">delete</a>
    <?php endif ?>
<?php endif ?>

<p>Status: <?php echo $status ?></p>
<p>Priority: <?php echo getEnumDisplayName($ticket->getPriority()) ?></p>
<p>Assignee: <?php echo $assigneeString ?></p>
<p>Created at: <?php echo $ticket->getCreatedAt()->format('Y-m-d H:i:s') ?></p>
<?php if ($closedAt !== null): ?>
    <p>Closed at: <?php echo $closedAt->format('Y-m-d H:i:s') ?></p>
<?php endif ?>
<p>Deadline: <?php echo $ticket->getDeadline()->format('Y-m-d H:i:s') ?></p>
