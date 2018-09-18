<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

trait IntegerIdAwareTrait
{
    /**
     * @var int
     *
     * @MongoDB\Id(type="int", strategy="none")
     */
    protected $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
