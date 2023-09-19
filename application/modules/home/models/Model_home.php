<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of users model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_home extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	//Get Data List Peserta Jika Ada Diklat Yang Aktif Maka Ditampilkan Absen
	public function checkProfilePeserta($userLogin)
	{
		$this->db->select('id_peserta,
						 id_jenis_akun
                         ');
		$this->db->from('data_peserta');
		$this->db->where('id_peserta', $userLogin);
		$this->db->where('id_jenis_akun', 1);
		$query = $this->db->get();
		return $query->row_array();
	}

	/* Fungsi untuk insert data */
    public function insertData() {
        //get data
		$userLogin      = $this->app_loader->current_pesertaid();
		$nama_pemilik   = escape($this->input->post('nama_pemilik', TRUE));
		
			$data = array(
				'id_peserta'           		=> $userLogin,
				'nama_pemilik'          	=> $nama_pemilik,
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
			/*query insert*/
			$this->db->insert('data_umkm', $data);
			return array('response'=>'SUCCESS', 'usaha'=>$nama_pemilik);	
    }

	public function init_kegiatan($id)
    {
        $this->db->select('a.*,
							b.nama_opd
                         ');
		$this->db->from('data_berita a');
		$this->db->join('ms_unit_kerja b', 'a.id_opd = b.id_opd', 'left');
		$this->db->where('a.id_berita', $id);
		$query = $this->db->get();
		return $query->row_array();
    }
}

// This is the end of auth signin model
