<?php

namespace Access\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allow
 *
 * @ORM\Table(name="grupo_transacao")
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
     * @ORM\SequenceGenerator(sequenceName="grupo_transacao_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var Role
     *
     * @ORM\OneToOne(targetEntity="Access\Entity\Role")
     * @ORM\JoinColumn(name="grupoid", referencedColumnName="id")
     */
    private $role;

    /**
     * @var Resource
     *
     * @ORM\OneToOne(targetEntity="Access\Entity\Resource")
     * @ORM\JoinColumn(name="transacaoid", referencedColumnName="id")
     */
    private $resource;

    /**
     * @var Privillege
     *
     * @ORM\OneToOne(targetEntity="Access\Entity\Privillege")
     * @ORM\JoinColumn(name="permissaoid", referencedColumnName="id")
     */
    private $privillege;

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
     * @param \Access\Entity\Privillege $privillege
     */
    public function setPrivillege($privillege)
    {
        $this->privillege = $privillege;
    }

    /**
     * @return \Access\Entity\Privillege
     */
    public function getPrivillege()
    {
        return $this->privillege;
    }

    /**
     * @param Resource $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
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
