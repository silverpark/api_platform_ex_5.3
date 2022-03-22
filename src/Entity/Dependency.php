<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 *  collectionOperations={"GET","POST"},
 *  itemOperations={"GET","PUT","DELETE"}
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
     * @ApiProperty(identifier=true)
     *
     * @var string
     */
    protected string $name;

    /**
     * @ApiProperty(identifier=true)
     *
     * @var string
     */
    protected string $version;

    /**
     * @param string $uuid
     * @param string $name
     * @param string $version
     */
    public function __construct(string $uuid, string $name, string $version)
    {
        $this->uuid = $uuid;
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
