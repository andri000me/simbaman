<?php
/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-10-06 10:41:23
 * @modify date 2019-10-06 10:41:23
 * @desc [description]
 */


class Pengecekanbahan_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function cektglpengajuanbahan($tglpengajuan) 
    {
        $sql = "SELECT a.tanggalpengajuan, a.idpengajuan
                FROM pengajuanbahandetail AS a
                WHERE a.tanggalpengajuan = '$tglpengajuan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_tanggalpengajuan($tglpengajuan)
    {
        $sql = "SELECT tanggalrekap, tanggalpengajuan, idpengajuan
            FROM pengajuanbahandetail 
            WHERE tanggalpengajuan = '$tglpengajuan'
            GROUP BY tanggalrekap, tanggalpengajuan, idpengajuan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function jumlah_pasienpengajuan($tglpengajuan)
    {
        $sql = "SELECT a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien, a.idkelas, b.namakelas
                FROM pengajuanbahandetail AS a INNER JOIN
                kelas AS b ON a.idkelas = b.idkelas
                WHERE a.tanggalpengajuan = '$tglpengajuan'
                GROUP BY a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien, a.idkelas, b.namakelas";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function jenismenumasakanpengajuan($tglpengajuan)
    {
        $sql = "SELECT a.idjenismenu, b.namajenismenu
                FROM pengajuanbahandetail AS a INNER JOIN
                jenismenu AS b ON a.idjenismenu = b.idjenismenu
                WHERE a.tanggalpengajuan = '$tglpengajuan'
                GROUP BY a.idjenismenu, b.namajenismenu";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_waktumenupengajuan($tglpengajuan)
    {
        $sql = "SELECT a.idwaktumenu, b.namawaktumenu, b.waktu
                FROM pengajuanbahandetail AS a INNER JOIN
                waktumenu AS b ON a.idwaktumenu = b.idwaktumenu
                WHERE a.tanggalpengajuan = '$tglpengajuan'
                GROUP BY a.idwaktumenu, b.namawaktumenu, b.waktu
                ORDER BY b.waktu ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function pengajuanbahanfix($tglpengajuan,$idjenismenu)
    {
        /*
        $sql = "SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan
                    , z.idbahan, z.idbahansupplier
                    , z.namabahan, z.jumlahkuantitas, z.satuan
                    , z.hargasatuansupplier, z.satuansupplier, z.hargatotal
                    , y.idbahanpengajuan, y.kesesuaian, y.jumlahkuantitasreal, y.hargatotalreal
                FROM (
                SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                    , a.idbahan, a.idbahansupplier
                    , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                    , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                FROM pengajuanbahandetail AS a INNER JOIN 
                    bahan AS b ON a.idbahan = b.idbahan
                WHERE a.tanggalpengajuan = '$tglpengajuan'
                    AND a.idjenismenu = '$idjenismenu'
                GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                    , a.idbahan, a.idbahansupplier
                    , b.namabahan, a.satuan
                    , a.hargasatuansupplier, a.satuansupplier) AS z
                LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                AND z.idbahansupplier = y.idbahansupplier
                ORDER BY z.namabahan ASC";
        */
        
        $sql = "SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan
                    , z.idbahan, z.idbahansupplier
                    , z.namabahan, z.jumlahkuantitas, z.satuan
                    , z.hargasatuansupplier, z.satuansupplier, z.hargatotal
                    , y.idbahanpengajuan, y.kesesuaian, y.jumlahkuantitasreal, y.hargatotalreal, z.idpengajuandiet
                FROM (
                    SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                            , y.idbahan, y.idbahansupplier
                            , y.namabahan, y.satuan
                            , y.hargasatuansupplier, y.satuansupplier
                            , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0)) AS jumlahkuantitas
                            , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))*y.hargasatuansupplier AS hargatotal
                            , x.idpengajuan AS idpengajuandiet
                        FROM ( SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                            , a.idbahan, a.idbahansupplier
                            , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                            , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                        FROM pengajuanbahandetail AS a INNER JOIN 
                            bahan AS b ON a.idbahan = b.idbahan
                        WHERE a.tanggalpengajuan = '$tglpengajuan'
                            AND a.idjenismenu = '$idjenismenu'
                        GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                            , a.idbahan, a.idbahansupplier
                            , b.namabahan, a.satuan
                            , a.hargasatuansupplier, a.satuansupplier) AS y
                        LEFT OUTER JOIN (SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan
                        , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan, z.satuan
                        FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                                    , a.idbahan, b.namabahan
                                    , a.kuantitaspengurangan
                                    , (a.jumlahpasien*a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                                    , a.satuan
                                FROM pengajuanbahandietdetail AS a
                                    INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                                GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan, z.satuan) AS x ON y.idpengajuan = x.idpengajuan
                                    AND y.tanggalpengajuan = x.tanggalpengajuan
                                    AND y.tanggalrekap = x.tanggalrekap
                                    AND y.idbahan = x.idbahan) AS z
                LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                AND z.idbahansupplier = y.idbahansupplier
                ORDER BY z.namabahan ASC";
        

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function jenismenumasakan($idjenismenu)
    {
        $sql = "SELECT idjenismenu, namajenismenu, tanggal
                FROM jenismenu
                WHERE idjenismenu = '$idjenismenu'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function kelasmenumasakan($idjenismenu)
    {
        $sql = "SELECT a.idkelas, b.namakelas
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                WHERE a.idjenismenu = '$idjenismenu'
                GROUP BY a.idkelas, b.namakelas
                ORDER BY b.namakelas ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function waktumenumasakan($idjenismenu)
    {
        $sql = "SELECT a.idwaktumenu, d.namawaktumenu, d.waktu
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                WHERE a.idjenismenu = '$idjenismenu'
                GROUP BY a.idwaktumenu, d.namawaktumenu, d.waktu
                ORDER BY d.waktu ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function menumasakan($idjenismenu)
    {
        $sql = "SELECT a.idkelas, b.namakelas
                , a.idwaktumenu, d.namawaktumenu, d.waktu
                , a.idmasakan, e.namamasakan
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                INNER JOIN masakan AS e ON a.idmasakan = e.idmasakan
                WHERE a.idjenismenu = '$idjenismenu'
                ORDER BY e.namamasakan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_pengajuanbahansupplier($idpengajuan,$idbahansupplier)
    {
        $sql = "SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan
                        , z.idbahan, z.idbahansupplier
                        , z.namabahan, z.jumlahkuantitas, z.satuan
                        , z.hargasatuansupplier, z.satuansupplier, z.hargatotal
                        , y.idbahanpengajuan, y.kesesuaian, y.jumlahkuantitasreal, y.hargatotalreal, z.idpengajuandiet
                    FROM (
                        SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                                , y.idbahan, y.idbahansupplier
                                , y.namabahan, y.satuan
                                , y.hargasatuansupplier, y.satuansupplier
                                , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0)) AS jumlahkuantitas
                                , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))*y.hargasatuansupplier AS hargatotal
                                , x.idpengajuan AS idpengajuandiet
                            FROM ( SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                , a.idbahan, a.idbahansupplier
                                , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                                , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                            FROM pengajuanbahandetail AS a INNER JOIN 
                                bahan AS b ON a.idbahan = b.idbahan
                            WHERE a.idpengajuan = '$idpengajuan'
                                AND a.idbahansupplier = '$idbahansupplier'
                            GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                , a.idbahan, a.idbahansupplier
                                , b.namabahan, a.satuan
                                , a.hargasatuansupplier, a.satuansupplier) AS y
                            LEFT OUTER JOIN (SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan
                            , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan, z.satuan
                            FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                                        , a.idbahan, b.namabahan
                                        , a.kuantitaspengurangan
                                        , (a.jumlahpasien*a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                                        , a.satuan
                                    FROM pengajuanbahandietdetail AS a
                                        INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                                    GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan, z.satuan) AS x ON y.idpengajuan = x.idpengajuan
                                        AND y.tanggalpengajuan = x.tanggalpengajuan
                                        AND y.tanggalrekap = x.tanggalrekap
                                        AND y.idbahan = x.idbahan) AS z
                    LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                    AND z.idbahansupplier = y.idbahansupplier
                    ORDER BY z.namabahan ASC";

        /*
        $sql = "SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan , a.idbahan, a.idbahansupplier 
                , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan , a.hargasatuansupplier
                , a.satuansupplier, SUM(a.hargatotal) AS hargatotal 
                FROM pengajuanbahandetail AS a 
                INNER JOIN bahan AS b ON a.idbahan = b.idbahan 
                WHERE a.idpengajuan = '$idpengajuan' 
                AND a.idbahansupplier = '$idbahansupplier'
                GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan , a.idbahan, a.idbahansupplier , b.namabahan, a.satuan 
                , a.hargasatuansupplier, a.satuansupplier 
                ORDER BY b.namabahan ASC";
        */

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function submit_pengajuanbahan($data,$pengajuan,$real = null)
    {
        $idpengguna = $this->session->userdata('idpengguna');

        $idpengajuan = $data[0]['idpengajuan'];
        $tanggalrekap = $data[0]['tanggalrekap'];
        $tanggalpengajuan = $data[0]['tanggalpengajuan'];
        $idbahan = $data[0]['idbahan'];
        $idbahansupplier = $data[0]['idbahansupplier'];
        $namabahan = $data[0]['namabahan'];
        $jumlahkuantitas = $data[0]['jumlahkuantitas'];
        $satuan = $data[0]['satuan'];
        $hargasatuansupplier = $data[0]['hargasatuansupplier'];
        $satuansupplier = $data[0]['satuansupplier'];
        $hargatotal = $data[0]['hargatotal'];

        if ($pengajuan == 'tidak_sesuai') {
            $jumlahkuantitasreal = $real['jumlahkuantitasreal'];
            $hargatotalreal = $real['hargatotalreal'];
        } else {
            $jumlahkuantitasreal = $jumlahkuantitas;
            $hargatotalreal = $hargatotal;
        }

        $insert = "INSERT INTO pengajuanbahan
                    (idbahanpengajuan,idpengajuan,tanggalrekappasien,idbahansupplier,idbahan,namabahan,jumlahkuantitas,
                    satuan,hargasatuansupplier,satuansupplier,hargatotal,tanggalpengajuan,tanggalinsert,idpengguna,kesesuaian
                    ,jumlahkuantitasreal,hargatotalreal,tanggalcek,idpenggunacek)
            VALUES (UUID(),'$idpengajuan','$tanggalrekap','$idbahansupplier','$idbahan','$namabahan',$jumlahkuantitas,
                '$satuan',$hargasatuansupplier,'$satuansupplier',$hargatotal,'$tanggalpengajuan',NOW(),'$idpengguna','$pengajuan',
                $jumlahkuantitasreal,$hargatotalreal,NULL,NULL);";

        $query = $this->db->query($insert);
        //return $query;
        $a = number_format($jumlahkuantitasreal,2);
        $b = number_format($hargatotalreal,2,",",".");
        $arr = array(
            'jumlahkuantitasreal' => $a, 
            'hargatotalreal' => $b
            );
        echo json_encode($arr);
    }

    public function delete_pengajuanbahan($idpengajuan,$idbahansupplier)
    {
        $delete = "DELETE FROM pengajuanbahan
                    WHERE idpengajuan = '$idpengajuan'
                    AND idbahansupplier = '$idbahansupplier'";

        $query = $this->db->query($delete);
    }

    public function get_pengecekanbahanfix($idpengajuan)
    {
        $sql = "SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan
                        , z.idbahan, z.idbahansupplier
                        , z.namabahan, z.jumlahkuantitas, z.satuan
                        , z.hargasatuansupplier, z.satuansupplier, z.hargatotal
                        , y.idbahanpengajuan, y.kesesuaian, y.jumlahkuantitasreal, y.hargatotalreal, z.idpengajuandiet
                        , z.jenis
                    FROM (
                        SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                                , y.idbahan, y.idbahansupplier
                                , y.namabahan, y.satuan
                                , y.hargasatuansupplier, y.satuansupplier
                                , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0)) AS jumlahkuantitas
                                , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))*y.hargasatuansupplier AS hargatotal
                                , x.idpengajuan AS idpengajuandiet
                                , y.jenis
                            FROM ( SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                , a.idbahan, a.idbahansupplier
                                , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                                , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                                , b.jenis
                            FROM pengajuanbahandetail AS a INNER JOIN 
                                bahan AS b ON a.idbahan = b.idbahan
                            WHERE a.idpengajuan = '$idpengajuan'
                            GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                , a.idbahan, a.idbahansupplier
                                , b.namabahan, a.satuan
                                , a.hargasatuansupplier, a.satuansupplier
                                , b.jenis) AS y
                            LEFT OUTER JOIN (SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan
                            , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan, z.satuan
                            FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                                        , a.idbahan, b.namabahan
                                        , a.kuantitaspengurangan
                                        , (a.jumlahpasien*a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                                        , a.satuan
                                    FROM pengajuanbahandietdetail AS a
                                        INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                                    GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan, z.satuan) AS x ON y.idpengajuan = x.idpengajuan
                                        AND y.tanggalpengajuan = x.tanggalpengajuan
                                        AND y.tanggalrekap = x.tanggalrekap
                                        AND y.idbahan = x.idbahan) AS z
                    LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                    AND z.idbahansupplier = y.idbahansupplier
                    ORDER BY z.namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_jenisbahan($idpengajuan)
    {
        $sql = "SELECT b.jenis
                FROM pengajuanbahandetail AS a
                INNER JOIN bahan AS b on a.idbahan = b.idbahan
                WHERE a.idpengajuan = '$idpengajuan'
                GROUP BY b.jenis
                ORDER BY b.jenis";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function pengajuanbahan_kelas($idkelas,$idpengajuan)
    {
        if ($idkelas == 'pilihsemua') {
            $kelas = "";
        } else {
            $kelas = "AND a.idkelas = '$idkelas'";
        }

        $sql = "SELECT a.idkelas, b.namakelas
                FROM pengajuanbahandetail AS a INNER JOIN
                kelas AS b ON a.idkelas = b.idkelas
                WHERE a.idpengajuan = '$idpengajuan'
                    $kelas
                GROUP BY a.idkelas, b.namakelas";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function pengajuanbahan_waktumenu($idwaktumenu,$idpengajuan)
    {
        if ($idwaktumenu == 'pilihsemua') {
            $waktumenu = "";
        } else {
            $waktumenu = "AND a.idwaktumenu = '$idwaktumenu'";
        }

        $sql = "SELECT a.idwaktumenu, b.namawaktumenu, b.waktu
                FROM pengajuanbahandetail AS a INNER JOIN
                waktumenu AS b ON a.idwaktumenu = b.idwaktumenu
                WHERE a.idpengajuan = '$idpengajuan'
                    $waktumenu
                GROUP BY a.idwaktumenu, b.namawaktumenu, b.waktu
                ORDER BY b.waktu ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function tanggalpengajuan($idpengajuan)
    {
        $sql = "SELECT idpengajuan, tanggalpengajuan
                FROM pengajuanbahandetail
                WHERE idpengajuan = '$idpengajuan'
                GROUP BY idpengajuan, tanggalpengajuan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}