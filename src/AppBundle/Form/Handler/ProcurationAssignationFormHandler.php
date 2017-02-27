<?php

namespace AppBundle\Form\Handler;

use AppBundle\Entity\Procuration;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ProcurationAssignationFormHandler
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formClassName;

    /**
     * @var EntityManager
     */
    protected $doctrinEntityManager;

    /**
     * @param FormFactoryInterface $formFactory
     * @param string               $formClassName
     * @param EntityManager        $doctrinEntityManager
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        $formClassName,
        EntityManager $doctrinEntityManager
    ) {
        $this->formFactory = $formFactory;
        $this->formClassName = $formClassName;
        $this->doctrinEntityManager = $doctrinEntityManager;
    }

    /**
     * @param Procuration $procuration
     *
     * @return FormInterface
     */
    public function createForm(Procuration $procuration)
    {
        return $this->formFactory->create($this->formClassName, $procuration);
    }

    /**
     * @param Procuration $procuration
     *
     * @return \Symfony\Component\Form\FormView
     */
    public function createFormView(Procuration $procuration)
    {
        return $this->createForm($procuration)
            ->createView();
    }

    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    public function process(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }

        $this->doctrinEntityManager->persist($form->getData());
        $this->doctrinEntityManager->flush();

        return true;
    }
}