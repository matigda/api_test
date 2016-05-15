<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Pub;
use ApiBundle\Form\PubTypeHandler;
use ApiBundle\Provider\PubProvider;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class PubController
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var PubProvider
     */
    private $pubProvider;

    /**
     * @var PubTypeHandler
     */
    private $pubFormHandler;

    /**
     * @param PubProvider $pubProvider
     * @param ObjectManager $objectManager
     * @param PubTypeHandler $pubFormHandler
     */
    public function __construct(PubProvider $pubProvider, ObjectManager $objectManager, PubTypeHandler $pubFormHandler)
    {
        $this->objectManager = $objectManager;
        $this->pubProvider = $pubProvider;
        $this->pubFormHandler = $pubFormHandler;
    }

    /**
     * @Rest\View(serializerGroups={"list"})
     * @ApiDoc()
     * @param Request $request
     *
     * @return array
     */
    public function listAction(Request $request)
    {
        $pubs = $this->pubProvider->getPubs($request);

        return $pubs;
    }

    /**
     * @Rest\View(serializerGroups={"item"})
     * @ApiDoc()
     * @param string $id
     *
     * @return Pub
     */
    public function itemAction($id)
    {
        return $this->pubProvider->getPub($id);
    }

    /**
     * @Rest\View(serializerGroups={"item"})
     * @ApiDoc()
     * @param Request $request
     *
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $pub = $this->pubFormHandler->handleCreateRequest($request);

        $this->objectManager->persist($pub);

        $this->objectManager->flush();

        return $pub;
    }

    /**
     * @Rest\View(serializerGroups={"item"})
     * @ApiDoc()
     * @param Request $request
     *
     * @return mixed
     */
    public function updateAction(Request $request)
    {
        $pub = $this->pubFormHandler->handleUpdateRequest($request);

        $this->objectManager->flush($pub);

        return $pub;
    }

    /**
     * @ApiDoc()
     * @param string $id
     *
     * @return array
     */
    public function deleteAction($id)
    {
        $pub = $this->pubProvider->getPub($id, true);

        $this->objectManager->remove($pub);

        $this->objectManager->flush();

        return ['message' => sprintf('Item with id %s deleted', $id)];
    }
}
