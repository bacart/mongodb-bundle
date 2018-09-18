<?php

namespace Bacart\Bundle\MongoDBBundle\Document;

use Bacart\Bundle\MongoDBBundle\Field\Interfaces\IdAwareInterface;
use Bacart\Bundle\MongoDBBundle\Repository\AbstractDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\MappedSuperclass(repositoryClass=AbstractDocumentRepository::class)
 * @Unique("id")
 */
abstract class AbstractDocument implements IdAwareInterface
{
}
