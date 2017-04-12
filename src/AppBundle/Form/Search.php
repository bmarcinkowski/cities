<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Search extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('n', SearchType::class, ['label' => 'nazwa dzielnicy: '])
            ->add('c', HiddenType::class)
            ->add('search', SubmitType::class, array('label' => 'Szukaj'));
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
