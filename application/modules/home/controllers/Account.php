<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of login class
 *
 * @author Yogi "solop" Kaputra
 */

class Account extends SLP_Controller
{
    protected $_vwName  = '';
    protected $_uriName = '';
    protected $csrfHash;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_account' => 'mos'));
        $this->_vwName = 'vaccount';
        $this->_uriName = 'home/account';
    }
    public function index()
    {
        $this->session_info['page_name']     = 'Ubah Password';
        $this->session_info['siteUri']      = $this->_uriName;
        $this->session_info['page_js']         = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['page_css']         = $this->load->view($this->_vwName . '/vcss', array('siteUri' => $this->_uriName), true);
        $this->template->build($this->_vwName . '/vpage', $this->session_info);
    }
    private function validasiDataValue()
    {
        $this->form_validation->set_rules('oldpass', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('newpass', 'Password', 'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
        $this->form_validation->set_rules('confpass', 'Ketik ulang Password', 'required|matches[newpass]');
        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }
    public function update()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit;
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            if (!empty($session)) {
                // print_r($this->msis->ubahPass()); die;
                if ($this->is_password() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => array('oldpass' => 'Password lama salah'), 'csrfHash' => $csrfHash);
                } else if ($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mos->ubahPass();
                    if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Password berhasil diubah', 'csrfHash' => $csrfHash);
                    } else {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses ubah password gagal,silakan hubungi admin'), 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data tahun gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
    private function is_password()
    {
        $data = $this->mos->cek_password();
        if ($data == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
