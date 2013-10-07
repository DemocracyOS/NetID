<?php

namespace PdR\NetIdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PdR\NetIdBundle\Entity\User;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
    	$userRepository = $this->getDoctrine()->getManager()->getRepository('PdRNetIdBundle:User');
        $users = $userRepository->findAll();
        $userSerializer = $this->get('user_serializer');

        $json = $userSerializer->serialize($users);

        return new Response($json);
    }

    public function insertAction($email)
    {
        $user = new User();
        $user->setEmail($email);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return new Response($email);
    }
}
