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

use DateTime;
use DateTimeInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Exception;

trait CreatedAwareTrait
{
    /**
     * @var DateTimeInterface
     *
     * @MongoDB\Field(type="date")
     */
    protected $created;

    /**
     * @throws Exception
     *
     * @return DateTimeInterface
     */
    public function getCreated(): DateTimeInterface
    {
        return $this->created ?: new DateTime();
    }

    /**
     * @param DateTimeInterface $created
     *
     * @return self
     */
    public function setCreated(DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
