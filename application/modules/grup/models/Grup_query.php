<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Grup_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }
    
    function listDataGrup()
    {
        $this->db->select('idgrup, namagrup, keterangan, publish');
        $this->db->order_by('namagrup', 'ASC');
        $query = $this->db->get('tgrup');
        return $query->result_array();
    }
    
    function listdataGrupWhere($id)
    {
        $this->db->select('idgrup, namagrup, keterangan, publish');
        $this->db->where('idgrup', $id);
        $query = $this->db->get('tgrup');
        return $query;
    }
    
    function ExecData($data)
    {
        $idgrup = $data['idgrup'];
        $namagrup = $data['namagrup'];
        $keterangangrup = $data['keterangangrup'];        
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->listdataGrupWhere($idgrup);
        foreach ($q->result() as $t){
            $nama_his = $t->namagrup;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idgrup', $idgrup);
            $res = $this->db->delete('tgrup');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idgrup == '') {

                $sql = "INSERT INTO tgrup
                    (idgrup,namagrup,keterangan,tglinsert,tglupdate,pembuatid,publish)
                    VALUES (UUID(),'$namagrup','$keterangangrup',NOW(),NULL,'$pembuatid',1);";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namagrup.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE tgrup
                        SET namagrup = '$namagrup',
                          keterangan = '$keterangangrup',
                          tglupdate = NOW(),
                          pembuatid = '$pembuatid'
                        WHERE idgrup = '$idgrup';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namagrup.', IP: '.$ip_address.', Browser: '.$user_agent;
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
        $idgrup = $data['idgrup'];
        $pembuatid = $data['pembuatid'];
        $publish = $data['publish'];
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $q = $this->listdataGrupWhere($idgrup);
        foreach ($q->result() as $t){
            $nama_his = $t->namagrup;
        }

        $sql = "UPDATE tgrup
                SET tglupdate = NOW(),
                  pembuatid = '$pembuatid',
                  publish = '$publish'
                WHERE idgrup = '$idgrup';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Publish data: '.$nama_his.' stat : '.$publish.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function cekDataGrupPengguna($id)
    {
        $this->db->select('idpengguna, idgrup');
        $this->db->where('idgrup', $id);
        $query = $this->db->get('tpengguna');
        return $query;
    }
    
    function listdataModul()
    {
        $this->db->select('tmenu.idmenu, tmenu.namamenu, tmenu.urutan, tmodul.idmodul, tmodul.namamodul');
        $this->db->from('tmenu');
        $this->db->join('tmodul', 'tmenu.idmenu = tmodul.idmenu');
        $this->db->order_by('tmenu.urutan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //=== Hak Akses View, Add, Edit, Delete ==============
    
    function listDataWhere_Modul($id)
    {
        $this->db->select('tmodul.idmodul, tmodul.idmenu, tmodul.namamodul, tmodul.linkmodul, tmodul.keterangan, tmodul.publish, tmodul.urutan, tmenu.namamenu');
        $this->db->from('tmodul');
        $this->db->join('tmenu', 'tmodul.idmenu = tmenu.idmenu');
        $this->db->where('tmodul.idmodul', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function whereView($idmodulx,$idgrupx)
    {
        $this->db->select('idhakakses, idmodul, idgrup
                    , visited, created, updated, deleted');
        $this->db->where('idmodul', $idmodulx);
        $this->db->where('idgrup', $idgrupx);
        $query = $this->db->get('thakakses');
        return $query;
    }
    
    function insertDataView($data)
    {        
        $idmodul = $data['idmodul'];
        $idgrup = $data['idgrup'];
        $cek = $data['cek'];
        $pembuatid = $data['pembuatid'];

        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_modul = $val['namamodul'];
        }
        
        $g = $this->listdataGrupWhere($idgrup);
        foreach ($g->result() as $t){
            $nama_grup = $t->namagrup;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $sql = "INSERT INTO thakakses
                (idhakakses,idmodul,idgrup,visited,created,updated,deleted,tglinsert,tglupdate,pembuatid)
                VALUES (UUID(),'$idmodul','$idgrup','$cek',0,0,0,NOW(),NULL,'$pembuatid');";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Menambah hak akses modul: '.$nama_modul.' pada grup: '.$nama_grup.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function updateDataView($data)
    {        
        $idmodul = $data['idmodul'];
        $idgrup = $data['idgrup'];
        $cek = $data['cek'];
        $pembuatid = $data['pembuatid'];

        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_modul = $val['namamodul'];
        }
        
        $g = $this->listdataGrupWhere($idgrup);
        foreach ($g->result() as $t){
            $nama_grup = $t->namagrup;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $sql = "UPDATE thakakses
                SET  visited = '$cek',
                  tglupdate = NOW(),
                  pembuatid = '$pembuatid'
                WHERE idmodul = '$idmodul'
                  AND idgrup = '$idgrup';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Mengubah hak akses modul: '.$nama_modul.' pada grup: '.$nama_grup.' visited: '.$cek.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function updateDataAdd($data)
    {        
        $idmodul = $data['idmodul'];
        $idgrup = $data['idgrup'];
        $cek = $data['cek'];
        $pembuatid = $data['pembuatid'];

        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_modul = $val['namamodul'];
        }
        
        $g = $this->listdataGrupWhere($idgrup);
        foreach ($g->result() as $t){
            $nama_grup = $t->namagrup;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $sql = "UPDATE thakakses
                SET  created = '$cek',
                  tglupdate = NOW(),
                  pembuatid = '$pembuatid'
                WHERE idmodul = '$idmodul'
                  AND idgrup = '$idgrup';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Mengubah hak akses modul: '.$nama_modul.' pada grup: '.$nama_grup.' created: '.$cek.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function updateDataEdit($data)
    {        
        $idmodul = $data['idmodul'];
        $idgrup = $data['idgrup'];
        $cek = $data['cek'];
        $pembuatid = $data['pembuatid'];

        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_modul = $val['namamodul'];
        }
        
        $g = $this->listdataGrupWhere($idgrup);
        foreach ($g->result() as $t){
            $nama_grup = $t->namagrup;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $sql = "UPDATE thakakses
                SET  updated = '$cek',
                  tglupdate = NOW(),
                  pembuatid = '$pembuatid'
                WHERE idmodul = '$idmodul'
                  AND idgrup = '$idgrup';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Mengubah hak akses modul: '.$nama_modul.' pada grup: '.$nama_grup.' updated: '.$cek.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function updateDataDelete($data)
    {        
        $idmodul = $data['idmodul'];
        $idgrup = $data['idgrup'];
        $cek = $data['cek'];
        $pembuatid = $data['pembuatid'];
        
        $q = $this->listDataWhere_Modul($idmodul);
        foreach ($q as $key => $val){
            $nama_modul = $val['namamodul'];
        }
        
        $g = $this->listdataGrupWhere($idgrup);
        foreach ($g->result() as $t){
            $nama_grup = $t->namagrup;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        $sql = "UPDATE thakakses
                SET  deleted = '$cek',
                  tglupdate = NOW(),
                  pembuatid = '$pembuatid'
                WHERE idmodul = '$idmodul'
                  AND idgrup = '$idgrup';";
        $res = $this->db->query($sql);
        
        if($res) {
            $data['msg'] = 'Mengubah hak akses modul: '.$nama_modul.' pada grup: '.$nama_grup.' deleted: '.$cek.', IP: '.$ip_address.', Browser: '.$user_agent;
            $this->sistemlog->aktifitas($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}