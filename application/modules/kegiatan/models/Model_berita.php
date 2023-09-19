<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_berita extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('judul_berita');
    public function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        if ($this->app_loader->is_admin()) {
            $this->db->where('id_opd', $this->app_loader->current_opdid());
        }
        return $this->db->count_all_results('data_berita');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_berita,
                           a.judul_berita,
                           a.id_pelatihan,
                           a.id_opd,
                           a.keterangan,
                           a.link_youtube,
                           b.id_jadwal,
                           c.id_master_pelatihan,
                           d.nm_pelatihan,
                           ');
        $this->db->from('data_berita a');
        $this->db->join('data_pelatihan b', 'a.id_pelatihan = b.id_pelatihan', 'left');
        $this->db->join('ms_jadwal c', 'b.id_jadwal = c.id_jadwal', 'left');
        $this->db->join('ms_pelatihan d', 'c.id_master_pelatihan = d.id_master_pelatihan', 'left');
        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        $i = 0;
        foreach ($this->search as $item) { // loop column
            if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->order_by('id_berita ASC');
    }

    public function getDataPelatihan($id_pelatihan)
    {
        $this->db->select('a.id_pelatihan,
                a.id_opd,
                h.nama_opd,
                a.token,
                a.id_jadwal,
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
                g.nm_kat_urusan
                ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->join('ms_unit_kerja h', 'a.id_opd = h.id_opd', 'left');
        $this->db->where('a.id_pelatihan', $id_pelatihan);
        if ($this->app_loader->is_admin()) {
        $this->db->where('h.id_opd', $this->app_loader->current_opdid());
        }
        $this->db->order_by('a.id_pelatihan ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_berita', abs($id));
        $query = $this->db->get('data_berita');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        if ($this->app_loader->is_admin()) {
            $opd_id         = $this->app_loader->current_opdid();
        } else {
            $opd_id = 0;
        }
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $judul_berita   = escape($this->input->post('judul_berita', TRUE));
        // die($pelatihan);
        //cek nama matadiklat duplicate
        $this->db->where('judul_berita', $judul_berita);
        $qTot = $this->db->count_all_results('data_berita');
        if($qTot > 0)
            return array('response'=>'ERROR', 'nama'=>$judul_berita);
        else {
            $dirname 	   	= 'repository/foto';
			if (!is_dir($dirname)) {
				mkdir('./' . $dirname, 0777, TRUE);
			}
			//cek upload file foto	
			$config = array(
				'upload_path'	 	=> './' . $dirname . '/',
				'allowed_types' 	=> 'png|jpg|jpeg',
                'file_type'         => 'image/jpeg|image/png|image/jpg',
                'is_image'          => 1,
				'file_name' 		=> 'foto_' . $create_date.'_'.$opd_id,
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 3072,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE
			);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file_foto')) {
				return array('response' => 'NOIMAGE');
			} else {
				$upload_data = $this->upload->data();
				$file_foto = $upload_data['file_name'];
                $data = array(
                    'judul_berita'      => $judul_berita,
                    'id_pelatihan'      => escape($this->input->post('id_pelatihan', TRUE)),
                    'link_youtube'      => escape($this->input->post('link_youtube', TRUE)),
                    'keterangan'        => str_replace('\r\n', '', $this->input->post('keterangan', TRUE)),
                    'id_status'         => escape($this->input->post('status', TRUE)),
                    'id_opd' 			=> $opd_id,
                    'file_foto' 		=> $file_foto,
                    'create_by' 		=> $create_by,
                    'create_date' 		=> $create_date,
                    'create_ip' 		=> $create_ip,
                    'mod_by' 			=> $create_by,
                    'mod_date' 			=> $create_date,
                    'mod_ip' 			=> $create_ip
                );
                /*query insert*/
                $this->db->insert('data_berita', $data);
                return array('response'=>'SUCCESS', 'nama'=>$judul_berita);
            }
        }
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $opd_id             = $this->app_loader->current_opdid();
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_berita	        = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $judul_berita       = escape($this->input->post('judul_berita', TRUE));
        $file_data    	    = $_FILES['file_foto']['name'];
		$foto_old  	  	    = escape($this->input->post('fileshow', TRUE));

        //cek data by id
        $data_search = $this->getDataDetail($id_berita);
        if(count($data_search) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            //cek nama kontrol duplicate
            $this->db->where('judul_berita', $judul_berita);
            $this->db->where('id_berita !=', $id_berita);
            $qTot = $this->db->count_all_results('data_berita');
            if($qTot > 0)
                return array('response'=>'ERRDATA', 'nama'=>$judul_berita);
            else {
                if ($file_data != '') {
					$dirname 	   	= 'repository/foto';
					if (!is_dir($dirname)) {
						mkdir('./' . $dirname, 0777, TRUE);
					}
					//cek upload file foto	
					$config = array(
						'upload_path'	 	=> './' . $dirname . '/',
						'allowed_types' 	=> 'png|jpg|jpeg',
                        'file_type'         => 'image/jpeg|image/png|image/jpg',
                        'is_image'          => 1,
						'file_name' 		=> 'foto_' . $create_date.'_'.$opd_id,
						'file_ext_tolower'	=> TRUE,
						'max_size' 			=> 3072,
						'max_filename' 		=> 0,
						'remove_spaces' 	=> TRUE
					);
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file_foto'))
                        $file_foto = $foto_old;
					else {
						//hapus image
						if (file_exists(realpath('./' . $dirname . '/' . $foto_old))) {
							@unlink(realpath('./' . $dirname . '/' . $foto_old));
						}
						$upload_data = $this->upload->data();
						$file_foto = $upload_data['file_name'];
					}
				}
                $data = array(
                    'judul_berita'      => $judul_berita,
                    'id_pelatihan'      => escape($this->input->post('id_pelatihan', TRUE)),
                    'link_youtube'      => escape($this->input->post('link_youtube', TRUE)),
                    'keterangan'        => str_replace('\r\n', '', $this->input->post('keterangan', TRUE)),
                    'id_status'         => escape($this->input->post('status', TRUE)),
					'mod_by'            => $create_by,
					'mod_date'          => $create_date,
					'mod_ip'            => $create_ip
                );
                if($file_data != ''){ $data['file_foto'] = $file_foto; }
                /*query update*/
                $this->db->where('id_berita', abs($id_berita));
                $this->db->update('data_berita', $data);
                return array('response'=>'SUCCESS', 'nama'=>$judul_berita);
            }
        }
    }

    /* Fungsi untuk delete data */
    public function deleteData() {
        $id = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        //cek data by id
        $dataSearch = $this->getDataDetail($id);
        $judul_berita = !empty($dataSearch) ? $dataSearch['judul_berita'] : '';
        if (count($dataSearch) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            $file_foto 	= !empty($dataSearch) ? $dataSearch['file_foto'] : 0;
			@unlink(realpath('./repository/foto/' . $file_foto));
            $this->db->where('id_berita', abs($id));
            $this->db->delete('data_berita');
            return array('response'=>'SUCCESS', 'nama'=>$judul_berita);
        }
    }
}

// This is the end of auth signin model
