<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of peserta class
 *
 * @author Yogi "solop" Kaputra
 */

class Peserta extends SLP_Controller
{
    protected $_vwName   = '';
    protected $_uriName  = '';
    protected $_unitId   = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_peserta' => 'mpeserta', 'master/model_master' => 'mmas'));
        $this->_vwName  = 'vpeserta';
        $this->_uriName = 'data/peserta';
        //set data daerah
        // $dataUser = currentDataUser();
        //  = !empty($dataUser) ? $dataUser['unit_id'] : '';
    }

    private function validasiDataValue($role, $minat_usaha)
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Peserta', 'required|trim');
        $this->form_validation->set_rules('tempat_lhr', 'Tempat Lahir Peserta', 'required|trim');
        $this->form_validation->set_rules('tanggal_lhr', 'Tanggal Lahir Peserta', 'required|trim');
        $this->form_validation->set_rules('alamat_peserta', 'Alamat Peserta', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required|trim');
        $this->form_validation->set_rules('id_study', 'Pendidikan', 'required|trim');
        $this->form_validation->set_rules('id_agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('id_gender', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('id_jenis_akun', 'Silahkan pilih jawaban', 'required|trim');
        if ($minat_usaha == '2') {
            $this->form_validation->set_rules('minat_usaha', 'Silahkan isi minat usaha yang akan anda rintis', 'required|trim');
        }

        if ($role == 'new') {
            $valid = 'required|';
        } else {
            $valid = ($this->input->post('password') != '') ? 'required|' : '';
        }
        $this->form_validation->set_rules('username', 'Email', 'required|trim|valid_email');

        if ($this->app_loader->is_super()) {
            $this->form_validation->set_rules('password', 'Password', $valid . 'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
            $this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid . 'matches[password]');
        } else {
            $this->form_validation->set_rules('id_pelatihan', 'Pelatihan', 'required|trim');
        }

        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Data', '#');
        $this->breadcrumb->add('Peserta', site_url($this->_uriName));

        $this->session_info['page_name']        = 'Data Peserta';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['page_js']            = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['data_study']       = $this->mmas->getDataStudy();
        $this->session_info['data_agama']       = $this->mmas->getDataAgama();
        $this->session_info['data_gender']      = $this->mmas->getDataGender();
        $this->session_info['data_provinsi']    = $this->mmas->getProvinsi();
        $this->session_info['data_usaha']       = $this->mmas->getJenisAkun();
        $this->session_info['data_pelatihan']   = $this->mmas->getPelatihanOPD();
        $this->template->build($this->_vwName . '/vpage', $this->session_info);
    }

    public function listview()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $data = array();
            $session = $this->app_loader->current_account();
            if (isset($session)) {
                $param    = $this->input->post('param', TRUE);
                $dataTabels = $this->mpeserta->get_datatables($param);
                $no       = $this->input->post('start');
                foreach ($dataTabels as $key => $u) {
                    if (file_exists(FCPATH . 'assets/img/avatar/' . $u['upload_foto']) and $u['upload_foto'] != "") {
                        $img_url = site_url('assets/img/avatar/' . $u['upload_foto']);
                    } else {
                        $img_url = site_url('assets/img/avatar/default-user-icon.jpg');
                    }

                    $no++;
                    $row = array();
                    $row[] = '<div class="custom-control custom-checkbox mt-0 pt-0">
                            <input type="checkbox" class="custom-control-input" name="checkid[]" id="u_' . $u['token'] . '" value="' . $u['token'] . '">
                            <label class="custom-control-label font-weight-bolder" for="u_' . $u['token'] . '"></label>
                            </div>';
                    $row[] = $no;
                    $row[] = '<img style="width: 100%; height: 50%;" src="' . $img_url . '">';
                    $row[] = '<ul class="list-unstyled" style="margin-bottom:0px;">' .
                        '<li><strong>NIK :</strong> ' . $u['nik'] . '</li>' .
                        '<li><strong>Nama :</strong> ' . $u['nama_lengkap'] . '</li>' .
                        '</ul>';
                    $row[] = province($u['id_province']);
                    $row[] = regency($u['id_regency']);
                    $row[] = '<button type="button" class="btn btn-orange btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnEdit" data-id="' . $u['token'] . '" title="Edit data user"><i class="fas fa-pencil-alt"></i> </button>';
                    $data[] = $row;
                }
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mpeserta->count_all(),
                    "recordsFiltered" => $this->mpeserta->count_filtered($param),
                    "data" => $data,
                );
            }
            //output to json format
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $minat_usaha = escape($this->input->get('minat_usaha', TRUE));
            if (!empty($session)) {
                // if($this->validasiDataValue('new') == FALSE) {
                if ($this->validasiDataValue('new', $minat_usaha) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mpeserta->insertDataPeserta();
                    if ($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data peserta baru dengan NIK ' . $data['nikID'] . ' gagal, karena sudah ada peserta yang menggunakan NIK yang sama'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'NOIMAGE') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses upload data gagal'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'FOUND') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses simpan gagal, peserta sudah ada dalam pelatihan'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'USERNAME') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data user baru dengan username gagal, karena sudah ada user yang menggunakan username yang sama'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses insert data peserta baru dengan NIK ' . $data['nikID'] . ' sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data peserta gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function details()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $token    = escape($this->input->post('tokenId', TRUE));
            if (!empty($token) and !empty($session)) {
                $data_peserta   = $this->mpeserta->getDataDetailPeserta($token);
                $data_users     = $this->mpeserta->getDataDetailUsers($token);

                $row = array();
                $row['nik']             = !empty($data_peserta) ? $data_peserta['nik'] : '';
                $row['nama_lengkap']    = !empty($data_peserta) ? $data_peserta['nama_lengkap'] : '';
                $row['tempat_lhr']      = !empty($data_peserta) ? $data_peserta['tempat_lhr'] : '';
                $row['tanggal_lhr']     = !empty($data_peserta) ? $data_peserta['tanggal_lhr'] : '';
                $row['alamat_peserta']  = !empty($data_peserta) ? $data_peserta['alamat_peserta'] : '';
                $row['no_hp']           = !empty($data_peserta) ? $data_peserta['no_hp'] : '';
                $row['id_study']        = !empty($data_peserta) ? $data_peserta['id_study'] : '';
                $row['id_agama']        = !empty($data_peserta) ? $data_peserta['id_agama'] : '';
                $row['id_gender']       = !empty($data_peserta) ? $data_peserta['id_gender'] : '';
                $row['id_province']     = !empty($data_peserta) ? $data_peserta['id_province'] : '';
                $row['id_regency']      = !empty($data_peserta) ? $data_peserta['id_regency'] : '';
                $row['pekerjaan']       = !empty($data_peserta) ? $data_peserta['pekerjaan'] : '';
                $row['id_jenis_akun']   = !empty($data_peserta) ? $data_peserta['id_jenis_akun'] : '';
                $row['minat_usaha']     = !empty($data_peserta) ? $data_peserta['minat_usaha'] : '';
                $row['kode_pos']        = !empty($data_peserta) ? $data_peserta['kode_pos'] : '';
                $row['upload_foto']     = !empty($data_peserta) ? $data_peserta['upload_foto'] : '';
                $row['id_pelatihan']    = !empty($data_peserta) ? $data_peserta['id_pelatihan'] : '';

                $row['username'] = !empty($data_users) ? $data_users['username'] : '';
                $row['blokir']     = !empty($data_users) ? $data_users['blokir'] : 0;
                $row['status']     = !empty($data_users) ? $data_users['id_status'] : 1;
                $result = array('status' => 'RC200', 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $token         = escape($this->input->post('tokenId', TRUE));
            $minat_usaha = escape($this->input->get('minat_usaha', TRUE));
            if (!empty($session) and !empty($token)) {
                // if($this->validasiDataValue('edit') == FALSE) {
                if ($this->validasiDataValue('edit', $minat_usaha) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mpeserta->updateDataPeserta();
                    if ($data['response'] == 'NODATA') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data peserta dengan nik ' . $data['nikID'] . ' gagal, karena data tidak ditemukan'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data peserta dengan nik ' . $data['nikID'] . ' gagal, karena sudah ada peserta yang menggunakan nik yang sama'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'NOIMAGE') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Foto harus diupload dengan format .png, .bmp, .jpg dan .jpeg serta max 3MB...'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'FOUND') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update gagal, peserta sudah diletakkan pada pelatihan lain'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses update data peserta dengan nik ' . $data['nikID'] . ' sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data user gagal, mohon coba kembali...'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session   = $this->app_loader->current_account();
            $csrfHash  = $this->security->get_csrf_hash();
            $token     = escape($this->input->post('tokenId', TRUE));
            if (!empty($session) and !empty($token)) {
                $data = $this->mpeserta->deleteDataPeserta();
                if ($data['response'] == 'SUCCESS') {
                    $result = array('status' => 'RC200', 'message' => 'Proses delete data peserta sukses', 'csrfHash' => $csrfHash);
                } else {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data peserta gagal, silahkan periksa kembali', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 'RC404', 'message' => 'Proses delete data peserta gagal', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function kirim_email()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session   = $this->app_loader->current_account();
            $csrfHash  = $this->security->get_csrf_hash();
            $token     = escape($this->input->post('tokenId', TRUE));
            if (!empty($session) and !empty($token)) {
                $data = $this->mpeserta->sendMailAkunPeserta();
                if ($data['response'] == 'SUCCESS') {
                    $result = array('status' => 'RC200', 'message' => 'Proses pengiriman data akun peserta sukses', 'csrfHash' => $csrfHash);
                } else {
                    $result = array('status' => 'RC404', 'message' => 'Proses pengiriman data akun peserta gagal, silahkan periksa kembali', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 'RC404', 'message' => 'Proses pengiriman data akun peserta gagal', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function searching()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $username = escape($this->input->get('username', TRUE));
            if (!empty($session) and !empty($username)) {
                $data  = $this->mpeserta->searchDataUser($username);
                $result = array('message' => $data, 'csrfHash' => $csrfHash);
            } else
                $result = array('message' => 0, 'csrfHash' => $csrfHash);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    //get data kab/kota
    public function regency()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $province = $this->input->get('province', TRUE);
            if (!empty($province) and !empty($session)) {
                $data = $this->mmas->getDataRegencyByProvince($province);
                if (count($data) > 0) {
                    $row = array();
                    foreach ($data as $key => $val) {
                        $row['id']         = $val['id'];
                        $row['text']    = ($val['status'] == 1) ? "KAB " . $val['name'] : $val['name'];
                        $hasil[] = $row;
                    }
                    $result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
                } else
                    $result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function import_excel()
    {
        include APPPATH . 'third_party/PHPExcel.php';
        $create_by       = $this->app_loader->current_account();
        $create_date     = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $create_ip       = $this->input->ip_address();
        $csrfHash         = $this->security->get_csrf_hash();
        $namafile          = $_FILES['file_name']['name'];
        $lokasi            = $_FILES['file_name']['tmp_name'];
        move_uploaded_file($lokasi, './repository/temporary/' . $namafile);
        $excelreader         = new PHPExcel_Reader_Excel2007();
        $spreadsheet         = $excelreader->load('repository/temporary/' . $namafile);
        $sheetdata             = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // echo "<pre>";
        // print_r($sheetdata);
        // echo "</pre>";
        // exit;

        $dataPeserta = array();

        $numrow = 1;

        foreach ($sheetdata as $row) {
            if ($numrow > 3) { // kalau row ke satu di excel adalah nama th table
                $token = generateToken($row['A'], $row['B']);
                array_push($dataPeserta, array(
                    'token'                 => $token,
                    'nik'               => isset($row['A']) ? trim($row['A']) : '',
                    'nama_lengkap'      => $row['B'] ? $row['B'] : '',
                    'tanggal_lhr '      => $row['C'] ? $row['C'] : '',
                    'tempat_lhr'        => $row['D'] ? $row['D'] : '',
                    'id_gender'         => $row['E'] ? $row['E'] : '',
                    'alamat_peserta'    => $row['F'] ? $row['F'] : '',
                    'kode_pos'          => $row['G'] ? $row['G'] : '',
                    'id_study'          => $row['H'] ? $row['H'] : '',
                    'id_agama'          => $row['I'] ? $row['I'] : '',
                    'pekerjaan'         => $row['J'] ? $row['J'] : '',
                    'id_jenis_akun'     => $row['K'] ? $row['K'] : '',
                    'create_by'         => $create_by,
                    'create_date'       => $create_date,
                    'create_ip'         => $create_ip,
                    'mod_by'            => $create_by,
                    'mod_date'          => $create_date,
                    'mod_ip'            => $create_ip,
                ));
                $password = isset($row['A']) ? password_hash($row['A'], PASSWORD_DEFAULT) : '';
                $dataUsers = array(
                    'token'                 => $token,
                    'username'          => $row['L'] ? $row['L'] : '',
                    'password'          => $password,
                    'email '              => $row['L'] ? $row['L'] : '',
                    'fullname'          => $row['B'] ? $row['B'] : '',
                    'id_opd'            => '0',
                    'blokir'            => '0',
                    'id_status'         => '1',
                    'create_by'         => $create_by,
                    'create_date'       => $create_date,
                    'create_ip'         => $create_ip,
                    'mod_by'            => $create_by,
                    'mod_date'          => $create_date,
                    'mod_ip'            => $create_ip,
                );
                $this->db->insert('xi_sa_users', $dataUsers);
                $id_users = $this->db->insert_id();

                $this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $password, 'updated' => 'N'));
                /*query insert user group privileges*/
                $this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => '9', 'id_status' => 1));
            }
            $numrow++;
        }

        $data = ['data_peserta' => $dataPeserta];
        // print_r($data);die;
        $cek = 0;
        $response = [];
        foreach ($data as $key => $value) {
            $import = $this->mpeserta->import($key, $value);
            if ($import > 0) {
                $cek += 1;
            }
        }

        if ($cek == 1) {
            $result = array('status' => 'RC200', 'message' => 'Proses import data sukses', 'csrfHash' => $csrfHash);
        } else {
            $result = array('status' => 'RC404', 'message' => 'Proses import data gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
        }

        // print_r($cek);die;

        // $response =  $this->db->insert_batch('data_peserta', $dataPeserta);
        // $responsePeserta    = $this->mpeserta->import($dataPeserta);
        // $responseUser       = $this->mpeserta->import($dataUsers);
        // // $response2 =  $this->db->insert_batch('xi_sa_users', $dataUsers);
        // if ($response['response'] == 'ERROR') {
        //     $result = array('status' => 'RC404', 'message' => 'Proses import data gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
        // } else if ($response['response'] == 'SUCCESS') {

        // }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function export_to_pdf($tahun = "")
    {
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        if (!empty($session)) {
            $data['peserta'] = $this->mpeserta->printDataPeserta($tahun);
            $data['tahun'] = $tahun;
            echo $this->load->view($this->_vwName . '/printpage', $data, TRUE);
        } else {
            $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            echo json_encode($result);
        }
    }
}

// This is the end of users class
