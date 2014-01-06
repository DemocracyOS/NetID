<?php

namespace DemocracyOS\NetIdAdminBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\Document */
class LogRecord
{
	/** @MongoDB\Id */
	protected $id;

	/** @MongoDB\String */
	protected $ip;

	/** @MongoDB\String */
	protected $browserData;

	/** @MongoDB\Hash */
	protected $roles;

	#	/** @ReferenceOne(targetDocument="User", inversedBy="posts") */
	#protected $user;

	#protected $action;

	#protected $object;

	#protected $datetime;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get ip
     *
     * @return string $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set browserData
     *
     * @param string $browserData
     * @return self
     */
    public function setBrowserData($browserData)
    {
        $this->browserData = $browserData;
        return $this;
    }

    /**
     * Get browserData
     *
     * @return string $browserData
     */
    public function getBrowserData()
    {
        return $this->browserData;
    }

    /**
     * Set roles
     *
     * @param hash $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get roles
     *
     * @return hash $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
