<?php

namespace PdR\NetIdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PdRNetIdBundle:Default:index.html.twig');
    }

    public function usersAction(Request $request)
    {
    	$userRepository = $this->getDoctrine()->getManager()->getRepository('PdRNetIdBundle:User');
        $users = $userRepository->findAll();
        $userSerializer = $this->get('user_serializer');

        $json = $userSerializer->serialize($users);

        return new Response($json);
    }
}
