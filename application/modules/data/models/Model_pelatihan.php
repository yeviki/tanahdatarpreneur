<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of kontrol model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_pelatihan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataSD()
	{
		$this->db->order_by('id_sumber ASC');
		$this->db->order_by('id_sumber ASC');
		$query = $this->db->get('ref_sumberdana');
		$dd_sumber[''] = 'Pilih Sumber Dana';
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$dd_sumber[$row['id_sumber']] = $row['sumber'];
			}
		}
		return $dd_sumber;
	}

    /*Fungsi Get Data List*/
    var $search = array('d.nm_pelatihan', 'a.id_jadwal', 'b.mulai_registrasi', 'h.nama_opd');
    public function get_datatables($param)
    {
        $this->_get_datatables_query($param);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered($param)
    {
        $this->_get_datatables_query($param);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $date = date('Y-m-d');
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_sumber,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.tanggal_pelatihan_akhir,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           h.sumber
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'left');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->join('ref_sumberdana h', 'h.id_sumber = a.id_sumber', 'left');
        if ($this->app_loader->is_peserta()) {
            $this->db->where('b.akhir_registrasi >=', $date);
        } else if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        return $this->db->count_all_results();
    }

    private function _get_datatables_query($param)
    {
        $post = array();
        if (is_array($param)) {
            foreach ($param as $v) {
                $post[$v['name']] = $v['value'];
            }
        }
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           g.nama_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_sumber,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.tanggal_pelatihan_akhir,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           h.sumber,
                           GROUP_CONCAT(f.nm_syarat ORDER BY a.id_pelatihan ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'left');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'left');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('ms_unit_kerja g', 'a.id_opd = g.id_opd', 'left');
        $this->db->join('ref_sumberdana h', 'h.id_sumber = a.id_sumber', 'left');

        //Tahun
        if (isset($post['filter_tahun']) and $post['filter_tahun'] != '')
            $this->db->where('year(b.tanggal_pelatihan)', $post['filter_tahun']);

        //OPD
        if (isset($post['opd_search']) and $post['opd_search'] != '')
            $this->db->where('a.id_opd', $post['opd_search']);

        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        if ($this->app_loader->is_peserta()) {
            $date = date('Y-m-d');
            $this->db->where('b.akhir_registrasi >=', $date);
        }
        $i = 0;
        foreach ($this->search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('b.mulai_registrasi DESC');
    }

    //Get Data Peserta Di Table History Pelatihan
    public function getData_History($id_pelatihan)
    {
        $this->db->select('id_history_pelatihan,
						 id_pelatihan,
						 id_peserta,
						 tanggal_daftar,
						 tahun,
						 flag
                         ');
        $this->db->from('data_history_pelatihan');
        $this->db->where('id_pelatihan', $id_pelatihan);
        $this->db->order_by('id_history_pelatihan');
        $query = $this->db->get();
        return $query->row_array();
    }

    /*Fungsi get data edit by id*/
    public function getDataDetailPelatihan($id)
    {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_sumber,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.tanggal_pelatihan_akhir,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           j.sumber,
                           GROUP_CONCAT(e.id_syarat ORDER BY e.id_syarat ASC SEPARATOR ",") AS group_syarat,
                           GROUP_CONCAT(i.id_syarat_dinamis ORDER BY i.id_syarat_dinamis ASC SEPARATOR ",") AS group_syarat_dinamis
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->join('data_rules_syarat_dinamis h', 'a.id_pelatihan = h.id_pelatihan', 'left');
        $this->db->join('ms_syarat_dinamis i', 'h.id_syarat_dinamis = i.id_syarat_dinamis', 'left');
        $this->db->join('ref_sumberdana j', 'j.id_sumber = a.id_sumber', 'left');
        $this->db->where('a.token', $id);
        $this->db->where('e.id_status', 1);
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('a.id_pelatihan ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    /*Fungsi get data edit by id*/
    public function getDataViewDinamis($id)
    {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_sumber,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           GROUP_CONCAT(c.id_syarat_dinamis ORDER BY c.id_syarat_dinamis ASC SEPARATOR ",") AS group_syarat_dinamis
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('data_rules_syarat_dinamis b', 'a.id_pelatihan = b.id_pelatihan', 'inner');
        $this->db->join('ms_syarat_dinamis c', 'b.id_syarat_dinamis = c.id_syarat_dinamis', 'left');
        $this->db->where('a.token', $id);
        $this->db->where('b.id_status', 1);
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('a.id_pelatihan ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    /*Fungsi get data show pada peserta by id*/
    public function getDataDetailShow($id)
    {

        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_sumber,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           h.sumber,
                           GROUP_CONCAT(e.id_syarat ORDER BY e.id_syarat ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->join('ref_sumberdana h', 'h.id_sumber = a.id_sumber', 'left');
        $this->db->where('a.token', $id);
        $this->db->where('b.id_status', 1);
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('a.id_pelatihan ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    // public function cekSyarat($dataSyarat){
    //     $userLogin = "";
    //     if ($this->app_loader->is_peserta()) {
    //         $userLogin      = $this->app_loader->current_pesertaid();
    //     }
    //     $dataSyarat = explode(',',$dataSyarat);

    //     $ceka = array();
    //     foreach($dataSyarat as $syarat){
    //         $tf  = $this->db->select('tabel_name, field_name')->from('data_syarat')->where('id_syarat',$syarat)->get()->row_array();
    //         $cek = $this->db->select($tf['field_name'].' as cek')->from($tf['tabel_name'])->where('id_peserta',$userLogin)->get()->row_array();
    //         $ceka[trim($syarat," ")] = $cek['cek'];
    //     }
    //     return $ceka;
    // }

    /* Fungsi untuk insert data */
    public function insertDataPelatihan()
    {
        //get data
        $create_by      = $this->app_loader->current_account();
        $opd_id         = $this->app_loader->current_opdid();
        $create_date    = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $create_ip      = $this->input->ip_address();
        $id_jadwal         = escape($this->input->post('id_jadwal', TRUE));
        $kuota              = escape($this->input->post('kuota', TRUE));
        $upload_brosur      = escape($this->input->post('upload_brosur', TRUE));
        $syarat_pelatihan    = escape($this->input->post('syarat_id', TRUE));
        $syarat_tambahan    = escape($this->input->post('syarat_dinamis_id', TRUE));
        $token                 = generateToken($id_jadwal, $kuota);

        /*cek yang diinputkan*/
        $this->db->where('id_jadwal', $id_jadwal);
        $qTot = $this->db->count_all_results('data_pelatihan');
        if ($qTot > 0)
            return array('response' => 'ERROR');
        else {
            $dirname = 'uploads/brosur';
            if (!is_dir($dirname)) {
                mkdir('./' . $dirname, 0777, TRUE);
            }
            //cek upload file brosur	
            $config = array(
                'upload_path'         => './' . $dirname . '/',
                'allowed_types'     => 'png|jpg|jpeg',
                'file_name'         => 'brosur_' . $token,
                'file_ext_tolower'    => TRUE,
                'max_size'             => 3072,
                'max_filename'         => 0,
                'remove_spaces'     => TRUE
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('upload_brosur')) {
                $file_upload = '';
            } else {
                $upload_data = $this->upload->data();
                $file_upload = $upload_data['file_name'];
            }
            $data = array(
                'token'                 => $token,
                'id_opd'                => $opd_id,
                'upload_brosur '        => $file_upload,
                'id_jadwal'             => escape($this->input->post('id_jadwal', TRUE)),
                'id_sumber'             => escape($this->input->post('id_sumber', TRUE)),
                'id_metode_pelatihan'   => escape($this->input->post('id_metode_pelatihan', TRUE)),
                'keterangan'            => str_replace('\r\n', '', $this->input->post('keterangan', TRUE)),
                'kuota'                 => $kuota,
                'create_by'             => $create_by,
                'create_date'           => $create_date,
                'create_ip'             => $create_ip,
                'mod_by'                => $create_by,
                'mod_date'              => $create_date,
                'mod_ip'                => $create_ip
            );
            /*query insert*/
            $this->db->insert('data_pelatihan', $data);
            $id_pelatihan = $this->db->insert_id();

            /*query insert syarat pelatihan*/
            // foreach ($syarat_pelatihan as $id) {
            //     $this->db->insert('data_rules_syarat', array('id_pelatihan' => $id_pelatihan, 'id_syarat' => $this->encryption->decrypt($id), 'id_status' => 1));
            // }

            foreach ($syarat_pelatihan as $key => $id) {
                /*cek data kontrol*/
                $this->db->where('id_pelatihan', abs($id_pelatihan));
                $this->db->where('id_syarat', abs($id));
                $qTot = $this->db->count_all_results('data_rules_syarat');
                if ($qTot <= 0) {
                    $data = array(
                        'id_pelatihan'  => $id_pelatihan,
                        'id_syarat'  => $id,
                        'id_status'  => '1'
                    );
                    $this->db->insert('data_rules_syarat', $data);
                }
            }

            if (!empty($syarat_tambahan)) {
                foreach ($syarat_tambahan as $key => $id) {
                    /*cek data kontrol*/
                    $this->db->where('id_pelatihan', abs($id_pelatihan));
                    $this->db->where('id_syarat_dinamis', abs($id));
                    $qTot = $this->db->count_all_results('data_rules_syarat_dinamis');
                    if ($qTot <= 0) {
                        $data = array(
                            'id_pelatihan'          => $id_pelatihan,
                            'id_syarat_dinamis'     => $id,
                            'id_status'             => '1'
                        );
                        $this->db->insert('data_rules_syarat_dinamis', $data);
                    }
                }
            }


            return array('response' => 'SUCCESS');
        }
    }

    /* Fungsi untuk update data */
    public function updateDataPelatihan()
    {
        //get data
        $create_by    = $this->app_loader->current_account();
        $opd_id       = $this->app_loader->current_opdid();
        $create_date  = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $create_ip    = $this->input->ip_address();
        $token                = escape($this->input->post('tokenId', TRUE));
        $kuota              = escape($this->input->post('kuota', TRUE));
        $syarat_pelatihan    = escape($this->input->post('syarat_id', TRUE));
        $syarat_tambahan    = escape($this->input->post('syarat_dinamis_id', TRUE));
        $file_data          = $_FILES['upload_brosur']['name'];
        $foto_old              = escape($this->input->post('fileshow', TRUE));



        //get data by id
        $dataP = $this->getDataDetailPelatihan($token);
        $id_pelatihan = !empty($dataP) ? $dataP['id_pelatihan'] : 0;
        //cek data ditemukan atau tidak
        if (count($dataP) <= 0)
            return array('response' => 'NODATA');
        else {

            $data = array(
                'token'                 => $token,
                'upload_brosur '        => '',
                'id_jadwal'             => escape($this->input->post('id_jadwal', TRUE)),
                'id_sumber'             => escape($this->input->post('id_sumber', TRUE)),
                'id_metode_pelatihan'   => escape($this->input->post('id_metode_pelatihan', TRUE)),
                'keterangan'            => str_replace('\r\n', '', $this->input->post('keterangan', TRUE)),
                'kuota'                 => $kuota,
                'mod_by'                => $create_by,
                'mod_date'              => $create_date,
                'mod_ip'                => $create_ip
            );
            /*query update*/
            $this->db->where('token', $token);
            $this->db->update('data_pelatihan', $data);

            /*query update syarat pelatihan*/
            $this->db->set('id_status', 0);
            $this->db->where('id_pelatihan', abs($id_pelatihan));
            $this->db->update('data_rules_syarat');

            foreach ($syarat_pelatihan as $key => $id) {

                $this->db->where('id_pelatihan', abs($id_pelatihan));
                $this->db->where('id_syarat', $id);
                $nSyarat = $this->db->count_all_results('data_rules_syarat');
                if ($nSyarat > 0) {
                    //update status syarat jadi 1
                    $this->db->set('id_status', 1);
                    $this->db->where('id_pelatihan', abs($id_pelatihan));
                    $this->db->where('id_syarat', $id);
                    $this->db->update('data_rules_syarat');
                } else
                    $this->db->insert('data_rules_syarat', array('id_pelatihan' => $id_pelatihan, 'id_syarat' => $id, 'id_status' => 1));
            }

            if (!empty($syarat_tambahan)) {
                /*query update syarat pelatihan dinamis*/
                $this->db->set('id_status', 0);
                $this->db->where('id_pelatihan', abs($id_pelatihan));
                $this->db->update('data_rules_syarat_dinamis');
                foreach ($syarat_tambahan as $key => $id) {
                    /*cek data kontrol*/
                    $this->db->where('id_pelatihan', abs($id_pelatihan));
                    $this->db->where('id_syarat_dinamis', abs($id));
                    $qTot = $this->db->count_all_results('data_rules_syarat_dinamis');
                    if ($qTot > 0) {
                        //update status syarat jadi 1
                        $this->db->set('id_status', 1);
                        $this->db->where('id_pelatihan', abs($id_pelatihan));
                        $this->db->where('id_syarat_dinamis', $id);
                        $this->db->update('data_rules_syarat_dinamis');
                    } else {
                        $this->db->insert('data_rules_syarat_dinamis', array('id_pelatihan' => $id_pelatihan, 'id_syarat_dinamis' => $id, 'id_status' => 1));
                    }
                }
            }

            return array('response' => 'SUCCESS');
        }
    }

    /* Fungsi untuk delete data */
    public function deleteDataPelatihan()
    {
        $id = escape($this->input->post('tokenId', TRUE));
        //cek data by id
        $dataPelatihan  = $this->getDataDetailPelatihan($id);
        $id_pelatihan   = !empty($dataPelatihan) ? $dataPelatihan['id_pelatihan'] : '';
        if (count($dataPelatihan) <= 0)
            return array('response' => 'ERROR', 'nama' => '');
        else {
            $this->db->where('id_pelatihan', $id_pelatihan);
            $count = $this->db->count_all_results('data_history_pelatihan');
            if ($count > 0)
                return array('response' => 'ERRDATA');
            else {
                $this->db->where('token', $id);
                $this->db->delete('data_pelatihan');
                return array('response' => 'SUCCESS');
            }
        }
    }

    //Get Data Peserta Di Table History Pelatihan
    public function getData_byPesertaPelatihan($id_pelatihan, $userLogin, $tahun = 0)
    {

        $this->db->select('id_history_pelatihan,
						 id_pelatihan,
						 id_peserta,
						 tanggal_daftar,
						 tahun,
						 flag
                         ');
        $this->db->from('data_history_pelatihan');
        $this->db->where('id_pelatihan', $id_pelatihan);
        $this->db->where('id_peserta', $userLogin);
        if ($tahun > 0) {
            $tahun = $tahun - 5;
            $this->db->where('tahun > ' . $tahun);
        }
        $this->db->order_by('id_history_pelatihan');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getDataSyarat($pelatihanId, $userLogin = "")
    {
        $cekData = array();
        $userLogin = ($this->app_loader->is_peserta()) ?  $this->app_loader->current_pesertaid() : 0;
        $this->db->select('a.id_rules_syarat,
                           a.id_pelatihan,
                           a.id_syarat,
                           a.id_status,
                           b.nm_syarat,
                           b.tabel_name,
                           b.field_name');
        $this->db->from('data_rules_syarat a');
        $this->db->join('data_syarat b', 'a.id_syarat = b.id_syarat', 'inner');
        $this->db->where('a.id_pelatihan', $pelatihanId);
        $this->db->where('a.id_status', 1);
        $query = $this->db->get()->result_array();
        foreach ($query as $key => $val) {
            $cek = $this->db->select($val['field_name'] . ' as nilai')->from($val['tabel_name'])->where('id_peserta', $userLogin)->get()->row_array();
            $cekData[$val['id_syarat']] = array(
                'id' => $val['id_syarat'],
                'label' => $val['nm_syarat'],
                'nilai' => (!empty($cek['nilai']) ? $cek['nilai'] : ''),
                'field_name' => $val['field_name']
            );
        }
        return $cekData;
    }

    public function getDataSyaratTambahan($pelatihanId, $userLogin = "")
    {
        $cekData = array();
        $userLogin = ($this->app_loader->is_peserta()) ?  $this->app_loader->current_pesertaid() : 0;
        $this->db->select('a.id_rules_dinamis,
                           a.id_pelatihan,
                           a.id_syarat_dinamis,
                           a.id_status,
                           b.nm_syarat_dinamis');
        $this->db->from('data_rules_syarat_dinamis a');
        $this->db->join('ms_syarat_dinamis b', 'a.id_syarat_dinamis = b.id_syarat_dinamis', 'inner');
        $this->db->where('a.id_pelatihan', $pelatihanId);
        $this->db->where('a.id_status', 1);
        $query = $this->db->get()->result_array();
        foreach ($query as $key => $val) {
            $cek = $this->db->select($val['id_syarat_dinamis'] . ' as syarat, data_pelatihan.id_pelatihan, nama_file')->from('data_berkas_peserta')->join('data_pelatihan', 'data_pelatihan.id_pelatihan = data_berkas_peserta.id_pelatihan', 'inner')->where('id_peserta', $userLogin)->where('data_pelatihan.id_pelatihan', $pelatihanId)->get()->row_array();
            $cekData[$val['id_syarat_dinamis']] = array(
                'id'                => $val['id_syarat_dinamis'],
                'nm_syarat_dinamis' => $val['nm_syarat_dinamis'],
                'id_pelatihan'      => (!empty($cek['id_pelatihan']) ? $cek['id_pelatihan'] : ''),
                'syarat'            => (!empty($cek['syarat']) ? $cek['syarat'] : ''),
                'status'            => (!empty($cek['nama_file']) ? '<span class="badge badge-pill badge-success">OK</span>' : '<span class="badge badge-pill badge-danger">Belum Upload</span>')
            );
        }
        return $cekData;
    }

    /*Fungsi get data edit by id*/
    public function getOPD($id)
    {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->where('a.token', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Fungsi untuk pendaftaran pelatihan data */
    public function daftarPelatihan_upload($fields)
    {

        $tahun              = gmdate('Y');
        $bulan              = date('m');
        $id_token           = $this->input->post('tokenView', TRUE);
        $idPelatihan        = $this->input->post('pelatihanId', TRUE);
        $pelatihan          = $this->getDataDetailPelatihan($id_token);
        $token              = !empty($pelatihan) ? $pelatihan['token'] : '';
        $mulai_registrasi   = !empty($pelatihan) ? $pelatihan['mulai_registrasi'] : '';
        $akhir_registrasi   = !empty($pelatihan) ? $pelatihan['akhir_registrasi'] : '';

        if ($this->app_loader->is_peserta()) {
            $userLogin            = $this->app_loader->current_pesertaid();
        } else {
            $peserta = '0';
        }
        $history          = $this->getData_byPesertaPelatihan($idPelatihan, $userLogin);
        $id_pelatihan     = !empty($history) ? $history['id_pelatihan'] : '';
        $id_peserta       = !empty($history) ? $history['id_peserta'] : '';

        $opdGET          = $this->getOPD($id_token);
        // echo $this->db->last_query(); die;
        $opd            = !empty($opdGET) ? $opdGET['id_opd'] : '';


        $tanggal_daftar    = date('Y-m-d');

        $getFiles = $_FILES['upload_bukti']['name'];
        //cek data by id
        $this->db->where('id_peserta', $id_peserta);
        $this->db->where('id_pelatihan', $id_pelatihan);
        $this->db->where('tahun', $tahun);
        $nUser = $this->db->count_all_results('data_history_pelatihan');
        if ($nUser > 0) {
            return array('response' => 'ERRDATA');
        } else if (count($token) <= 0) {
            return array('response' => 'ERROR');
        } else if (in_array(null, $getFiles)) {
            return array('response' => 'UPLOAD_FAILED');
        } else {

            //create repo
            $dirname = 'repository/pelatihan/' . $idPelatihan . '/' . $tahun . '/' . $bulan . '/' . $userLogin;
            if (!is_dir($dirname)) {
                mkdir($dirname, 0777, TRUE);
            }
            $this->load->library('upload');
            foreach ($getFiles as $key => $val) {
                if (!empty($_FILES['upload_bukti']['name'][$key])) {
                    $_FILES['upload_bukti[]']['name']     = $_FILES['upload_bukti']['name'][$key];
                    $_FILES['upload_bukti[]']['type']     = $_FILES['upload_bukti']['type'][$key];
                    $_FILES['upload_bukti[]']['tmp_name'] = $_FILES['upload_bukti']['tmp_name'][$key];
                    $_FILES['upload_bukti[]']['error']    = $_FILES['upload_bukti']['error'][$key];
                    $_FILES['upload_bukti[]']['size']     = $_FILES['upload_bukti']['size'][$key];

                    $config = array(
                        'upload_path'         => './' . $dirname . '/',
                        // 'allowed_types' 	=> 'png|jpg|jpeg|pdf',
                        'allowed_types'     => 'pdf',
                        'file_name'            => 'upload_' . $userLogin . '_' . $key,
                        'file_ext_tolower'    => TRUE,
                        'max_size'             => 1024,
                        'max_filename'         => 0,
                        'remove_spaces'     => TRUE,
                    );

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('upload_bukti[]')) {
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];
                        //inser ke table dokumen
                        $dataFile = array(
                            'id_pelatihan'      => $idPelatihan,
                            'id_peserta'        => $userLogin,
                            'nama_file'         => $filename,
                            'id_syarat_dinamis' => $key,
                            'date'              => $bulan,
                            'year'              => $tahun
                        );
                        $this->db->insert('data_berkas_peserta', $dataFile);
                    } else {
                        return array('response' => 'FILE_ERROR');
                        break;
                    }
                }
            }

            $data = array(
                'id_pelatihan'      => $idPelatihan,
                'id_opd'            => $opd,
                'id_peserta'        => $userLogin,
                'tahun'               => $tahun,
                'flag'               => '1',
                'tanggal_daftar'       => $tanggal_daftar,
                'id_status'           => '1'
            );
            /*query insert*/
            $this->db->insert('data_history_pelatihan', $data);


            foreach ($fields as $key => $value) {
                $dataSyarat = $this->db->get_where('data_syarat', array('id_syarat' => $key))->row();
                if ($dataSyarat->field_name == 'no_nib') {
                    if ($value != 0) {
                        $this->db->where('id_peserta', $userLogin);
                        $umkm = $this->db->count_all_results('data_umkm');
                        if ($umkm > 0) {
                            $this->db->query('update ' . $dataSyarat->tabel_name . ' set ' . $dataSyarat->field_name . '="' . $value . '" where id_peserta="' . $userLogin . '"');
                        } else {
                            $this->db->query('insert into ' . $dataSyarat->tabel_name . ' (' . $dataSyarat->field_name . ', id_peserta) values ("' . $value . '","' . $userLogin . '")');
                        }
                        $this->db->query('update data_peserta set id_jenis_akun = 1, minat_usaha = "" where id_peserta="' . $userLogin . '"');
                    }
                } else {
                    $this->db->query('update ' . $dataSyarat->tabel_name . ' set ' . $dataSyarat->field_name . '="' . $value . '" where id_peserta="' . $userLogin . '"');
                }
            };

            return array('response' => 'SUCCESS');
        }
    }

    /* Fungsi untuk pendaftaran pelatihan data */
    public function daftarPelatihan_noupload($fields)
    {

        $tahun              = gmdate('Y');
        $bulan              = date('m');
        $id_token           = $this->input->post('tokenView', TRUE);
        $idPelatihan        = $this->input->post('pelatihanId', TRUE);
        $pelatihan          = $this->getDataDetailPelatihan($id_token);
        $token              = !empty($pelatihan) ? $pelatihan['token'] : '';
        $mulai_registrasi   = !empty($pelatihan) ? $pelatihan['mulai_registrasi'] : '';
        $akhir_registrasi   = !empty($pelatihan) ? $pelatihan['akhir_registrasi'] : '';

        if ($this->app_loader->is_peserta()) {
            $userLogin            = $this->app_loader->current_pesertaid();
        } else {
            $peserta = '0';
        }
        $history          = $this->getData_byPesertaPelatihan($idPelatihan, $userLogin);
        $id_pelatihan     = !empty($history) ? $history['id_pelatihan'] : '';
        $id_peserta       = !empty($history) ? $history['id_peserta'] : '';

        $opdGET          = $this->getOPD($id_token);
        // echo $this->db->last_query(); die;
        $opd            = !empty($opdGET) ? $opdGET['id_opd'] : '';

        // die($idopd);

        $tanggal_daftar    = date('Y-m-d');
        //cek data by id
        $this->db->where('id_peserta', $id_peserta);
        $this->db->where('id_pelatihan', $id_pelatihan);
        $this->db->where('tahun', $tahun);
        $nUser = $this->db->count_all_results('data_history_pelatihan');
        if ($nUser > 0) {
            return array('response' => 'ERRDATA');
        } else if (count($token) <= 0) {
            return array('response' => 'ERROR');
        } else {

            $data = array(
                'id_pelatihan'      => $idPelatihan,
                'id_opd'            => $opd,
                'id_peserta'        => $userLogin,
                'tahun'               => $tahun,
                'flag'               => '1',
                'tanggal_daftar'       => $tanggal_daftar,
                'id_status'           => '1'
            );
            /*query insert*/
            $this->db->insert('data_history_pelatihan', $data);

            foreach ($fields as $key => $value) {
                $dataSyarat = $this->db->get_where('data_syarat', array('id_syarat' => $key))->row();
                if ($dataSyarat->field_name == 'no_nib') {
                    if ($value != 0) {
                        $this->db->where('id_peserta', $userLogin);
                        $umkm = $this->db->count_all_results('data_umkm');
                        if ($umkm > 0) {
                            $this->db->query('update ' . $dataSyarat->tabel_name . ' set ' . $dataSyarat->field_name . '="' . $value . '" where id_peserta="' . $userLogin . '"');
                        } else {
                            $this->db->query('insert into ' . $dataSyarat->tabel_name . ' (' . $dataSyarat->field_name . ', id_peserta) values ("' . $value . '","' . $userLogin . '")');
                        }
                        $this->db->query('update data_peserta set id_jenis_akun = 1, minat_usaha = "" where id_peserta="' . $userLogin . '"');
                    }
                } else {
                    $this->db->query('update ' . $dataSyarat->tabel_name . ' set ' . $dataSyarat->field_name . '="' . $value . '" where id_peserta="' . $userLogin . '"');
                }
            };

            return array('response' => 'SUCCESS');
        }
    }

    /* get data list peserta pelatihan */
    public function getDataListPendaftar($id_pelatihan)
    {

        $this->db->select('a.id_pelatihan,
                            a.id_opd,
                            a.token,
                            a.id_jadwal,
                            a.id_sumber,
                            a.id_metode_pelatihan,
                            a.keterangan,
                            a.upload_brosur,
                            a.kuota,
                            b.id_history_pelatihan,
                            b.tanggal_daftar,
                            b.tahun,
                            b.flag,
                            c.id_peserta,
							c.nik,
							c.nama_lengkap,
							c.id_province,
							c.id_regency,
                            d.id_master_pelatihan,
                            e.nm_pelatihan,
                            f.sumber
                            ');
        $this->db->from('data_pelatihan a');
        $this->db->join('data_history_pelatihan b', 'b.id_pelatihan = a.id_pelatihan', 'inner');
        $this->db->join('data_peserta c', 'c.id_peserta = b.id_peserta', 'inner');
        $this->db->join('ms_jadwal d', 'a.id_jadwal = d.id_jadwal', 'inner');
        $this->db->join('ms_pelatihan e', 'd.id_master_pelatihan = e.id_master_pelatihan', 'inner');
        $this->db->join('ref_sumberdana f', 'f.id_sumber = a.id_sumber', 'left');
        $this->db->where('a.id_pelatihan', abs($id_pelatihan));
        $this->db->order_by('a.id_pelatihan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id)
    {
        $this->db->select('a.id_pelatihan,
                            a.id_opd,
                            a.token,
                            a.id_jadwal,
                            a.id_sumber,
                            a.id_metode_pelatihan,
                            a.keterangan,
                            a.upload_brosur,
                            a.kuota,
                            b.id_history_pelatihan,
                            b.tanggal_daftar,
                            b.tahun,
                            b.flag,
                            c.id_peserta,
							c.nik,
							c.nama_lengkap,
							c.id_province,
							c.id_regency,
                            d.id_master_pelatihan,
                            e.nm_pelatihan,
                            f.sumber
                            ');
        $this->db->from('data_pelatihan a');
        $this->db->join('data_history_pelatihan b', 'b.id_pelatihan = a.id_pelatihan', 'inner');
        $this->db->join('data_peserta c', 'c.id_peserta = b.id_peserta', 'inner');
        $this->db->join('ms_jadwal d', 'a.id_jadwal = d.id_jadwal', 'inner');
        $this->db->join('ms_pelatihan e', 'd.id_master_pelatihan = e.id_master_pelatihan', 'inner');
        $this->db->join('ref_sumberdana f', 'f.id_sumber = a.id_sumber', 'left');
        $this->db->where('a.id_pelatihan', abs($id));
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Fungsi untuk update data status peserta pelatihan */
    public function updateDataStatusPesertaPelatihan()
    {
        //get data
        $id         = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $flag       = $this->encryption->decrypt(escape($this->input->post('flag', TRUE)));
        $peserta    = escape($this->input->post('pesertaId', TRUE));
        // die(var_dump($peserta));
        //cek data by id
        $dataPelatihan = $this->getDataDetail($id);
        $nm_pelatihan      = !empty($dataPelatihan) ? $dataPelatihan['nm_pelatihan'] : '';
        if (count($dataPelatihan) <= 0)
            return array('response' => 'ERROR', 'nama' => '');
        else {
            foreach ($peserta as $key => $r) {
                $this->db->where('id_history_pelatihan', abs($this->encryption->decrypt($r)));
                $this->db->where('id_pelatihan', abs($id));
                if ($flag == "TR") {
                    $this->db->update('data_history_pelatihan', array('flag' => 2));
                } elseif ($flag == "TL") {
                    $this->db->update('data_history_pelatihan', array('flag' => 3));
                } elseif ($flag == "SL") {
                    $this->db->update('data_history_pelatihan', array('flag' => 4));
                }
            }
            return array('response' => 'SUCCESS', 'nama' => $nm_pelatihan);
        }
    }

    public function getDataDetailPeserta($id_peserta)
    {
        $this->db->select('a.id_peserta,
							a.token,
							a.nik,
							a.nama_lengkap,
							a.tempat_lhr,
							a.tanggal_lhr,
							a.alamat_peserta,
							a.id_study,
							a.id_agama,
							a.id_gender,
							a.id_province,
							a.id_regency,
							a.pekerjaan,
							a.id_jenis_akun,
							a.minat_usaha,
							a.kode_pos,
							a.upload_foto
							');
        $this->db->from('data_peserta a');
        $this->db->where('a.id_peserta', $id_peserta);
        $this->db->order_by('a.id_peserta ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getDataUsaha($id_peserta)
    {
        $this->db->select('u.id_umkm,
                            u.id_peserta,
                            u.nama_pemilik,
                            u.nama_usaha,
                            u.alamat_usaha,
                            u.telp,
                            u.wa,
                            u.id_bidang_usaha,
                            u.jenis_usaha,
                            p.nama_lengkap
                            ');
        $this->db->from('data_umkm u');
        $this->db->join('data_peserta p', 'p.id_peserta = u.id_peserta', 'left');
        $this->db->where('u.id_peserta', $id_peserta);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getDataSyaratTambahanPeserta($pelatihanId, $user)
    {
        $cekData = array();
        $this->db->select('a.id_rules_dinamis,
                           a.id_pelatihan,
                           a.id_syarat_dinamis,
                           a.id_status,
                           b.nm_syarat_dinamis');
        $this->db->from('data_rules_syarat_dinamis a');
        $this->db->join('ms_syarat_dinamis b', 'a.id_syarat_dinamis = b.id_syarat_dinamis', 'inner');
        $this->db->where('a.id_pelatihan', $pelatihanId);
        $this->db->where('a.id_status', 1);
        $query = $this->db->get()->result_array();
        foreach ($query as $key => $val) {
            $cek = $this->db->select('data_berkas_peserta.id_syarat_dinamis, data_berkas_peserta.id_berkas, data_berkas_peserta.nama_file, data_berkas_peserta.year, data_berkas_peserta.date, data_pelatihan.id_pelatihan')->from('data_berkas_peserta')->join('data_pelatihan', 'data_pelatihan.id_pelatihan = data_berkas_peserta.id_pelatihan', 'inner')->where('id_peserta', $user)->where('data_pelatihan.id_pelatihan', $pelatihanId)->where('data_berkas_peserta.id_syarat_dinamis', $val['id_syarat_dinamis'])->get()->row_array();
            $cekData[$val['id_syarat_dinamis']] = array(
                'id'                => $val['id_syarat_dinamis'],
                'id_peserta'        => $user,
                'id_berkas'         => (!empty($cek['id_berkas']) ? $cek['id_berkas'] : ''),
                'nm_syarat_dinamis' => $val['nm_syarat_dinamis'],
                'id_pelatihan'      => (!empty($cek['id_pelatihan']) ? $cek['id_pelatihan'] : ''),
                'syarat'            => (!empty($cek['syarat']) ? $cek['syarat'] : ''),
                'nama_file'         => (!empty($cek['nama_file']) ? $cek['nama_file'] : ''),
                'year'              => (!empty($cek['year']) ? $cek['year'] : ''),
                'date'              => (!empty($cek['date']) ? $cek['date'] : ''),
                'status'            => (!empty($cek['nama_file']) ? '<span class="badge badge-pill badge-success">Sudah Upload</span>' : '<span class="badge badge-pill badge-danger">Belum Upload</span>')
            );
        }
        return $cekData;
    }
}

// This is the end of auth signin model
