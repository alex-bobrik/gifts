<?php

namespace App\Form\Item;

use App\Entity\ItemTag;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag', EntityType::class, [
                'label' => 'Тег',
                'class' => Tag::class,
                'choice_label' => 'name',
                'mapped' => true,
                'multiple' => false,
                'attr' => ['class'=> 'form-control',]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ItemTag::class,
        ]);
    }
}
