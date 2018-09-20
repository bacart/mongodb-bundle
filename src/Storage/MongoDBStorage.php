<?php

namespace Bacart\Bundle\MongoDBBundle\Storage;

use Bacart\Bundle\MongoDBBundle\Document\AbstractDocument;
use Bacart\Common\Util\ClassUtils;
use Bacart\SymfonyCommon\Interfaces\DocumentManagerAwareInterface;
use Bacart\SymfonyCommon\Interfaces\LoggerAwareInterface;
use Bacart\SymfonyCommon\Interfaces\SessionAwareInterface;
use Bacart\SymfonyCommon\Traits\DocumentManagerAwareTrait;
use Bacart\SymfonyCommon\Traits\LoggerAwareTrait;
use Bacart\SymfonyCommon\Traits\SessionAwareTrait;
use Doctrine\ODM\MongoDB\UnitOfWork;

class MongoDBStorage implements DocumentManagerAwareInterface, SessionAwareInterface, LoggerAwareInterface
{
    use DocumentManagerAwareTrait;
    use SessionAwareTrait;
    use LoggerAwareTrait;

    protected const ACTION_DOCUMENT_CREATED = 'created';
    protected const ACTION_DOCUMENT_UPDATED = 'updated';
    protected const ACTION_DOCUMENT_DELETED = 'deleted';

    /**
     * @param AbstractDocument $document
     * @param bool             $addFlash
     *
     * @return bool
     */
    public function createDocument(
        AbstractDocument $document,
        bool $addFlash = false
    ): bool {
        try {
            $this->documentManager->persist($document);
            $result = $this->updateDocument($document);
        } catch (\InvalidArgumentException $e) {
            $this->logException($e, get_defined_vars());
            $result = false;
        }

        if ($addFlash) {
            $this->addFlash($document, static::ACTION_DOCUMENT_CREATED, $result);
        }

        return $result;
    }

    /**
     * @param AbstractDocument $document
     * @param bool             $addFlash
     *
     * @return bool
     */
    public function updateDocument(
        AbstractDocument $document,
        bool $addFlash = false
    ): bool {
        $uow = $this->documentManager->getUnitOfWork();

        if (UnitOfWork::STATE_MANAGED !== $uow->getDocumentState($document)) {
            $result = true;
        } else {
            try {
                $this->documentManager->flush($document);
                $result = true;
            } catch (\InvalidArgumentException $e) {
                $this->logException($e, get_defined_vars());
                $result = false;
            }
        }

        if ($addFlash) {
            $this->addFlash($document, static::ACTION_DOCUMENT_UPDATED, $result);
        }

        return $result;
    }

    /**
     * @param AbstractDocument $document
     * @param bool             $addFlash
     *
     * @return bool
     */
    public function deleteDocument(
        AbstractDocument $document,
        bool $addFlash = false
    ): bool {
        try {
            $this->documentManager->remove($document);
            $this->documentManager->flush($document);

            $result = true;
        } catch (\InvalidArgumentException $e) {
            $this->logException($e, get_defined_vars());
            $result = false;
        }

        if ($addFlash) {
            $this->addFlash($document, static::ACTION_DOCUMENT_DELETED, $result);
        }

        return $result;
    }

    /**
     * @param AbstractDocument $document
     * @param string           $action
     * @param bool             $result
     */
    protected function addFlash(
        AbstractDocument $document,
        string $action,
        bool $result
    ): void {
        if (null === $this->session) {
            $this->logger->warning('You can not use the addFlash method if sessions are disabled. Enable them in "config/packages/framework.yaml".');

            return;
        }

        $documentName = sprintf(
            '%s <strong>%s</strong>',
            ClassUtils::getClassShortName(\get_class($document)),
            $document->getId()
        );

        $type = $result ? 'success' : 'danger';

        $message = $result
            ? sprintf('%s %s successfully', $documentName, $action)
            : sprintf('%s has not been %s', $documentName, $action);

        $this->session->getFlashBag()->add($type, $message);
    }
}
