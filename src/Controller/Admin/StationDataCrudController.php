<?php

namespace App\Controller\Admin;

use App\Entity\StationData;
use App\Field\SensorsField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use MartinGeorgiev\Doctrine\ORM\Query\AST\Functions\JsonGetField;

class StationDataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StationData::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ArrayField::new('value'),
//            SensorsField::new('value'),
            DateTimeField::new('created')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setDefaultSort(['created' => 'DESC']);
    }
}
