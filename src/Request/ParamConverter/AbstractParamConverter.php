<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacart\Bundle\MongoDBBundle\Request\ParamConverter;

use Bacart\Common\Util\ClassUtils;
use Bacart\SymfonyCommon\Aware\Interfaces\DocumentManagerAwareInterface;
use Bacart\SymfonyCommon\Aware\Traits\DocumentManagerAwareTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractParamConverter implements ParamConverterInterface, DocumentManagerAwareInterface
{
    use DocumentManagerAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @throws NotFoundHttpException
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $class = $configuration->getClass();
        $meta = $this->documentManager->getClassMetadata($class);

        if (null === $id = $request->get($meta->identifier)) {
            return false;
        }

        $document = $this->documentManager->find($class, $id);

        if (null !== $document) {
            $request->attributes->set($configuration->getName(), $document);

            return true;
        }

        if ($configuration->isOptional()) {
            return false;
        }

        throw new NotFoundHttpException(sprintf(
            '%s not found by %s "%s"',
            ClassUtils::getClassShortName($class),
            $meta->identifier,
            $id
        ));
    }
}
