<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\UnauthorizedException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = ['Auth', 'Flash', ];

  protected $_CustomersAutentication = array(
             'authenticate'=> [
                AuthComponent::ALL => ['userModel' => 'Users'],
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                    ],
             ],
            'authError'=> 'Área restrita, identifique-se primeiro.',
            'sessionKey' => 'Auth.Customer', 
            'loginAction' => ['controller' => 'users', 'action' => 'login', 'customer' => true], 
            'loginRedirect' => '/', 
            'logoutRedirect' => '/');

    protected $_UsersAutentication = array(
             'authenticate'=> [
                AuthComponent::ALL => ['userModel' => 'Users'],
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                    ],
             ],
            'authError'=> 'Área restrita, identifique-se primeiro.',
            'sessionKey' => 'Auth.Admin', 
            'loginAction' => ['controller' => 'users', 'action' => 'login', 'admin' => true], 
            'loginRedirect' => '/admin', 
            'logoutRedirect' => '/admin/login');

    public $helpers = ['Form', 'Html'];
    
    public function initialize() {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', ['authorize' => 'Controller',
        
        //added this line
        'authenticate' => ['Form' => ['fields' => ['username' => 'email', 'password' => 'password']]], 'loginAction' => ['controller' => 'Users', 'action' => 'login'], 'unauthorizedRedirect' => $this->referer() ]);
        
        // Permite a ação display, assim nosso pages controller
        // continua a funcionar.
        //$this->Auth->allow(['login']);
        
        
    }
    
    public function isAuthorized($user) {
        return true;
    }
    
    // Verifiy that is a prefix
    protected function isPrefix($prefix) {
        $params = $this->request->params;
        return isset($params['prefix']) && $params['prefix'] === $prefix;
    }
    
    public function beforeFilter(Event $e) {
        $name = $this->request->session()->read();
        //pr($name);
        $this->_manageAuthConfigs();
    }
    
    // public function beforeFilter(Event $e) {
    //     $params = $this->request->params;
    //     if (!empty($params['prefix']) and $params['prefix'] == 'admin') {
    //         if ($this->Auth->user('admin') != true) {
    //             throw new UnauthorizedException('Opa!, você não pode estar aqui!');
    //         }
    //     }
    // }
    
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
        
       $authUser = !empty($this->Auth->user()) ? $this->Auth->user() : null;
        $this->set(['authUser'=>$authUser]);
        // set in view the body class
        $this->set('bodyClass', 
        sprintf('%s %s', strtolower($this->name), strtolower($this->name) . '-' . strtolower($this->request->params['action'])));
    }

    private function _manageAuthConfigs() {
      
         $this->Auth->config($this->_CustomersAutentication);
        
        // if the user admin
        if ($this->isPrefix('admin')) {
            $this->Auth->config($this->_UsersAutentication);
            $this->Auth->allow('login');
        } elseif ($this->isPrefix('user')) {
            //$this->Auth->deny();
        } else {
            $this->Auth->allow();
        }
    }
}
