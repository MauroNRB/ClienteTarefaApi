<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ))
            ->add('email', EmailType::class, array(
                'label'  => 'E-mail',
                'required' => true,
            ))
            ->add('password', PasswordType::class, array(
                'label'  => 'Senha',
                'required' => true,
            ))
            ->add('phone', TextType::class, array(
                'label'  => 'Telefone',
                'required' => false,
            ))
            ->add('genre', ChoiceType::class, array(
                'label' => 'Gênero',
                'required' => false,
                'choices' => array(
                    'F' => 'Mulher',
                    'M' => 'Homem',
                    'O' => 'Outros'
                )
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
