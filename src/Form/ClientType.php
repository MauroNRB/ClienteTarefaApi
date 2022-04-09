<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-06
 */
class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label'  => 'Nome',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
            ->add('email', EmailType::class, array(
                'label'  => 'E-mail',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
            ->add('password', PasswordType::class, array(
                'label'  => 'Senha',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
            ->add('phone', TextType::class, array(
                'label'  => 'Telefone',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
            ->add('genre', ChoiceType::class, array(
                'label' => 'Gênero',
                'required' => false,
                'choices' => Client::getGenreChoices(),
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Salvar',
                'attr' => array(
                    'class' => 'btn btn-primary float-right',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
