<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\MapOption;
use App\Entity\Tag;
use App\Entity\TagKind;
use App\Form\Item\TagType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', EntityType::class, [
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->join('t.tagKind', 'tg', 'WITH', 't.tagKind = tg.id')

                        ->where('tg.name = ?1')
                        ->setParameter(1, 'gender');
                },
                'choice_label' => 'name',
                'mapped' => true,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('holiday', EntityType::class, [
                'class' => Tag::class,'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->join('t.tagKind', 'tg', 'WITH', 't.tagKind = tg.id')
                        ->where('tg.name = ?1')
                        ->setParameter(1, 'holiday');
                },
                'choice_label' => 'name',
                'mapped' => true,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('hobbies', EntityType::class, [
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->join('t.tagKind', 'tg', 'WITH', 't.tagKind = tg.id')

                        ->where('tg.name = ?1')
                        ->setParameter(1, 'hobbies');
                },
                'choice_label' => 'name',
                'mapped' => true,
                'multiple' => true,
                'expanded' => true,
            ])
//            ->add('tags', CollectionType::class, [
//                'entry_type' => TagKindType::class,
//                'entry_options' => ['label' => false],
//                'allow_add' => true,
//                'allow_delete' => true,
//                'prototype' => true,
//                'data_class' => null,
//                'by_reference' => false,
//                'required' => true,
//                'label' => false,
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Find',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//            'data_class' => TagKind::class,
        ]);
    }
}
