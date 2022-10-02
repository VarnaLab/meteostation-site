<?php
declare(strict_types=1);

namespace App\Types;

use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class PointType
 */
class PointType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'point';
    }

    public function getName()
    {
        return 'point';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        [$lon, $lat] = sscanf($value, 'POINT(%f %f)');

        return (new Point($lon, $lat));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Point) {
            $value = sprintf('POINT(%F %F)', $value->getLongitude(), $value->getLatitude());
        }

        return $value;
    }


    public function convertToPHPValueSQL($sqlExpr, $platform): string
    {
        return sprintf('ST_AsText(%s)', $sqlExpr);
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return sprintf('ST_GeomFromText(%s)', $sqlExpr);
    }

    public function canRequireSQLConversion()
    {
        return true;
    }


}
