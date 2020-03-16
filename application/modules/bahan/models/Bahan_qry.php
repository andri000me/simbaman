<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Bahan_qry extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function list_satuan()
    {
        $sql = "SELECT satuan FROM bahan GROUP BY satuan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_jenismasakan()
    {
        $sql = "SELECT namajenismasakan FROM jenismasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }
    
    function listDataMenu()
    {
        $sql = "SELECT a.idbahan, a.namabahan, a.satuan, a.jenis, b.idmasakanbahan
                FROM bahan AS a
                LEFT OUTER JOIN masakanbahan AS b ON a.idbahan = b.idbahan
                GROUP BY a.idbahan, a.namabahan, a.satuan, a.jenis
                ORDER BY a.namabahan ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
        // $this->db->select('idbahan, namabahan, satuan, jenis, tanggalinsert, stat');
        // $this->db->order_by('namabahan', 'ASC');
        // $query = $this->db->get('bahan');
        // return $query->result_array();
    }

    function listDataMenuWhere($id)
    {
        $this->db->select('idbahan, namabahan, satuan, jenis, tanggalinsert, stat');
        $this->db->where('idbahan', $id);
        $query = $this->db->get('bahan');
        return $query;
    }

    function ExecData($data)
    {
        $idbahan = $data['idbahan'];
        $namabahan = $data['namabahan'];
        $satuan = $data['satuan'];
        $jenis = $data['jenis']; 
        $status = $data['status'];
        
        $q = $this->listDataMenuWhere($idbahan);
        foreach ($q->result() as $t){
            $nama_his = $t->namabahan;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($status == 'delete') {
            
            $this->db->where('idbahan', $idbahan);
            $res = $this->db->delete('bahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idbahan == '') {

                $sql = "INSERT INTO bahan
                    (idbahan, namabahan, satuan, jenis, tanggalinsert, stat)
                    VALUES (UUID(),'$namabahan','$satuan','$jenis',NOW(),'aktif');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE bahan
                        SET namabahan = '$namabahan',
                            satuan = '$satuan',
                            jenis = '$jenis',
                          tanggalinsert = NOW()
                        WHERE idbahan = '$idbahan';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }        
    }

    public function cekDataBahan($id)
    {
        $this->db->select('idmasakanbahan, idbahan');
        $this->db->from('masakanbahan');
        $this->db->where('idbahan', $id);
        $query = $this->db->get();
        return $query;
    }

    function listDataJenismasakan()
    {
        $this->db->select('idjenismasakan,namajenismasakan,stat');
        $this->db->order_by('namajenismasakan', 'ASC');
        $query = $this->db->get('jenismasakan');
        return $query->result_array();
    }

    function listDataJenismasakanWhere($id)
    {
        $this->db->select('idjenismasakan,namajenismasakan,stat');
        $this->db->where('idjenismasakan', $id);
        $query = $this->db->get('jenismasakan');
        return $query;
    }   

    function ExecData_jenismasakan($data)
    {
        $idjenismasakan = $data['idjenismasakan'];
        $namajenismasakan = $data['namajenismasakan'];
        $status = $data['status'];
        
        $q = $this->listDataJenismasakanWhere($idjenismasakan);
        foreach ($q->result() as $t){
            $nama_his = $t->namajenismasakan;
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($status == 'delete') {
            
            $this->db->where('idjenismasakan', $idjenismasakan);
            $res = $this->db->delete('jenismasakan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$nama_his.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idjenismasakan == '') {

                $sql = "INSERT INTO jenismasakan
                    (idjenismasakan, namajenismasakan, stat)
                    VALUES (UUID(),'$namajenismasakan','aktif');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namajenismasakan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE jenismasakan
                        SET namajenismasakan = '$namajenismasakan'
                        WHERE idjenismasakan = '$idjenismasakan';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namajenismasakan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }        
    }

    public function cekDataJenisMasakan($jenis)
    {
        $this->db->select('idbahan');
        $this->db->from('bahan');
        $this->db->where('jenis', $jenis);
        $query = $this->db->get();
        return $query;
    }

}