<?php
require_once __DIR__ . "/../../bootstrap.php";

function handleCreate($entityManager)
{
    // TODO)) Validation
    $title = $_POST["title"];
    $priority = Priority::from($_POST["priority"]);
    $assigneeId = $_POST["assignee"];
    $deadline = new DateTime($_POST["deadline"]);

    $ticket = new Ticket();
    // TODO)) Auth team lead
    // TODO)) Team
    $ticket->create($title, $priority, null, $deadline);
    if ($assigneeId !== "-1") {
        $assignee = $entityManager->find(User::class, $assigneeId);
        $ticket->setAssignee($assignee);
    }

    $entityManager->persist($ticket);
    $entityManager->flush();

    header("Location: ticket.php?id={$ticket->getId()}");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleCreate($entityManager);
    return;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    return;
}

$users = $entityManager->getRepository(User::class)->findAll();
?>

<?php $pageTitle = "New Ticket";
include (__DIR__ . "/common/top.php"); ?>
<h1>New Ticket</h1>
<form action="new_ticket.php" method="post">
    <div class="form-field">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" autofocus>
    </div>
    <div class="form-field">
        <label for="priority">Priority</label>
        <select id="priority" name="priority">
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
        </select>
    </div>
    <div class="form-field">
        <label for="assignee">Assignee</label>
        <select id="assignee" name="assignee">
            <option value="-1">Unassigned</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user->getId() ?>">
                    <?php echo $user->getUsername() ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-field">
        <label for="deadline">Deadline</label>
        <input type="datetime-local" id="deadline" name="deadline">
    </div>
    <input type="submit" value="Create Ticket">
</form>
