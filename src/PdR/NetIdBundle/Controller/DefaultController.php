<?php

namespace PdR\NetIdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PdRNetIdBundle:Default:index.html.twig');
    }

    public function usersAction()
    {
        $users = array('sacha', 'oscar', 'cristian', 'guido');
        return new JsonResponse($users);
    }
}
