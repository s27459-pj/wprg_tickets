<?php
require_once __DIR__ . "/../../bootstrap.php";

function authenticate($entityManager): User
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["user"])) {
        http_response_code(401);
        exit("User not authenticated");
    }
    $userId = $_SESSION["user"];
    $user = $entityManager->find(User::class, $userId);
    if ($user === null) {
        http_response_code(401);
        exit("User not found");
    }
    return $user;
}

function authenticateOptional($entityManager): ?User
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["user"])) {
        return null;
    }
    $userId = $_SESSION["user"];
    $user = $entityManager->find(User::class, $userId);
    if ($user === null) {
        return null;
    }
    return $user;
}

function authenticateAdmin($entityManager): User
{

    $user = authenticate($entityManager);
    if (!$user->isAdmin()) {
        http_response_code(403);
        exit("Forbidden");
    }
    return $user;
}

function authenticateTeamLead($entityManager, ?Team $team = null): User
{
    $user = authenticate($entityManager);
    if ($user->isAdmin()) {
        return $user;
    }
    if (!$user->isTeamLead()) {
        http_response_code(403);
        exit("Forbidden");
    }
    if ($team !== null && $user->getTeam() !== $team) {
        http_response_code(403);
        exit("Forbidden");
    }
    return $user;
}

function authenticateTeamMember($entityManager, Team $team): User
{
    $user = authenticate($entityManager);
    if ($user->isAdmin()) {
        return $user;
    }
    if ($user->getTeam() !== $team) {
        http_response_code(403);
        exit("Forbidden");
    }
    return $user;
}
