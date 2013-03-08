<?php

namespace Access\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory;
use Zend\Validator;
use Access\Form\Fieldset\Validator as MyValidators;
use Access\Utils;

/**
 * User
 *
 * @ORM\Table(name="account")
 * @ORM\Entity
 */
class User extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=50, nullable=false)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=20, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text")
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="string")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @param string $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
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
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param \DateTime $createAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getCreatedAtBR()
    {
        return Utils\Utils::DateToBr($this->createdAt);
    }

    public function getInputFilter()
    {
        $notEmpty = new Validator\NotEmpty();
        $notEmpty->setMessage(
            array(
                Validator\NotEmpty::IS_EMPTY => "Campo obrigatório.",
            )
        );

        $identical = new Validator\Identical('password');
        $identical->setMessages(
            array(
                Validator\Identical::NOT_SAME => "Campo senha e repetição de senha não coinscidem",
            )
        );

        $stringLength = new Validator\StringLength(array('min' => 8, 'max' => null));
        $stringLength->setMessage(
            array(
                Validator\StringLength::TOO_SHORT => "A senha possui menos de 8 caracteres"
            )
        );

        $emailAddress = new Validator\EmailAddress();
        $emailAddress->setMessage(
            array(
                Validator\EmailAddress::INVALID_FORMAT     => "E-mail com formato inválido."
            )
        );

        $fullNameValidator = new MyValidators\FullNameValidator();

        if (null === $this->inputFilter) {
            $factory = new Factory();

            $this->inputFilter = $factory->createInputFilter(
                array(
                    'fullname' => array(
                        'validators' => array(
                            $fullNameValidator,
                            $notEmpty
                        )
                    ),
                    'email' => array(
                        'validators' => array(
                            $emailAddress,
                            $notEmpty
                        )
                    ),
                    'password' => array(
                        'validators' => array(
                            $stringLength,
                            $notEmpty
                        )
                    ),
                    'repassword' => array(
                        'validators' => array(
                            $identical,
                            $notEmpty
                        )
                    )
                )
            );
        }

        return $this->inputFilter;
    }
}
