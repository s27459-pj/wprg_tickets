<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/ticket.php";

function handleUpdate($entityManager)
{
    $ticket = getTicket($entityManager);

    $required_params = ["title", "priority", "assignee", "deadline"];
    foreach ($required_params as $param) {
        if (!isset($_POST[$param])) {
            exit("Missing required parameter: $param");
        }
    }

    $title = $_POST["title"];
    $priority = Priority::from($_POST["priority"]);
    $assigneeId = $_POST["assignee"];
    $deadline = new DateTime($_POST["deadline"]);
    if (!is_numeric($assigneeId)) {
        exit("Invalid assignee ID");
    } else if ($assigneeId === "-1") {
        $ticket->setAssignee(null);
    } else {
        $assignee = $entityManager->find(User::class, $assigneeId);
        if ($assignee === null) {
            exit("Assignee not found");
        }
        $ticket->setAssignee($assignee);
    }

    $ticket->update($title, $priority, $deadline);
    $entityManager->flush();

    header("Location: ticket.php?id={$ticket->getId()}");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleUpdate($entityManager);
    return;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit("Unsupported HTTP method");
}

$ticket = getTicket($entityManager);

$status = $ticket->getClosedAt() !== null ? "Closed" : "Open";
$assignee = $ticket->getAssignee();
$assigneeString = $assignee !== null ? $assignee->getUsername() : "Unassigned";
$deadline = $ticket->getDeadline()->format('Y-m-d H:i');

$users = $entityManager->getRepository(User::class)->findAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo $ticket->getTitle() ?></title>
</head>

<body>
    <a href="ticket.php?id=<?php echo $ticket->getId() ?>">cancel</a>
    <form action="edit_ticket.php?id=<?php echo $ticket->getId() ?>" method="post">
        <div class="form-field">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo $ticket->getTitle() ?>" autofocus>
        </div>
        <div class="form-field">
            <label for="priority">Priority</label>
            <select id="priority" name="priority">
                <?php foreach (Priority::cases() as $priority): ?>
                    <?php if ($ticket->getPriority() === $priority): ?>
                        <option value="<?php echo $priority->value ?>" selected>
                            <?php echo ucwords($priority->value) ?>
                        </option>
                    <?php else: ?>
                        <option value="<?php echo $priority->value ?>">
                            <?php echo ucwords($priority->value) ?>
                        </option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-field">
            <label for="assignee">Assignee</label>
            <select id="assignee" name="assignee">
                <option value="-1">Unassigned</option>
                <?php foreach ($users as $user): ?>
                    <?php if ($assignee !== null && $assignee->getId() === $user->getId()): ?>
                        <option value="<?php echo $user->getId() ?>" selected>
                            <?php echo $user->getUsername() ?>
                        </option>
                    <?php else: ?>
                        <option value="<?php echo $user->getId() ?>">
                            <?php echo $user->getUsername() ?>
                        </option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-field">
            <label for="deadline">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline" value="<?php echo $deadline ?>">
        </div>
        <input type="submit" value="Update Ticket">
    </form>
    <a href="index.php">Back to Backlog</a>
</body>

</html>
