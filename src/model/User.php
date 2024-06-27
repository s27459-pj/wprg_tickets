<?php
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', enumType: Role::class)]
    private Role $role = Role::USER;

    // TODO)) Team

    /** @var Collection<int, Ticket> */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'assignee')]
    private Collection $assignedTickets;

    public function __construct()
    {
        $this->assignedTickets = new ArrayCollection();
    }

    public function create(string $username, string $password, Role $role): self
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function addAssignedTicket(Ticket $ticket): void
    {
        $this->assignedTickets[] = $ticket;
    }

    public function removeAssignedTicket(Ticket $ticket): void
    {
        $this->assignedTickets->removeElement($ticket);
    }
}


enum Role: string
{
    case USER = 'user';
    case TEAM_LEAD = 'team_lead';
    case ADMIN = 'admin';
}
