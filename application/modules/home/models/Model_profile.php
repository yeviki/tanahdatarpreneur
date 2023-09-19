<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of fungsi model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_profile extends CI_Model
{   
    public function searchDataNIK($nik) {
		$this->db->where('nik', $nik);
		return $this->db->count_all_results('data_peserta');
    }
    
    public function getDataUser()
	{
		$account = $this->app_loader->current_account();
		$tokenUser = $this->app_loader->current_userid();
		$this->db->select('u.id_users,
                            u.token,
                            u.username,
                            u.fullname,
                            u.email,
                            u.foto_profile,
                            u.id_status,
                            u.create_date,
                            ps.nik,
							ps.nama_lengkap,
							ps.tempat_lhr,
							ps.tanggal_lhr,
							ps.alamat_peserta,
							ps.id_study,
							ps.id_agama,
							ps.id_gender,
							ps.id_province,
							ps.id_regency,
							ps.pekerjaan,
							ps.id_jenis_akun,
							ps.minat_usaha,
							ps.kode_pos,
							ps.upload_foto
                            ');
		$this->db->from('xi_sa_users u');
        $this->db->join('xi_sa_users_default_pass p', 'p.id_users = u.id_users', 'left');
        $this->db->join('data_peserta ps', 'u.token = ps.token', 'left');
		$this->db->where('u.token', $tokenUser);
		$this->db->where('u.username', $account);
		$this->db->where('u.id_status', 1);
		$query = $this->db->get();
		return $query->row();
    }

    public function getDataUsaha()
	{
		$userLogin      = $this->app_loader->current_pesertaid();
		$this->db->select('u.id_umkm,
                            u.id_peserta,
                            u.nama_pemilik,
                            u.nama_usaha,
                            u.alamat_usaha,
                            u.telp,
                            u.wa,
                            u.id_bidang_usaha,
                            u.jenis_usaha,
                            u.produk_jual,
                            u.no_nib,
                            u.no_pirt,
                            u.no_pkrt,
                            u.no_iumk,
                            u.no_md,
                            u.no_ml,
                            u.no_halal,
                            u.no_merek,
                            u.tahun_mulai_usaha,
                            u.jumlah_produksi,
                            u.jumlah_penjualan,
                            u.omset,
                            u.bentuk_pemasaran,
                            u.jumlah_pekerja,
                            u.menerima_pinjaman,
                            u.jumlah_pinjaman,
                            u.id_skala_usaha,
                            u.modal_awal,
                            u.media_sosial,
                            u.nama_toko_online,
                            u.media_transaksi_digital,
                            u.kendala_usaha,
                            u.pelatihan_diinginkan,
                            p.nama_lengkap
                            ');
		$this->db->from('data_umkm u');
        $this->db->join('data_peserta p', 'p.id_peserta = u.id_peserta', 'left');
		$this->db->where('u.id_peserta', $userLogin);
		$query = $this->db->get();
		return $query->row();
    }
    
    /*Fungsi get data edit by id*/
    public function getDiklat() {
        $userLogin  = $this->app_loader->current_pesertaid();
        $date       = date('Y-m-d');
        $this->db->select('a.id_history_pelatihan,
                           a.id_pelatihan,
                           a.id_peserta,
                           a.flag,
                           (select count(x.id_peserta) from data_history_pelatihan x where x.id_peserta = a.id_peserta) as total,
                           b.id_opd,
                           b.token,
                           b.judul,
                           b.deskripsi,
                           b.id_metode_pelatihan,
                           b.persyaratan,
                           b.upload_brosur ,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.kuota,
                           b.alamat,
                           b.jadwal_pelatihan,
                           b.id_status,
                           b.flag
                         ');
        $this->db->from('data_history_pelatihan a');
        $this->db->join('data_pelatihan b', 'a.id_pelatihan = b.id_pelatihan', 'inner');
        $this->db->join('data_peserta c', 'a.id_peserta = c.id_peserta', 'inner');
        $this->db->where('b.jadwal_pelatihan <', $date);
        $this->db->or_where('a.flag', 4);
		$this->db->where('a.id_peserta', $userLogin);
		$query = $this->db->get();
		return $query->row();
    }

    private function getDataPesertaByToken($token) {
		$this->db->where('token', $token);
		$query = $this->db->get('data_peserta');
		return $query->row_array();
    }
    
    /* Fungsi untuk update data */
    public function updateDataPeserta() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $userLogin      = $this->app_loader->current_pesertaid();
        $create_date    = date('Y-m-d H:i:s');
        $create_ip      = $this->input->ip_address();
		$token          = $this->app_loader->current_userid();
		$nik	 	 	= escape($this->input->post('nik', TRUE));
		$nama_lengkap 	= escape($this->input->post('nama_lengkap', TRUE));
		$id_jenis_akun 	= escape($this->input->post('id_jenis_akun', TRUE));
		$file_data    	= $_FILES['upload_foto']['name'];	
		$foto_old  	  	= escape($this->input->post('fotoProfile', TRUE));

		//cek data pendamping by id
		$checkData = $this->getDataPesertaByToken($token);
		if(count($checkData) <= 0)
			return array('response'=>'NODATA');
		else {
                //cek data
                $this->db->where('token !=', $token);
                $this->db->where('nik', $nik);
                $qTot = $this->db->count_all_results('data_peserta');
			if($qTot > 0)
				return array('response'=>'ERROR');
			else {
                    // Proses Penampungan Input Data Peserta
                    if($file_data != '' or $foto_old == '') {
                        $dirname 	   	= 'assets/img/avatar';
                        if (!is_dir($dirname)) {
                            mkdir('./'.$dirname, 0777, TRUE);
                        }
                        //cek upload file foto	
                        $config = array(
                            'upload_path'	 	=> './'.$dirname.'/',
                            'allowed_types' 	=> 'png|jpg|jpeg',
                            'file_type'         => 'image/jpeg|image/png|image/jpg',
                            'is_image'          => 1,
                            'file_name' 		=> 'foto_'.$token,
                            'file_ext_tolower'	=> TRUE,
                            'max_size' 			=> 3072,
                            'max_filename' 		=> 0,
                            'remove_spaces' 	=> TRUE
                        );
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('upload_foto'))
                            return array('response'=>'NOIMAGE');
                        else {
                            //hapus image
                            if(file_exists(realpath('./'.$dirname.'/'.$foto_old))) {
                                unlink(realpath('./'.$dirname.'/'.$foto_old));
                            }
                            $upload_data = $this->upload->data();
                            $file_foto = $upload_data['file_name'];
                        }
                    } else {
                        $file_foto = $foto_old;
                    }
                    $dataPeserta = array(
                        'token'				  	    => $token,
                        'nik' 						=> $nik,
                        'nama_lengkap' 				=> $nama_lengkap,
                        'upload_foto' 				=> $file_foto,
                        'tempat_lhr' 				=> escape($this->input->post('tempat_lhr', TRUE)),
                        'tanggal_lhr' 				=> escape($this->input->post('tanggal_lhr', TRUE)),
                        'alamat_peserta' 			=> escape($this->input->post('alamat_peserta', TRUE)),
                        'id_study' 					=> escape($this->input->post('id_study', TRUE)),
                        'id_agama' 					=> escape($this->input->post('id_agama', TRUE)),
                        'id_gender' 				=> escape($this->input->post('id_gender', TRUE)),
                        'id_province' 				=> escape($this->input->post('province', TRUE)),
                        'id_regency' 				=> escape($this->input->post('regency', TRUE)),
                        'kode_pos' 					=> escape($this->input->post('kode_pos', TRUE)),
                        'pekerjaan' 				=> escape($this->input->post('pekerjaan', TRUE)),
                        'id_jenis_akun' 			=> escape($this->input->post('id_jenis_akun', TRUE)),
                        'minat_usaha' 			    => escape($this->input->post('minat_usaha', TRUE)),
                        'mod_by' 					=> $create_by,
                        'mod_date' 					=> $create_date,
                        'mod_ip' 					=> $create_ip
                    );

                    $dataUser = array(
                        'fullname'  	=> $nama_lengkap,
                        'foto_profile' 	=> $file_foto,
                        'mod_by' 	  	=> $create_by,
                        'mod_date'  	=> $create_date,
                        'mod_ip'    	=> $create_ip
                    );

                    // Proses Penampungan Input Data UMKM
                    $dataUsaha = array(
                        'id_peserta'           		=> $userLogin,
                        'nama_pemilik'          	=> escape($this->input->post('nama_pemilik', TRUE)),
                        'nama_usaha'				=> escape($this->input->post('nama_usaha', TRUE)),
                        'alamat_usaha'				=> escape($this->input->post('alamat_usaha', TRUE)),
                        'telp'						=> escape($this->input->post('telp', TRUE)),
                        'wa'						=> escape($this->input->post('wa', TRUE)),
                        'id_bidang_usaha'			=> escape($this->input->post('id_bidang_usaha', TRUE)),
                        'jenis_usaha'				=> escape($this->input->post('jenis_usaha', TRUE)),
                        'produk_jual'				=> escape($this->input->post('produk_jual', TRUE)),
                        'no_nib'					=> escape($this->input->post('no_nib', TRUE)),
                        'no_pirt'					=> escape($this->input->post('no_pirt', TRUE)),
                        'no_pkrt'					=> escape($this->input->post('no_pkrt', TRUE)),
                        'no_iumk'					=> escape($this->input->post('no_iumk', TRUE)),
                        'no_md'						=> escape($this->input->post('no_md', TRUE)),
                        'no_ml'						=> escape($this->input->post('no_ml', TRUE)),
                        'no_halal'					=> escape($this->input->post('no_halal', TRUE)),
                        'no_merek'					=> escape($this->input->post('no_merek', TRUE)),
                        'tahun_mulai_usaha'			=> escape($this->input->post('tahun_mulai_usaha', TRUE)),
                        'jumlah_produksi'			=> escape($this->input->post('jumlah_produksi', TRUE)),
                        'jumlah_penjualan'			=> escape($this->input->post('jumlah_penjualan', TRUE)),
                        'omset'						=> escape($this->input->post('omset', TRUE)),
                        'bentuk_pemasaran'			=> escape($this->input->post('bentuk_pemasaran', TRUE)),
                        'jumlah_pekerja'			=> escape($this->input->post('jumlah_pekerja', TRUE)),
                        'menerima_pinjaman'			=> escape($this->input->post('menerima_pinjaman', TRUE)),
                        'jumlah_pinjaman'			=> escape($this->input->post('jumlah_pinjaman', TRUE)),
                        'id_skala_usaha'			=> escape($this->input->post('id_skala_usaha', TRUE)),
                        'modal_awal'				=> escape($this->input->post('modal_awal', TRUE)),
                        'media_sosial'				=> escape($this->input->post('media_sosial', TRUE)),
                        'nama_toko_online'			=> escape($this->input->post('nama_toko_online', TRUE)),
                        'media_transaksi_digital'	=> escape($this->input->post('media_transaksi_digital', TRUE)),
                        'kendala_usaha'				=> escape($this->input->post('kendala_usaha', TRUE)),
                        'pelatihan_diinginkan'		=> escape($this->input->post('pelatihan_diinginkan', TRUE))                
                    );

                if($id_jenis_akun != '2') {
                    // die('Ada Usaha');
                    $this->db->where('id_peserta', $userLogin);
                    $qTot = $this->db->count_all_results('data_umkm');
                    if($qTot > 0) {
                        // die('Ada ID Peserta');
                        // Query Update Tabel Peserta
                        $this->db->where('token', $token);
                        $this->db->update('data_peserta', $dataPeserta);

                        // Query Update Tabel User
                        $this->db->where('token', $token);
				        $this->db->update('xi_sa_users', $dataUser);

                        // Query Update Tabel UMKM
                        $this->db->where('id_peserta', $userLogin);
                        $this->db->update('data_umkm', $dataUsaha);
                        return array('response'=>'SUCCESS');

                    } else {
                        // die('Tidak Ada ID Peserta');
                        // Query update Data Peserta
                        $this->db->where('token', $token);
                        $this->db->update('data_peserta', $dataPeserta);

                        // Query Update Tabel User
                        $this->db->where('token', $token);
				        $this->db->update('xi_sa_users', $dataUser);

                        // Query Simpan Data UMKM
                        $this->db->insert('data_umkm', $dataUsaha);
                        return array('response'=>'SUCCESS');
                    }
                } else {
                    // die('Tidak Ada Usaha');
                    // Query update Data Peserta
                    $this->db->where('token', $token);
                    $this->db->update('data_peserta', $dataPeserta);

                    // Query Update Tabel User
                    $this->db->where('token', $token);
                    $this->db->update('xi_sa_users', $dataUser);

                    // Query Delete Detail Usaha Peserta
                    $this->db->delete('data_umkm', array('id_peserta' => $userLogin));
                    return array('response'=>'SUCCESS');

                }
			}
		}
    }
}