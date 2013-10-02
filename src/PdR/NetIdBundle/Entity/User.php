<?php

namespace PdR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message = "user.name.not_blank")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message = "user.lastname.not_blank")
     */
    protected $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="user.birthdate.invalid")
     */
    protected $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="LegalId", inversedBy="users")
     * @ORM\JoinColumn(name="legal_id_type", nullable=true)
     * @Assert\NotNull
     */
    protected $legalIdType;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $staff = false;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set legalId
     *
     * @param integer $legalId
     * @return User
     */
    public function setLegalId($legalId)
    {
        $this->legalId = $legalId;
    
        return $this;
    }

    /**
     * Get legalId
     *
     * @return integer
     */
    public function getLegalId()
    {
        return $this->legalId;
    }

    /**
     * Set legalIdType
     *
     * @param integer $legalIdType
     * @return User
     */
    public function setLegalIdType($legalIdType)
    {
        $this->legalIdType = $legalIdType;
    
        return $this;
    }

    /**
     * Get legalIdType
     *
     * @return LegalIdType
     */
    public function getLegalIdType()
    {
        return $this->legalIdType;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set staff
     *
     * @param boolean $staff
     * @return User
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    
        return $this;
    }

    /**
     * Get staff
     *
     * @return boolean 
     */
    public function getStaff()
    {
        return $this->staff;
    }

    public function getRoles()
    {
        $roles = parent::getRoles();
        if ($this->staff)
        {
            $roles[] = 'ROLE_ADMIN';
        }
        return $roles;
    }
}