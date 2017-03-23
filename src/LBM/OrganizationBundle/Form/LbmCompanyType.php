<?php

namespace LBM\OrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LbmCompanyType extends AbstractType
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
            ->add('corporateName', TextType::class, array( 'attr' => array('placeholder' => 'Nom officiel'), 'label' => 'Dénomination Sociale'))
            ->add('tradeName', TextType::class, array( 'attr' => array('placeholder' => 'Nom usuel'), 'label' => 'Nom commercial'))
            ->add('description', TextareaType::class, array( 'attr' => array('placeholder' => 'Description')))
            ->add('siren', TextType::class, array( 'attr' => array('placeholder' => 'Siren')))
            ->add('siret', TextType::class, array( 'attr' => array('placeholder' => 'Siret')))
            ->add('tvaIntra', TextType::class, array( 'attr' => array('placeholder' => 'N° TVA intracommunautaire'), 'label' => 'N° TVA intracommunautaire'))
            ->add('immatriculationRcsDate', DateType::class, array(
                                                                        'label' => 'Date d\'immatriculation au RCS',
                                                                        'widget' => 'single_text',
                                                                        'attr' => ['class' => 'form-control'],
                                                                    )
            )
            ->add('legalCategory', EntityType::class,
                                                        array( 'class' => 'LBMOrganizationBundle:LbmLegalCategory',
                                                               'choice_label' => 'codeAndLabel',
                                                               'label' => 'Catégorie légale',
                                                               'attr' => ['class' => 'chosen-select', 'style' => 'width: 90%']
                                                             )
                )
            ->add('apeCode', EntityType::class, array(
                                                        'class' => 'LBMOrganizationBundle:LbmApeCode',
                                                        'choice_label' => 'codeAndLabel',
                                                        'label' => 'Code APE/NAF',
                                                        'attr' => ['class' => 'chosen-select', 'style' => 'width: 90%']
                                                        )
            )
            ->add('Sauvegarder', SubmitType::class, array( 'attr' => array ('class' => 'btn btn-greensea btn-border btn-rounded-20 mb-10')));
    }
}
