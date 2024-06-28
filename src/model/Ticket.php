<?php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'ticket')]
#[ORM\HasLifecycleCallbacks]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'string', enumType: Priority::class)]
    private Priority $priority = Priority::MEDIUM;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'tickets')]
    private Team $team;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'assignedTickets')]
    private ?User $assignee = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $attachment = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $closed = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $deadline;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created = new DateTime();
    }

    public function create(
        string $title,
        Priority $priority,
        Team $team,
        DateTime $deadline
    ): void {
        $this->title = $title;
        $this->priority = $priority;
        $this->team = $team;
        $this->deadline = $deadline;

        $this->team->addTicket($this);
    }

    public function update(
        string $title,
        Priority $priority,
        DateTime $deadline
    ): void {
        $this->title = $title;
        $this->priority = $priority;
        $this->deadline = $deadline;
    }

    public function delete(): void
    {
        $this->team->removeTicket($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): void
    {
        // Unassign
        if ($assignee === null && $this->assignee !== null) {
            $this->assignee->removeAssignedTicket($this);
            $this->assignee = null;
            return;
        }

        // Keep current assignee
        if ($assignee === $this->assignee) {
            return;
        }

        // Reassign
        // Unassign current
        if ($this->assignee !== null) {
            $this->assignee->removeAssignedTicket($this);
        }
        // Assign new
        $this->assignee = $assignee;
        $this->assignee->addAssignedTicket($this);
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created;
    }

    public function getClosedAt(): ?DateTime
    {
        return $this->closed;
    }

    public function getDeadline(): ?DateTime
    {
        return $this->deadline;
    }
}


enum Priority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
