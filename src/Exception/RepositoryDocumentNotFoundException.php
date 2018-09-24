<?php

namespace Bacart\Bundle\MongoDBBundle\Exception;

class RepositoryDocumentNotFoundException extends AbstractMongoDBException
{
    /**
     * @param string $repositoryClass
     */
    public function __construct(string $repositoryClass)
    {
        $message = sprintf('Document for repository "%s" not found', $repositoryClass);

        parent::__construct($message);
    }
}
