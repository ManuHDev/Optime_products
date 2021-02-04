<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, array('label'=> 'Code','required' =>true))
            ->add('name', TextType::class, array('label'=> 'Name','required' =>true))
            ->add('description', TextareaType::class, array('label'=> 'Description','required' =>true))
            ->add('brand', TextType::class, array('label'=> 'Brand','required' =>true))
            ->add('category', EntityType::class, array(
                'class' => 'App:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = :active')
                        ->orderBy('u.name', 'ASC')
                        ->setParameter('active', 1);
                },
                'choice_label' => 'name'
            ))
            ->add('price', TextType::class, array('label'=> 'Price','required' =>true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
