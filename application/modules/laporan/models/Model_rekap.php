<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_rekap extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('nama_opd', 'singkatan');
    public function get_datatables($dt)
    {
        $this->_get_datatables_query($dt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->where('id_opd <>', 17);
        return $this->db->count_all_results('ms_unit_kerja');
    }

    private function _get_datatables_query($dt = null)
    {
        $select = "";
        if ($dt != null) {
            foreach ($dt as $d) {
                $select .= '(select count(distinct(id_peserta)) from data_history_pelatihan where id_pelatihan != 0 and id_opd=a.id_opd and id_opd != 0 and tahun="' . $d['tahun'] . '") as p' . $d['tahun'] . ', ';
                $select .= '(select count(distinct(dp.id_pelatihan)) from data_pelatihan dp, ms_jadwal j where dp.id_pelatihan != 0 and dp.id_opd=a.id_opd and dp.id_opd != 0 and dp.id_jadwal = j.id_jadwal and YEAR(j.tanggal_pelatihan)="' . $d['tahun'] . '") as pel' . $d['tahun'] . ', ';
            }
        }
        $this->db->select('a.id_opd,
                           a.nama_opd,
                           ' . $select . '
                           a.singkatan,
                           (select count(b.id_opd) from data_pelatihan b where b.id_opd = a.id_opd) as total
                           ');
        $this->db->from('ms_unit_kerja a');
        $this->db->where('a.id_opd <>', 17);
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
        $this->db->order_by('id_opd ASC');
    }

    public function printDataPeserta($tahun, $opd_id)
    {
        $this->db->select('a.id_peserta,
                            a.token,
                            a.nik,
                            a.nama_lengkap,
                            a.tempat_lhr,
                            a.tanggal_lhr,
                            a.alamat_peserta,
                            a.id_study,
                            d.study as pendidikan,
                            a.id_agama,
                            f.agama,
                            a.id_gender,
                            e.gender as jenis_kelamin,
                            a.id_province,
                            b.name as provinsi,
                            a.id_regency,
                            c.name as kabkota,
                            a.pekerjaan,
                            a.id_jenis_akun,
                            a.minat_usaha,
                            a.kode_pos,
                            a.upload_foto,
                            g.username as email,
                            i.nama_opd,
                            j.id_pelatihan,
                            l.nm_pelatihan,
                            k.tanggal_pelatihan,
                            YEAR(k.tanggal_pelatihan) as tahun_pelatihan,
                            k.tanggal_pelatihan_akhir,
                            k.tempat_pelatihan,
                            m.no_nib,
                            (select count(b.id_peserta) from data_history_pelatihan b where b.id_pelatihan = j.id_pelatihan) as total
						   ');
        $this->db->from('data_peserta a');
        $this->db->join('wa_province b', 'a.id_province = b.id', 'left');
        $this->db->join('wa_regency c', 'a.id_regency = c.id', 'left');
        $this->db->join('ref_pendidikan d', 'a.id_study = d.id_study', 'left');
        $this->db->join('ref_gender e', 'a.id_gender = e.id_gender', 'left');
        $this->db->join('ref_agama f', 'a.id_agama = f.id_agama', 'left');
        $this->db->join('xi_sa_users g', 'a.token = g.token', 'left');
        $this->db->join('data_history_pelatihan h', 'a.id_peserta = h.id_peserta', 'inner');
        $this->db->join('ms_unit_kerja i', 'h.id_opd = i.id_opd', 'inner');
        $this->db->join('data_pelatihan j', 'h.id_pelatihan = j.id_pelatihan', 'inner');
        $this->db->join('ms_jadwal k', 'j.id_jadwal = k.id_jadwal', 'inner');
        $this->db->join('ms_pelatihan l', 'k.id_master_pelatihan = l.id_master_pelatihan', 'inner');
        $this->db->join('data_umkm m', 'a.id_peserta = m.id_peserta', 'left');
        $this->db->where('i.id_opd', $opd_id);
        if ($tahun != '') {
            $this->db->where('YEAR(k.tanggal_pelatihan)', $tahun);
        }
        $this->db->group_by('a.id_peserta');
        $this->db->order_by('j.id_pelatihan ASC, a.id_peserta ASC');
        $get = $this->db->get();
        return $get->result_array();
    }

    public function totPeserta()
    {
        $this->db->select('a.id_peserta,
                            a.token,
                            a.nik,
                            a.nama_lengkap,
                            a.tempat_lhr,
                            a.tanggal_lhr,
                            a.alamat_peserta,
                            a.id_study,
                            j.id_pelatihan,
                            (select count(b.id_peserta) from data_history_pelatihan b where b.id_pelatihan = j.id_pelatihan) as total
    					   ');
        $this->db->from('data_peserta a');
        $this->db->join('data_history_pelatihan h', 'a.id_peserta = h.id_peserta', 'inner');
        $this->db->join('data_pelatihan j', 'h.id_pelatihan = j.id_pelatihan', 'inner');
        $this->db->group_by('a.id_peserta');
        $this->db->order_by('j.id_pelatihan ASC, a.id_peserta ASC');
        $query = $this->db->count_all_results();
        return $query;
    }

    public function printDataPelatihan($tahun, $opd_id)
    {
        $this->db->select('a.id_peserta,
                            a.token,
                            a.nik,
                            a.nama_lengkap,
                            a.tempat_lhr,
                            a.tanggal_lhr,
                            a.alamat_peserta,
                            a.id_study,
                            d.study as pendidikan,
                            a.id_agama,
                            f.agama,
                            a.id_gender,
                            e.gender as jenis_kelamin,
                            a.id_province,
                            b.name as provinsi,
                            a.id_regency,
                            c.name as kabkota,
                            a.pekerjaan,
                            a.id_jenis_akun,
                            a.minat_usaha,
                            a.kode_pos,
                            a.upload_foto,
                            g.username as email,
                            i.nama_opd,
                            j.id_pelatihan,
                            l.nm_pelatihan,
                            k.tanggal_pelatihan,
                            YEAR(k.tanggal_pelatihan) as tahun_pelatihan,
                            k.tanggal_pelatihan_akhir,
                            k.tempat_pelatihan,
                            m.no_nib,
                            (select count(b.id_peserta) from data_history_pelatihan b where b.id_pelatihan = j.id_pelatihan) as total
						   ');
        $this->db->from('data_peserta a');
        $this->db->join('wa_province b', 'a.id_province = b.id', 'left');
        $this->db->join('wa_regency c', 'a.id_regency = c.id', 'left');
        $this->db->join('ref_pendidikan d', 'a.id_study = d.id_study', 'left');
        $this->db->join('ref_gender e', 'a.id_gender = e.id_gender', 'left');
        $this->db->join('ref_agama f', 'a.id_agama = f.id_agama', 'left');
        $this->db->join('xi_sa_users g', 'a.token = g.token', 'left');
        $this->db->join('data_history_pelatihan h', 'a.id_peserta = h.id_peserta', 'inner');
        $this->db->join('ms_unit_kerja i', 'h.id_opd = i.id_opd', 'inner');
        $this->db->join('data_pelatihan j', 'h.id_pelatihan = j.id_pelatihan', 'inner');
        $this->db->join('ms_jadwal k', 'j.id_jadwal = k.id_jadwal', 'inner');
        $this->db->join('ms_pelatihan l', 'k.id_master_pelatihan = l.id_master_pelatihan', 'inner');
        $this->db->join('data_umkm m', 'a.id_peserta = m.id_peserta', 'left');
        $this->db->where('i.id_opd', $opd_id);
        if ($tahun != '') {
            $this->db->where('YEAR(k.tanggal_pelatihan)', $tahun);
        }
        $this->db->group_by('j.id_pelatihan');
        $this->db->order_by('j.id_pelatihan ASC, a.id_peserta ASC');
        $get = $this->db->get();
        return $get->result_array();
    }

    public function getDataPelatihan($idOPD) {
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
                           GROUP_CONCAT(f.nm_syarat ORDER BY a.id_pelatihan ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'left');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'left');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('ms_unit_kerja h', 'a.id_opd = h.id_opd', 'left');
        $this->db->where('a.id_opd', abs($idOPD));
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('b.mulai_registrasi DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getDataListPendaftar($id_pelatihan)
    {

        $this->db->select('a.id_pelatihan,
                            a.id_opd,
                            a.token,
                            a.id_jadwal,
                            a.id_metode_pelatihan,
                            a.keterangan,
                            a.upload_brosur,
                            a.kuota,
                            b.id_history_pelatihan,
                            b.tanggal_daftar,
                            b.tahun,
                            b.flag,
                            COUNT(c.id_peserta) AS total,
							c.nik,
							c.nama_lengkap,
							c.id_province,
							c.id_regency,
                            d.id_master_pelatihan,
                            e.nm_pelatihan
                            ');
        $this->db->from('data_pelatihan a');
        $this->db->join('data_history_pelatihan b', 'b.id_pelatihan = a.id_pelatihan', 'inner');
        $this->db->join('data_peserta c', 'c.id_peserta = b.id_peserta', 'inner');
        $this->db->join('ms_jadwal d', 'a.id_jadwal = d.id_jadwal', 'inner');
        $this->db->join('ms_pelatihan e', 'd.id_master_pelatihan = e.id_master_pelatihan', 'inner');
        $this->db->where('a.id_pelatihan', abs($id_pelatihan));
        $query = $this->db->get();
        return $query->row_array();
    }
}

// This is the end of auth signin model
