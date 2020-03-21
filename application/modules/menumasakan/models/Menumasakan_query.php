<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-15 11:33:03
 * @modify date 2019-09-15 11:33:03
 * @desc [description]
 */

class Menumasakan_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function list_kelaspasien()
    {
        // $sql = "SELECT a.idkelas, b.namakelas
        //         FROM rekapjumlahpasien AS a
        //         INNER JOIN kelas AS b ON a.idkelas = b.idkelas
        //         GROUP BY a.idkelas, b.namakelas";

        $sql = "SELECT idkelas, namakelas FROM kelas ORDER BY urutan ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_namakelas($idkelas)
    {
        // $sql = "SELECT a.idkelas, b.namakelas
        //         FROM menumasakan AS a INNER JOIN
        //         kelas AS b ON a.idkelas = b.idkelas
        //         WHERE a.idkelas = '$idkelas'
        //         GROUP BY a.idkelas, b.namakelas";

        $sql = "SELECT idkelas, namakelas FROM kelas WHERE idkelas = '$idkelas';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataMenu($idkelas)
    {
        $sql = "SELECT a.idkelas, a.idjenismenu, b.namajenismenu
                FROM menumasakan AS a INNER JOIN
                jenismenu AS b ON a.idjenismenu = b.idjenismenu
                WHERE a.idkelas = '$idkelas'
                GROUP BY a.idkelas, a.idjenismenu, b.namajenismenu";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataWaktu($idkelas)
    {
        $sql = "SELECT a.idkelas, a.idjenismenu, a.idwaktumenu, b.namawaktumenu
                    FROM menumasakan AS a INNER JOIN
                    waktumenu AS b ON a.idwaktumenu = b.idwaktumenu
                    WHERE a.idkelas = '$idkelas'
                    GROUP BY a.idkelas, a.idjenismenu, a.idwaktumenu, b.namawaktumenu";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataMasakan($idkelas)
    {
        $sql = "SELECT a.idkelas, a.idjenismenu, a.idwaktumenu, a.idmasakan, b.namamasakan
                FROM menumasakan AS a INNER JOIN
                masakan AS b ON a.idmasakan = b.idmasakan
                WHERE a.idkelas = '$idkelas'
                GROUP BY a.idkelas, a.idjenismenu, a.idwaktumenu, a.idmasakan, b.namamasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_kelas()
    {
        $sql = "SELECT idkelas, namakelas
                FROM kelas ORDER BY urutan ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_jenismenu()
    {
        $sql = "SELECT idjenismenu, namajenismenu
                FROM jenismenu ORDER BY namajenismenu ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_waktumenu()
    {
        $sql = "SELECT idwaktumenu, namawaktumenu
                FROM waktumenu ORDER BY waktu ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_masakan()
    {
        $sql = "SELECT idmasakan, namamasakan
                FROM masakan ORDER BY namamasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataKelasWhere($idkelas)
    {
        $sql = "SELECT idkelas, namakelas
                FROM kelas WHERE idkelas = '$idkelas';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataJenisMenuWhere($idjenismenu)
    {
        $sql = "SELECT idjenismenu, namajenismenu
                FROM jenismenu WHERE idjenismenu = '$idjenismenu';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataWaktuMenuWhere($idwaktumenu)
    {
        $sql = "SELECT idwaktumenu, namawaktumenu
                FROM waktumenu WHERE idwaktumenu = '$idwaktumenu';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdataMasakanWhere($idmasakan)
    {
        $sql = "SELECT idmasakan, namamasakan
                FROM masakan WHERE idmasakan = '$idmasakan';";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function id()
    {
        $sql = "SELECT UUID() AS id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]['id'];
    }

    public function ExecData_menumasakan($data)
    {
        $idmenumasakan = $data['idmenumasakan'];
        $idkelas = $data['idkelas'];
        $idjenismenu = $data['idjenismenu'];
        $idwaktumenu = $data['idwaktumenu'];
        $idmasakan = $data['idmasakan'];
        $stat = $data['stat'];
        
        $q = $this->listdataKelasWhere($idkelas);
        foreach ($q as $a){
            $namakelas = $a['namakelas'];
        }

        $r = $this->listdataJenisMenuWhere($idjenismenu);
        foreach ($r as $b){
            $namajenismenu = $b['namajenismenu'];
        }

        $s = $this->listdataWaktuMenuWhere($idwaktumenu);
        foreach ($s as $c){
            $namawaktumenu = $c['namawaktumenu'];
        }

        $t = $this->listdataMasakanWhere($idmasakan);
        foreach ($t as $d){
            $namamasakan = $d['namamasakan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('idmenumasakan', $idmenumasakan);
            $res = $this->db->delete('menumasakan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$namakelas.' '.$namajenismenu.' '.$namawaktumenu.' '.$namamasakan.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idmenumasakan == '') {

                $sql = "INSERT INTO menumasakan
                    (idmenumasakan,idkelas,namakelas,idjenismenu,namajenismenu,idwaktumenu,namawaktumenu,idmasakan,namamasakan,tanggalinsert,stat)
                    VALUES (UUID(),'$idkelas','$namakelas','$idjenismenu','$namajenismenu','$idwaktumenu','$namawaktumenu','$idmasakan','$namamasakan',NOW(),'aktif');";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$namakelas.' '.$namajenismenu.' '.$namawaktumenu.' '.$namamasakan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    echo $idkelas.'/'.$idjenismenu;
                } else {
                    return FALSE;
                }
            } 
        }
    }

    public function listDataKelas($idkelas,$idjenismenu)
    {
        $sql = "SELECT a.idkelas, a.idjenismenu
                        , b.namakelas, c.namajenismenu
                FROM menumasakan AS a 
                    INNER JOIN kelas AS b ON a.idkelas = b.idkelas 
                    INNER JOIN jenismenu AS c ON a.idjenismenu = c.idjenismenu
                WHERE a.idkelas = '$idkelas'
                    AND a.idjenismenu = '$idjenismenu'
                GROUP BY a.idkelas, a.idjenismenu, b.namakelas, c.namajenismenu";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataKelasMenuWaktu($idkelas,$idjenismenu)
    {
        $sql = "SELECT a.idwaktumenu
                    , b.namawaktumenu
                FROM menumasakan AS a 
                    INNER JOIN waktumenu AS b ON a.idwaktumenu = b.idwaktumenu 
                WHERE a.idkelas = '$idkelas'
                    AND a.idjenismenu = '$idjenismenu'
                GROUP BY a.idwaktumenu, b.namawaktumenu ORDER BY b.waktu";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listDataKelasMenuMasakan($idkelas,$idjenismenu)
    {
        $sql = "SELECT a.idmenumasakan, a.idwaktumenu, a.idmasakan, a.idkelas, a.idjenismenu
                , b.namamasakan
                FROM menumasakan AS a 
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan 
                WHERE a.idkelas = '$idkelas'
                    AND a.idjenismenu = '$idjenismenu'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_menumasakan($idmenumasakan)
    {
        $sql = "SELECT a.idmenumasakan, a.idkelas, a.idjenismenu, a.idwaktumenu, a.idmasakan
                , b.namamasakan
                FROM menumasakan AS a
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                WHERE a.idmenumasakan = '$idmenumasakan'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_DataKelasMenuMasakan($idkelas)
    {
        $sql = "SELECT idmenumasakan
                FROM menumasakan WHERE idkelas = '$idkelas'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function jenismenumasakan()
    {
        $sql = "SELECT a.idjenismenu, b.namajenismenu
                FROM ref_menumasakan AS a
                INNER JOIN jenismenu AS b ON a.idjenismenu = b.idjenismenu
                GROUP BY a.idjenismenu, b.namajenismenu";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function kelasmenumasakan()
    {
        $sql = "SELECT a.idkelas, b.namakelas, a.idjenismenu
                FROM ref_menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                GROUP BY a.idkelas, b.namakelas, a.idjenismenu
                ORDER BY b.namakelas ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function waktumenumasakan()
    {
        $sql = "SELECT a.idwaktumenu, d.namawaktumenu, d.waktu, a.idjenismenu
                FROM ref_menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                GROUP BY a.idwaktumenu, d.namawaktumenu, d.waktu, a.idjenismenu
                ORDER BY d.waktu ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function menumasakan()
    {
        $sql = "SELECT a.idkelas, b.namakelas
                , a.idwaktumenu, d.namawaktumenu, d.waktu
                , a.idmasakan, e.namamasakan
                , a.idjenismenu
                FROM ref_menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                ORDER BY e.namamasakan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_reset_menumasakan()
    {
        $delete = "TRUNCATE TABLE menumasakan;";
        $q_del = $this->db->query($delete);

        if ($q_del) {
            $insert = "INSERT INTO menumasakan
                    (idmenumasakan,
                    idkelas,namakelas,
                    idjenismenu,namajenismenu,
                    idwaktumenu,namawaktumenu,
                    idmasakan,namamasakan,
                    tanggalinsert,stat)
                SELECT idmenumasakan
                    , idkelas, namakelas
                    , idjenismenu, namajenismenu
                    , idwaktumenu, namawaktumenu
                    , idmasakan, namamasakan
                    , NOW() AS tanggalinsert, stat
                FROM ref_menumasakan";
            $q_insert = $this->db->query($insert);

            if($q_insert) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function jenismenumasakan_fix()
    {
        $sql = "SELECT a.idjenismenu, b.namajenismenu
                FROM menumasakan AS a
                INNER JOIN jenismenu AS b ON a.idjenismenu = b.idjenismenu
                GROUP BY a.idjenismenu, b.namajenismenu";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function kelasmenumasakan_fix()
    {
        $sql = "SELECT a.idkelas, b.namakelas, a.idjenismenu
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                GROUP BY a.idkelas, b.namakelas, a.idjenismenu
                ORDER BY b.namakelas ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function waktumenumasakan_fix()
    {
        $sql = "SELECT a.idwaktumenu, d.namawaktumenu, d.waktu, a.idjenismenu
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                GROUP BY a.idwaktumenu, d.namawaktumenu, d.waktu, a.idjenismenu
                ORDER BY d.waktu ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function menumasakan_fix()
    {
        $sql = "SELECT a.idkelas, b.namakelas
                , a.idwaktumenu, d.namawaktumenu, d.waktu
                , a.idmasakan, e.namamasakan
                , a.idjenismenu
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                ORDER BY e.namamasakan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}