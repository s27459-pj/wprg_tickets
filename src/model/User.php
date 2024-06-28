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

    #[ORM\Column(type: 'string', unique: true)]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', enumType: Role::class)]
    private Role $role = Role::USER;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'users')]
    private ?Team $team = null;

    /** @var Collection<int, Ticket> */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'assignee')]
    private Collection $assignedTickets;

    public function __construct()
    {
        $this->assignedTickets = new ArrayCollection();
    }

    public function create(string $username, string $password, Role $role): void
    {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->role = $role;
    }

    public function update(string $username, Role $role): void
    {
        $this->username = $username;
        $this->role = $role;
    }

    public function delete(): void
    {
        $this->team->removeUser($this);
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

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    public function isTeamLead(): bool
    {
        return $this->role === Role::TEAM_LEAD;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): void
    {
        // Remove from team
        if ($team === null && $this->team !== null) {
            $this->team->removeUser($this);
            $this->team = null;
            return;
        }

        // Keep current team
        if ($team === $this->team) {
            return;
        }

        // Switch teams
        // Leave current team
        if ($this->team !== null) {
            $this->team->removeUser($this);
        }
        // Join new team
        $this->team = $team;
        $this->team->addUser($this);
    }

    public function getAssignedTickets(): Collection
    {
        return $this->assignedTickets;
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
