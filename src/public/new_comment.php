<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../util/util.php";
require_once __DIR__ . "/../util/auth.php";
require_once __DIR__ . "/../util/ticket.php";

$ticket = getTicket($entityManager, "ticket_id");
$user = authenticateTeamMember($entityManager, $ticket->getTeam());

function handleCreate($entityManager, User $user, Ticket $ticket)
{
    $content = $_POST["content"];
    $comment = new Comment();
    $comment->create($user, $ticket, $content);
    $entityManager->persist($comment);
    $entityManager->flush();

    header("Location: ticket.php?id={$ticket->getId()}");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    handleCreate($entityManager, $user, $ticket);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}
