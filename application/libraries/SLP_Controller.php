<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of SLP_Controller class
 *
 * @author  Yogi Kaputra
 * @since   1.0
 *
 *
 */

class SLP_Controller extends MY_Controller {

  protected $session_info = array();

  public function __construct() {
    parent::__construct();
    $setApps = setApps();
    $appname = !empty($setApps) ? $setApps['app_name'] : '';
    $year    = !empty($setApps) ? $setApps['app_year'] : date('Y');
    $author  = !empty($setApps) ? $setApps['app_author'] : '';
    $versi   = !empty($setApps) ? $setApps['app_versi'] : '';
    $this->session_info['app_name']   = $appname;
    $this->session_info['app_author'] = $author;
    $this->session_info['app_footer'] = '&copy; '.((date('Y') == $year) ? $year : $year.' - '.date('Y')).' Copyright : <a href="javascript:void(0)">'.$author.'</a> - Aplikasi '.$appname.' v'.$versi;
    $this->session_info['app_descs']  = !empty($setApps) ? $setApps['app_description'] : '';
    $this->session_info['app_keys']   = !empty($setApps) ? $setApps['app_keywords'] : '';
    $this->session_info['app_favico'] = !empty($setApps) ? $setApps['app_favicon'] : '';
    $this->session_info['appIcon']    = !empty($setApps) ? $setApps['app_icon'] : '';

    //$this->load->library('Menu_loader');

    // Setting up the template
    //$this->template->set_layout('layouts/main');
    $this->template->enable_parser(FALSE); // default true

    $this->template->set_partial('header', 'layouts/partials/header', FALSE);
    $this->template->set_partial('title', 'layouts/partials/title', FALSE);
    $this->template->set_partial('navigation', 'layouts/partials/navigation', FALSE);
    $this->template->set_partial('footer', 'layouts/partials/footer', FALSE);
    $this->template->set_partial('javascript', 'layouts/partials/javascript', FALSE);
  }

}

// This is the end of WRC_AdminCont class
