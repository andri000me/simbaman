<?php

class Dietmasakan_query extends CI_Model {
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

    public function list_dietpasien()
    {
        $sql = "SELECT iddiet, namadiet FROM diet WHERE stat = 'aktif' ORDER BY urutan ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_diet($iddiet)
    {
        $sql = "SELECT iddiet, namadiet FROM diet WHERE iddiet = '$iddiet'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_masakan()
    {
        $sql = "SELECT a.idmasakan, b.namamasakan
                FROM menumasakan AS a
                INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                GROUP BY a.idmasakan, b.namamasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function list_masakanbahan($idmasakan)
    {
        $sql = "SELECT a.idmasakan, b.namamasakan 
                    , c.idbahan, d.namabahan
                    , c.kuantitas, c.satuan
                    FROM menumasakan AS a
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                    INNER JOIN masakanbahan AS c ON a.idmasakan = c.idmasakan
                    INNER JOIN bahan AS d ON c.idbahan = d.idbahan
                    WHERE a.idmasakan = '$idmasakan'
                    GROUP BY a.idmasakan, b.namamasakan
                    , c.idbahan, d.namabahan
                    , c.kuantitas, c.satuan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return json_encode($res);
    }

    public function get_masakan($idmasakan)
    {
        $sql = "SELECT idmasakan, namamasakan
                FROM masakan
                WHERE idmasakan = '$idmasakan'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_bahan($idbahan)
    {
        $sql = "SELECT idbahan, namabahan
                FROM bahan
                WHERE idbahan = '$idbahan'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function ExecData_dietmasakan($data)
    {
        $iddietmasakanbahan = $data['iddietmasakanbahan'];
        $iddiet = $data['iddiet'];
        $idmasakan = $data['idmasakan'];
        $idbahan = $data['idbahan'];
        $pengurangan = $data['pengurangan'];
        $satuan = $data['satuan'];
        $penambahan = $data['penambahan'];
        $satuan_tambah = $data['satuan_tambah'];
        $stat = $data['stat'];

        $pembuatid = $this->session->userdata('idpengguna');
        
        $q = $this->get_diet($iddiet);
        foreach ($q as $a){
            $namadiet = $a['namadiet'];
        }

        $r = $this->get_masakan($idmasakan);
        foreach ($r as $b){
            $namamasakan = $b['namamasakan'];
        }

        $s = $this->get_bahan($idbahan);
        foreach ($s as $c){
            $namabahan = $c['namabahan'];
        }

        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        
        if ($stat == 'delete') {
            $this->db->where('iddietmasakanbahan', $iddietmasakanbahan);
            $res = $this->db->delete('dietmasakanbahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$namadiet.' '.$namamasakan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($iddietmasakanbahan == '') {

                $sql = "INSERT INTO dietmasakanbahan
                            (iddietmasakanbahan,iddiet,namadiet,idmasakan,namamasakan,idbahan,namabahan
                                ,pengurangan,satuan
                                ,penambahan,satuan_tambah
                                ,tanggalinsert,idpengguna)
                    VALUES (UUID(),'$iddiet','$namadiet','$idmasakan','$namamasakan','$idbahan','$namabahan'
                        ,'$pengurangan','$satuan'
                        ,'$penambahan','$satuan_tambah'
                        ,NOW(),'$pembuatid');";
                $res = $this->db->query($sql);

                if($res) {
                    $data['msg'] = 'Tambah data: '.$namadiet.' '.$namamasakan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }

            } else {
                $sql = "UPDATE dietmasakanbahan
                            SET pengurangan = '$pengurangan',
                                satuan = '$satuan',
                                penambahan = '$penambahan',
                                satuan_tambah = '$satuan_tambah',
                                tanggalinsert = NOW(),
                                idpengguna = '$pembuatid'
                            WHERE iddietmasakanbahan = '$iddietmasakanbahan';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$namadiet.' '.$namamasakan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function get_dietmasakan($iddiet)
    {
        $sql = "SELECT a.idmasakan, b.namamasakan
                FROM dietmasakanbahan AS a
                INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                WHERE a.iddiet = '$iddiet'
                GROUP BY a.idmasakan, b.namamasakan";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_dietmasakanbahan($iddiet)
    {
        $sql = "SELECT a.iddietmasakanbahan ,a.idmasakan, b.namamasakan
                , a.idbahan, d.namabahan, d.satuan, d.jenis
                , c.kuantitas, c.satuan AS satuan_kauntitas
                , a.pengurangan, a.satuan AS satuan_pengurangan
                , a.penambahan, a.satuan_tambah
                FROM dietmasakanbahan AS a
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                    INNER JOIN masakanbahan AS c ON a.idmasakan = c.idmasakan AND a.idbahan = c.idbahan
                    INNER JOIN bahan AS d ON a.idbahan = d.idbahan
                WHERE a.iddiet = '$iddiet'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_dietmasakanbahanwhere($iddietmasakanbahan)
    {
        $sql = "SELECT a.iddietmasakanbahan, a.iddiet, e.namadiet
                    , a.idmasakan, b.namamasakan
                    , a.idbahan, d.namabahan, d.satuan, d.jenis
                    , c.kuantitas, c.satuan AS satuan_kauntitas
                    , a.pengurangan, a.satuan AS satuan_pengurangan
                    , a.penambahan, a.satuan_tambah
                FROM dietmasakanbahan AS a
                    INNER JOIN masakan AS b ON a.idmasakan = b.idmasakan
                    INNER JOIN masakanbahan AS c ON a.idmasakan = c.idmasakan AND a.idbahan = c.idbahan
                    INNER JOIN bahan AS d ON a.idbahan = d.idbahan
                    INNER JOIN diet AS e ON a.iddiet = e.iddiet
                WHERE a.iddietmasakanbahan = '$iddietmasakanbahan'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function listdiet()
    {
        $sql = "SELECT iddiet, namadiet, urutan, stat FROM diet ORDER BY urutan ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    function ExecData_Diet($data)
    {
        $iddiet = $data['iddiet'];
        $namadiet = $data['namadiet'];
        $urutan = $data['urutan'];
        $stat = $data['stat'];
                
        if ($stat == 'delete') {
            $this->db->where('iddiet', $iddiet);
            $res = $this->db->delete('diet');
            
            if($res) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($iddiet == '') {

                $sql = "INSERT INTO diet
                    (iddiet,namadiet,urutan,stat)
                    VALUES (UUID(),'$namadiet','$urutan','aktif');";
                $res = $this->db->query($sql);                
                
                if($res) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE diet
                        SET iddiet = '$iddiet',
                        namadiet = '$namadiet',
                        urutan = '$urutan'
                        WHERE iddiet = '$iddiet';";
                $res = $this->db->query($sql);
                
                if($res) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    function ExecPublish_Diet($data)
    {
        $iddiet = $data['iddiet'];
        $stat = $data['stat'];
        
        $sql = "UPDATE diet
                SET stat = '$stat'
                WHERE iddiet = '$iddiet';";
        $res = $this->db->query($sql);

        if($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function listDataWhere_Diet($iddiet)
    {
        $sql = "SELECT iddiet, namadiet, urutan, stat FROM diet WHERE iddiet = '$iddiet'";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

}