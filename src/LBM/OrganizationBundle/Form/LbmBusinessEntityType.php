<?php

namespace LBM\OrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LbmBusinessEntityType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('updatedBy', HiddenType::class, array(
                'data' => 4,
            ))
            ->add('createdBy', HiddenType::class, array(
                'data' => 4,
            ))
            ->add('name', TextType::class, array( 'attr' => array('placeholder' => 'Nom de l\'entité'), 'label' => 'Nom de l\'entité'))
            ->add('description', TextareaType::class, array( 'attr' => array('placeholder' => 'Description')))
            ->add('company', EntityType::class,
                array( 'class' => 'LBMOrganizationBundle:LbmCompany',
                    'choice_label' => 'tradeName',
                    'label' => 'Société'))
            ->add('Sauvegarder', SubmitType::class, array( 'attr' => array ('class' => 'btn btn-greensea btn-border btn-rounded-20 mb-10')));
    }
}
