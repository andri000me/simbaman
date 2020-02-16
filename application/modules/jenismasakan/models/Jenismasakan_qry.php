<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Jenismasakan_qry extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
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

    function ExecData($data)
    {
        $idjenismasakan = $data['idjenismasakan'];
        $namajenismasakan = $data['namajenismasakan'];
        $stat = $data['stat'];
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
                    VALUES (UUID(),'$namajenismasakan','$stat');";
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
                        SET namajenismasakan = '$namajenismasakan',
                          stat = '$stat'
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