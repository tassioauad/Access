<?php

namespace Access\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 *
 * @ORM\Table(name="user_role")
 * @ORM\Entity
 */
class UserRole extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_role_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Role", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roleid", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="id")
     * })
     */
    private $user;

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
     * @param \Access\Entity\Role $roles
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

    /**
     * @param \Access\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \Access\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

}
