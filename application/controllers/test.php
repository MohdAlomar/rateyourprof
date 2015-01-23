<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
class Test extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	
		if(!$this->session->userdata('is_logged_in')){
			$this->response('unauthorized access', 401);
			exit();
		}
	}
    public function index_get()
    {
        // Display all books
		$user_test = array(
			'id'  => 1,
			'name'  => 'Mohd Alomar',
			'auth'  => 'yes',
		);
		     $this->response($user_test);         
    }

    public function index_post()
    {
        // Create a new book
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */