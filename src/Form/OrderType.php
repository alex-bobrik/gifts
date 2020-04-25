<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\OrderKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('order_date')
//            ->add('item')
            ->add('fullName', TextType::class, [
                'label' => 'FIO',
            ])
            ->add('phone_num', TextType::class, [
                'label' => 'Phone',
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
            ])
            ->add('is_delivery', ChoiceType::class, [
                'choices' => [
                    'Доставка' => true,
                    'Самовывоз' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('delivery_address', TextType::class, [
                // active if checkbox checked
            ])
            ->add('order_kind', EntityType::class, [
                'class' => OrderKind::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Orders this!',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
