<?php

namespace Bacart\Bundle\MongoDBBundle\Storage;

use Bacart\Bundle\MongoDBBundle\Document\AbstractDocument;

interface MongoDBStorageInterface
{
    public const ACTION_DOCUMENT_CREATED = 'created';
    public const ACTION_DOCUMENT_UPDATED = 'updated';
    public const ACTION_DOCUMENT_DELETED = 'deleted';

    /**
     * @param AbstractDocument $document
     * @param bool             $addFlash
     *
     * @return bool
     */
    public function createDocument(AbstractDocument $document, bool $addFlash = false): bool;

    /**
     * @param AbstractDocument $document
     * @param bool             $addFlash
     *
     * @return bool
     */
    public function updateDocument(AbstractDocument $document, bool $addFlash = false): bool;

    /**
     * @param AbstractDocument $document
     * @param bool             $addFlash
     *
     * @return bool
     */
    public function deleteDocument(AbstractDocument $document, bool $addFlash = false): bool;

    /**
     * @param AbstractDocument $document
     * @param string           $action
     * @param bool             $result
     */
    public function addFlash(AbstractDocument $document, string $action, bool $result): void;
}
