<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.


        
        // E.g.: $this->session = service('session');
    }

    protected function getAuthuser()
    {
        $token = $this->request->getHeaderLine('Authorization');
        
        // echo $token;
        if(!$token)
        {
            // $data = array('status'=>'token mismatch');
            // return $this->response->setJson($data)->setStatusCode(401);

            return null;
        }

        if(!empty($token)) {
            if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
                $token = $matches[1];
            }
        }

        

       

        try {

            $key = getenv('JWT_SECRET');
         
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            return true;
        } catch (\Exception $ex) {

            $response = service('response');
            $response->setBody('Access denied');
            $response->setStatusCode(401);
            return false;
        }

        

    }
}

