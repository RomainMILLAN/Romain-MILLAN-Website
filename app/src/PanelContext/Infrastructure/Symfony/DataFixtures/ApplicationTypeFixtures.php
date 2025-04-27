<?php

namespace Panel\Infrastructure\Symfony\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Panel\Domain\Entity\ApplicationType;

class ApplicationTypeFixtures extends Fixture
{
    public const string LOCAL = 'application_type_local';

    public const string PROD01 = 'application_type_prod_01';

    public const string PROD02 = 'application_type_prod_02';

    public function load(ObjectManager $manager): void
    {
        $this->loadTypeInReference(
            name: 'LOCAL',
            color: '#FF2E00',
            reference: self::LOCAL,
            manager: $manager,
        );

        $this->loadTypeInReference(
            name: 'PROD01',
            color: '#00000',
            reference: self::PROD01,
            manager: $manager,
        );

        $this->loadTypeInReference(
            name: 'PROD02',
            color: '#00000',
            reference: self::PROD02,
            manager: $manager,
        );
    }

    public function loadTypeInReference(
        string $name,
        string $color,
        string $reference,
        ObjectManager $manager,
    ): void {
        $type = new ApplicationType();
        $type->name = $name;
        $type->color = $color;

        $manager->persist($type);
        $manager->flush();

        $this->addReference($reference, $type);
    }
}
