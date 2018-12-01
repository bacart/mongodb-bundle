<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
