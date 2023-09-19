<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_statistik extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getDataTahun()
	{
		$dd_year[''] = 'Pilih Tahun';
		for ($i = 2021; $i <= ((int) date('Y')) + 1; $i++) {
			$dd_year[$i] = $i;
		}
		return $dd_year;
	}

	public function getDataPesertaPelatihan()
	{
		$this->db->select('a.id_opd, 
                            a.id_peserta, 
                            a.id_pelatihan, 
                            a.flag, 
                            (select count(distinct(id_peserta)) from data_history_pelatihan where id_pelatihan > 0 and id_opd=a.id_opd) as jml
                        ');
		$this->db->from('data_history_pelatihan a');
		$this->db->join('data_peserta b ', ' a.id_peserta = b.id_peserta', 'inner');
		$this->db->join('data_pelatihan c ', ' a.id_pelatihan = c.id_pelatihan', 'inner');
		$this->db->join('ms_unit_kerja d ', ' a.id_opd = d.id_opd', 'inner');
		// $this->db->where('a.flag', 2);
		// $this->db->where('a.tahun', date('Y'));
		$this->db->where('a.id_pelatihan > 0');
		$this->db->group_by('a.id_opd');
		$query = $this->db->get();
		return $query->result_array();
	}

	// Grafik Peserta Per Kab/Kota
	public function getDataOPD_grafik()
	{
		$this->db->select('id_opd, nama_opd, singkatan');
		$this->db->from('ms_unit_kerja a');
		$this->db->where('id_opd <>', 17);
		$query = $this->db->get();
		return $query->result_array();
	}
}

// This is the end of auth signin model
