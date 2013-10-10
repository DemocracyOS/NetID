<?php

namespace PdR\NetIdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function insertAction()
    {
        $content = $this->getRequest()->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true);
            if (isset($params['email']))
            {
                $email = $params['email'];   
            } else {
                $response = array('status' => 'error', 'error' => 'no email included in request');
                return new JsonResponse($response);       
            }
        } else {
            $response = array('status' => 'error', 'error' => 'no params included in request');
            return new JsonResponse($response);   
        }
        $user = new User();
        $user->setEmail($email);
        $user->setPassword('');
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        try {
            $manager->flush();   
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'error' => $e->getMessage());
            return new JsonResponse($response);
        }

        $response = array('status' => 'ok');
        return new JsonResponse($response);
    }

    public function allowedAction()
    {
        $content = $this->getRequest()->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true);
            $verb = $params['verb'];
        } else {
            return new JsonResponse(false);
        }
        
        $token = $this->getRequestAccessToken();

        if (!$token)
        {
            $response = array($verb => false);
            return new JsonResponse($response);
        }
        
        $foreignId = $params['foreignId'];
        
        $userRepository = $this->getDoctrine()->getManager()->getRepository('PdRNetIdBundle:User');
        try { 
            $user = $userRepository->findOneByClientTokenAndForeignId($token, $foreignId);
        } catch (\Doctrine\ORM\NoResultException $e) {
            $user = null;
        }

        if (!$user)
        {
            $response = array($verb => false);
            return new JsonResponse($response);
        }

        $allowed = $user->isAllowed($verb);
        $response = array($verb => $allowed);

        return new JsonResponse($response);
    }

    protected function getRequestAccessToken()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $header = $headers['Authorization'];
        } else {
            $header = '';
        }
        if (!preg_match('/'.preg_quote('Bearer', '/').'\s(\S+)/', $header, $matches)) {          
            return null;
        }

        $token = $matches[1];
        
        return $token;
    }
}
