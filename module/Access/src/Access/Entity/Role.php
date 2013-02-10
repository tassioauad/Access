<?php

namespace Access\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
use Zend\Permissions\Acl\Role\GenericRole;

/**
 * Role
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity
 */
class Role extends GenericRole implements InterfaceEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="grupo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=10, nullable=false)
     */
    protected $roleId;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
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
     * @param string $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }
}
