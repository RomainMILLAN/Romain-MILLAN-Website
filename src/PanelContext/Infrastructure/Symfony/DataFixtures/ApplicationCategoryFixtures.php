<?php

namespace Panel\Infrastructure\Symfony\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Panel\Domain\Entity\ApplicationCategory;

class ApplicationCategoryFixtures extends Fixture
{
    public const string SELF_HOSTED = 'application_category_self_hosted';

    public const string CLIENT_ONE = 'application_category_client_one';

    public function load(ObjectManager $manager): void
    {
        $this->loadCategoryInReference(
            name: 'Self Host',
            inAccordion: false,
            orderNumber: -1,
            reference: self::SELF_HOSTED,
            manager: $manager,
        );

        $this->loadCategoryInReference(
            name: 'Client 1',
            inAccordion: true,
            orderNumber: 1,
            reference: self::CLIENT_ONE,
            manager: $manager,
        );
    }

    public function loadCategoryInReference(
        string $name,
        bool $inAccordion,
        int $orderNumber,
        string $reference,
        ObjectManager $manager,
    ): void {
        $category = new ApplicationCategory();
        $category->name = $name;
        $category->inAccordion = $inAccordion;
        $category->orderNumber = $orderNumber;

        $manager->persist($category);
        $manager->flush();

        $this->addReference($reference, $category);
    }
}
