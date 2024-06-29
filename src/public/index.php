<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}

enum ViewType: string
{
    case ALL = "all";
    case USER = "user";
    case TEAM = "team";
    case PRIORITY = "priority";
    case DEADLINE = "deadline";
}

if (!isset($_GET["view"])) {
    header("Location: index.php?view=" . ViewType::ALL->value);
    exit;
}

function getParam($paramName): string
{
    if (!isset($_GET[$paramName])) {
        exit("$paramName parameter not provided");
    }
    return $_GET[$paramName];
}

function getViewUser($entityManager): User
{
    $userId = getParam("user");
    $user = $entityManager->getRepository(User::class)->find($userId);
    if ($user === null) {
        exit("User not found");
    }
    return $user;
}

function getViewTeam($entityManager): Team
{
    $teamId = getParam("team");
    $team = $entityManager->getRepository(Team::class)->find($teamId);
    if ($team === null) {
        exit("Team not found");
    }
    return $team;
}

function getViewDeadline(): DateTime
{
    $deadline = getParam("deadline");
    $date = (new DateTime($deadline))->format("Y-m-d");
    return new DateTime($date);
}

function getViewName($entityManager, ViewType $view)
{
    if ($view === ViewType::ALL) {
        return "All Tickets";
    } else if ($view === ViewType::USER) {
        $user = getViewUser($entityManager);
        return "Tickets assigned to {$user->getUsername()}";
    } else if ($view === ViewType::TEAM) {
        $team = getViewTeam($entityManager);
        return "Tickets from {$team->getName()}";
    } else if ($view === ViewType::PRIORITY) {
        $priority = ucwords(str_replace("_", " ", getParam("priority")));
        return "{$priority} priority Tickets";
    } else if ($view === ViewType::DEADLINE) {
        $deadline = getViewDeadline();
        return "Tickets due by {$deadline->format('Y-m-d')}";
    }
}

function getTickets($entityManager, ViewType $view)
{
    if ($view === ViewType::ALL) {
        return $entityManager->getRepository(Ticket::class)->findAll();
    } else if ($view === ViewType::USER) {
        $user = getViewUser($entityManager);
        $dql = "SELECT t FROM Ticket t WHERE t.assignee = {$user->getId()}";
        return $entityManager->createQuery($dql)->getResult();
    } else if ($view === ViewType::TEAM) {
        $team = getViewTeam($entityManager);
        $dql = "SELECT t FROM Ticket t WHERE t.team = {$team->getId()}";
        return $entityManager->createQuery($dql)->getResult();
    } else if ($view === ViewType::PRIORITY) {
        $priority = getParam("priority");
        $qb = $entityManager->createQueryBuilder();
        $qb->select('t')->from(Ticket::class, 't')
            ->where("t.priority = :priority")
            ->setParameter("priority", $priority);
        return $qb->getQuery()->getResult();
    } else if ($view === ViewType::DEADLINE) {
        $deadline = getViewDeadline();
        $start = $deadline->format("Y-m-d");
        $end = date('Y-m-d', strtotime($start . ' + 1 day'));
        $qb = $entityManager->createQueryBuilder();
        $qb->select('t')->from(Ticket::class, 't')
            ->where("t.deadline >= :start")
            ->andWhere("t.deadline < :end")
            ->setParameter("start", $start)
            ->setParameter("end", $end);
        return $qb->getQuery()->getResult();
    }
}

$viewName = getViewName($entityManager, ViewType::from($_GET["view"]));
$tickets = getTickets($entityManager, ViewType::from($_GET["view"]));
$users = $entityManager->getRepository(User::class)->findAll();
$teams = $entityManager->getRepository(Team::class)->findAll();
?>

<?php $pageTitle = "Tickets";
include (__DIR__ . "/common/top.php"); ?>
<h1><?php echo $viewName ?></h1>
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

<h2>Filter</h2>
<form action="index.php">
    <span>All</span>
    <input type="submit" value="Filter">
</form>
<form action="index.php" method="get">
    <span>Assigned to User</span>
    <input type="hidden" name="view" value="user">
    <select name="user">
        <?php foreach ($users as $user): ?>
            <option value="<?php echo $user->getId() ?>">
                <?php echo $user->getUsername() ?>
            </option>
        <?php endforeach ?>
    </select>
    <input type="submit" value="Filter">
</form>
<form action="index.php">
    <span>Assigned to Team</span>
    <input type="hidden" name="view" value="team">
    <select name="team">
        <?php foreach ($teams as $team): ?>
            <option value="<?php echo $team->getId() ?>">
                <?php echo $team->getName() ?>
            </option>
        <?php endforeach ?>
    </select>
    <input type="submit" value="Filter">
</form>
<form action="index.php">
    <span>With Priority</span>
    <input type="hidden" name="view" value="priority">
    <select name="priority">
        <?php foreach (Priority::cases() as $priority): ?>
            <option value="<?php echo $priority->value ?>">
                <?php echo getEnumDisplayName($priority) ?>
            </option>
        <?php endforeach ?>
    </select>
    <input type="submit" value="Filter">
</form>
<form action="index.php">
    <span>For a given day</span>
    <input type="hidden" name="view" value="deadline">
    <input type="datetime" name="deadline">
    <input type="submit" value="Filter">
</form>
