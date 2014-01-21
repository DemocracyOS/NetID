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
    public function verifyAction(Request $request)
    {
        $email = $request->get('email');
        $identityRepository = $this->getDoctrine()->getManager()->getRepository('DemocracyOSNetIdAdminBundle:Identity');
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

    public function createAction(Request $request)
    {
        $parser = $this->get('request_headers_parser');
        $token = $parser->getAccessToken();
        $em = $this->getDoctrine()->getManager();
        $applicationRepository = $em->getRepository('DemocracyOSNetIdApiBundle:Application');
        $application = $applicationRepository->findOneByAccessToken($token);
        
        $email = $request->get('email');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $foreignId = $request->get('foreignId');

        $identity = new Identity($email);
        $identity->setFirstname($firstname);
        $identity->setLastname($lastname);
        $identityApplication = new IdentityApplication();
        $identityApplication->setApplication($application);
        $identityApplication->setIdentity($identity);
        $identityApplication->setForeignId($foreignId);
        $identity->addApplication($identityApplication);
        $em->persist($identity);
        $em->flush();

        $response = new JsonResponse();
        $response->setData(array('id' => $identity->getId()));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/html');
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
        
        $response = new JsonResponse();
        $response->setData(array('email' => $email->getEmail(), 'validated' => $email->getValidated()));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }
}
