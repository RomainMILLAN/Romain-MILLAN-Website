<?php

namespace Panel\Infrastructure\Symfony\Form;

use Panel\Domain\Entity\ApplicationCategory;
use Panel\Domain\FormType\SwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationCategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('inAccordion', SwitchType::class, [
                'required' => false,
                'label' => 'Dans l\'accordéon',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplicationCategory::class,
        ]);
    }
}
