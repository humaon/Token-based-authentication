<?php

namespace App\Classes;

use phpDocumentor\Reflection\DocBlock\Tags\Method;

require_once "Constant.php";

Class Rest
{
    protected $request;
    protected $key='test123';
    protected $serviceName;
    protected $param;

    public function __construct()
    {
        $handler = fopen('php://input', 'r');
        $this->request = stream_get_contents($handler);
        //return print_r($this->request,true);
        $this->validateRequest();

    }

    public function validateRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo $this->throwError(REQUEST_TYPE_NOT_VALID, 'Request Type is not Valid');

        }
//      echo $_SERVER['CONTENT_TYPE'];
//       exit();
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            echo $this->throwError(REQUEST_CONTENT_NOT_VALID, 'Request content is not valid');
            exit();
        }
        $data = json_decode($this->request, true);
        //print_r($data);
        if (!isset($data['name']) || $data['name'] == '') {
            echo $this->throwError(API_NAME_REQUIRED, 'Api name is required');
            exit();
        }
        $this->serviceName = $data['name'];
        if (!is_array($data['param'])) {
            echo $this->throwError(API_PARAM_REQUIRED, 'Api parameter is required');
            exit();
        }
        $this->param = $data['param'];


    }

    public function validateParameter($fieldname, $value, $dataType, $required = true)
    {
        if($required){
            if($value=='')
                echo $this->throwError(API_PARAM_REQUIRED, "$fieldname is required");
                exit();
        }



        switch ($dataType) {
            case BOOLEAN:
                if (!is_bool($value)) {
                    echo $this->throwError(VALIDATE_PARAMETER_DATATYPE, 'Data type is not valid.it should be boolean');
                    exit();
                }
                break;
            case INTEGER:
                if (!is_numeric($value)) {
                    echo $this->throwError(VALIDATE_PARAMETER_DATATYPE, 'Data type is not valid.it should be numeric');
                    exit();
                }
                break;
            case STRING:

                if (!is_string($value)) {
                    echo $this->throwError(VALIDATE_PARAMETER_DATATYPE, 'Data type is not valid.it should be string');
                    exit();
                }
                break;

            Default:
                echo $this->throwError(VALIDATE_PARAMETER_DATATYPE, 'Data type is not valid');
                exit();
        }
    }

    public function processApi()
    {
        $api = new Api();
        $rMehtod = new reflectionMethod($api, $this->serviceName);
        if (!method_exists($api, $this->serviceName)) {
            echo $this->throwError(API_DOES_NOT_EXIST, 'Api does not exist');
            exit();
        }
        $rMehtod->invoke($api);

    }

    public function throwError($code, $message)
    {
        header('content-type:application/json');

        return json_encode(['error' => ['status' => $code, 'message' => $message]]);
    }

}