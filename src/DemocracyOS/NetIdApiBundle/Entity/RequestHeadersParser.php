<?php

namespace DemocracyOS\NetIdApiBundle\Entity;

class RequestHeadersParser
{
    protected $headers;

    public function __construct()
    {
        if (!function_exists('getallheaders')) { 
            function getallheaders() { 
                foreach($_SERVER as $key=>$value) { 
                    if (substr($key,0,5)=="HTTP_") { 
                        $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5))))); 
                        $out[$key]=$value; 
                    }else{ 
                        $out[$key]=$value; 
                    } 
                } 
                return $out; 
            }
        }
        $this->headers = getallheaders();
    }

    public function get($header)
    {
        return $this->headers[$header];
    }

    public function getAccessToken()
    {
        $authorization = $this->get('Authorization');
        $token = explode(' ', $authorization);
        $token = isset($token[1]) ? $token[1] : null;
        return $token;
    }
}