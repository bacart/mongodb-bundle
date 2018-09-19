<?php

namespace Bacart\Bundle\MongoDBBundle\DoctrineEventSubscriber;

use Bacart\Bundle\MongoDBBundle\Field\Interfaces\CreatedAwareInterface;
use Bacart\Bundle\MongoDBBundle\Field\Interfaces\UpdatedAwareInterface;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;

class CreatedUpdatedSubscriber extends AbstractDoctrineSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $this
            ->setCreatedDate($eventArgs)
            ->setUpdatedDate($eventArgs);
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $this->setUpdatedDate($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @return CreatedUpdatedSubscriber
     */
    protected function setCreatedDate(
        LifecycleEventArgs $eventArgs
    ): CreatedUpdatedSubscriber {
        $document = $eventArgs->getDocument();

        if ($document instanceof CreatedAwareInterface) {
            $document->setCreated(new \DateTime());
        }

        return $this;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @return CreatedUpdatedSubscriber
     */
    protected function setUpdatedDate(
        LifecycleEventArgs $eventArgs
    ): CreatedUpdatedSubscriber {
        $document = $eventArgs->getDocument();

        if ($document instanceof UpdatedAwareInterface) {
            $document->setUpdated(new \DateTime());

            $this->recomputeSingleDocumentChangeSet($eventArgs, $document);
        }

        return $this;
    }
}
