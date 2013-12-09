<?php

namespace DeR\NetIdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use DeR\NetIdBundle\Entity\Identity;

class IdentityController extends Controller
{
    public function indexAction(Request $request)
    {
    	$identityRepository = $this->getDoctrine()->getManager()->getRepository('DeRNetIdBundle:Identity');
        $identities = $identityRepository->findAll();
        $identitySerializer = $this->get('identity_serializer');

        $json = $identitySerializer->serialize($identities);

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
        $identity = new Identity();
        $identity->setEmail($email);
        $identity->setPassword('');
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($identity);
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
        
        $identityRepository = $this->getDoctrine()->getManager()->getRepository('DeRNetIdBundle:Identity');
        try { 
            $identity = $identityRepository->findOneByClientTokenAndForeignId($token, $foreignId);
        } catch (\Doctrine\ORM\NoResultException $e) {
            $identity = null;
        }

        if (!$identity)
        {
            $response = array($verb => false);
            return new JsonResponse($response);
        }

        $allowed = $identity->isAllowed($verb);
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

    public function verifyAction()
    {
        $email = $this->get('request')->request->get('email');
        $identityRepository = $this->getDoctrine()->getManager()->getRepository('DeRNetIdBundle:Identity');
        $identity = $identityRepository->findOneByEmail($email);
        $response = new JsonResponse();
        if (!$identity->isValidated())
        {
            $response->setStatusCode(200);
        } else {
            $errorMessage = $this->get('translator')->trans('not.verified.identity');
            $response->setData(array('error' => $errorMessage));
            $response->setStatusCode(403);
            $response->headers->set('Content-Type', 'text/html');
        }
        return $response;
    }
}
