<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pengguna_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function listdataGrup()
    {
        $this->db->select('idgrup, namagrup');
        $this->db->order_by('namagrup', 'ASC');
        $query = $this->db->get('tgrup');
        return $query->result_array();
    }
    
    function listDataPengguna()
    {
        $this->db->select('tpengguna.idpengguna, tpengguna.username, tpengguna.namalengkap, tpengguna.idpeserta, tpengguna.idgrup, tpengguna.publish, tpengguna.kelamin, tgrup.namagrup');
        $this->db->from('tpengguna');
        $this->db->join('tgrup', 'tpengguna.idgrup = tgrup.idgrup');
        $this->db->where('idpengguna !=', 'b3d07aa1-c7d9-11e5-b2b7-68f72820d6fc');
        $query = $this->db->get();
        return $query->result_array();
    }
            
    function listdataPenggunaWhere($id)
    {
        $this->db->select('idpengguna, username, namalengkap, idpeserta, idgrup, kelamin');
        $this->db->where('idpengguna', $id);
        $query = $this->db->get('tpengguna');
        return $query;
    }
    
    function ExecData($data)
    {
        $idpengguna = $data['idpengguna'];
        $username = $data['username'];
        $password = md5($data['password']);
        $namalengkap = $data['namalengkap'];        
        $kelamin = $data['kelamin'];
        $idgrup = $data['idgrup'];
        $idpeserta = $data['idpeserta'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->listdataPenggunaWhere($idpengguna);
        foreach ($q->result() as $t){
            $nama_his = $t->username;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idpengguna', $idpengguna);
            $res = $this->db->delete('tpengguna');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idpengguna == '') {

                $sql = "INSERT INTO tpengguna
                    (idpengguna,username,PASSWORD,namalengkap,kelamin,foto,idpeserta,idgrup,tglinsert,tglupdate,pembuatid,publish)
                    VALUES (UUID(),'$username','$password','$namalengkap','$kelamin',NULL,'$idpeserta','$idgrup',NOW(),NULL,'$pembuatid',1);";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$username.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                
                $sql = "UPDATE tpengguna
                        SET username = '$username',
                          PASSWORD = '$password',
                          namalengkap = '$namalengkap',
                          kelamin = '$kelamin',
                          idgrup = '$idgrup',
                          tglupdate = NOW(),
                          pembuatid = '$pembuatid',
                          idpeserta = '$idpeserta'
                        WHERE idpengguna = '$idpengguna';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$username.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }
    
    function ExecPublish($data)
    {
        $idpengguna = $data['idpengguna'];
        $pembuatid = $data['pembuatid'];
        $publish = $data['publish'];
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $q = $this->listdataPenggunaWhere($idpengguna);
        foreach ($q->result() as $t){
            $nama_his = $t->username;
        }

        $sql = "UPDATE tpengguna
                SET tglupdate = NOW(),
                  pembuatid = '$pembuatid',
                  publish = '$publish'
                WHERE idpengguna = '$idpengguna';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Publish data: '.$nama_his.' stat : '.$publish.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}