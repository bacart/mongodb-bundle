<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

trait UpdatedAwareTrait
{
    /**
     * @var \DateTimeInterface
     *
     * @MongoDB\Field(type="date")
     */
    protected $updated;

    /**
     * @return \DateTimeInterface
     */
    public function getUpdated(): \DateTimeInterface
    {
        return $this->updated ?: new \DateTime();
    }

    /**
     * @param \DateTimeInterface $updated
     *
     * @return self
     */
    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
