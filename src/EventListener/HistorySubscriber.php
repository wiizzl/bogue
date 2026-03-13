<?php

namespace App\EventListener;

use App\Entity\ActionType;
use App\Entity\HistoryLog;
use App\Entity\Internship;
use App\Entity\InternshipMilestone;
use App\Entity\User;
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

        if (!$user instanceof User) {
            return;
        }

        $statusUpdateActionType = $em->getRepository(ActionType::class)->findOneBy(['code' => 'STATUS_UPDATE']);
        $teacherUpdateActionType = $em->getRepository(ActionType::class)->findOneBy(['code' => 'TEACHER_UPDATE']);

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $changeSet = $uow->getEntityChangeSet($entity);

            if ($entity instanceof InternshipMilestone && isset($changeSet['status']) && $statusUpdateActionType) {
                $oldStatus = $changeSet['status'][0];
                $newStatus = $changeSet['status'][1];

                $this->createHistoryLog(
                    $em,
                    $uow,
                    $entity->getInternship(),
                    $user,
                    $statusUpdateActionType,
                    $oldStatus ? $oldStatus->getLabel() : 'Non défini',
                    $newStatus ? $newStatus->getLabel() : 'Non défini'
                );
            }

            if ($entity instanceof Internship && $teacherUpdateActionType) {
                if (isset($changeSet['trackingTeacher'])) {
                    /** @var User|null $oldTeacher */
                    $oldTeacher = $changeSet['trackingTeacher'][0];
                    /** @var User|null $newTeacher */
                    $newTeacher = $changeSet['trackingTeacher'][1];

                    $this->createHistoryLog(
                        $em,
                        $uow,
                        $entity,
                        $user,
                        $teacherUpdateActionType,
                        'Professeur de suivi: ' . $this->formatTeacher($oldTeacher),
                        'Professeur de suivi: ' . $this->formatTeacher($newTeacher)
                    );
                }

                if (isset($changeSet['visitingTeacher'])) {
                    /** @var User|null $oldTeacher */
                    $oldTeacher = $changeSet['visitingTeacher'][0];
                    /** @var User|null $newTeacher */
                    $newTeacher = $changeSet['visitingTeacher'][1];

                    $this->createHistoryLog(
                        $em,
                        $uow,
                        $entity,
                        $user,
                        $teacherUpdateActionType,
                        'Professeur de visite: ' . $this->formatTeacher($oldTeacher),
                        'Professeur de visite: ' . $this->formatTeacher($newTeacher)
                    );
                }
            }
        }
    }

    private function createHistoryLog(
        $em,
        $uow,
        Internship $internship,
        User $author,
        ActionType $actionType,
        string $oldValue,
        string $newValue
    ): void {
        $log = new HistoryLog();
        $log->setInternship($internship);
        $log->setAuthor($author);
        $log->setActionType($actionType);
        $log->setOldValue($oldValue);
        $log->setNewValue($newValue);
        $log->setCreatedAt(new \DateTime());

        $em->persist($log);

        $classMetadata = $em->getClassMetadata(HistoryLog::class);
        $uow->computeChangeSet($classMetadata, $log);
    }

    private function formatTeacher(?User $teacher): string
    {
        if (!$teacher) {
            return 'Non défini';
        }

        return trim($teacher->getFirstName() . ' ' . $teacher->getLastName());
    }
}
