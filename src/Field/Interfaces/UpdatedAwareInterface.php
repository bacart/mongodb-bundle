<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Interfaces;

interface UpdatedAwareInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getUpdated(): \DateTimeInterface;

    /**
     * @param \DateTimeInterface $updated
     */
    public function setUpdated(\DateTimeInterface $updated);
}
