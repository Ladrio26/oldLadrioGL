<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('username'),
            TextField::new('email'),
            ChoiceField::new('roles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'VIP' => 'ROLE_VIP',
                    'Events' => 'ROLE_EVENTS',
                    'Family' => 'ROLE_FAMILY',
                ])
                ->allowMultipleChoices()
                ->renderExpanded()
                ->renderAsBadges(),

            // Ajoute les autres champs nécessaires
        ];
    }
}
