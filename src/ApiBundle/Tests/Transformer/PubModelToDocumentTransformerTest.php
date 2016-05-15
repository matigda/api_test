<?php

namespace ApiBundle\Tests\Transformer;

use ApiBundle\Document\Localization;
use ApiBundle\Document\Pub;
use ApiBundle\Model\PubFormModel;
use ApiBundle\Tests\AbstractFunctionalTest;
use ApiBundle\Transformer\PubModelToDocumentTransformer;

class PubModelToDocumentTransformerTest extends AbstractFunctionalTest
{
    /**
     * @var PubModelToDocumentTransformer
     */
    private $transformer;

    public function setUp()
    {
        parent::setUp();
        $this->transformer = new PubModelToDocumentTransformer($this->documentManager->getRepository(Pub::class));
    }

    public function testTransform()
    {
        $model = new PubFormModel();
        $result = $this->transformer->transform($model);

        $this->assertSame($model, $result);
    }

    public function testReverseTransform()
    {
        // given
        $document = $this->createDocument();
        $model = $this->createModel($document);
        $localization = $document->getLocalization();

        // when
        $result = $this->transformer->reverseTransform($model);

        // then
        $this->assertSame($document->getId(), $result->getId());
        $this->assertSame($model->getName(), $result->getName());
        $this->assertSame($localization->getCoordinates(), $result->getLocalization()->getCoordinates());
    }

    /**
     * @return Pub
     */
    private function createDocument()
    {
        $document = new Pub();
        $document->setName('some pub name');

        $localization = new Localization([2, 3]);
        $document->setLocalization($localization);
        $this->documentManager->persist($document);
        $this->documentManager->flush();

        return $document;
    }

    /**
     * @param Pub $document
     *
     * @return PubFormModel
     */
    private function createModel(Pub $document)
    {
        $model = new PubFormModel();
        $model->setName('changed pub name');
        $model->setDocumentId($document->getId());
        $model->setLatitude(2);
        $model->setLongitude(3);

        return $model;
    }
}
