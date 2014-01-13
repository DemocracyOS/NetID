<?php

namespace DemocracyOS\NetIdAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use DemocracyOS\NetIdApiBundle\Entity\Identity;

class IdentityController extends Controller
{
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
