<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

trait CreatedAwareTrait
{
    /**
     * @var \DateTimeInterface
     *
     * @MongoDB\Field(type="date")
     */
    protected $created;

    /**
     * @return \DateTimeInterface
     */
    public function getCreated(): \DateTimeInterface
    {
        return $this->created ?: new \DateTime();
    }

    /**
     * @param \DateTimeInterface $created
     *
     * @return self
     */
    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
