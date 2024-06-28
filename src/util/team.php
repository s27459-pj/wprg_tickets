<?php
require_once __DIR__ . "/../../bootstrap.php";

function getTeam($entityManager): Team
{
    if (!isset($_GET["id"])) {
        exit("Missing required parameter: id");
    }
    $teamId = $_GET["id"];
    $team = $entityManager->find(Team::class, $teamId);
    if ($team === null) {
        exit("Team not found");
    }
    return $team;
}

