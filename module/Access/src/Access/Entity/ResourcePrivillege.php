<?php

namespace Access\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
use Zend\Permissions\Acl\Resource\GenericResource;

/**
 * Resource
 *
 * @ORM\Table(name="controller_action")
 * @ORM\Entity
 */
class ResourcePrivillege extends GenericResource implements InterfaceEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="controller_action_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=255, nullable=false)
     */
    protected $resource;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=false)
     */
    protected $privillege;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    function __construct(array $data = null)
    {
        if($data != null) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data)
    {
        $hydrator = new Hydrator\ClassMethods(true);
        $hydrator->hydrate($data, $this);
    }

    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods(true);

        return $hydrator->extract($this);
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $privillege
     */
    public function setPrivillege($privillege)
    {
        $this->privillege = $privillege;
    }

    /**
     * @return string
     */
    public function getPrivillege()
    {
        return $this->privillege;
    }

    /**
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }
 }
