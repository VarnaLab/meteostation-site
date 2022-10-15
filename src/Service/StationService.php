<?php
declare(strict_types=1);

namespace App\Service;

use Doctrine\DBAL\Result;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StationService
 */
class StationService
{
    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
    }

    public function findCurrent(): Result
    {
        $sql = /** @lang PostgreSQL */
            <<<SQL
            select s.station_id, s.name
                 , s.location[0] as lng
                 , s.location[1] as lat
                 , sd.*
            from station s
              inner join lateral (
                  select * 
                  from station_data sd 
                  where sd.station_id=s.station_id 
                  order by sd.created_at desc 
                  limit 1
              ) sd on true
        SQL;

        $stmt = $this->em->getConnection()->prepare($sql);

        return $stmt->executeQuery([]);
    }
}
