<?php

namespace Panel\Infrastructure\Symfony\Form;

use Panel\Domain\Entity\Application;
use Panel\Domain\Entity\InfrastructureService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfrastructureServiceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('ipAddress', TextType::class, [
                'required' => true,
                'label' => 'Adresse IP',
            ])
            ->add('applications', EntityType::class, [
                'label' => 'Application(s)',
                'class' => Application::class,
                'choice_label' => 'name',
                'required' => false,
                'autocomplete' => true,
                'multiple' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfrastructureService::class,
        ]);
    }
}
