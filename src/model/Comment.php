<?php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'comment')]
#[ORM\HasLifecycleCallbacks]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private ?User $author = null;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'comments')]
    private ?Ticket $ticket = null;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created = new DateTime();
    }

    public function create(User $author, Ticket $ticket, string $content): void
    {
        $this->author = $author;
        $this->ticket = $ticket;
        $this->content = $content;

        $this->author->addComment($this);
        $this->ticket->addComment($this);
    }

    function getId(): ?int
    {
        return $this->id;
    }

    function getAuthor(): User
    {
        return $this->author;
    }

    function getTicket(): Ticket
    {
        return $this->ticket;
    }

    function getContent(): string
    {
        return $this->content;
    }

    function getCreated(): DateTime
    {
        return $this->created;
    }
}
