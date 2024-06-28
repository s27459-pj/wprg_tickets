<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit("Unsupported HTTP method");
}

$ticketRepository = $entityManager->getRepository(Ticket::class);
$tickets = $ticketRepository->findAll();
?>

<?php $pageTitle = "Tickets";
include (__DIR__ . "/common/top.php"); ?>
<h1>All Tickets</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Priority</th>
        <th>Team</th>
        <th>Assignee</th>
        <th>Status</th>
        <th>Deadline</th>
    </tr>
    <?php foreach ($tickets as $ticket):
        $team = $ticket->getTeam();
        $assignee = $ticket->getAssignee();
        $deadline = $ticket->getDeadline();
        ?>
        <tr>
            <td>
                <a href="ticket.php?id=<?php echo $ticket->getId() ?>">
                    <?php echo $ticket->getTitle() ?>
                </a>
            </td>
            <td><?php echo getEnumDisplayName($ticket->getPriority()) ?></td>
            <td><?php echo $team->getName() ?></td>
            <td>
                <?php if ($assignee !== null): ?>
                    <?php echo $assignee->getUsername() ?>
                <?php else: ?>
                    Unassigned
                <?php endif ?>
            </td>
            <td><?php echo $ticket->getStatus() ?></td>
            <td><?php echo $deadline->format('Y-m-d H:i') ?></td>
        </tr>
    <?php endforeach ?>
</table>
