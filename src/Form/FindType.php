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
                'label' => 'Пол',
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
                'attr' => [
                    'class' => 'gender'
                ],

            ])
            ->add('holiday', EntityType::class, [
                'label' => 'Событие/Праздник',
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
                'label' => 'Хобби/Увлечения',
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
            ->add('submit', SubmitType::class, [
                'label' => 'Искать!',
                'attr' => [
                    'class' => 'btn btn-success',
                ]
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
