<?php
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";

authenticateAdmin($entityManager);

function handleCreate($entityManager)
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = Role::from($_POST["role"]);
    $teamId = $_POST["team"];

    $user = new User();
    $user->create($username, $password, $role);
    if ($teamId !== "-1") {
        $team = $entityManager->find(Team::class, $teamId);
        $user->setTeam($team);
    }

    $entityManager->persist($user);
    try {
        $entityManager->flush();
    } catch (UniqueConstraintViolationException) {
        exit("This username is already taken.");
    }

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

$teams = $entityManager->getRepository(Team::class)->findAll();
?>

<?php $pageTitle = "New User";
include (__DIR__ . "/common/top.php"); ?>
<h1>New User</h1>
<form action="new_user.php" method="post">
    <div class="form-field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autofocus>
    </div>
    <div class="form-field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="form-field">
        <label for="role">Role</label>
        <select id="role" name="role">
            <?php foreach (Role::cases() as $role): ?>
                <option value="<?php echo $role->value ?>">
                    <?php echo getEnumDisplayName($role) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-field">
        <label for="team">Team</label>
        <select id="team" name="team">
            <option value="-1">Unassigned</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?php echo $team->getId() ?>">
                    <?php echo $team->getName() ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit">Create</button>
</form>
