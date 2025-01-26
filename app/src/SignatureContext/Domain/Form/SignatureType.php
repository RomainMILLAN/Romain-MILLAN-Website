<?php

namespace Signature\Domain\Form;

use Signature\Domain\DTO\SignatureDTO;
use Arkounay\Bundle\UxCollectionBundle\Form\UxCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'John',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'NOM',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'DOE',
                ],
            ])
            ->add('status', TextType::class, [
                'label' => 'Statut',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Développeur',
                ],
            ])
            ->add('logo', ChoiceType::class, [
                'label' => 'Logo',
                'required' => true,
                'choices' => [
                    'Pas de logo' => null,
                    'RM' => 'build/signature/signature/logo/rm-text.svg',
                    'Romain - Photo n°1' => 'build/signature/signature/logo/1.jpg',
                    'Romain - Photo n°2' => 'build/signature/signature/logo/2.jpg',
                ],
                'empty_data' => null,
            ])
            ->add('accentColor', ColorType::class, [
                'label' => 'Couleur d\'accentuation',
                'required' => true,
                'data' => '#FDCA40',
            ])

            ->add('emails', UxCollectionType::class, [
                'entry_type' => SignatureEmailType::class,
                'label' => 'Vo・tre・s adresse(s) email',
                'allow_add' => true,
                'add_label' => 'Ajouter',
                'allow_delete' => true,
                'display_sort_buttons' => true,
                'allow_drag_and_drop' => true,
                'add_class' => 'btn btn-primary float-end',
                'min' => 1,
            ])

            ->add('phones', UxCollectionType::class, [
                'entry_type' => SignaturePhoneType::class,
                'label' => 'Vo・tre・s numéro(s) de téléphone(s)',
                'allow_add' => true,
                'add_label' => 'Ajouter',
                'allow_delete' => true,
                'display_sort_buttons' => true,
                'allow_drag_and_drop' => true,
                'add_class' => 'btn btn-primary float-end',
                'min' => 1,
            ])

            ->add('socialNetwork', SignatureSocialNetworkType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignatureDTO::class,
        ]);
    }
}
