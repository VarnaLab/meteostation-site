<?php
declare(strict_types=1);

namespace App\Entity;

use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[
    ORM\Entity,
    ORM\Table(name: "station")
]
class Station
{
    #[ORM\Id, ORM\Column(name: 'station_id', type: 'string')]
    private readonly string $id;

    #[ORM\Column(name: 'name', type: 'string')]
    public ?string $name = null;

    #[ORM\Column(name: 'description', type: 'string')]
    public string $description = '';

    #[ORM\Column(name: 'location', type: 'point')]
    public Point $location;

    #[ORM\Column(name: 'created_at', type: 'datetimetz_immutable')]
    private \DateTimeImmutable $created;

    public function __construct()
    {
        $this->id = (string)Uuid::v6();
        $this->created = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string|null $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getLocation(): Point
    {
        return $this->location;
    }

    public function setLocation(Point $location): void
    {
        $this->location = $location;
    }

    public function __toString()
    {
        return $this->name ?? 'Unnamed';
    }
}
