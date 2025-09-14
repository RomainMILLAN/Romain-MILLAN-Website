<?php

namespace Panel\Infrastructure\Symfony\Repository\Custom;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class InfrastructureRepository
{
    public function __construct(
        private readonly Filesystem $filesystem,
        #[Autowire(env: 'resolve:INFRASTRUCTURE_PATH')]
        private readonly string $filePath,
    ) {
    }

    public function get(): string
    {
        if ($this->filesystem->exists($this->filePath) == false) {
            return '';
        }

        return $this->filesystem->readFile($this->filePath);
    }

    public function save(string $content): void
    {
        try {
            $this->filesystem->dumpFile($this->filePath, $content);
        } catch (IOExceptionInterface $exception) {
            throw new \RuntimeException('Could not write file: ' . $exception->getMessage());
        }
    }
}
