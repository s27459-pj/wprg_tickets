<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";
require_once __DIR__ . "/../util/team.php";
require_once __DIR__ . "/../util/validation.php";

authenticateAdmin($entityManager);

function handleUpdate($entityManager)
{
    $team = getTeam($entityManager);
    requireParams(["name"]);

    $name = $_POST["name"];
    $team->update($name);
    $entityManager->flush();

    header("Location: admin.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleUpdate($entityManager);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}

$team = getTeam($entityManager);
$name = $team->getName();
?>

<?php $pageTitle = "Edit {$team->getName()}";
include (__DIR__ . "/common/top.php"); ?>
<h1>Edit <?php echo $team->getName() ?></h1>

<form action="edit_team.php?id=<?php echo $team->getId() ?>" method="post">
    <div class="form-field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo $name ?>" autofocus>
    </div>
    <button type="submit">Update</button>
</form>
