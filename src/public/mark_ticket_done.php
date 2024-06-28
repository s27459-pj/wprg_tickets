<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";
require_once __DIR__ . "/../util/ticket.php";

$ticket = getTicket($entityManager);
authenticateTeamMember($entityManager, $ticket->getTeam());

function handleMarkAsDone($entityManager, Ticket $ticket)
{
    $ticket->close();
    $entityManager->flush();

    header("Location: ticket.php?id={$ticket->getId()}");
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    handleMarkAsDone($entityManager, $ticket);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}
