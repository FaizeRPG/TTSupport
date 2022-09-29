<?php

namespace App\Controller\Admin;

use App\Entity\Jdr;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

use App\Entity\JdrPlayer;

class JdrCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Jdr::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('admin'),
            AssociationField::new('jdrPlayers'),
        ];
    }
}
