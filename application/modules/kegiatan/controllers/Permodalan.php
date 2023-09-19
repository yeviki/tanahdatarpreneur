<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat class
 *
 * @author Yogi "solop" Kaputra
 */

class Permodalan extends SLP_Controller {
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_permodalan' => 'mPModalan', 'master/model_master' => 'mmas'));
        $this->_vwName = 'vpermodalan';
        $this->_uriName = 'kegiatan/permodalan';
    }

    private function validasiDataValue($id) {
        if ($id == 1) {
            $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
            $this->form_validation->set_rules('id_jenis_kegiatan', 'Jenis Kegiatan', 'required|trim');
            $this->form_validation->set_rules('no_nib', 'No NIB', 'required|trim');
            $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
            $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
            $this->form_validation->set_rules('npwp', 'No NPWP', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('unit_usaha', 'Unit Usaha', 'required|trim');
            $this->form_validation->set_rules('id_bentuk_permodalan', 'Bentuk Permodalan', 'required|trim');
            $this->form_validation->set_rules('tahun_bantuan', 'Tahun Bantuan', 'required|trim');
            $this->form_validation->set_rules('jumlah_uang_diterima', 'Uang Diterima', 'required|trim');
            $this->form_validation->set_rules('unit_pemberi_modal', 'Unit Pemberi Modal', 'required|trim');

            validation_message_setting();
            if($this->form_validation->run() == FALSE)
                return false;
            else
                return true;
        } else {
            $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
            $this->form_validation->set_rules('id_jenis_kegiatan', 'Jenis Kegiatan', 'required|trim');
            $this->form_validation->set_rules('no_nib', 'No NIB', 'required|trim');
            $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
            $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
            $this->form_validation->set_rules('npwp', 'No NPWP', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('unit_usaha', 'Unit Usaha', 'required|trim');
            $this->form_validation->set_rules('id_bentuk_permodalan', 'Bentuk Permodalan', 'required|trim');
            $this->form_validation->set_rules('tahun_bantuan', 'Tahun Bantuan', 'required|trim');
            $this->form_validation->set_rules('opd_pemberi_bantuan', 'OPD Pemberi Bantuan', 'required|trim');
            $this->form_validation->set_rules('sub_kegiatan', 'Sub Kegiatan', 'required|trim');
            $this->form_validation->set_rules('nm_alat', 'Nama Alat', 'required|trim');
            $this->form_validation->set_rules('pemberi_permodalan', 'Pemberi Permodalan', 'required|trim');

            validation_message_setting();
            if($this->form_validation->run() == FALSE)
                return false;
            else
                return true;
        }
    }

    public function index() {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Kegiatan', '#');
        $this->breadcrumb->add('Permodalan', site_url($this->_uriName));
        $this->session_info['page_name']        = 'Permodalan';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['page_js']	        = $this->load->view($this->_vwName.'/vjs', array('siteUri'=>$this->_uriName), true);
        $this->session_info['data_kat']         = $this->mmas->getJenisKegiatan();
        $this->session_info['data_permodalan']  = $this->mmas->getbentuk_permodalan();
        $this->session_info['data_pelatihan']   = $this->mmas->getPelatihan();
        $this->template->build($this->_vwName.'/vpage', $this->session_info);
    }

    public function listview() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $data = array();
            $session = $this->app_loader->current_account();
            if(isset($session)){
                $dataList = $this->mPModalan->get_datatables();
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
                    $row[] = convert_bentuk_permodalan($dl['id_bentuk_permodalan']);
                    $row[] = '<button type="button" class="btn btn-orange btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnEdit" data-id="'.$this->encryption->encrypt($dl['id_permodalan']).'" title="Edit data"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-danger btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnDelete" data-id="'.$this->encryption->encrypt($dl['id_permodalan']).'" title="Hapus data"><i class="fas fa-trash-alt"></i></button>';
                    $data[] = $row;
                }
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mPModalan->count_all(),
                    "recordsFiltered" => $this->mPModalan->count_filtered(),
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
            $session    = $this->app_loader->current_account();
            $csrfHash   = $this->security->get_csrf_hash();
            $id         = $this->input->post('id_bentuk_permodalan', TRUE);
            if(!empty($session)) {
                if($this->validasiDataValue($id) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mPModalan->insertData();
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
                $data = $this->mPModalan->getDataDetail($this->encryption->decrypt($contId));
                $row = array();
                $row['nik']	                    = !empty($data) ? $data['nik'] : '';
                $row['no_nib']	                = !empty($data) ? $data['no_nib'] : '';
                $row['id_pelatihan']	        = !empty($data) ? $data['id_pelatihan'] : '';
                $row['id_jenis_kegiatan']	    = !empty($data) ? $data['id_jenis_kegiatan'] : '';
                $row['nama']	                = !empty($data) ? $data['nama'] : '';
                $row['no_hp']	                = !empty($data) ? $data['no_hp'] : '';
                $row['npwp']	                = !empty($data) ? $data['npwp'] : '';
                $row['email']	                = !empty($data) ? $data['email'] : '';
                $row['unit_usaha']	            = !empty($data) ? $data['unit_usaha'] : '';
                $row['tahun_bantuan']	        = !empty($data) ? $data['tahun_bantuan'] : '';
                $row['jumlah_uang_diterima']	= !empty($data) ? $data['jumlah_uang_diterima'] : '';
                $row['unit_pemberi_modal']	    = !empty($data) ? $data['unit_pemberi_modal'] : '';
                $row['opd_pemberi_bantuan']	    = !empty($data) ? $data['opd_pemberi_bantuan'] : '';
                $row['sub_kegiatan']	        = !empty($data) ? $data['sub_kegiatan'] : '';
                $row['nm_alat']	                = !empty($data) ? $data['nm_alat'] : '';
                $row['pemberi_permodalan']	    = !empty($data) ? $data['pemberi_permodalan'] : '';
                $row['id_bentuk_permodalan']	= !empty($data) ? $data['id_bentuk_permodalan'] : '';
                $row['upload_foto_alat']	    = !empty($data) ? $data['upload_foto_alat'] : '';
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
            $id       = $this->input->post('id_bentuk_permodalan', TRUE);
            if(!empty($session) AND !empty($contId)) {
                if($this->validasiDataValue($id) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mPModalan->updateData();
                    if ($data['response'] == 'NODATA') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data dengan nik ' . $data['nikID'] . ' gagal, karena data tidak ditemukan'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'ERRDATA') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data dengan nik ' . $data['nikID'] . ' gagal, karena sudah ada yang menggunakan nik yang sama'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses update data dengan nik ' . $data['nikID'] . ' sukses', 'csrfHash' => $csrfHash);
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
                $data = $this->mPModalan->deleteData();
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

    public function import_excel()
    { 
        ini_set('memory_limit', '-1');
        $this->load->model('model_permodalan', 'mPModalan');
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
        $newname        = 'import_permodalan_' . $id_opd .'_' . $id_pelatihan .'_'.gmdate('YmdHis', time() + 60 * 60 * 7).'-'.uniqid().'.'.$extension;

        move_uploaded_file($lokasi, './repository/temporary/permodalan/' . $newname);
        $excelreader     	= new PHPExcel_Reader_Excel2007();
        $spreadsheet 		= $excelreader->load('repository/temporary/permodalan/' . $newname);
        $sheetdata 			= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $url_file       = base_url('/repository/temporary/permodalan/'.$newname);
		
        $dataArray      = array();
        $dataImported   = array();
        $dataPermodalan = array();
        
        $numrow = 1;
        foreach ($sheetdata as $row) {
            if ($numrow > 2) { // kalau row ke satu di excel adalah nama th table
                $nikPerizinan = array();
                //regex nik
                $nik = isset($row['A']) ? trim($row['A']) : '';
                $nik_regex = '/^[0-9]{16}$/';
                if(preg_match($nik_regex, $nik)){
                    $nikPerizinan = $this->mPModalan->get_nik_existance($nik);
                }
                
                /** Jika nik belum terdaftar dan NIK sudah sesuai format */
                if(empty($nikPerizinan) AND $nik != '' AND preg_match($nik_regex, $nik)){
                    $this->db->trans_begin();

                    $email = $row['H'] ? $row['H'] : '';
                    $user = $this->mPModalan->get_user_existance($email);
                    /** Jika username sudah ada maka generate email random */
                    if(!empty($user)){
                        $email = uniqid() . '_' . time() . '@mail.com';
                    } else if (empty($email)) {
                        $email = uniqid() . '_' . time() . '@mail.com';
                    }

                    // $regency = $row['D'] ? $row['D'] : '';
                    // $id_regency = explode(' - ',$regency)[0];

                    $bentuk             = $row['J'] ? $row['J'] : '';
                    $bentuk_permodalan  = explode(' - ',$bentuk)[0];

                    $jenis_kegiatan     = $row['F'] ? $row['F'] : '';
                    $id_jenis_kegiatan  = $jenis_kegiatan == '' ? 2 : explode(' - ',$jenis_kegiatan)[0] ;

                    // Jika Bentuk Permodalan Uang
                    if($bentuk_permodalan == 1) {
                        $dataPermodalan = array(
                            'nik'                       => $nik,
                            'no_nib'                    => $row['B'] ? $row['B'] : '',
                            'nama'                      => $row['C'] ? $row['C'] : '',
                            'unit_usaha'                => $row['D'] ? $row['D'] : '',
                            'no_hp'                     => $row['E'] ? $row['E'] : '',
                            'npwp'                      => $row['G'] ? $row['G'] : '',
                            'email'                     => $email,
                            'id_bentuk_permodalan'      => $bentuk_permodalan,
                            'id_jenis_kegiatan'         => $id_jenis_kegiatan,
                            'id_pelatihan'              => $id_pelatihan,
                            'file_url'                  => $url_file,
                            'tahun_bantuan'             => $row['I'] ? $row['I'] : '',
                            'jumlah_uang_diterima'      => $row['K'] ? $row['K'] : '',
                            'unit_pemberi_modal'        => $row['L'] ? $row['L'] : '',
                            'id_opd'                    => $id_opd,
                            'create_by'                 => $create_by,
                            'create_date'               => $create_date,
                            'create_ip'                 => $create_ip,
                            'mod_by'                    => $create_by,
                            'mod_date'                  => $create_date,
                            'mod_ip'                    => $create_ip,
                        );
                    
                    } else {
                        // Jika Bentuk Permodalan Peralatan
                        $dataPermodalan = array(
                            'nik'                       => $nik,
                            'no_nib'                    => $row['B'] ? $row['B'] : '',
                            'nama'                      => $row['C'] ? $row['C'] : '',
                            'unit_usaha'                => $row['D'] ? $row['D'] : '',
                            'no_hp'                     => $row['E'] ? $row['E'] : '',
                            'npwp'                      => $row['G'] ? $row['G'] : '',
                            'email'                     => $email,
                            'id_bentuk_permodalan'      => $bentuk_permodalan,
                            'id_jenis_kegiatan'         => $id_jenis_kegiatan,
                            'id_pelatihan'              => $id_pelatihan,
                            'file_url'                  => $url_file,
                            'tahun_bantuan'             => $row['I'] ? $row['I'] : '',
                            'opd_pemberi_bantuan'       => $row['M'] ? $row['M'] : '',
                            'sub_kegiatan'              => $row['N'] ? $row['N'] : '',
                            'nm_alat'                   => $row['O'] ? $row['O'] : '',
                            'pemberi_permodalan'        => $row['P'] ? $row['P'] : '',
                            'id_opd'                    => $id_opd,
                            'create_by'                 => $create_by,
                            'create_date'               => $create_date,
                            'create_ip'                 => $create_ip,
                            'mod_by'                    => $create_by,
                            'mod_date'                  => $create_date,
                            'mod_ip'                    => $create_ip,
                        );
                    }
                    // $dataPermodalan = array(
                    //     'nik'                       => $nik,
                    //     'no_nib'                    => $row['B'] ? $row['B'] : '',
                    //     'nama'                      => $row['C'] ? $row['C'] : '',
                    //     'unit_usaha'                => $row['D'] ? $row['D'] : '',
                    //     'no_hp'                     => $row['E'] ? $row['E'] : '',
                    //     'npwp'                      => $row['G'] ? $row['G'] : '',
                    //     'tahun_bantuan'             => $row['I'] ? $row['I'] : '',
                    //     'jumlah_uang_diterima'      => $row['K'] ? $row['K'] : '',
                    //     'unit_pemberi_modal'        => $row['L'] ? $row['L'] : '',
                    //     'opd_pemberi_bantuan'       => $row['M'] ? $row['M'] : '',
                    //     'sub_kegiatan'              => $row['N'] ? $row['N'] : '',
                    //     'nm_alat'                   => $row['O'] ? $row['O'] : '',
                    //     'pemberi_permodalan'        => $row['P'] ? $row['P'] : '',
                    //     'email'                     => $email,
                    //     'id_bentuk_permodalan'      => $bentuk_permodalan,
                    //     'id_jenis_kegiatan'         => $id_jenis_kegiatan,
                    //     'id_pelatihan'              => $id_pelatihan,
                    //     'id_opd'                    => 0,
                    //     'file_url'                  => 0,
                    //     'create_by'                 => $create_by,
                    //     'create_date'               => $create_date,
                    //     'create_ip'                 => $create_ip,
                    //     'mod_by'                    => $create_by,
                    //     'mod_date'                  => $create_date,
                    //     'mod_ip'                    => $create_ip,
                    // );

                    $dataArray[] = $dataPermodalan;

                    $this->db->insert('data_permodalan', $dataPermodalan);
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
