<?php

namespace ApiBundle\Transformer;

use ApiBundle\Document\Localization;
use ApiBundle\Document\Pub;
use ApiBundle\Model\PubFormModel;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\DataTransformerInterface;

class PubModelToDocumentTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectRepository
     */
    private $pubRepository;

    /**
     * @param ObjectRepository $pubRepository
     */
    public function __construct(ObjectRepository $pubRepository)
    {
        $this->pubRepository = $pubRepository;
    }

    /**
     * @param PubFormModel $pubFormModel
     *
     * @return PubFormModel
     */
    public function transform($pubFormModel)
    {
        return $pubFormModel;
    }

    /**
     * @param PubFormModel $pubFormModel
     *
     * @return Pub
     */
    public function reverseTransform($pubFormModel)
    {
        return $this->getDocumentBasedOnModel($pubFormModel);
    }

    /**
     * @param PubFormModel $pubFormModel
     *
     * @return Pub
     */
    private function getDocumentBasedOnModel(PubFormModel $pubFormModel)
    {
        $localization = new Localization([$pubFormModel->getLatitude(), $pubFormModel->getLongitude()]);

        $pub = $pubFormModel->getDocumentId() ? $this->pubRepository->find($pubFormModel->getDocumentId()) : new Pub();

        return $pub->setLocalization($localization)->setName($pubFormModel->getName());
    }
}
