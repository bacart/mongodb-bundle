<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacart\Bundle\MongoDBBundle\Field\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use MongoId;

trait MongoIdAwareTrait
{
    /**
     * @var MongoId
     *
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * @return MongoId|null
     */
    public function getId(): ?MongoId
    {
        return $this->id;
    }

    /**
     * @param MongoId $id
     *
     * @return self
     */
    public function setId(MongoId $id): self
    {
        $this->id = $id;

        return $this;
    }
}
