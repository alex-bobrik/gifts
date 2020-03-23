<?php

namespace App\Form\Item;

use App\Entity\Tag;
use App\Entity\TagKind;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('tagKind', EntityType::class, [
                'class' => TagKind::class,
                'choice_label' => function($tagKind) {
                    switch ($tagKind->getName()){
                        case 'gender': return 'Пол';
                        case 'holiday': return 'Событие/Праздник';
                        case 'hobbies': return 'Хобби/Увлечения';
                        default: return 'error';
                    }
                },
//                'choice_label' => 'name',
                'mapped' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
