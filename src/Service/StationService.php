<?php
declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Result;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StationService
 */
class StationService
{
    private const DEFAULT_VALIDITY = '2 months';

    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function findCurrent(): Result
    {
        $sql = /** @lang PostgreSQL */
            <<<SQL
            select s.station_id, s.name
                 , (s.location::point)[0] as lng
                 , (s.location::point)[1] as lat
                 , sd.*
            from station s
              inner join lateral (
                  select sd.station_id, sd.created_at, sd.value
                  from station_data sd 
                  where sd.station_id=s.station_id 
                    and sd.created_at >= :when
                  order by sd.created_at desc 
                  limit 1
              ) sd on true
        SQL;

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue('when', (new \DateTimeImmutable('-' . self::DEFAULT_VALIDITY))->format('c'));

        return $stmt->executeQuery();
    }
}
