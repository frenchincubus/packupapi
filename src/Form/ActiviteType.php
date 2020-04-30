<?php


namespace App\Form;


use App\Entity\Activite;
use App\Entity\Etape;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
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
            ->add('typeTransport', TextType::class, [
                'label' => 'Transport'
            ])
            ->add('etapeId', EntityType::class, [
                'label' => 'Etape',
                'class' => 'App\Entity\Etape',
                'choice_value' => function (Etape $etape = null) {
                    return $etape ? $etape->getName() : '';
                }

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Activite::class]);
    }

}