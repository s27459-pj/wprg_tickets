<?php
require_once __DIR__ . "/../../bootstrap.php";

function getTicket($entityManager, ?string $paramName = null): Ticket
{
    $param = $paramName ?? "id";
    if (!isset($_GET[$param])) {
        exit("Missing required parameter: $param");
    }
    $ticketId = $_GET[$param];
    $ticket = $entityManager->find(Ticket::class, $ticketId);
    if ($ticket === null) {
        exit("Ticket not found");
    }
    return $ticket;
}
