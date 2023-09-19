<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model odp
 *
 * @author Yogi "solop" Kaputra
 */

class Model_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataProvince()
    {
        $this->db->where('id', '13');
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_province');
        $dd_prov[''] = 'Pilih Provinsi';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_prov[$row['id']] = $row['name'];
            }
        }
        return $dd_prov;
    }

    public function getDataRegency()
    {
        $this->db->where('province_id', '13');
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_regency');
        $dd_reg[''] = 'Pilih Daerah';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_reg[$row['id']] = ($row['status'] == 1) ? "KAB " . $row['name'] : $row['name'];
            }
        }
        return $dd_reg;
    }

    public function getDataRegencyByProvince($id)
    {
        $this->db->where('province_id', $id);
        $this->db->order_by('status ASC');
        $this->db->order_by('name ASC');
        $query = $this->db->get('wa_regency');
        return $query->result_array();
    }

    public function getDataDistrictByRegency($id)
    {
        $this->db->where('regency_id', $id);
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_district');
        return $query->result_array();
    }

    public function getDataVillageByDistrict($id)
    {
        $this->db->where('district_id', $id);
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_village');
        return $query->result_array();
    }

    public function getDataStatusNikah()
    {
        $this->db->order_by('id_nikah ASC');
        $query = $this->db->get('ref_status_nikah');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_nikah']] = $row['status_nikah'];
            }
        }
        return $dd_data;
    }

    public function getDataStudy()
    {
        $this->db->order_by('id_study ASC');
        $query = $this->db->get('ref_pendidikan');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_study']] = $row['study'];
            }
        }
        return $dd_data;
    }

    public function getDataAgama()
    {
        $this->db->order_by('id_agama ASC');
        $query = $this->db->get('ref_agama');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_agama']] = $row['agama'];
            }
        }
        return $dd_data;
    }

    public function getDataGender()
    {
        $this->db->order_by('id_gender ASC');
        $query = $this->db->get('ref_gender');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_gender']] = $row['gender'];
            }
        }
        return $dd_data;
    }

    public function getProvinsi()
    {
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_province');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id']] = $row['name'];
            }
        }
        return $dd_data;
    }

    public function getRegency()
    {
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_regency');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id']] = $row['name'];
            }
        }
        return $dd_data;
    }

    public function getKatPel()
    {
        $this->db->order_by('id_jenis_kegiatan ASC');
        $query = $this->db->get('ms_jenis_kegiatan');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_jenis_kegiatan']] = $row['nm_jenis_kegiatan'];
            }
        }
        return $dd_data;
    }

    // User
    public function getDataUserPassword($id_users)
    {
        $this->db->select('pass_plain');
        $this->db->where('id_users', $id_users);
        $query = $this->db->get('xi_sa_users_default_pass');
        return $query->row_array();
    }

    public function getDataUserGroup($id_users)
    {
        $this->db->select('p.id_group, 
		                   g.nama_group');
        $this->db->from('xi_sa_users_privileges p');
        $this->db->join('xi_sa_group g', 'g.id_group = p.id_group', 'inner');
        $this->db->where('p.id_users', $id_users);
        $this->db->where('p.id_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataUserGroupPrivileges($id_users)
    {
        $this->db->where('id_users', abs($id_users));
        $this->db->where('id_status', 1);
        $query = $this->db->get('xi_sa_users_privileges');
        return $query->result_array();
    }

    public function getJenisAkun()
    {
        $this->db->order_by('id_jenis_akun ASC');
        $query = $this->db->get('_status_akun');
        $dd_data[''] = 'Pilih Jawaban';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_jenis_akun']] = $row['jenis_akun'];
            }
        }
        return $dd_data;
    }

    public function getJenisUsaha()
    {
        $this->db->order_by('id_bidang_usaha ASC');
        $query = $this->db->get('wa_bidang_usaha');
        $dd_data[''] = 'Pilih Jawaban';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_bidang_usaha']] = $row['nama_bidang'];
            }
        }
        return $dd_data;
    }

    public function getDataListSyarat()
    {
        $this->db->where('id_status', 1);
        $this->db->order_by('id_syarat ASC');
        $query = $this->db->get('data_syarat');
        return $query->result_array();
    }

    // public function getDataListSyaratShow($id) {
    // 	$this->db->where('a.id_status', 1);
    // 	$this->db->where('a.id_pelatihan', $id);
    // 	$this->db->join('data_rules_syarat b', 'a.id_pelatihan = b.id_pelatihan', 'inner');
    // 	$this->db->order_by('a.id_syarat ASC');
    // 	$query = $this->db->get('data_syarat a');
    // 	return $query->result_array();
    // }

    public function getKatUrusanPemerintahan()
    {
        $this->db->order_by('id_kat_urusan ASC');
        $query = $this->db->get('data_kat_urusan');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_kat_urusan']] = $row['nm_kat_urusan'];
            }
        }
        return $dd_data;
    }

    public function getMasterPelatihan()
    {
        $this->db->select('a.id_master_pelatihan,
                           a.nm_pelatihan,
                           a.id_kat_urusan,
                           a.id_opd,
                           b.nama_opd,
                           ');
        $this->db->from('ms_pelatihan a');
        $this->db->join('ms_unit_kerja b', 'a.id_opd = b.id_opd', 'inner');
        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        $this->db->order_by('a.id_master_pelatihan ASC');
        $query = $this->db->get();
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_master_pelatihan']] = $row['nm_pelatihan'];
            }
        }
        return $dd_data;
    }

    public function getPelatihan()
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
        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        $this->db->order_by('a.id_pelatihan ASC');
        $query = $this->db->get();
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_pelatihan']] = $row['nm_pelatihan'];
            }
        }
        return $dd_data;
    }

    public function getJenisKegiatan()
    {
        $this->db->order_by('id_jenis_kegiatan ASC');
        $query = $this->db->get('ms_jenis_kegiatan');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_jenis_kegiatan']] = $row['nm_jenis_kegiatan'];
            }
        }
        return $dd_data;
    }

    public function getJadwal()
    {
        if ($this->app_loader->is_admin()) {
            $this->db->where('id_opd', $this->app_loader->current_opdid());
        }
        $this->db->order_by('id_jadwal ASC');
        $query = $this->db->get('ms_jadwal');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_jadwal']] = $row['pagu_anggaran'] . ' - ' . $row['nm_sub_kegiatan'];
            }
        }
        return $dd_data;
    }

    public function getDataJadwal($id_jadwal)
    {
        $this->db->select('a.id_jadwal,
                           a.id_master_pelatihan,
                           a.nm_sub_kegiatan,
                           a.tanggal_pelatihan,
                           a.mulai_registrasi,
                           a.akhir_registrasi,
                           a.tempat_pelatihan,
                           a.pagu_anggaran,
                           a.nm_sub_kegiatan,
                           a.id_jenis_kegiatan,
                           a.id_opd,
                           a.id_status,
                           b.nm_jenis_kegiatan,
                           c.nm_pelatihan
                           ');
        $this->db->from('ms_jadwal a');
        $this->db->join('ms_jenis_kegiatan b', 'a.id_jenis_kegiatan = b.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan c', 'a.id_master_pelatihan = c.id_master_pelatihan', 'inner');
        $this->db->where('a.id_jadwal', $id_jadwal);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getDataSyarat()
    {
        $this->db->where('id_status', 1);
        $this->db->order_by('id_syarat', 'ASC');
        $query = $this->db->get('data_syarat');
        $dd_fungsi = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $dd_fungsi[$row->id_syarat] = $row->nm_syarat;
            }
        }
        return $dd_fungsi;
    }

    public function getDataSyaratTambahan()
    {
        $this->db->order_by('id_syarat_dinamis', 'ASC');
        $query = $this->db->get('ms_syarat_dinamis');
        $dd_fungsi = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $dd_fungsi[$row->id_syarat_dinamis] = $row->nm_syarat_dinamis;
            }
        }
        return $dd_fungsi;
    }

    /*get data list rules module index aktif */
    public function showDataSyaratTambahan()
    {
        $this->db->select('a.id_syarat_dinamis,
                           a.nm_syarat_dinamis,
                           a.id_opd
                           ');
        $this->db->from('ms_syarat_dinamis a');
        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    // Combobox pilih pelatihan
    public function getPelatihanOPD()
    {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
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
                           d.id_kat_urusan
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        $query = $this->db->get();
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_pelatihan']] = $row['tanggal_pelatihan'] . '-' . $row['tanggal_pelatihan_akhir'] . ' / ' . $row['pagu_anggaran'] . ' / ' . $row['nm_pelatihan'];
            }
        }
        return $dd_data;
    }

    public function getOPD()
    {
        if ($this->app_loader->current_opdid() == 1 || $this->app_loader->current_opdid() == 17 || $this->app_loader->is_super() || $this->app_loader->is_pimpinan()) {
        } else {
            $this->db->where('id_opd', $this->app_loader->current_opdid());
        }
        $this->db->where('id_opd <>', 17);
        $this->db->order_by('id_opd ASC');
        $query = $this->db->get('ms_unit_kerja');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_opd']] = $row['nama_opd'];
            }
        }
        return $dd_data;
    }

    public function getbentuk_permodalan()
    {
        $this->db->order_by('id_bentuk_permodalan ASC');
        $query = $this->db->get('ref_bentuk_permodalan');
        $dd_data[''] = 'Pilih Data';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dd_data[$row['id_bentuk_permodalan']] = $row['nm_bentuk_permodalan'];
            }
        }
        return $dd_data;
    }
}

// This is the end of auth signin model
