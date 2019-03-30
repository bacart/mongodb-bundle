<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacart\Bundle\MongoDBBundle\Field\Interfaces;

use DateTimeInterface;

interface UpdatedAwareInterface
{
    /**
     * @return DateTimeInterface
     */
    public function getUpdated(): DateTimeInterface;

    /**
     * @param DateTimeInterface $updated
     */
    public function setUpdated(DateTimeInterface $updated);
}
