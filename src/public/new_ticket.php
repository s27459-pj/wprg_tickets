<?php
require_once __DIR__ . "/../../bootstrap.php";

function handleCreate($entityManager)
{
    // TODO)) Validation
    $title = $_POST["title"];
    $priority = $_POST["priority"];
    $assignee = $_POST["assignee"];
    $deadline = new DateTime($_POST["deadline"]);

    $ticket = new Ticket();
    $ticket->create($title, Priority::from($priority), $deadline);
    if ($assignee !== "-1") {
        $user = $entityManager->find(User::class, $assignee);
        $ticket->setAssignee($user);
    }

    $entityManager->persist($ticket);
    $entityManager->flush();

    echo "<p>Created Ticket with ID {$ticket->getId()}";
    echo "<a href=\"ticket.php?id={$ticket->getId()}\">View Ticket</a>";
    echo "</p>";

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ticket</title>
</head>

<body>
    <h1>New Ticket</h1>
    <form action="new_ticket.php" method="post">
        <div class="form-field">
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title"><br>
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
            <label for="deadline">Deadline</label><br>
            <input type="datetime-local" id="deadline" name="deadline"><br>
        </div>
        <input type="submit" value="Create Ticket">
    </form>
    <a href="index.php">Back to Backlog</a>
</body>

</html>
