<?php

namespace DemocracyOS\NetIdApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use DemocracyOS\NetIdAdminBundle\Entity\Identity;
use DemocracyOS\NetIdAdminBundle\Entity\IdentityApplication;

class IdentityController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new JsonResponse();
        $this->response->headers->set('Content-Type', 'application/json');
    }

    public function verifyAction(Request $request)
    {
        $email = $request->get('email');
        $identityRepository = $this->getDoctrine()->getManager()->getRepository('DemocracyOSNetIdAdminBundle:Identity');
        $identity = $identityRepository->findOneByEmail($email);
        $response = $this->response;

        if ($identity->isValidated())
        {
            $response->setStatusCode(200);
        } else {
            $errorMessage = $this->get('translator')->trans('not.verified.identity');
            $response->setData(array('error' => $errorMessage));
            $response->setStatusCode(403);
        }
        return $response;
    }

    public function createAction(Request $request)
    {
        $parser = $this->get('request_headers_parser');
        $token = $parser->getAccessToken();

        $em = $this->getDoctrine()->getManager();
        $applicationRepository = $em->getRepository('DemocracyOSNetIdApiBundle:Application');
        $identityRepository = $em->getRepository('DemocracyOSNetIdAdminBundle:Identity');
        $application = $applicationRepository->findOneByAccessToken($token);
        
        $email = $request->get('email');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $foreignId = $request->get('foreignId');
        $emailValidated = $request->get('emailValidated');

        $response = $this->response;

        $identity = $identityRepository->findOneByEmail($email);
        $exists = isset($identity);
        
        if (!isset($identity)) {
            $identity = new Identity($email, $emailValidated);
            #$identityApplication = new IdentityApplication();
            #$identityApplication->setApplication($application);
            #$identityApplication->setIdentity($identity);
            #$identityApplication->setForeignId($foreignId);
            #$identity->addApplication($identityApplication);
        }
        
        $identity->setFirstname($firstname . $token);
        $identity->setLastname($lastname . $token);
        
        $em->persist($identity);
        $em->flush();

        if ($exists)
        {
            $response->setData(array('error' => 'Email already exists', 'id' => $identity->getId()));
            $response->setStatusCode(409);
        } else {
            $response->setData(array('id' => $identity->getId()));
            $response->setStatusCode(200);   
        }
        return $response;
    }

    public function verifyEmailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $emailRepository = $em->getRepository('DemocracyOSNetIdAdminBundle:Email');
        
        $email = $request->get('email');
        $foreignId = $request->get('foreignId');

        $email = $emailRepository->findByForeignIdAndEmail($foreignId, $email);
        $email->setValidated();
        $em->persist($email);
        $em->flush();
        
        $response = $this->response;
        $response->setData(array('email' => $email->getEmail(), 'validated' => $email->getValidated()));
        $response->setStatusCode(200);
        return $response;
    }
}
