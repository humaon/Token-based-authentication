<?php
namespace App\Classes;

use Firebase\JWT\JWT;

class Api extends Rest{
    public function __construct()
    {
        echo parent::__construct();


    }
    public function generateToken()
    {
        $this->validateParameter('email',$this->param['email'],STRING,FALSE);
        $payload=[
            'is'=>time(),
            'issuer'=>'localhost',
            'is'=>time()+60,
            'user_id'=>1

        ];
        echo JWT::encode($payload,$this->key);
    }

}