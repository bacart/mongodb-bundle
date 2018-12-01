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

interface IdAwareInterface
{
    public const STRING_ID_REGEX = '/^[a-z0-9-_.,:;!? ]+$/i';

    /**
     * @return mixed
     */
    public function getId();
}
