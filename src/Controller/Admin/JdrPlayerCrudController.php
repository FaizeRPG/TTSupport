<?php

namespace App\Controller\Admin;

use App\Entity\JdrPlayer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class JdrPlayerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JdrPlayer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('picture'),
            TextField::new('token'),
            IntegerField::new('diceCount'),
            BooleanField::new('isActive'),
            AssociationField::new('owner'),
            AssociationField::new('jdr')
        ];
    }
}
