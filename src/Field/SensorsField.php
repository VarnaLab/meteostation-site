<?php
declare(strict_types=1);

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

/**
 * Class SensorsField
 */
class SensorsField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): SensorsField
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormattedValue(5)
            ;
    }


}
