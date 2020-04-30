<?php


namespace App\Form;


use App\Entity\Etape;
use App\Entity\Voyage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays'
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('coordinates', CollectionType::class, [
                'entry_type' => TextType::class,
                'label' => false,
                'allow_add' => true,
                'prototype' => true,
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Départ'
            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'Fin'
            ])
            ->add('budget', IntegerType::class, [
                'label' => 'Budget(€)'
            ])
            ->add('voyageId',EntityType::class, [
                'label' => 'Voyage',
                'class' => 'App\Entity\Voyage',
                'choice_value' => function(Voyage $voyage = null) {
                    return $voyage ? $voyage->getName(): '';
                }

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Etape::class]);
    }

}