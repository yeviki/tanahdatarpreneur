<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat class
 *
 * @author Yogi "solop" Kaputra
 */

class Perizinan extends SLP_Controller {
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_perizinan' => 'mIzin', 'master/model_master' => 'mmas'));
        $this->_vwName = 'vperizinan';
        $this->_uriName = 'kegiatan/perizinan';
    }

    private function validasiDataValue() {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
        $this->form_validation->set_rules('id_jenis_kegiatan', 'Jenis Kegiatan', 'required|trim');
        $this->form_validation->set_rules('no_nib', 'No NIB', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
        $this->form_validation->set_rules('npwp', 'No NPWP', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        validation_message_setting();
        if($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function index() {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Kegiatan', '#');
        $this->breadcrumb->add('Perizinan', site_url($this->_uriName));
        $this->session_info['page_name']        = 'Perizinan';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['page_js']	        = $this->load->view($this->_vwName.'/vjs', array('siteUri'=>$this->_uriName), true);
        $this->session_info['data_kat']         = $this->mmas->getJenisKegiatan();
        $this->session_info['data_pelatihan']   = $this->mmas->getPelatihan();
        $this->session_info['data_provinsi']    = $this->mmas->getProvinsi();
        $this->template->build($this->_vwName.'/vpage', $this->session_info);
    }

    public function listview() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $data = array();
            $session = $this->app_loader->current_account();
            if(isset($session)){
                $dataList = $this->mIzin->get_datatables();
                $no = $this->input->post('start');
                foreach ($dataList as $key => $dl) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $dl['nik'];
                    $row[] = $dl['no_nib'];
                    $row[] = $dl['nama'];
                    $row[] = $dl['npwp'];
                    $row[] = kategori_pelatihan($dl['id_jenis_kegiatan']);
                    $row[] = '<button type="button" class="btn btn-orange btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnEdit" data-id="'.$this->encryption->encrypt($dl['id_perizinan']).'" title="Edit data"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-danger btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnDelete" data-id="'.$this->encryption->encrypt($dl['id_perizinan']).'" title="Hapus data"><i class="fas fa-trash-alt"></i></button>';
                    $data[] = $row;
                }
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mIzin->count_all(),
                    "recordsFiltered" => $this->mIzin->count_filtered(),
                    "data" => $data,
                );
            }
            //output to json format
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function create() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            if(!empty($session)) {
                if($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mIzin->insertData();
                    if($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data baru dengan nik '.$data['nama'].' gagal, karena ditemukan nik yang sama'), 'csrfHash' => $csrfHash);
                    } else if($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses insert data baru dengan nik '.$data['nama'].' sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data baru gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function details() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = $this->input->post('token', TRUE);
            if(!empty($contId) AND !empty($session)) {
                $data = $this->mIzin->getDataDetail($this->encryption->decrypt($contId));
                $row = array();
                $row['nik']	                = !empty($data) ? $data['nik'] : '';
                $row['no_nib']	            = !empty($data) ? $data['no_nib'] : '';
                $row['id_jenis_kegiatan']	= !empty($data) ? $data['id_jenis_kegiatan'] : '';
                $row['id_pelatihan']	    = !empty($data) ? $data['id_pelatihan'] : '';
                $row['nama']	            = !empty($data) ? $data['nama'] : '';
                $row['alamat']	            = !empty($data) ? $data['alamat'] : '';
                $row['no_hp']	            = !empty($data) ? $data['no_hp'] : '';
                $row['npwp']	            = !empty($data) ? $data['npwp'] : '';
                $row['email']	            = !empty($data) ? $data['email'] : '';
                $row['id_province']         = !empty($data) ? $data['id_province'] : '';
                $row['id_regency']          = !empty($data) ? $data['id_regency'] : '';
                $result = array('status' => 'RC200', 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = escape($this->input->post('tokenId', TRUE));
            if(!empty($session) AND !empty($contId)) {
                if($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mIzin->updateData();
                    if($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, karena data tidak ditemukan'), 'csrfHash' => $csrfHash);
                    } else if($data['response'] == 'ERRDATA') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data dengan nik '.$data['nama'].' gagal, karena ditemukan nama yang sama'), 'csrfHash' => $csrfHash);
                    } else if($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses update data dengan nik '.$data['nama'].' sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = escape($this->input->post('tokenId', TRUE));
            if(!empty($session) AND !empty($contId)) {
                $data = $this->mIzin->deleteData();
                if($data['response'] == 'ERROR') {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
                } else if($data['response'] == 'ERRDATA') {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data dengan nik '.$data['nama'].' gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
                } else if($data['response'] == 'SUCCESS') {
                    $result = array('status' => 'RC200', 'message' => 'Proses delete data dengan nik '.$data['nama'].' sukses', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data gagal, mohon coba kembali', 'csrfHash' => $csrfHash);
            }
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
        ini_set('memory_limit', '-1');
        $this->load->model('model_perizinan', 'mIzin');
        include APPPATH . 'third_party/PHPExcel.php';
        $create_by   	= $this->app_loader->current_account();
        $create_date 	= gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $create_ip   	= $this->input->ip_address();
        $csrfHash 		= $this->security->get_csrf_hash();
        $namafile  		= $_FILES['file_name']['name'];
        $lokasi    		= $_FILES['file_name']['tmp_name'];

        $id_pelatihan = $this->input->post('id_pelatihan_import', TRUE);

        $id_opd         = 0;
        if ($this->app_loader->is_admin()) {
            $id_opd = $this->app_loader->current_opdid();
        }

        $parted_name    = explode('.', $namafile);
        $extension      = end($parted_name);
        $newname        = 'import_perizinan_' . $id_opd .'_' . $id_pelatihan .'_'.gmdate('YmdHis', time() + 60 * 60 * 7).'-'.uniqid().'.'.$extension;

        move_uploaded_file($lokasi, './repository/temporary/perizinan/' . $newname);
        $excelreader     	= new PHPExcel_Reader_Excel2007();
        $spreadsheet 		= $excelreader->load('repository/temporary/perizinan/' . $newname);
        $sheetdata 			= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $url_file       = base_url('/repository/temporary/perizinan/'.$newname);
		
        $dataArray      = array();
        $dataImported   = array();
        $dataPerizinan  = array();
        
        $numrow = 1;
        foreach ($sheetdata as $row) {
            if ($numrow > 2) { // kalau row ke satu di excel adalah nama th table
                $nikPerizinan = array();
                //regex nik
                $nik = isset($row['A']) ? trim($row['A']) : '';
                $nik_regex = '/^[0-9]{16}$/';
                if(preg_match($nik_regex, $nik)){
                    $nikPerizinan = $this->mIzin->get_nik_existance($nik);
                }
                
                /** Jika nik belum terdaftar dan NIK sudah sesuai format */
                if(empty($nikPerizinan) AND $nik != '' AND preg_match($nik_regex, $nik)){
                    $this->db->trans_begin();

                    $email = $row['I'] ? $row['I'] : '';
                    $user = $this->mIzin->get_user_existance($email);
                    /** Jika username sudah ada maka generate email random */
                    if(!empty($user)){
                        $email = uniqid() . '_' . time() . '@mail.com';
                    } else if (empty($email)) {
                        $email = uniqid() . '_' . time() . '@mail.com';
                    }

                    $regency = $row['D'] ? $row['D'] : '';
                    $id_regency = explode(' - ',$regency)[0];

                    $jenis_kegiatan     = $row['G'] ? $row['G'] : '';
                    $id_jenis_kegiatan  = $jenis_kegiatan == '' ? 2 : explode(' - ',$jenis_kegiatan)[0] ;

                    $dataPerizinan = array(
                        'nik'               => $nik,
                        'no_nib'            => $row['B'] ? $row['B'] : '',
                        'nama'              => $row['C'] ? $row['C'] : '',
                        'id_province'       => '13',
                        'id_regency'        => $id_regency,
                        'alamat'            => $row['E'] ? $row['E'] : '',
                        'no_hp'             => $row['F'] ? $row['F'] : '',
                        'npwp'              => $row['H'] ? $row['H'] : '',
                        'email'             => $email,
                        'id_opd'            => $id_opd,
                        'id_jenis_kegiatan' => $id_jenis_kegiatan,
                        'id_pelatihan'      => $id_pelatihan,
                        'file_url'          => $url_file,
                        'create_by'         => $create_by,
                        'create_date'       => $create_date,
                        'create_ip'         => $create_ip,
                        'mod_by'            => $create_by,
                        'mod_date'          => $create_date,
                        'mod_ip'            => $create_ip,
                    );

                    $dataArray[] = $dataPerizinan;

                    $this->db->insert('data_perizinan', $dataPerizinan);
                    if ($this->db->trans_status() === FALSE)
                    {
                        $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "failed");
                        $this->db->trans_rollback();
                    }
                    else
                    {
                        $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "success");
                        $this->db->trans_commit();
                    }
                } else{
                    if(!preg_match($nik_regex, $nik)){
                        $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "invalid");
                    } else {
                        //cek history pelatihan
                        $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "existed");
                    }
                }
            }
            $numrow++;
        }
        // print_r([
        //     "dataArray" => $dataArray,
        //     "dataImported" => $dataImported,
        //     "post" => $this->input->post()
        // ]); die;
        if(count($dataImported) > 0)
        {
            $result = array('status' => 'RC200', 'message' => 'Proses import data sukses', 'data' => $dataImported, 'csrfHash' => $csrfHash);
        }else{
            $result = array('status' => 'RC404', 'message' => 'Proses import data gagal', 'data' => $dataImported,  'csrfHash' => $csrfHash);
        }

        // print_r($cek);die;
        $this->output->set_content_type('application/json')->set_output(json_encode($result));  

    }
}

// This is the end of fungsi class
