<?php

namespace LBM\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LbmUserType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array( 'attr' => array('placeholder' => 'Nom d\'utilisateur')))
            ->add('password', PasswordType::class, array( 'attr' => array('placeholder' => 'Mot de passe')))
            ->add('salt', HiddenType::class, array('data' => '878787878'))

            ->add('save', SubmitType::class);
    }
}
