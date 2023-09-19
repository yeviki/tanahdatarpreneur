<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @author Yogi Kaputra
 *
 */

/**
 * Fungsi membuat pesan error
 */
if (!function_exists('error_message')) {
    function error_message($type, $label, $message) {
        $ci =& get_instance();
        $error = '<div class="alert alert-dismissable alert-'.$type.'">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			        <strong>'.$label.'</strong> '.$message.'
			      </div>';
        $ci->session->set_flashdata('message', $error);
    }
}

/**
 * Fungsi Validation Message Setting
 */
if (!function_exists('validation_message_setting')) {
    function validation_message_setting() {
        $ci =& get_instance();
        $ci->form_validation->set_message('required','%s harus diisi.');
        $ci->form_validation->set_message('min_length','%s sekurang-kurangnya harus berisi %s karakter.');
        $ci->form_validation->set_message('max_length','%s tidak boleh lebih dari %s karakter.');
        $ci->form_validation->set_message('valid_email','%s harus diisi dengan alamat email yang valid.');
        $ci->form_validation->set_message('numeric','%s harus bernilai angka yang valid.');
        $ci->form_validation->set_message('integer','%s harus bernilai bilangan bulat yang valid.');
        $ci->form_validation->set_message('matches','%s tidak cocok dengan %s.');
        $ci->form_validation->set_message('is_unique','%s sudah digunakan.');
        $ci->form_validation->set_message('is_natural_no_zero','%s tidak boleh diisi dengan nol.');
        $ci->form_validation->set_message('alpha_numeric','%s hanya boleh diisi dengan huruf atau angka.');
        $ci->form_validation->set_message('alpha','%s hanya boleh diisi dengan huruf.');
        $ci->form_validation->set_message('alpha_dash','%s hanya boleh diisi dengan huruf, angka, garis bawah atau tanda penghubung.');
        $ci->form_validation->set_message('regex_match','%s minimal 8 karakter, mengandung satu huruf besar, satu huruf kecil, satu angka dan satu karakter khusus.');
        $ci->form_validation->set_error_delimiters('<div class="has-error"><p class="help-block">', '</p></div>');
    }
}

/**
 * Fungsi generate token
 */
if (!function_exists('generateToken')) {
    function generateToken($param1, $param2) {
        $datetime = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $token 	  = strtoupper(substr(sha1(rand().$datetime.$param1.$param2), 0, 32));
        return $token;
    }
}

/**
 * Fungsi generate key validate
 */
if (!function_exists('generateKey')) {
    function generateKey($param1, $param2) {
        $datetime = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $key 	  = strtoupper(substr(sha1(rand().$datetime.$param1.$param2), 0, 64));
        return $key;
    }
}

/**
 * Fungsi status
 */
if (!function_exists('status')) {
    function status() {
        $status = array(
            1 => "AKTIF",
            0 => "TIDAK AKTIF"
        );
        return $status;
    }
}

/**
 * Fungsi convert status
 */
if (!function_exists('convert_status')) {
    function convert_status($id_status) {
        $status = array(
            0 => '<span class="badge badge-pill badge-danger">TIDAK AKTIF</span>',
            1 => '<span class="badge badge-pill badge-success">AKTIF</span>',
        );
        return $status[intval($id_status)];
    }
}

/**
 * Fungsi Metode Pelatihan
 */
if (!function_exists('metode_pel')) {
    function metode_pel() {
        $status = array(
            1 => "Tatap muka dan mengikuti protokol kesehatan",
            2 => "Pelatihan ini dilaksanakan secara Online"
        );
        return $status;
    }
}

/**
 * Fungsi convert Metode Pelatihan
 */
if (!function_exists('convert_metodepel_badge')) {
    function convert_metodepel_badge($id_status) {
        $status = array(
            1 => '<span class="badge badge-danger"><i class="fas fa-info-circle"></i> Tatap muka dan mengikuti protokol kesehatan</span>',
            2 => '<span class="badge badge-success"><i class="fas fa-info-circle"></i> Pelatihan ini dilaksanakan secara Online</span>',
        );
        return $status[intval($id_status)];
    }
}
if (!function_exists('convert_metodepel_text')) {
    function convert_metodepel_text($id_status) {
        $status = array(
            1 => '<i class="fas fa-info-circle"></i> Tatap muka dan mengikuti protokol kesehatan',
            2 => '<i class="fas fa-info-circle"></i> Pelatihan ini dilaksanakan secara Online',
        );
        return $status[intval($id_status)];
    }
}

/**
 * Fungsi convert status
 */
if (!function_exists('convert_statpel')) {
    function convert_statpel($id_status) {
        $status = array(
            4 => '<span class="badge badge-pill badge-default">DONE</span>',
            3 => '<span class="badge badge-pill badge-success">OPEN</span>',
            2 => '<span class="badge badge-pill badge-danger">CLOSE</span>',
            1 => '<span class="badge badge-pill badge-info">WAIT</span>',
            0 => '<span class="badge badge-pill badge-secondary">REGISTER</span>',
        );
        return $status[intval($id_status)];
    }
}

/**
 * Fungsi convert status
 */
if (!function_exists('convert_flag')) {
    function convert_flag($flag) {
        $status = array(
            4 => '<span class="badge badge-pill badge-default">SELESAI</span>',
            3 => '<span class="badge badge-pill badge-danger">TOLAK</span>',
            2 => '<span class="badge badge-pill badge-info">SETUJU</span>',
            1 => '<span class="badge badge-pill badge-secondary">REGISTER</span>',
        );
        return $status[intval($flag)];
    }
}

/**
 * Fungsi blokir
 */
if (!function_exists('blokir')) {
    function blokir() {
        $blokir = array(
            0 => "TIDAK",
            1 => "YA",
        );
        return $blokir;
    }
}

/**
 * Fungsi convert blokir
 */
if (!function_exists('convert_blokir')) {
    function convert_blokir($id_blokir) {
        $blokir = array(
            0 => '<span class="badge badge-pill badge-success">TIDAK</span>',
            1 => '<span class="badge badge-pill badge-danger">YA</span>',
        );
        return $blokir[intval($id_blokir)];
    }
}

/**
 * Fungsi convert jenis fungsi
 */
if (!function_exists('convert_jenis_fungsi')) {
    function convert_jenis_fungsi($id_jenis_fungsi) {
        switch ($id_jenis_fungsi) {
            case '1': $jenis = "Fungsi Public";
                break;
            case '2': $jenis = "Fungsi Pendukung";
                break;
            case '3': $jenis = "Fungsi Private";
                break;
            case '4': $jenis = "Fungsi Belum Ada";
                break;
            default: $jenis = "";
                break;
        }
        return $jenis;
    }
}

/**
 * Fungsi gender
 */
if (!function_exists('gender')) {
    function gender() {
        $gender= array(
            1 => "LAKI-LAKI",
            2 => "PEREMPUAN"
        );
        return $gender;
    }
}

if (!function_exists('jenis_kelamin')) {
    function jenis_kelamin($B_06, $singkat = FALSE) {
        if ($singkat) {
            $arr = array(
                0 => "",
                1 => "L",
                2 => "P"
            );
        } else {
            $arr = array(
                0 => "",
                1 => "LAKI-LAKI",
                2 => "PEREMPUAN"
            );
        }
        return $arr[intval($B_06)];
    }
}

if (!function_exists('replace_backslases')) {
    function replace_backslases($arr) {
        $to = array();
        foreach ($arr as $k => $str) {
            $to[$k] = stripslashes($str);
        }
        return $to;
    }
}

/**
 * Fungsi menerima pinjaman
 */
if (!function_exists('menerima_pinjaman')) {
    function menerima_pinjaman() {
        $menerima_pinjaman = array(
            "N" => "TIDAK PERNAH",
            "Y" => "PERNAH"
        );
        return $menerima_pinjaman;
    }
}

/**
 * Fungsi menerima pinjaman
 */
if (!function_exists('skala_usaha')) {
    function skala_usaha() {
        $skala_usaha = array(
            1 => "Mikro (Asset dibawah Rp. 1 Milyar)",
            2 => "Menengah (Asset Rp. 1 M s/d 5 M)",
            3 => "Menengah (Asset > Rp. 5 M)"
        );
        return $skala_usaha;
    }
}

/**
 * Fungsi status permodalan
 */
if (!function_exists('bentuk_permodalan')) {
    function bentuk_permodalan() {
        $bentuk_permodalan = array(
            1 => "UANG",
            2 => "PERALATAN"
        );
        return $bentuk_permodalan;
    }
}

/**
 * Fungsi convert status permodalan
 */
if (!function_exists('convert_bentuk_permodalan')) {
    function convert_bentuk_permodalan($id_bentuk_permodalan) {
        $bentuk_permodalan = array(
            1 => '<span class="badge badge-pill badge-danger">UANG</span>',
            2 => '<span class="badge badge-pill badge-success">PERALATAN</span>',
        );
        return $bentuk_permodalan[intval($id_bentuk_permodalan)];
    }
}
/* End of file inc.php */
/* Location: ./application/helpers/inc_helper.php */
