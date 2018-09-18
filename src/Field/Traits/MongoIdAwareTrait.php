<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

trait MongoIdAwareTrait
{
    /**
     * @var \MongoId
     *
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * @return \MongoId|null
     */
    public function getId(): ?\MongoId
    {
        return $this->id;
    }

    /**
     * @param \MongoId $id
     *
     * @return self
     */
    public function setId(\MongoId $id): self
    {
        $this->id = $id;

        return $this;
    }
}
