<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of kontrol class
 *
 * @author Yogi "solop" Kaputra
 */

class Pelatihan extends SLP_Controller
{
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_pelatihan' => 'mpelatihan', 'master/model_master' => 'mmas', 'data/model_syarat_tambahan' => 'mSyaratTambah'));
        $this->_vwName = 'vpelatihan';
        $this->_uriName = 'data/pelatihan';
    }

    private function validasiDataValue()
    {
        $this->form_validation->set_rules('id_jadwal', 'Kategori Pelatihan', 'required|trim');
        $this->form_validation->set_rules('id_sumber', 'Kategori Pelatihan', 'required|trim');
        $this->form_validation->set_rules('kuota', 'Kuota', 'required|trim');
        $this->form_validation->set_rules('id_metode_pelatihan', 'Metode Pelatihan', 'required|trim');
        $this->form_validation->set_rules('syarat_id[]', 'Syarat Pelatihan', 'required|trim');
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
        $this->breadcrumb->add('Pelatihan', site_url($this->_uriName));
        $this->session_info['page_name']                = 'Data Pelatihan';
        $this->session_info['siteUri']                  = $this->_uriName;
        $this->session_info['page_css']                    = $this->load->view($this->_vwName . '/vcss', array('siteUri' => $this->_uriName), true);
        $this->session_info['page_js']                    = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['data_jadwal']              = $this->mmas->getJadwal();
        $this->session_info['data_syarat']              = $this->mmas->getDataSyarat();
        $this->session_info['data_syarat_dinamis']      = $this->mmas->getDataSyaratTambahan();
        $this->session_info['data_opd']                 = $this->mmas->getOPD();
        $this->session_info['sumber_dana']               = $this->mpelatihan->getDataSD();
        // $this->session_info['show_tabel_syarat']        = $this->mmas->showDataSyaratTambahan();
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
                $dataList = $this->mpelatihan->get_datatables($param);
                $no = $this->input->post('start');
                foreach ($dataList as $key => $dl) {
                    $no++;
                    $tanggal_daftar    = date('Y-m-d');
                    if ($this->app_loader->is_peserta()) {
                        // Bagian Hak Akses Peserta
                        $this->db->where('id_pelatihan', $dl['id_pelatihan']);
                        $qTot = $this->db->count_all_results('data_history_pelatihan');
                        if ($qTot == $dl['kuota']) {
                            $flagKuota = '<a class="text-danger">FULL</a>';
                            $full = 'disabled';
                        } else {
                            $flagKuota = '';
                            $full = '';
                        }
                        $userLogin            = $this->app_loader->current_pesertaid();
                        //Memanggil data peserta pada tabel history pelatihan, apakah sudah mendaftar pada pelatihan atau belum
                        $data_history = $this->mpelatihan->getData_byPesertaPelatihan($dl['id_pelatihan'], $userLogin);
                        $id_peserta = !empty($data_history) ? $data_history['id_peserta'] : 0;
                        $flag_stat = !empty($data_history) ? $data_history['flag'] : 0;
                        $color = ($id_peserta != 0) ? 'btn-danger' : 'btn-cyan';
                        $icon = ($id_peserta != 0) ? 'fas fa-award' : 'fas fa-sign-in-alt';
                        // $flag = ($id_peserta != 0) ? 'fa-spinner fa-spin' : 'fa-eye';
                        $this->db->where('id_pelatihan', $dl['id_pelatihan']);
                        $qTot = $this->db->count_all_results('data_history_pelatihan');
                        if ($qTot == $dl['kuota']) {
                            $flagKuota = '<a class="text-danger">FULL</a>';
                            $full = 'disabled';
                        } else {
                            $flagKuota = '';
                            $full = '';
                        }

                        if ($tanggal_daftar < $dl['mulai_registrasi']) {
                            $validasi = '1';
                            $flagRegistrasi = '1';
                            $status_pelatihan = convert_statpel($flagRegistrasi);
                        } else if ($tanggal_daftar > $dl['akhir_registrasi']) {
                            $validasi = '2';
                            $flagRegistrasi = '2';
                            $status_pelatihan = convert_statpel($flagRegistrasi);
                        } else if (($tanggal_daftar >= $dl['mulai_registrasi']) && ($tanggal_daftar <= $dl['akhir_registrasi'])) {
                            $validasi = '3';
                            $flagRegistrasi = '3';
                            $status_pelatihan = convert_statpel($flagRegistrasi);
                        }

                        if ($flag_stat == '1') {
                            $get            = '';
                            $title          = "Daftar";
                            $flagHistory    = '1';
                            $status_history = convert_flag($flagHistory);
                        } else if ($flag_stat == '2') {
                            $get            = 'disabled';
                            $title          = "Diterima";
                            $flagHistory    = '2';
                            $status_history = convert_flag($flagHistory);
                        } else if ($flag_stat == '3') {
                            $get            = 'disabled';
                            $title          = "Ditolak";
                            $flagHistory    = '3';
                            $status_history = convert_flag($flagHistory);
                        } else if ($flag_stat == '4') {
                            $get            = 'disabled';
                            $title          = "Selesai";
                            $flagHistory    = '4';
                            $status_history = convert_flag($flagHistory);
                        } else {
                            $get            = '';
                            $title          = "Detail";
                            $status_history = '';
                        }

                        $judul_show = '<ul class="list-unstyled" style="margin-bottom:0px;">' .
                            '<li><h4><strong>' . $dl['nm_pelatihan'] . '</strong></h4></li>' .
                            '<li><i class="fas fa-map-marker-alt"></i> <strong>' . $dl['tempat_pelatihan'] . '</strong></li>' .
                            '<li><i class="fas fa-clock"></i> Registrasi : <strong class="text-success">' . tgl_indo($dl['mulai_registrasi']) . '</strong> - <strong class="text-danger">' . tgl_indo($dl['akhir_registrasi']) . '</strong> &nbsp;&nbsp; <i class="fas fa-users"></i> Kuota : <strong class="text-info">' . $dl['kuota'] . ' ' . $flagKuota . '</strong></li>' .
                            '<li><strong>' . convert_metodepel_badge($dl['id_metode_pelatihan']) . '</strong> ' . $status_pelatihan . '</li>' .
                            '</ul>';

                        $button = '<button type="button" class="btn ' . $color . ' btnShow" ' . $get . ' ' . $full . ' data-id="' . $dl['token'] . '" data-pe="' . $dl['id_pelatihan'] . '" data-vl="' . $validasi . '"><i class="' . $icon . '"> ' . $title . '</i></button>';
                        // Tutup Bagian Peserta DigitalTalent
                    } else {
                        // Bagian Admin Super dan Admin DigitalTalent
                        $this->db->where('id_pelatihan', $dl['id_pelatihan']);
                        $qTot = $this->db->count_all_results('data_history_pelatihan');
                        if ($qTot == $dl['kuota']) {
                            $flagKuota = '<a class="text-danger">FULL</a>';
                            $full = 'disabled';
                        } else {
                            $flagKuota = '';
                            $full = '';
                        }

                        $data_history = $this->mpelatihan->getData_History($dl['id_pelatihan']);
                        $id_peserta = !empty($data_history) ? $data_history['id_peserta'] : 0;
                        $stat_view = ($id_peserta != 0) ? 'btn-danger' : 'btn-cyan';

                        $judul_show = '<ul class="list-unstyled" style="margin-bottom:0px;">' .
                            '<li><h4><strong>' . $dl['nm_pelatihan'] . '</strong></h4></li>' .
                            '<li><i class="fas fa-map-marker-alt"></i> <strong>' . $dl['tempat_pelatihan'] . '</strong></li>' .
                            '<li><i class="fas fa-clock"></i> Registrasi : <strong class="text-success">' . tgl_indo($dl['mulai_registrasi']) . '</strong> - <strong class="text-danger">' . tgl_indo($dl['akhir_registrasi']) . '</strong></li>' .
                            '<li><i class="fas fa-clock"></i> Pelatihan : <strong class="text-success">' . tgl_indo($dl['tanggal_pelatihan']) . '</strong> -  <strong class="text-danger">' . tgl_indo($dl['tanggal_pelatihan_akhir']) . '</strong> <br> <i class="fas fa-users"></i> Kuota : <strong class="text-info">' . $dl['kuota'] . ' ' . $flagKuota . '</strong></li>' .
                            '<li><i class="fas fa-building"></i><strong> ' . strtoupper($dl['nama_opd']) . '</strong></li>' .
                            '<li><strong>' . convert_metodepel_badge($dl['id_metode_pelatihan']) . '</strong></li>' .
                            '</ul>';

                        $button = '<button type="button" class="btn btn-orange btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnEdit" data-id="' . $dl['token'] . '" title="Edit data"><i class="fas fa-pencil-alt"></i></button>';

                        $button .= '<button type="button" class="btn btn-danger btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnDelete" data-id="' . $dl['token'] . '" title="Hapus data"><i class="fas fa-trash-alt"></i></button>';

                        $button .= '<button type="button" class="btn ' . $stat_view . ' btn-sm waves-effect px-4 py-1 waves-light btnListPeserta" data-id="' . $this->encryption->encrypt($dl['id_pelatihan']) . '" data-jd="' . $dl['nm_pelatihan'] . '" title="List Pendaftar"><i class="fas fa-eye"></i></button>';

                        if ($this->app_loader->is_super()) {
                            $button .= '<button type="button" class="btn btn-warning btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnImport" 
                            data-id="' . $dl['id_pelatihan'] . '" 
                            data-opd="' . $dl['id_opd'] . '" 
                            data-regis="' . $dl['tanggal_pelatihan'] . '"
                            data-title="' . $dl['nm_pelatihan'] . '" 
                            data-schedule="' . tgl_indo($dl['mulai_registrasi']) . ' - ' . tgl_indo($dl['akhir_registrasi']) . '"
                            title="Import data">
                            <i class="fas fa-upload"></i>
                            <br /> Import Data Peserta
                            </button>';
                        }
                    }
                    //<button type="button" class="btn btn-warning waves-effect waves-light px-2 py-1 my-0 mx-0 font-weight-bold btnImport"><i class="fas fa-plus-circle"></i> Import Excel</button>-->

                    $row = array();
                    $row[] = $no;
                    $row[] = $judul_show;
                    $row[] = $dl['nm_jenis_kegiatan'];
                    if ($this->app_loader->is_peserta()) {
                        $row[] = $status_history;
                    } else {
                        $row[] = convert_status($dl['id_status']);
                    }
                    $row[] = $button;
                    $row[] = $dl['id_pelatihan'];
                    $data[] = $row;
                }
                // var_dump($data);
                // die;
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mpelatihan->count_all(),
                    "recordsFiltered" => $this->mpelatihan->count_filtered($param),
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
            if (!empty($session)) {
                if ($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mpelatihan->insertDataPelatihan();
                    if ($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data pelatihan baru gagal, karena ditemukan jadwal yang sama'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses insert data pelatihan baru sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data pelatihan baru gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
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
            $contId   = $this->input->post('token', TRUE);
            $flag     = $this->input->post('flag', TRUE);
            if (!empty($contId) and !empty($session)) {
                $dataUpdate     = $this->mpelatihan->getDataDetailPelatihan($contId);
                $dataDinamis    = $this->mpelatihan->getDataViewDinamis($contId);
                $dataShow       = $this->mpelatihan->getDataDetailShow($contId);
                // $id_pelatihan              = !empty($dataShow) ? $dataShow['id_pelatihan'] : '';

                $row = array();
                if (!empty($flag)) {
                    $row['id_jadwal']            = !empty($dataUpdate) ? $dataUpdate['id_jadwal'] : '';
                    $row['id_sumber']            = !empty($dataUpdate) ? $dataUpdate['id_sumber'] : '';
                    $row['id_metode_pelatihan']    = !empty($dataUpdate) ? $dataUpdate['id_metode_pelatihan'] : '';
                    $row['keterangan']            = !empty($dataUpdate) ? $dataUpdate['keterangan'] : '';
                    $row['kuota']                = !empty($dataUpdate) ? $dataUpdate['kuota'] : '';
                    $row['tempat_pelatihan']    = !empty($dataUpdate) ? $dataUpdate['tempat_pelatihan'] : '';
                    $row['upload_brosur']        = !empty($dataUpdate) ? $dataUpdate['upload_brosur'] : '';
                    $row['status']                = !empty($dataUpdate) ? $dataUpdate['id_status'] : 1;
                    $row['syarat_id']            = !empty($dataUpdate) ? explode(',', str_replace(' ', '', $dataUpdate['group_syarat'])) : array();
                    $row['syarat_dinamis_id']    = !empty($dataDinamis) ? explode(',', str_replace(' ', '', $dataDinamis['group_syarat_dinamis'])) : array();
                } else {
                    $row['nm_pelatihan']        = !empty($dataShow) ? $dataShow['nm_pelatihan'] : '';
                    $row['id_jadwal']            = !empty($dataShow) ? $dataShow['id_jadwal'] : '';
                    $row['id_sumber']            = !empty($dataShow) ? $dataShow['id_sumber'] : '';
                    $row['id_kat_urusan']        = !empty($dataShow) ? $dataShow['id_kat_urusan'] : '';
                    $row['id_metode_pelatihan']    = !empty($dataShow) ? convert_metodepel_text($dataShow['id_metode_pelatihan']) : '';
                    $row['keterangan']            = !empty($dataShow) ? $dataShow['keterangan'] : '';
                    $row['mulai_registrasi']    = !empty($dataShow) ? tgl_indo($dataShow['mulai_registrasi']) : '';
                    $row['akhir_registrasi']    = !empty($dataShow) ? tgl_indo($dataShow['akhir_registrasi']) : '';
                    $row['kuota']                = !empty($dataShow) ? $dataShow['kuota'] : '';
                    $row['tempat_pelatihan']    = !empty($dataShow) ? $dataShow['tempat_pelatihan'] : '';
                    $row['tanggal_pelatihan']    = !empty($dataShow) ? $dataShow['tanggal_pelatihan'] : '';
                    $row['upload_brosur']        = !empty($dataShow) ? $dataShow['upload_brosur'] : '';
                    $row['status']                = !empty($dataShow) ? $dataShow['id_status'] : 1;

                    // $dataSyarat = $this->mpelatihan->cekSyarat($dataShow['group_syarat']);
                    // Syarat Pelatihan
                    $dataSyarat = $this->mpelatihan->getDataSyarat($dataShow['id_pelatihan']);
                    $row['syarat']            = !empty($dataSyarat) ? $dataSyarat : array();

                    // Syarat Tambahan
                    $dataSyaratTambahan = $this->mpelatihan->getDataSyaratTambahan($dataShow['id_pelatihan']);
                    $row['syarat_dinamis']    = !empty($dataSyaratTambahan) ? $dataSyaratTambahan : null;
                }

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
            $modId    = escape($this->input->post('tokenId', TRUE));
            if (!empty($session) and !empty($modId)) {
                if ($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mpelatihan->updateDataPelatihan();
                    if ($data['response'] == 'NODATA') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data pelatihan gagal, karena data tidak ditemukan'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses update data pelatihan sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = escape($this->input->post('tokenId', TRUE));
            if (!empty($session) and !empty($contId)) {
                $data = $this->mpelatihan->deleteDataPelatihan();
                if ($data['response'] == 'ERROR') {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data pelatihan gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
                } else if ($data['response'] == 'ERRDATA') {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data pelatihan gagal, karena sudah ada peserta pelatihan', 'csrfHash' => $csrfHash);
                } else if ($data['response'] == 'SUCCESS') {
                    $result = array('status' => 'RC200', 'message' => 'Proses delete data pelatihan sukses', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data pelatihan gagal, mohon coba kembali', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }


    public function views()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = $this->input->post('jadwal_id', TRUE);
            if (!empty($contId) and !empty($session)) {
                $data = $this->mmas->getDataJadwal($contId);

                $row = array();
                $row['nm_pelatihan']        = !empty($data) ? $data['nm_pelatihan'] : '';
                $row['nm_jenis_kegiatan']    = !empty($data) ? $data['nm_jenis_kegiatan'] : '';
                $row['tanggal_pelatihan']    = !empty($data) ? tgl_indo($data['tanggal_pelatihan']) : '';
                $row['daterange']            = !empty($data) ? tgl_indo($data['mulai_registrasi']) . ' - ' . tgl_indo($data['akhir_registrasi']) : '';
                $row['tempat_pelatihan']    = !empty($data) ? $data['tempat_pelatihan'] : '';
                $row['pagu_anggaran']        = !empty($data) ? $data['pagu_anggaran'] : '';
                $row['nm_sub_kegiatan']        = !empty($data) ? $data['nm_sub_kegiatan'] : '';

                $result = array('status' => 'RC200', 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function review()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $id_peserta     = $this->input->post('tokenPeserta', TRUE);
            $token          = $this->input->post('tokenPelatihan', TRUE);
            if (!empty($id_peserta) and !empty($session)) {
                $data_peserta   = $this->mpelatihan->getDataDetailPeserta($id_peserta);
                $data_usaha     = $this->mpelatihan->getDataUsaha($id_peserta);
                $dataShow       = $this->mpelatihan->getDataDetailShow($token);

                $row = array();
                $row['nik']             = !empty($data_peserta) ? $data_peserta['nik'] : '';
                $row['nama_lengkap']    = !empty($data_peserta) ? $data_peserta['nama_lengkap'] : '';
                $row['tempat_lhr']      = !empty($data_peserta) ? $data_peserta['tempat_lhr'] : '';
                $row['tanggal_lhr']     = !empty($data_peserta) ? $data_peserta['tanggal_lhr'] : '';
                $row['alamat_peserta']  = !empty($data_peserta) ? $data_peserta['alamat_peserta'] : '';
                $row['id_study']        = !empty($data_peserta) ? pendidikan($data_peserta['id_study']) : '';
                $row['id_agama']        = !empty($data_peserta) ? agama($data_peserta['id_agama']) : '';
                $row['id_gender']       = !empty($data_peserta) ? jenis_kelamin($data_peserta['id_gender']) : '';
                $row['id_province']     = !empty($data_peserta) ? $data_peserta['id_province'] : '';
                $row['id_regency']      = !empty($data_peserta) ? $data_peserta['id_regency'] : '';
                $row['pekerjaan']       = !empty($data_peserta) ? $data_peserta['pekerjaan'] : '';
                $row['id_jenis_akun']   = !empty($data_peserta) ? $data_peserta['id_jenis_akun'] : '';
                $row['minat_usaha']     = !empty($data_peserta) ? $data_peserta['minat_usaha'] : '';
                $row['kode_pos']        = !empty($data_peserta) ? $data_peserta['kode_pos'] : '';
                $row['upload_foto']     = !empty($data_peserta) ? $data_peserta['upload_foto'] : '';


                $row['nama_pemilik']        = !empty($data_usaha) ? $data_usaha['nama_pemilik'] : '';
                $row['nama_usaha']          = !empty($data_usaha) ? $data_usaha['nama_usaha'] : '';
                $row['alamat_usaha']        = !empty($data_usaha) ? $data_usaha['alamat_usaha'] : '';
                $row['telp']                = !empty($data_usaha) ? $data_usaha['telp'] : '';
                $row['wa']                  = !empty($data_usaha) ? $data_usaha['wa'] : '';
                $row['id_bidang_usaha']     = !empty($data_usaha) ? $data_usaha['id_bidang_usaha'] : '';
                $row['jenis_usaha']         = !empty($data_usaha) ? $data_usaha['jenis_usaha'] : '';

                // Syarat Tambahan
                $dataSyaratTambahan = $this->mpelatihan->getDataSyaratTambahanPeserta($dataShow['id_pelatihan'], $data_peserta['id_peserta']);
                $row['syarat_dinamis']    = !empty($dataSyaratTambahan) ? $dataSyaratTambahan : array();

                $result = array('status' => 'RC200', 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }


    public function daftar()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $tahun      = gmdate('Y');
            $session    = $this->app_loader->current_account();
            $csrfHash   = $this->security->get_csrf_hash();
            $userLogin  = $this->app_loader->current_pesertaid();
            $contId     = escape($this->input->post('tokenView', TRUE));
            $pelaId     = escape($this->input->post('pelatihanId', TRUE));
            $status     = escape($this->input->post('statusId', TRUE));
            $fields     = escape($this->input->post('fields', TRUE));

            $this->db->where('id_peserta', $userLogin);
            $this->db->where('tahun', $tahun);
            $checkPelatihan = $this->db->count_all_results('data_history_pelatihan');

            if (!empty($session) and !empty($contId) and !empty($pelaId) and !empty($status)) {
                if ($status == 1) {
                    $result = array('status' => 'RC404', 'message' => 'Proses mendaftar pelatihan gagal, karena saat ini registrasi belum dibuka', 'csrfHash' => $csrfHash);
                } else if ($status == 2) {
                    $result = array('status' => 'RC404', 'message' => 'Proses mendaftar pelatihan gagal, tanggal registrasi telah tutup', 'csrfHash' => $csrfHash);
                } else if ($checkPelatihan > 0) {
                    $result = array('status' => 'RC404', 'message' => 'Proses mendaftar pelatihan gagal, anda sudah pernah mengikuti pelatihan pada tahun ini silahkan menunggu tahun depan', 'csrfHash' => $csrfHash);
                } else {
                    foreach ($fields as $field) {
                        if ($field == null || $field == "") {
                            $result = array('status' => 'RC404', 'message' => 'Proses mendaftar gagal, data syarat masih ada yang kosong', 'csrfHash' => $csrfHash);
                            return $this->output->set_content_type('application/json')->set_output(json_encode($result));
                        }
                    };
                    // Check rules syarat dinamis apakah pelatihan ada pada tabel atau tidak
                    $this->db->where('id_pelatihan', $pelaId);
                    $this->db->where('id_status', 1);
                    $checkSyarat = $this->db->count_all_results('data_rules_syarat_dinamis');
                    if ($checkSyarat > 0) {
                        $data = $this->mpelatihan->daftarPelatihan_upload($fields);
                    } else {
                        $data = $this->mpelatihan->daftarPelatihan_noupload($fields);
                    }

                    if ($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => 'Proses mendaftar gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'ERRDATA') {
                        $result = array('status' => 'RC404', 'message' => 'Proses mendaftar pelatihan gagal, karena saat ini anda sudah terdaftar pada pelatihan ini', 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'UPLOAD_FAILED') {
                        $result = array('status' => 'RC404', 'message' => 'Proses pendaftaran tidak berhasil, ada file berkas yang masih kurang', 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'FILE_ERROR') {
                        $result = array('status' => 'RC404', 'message' => 'Upload file gagal, file tidak sesuai format', 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses mendaftar berhasil', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses mendaftar gagal, mohon coba kembali', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function list_pendaftar($name = null)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($name == 'set-flag')
                $this->listUpdate();
            else
                $this->listData();
        }
    }

    private function listData()
    {
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        $pelatihanId = $this->encryption->decrypt(escape($this->input->get('tokenPelatihan', TRUE)));
        if (!empty($pelatihanId) and !empty($session)) {
            $data = $this->mpelatihan->getDataListPendaftar($pelatihanId);
            $pelatihan = array();
            foreach ($data as $q) {
                $isi['id_history_pelatihan']     = $this->encryption->encrypt($q['id_history_pelatihan']);
                $isi['token']                     = $q['token'];
                $isi['id_peserta']                 = $q['id_peserta'];
                $isi['nik']                     = $q['nik'];
                $isi['nama_lengkap']             = $q['nama_lengkap'];
                $isi['province']                 = province($q['id_province']);
                $isi['regency']                 = regency($q['id_regency']);
                $isi['flag']                     = convert_flag($q['flag']);
                $pelatihan[$q['nm_pelatihan']][] = $isi;
            }
            $result = array('status' => 'RC200', 'message' => $pelatihan, 'csrfHash' => $csrfHash);
        } else {
            $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    private function listUpdate()
    {
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        $modId    = escape($this->input->post('tokenId', TRUE));
        $flag     = $this->encryption->decrypt(escape($this->input->post('flag', TRUE)));
        if (!empty($session) and !empty($modId)) {
            $data = $this->mpelatihan->updateDataStatusPesertaPelatihan();
            if ($data['response'] == 'ERROR') {
                $result = array('status' => 'RC404', 'message' => 'Proses ' . (($flag == 'TL') ? 'tolak' : 'update status') . ' data peserta gagal, karena data tidak ditemukan', 'kode' => $modId, 'csrfHash' => $csrfHash);
            } else if ($data['response'] == 'SUCCESS') {
                $result = array('status' => 'RC200', 'message' => 'Proses ' . (($flag == 'TL') ? 'tolak' : 'update status') . ' data peserta dari pelatihan ' . $data['nama'] . ' sukses', 'kode' => $modId, 'csrfHash' => $csrfHash);
            }
        } else {
            $result = array('status' => 'RC404', 'message' => 'Proses ' . (($flag == 'TL') ? 'tolak' : 'update status') . ' data peserta gagal, mohon coba kembali', 'kode' => $modId, 'csrfHash' => $csrfHash);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function list_syarat()
    {
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        if (!empty($session)) {
            $data = $this->mmas->showDataSyaratTambahan();
            $pelatihan = array();
            foreach ($data as $q) {
                $isi['nm_syarat_dinamis']                     = $q['nm_syarat_dinamis'];
                $isi['id_syarat_dinamis']                   = $q['id_syarat_dinamis'];
                $pelatihan[$q['nm_syarat_dinamis']] = $isi;
            }
            $result = array('status' => 'RC200', 'message' => $pelatihan, 'csrfHash' => $csrfHash);
        } else {
            $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function add_syarat()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            if (!empty($session)) {
                $data = $this->mSyaratTambah->insertData();
                if ($data['response'] == 'ERROR') {
                    $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data baru dengan nama ' . $data['nama'] . ' gagal, karena ditemukan nama yang sama'), 'csrfHash' => $csrfHash);
                } else if ($data['response'] == 'SUCCESS') {
                    $result = array('status' => 'RC200', 'message' => 'Proses insert data baru dengan nama ' . $data['nama'] . ' sukses', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data baru gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }


    public function import_excel()
    { 
        $this->load->model('model_peserta', 'mpeserta');
        include APPPATH . 'third_party/PHPExcel.php';
        $create_by   	= $this->app_loader->current_account();
        $create_date 	= gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $create_ip   	= $this->input->ip_address();
        $csrfHash 		= $this->security->get_csrf_hash();
        $namafile  		= $_FILES['file_name']['name'];
        $lokasi    		= $_FILES['file_name']['tmp_name'];

        $id_pelatihan = $this->input->post('id_pelatihan', TRUE);
        $id_opd = $this->input->post('id_opd', TRUE);

        $tgl_regis = $this->input->post('regis', TRUE);
        $tahun_regis = substr($tgl_regis, 0, 4);
        $flag = 2;
        $id_status = 1;

        $parted_name    = explode('.', $namafile);
        $extension      = end($parted_name);
        $newname        = 'import_peserta_' . $id_pelatihan .'_'.gmdate('YmdHis', time() + 60 * 60 * 7).'-'.uniqid().'.'.$extension;

        move_uploaded_file($lokasi, './repository/temporary/' . $newname);
        $excelreader     	= new PHPExcel_Reader_Excel2007();
        $spreadsheet 		= $excelreader->load('repository/temporary/' . $newname);
        $sheetdata 			= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        
		
        $dataPesertas = array();
        $dataUsers = array();
        $dataImported = array();
		
        $dataPeserta = array();
        $dataUser = array();
        $rawPass = 'Asdf@1234';
        $password = '$2a$12$ltvQiUuRMOW9JFA5wBxOgOoqeA1jUgqm7k44rinA.eildmoHRIy1.';
        
        $numrow = 1;
        foreach ($sheetdata as $row) {
            if ($numrow > 2) { // kalau row ke satu di excel adalah nama th table

                // if($row['A'] == '' AND $row['B'] == '' AND $row['C'] == '' AND $row['D'] == '' AND $row['E'] == '' AND $row['F'] == '' AND $row['G'] == '')
                // {
                //     break;
                // }
                $peserta = array();
                
                //regex nik
                $nik = isset($row['A']) ? trim($row['A']) : '';
                $nik_regex = '/^[0-9]{16}$/';
                if(preg_match($nik_regex, $nik)){
                    $peserta = $this->mpeserta->get_nik_existance($nik);
                }
                
                /** Jika nik belum terdaftar dan NIK sudah sesuai format */
                if(empty($peserta) AND $nik != '' AND preg_match($nik_regex, $nik)){
                    $this->db->trans_begin();

                    $token = generateToken($row['A'], $row['B']);
                    $email = $row['M'] ? $row['M'] : '';
                    $user = $this->mpeserta->get_user_existance($email);
                    /** Jika username sudah ada maka generate email random */
                    if(!empty($user)){
                        $email = uniqid() . '_' . time() . '@mail.com';
                    }

                    // $gender = $row['E'] ? $row['E'] : '';
                    // $id_gender = strtolower($gender) == 'perempuan' ? 2 : 1;
                    $gender = $row['E'] ? $row['E'] : '';
                    $id_gender = explode(' - ',$gender)[0];

                    $regency = $row['F'] ? $row['F'] : '';
                    $id_regency = explode(' - ',$regency)[0];
                    
                    $study = $row['I'] ? $row['I'] : '';
                    $id_study = explode(' - ',$study)[0];

                    $agama = $row['J'] ? $row['J'] : '';
                    $id_agama = explode(' - ',$agama)[0];

                    $jenis_akun = $row['J'] ? $row['J'] : '';
                    $id_jenis_akun = $jenis_akun == '' ? 2 : explode(' - ',$jenis_akun)[0] ;


                    $dataPeserta = array(
                        'token'		 	    => $token,
                        'nik'               => $nik,
                        'nama_lengkap'      => $row['B'] ? $row['B'] : '',
                        'tanggal_lhr '  	=> $row['C'] ? $this->convertDate($row['C']) : '',
                        'tempat_lhr'        => $row['D'] ? $row['D'] : '',
                        'id_gender'         => $id_gender,
                        'id_province'       => '13',
                        'id_regency'        => $id_regency,
                        'alamat_peserta'    => $row['G'] ? $row['G'] : '',
                        'kode_pos'          => $row['H'] ? $row['H'] : '',
                        'id_study'          => $id_study,
                        'id_agama'          => $id_agama,
                        'pekerjaan'         => $row['K'] ? $row['K'] : '',
                        'no_hp'             => $row['N'] ? $row['N'] : '',
                        'id_jenis_akun'     => $id_jenis_akun,
                        'create_by'         => $create_by,
                        'create_date'       => $create_date,
                        'create_ip'         => $create_ip,
                        'mod_by'            => $create_by,
                        'mod_date'          => $create_date,
                        'mod_ip'            => $create_ip,
                    );

                    $dataPesertas[] = $dataPeserta;

                    $this->db->insert('data_peserta', $dataPeserta);
                    $id_peserta = $this->db->insert_id();

                    $dataUser = array(
                        'token'		 	    => $token,
                        'username'          => $email,
                        'password'          => $password,
                        'email '  	        => $email,
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
                    $dataUsers[] = $dataUser;



                    $this->db->insert('xi_sa_users', $dataUser);
                    $id_users = $this->db->insert_id();

                    $this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $rawPass, 'updated' => 'N'));
                    /*query insert user group privileges*/
                    $this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => '9', 'id_status' => 1));

                    $history = $this->mpelatihan->getData_byPesertaPelatihan($id_pelatihan, $id_peserta,$tahun_regis);
                    if(empty($history)){
                        $this->db->insert('data_history_pelatihan', 
                                        array(
                                            'id_peserta'        => $id_peserta, 
                                            'id_pelatihan'      => $id_pelatihan, 
                                            'id_opd'            => $id_opd, 
                                            'tanggal_daftar'    => $tgl_regis,
                                            'tahun'             => $tahun_regis,
                                            'flag'              => $flag, 
                                            'id_status'         => $id_status, 
                                            )
                                        );
                    }
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
                }
                else{
                    if(!preg_match($nik_regex, $nik)){
                        $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "invalid");
                    }
                    else{
                        //cek history pelatihan
                        $history = $this->mpelatihan->getData_byPesertaPelatihan($id_pelatihan, $peserta['id_peserta'],$tahun_regis);
                        if(empty($history)){
                            $this->db->insert('data_history_pelatihan', 
                                            array(
                                                'id_peserta'        => $peserta['id_peserta'], 
                                                'id_pelatihan'      => $id_pelatihan, 
                                                'id_opd'            => $id_opd, 
                                                'tanggal_daftar'    => $tgl_regis,
                                                'tahun'             => $tahun_regis,
                                                'flag'              => $flag, 
                                                'id_status'         => $id_status, 
                                                )
                                            );
                            $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "success");
                        }
                        else $dataImported[] = array('nik' => $nik, 'nama_lengkap' => $row['B'], 'status' => "existed");


                    }
                }
            }
            $numrow++;
        }
        // print_r([
        //     "dataPesertas" => $dataPesertas,
        //     "dataUsers" => $dataUsers,
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

    private function convertDate($tgl)
    {
        $tgl = explode('-',$tgl);
        if(count($tgl) == 3){
            if($tgl[2] > 1000){
                /** jika format dd-mm-yyyy */
                $formated = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
                
            }
            else if($tgl[0] > 1000){
                /** jika format yyyy-mm-dd */
                $formated = $tgl;
            }
            else{
                /** jika format mm-dd-yy */
                $tanggal = $tgl[1];
                $bulan = $tgl[0];
                $tahun = $tgl[2] > 20 ? '19' . $tgl[2] : '20'.$tgl[2];
                $formated = $tahun . '-' . $bulan . '-' . $tanggal;
            }

            return $formated;
        }
        else{
            return '';
        }
    }
}

// This is the end of fungsi class
