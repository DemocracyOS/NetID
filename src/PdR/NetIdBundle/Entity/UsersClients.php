<?php

namespace PdR\NetIdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * UsersClient
 *
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class UsersClients
{
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="clients")
     * @ORM\Id
     * @ORM\JoinColumn(name="user_id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="users")
     * @ORM\Id
     * @ORM\JoinColumn(name="client_id")
     * @Expose
     * @Type("string")
     * @SerializedName("appId")
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column
     * @Type("string")
     * @Expose
     */
    private $foreignId;


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
     * Set user
     *
     * @param \PdR\NetIdBundle\Entity\User $user
     * @return UsersClient
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \PdR\NetIdBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set client
     *
     * @param \PdR\NetIdBundle\Entity\Client $client
     * @return UsersClient
     */
    public function setClient($client)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \PdR\NetIdBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set foreignId
     *
     * @param string $foreignId
     * @return UsersClient
     */
    public function setForeignId($foreignId)
    {
        $this->foreignId = $foreignId;
    
        return $this;
    }

    /**
     * Get foreignId
     *
     * @return string 
     */
    public function getForeignId()
    {
        return $this->foreignId;
    }
}
