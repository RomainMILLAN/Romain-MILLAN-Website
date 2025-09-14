<?php

namespace Panel\Infrastructure\Symfony\Form\Filter;

use Spiriit\Bundle\FormFilterBundle\Filter\Doctrine\ORMQuery;
use Spiriit\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ApplicationFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextFilterType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher ...',
                ],
                'apply_filter' => function (ORMQuery $query, string $field, array $values) {
                    if (empty($values['value'])) {
                        return null;
                    }

                    $value = \sprintf('%%%s%%', $values['value']);
                    $alias = $query->getRootAlias();

                    $expr = $query->getExpr();
                    $condition = $expr->orX(
                        $expr->like($alias . '.name', $expr->literal($value)),
                        $expr->like($alias . '.description', $expr->literal($value)),
                        $expr->like($alias . '.icon', $expr->literal($value)),
                    );

                    return $query->createCondition((string) $condition);
                },
            ])
        ;
    }
}
