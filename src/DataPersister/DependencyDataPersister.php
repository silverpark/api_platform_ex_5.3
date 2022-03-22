<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;

class DependencyDataPersister implements ContextAwareDataPersisterInterface
{
    protected DependencyRepository $dependencyRepository;

    public function __construct(DependencyRepository $dependencyRepository)
    {
        $this->dependencyRepository = $dependencyRepository;
    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Dependency;
    }

    public function persist($data, array $context = [])
    {
        // The setter of version is mandotary in the case of persist data in PUT
        $this->dependencyRepository->saveDependency($data);
    }

    public function remove($data, array $context = [])
    {
        $this->dependencyRepository->removeDependency($data);
    }
}
