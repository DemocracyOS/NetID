<?php

namespace DemocracyOS\NetIdApiBundle\Entity;

class RequestHeadersParser
{
    protected $headers;

    public function __construct()
    {
        if (!function_exists('getallheaders')) 
        { 
            function getallheaders() 
            { 
                $headers = array(); 
                foreach ($_SERVER as $name => $value) 
                { 
                    if (substr($name, 0, 5) == 'HTTP_') 
                    { 
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
                    } 
                } 
                return $headers; 
            }
        }
        fwrite(STDOUT, sprintf("existe la funcion getallheaders? %s", function_exists('getallheaders')));
        fwrite(STDOUT, sprintf("devuelve %j", getallheaders()));
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