<?php

namespace App\SignatureContext\Domain\Form;

use App\SignatureContext\Domain\DTO\SignatureSocialNetworkDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SignatureSocialNetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('discord', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => '**********',
                    'class' => 'form-control',
                    'aria-label' => '**********',
                ],
            ])
            ->add('instagram', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'millan_romain',
                    'class' => 'form-control',
                    'aria-label' => 'millan_romain',
                ],
            ])
            ->add('linkedin', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'romain-millan',
                    'class' => 'form-control',
                    'aria-label' => 'romain-millan',
                ],
            ])
            ->add('github', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'RomainMILLAN',
                    'class' => 'form-control',
                    'aria-label' => 'RomainMILLAN',
                ],
            ])
            ->add('website', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'romainmillan.fr',
                    'class' => 'form-control',
                    'aria-label' => 'romainmillan.fr',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignatureSocialNetworkDTO::class,
        ]);
    }
}
