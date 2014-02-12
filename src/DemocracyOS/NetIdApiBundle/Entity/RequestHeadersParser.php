<?php

namespace DemocracyOS\NetIdApiBundle\Entity;

use Symfony\Component\HttpFoundation\Request;

class RequestHeadersParser
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getAccessToken()
    {
        $header = null;
        if (!$this->request->headers->has('AUTHORIZATION')) {
            if (!function_exists('apache_request_headers')) {
                function apache_request_headers() { 
                    foreach($_SERVER as $key=>$value) { 
                        if (substr($key,0,5)=="HTTP_") { 
                            $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5))))); 
                            $out[$key]=$value; 
                        } else { 
                            $out[$key]=$value; 
                        } 
                    } 
                    return $out; 
                } 
            }
            $headers = apache_request_headers();

            $headers = array_combine(array_map('ucwords', array_keys($headers)), array_values($headers));

            if (isset($headers['Authorization'])) {
                $header = $headers['Authorization'];
            }
        } else {
          $header = $this->request->headers->get('AUTHORIZATION');
        }

        if (!$header) {
            return NULL;
        }


        if (!preg_match('/'.preg_quote('Bearer', '/').'\s(\S+)/', $header, $matches)) {
          return NULL;
        }

        $token = $matches[1];

        return $token;
    }
}