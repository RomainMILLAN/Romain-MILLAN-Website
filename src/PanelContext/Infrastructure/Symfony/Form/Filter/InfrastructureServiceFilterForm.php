<?php

namespace Panel\Infrastructure\Symfony\Form\Filter;

use Spiriit\Bundle\FormFilterBundle\Filter\Doctrine\ORMQuery;
use Spiriit\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InfrastructureServiceFilterForm extends AbstractType
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
                    $appAlias = 'app_filter';

                    $qb = $query->getQueryBuilder();
                    $qb->leftJoin($alias . '.applications', $appAlias);

                    $expr = $query->getExpr();
                    $condition = $expr->orX(
                        $expr->like($alias . '.name', $expr->literal($value)),
                        $expr->like($alias . '.ipAddress', $expr->literal($value)),
                        $expr->like($appAlias . '.name', $expr->literal($value)),
                        $expr->like($appAlias . '.description', $expr->literal($value)),
                    );

                    $qb->distinct();

                    return $query->createCondition((string) $condition);
                },
            ])
        ;
    }
}
