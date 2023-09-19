<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Profile extends SLP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_peserta', 'mpeserta');
        $this->load->model('model_peserta', 'mpeserta');
        // ini_set('upload_max_filesize','8M');
        // echo ini_get('upload_max_filesize');
    }

    public function initform()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $data = array(
                [
                    "icon" => "image",
                    "keyboard_type" => "default",
                    "name" => "upload_foto",
                    "label" => "Foto Diri",
                    "type" => "file",
                    "validate" => ["image"],
                    "error" => ""
                ],
                [
                    "icon" => "assignment",
                    "keyboard_type" => "numeric",
                    "name" => "nik",
                    "label" => "Masukkan NIK",
                    "type" => "string",
                    "validate" => ["required", "min_length=16", "max_length=16"],
                    "error" => "",
                ],
                [
                    "icon" => "badge",
                    "keyboard_type" => "default",
                    "name" => "nama_lengkap",
                    "label" => "Masukkan Nama Lengkap",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "email",
                    "keyboard_type" => "email-address",
                    "name" => "email",
                    "label" => "Masukkan Email",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "lock",
                    "keyboard_type" => "default",
                    "name" => "password",
                    "label" => "Password",
                    "type" => "password",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "lock",
                    "keyboard_type" => "default",
                    "name" => "conf_password",
                    "label" => "Konfirmasi Password",
                    "type" => "password",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "event",
                    "keyboard_type" => "default",
                    "name" => "tempat_lhr",
                    "label" => "Masukkan Tempat Lahir",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "cake",
                    "keyboard_type" => "default",
                    "name" => "tanggal_lhr",
                    "label" => "Pilih Tanggal Lahir",
                    "type" => "date",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "home",
                    "keyboard_type" => "default",
                    "name" => "alamat_peserta",
                    "label" => "Masukkan Alamat",
                    "type" => "text",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "public",
                    "keyboard_type" => "",
                    "name" => "id_province",
                    "label" => "Pilih Provinsi",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => $this->mpeserta->getProvince()
                ],
                [
                    "icon" => "public",
                    "keyboard_type" => "",
                    "name" => "id_regency",
                    "label" => "Pilih Kabupaten/Kota",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => [
                        [
                            "value" => "",
                            "label" => "Silakan Pilih Provinsi Terlebih Dahulu"
                        ]

                    ]
                ],
                [
                    "icon" => "try",
                    "keyboard_type" => "",
                    "name" => "id_study",
                    "label" => "Pilih Pendidikan",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => $this->mpeserta->getStudy(),
                ],
                [
                    "icon" => "school",
                    "keyboard_type" => "",
                    "name" => "id_agama",
                    "label" => "Pilih Agama",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => $this->mpeserta->getAgama(),
                ],
                [
                    "icon" => "public",
                    "keyboard_type" => "",
                    "name" => "id_gender",
                    "label" => "Pilih Jenis Kelamin",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => $this->mpeserta->getGenderOptions(),
                ],
                [
                    "icon" => "person",
                    "keyboard_type" => "numeric",
                    "name" => "kode_pos",
                    "label" => "Masukkan Kode Pos",
                    "type" => "numeric",
                    "validate" => ["required", "max_length=5", "min_length=5"],
                    "error" => "",
                ],
                [
                    "icon" => "work",
                    "keyboard_type" => "default",
                    "name" => "pekerjaan",
                    "label" => "Masukkan Pekerjaan",
                    "type" => "string",
                    "validate" => ["required"],
                    "error" => "",
                ],
                [
                    "icon" => "bookmarks",
                    "keyboard_type" => "",
                    "name" => "id_jenis_akun",
                    "label" => "Apa anda sudah memiliki usaha?",
                    "type" => "select",
                    "validate" => ["required"],
                    "error" => "",
                    "options" => [
                        [
                            "value" => "1",
                            "label" => "Ya"
                        ],
                        [
                            "value" => "2",
                            "label" => "Tidak"
                        ]
                    ]
                ],
                [
                    "icon" => "pageview",
                    "keyboard_type" => "default",
                    "condition" => [
                        "id_jenis_akun" => "2"
                    ],
                    "name" => "minat_usaha",
                    "label" => "Masukkan Minat Usaha",
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
        } else {
            $this->output->set_status_header(401)->set_content_type("application/json")->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function getRegency()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $id_province = escape($this->input->get('id_province'));
            $data = $this->mpeserta->getRegency($id_province);
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => 'Data Kabupaten/Kota',
                'data' => $data
            ]));
        } else {
            $this->output->set_status_header(401)->set_content_type("application/json")->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    private function validasiDataValue($role, $id_jenis_akun)
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|min_length[16]|max_length[16]|is_unique[data_peserta.nik]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Peserta', 'required|trim');
        $this->form_validation->set_rules('tempat_lhr', 'Tempat Lahir Peserta', 'required|trim');
        $this->form_validation->set_rules('tanggal_lhr', 'Tanggal Lahir Peserta', 'required|trim');
        $this->form_validation->set_rules('alamat_peserta', 'Alamat Peserta', 'required|trim');
        $this->form_validation->set_rules('id_province', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('id_regency', 'Kabupaten/Kota', 'required|trim');
        $this->form_validation->set_rules('id_study', 'Pendidikan', 'required|trim');
        $this->form_validation->set_rules('id_agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('id_gender', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('id_jenis_akun', 'Silahkan pilih jawaban', 'required|trim');
        if ($id_jenis_akun == '2') {
            $this->form_validation->set_rules('minat_usaha', 'Silahkan isi minat usaha yang akan anda rintis', 'required|trim');
        }

        if ($role == 'new') {
            $valid = 'required|';
        } else {
            $valid = ($this->input->post('password') != '') ? 'required|' : '';
        }
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[xi_sa_users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid . 'matches[password]');
        validation_message_setting();

        $this->form_validation->set_message('regex_match', '%s minimal 8 karakter, mengandung satu huruf besar, satu huruf kecil,dan satu angka.');
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function createAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $id_jenis_akun = escape($this->input->post('id_jenis_akun', TRUE));
            // $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($_FILES));
            // var_dump( $_FILES ); die;
            if ($this->validasiDataValue('new', $id_jenis_akun) == FALSE or empty($_FILES) or $_FILES['upload_foto']['name'] == '') {
                $validate = $this->form_validation->error_array();
                $statusCode = 422;
                if (empty($_FILES)  or $_FILES['upload_foto']['name'] == '') {
                    $validate['upload_foto'] = 'Foto wajib diisi';
                }
                $result = array('status' => false, 'data' => $validate, 'message' => "Data tidak sesuai");
            } else {
                $foto = $this->getFoto();
                $data = $this->mpeserta->insertDataPeserta($foto);
                if ($data['response'] == 'ERROR') {
                    $statusCode = 500;
                    $result = array('status' => false, 'message' => "gagal menyimpan, terjadi kesalahan", 'data' => []);
                } else if ($data['response'] == 'USERNAME') {
                    $statusCode = 422;
                    $result = array('status' => false, 'message' => 'email sudah digunakan', 'data' => []);
                } else if ($data['response'] == 'SUCCESS') {
                    $statusCode = 200;
                    $result = array('status' => true, 'message' => 'Pendaftaran dengan NIK ' . $data['nikID'] . ' berhasil, silahkan login', 'data' => $data);
                }
            }
            $this->output->set_status_header($statusCode)->set_content_type('application/json')->set_output(json_encode($result));
        } else {
            $this->output->set_status_header(401)->set_content_type("application/json")->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function getFoto()
    {

        $nik              = escape($this->input->post('nik', TRUE));
        $nama_lengkap     = escape($this->input->post('nama_lengkap', TRUE));
        $token             = generateToken($nik, $nama_lengkap);
        $config = array(
            'upload_path'         => './assets/img/avatar/',
            'allowed_types'     => 'png|jpg|jpeg',
            'file_name'         => 'foto_' . $token,
            'file_ext_tolower'    => TRUE,
            'max_size'             => 3072,
            'max_filename'         => 0,
            'remove_spaces'     => TRUE
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('upload_foto')) {
            $error = array('error' => $this->upload->display_errors());
            $error['upload_max_filesize'] = ini_get('upload_max_filesize');
            // $this->output->set_status_header(400)->set_content_type('application/json')->set_output(json_encode($error));
            $file_upload = $error;
        } else {
            $upload_data = $this->upload->data();
            $file_upload = $upload_data['file_name'];
        }

        return $file_upload;
    }

    public function getData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nik = escape($this->input->post('nik', TRUE));
            $data = $this->mpeserta->getDataPeserta($nik);
            $foto = $data['foto'];
            unset($data['foto']);
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => 'Data ditemukan',
                'pas_foto' => $foto,
                'data' => $data
            ]));
        } else {
            $this->output->set_status_header(401)->set_content_type("application/json")->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }
}
