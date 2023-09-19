<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of program model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_usaha extends CI_Model
{
    private $table = 'data_umkm';
	public function __construct()
	{
		parent::__construct();
    }

    public function getBidang()
    {
        $this->db->select('*');
        $this->db->from('wa_bidang_usaha');
        $this->db->order_by('nama_bidang', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

}