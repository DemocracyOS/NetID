<?php

namespace DeR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\MaxDepth;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Identity
 *
 * @ORM\Entity(repositoryClass="DeR\NetIdBundle\Repository\IdentityRepository")
 * @ORM\Table(name="identity")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @Assert\Callback(methods={"isClientsValid", "isLegalIdValid"})
 * @UniqueEntity(fields="email", message="identity.email.duplicated")
 * @UniqueEntity(fields="username", message="identity.username.duplicated")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(
 *               nullable   = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(
 *               nullable   = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *               nullable   = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *               nullable   = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *               nullable   = true
 *          )
 *      )
 * })
 */
class Identity extends BaseUser
{
    public function __toString()
    {
        if (isset($this->username) && $this->username != '')
        {
            return $this->username;
        } else {
            return $this->getFullname();
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->clients = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
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
     * @Assert\NotBlank(message = "identity.name.not_blank")
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message = "identity.lastname.not_blank")
     * @Expose
     */
    protected $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="identity.birthdate.invalid")
     * @Expose
     * @Type("DateTime<'Y-m-d'>")
     */
    protected $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="LegalId", inversedBy="users")
     * @ORM\JoinColumn(name="legal_id_type", nullable=true)
     * @Expose
     * @MaxDepth(1)
     * @Type("string")
     */
    protected $legalIdType;

    /**
     * @ORM\Column(name="legal_id", nullable=true)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="identity.legal_id.invalid"
     * )
     */
    protected $legalId;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="identities")
     * @ORM\JoinColumn(name="district_id")
     * @Expose
     * @Type("string")
     */
    protected $district;

    /**
     * @ORM\OneToMany(targetEntity="IdentitiesClients", mappedBy="identity", cascade="all", orphanRemoval=true)
     * @Expose
     */
    protected $clients;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     */
    protected $userRoles;

    /**
     * @var suspicious
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $suspicious = false;

    /**
     * @var deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

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
     * @return Identity
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
     * @return Identity
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
     * @return Identity
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
     * @return Identity
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
     * @return Identity
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
     * @return Identity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set district
     *
     * @param \DeR\NetIdBundle\Entity\District $district
     * @return Identity
     */
    public function setDistrict(\DeR\NetIdBundle\Entity\District $district = null)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return \DeR\NetIdBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    
    /**
     * Add client
     *
     * @param \DeR\NetIdBundle\Entity\IdentitiesClients $client
     * @return Client
     */
    public function addClient(\DeR\NetIdBundle\Entity\IdentitiesClients $client)
    {
        $this->clients[] = $client;
    
        return $this;
    }

    /**
     * Remove client
     *
     * @param \DeR\NetIdBundle\Entity\IdentityClients $client
     */
    public function removeClient(\DeR\NetIdBundle\Entity\IdentitiesClients $client)
    {
        $this->clients->removeElement($client);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Add role
     *
     * @param \DeR\NetIdBundle\Entity\Role $role
     * @return Role
     */
    public function addRole($role)
    {
        $this->userRoles[] = $role;
    
        return $this;
    }

    /**
     * Remove Role
     *
     * @param \DeR\NetIdBundle\Entity\Role $roles
     */
    public function removeRole($role)
    {
        $this->userRoles->removeElement($role);
    }

    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Get roles
     */
    public function getRoles()
    {
        $roles = array();
        foreach ($this->userRoles as $role) {
            $roles[] = $role->getName();
            $roles = array_merge($roles, $role->getActionNames());
        }
        return $roles;
    }

    /**
     * Is suspicious
     *
     * @return boolean 
     */
    public function isSuspicious()
    {
        return $this->suspicious;
    }

    /**
     * Set suspicious
     *
     * @param boolean $suspicious
     * @return Identity
     */
    public function setSuspicious($suspicious = true)
    {
        $this->suspicious = $suspicious;
    
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Identity
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    
        return $this;
    }

    public function clearClients()
    {
        $this->clients = new ArrayCollection();
    }

    public function isClientsValid(ExecutionContextInterface $context)
    {
        $clients = array();
        $i = 0;
        $error = false;
        foreach ($this->clients as $client) {
            if (!in_array($client->getClient(), $clients))
            {
                $clients[] = $client->getClient();
            } else {
                $error = true;
                $context->addViolationAt("clients[$i].client", 'identity.client.duplicated', array(), null);
                $j = array_search($client->getClient(), $clients);
                $context->addViolationAt("clients[$j].client", 'identity.client.duplicated', array(), null);
            }
            $i++;
        }
        if ($error)
        {
            $context->addViolationAt("clients", 'identity.client.duplicated', array(), null);
        }
    }

    public function isLegalIdValid(ExecutionContextInterface $context)
    {
        if (isset($this->legalIdType) && !isset($this->legalId))
        {
            $context->addViolationAt('legalId', 'identity.legalId.not.set', array(), null);
        }
    }

    public function setEmail($email)
    {
        $this->username = $email;
        parent::setEmail($email);
    }

    protected function hasLegalId()
    {
        return isset($this->legalId);
    }

    public function isAllowed($verb)
    {
        return $this->hasLegalId();
    }

    public function isSuperAdmin()
    {
        return in_array('ROLE_SUPER_ADMIN', $this->getRoles());
    }

    public function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->getRoles());
    }
    
    public function getFullname()
    {
        return $this->name . ' ' . $this->lastname;
    }
}