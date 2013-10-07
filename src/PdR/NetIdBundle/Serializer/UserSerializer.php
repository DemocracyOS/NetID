<?php
namespace PdR\NetIdBundle\Serializer;

use JMS\Serializer\SerializerBuilder;
use PdR\NetIdBundle\Entity\User;
use JMS\Serializer\SerializationContext;

class UserSerializer
{
	protected $serializer;

	public function __construct($serializer)
	{
		$this->serializer = $serializer;
	}

	public function serialize($users)
	{
		$context = new SerializationContext();
    	$context->setSerializeNull(true);
    	
		$jsonContent = $this->serializer->serialize($users, 'json', $context);

		return $jsonContent;
	}
}