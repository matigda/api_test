<?php

namespace ApiBundle\Form;

use ApiBundle\Transformer\PubModelToDocumentTransformer;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PubType extends AbstractType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('latitude', 'text');
        $builder->add('longitude', 'text')
                    ->addModelTransformer(new PubModelToDocumentTransformer($this->pubRepository));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ApiBundle\Model\PubFormModel',
            'csrf_protection' => false,
        ));
    }
}
