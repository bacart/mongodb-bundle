<?php

namespace Bacart\Bundle\MongoDBBundle\Request\ParamConverter;

use Bacart\Common\Util\ClassUtils;
use Bacart\SymfonyCommon\Interfaces\DocumentManagerAwareInterface;
use Bacart\SymfonyCommon\Traits\DocumentManagerAwareTrait;
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
