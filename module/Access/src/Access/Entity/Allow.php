<?php

namespace Access\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allow
 *
 * @ORM\Table(name="allow")
 * @ORM\Entity
 */
class Allow extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="allow_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var Role
     *
     * @ORM\OneToOne(targetEntity="Access\Entity\Role")
     * @ORM\JoinColumn(name="roleid", referencedColumnName="id")
     */
    private $role;

    /**
     * @var ResourcePrivillege
     *
     * @ORM\OneToOne(targetEntity="Access\Entity\ResourcePrivillege")
     * @ORM\JoinColumn(name="controller_actionid", referencedColumnName="id")
     */
    private $resource_privilege;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param ResourcePrivillege $resource_privilege
     */
    public function setResourcePrivilege($resource_privilege)
    {
        $this->resource_privilege = $resource_privilege;
    }

    /**
     * @return ResourcePrivillege
     */
    public function getResourcePrivilege()
    {
        return $this->resource_privilege;
    }

    /**
     * @param \Access\Entity\Role $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return \Access\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

}
