<?php

namespace DemocracyOS\NetIdAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="DemocracyOS\NetIdAdminBundle\Repository\EmailRepository")
 */
class Email
{
    public function __toString()
    {
        return $this->email;
    }

    public function __construct($email = null, $validated = false)
    {
        $this->email = $email;
        $this->validated = $validated;
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
     * @Assert\NotBlank(message = "The email should not be blank")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    protected $validated;

    /**
     * @ORM\ManyToOne(targetEntity="Identity", inversedBy="emails")
     * @ORM\JoinColumn(name="id_identity", referencedColumnName="id")
     */
    protected $identity;

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
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return Email
     */
    public function setValidated($validated = true)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set identity
     *
     * @param \DemocracyOS\NetIdAdminBundle\Entity\Identity $identity
     * @return Email
     */
    public function setIdentity(\DemocracyOS\NetIdAdminBundle\Entity\Identity $identity = null)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return \DemocracyOS\NetIdAdminBundle\Entity\Identity 
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
