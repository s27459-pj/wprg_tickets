<?php
require_once __DIR__ . "/../../bootstrap.php";

function getTicket($entityManager): Ticket
{
    if (!isset($_GET["id"])) {
        exit("Missing required parameter: id");
    }
    $ticketId = $_GET["id"];
    $ticket = $entityManager->find(Ticket::class, $ticketId);
    if ($ticket === null) {
        exit("Ticket not found");
    }
    return $ticket;
}
