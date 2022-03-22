<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Ramsey\Uuid\Uuid as UuidUuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={"GET","POST"},
 *  itemOperations={"GET","PUT"={"denormalization_context"={"groups"={"dependency_put_write"}}},"DELETE"},
 *  paginationEnabled=false
 * )
 */
class Dependency
{
    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    protected string $uuid;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @var string
     */
    protected string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @Groups({"dependency_put_write"})
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

    /**
     * Set the value of version
     * This setter is mandotary in the case of persist data in PUT
     *
     * @param  string  $version
     *
     * @return  self
     */ 
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}
