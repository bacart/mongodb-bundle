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

use Bacart\Bundle\MongoDBBundle\Document\AbstractDocument;
use Bacart\Common\Util\ClassUtils;
use Bacart\SymfonyCommon\Aware\Interfaces\LoggerAwareInterface;
use Bacart\SymfonyCommon\Aware\Traits\LoggerAwareTrait;
use Doctrine\Common\EventSubscriber;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
use Doctrine\ODM\MongoDB\UnitOfWork;
use InvalidArgumentException;

abstract class AbstractDoctrineSubscriber implements EventSubscriber, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        $result = [];

        $events = ClassUtils::getClassConstants(Events::class);

        foreach ($events as $event) {
            if (method_exists($this, $event)) {
                $result[] = $event;
            }
        }

        return $result;
    }

    /**
     * @param LifecycleEventArgs           $eventArgs
     * @param object|AbstractDocument|null $document
     *
     * @return array|null
     */
    protected function recomputeSingleDocumentChangeSet(
        LifecycleEventArgs $eventArgs,
        AbstractDocument $document = null
    ): ?array {
        if (null === $document) {
            $document = $eventArgs->getDocument();
        }

        $documentManager = $eventArgs->getDocumentManager();
        $uow = $documentManager->getUnitOfWork();

        if (UnitOfWork::STATE_MANAGED !== $uow->getDocumentState($document)) {
            return null;
        }

        $meta = $documentManager->getClassMetadata(get_class($document));

        try {
            $uow->recomputeSingleDocumentChangeSet($meta, $document);

            return $uow->getDocumentChangeSet($document);
        } catch (InvalidArgumentException $e) {
            $this->error($e, get_defined_vars());
        }

        return null;
    }

//    /**
//     * @param LifecycleEventArgs            $eventArgs
//     * @param \object|AbstractDocument|null $document
//     *
//     * @return \object|AbstractDocument|null
//     */
//    protected function getParentDocument(
//        LifecycleEventArgs $eventArgs,
//        AbstractDocument $document = null
//    ): ?AbstractDocument {
//        if (null === $document) {
//            $document = $eventArgs->getDocument();
//        }
//
//        // TODO: see ->getUnitOfWork()->getOwningDocument($document), maybe it'll be useful
//        return $eventArgs
//            ->getDocumentManager()
//            ->getUnitOfWork()
//            ->getParentAssociation($document)[1] ?? null;
//    }
}
