<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = "Top Secret Government Site";    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {
        //$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'),true);
        $this->makemenu();
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->data['sessionid'] = session_id();
        $this->parser->parse('_template', $this->data);
    }

    function restrict($roleNeeded = null) {
        $userRole = $this->session->userdata('userRole');
        if ($roleNeeded != null) {
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                redirect("/");
                return;
                }
            } else if ($userRole != $roleNeeded) {
                redirect("/");
                return;
            }
        }
    }
    
    function makemenu() {
        $userRole = $this->session->userdata('userRole');
        $userName = $this->session->userdata('userName');
        $this->data['menudata'] = array();
        array_push($this->data['menudata'], array('name' => "Alpha",
                                                    'link' => '/alpha'));
        if ($userRole === "user") {
            array_push($this->data['menudata'], array('name' => "Beta", 
                                                        'link' => '/beta'));
        } else if ($userRole === "admin") {
            array_push($this->data['menudata'], array('name' => "Beta", 
                                                        'link' => '/beta'));
            array_push($this->data['menudata'], array('name' => "Gamma", 
                                                        'link' => '/gamma'));
        }        
        if (!empty($userName)) {
            $this->data['uname'] = $userName;
            array_push($this->data['menudata'], array('name' => "Logout", 
                                                        'link' => '/auth/logout'));
        } else {
            $this->data['uname'] = "";
            array_push($this->data['menudata'], array('name' => "Login", 
                                                        'link' => '/auth'));
        }
        
        $this->data['menubar'] = $this->parser->parse('_menubar', $this->data,true);
    }
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */