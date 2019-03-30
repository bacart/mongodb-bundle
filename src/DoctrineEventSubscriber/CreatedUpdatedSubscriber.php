<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacart\Bundle\MongoDBBundle\DoctrineEventSubscriber;

use Bacart\Bundle\MongoDBBundle\Field\Interfaces\CreatedAwareInterface;
use Bacart\Bundle\MongoDBBundle\Field\Interfaces\UpdatedAwareInterface;
use DateTime;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use Exception;

class CreatedUpdatedSubscriber extends AbstractDoctrineSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @throws Exception
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $this
            ->setCreatedDate($eventArgs)
            ->setUpdatedDate($eventArgs);
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     *
     * @throws Exception
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $this->setUpdatedDate($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @throws Exception
     *
     * @return CreatedUpdatedSubscriber
     */
    protected function setCreatedDate(
        LifecycleEventArgs $eventArgs
    ): CreatedUpdatedSubscriber {
        $document = $eventArgs->getDocument();

        if ($document instanceof CreatedAwareInterface) {
            $document->setCreated(new DateTime());
        }

        return $this;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @throws Exception
     *
     * @return CreatedUpdatedSubscriber
     */
    protected function setUpdatedDate(
        LifecycleEventArgs $eventArgs
    ): CreatedUpdatedSubscriber {
        $document = $eventArgs->getDocument();

        if ($document instanceof UpdatedAwareInterface) {
            $document->setUpdated(new DateTime());

            $this->recomputeSingleDocumentChangeSet($eventArgs, $document);
        }

        return $this;
    }
}
