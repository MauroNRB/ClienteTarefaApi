<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-06
 */
class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, array(
                'label'  => 'Descrição',
                'required' => true,
            ))
            ->add('expirationAt', DateType::class, array(
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'label'  => 'Data de Expiração',
                'required' => true,
            ))
            ->add('conclusionAt', DateType::class, array(
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'label'  => 'Data de Conclusão',
                'required' => true,
            ))
            ->add('client', EntityType::class, array(
                'class' => Client::class,
                'query_builder' => function (EntityRepository $em) {
                    return $em->createQueryBuilder('o')
                        ->orderBy('o.name', 'ASC');
                },
                'choice_label' => function($client) {
                    return $client->getName();
                },
                'mapped' => false,
                'label' => 'Cliente',
                'required' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
