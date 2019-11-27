<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Profil_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }
            
    function listdataPenggunaWhere($id)
    {
        $this->db->select('idpengguna, username, namalengkap, idgrup, kelamin, foto');
        $this->db->where('idpengguna', $id);
        $query = $this->db->get('tpengguna');
        return $query;
    }
    
    function getWherePengguna($idpengguna){
        $sql = "SELECT username
		FROM tpengguna
		WHERE idpengguna = '$idpengguna';";
	return $this->db->query($sql);
    }
    
    function ExecData($data)
    {
        $idpengguna = $data['idpengguna'];
        $username = $data['username'];
        $password = md5($data['password']);
        $namalengkap = $data['namalengkap'];        
        $kelamin = $data['kelamin'];
        $pembuatid = $data['pembuatid'];
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $sql = "UPDATE tpengguna
                SET username = '$username',
                  PASSWORD = '$password',
                  namalengkap = '$namalengkap',
                  kelamin = '$kelamin',
                  tglupdate = NOW(),
                  pembuatid = '$pembuatid'
                WHERE idpengguna = '$idpengguna';";
        $res = $this->db->query($sql);

        if($res) {
            $data['msg'] = 'Ubah profil data: '.$username.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function getWhereFoto($idpengguna){
        $sql = "SELECT foto
		FROM tpengguna
		WHERE idpengguna = '$idpengguna';";
	return $this->db->query($sql);
    }
    
    function updateFoto($idpengguna,$fileName){
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $pengguna = $this->getWherePengguna($idpengguna);
        foreach($pengguna->result() as $t){
            $username = $t->username;
        }
        
        $sql = "UPDATE tpengguna
                SET foto = '$fileName',
                  tglupdate = now()
                WHERE idpengguna = '$idpengguna';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Ubah foto data: '.$username.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }        
    }
    
    function unlinkFoto($idpengguna){
        $pengguna = $this->getWhereFoto($idpengguna);
        foreach($pengguna->result() as $t){
            $foto = $t->foto;
        }
        
        if (file_exists($foto)){
            unlink($foto);
            return;
        } else {
            return;
        }
    }
    
    function hapusFoto($idpengguna){
        $pengguna = $this->getWhereFoto($idpengguna);
        foreach($pengguna->result() as $t){
            $foto = $t->foto;
        }
        
        if ($foto == null){
            return TRUE;
        } else {            
            $result = unlink($foto);

            if ($result){
                
                $data['type'] = 'staff';
                $data['username'] = $this->session->userdata('username');
                $data['url'] = $this->session->userdata('url');
                $ip_address = $this->input->ip_address();
                $user_agent = $this->input->user_agent();

                $user = $this->getWherePengguna($idpengguna);
                foreach($user->result() as $t){
                    $username = $t->username;
                }
                
                $sql = "UPDATE tpengguna
                        SET foto = NULL,
                          tglupdate = now()
                        WHERE idpengguna = '$idpengguna';";
                $res = $this->db->query($sql);
                if($res) {
                    $data['msg'] = 'Menghapus foto data: '.$username.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }        
    }
}