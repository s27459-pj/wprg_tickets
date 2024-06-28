<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";
require_once __DIR__ . "/../util/user.php";
require_once __DIR__ . "/../util/validation.php";

authenticateAdmin($entityManager);

function handleUpdate($entityManager)
{
    $user = getUser($entityManager);
    requireParams(["username", "role", "team"]);

    $username = $_POST["username"];
    $role = Role::from($_POST["role"]);
    $teamId = $_POST["team"];
    if (!is_numeric($teamId)) {
        exit("Invalid team ID");
    } else if ($teamId === "-1") {
        $user->setTeam(null);
    } else {
        $team = $entityManager->find(Team::class, $teamId);
        if ($team === null) {
            exit("Team not found");
        }
        $user->setTeam($team);
    }

    $user->update($username, $role);
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

$user = getUser($entityManager);

$username = $user->getUsername();
$role = $user->getRole();
$team = $user->getTeam();
?>

<?php $pageTitle = "Edit {$user->getUsername()}";
include (__DIR__ . "/common/top.php"); ?>
<h1>Edit <?php echo $user->getUsername() ?></h1>

<form action="edit_user.php?id=<?php echo $user->getId() ?>" method="post">
    <div class="form-field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $username ?>" autofocus>
    </div>
    <div class="form-field">
        <label for="role">Role</label>
        <select id="role" name="role">
            <?php foreach (Role::cases() as $r): ?>
                <?php if ($role === $r): ?>
                    <option value="<?php echo $r->value ?>" selected>
                        <?php echo getEnumDisplayName($r) ?>
                    </option>
                <?php else: ?>
                    <option value="<?php echo $r->value ?>">
                        <?php echo getEnumDisplayName($r) ?>
                    </option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-field">
        <label for="team">Team</label>
        <select id="team" name="team">
            <option value="-1">Unassigned</option>
            <?php foreach ($entityManager->getRepository(Team::class)->findAll() as $t): ?>
                <?php if ($team !== null && $team->getId() === $t->getId()): ?>
                    <option value="<?php echo $t->getId() ?>" selected>
                        <?php echo $t->getName() ?>
                    </option>
                <?php else: ?>
                    <option value="<?php echo $t->getId() ?>">
                        <?php echo $t->getName() ?>
                    </option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
    </div>
    <input type="submit" value="Update User">
</form>
