<?php
require_once __DIR__ . "/../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // TODO)) Validation
    $title = $_POST["title"];
    $priority = $_POST["priority"];
    // TODO)) Assignee
    $deadline = new DateTime($_POST["deadline"]);

    $ticket = new Ticket();
    $ticket->create($title, Priority::from($priority), null, $deadline);

    $entityManager->persist($ticket);
    $entityManager->flush();

    echo "<p>Created Ticket with ID {$ticket->getId()}";
    echo "<a href=\"ticket.php?id={$ticket->getId()}\">View Ticket</a>";
    echo "</p>";
}
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
            <label for="deadline">Deadline</label><br>
            <input type="datetime-local" id="deadline" name="deadline"><br>
        </div>
        <input type="submit" value="Create Ticket">
    </form>
</body>

</html>
