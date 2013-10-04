<?php
namespace PdR\NetIdBundle\Serializer;

use JMS\Serializer\SerializerBuilder;
use PdR\NetIdBundle\Entity\User;

class UserSerializer
{
	protected $serializer;

	public function __construct($serializer)
	{
		$this->serializer = $serializer;
	}

	public function serialize($users)
	{
		$jsonContent = $this->serializer->serialize($users, 'json');

		return $jsonContent;
	}
}