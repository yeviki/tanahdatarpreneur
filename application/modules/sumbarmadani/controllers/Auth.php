<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Auth extends SLP_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_peserta','mpeserta');
    }
    public function cekDataPeserta(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if($this->input->post('email') != '')
            {
                $email = $this->input->post('email');
                $cek = $this->mpeserta->cekDataPeserta($email);
                if(count($cek) > 0)
                {
                    $statuscode = 200;
                    $data = array(
                        'status' => true,
                        'message' => 'Data peserta ditemukan',
                        'data' => $cek
                    );
                }
                else
                {
                    $statuscode = 200;
                    $data = array(
                        'status' => false,
                        'message' => 'Data peserta tidak ditemukan',
                        'data' => $cek
                    );
                }
            }
            else
            {
                $statuscode = 402;
                $data = array(
                    'status' => false,
                    'message' => 'Email tidak boleh kosong',
                    'data' => array()
                );
            }
            // print_r($data); die;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        }
        else{
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

}