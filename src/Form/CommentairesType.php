<?php

namespace App\Form;

use App\Entity\Commentaires;
use App\Entity\User;
use App\Entity\Voyage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => 'Commentaire'
            ])
            ->add('datePublication', DateTimeType::class, [
                'label' => 'Date de publication'
            ])
            ->add('userId',EntityType::class, [
                'label' => 'Utilisateur',
                'class' => 'App\Entity\User',
                'choice_value' => function(User $user = null) {
                    return $user ? $user->getUsername(): '';
                }

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
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
