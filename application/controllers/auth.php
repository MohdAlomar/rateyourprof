<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
class Auth extends REST_Controller
{
	

    public function login_get()
    {
    	if($this->get('id') == '1' && $this->get('password') === '123456')
    	{
    		$this->session->set_userdata('is_logged_in',true);
    		$this->response('loggedin TEST', 200);
    	}
    	else 
    		$this->response('Error 301', 301);
    }

    public function logout_get()
    {
    	$this->session->sess_destroy();
    	$this->response('logout', 200);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */