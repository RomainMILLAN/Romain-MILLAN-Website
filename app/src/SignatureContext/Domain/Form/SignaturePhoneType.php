<?php

namespace Signature\Domain\Form;

use Signature\Domain\DTO\SignaturePhoneDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignaturePhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TelType::class, [
                'label' => 'Type de numéro de téléphone',
                'required' => true,
                'data' => 'Mobile',
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
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10,
                        'max' => 16,
                    ]),
                ],
                'attr' => [
                    'placeholder' => '+336.00.00.00.00',
                    'class' => 'form-control',
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
            'data_class' => SignaturePhoneDTO::class,
        ]);
    }
}
