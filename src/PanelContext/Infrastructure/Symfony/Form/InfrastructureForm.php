<?php

namespace Panel\Infrastructure\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class InfrastructureForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'Contenue',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'rows' => 15,
                    'style' => 'font-family: monospace;',
                ],
            ])
        ;
    }
}
