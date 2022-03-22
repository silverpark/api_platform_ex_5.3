<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{
    /**
     * @var DependencyRepository
     */
    protected DependencyRepository $dependencyRepository;

    /**
     * @param string $rootPath
     */
    public function __construct(DependencyRepository $dependencyRepository)
    {
        $this->dependencyRepository = $dependencyRepository;
    }
    
    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {
        return $this->dependencyRepository->getDependencies();
    }

    public function getItem(string $resourceClass, $id, ?string $operationName = null, array $context = [])
    {
        return $this->dependencyRepository->getDependency($id);
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Dependency::class;
    }
}
