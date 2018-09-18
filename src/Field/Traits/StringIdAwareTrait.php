<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Traits;

use Bacart\Bundle\MongoDBBundle\Field\Interfaces\IdAwareInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

trait StringIdAwareTrait
{
    /**
     * @var string
     *
     * @MongoDB\Id(strategy="none")
     *
     * @Assert\NotBlank()
     * @Assert\Regex(IdAwareInterface::STRING_ID_REGEX)
     */
    protected $id;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
