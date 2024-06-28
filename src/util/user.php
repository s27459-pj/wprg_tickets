<?php
require_once __DIR__ . "/../../bootstrap.php";

function getUser($entityManager): User
{
    if (!isset($_GET["id"])) {
        exit("Missing required parameter: id");
    }
    $userId = $_GET["id"];
    $user = $entityManager->find(User::class, $userId);
    if ($user === null) {
        exit("User not found");
    }
    return $user;
}
