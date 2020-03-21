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

    public function cektglpenerimaanbahan($tglpengajuan) 
    {
        $sql = "SELECT a.tanggalpengajuan, a.idpengajuan
                FROM pengajuanbahan AS a
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
        $sql = "SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.idbahansupplier, z.namabahan, z.jumlahkuantitas, z.satuan,
                    z.hargasatuansupplier, z.satuansupplier, z.hargatotal, Y.idbahanpengajuan, Y.kesesuaian, Y.jumlahkuantitasreal, Y.hargatotalreal,
                    z.idpengajuandiet, z.idsisabahan
                FROM ( SELECT aa.idpengajuan, aa.tanggalrekap, aa.tanggalpengajuan, aa.idbahan, aa.idbahansupplier, aa.namabahan, aa.satuan, aa.hargasatuansupplier,
                        aa.satuansupplier, (aa.jumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)) AS jumlahkuantitas,
                        ( aa.jumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0) ) * aa.hargasatuansupplier AS hargatotal, aa.idpengajuandiet, bb.idsisabahan
                    FROM ( SELECT Y.idpengajuan, Y.tanggalrekap, Y.tanggalpengajuan, Y.idbahan, Y.idbahansupplier, Y.namabahan, Y.satuan, 
                            Y.hargasatuansupplier, Y.satuansupplier, 
                            (( Y.jumlahkuantitas - IFNULL(X.jmlkuantitaspengurangan, 0)) + IFNULL(X.jmlkuantitaspenambahan, 0)) AS jumlahkuantitas,
                            (( Y.jumlahkuantitas - IFNULL(X.jmlkuantitaspengurangan, 0)) + IFNULL(X.jmlkuantitaspenambahan, 0)) * Y.hargasatuansupplier AS hargatotal,
                            X.idpengajuan AS idpengajuandiet
                        FROM ( SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.idbahan, a.idbahansupplier, b.namabahan,
                                SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan, a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                            FROM pengajuanbahandetail AS a
                            INNER JOIN bahan AS b ON a.idbahan = b.idbahan
                            WHERE a.tanggalpengajuan = '$tglpengajuan' AND a.idjenismenu = '$idjenismenu'
                            GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.idbahan, a.idbahansupplier, b.namabahan, a.satuan,
                                a.hargasatuansupplier, a.satuansupplier ) AS Y
                    LEFT OUTER JOIN( SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan, SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan,
                            SUM(z.jmlkuantitaspenambahan) AS jmlkuantitaspenambahan
                        FROM ( SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien, a.idbahan, b.namabahan, a.kuantitaspengurangan,
                                ( a.jumlahpasien * a.kuantitaspengurangan ) AS jmlkuantitaspengurangan,
                                ( a.jumlahpasien * a.kuantitaspenambahan ) AS jmlkuantitaspenambahan
                            FROM pengajuanbahandietdetail AS a
                            INNER JOIN bahan AS b ON a.idbahan = b.idbahan ) AS z
                    GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan ) AS X
                ON Y.idpengajuan = X.idpengajuan 
                    AND Y.tanggalpengajuan = X.tanggalpengajuan 
                    AND Y.tanggalrekap = X.tanggalrekap 
                    AND Y.idbahan = X.idbahan ) AS aa
                LEFT OUTER JOIN sisabahan AS bb ON aa.idpengajuan = bb.idpengajuan 
                    AND aa.idbahan = bb.idbahan ) AS z
                LEFT OUTER JOIN pengajuanbahan AS Y ON z.idpengajuan = Y.idpengajuan 
                    AND z.idbahansupplier = Y.idbahansupplier
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
                FROM (SELECT aa.idpengajuan, aa.tanggalrekap, aa.tanggalpengajuan,
                    aa.idbahan, aa.idbahansupplier, aa.namabahan, aa.satuan,
                    aa.hargasatuansupplier, aa.satuansupplier,( aa.jumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)) AS jumlahkuantitas,
                    (aa.jumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)) * aa.hargasatuansupplier AS hargatotal,
                    aa.idpengajuandiet,bb.idsisabahan
                FROM ( SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
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
                                    AND y.idbahan = x.idbahan) AS aa
            LEFT OUTER JOIN sisabahan AS bb ON aa.idpengajuan = bb.idpengajuan AND aa.idbahan = bb.idbahan ) AS z
                LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                AND z.idbahansupplier = y.idbahansupplier
                ORDER BY z.namabahan ASC";

        /*
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
        */

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
                $jumlahkuantitasreal,$hargatotalreal,NOW(),'$idpengguna');";

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
                    , z.jenis, z.idsisabahan
                FROM ( SELECT aa.idpengajuan, aa.tanggalrekap, aa.tanggalpengajuan
                                                , aa.idbahan, aa.idbahansupplier
                                                , aa.namabahan, aa.satuan
                                                , aa.hargasatuansupplier, aa.satuansupplier
                                                , (aa.jumlahkuantitas-IFNULL(bb.jumlahkuantitas,0)) AS jumlahkuantitas
                                                , (aa.jumlahkuantitas-IFNULL(bb.jumlahkuantitas,0))*aa.hargasatuansupplier AS hargatotal
                                                , aa.idpengajuandiet, aa.jenis
                                                , bb.idsisabahan 
                                            FROM ( SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                            , y.idbahan, y.idbahansupplier
                            , y.namabahan, y.satuan
                            , y.hargasatuansupplier, y.satuansupplier
                            , ((y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))+IFNULL(x.jmlkuantitaspenambahan,0)) AS jumlahkuantitas
                            , ((y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))+IFNULL(x.jmlkuantitaspenambahan,0))*y.hargasatuansupplier AS hargatotal
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
                        , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan
                        , SUM(z.jmlkuantitaspenambahan) AS jmlkuantitaspenambahan
                        FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                                    , a.idbahan, b.namabahan
                                    , a.kuantitaspengurangan
                                    , (a.jumlahpasien*a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                                    , (a.jumlahpasien*a.kuantitaspenambahan) AS jmlkuantitaspenambahan
                                FROM pengajuanbahandietdetail AS a
                                    INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                                GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan) AS x ON y.idpengajuan = x.idpengajuan
                                    AND y.tanggalpengajuan = x.tanggalpengajuan
                                    AND y.tanggalrekap = x.tanggalrekap
                                    AND y.idbahan = x.idbahan) AS aa LEFT OUTER JOIN
                sisabahan AS bb ON aa.idpengajuan = bb.idpengajuan AND aa.idbahan = bb.idbahan) AS z
                LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                AND z.idbahansupplier = y.idbahansupplier
                ORDER BY z.namabahan ASC";

        /*
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
                                , ((y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))+IFNULL(x.jmlkuantitaspenambahan,0)) AS jumlahkuantitas
                                , ((y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))+IFNULL(x.jmlkuantitaspenambahan,0))*y.hargasatuansupplier AS hargatotal
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
                            , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan
                            , SUM(z.jmlkuantitaspenambahan) AS jmlkuantitaspenambahan
                            FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                                        , a.idbahan, b.namabahan
                                        , a.kuantitaspengurangan
                                        , (a.jumlahpasien*a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                                        , (a.jumlahpasien*a.kuantitaspenambahan) AS jmlkuantitaspenambahan
                                    FROM pengajuanbahandietdetail AS a
                                        INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                                    GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan) AS x ON y.idpengajuan = x.idpengajuan
                                        AND y.tanggalpengajuan = x.tanggalpengajuan
                                        AND y.tanggalrekap = x.tanggalrekap
                                        AND y.idbahan = x.idbahan) AS z
                    LEFT OUTER JOIN pengajuanbahan AS y ON z.idpengajuan = y.idpengajuan
                    AND z.idbahansupplier = y.idbahansupplier
                    ORDER BY z.namabahan ASC";
        */

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

    public function get_pengajuan($idpengajuan)
    {
        $sql = "SELECT idpengajuan, tanggalrekap, tanggalpengajuan
                FROM pengajuanbahandetail
                WHERE idpengajuan = '$idpengajuan'
                GROUP BY idpengajuan, tanggalrekap, tanggalpengajuan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_bahansupplier()
    {
        $sql = "SELECT b.idbahansupplier, b.idbahan, b.hargasatuan, b.satuan, c.namabahan
                FROM supplier AS a
                INNER JOIN bahansupplier AS b ON a.idsupplier = b.idsupplier
                INNER JOIN bahan AS c ON b.idbahan = c.idbahan
                WHERE a.stat = 'aktif' ORDER BY c.namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    
    public function get_satuan()
    {
        $sql = "SELECT b.satuan
                FROM supplier AS a
                INNER JOIN bahansupplier AS b ON a.idsupplier = b.idsupplier
                INNER JOIN bahan AS c ON b.idbahan = c.idbahan
                WHERE a.stat = 'aktif'
                GROUP BY b.satuan
                ORDER BY b.satuan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function ExecData_pengajuanbahantambahan($data)
    {
        $idbahanpengajuan = $data['idbahanpengajuan'];
        $idpengajuan = $data['idpengajuan'];
        $tanggalpengajuan = $data['tanggalpengajuan'];
        $tanggalrekappasien = $data['tanggalrekappasien']; 
        $idbahan = $data['idbahan'];
        $jumlahkuantitas = $data['jumlahkuantitas'];
        $satuan = $data['satuan'];
        $hargatotal = $data['hargatotal'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->get_namabahansupplier($idbahan);
        foreach ($q as $t){
            $idbahansupplier = $t['idbahansupplier'];
            $namabahan = $t['namabahan'];
            $hargasatuansupplier = $t['hargasatuan'];
            $satuansupplier = $t['satuan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($stat == 'delete') {
            
            $this->db->where('idbahanpengajuan', $idbahanpengajuan);
            $res = $this->db->delete('pengajuanbahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$tanggalpengajuan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $sql = "INSERT INTO pengajuanbahan
                                (idbahanpengajuan,
                                idpengajuan,
                                tanggalrekappasien,
                                idbahansupplier,
                                idbahan,
                                namabahan,
                                jumlahkuantitas,
                                satuan,
                                hargasatuansupplier,
                                satuansupplier,
                                hargatotal,
                                tanggalpengajuan,
                                tanggalinsert,
                                idpengguna,
                                kesesuaian,
                                jumlahkuantitasreal,
                                hargatotalreal,
                                tanggalcek,
                                idpenggunacek)
                    VALUES (UUID(),
                            '$idpengajuan',
                            '$tanggalrekappasien',
                            '$idbahansupplier',
                            '$idbahan',
                            '$namabahan',
                            '$jumlahkuantitas',
                            '$satuan',
                            '$hargasatuansupplier',
                            '$satuansupplier',
                            '$hargatotal',
                            '$tanggalpengajuan',
                            NOW(),
                            '$pembuatid',
                            'tambahan',
                            '$jumlahkuantitas',
                            '$hargatotal',
                            NOW(),
                            '$pembuatid');";
            
            $res = $this->db->query($sql);
            
            if($res) {
                $data['msg'] = 'Tambah data: '.$tanggalpengajuan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function get_namabahansupplier($idbahan)
    {
        $sql = "SELECT b.idbahansupplier, b.idbahan, b.hargasatuan, b.satuan, c.namabahan
                FROM supplier AS a
                    INNER JOIN bahansupplier AS b ON a.idsupplier = b.idsupplier
                    INNER JOIN bahan AS c ON b.idbahan = c.idbahan
                WHERE a.stat = 'aktif'
                    AND b.idbahan = '$idbahan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function batal_pengajuanbahan($data,$pengajuan,$real = null)
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

        $pengajuan = 'batal';
        $jumlahkuantitasreal = 0;
        $hargatotalreal = 0;

        $insert = "INSERT INTO pengajuanbahan
                    (idbahanpengajuan,idpengajuan,tanggalrekappasien,idbahansupplier,idbahan,namabahan,jumlahkuantitas,
                    satuan,hargasatuansupplier,satuansupplier,hargatotal,tanggalpengajuan,tanggalinsert,idpengguna,kesesuaian
                    ,jumlahkuantitasreal,hargatotalreal,tanggalcek,idpenggunacek)
            VALUES (UUID(),'$idpengajuan','$tanggalrekap','$idbahansupplier','$idbahan','$namabahan',$jumlahkuantitas,
                '$satuan',$hargasatuansupplier,'$satuansupplier',$hargatotal,'$tanggalpengajuan',NOW(),'$idpengguna','$pengajuan',
                $jumlahkuantitasreal,$hargatotalreal,NOW(),'$idpengguna');";

        $query = $this->db->query($insert);
        $arr = array(
            'jumlahkuantitasreal' => 0, 
            'hargatotalreal' => 0
            );
        echo json_encode($arr);
    }

    public function pengajuanbahanfix_tambahan($tglpengajuan)
    {
        $sql = "SELECT a.idbahanpengajuan, a.idpengajuan, a.tanggalrekappasien, a.idbahansupplier, a.idbahan, a.namabahan, a.jumlahkuantitas, a.satuan, 
                a.hargasatuansupplier, a.satuansupplier, a.hargatotal, a.tanggalpengajuan, a.kesesuaian, a.jumlahkuantitasreal, a.hargatotalreal
                FROM pengajuanbahan AS a
                WHERE a.tanggalpengajuan = '$tglpengajuan'
                    AND a.kesesuaian = 'tambahan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function hitung_hargatotal($idbahan,$jumlahkuantitas)
    {
        $sql = "SELECT b.namabahan, b.satuan, b.hargasatuan, b.hargasatuan*$jumlahkuantitas AS hargatotal
                FROM supplier AS a
                    INNER JOIN bahansupplier AS b ON a.idsupplier = b.idsupplier
                WHERE a.stat = 'aktif'
                    AND b.stat = 'aktif'
                    AND b.idbahan = '$idbahan'
                LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        echo $result[0]['hargatotal'];
    }

    public function get_pengecekanbahanfix_fix($idpengajuan)
    {
        $sql = "SELECT a.idbahan, a.namabahan, a.jumlahkuantitas, a.jumlahkuantitasreal, a.satuan
                , a.hargasatuansupplier, a.hargatotalreal, a.kesesuaian, b.jenis
                FROM pengajuanbahan AS a
                INNER JOIN bahan AS b ON a.idbahan = b.idbahan
                WHERE a.idpengajuan = '$idpengajuan'
                    AND a.kesesuaian <> 'batal'
                ORDER BY a.namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}