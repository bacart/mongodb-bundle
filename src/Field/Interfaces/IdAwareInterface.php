<?php

namespace Bacart\Bundle\MongoDBBundle\Field\Interfaces;

interface IdAwareInterface
{
    public const STRING_ID_REGEX = '/^[a-z0-9-_.,:;!? ]+$/i';

    /**
     * @return mixed
     */
    public function getId();
}
