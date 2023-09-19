<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of fungsi model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_account extends CI_Model
{
    public function cek_password()
    {
        $token = $this->app_loader->current_userid();

        $this->db->where('token', $token);
        $siswa = $this->db->get('xi_sa_users')->row_array();

        $hash_password = $siswa['password'];

        $password = escape($this->input->post('oldpass', TRUE));
        if ($this->bcrypt->check_password($password, $hash_password))
            return TRUE;
        else
            return FALSE;
    }
    public function ubahPass()
    {
        $token = $this->app_loader->current_userid();
        $this->db->where('token', $token);
        $user = $this->db->get('xi_sa_users')->row_array();

        $iduser = $user['id_users'];

        $this->db->where('id_users', $iduser);
        $password = escape($this->input->post('newpass', TRUE));
        $data = array('pass_plain'    => $password);
        $updatedefaultpass = $this->db->update('xi_sa_users_default_pass', $data);


        $this->db->where('id_users', $iduser);
        $password = escape($this->input->post('newpass', TRUE));
        $data = array('password'    => $this->bcrypt->hash_password($password));
        $update = $this->db->update('xi_sa_users', $data);
        return array('response' => 'SUCCESS');
    }
}