<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $this->denyAccessUnlessGranted('ROLE_EVENTS');
        return new Event();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->denyAccessUnlessGranted('ROLE_EVENTS');
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->denyAccessUnlessGranted('ROLE_EVENTS');
        parent::deleteEntity($entityManager, $entityInstance);
    }

    // Vous pouvez redéfinir d'autres méthodes similaires si nécessaire
}
