<?php

namespace Panel\Infrastructure\Symfony\Form\Signature;

use Panel\Domain\DTO\Signature\SignatureSocialNetworkDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SignatureSocialNetworkForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('discord', TextType::class, [
                'label' => 'Discord',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => '**********',
                ],
            ])
            ->add('instagram', TextType::class, [
                'label' => 'Instagram',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'millan_romain',
                ],
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'LinkedIn',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'romain-millan',
                ],
            ])
            ->add('github', TextType::class, [
                'label' => 'GitHub',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'RomainMILLAN',
                ],
            ])
            ->add('website', TextType::class, [
                'label' => 'Site web',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'romainmillan.fr',
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
