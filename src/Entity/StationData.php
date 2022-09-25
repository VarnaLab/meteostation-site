<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MartinGeorgiev\Doctrine\DBAL\Types\Jsonb;
use Symfony\Component\Uid\Uuid;

#[
    ORM\Entity,
    ORM\Table(name: 'station_data')
]
class StationData
{
    #[ORM\Id, ORM\Column(name: 'station_data_id', type: 'uuid')]
    private Uuid $id;

    #[
        ORM\ManyToOne(targetEntity: Station::class),
        ORM\JoinColumn(name: 'station_id', referencedColumnName: 'station_id')
    ]
    private ?Station $station = null;

    #[ORM\Column(name: 'value', type: 'json')]
    private array $value;

    #[ORM\Column(name: 'created_at', type: Types::DATETIMETZ_IMMUTABLE)]
    private ?\DateTimeInterface $created = null;

    public function __construct()
    {
        $this->id = Uuid::v6();
        $this->created = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }
}
