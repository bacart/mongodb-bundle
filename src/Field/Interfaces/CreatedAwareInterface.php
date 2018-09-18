<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Interfaces;

interface CreatedAwareInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getCreated(): \DateTimeInterface;

    /**
     * @param \DateTimeInterface $created
     */
    public function setCreated(\DateTimeInterface $created);
}
