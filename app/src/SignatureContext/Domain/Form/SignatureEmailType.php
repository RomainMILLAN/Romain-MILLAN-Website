<?php

namespace Signature\Domain\Form;

use Signature\Domain\DTO\SignatureEmailDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignatureEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type d\'email',
                'required' => true,
                'data' => 'Email',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form--input',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'john.doe@yopmail.fr',
                ],
                'row_attr' => [
                    'class' => 'form--input',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignatureEmailDTO::class,
        ]);
    }
}
