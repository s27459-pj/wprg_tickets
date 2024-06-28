<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";

authenticateAdmin($entityManager);

$users = $entityManager->getRepository(User::class)->findAll();
$teams = $entityManager->getRepository(Team::class)->findAll();
?>

<?php $pageTitle = "Admin dashboard";
include (__DIR__ . "/common/top.php"); ?>
<h1>Admin dashboard</h1>

<section>
    <h2>Users</h2>
    <a href="new_user.php">New User</a><br><br>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Team</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->getId() ?></td>
                <td><?php echo $user->getUsername() ?></td>
                <td><?php echo getEnumDisplayName($user->getRole()) ?></td>
                <td>
                    <?php
                    if ($user->getTeam() === null) {
                        echo "none";
                    } else {
                        echo $user->getTeam()->getName();
                    }
                    ?>
                </td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user->getId() ?>">edit</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</section>

<section>
    <h2>Teams</h2>
    <a href="new_team.php">New Team</a><br><br>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($teams as $team): ?>
            <tr>
                <td><?php echo $team->getId() ?></td>
                <td><?php echo $team->getName() ?></td>
                <td>
                    <!-- TODO)) Edit team -->
                    <a href="edit_team.php?id=<?php echo $team->getId() ?>">edit</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</section>
