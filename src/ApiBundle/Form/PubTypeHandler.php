<?php

namespace ApiBundle\Form;

use ApiBundle\Exception\WrongDataException;
use ApiBundle\Model\PubFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PubTypeHandler
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var AbstractType
     */
    private $pubForm;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param FormFactoryInterface $formFactory
     * @param AbstractType         $pubForm
     * @param ValidatorInterface   $validator
     */
    public function __construct(FormFactoryInterface $formFactory, AbstractType $pubForm, ValidatorInterface $validator)
    {
        $this->formFactory = $formFactory;
        $this->pubForm = $pubForm;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function handleCreateRequest(Request $request)
    {
        $pubModel = new PubFormModel();

        return $this->handleForm($request, $pubModel);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function handleUpdateRequest(Request $request)
    {
        $pubModel = new PubFormModel();

        $pubModel->setDocumentId($request->get('id'));

        return $this->handleForm($request, $pubModel);
    }

    /**
     * @param Request      $request
     * @param PubFormModel $pubModel
     *
     * @return mixed
     *
     * @throws WrongDataException
     */
    private function handleForm(Request $request, PubFormModel $pubModel)
    {
        $form = $this->formFactory->create($this->pubForm, $pubModel);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);

        /** @var ConstraintViolationListInterface $errors */
        $errors = $this->validator->validate($pubModel);

        if (count($errors) == 0) {
            return $form->getData();
        }

        throw new WrongDataException('Improper data sent.');
    }
}
