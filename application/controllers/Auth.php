<?php

class Auth extends Application {
    function __construct() {
      parent::__construct();
      $this->load->helper('url');
    }

    function index() {
      $this->data['pagebody'] = 'login';
      $this->render();
    }
    
     function submit() {
        $key = $_POST['userid'];
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $user = $this->users->get($key);
        if ($password == (string) $user->password) {
            $this->session->set_userdata('userID',$key);
            $this->session->set_userdata('userName',$user->name);
            $this->session->set_userdata('userRole',$user->role);
        }
        redirect('/');
    } 

    function logout() {
      $this->session->sess_destroy();
      redirect('/');
  } 
}