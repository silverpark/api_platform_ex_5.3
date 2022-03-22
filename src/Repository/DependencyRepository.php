<?php

namespace App\Repository;

use App\Entity\Dependency;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid as UuidUuid;

class DependencyRepository
{
    /**
     * @var string
     */
    protected string $rootPath;

    /**
     * @param string $rootPath
     */
    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }

    public function getDependencies(): ArrayCollection
    {
        $contentDecoded = $this->getContentDependencies();
        $collection = new ArrayCollection();

        foreach ($contentDecoded['require'] as $name => $version) {
            $collection->add(new Dependency($name, $version));
        }

        return $collection;
    }

    public function getDependency(string $uuid): ?Dependency
    {
        $contentDecoded = $this->getContentDependencies();

        foreach ($contentDecoded['require'] as $name => $version) {

            $uuid5 = UuidUuid::uuid5(UuidUuid::NAMESPACE_URL, $name)->toString();

            if ($uuid === $uuid5) {
                return new Dependency($name, $version);
            }
        }

        return null;
    }

    private function getContentDependencies(): array
    {
        $path = $this->rootPath . '/composer.json';
        $content = file_get_contents($path);
        $contentDecoded = json_decode($content, true);

        return $contentDecoded;
    }
}
