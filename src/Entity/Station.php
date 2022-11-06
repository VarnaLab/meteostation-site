<?php
declare(strict_types=1);

namespace App\Entity;

use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ORM\Entity,
    ORM\Table(name: "station"),
    UniqueEntity(fields: ['id'], message: 'Station with this identifier has already been registered.')
]
class Station
{
    #[ORM\Id, ORM\Column(name: 'station_id', type: 'string')]
    private string $id;

    #[ORM\Column(name: 'name', type: 'string')]
    public ?string $name = null;

    #[ORM\Column(name: 'description', type: 'string', nullable: true)]
    public string $description = '';

    #[ORM\Column(name: 'location', type: 'point', nullable: true)]
    public ?Point $location = null;

    #[ORM\Column(name: 'created_at', type: 'datetimetz_immutable')]
    private \DateTimeImmutable $created;

    public function __construct()
    {
        $this->created = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): void
    {
        $this->id = $value;
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

    public function setDescription(?string $description = ''): void
    {
        $this->description = $description ?? '';
    }

    public function getLocation(): ?Point
    {
        return $this->location;
    }

    public function setLocation($location): void
    {
        if (is_string($location)) {
            [$long, $lat] = preg_split('#(\s+|,\s*)#', $location);
            $location = (new Point($long, $lat));
        }
        $this->location = $location;
    }

    public function __toString()
    {
        return $this->name ?? 'Unnamed';
    }
}
