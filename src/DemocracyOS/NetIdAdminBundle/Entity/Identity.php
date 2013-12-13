<?php

namespace DemocracyOS\NetIdAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Identity
 *
 * @ORM\Entity
 * @ORM\Table(name="identity")
 */
class Identity
{
    public function __toString()
    {
        if (isset($this->id))
        {
            return $this->getFullname();
        } else {
            return 'New Identity';
        }
    }

    public function getFullname()
    {
        return sprintf('%s %s', $this->firstname, $this->lastname);
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
     * @ORM\Column()
     * @Assert\NotBlank(message = "The firstname should not be blank")
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column()
     * @Assert\NotBlank(message = "The lastname should not be blank")
     */
    protected $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\ManyToOne(targetEntity="LegalIdType", inversedBy="identities")
     * @ORM\JoinColumn(name="legal_id_type", nullable=true)
     */
    protected $legalIdType;

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
     * Set firstname
     *
     * @param string $firstname
     * @return Identity
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Identity
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }
    
    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set legalIdType
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\LegalIdType $legalIdType
     * @return Identity
     */
    public function setLegalIdType(\DemocracyOS\NetIdAdminBundle\Entity\LegalIdType $legalIdType = null)
    {
        $this->legalIdType = $legalIdType;

        return $this;
    }

    /**
     * Get legalIdType
     *
     * @return \DemocracyOS\NetIdAdminBundle\Entity\LegalIdType 
     */
    public function getLegalIdType()
    {
        return $this->legalIdType;
    }
}
