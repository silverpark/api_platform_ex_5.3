<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Ramsey\Uuid\Uuid as UuidUuid;

/**
 * @ApiResource(
 *  collectionOperations={"GET"},
 *  itemOperations={"GET"},
 *  paginationEnabled=false
 * )
 */
class Dependency
{
    /**
     * @ApiProperty(identifier=true)
     *
     * @var string
     */
    protected string $uuid;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $version;

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct(string $name, string $version)
    {
        $this->uuid = UuidUuid::uuid5(UuidUuid::NAMESPACE_URL, $name)->toString();
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Get the value of uuid
     *
     * @return  string
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of version
     *
     * @return  string
     */ 
    public function getVersion()
    {
        return $this->version;
    }
}
