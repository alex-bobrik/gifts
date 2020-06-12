<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\OrderKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'ФИО',
                'attr' => [
                    'class' => 'form-control',
                    'maxLength' => '250',
                ]
            ])
            ->add('phone_num', TextType::class, [
                'label' => 'Номер телефона',
                'attr' => [
                    'class' => 'form-control',
                    'maxLength' => '50',
                    'onkeypress' => 'return isNumberKey(event)',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'maxLength' => '250',
                ]
            ])
            ->add('is_delivery', ChoiceType::class, [
                'label' => 'Тип доставки',
                'choices' => [
                    'Доставка' => true,
                    'Самовывоз' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            // active if checkbox checked
            ->add('delivery_address', TextType::class, [
                'label' => 'Адрес доставки',
                'attr' => [
                    'class' => 'form-control',
                    'maxLength' => '250',
                ]
            ])
            ->add('order_kind', EntityType::class, [
                'label' => 'Вид оплаты',
                'class' => OrderKind::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Заказать!',
                'attr' => [
                    'class' => 'btn btn-success',
                ]
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
