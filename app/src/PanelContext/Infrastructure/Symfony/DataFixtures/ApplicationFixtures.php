<?php

namespace Panel\Infrastructure\Symfony\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Panel\Domain\Entity\Application;
use Panel\Domain\Entity\ApplicationCategory;
use Panel\Domain\Entity\ApplicationType;

class ApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public const string ONE = 'application_one';
    public const string TWO = 'application_two';

    public function load(ObjectManager $manager): void
    {
        $this->loadInReference(
            name: 'Un',
            description: 'Description une',
            url: 'https://google.com/',
            icon: 'uptime-kuma',
            hasInterface: true,
            category: $this->getReference(ApplicationCategoryFixtures::SELF_HOSTED, ApplicationCategory::class),
            types: [$this->getReference(ApplicationTypeFixtures::LOCAL, ApplicationType::class)],
            reference: self::ONE,
            manager: $manager,
        );

        $this->loadInReference(
            name: 'Deu',
            description: 'Description deux',
            url: 'https://google.fr/',
            icon: 'zoraxy',
            hasInterface: false,
            category: $this->getReference(ApplicationCategoryFixtures::CLIENT_ONE, ApplicationCategory::class),
            types: [$this->getReference(ApplicationTypeFixtures::PROD02, ApplicationType::class)],
            reference: self::TWO,
            manager: $manager,
        );
    }

    public function getDependencies(): array
    {
        return [
            ApplicationTypeFixtures::class,
            ApplicationCategoryFixtures::class,
        ];
    }

    /**
     * @param array<ApplicationType> $types
     */
    public function loadInReference(
        string $name,
        string $description,
        string $url,
        string $icon,
        bool $hasInterface,
        ApplicationCategory $category,
        array $types = [],
        string $reference,
        ObjectManager $manager,
    ): void {
        $application = new Application();
        $application->name = $name;
        $application->description = $description;
        $application->url = $url;
        $application->icon = $icon;
        $application->hasInterface = $hasInterface;
        $application->category = $category;

        // foreach ($types as $type) {
        //     $application->addType($type);
        // }

        $manager->persist($application);
        $manager->flush();

        $this->addReference($reference, $application);
    }
}
