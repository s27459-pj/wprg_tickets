<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/auth.php";

authenticateAdmin($entityManager);

function handleCreate($entityManager)
{
    $name = $_POST["name"];
    $team = new Team();
    $team->create($name);
    $entityManager->persist($team);
    $entityManager->flush();

    header("Location: admin.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleCreate($entityManager);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}
?>

<?php $pageTitle = "New Team";
include (__DIR__ . "/common/top.php"); ?>
<h1>New Team</h1>
<form action="new_team.php" method="post">
    <div class="form-field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" autofocus>
    </div>
    <button type="submit">Create</button>
</form>
