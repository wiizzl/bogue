<?php

namespace App\EventListener;

use App\Entity\ActionType;
use App\Entity\HistoryLog;
use App\Entity\InternshipMilestone;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::onFlush)]
class HistorySubscriber
{
    public function __construct(private Security $security)
    {
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        $user = $this->security->getUser();

        if (!$user) {
            return;
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if (!$entity instanceof InternshipMilestone) {
                continue;
            }

            $changeSet = $uow->getEntityChangeSet($entity);

            if (isset($changeSet['status'])) {
                $oldStatus = $changeSet['status'][0];
                $newStatus = $changeSet['status'][1];

                $log = new HistoryLog();
                $log->setInternship($entity->getInternship());
                $log->setAuthor($user);

                $actionType = $em->getRepository(ActionType::class)->findOneBy(['code' => 'UPDATE']);
                $log->setActionType($actionType);

                $log->setOldValue($oldStatus ? $oldStatus->getLabel() : 'Non défini');
                $log->setNewValue($newStatus ? $newStatus->getLabel() : 'Non défini');

                $log->setCreatedAt(new \DateTime());

                $em->persist($log);

                $classMetadata = $em->getClassMetadata(HistoryLog::class);
                $uow->computeChangeSet($classMetadata, $log);
            }
        }
    }
}
