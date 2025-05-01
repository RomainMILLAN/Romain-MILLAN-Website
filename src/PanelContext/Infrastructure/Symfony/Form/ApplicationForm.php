<?php

namespace Panel\Infrastructure\Symfony\Form;

use Panel\Domain\Entity\Application;
use Panel\Domain\Entity\ApplicationCategory;
use Panel\Domain\Entity\ApplicationType;
use Panel\Domain\FormType\SwitchType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'label' => 'Description',
            ])
            ->add('url', TextType::class, [
                'required' => true,
                'label' => 'URL',
            ])
            ->add('icon', TextType::class, [
                'required' => true,
                'label' => 'Icone',
            ])
            ->add('hasInterface', SwitchType::class, [
                'label' => 'À une interface',
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégorie(s)',
                'class' => ApplicationCategory::class,
                'choice_label' => 'name',
                'required' => true,
                'autocomplete' => true,
                'multiple' => true,
                'attr' => [
                    'data-controller' => 'form-control select2',
                ],
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type(s)',
                'class' => ApplicationType::class,
                'choice_label' => 'name',
                'required' => true,
                'autocomplete' => true,
                'multiple' => true,
                'attr' => [
                    'data-controller' => 'form-control select2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
