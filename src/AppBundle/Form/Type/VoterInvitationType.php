<?php

namespace AppBundle\Form\Type;

use AppBundle\Mediator\UserMediator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoterInvitationType extends AbstractType
{
    /**
     * @var string
     */
    protected $objectDataClass;

    /**
     * @param string $objectDataClass
     */
    public function __construct($objectDataClass)
    {
        $this->objectDataClass = $objectDataClass;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('civility', ChoiceType::class, [
                'choices' => array_flip(UserMediator::getCivilities()),
                'label' => 'Civilité',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->objectDataClass,
            'translation_domain' => false,
        ]);
    }
}
