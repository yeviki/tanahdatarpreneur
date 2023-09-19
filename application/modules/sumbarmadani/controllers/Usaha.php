<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Usaha extends SLP_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_usaha','musaha');
    }

    public function initForm()
    {
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $bidangusahaRAW = $this->musaha->getBidang();
            $bidangusaha = array();
            if(!empty($bidangusahaRAW)){
                foreach ($bidangusahaRAW as $key => $value) {
                    $bidangusaha[] = [
                        "value" => $value->id_bidang_usaha, 
                        "label" => $value->nama_bidang
                    ];
                }
            }
            $data = array(
                [
                    "icon" => "user",
                    "keyboard_type" => "default",
                    "name" => "nama_pemilik",
                    "label" => "Nama Pemilik",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "user",
                    "keyboard_type" => "default",
                    "name" => "nama_usaha",
                    "label" => "Nama Usaha",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "user",
                    "keyboard_type" => "default",
                    "name" => "alamat_usaha",
                    "label" => "Alamat Usaha",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "user",
                    "keyboard_type" => "phone-pad",
                    "name" => "telp",
                    "label" => "Telepon",
                    "type" => "numeric",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "user",
                    "keyboard_type" => "phone-pad",
                    "name" => "wa",
                    "label" => "Nomor WhatsApp",
                    "type" => "numeric",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "user",
                    "keyboard_type" => "",
                    "name" => "id_bidang_usaha",
                    "label" => "Bidang Usaha",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => $bidangusaha
                ],
                [
                    "icon" => "user",
                    "keyboard_type" => "default",
                    "name" => "jenis_usaha",
                    "label" => "Jenis Usaha",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                
            );
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => 'Form Lengkapi Profile',
                'data' => $data
            ]));
        }
        else{
            $this->output->set_status_header(401)->set_content_type("application/json")->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

}