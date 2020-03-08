<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-21 13:11:26
 * @modify date 2019-09-21 13:11:26
 * @desc [description]
 */

class Pengajuanbahan_query extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->module('sistemlog');
    }

    public function pengajuanbahan($tglrekappasien,$idjenismenu)
    {
        $sql = "SELECT k.tanggalrekap, k.idbahan, k.idbahansupplier, k.namabahan, SUM(k.jumlahkuantitas) AS jumlahkuantitas
                    , k.satuan, k.hargasatuansupplier, k.satuansupplier, SUM(k.hargatotal) AS hargatotal
                    FROM (SELECT j.tanggalrekap, j.idbahan,  j.namabahan, j.jumlahkuantitas, j.satuan
                    , m.hargasatuansupplier, m.satuansupplier, m.idbahansupplier
                    , (j.jumlahkuantitas*m.hargasatuansupplier) AS hargatotal
                    FROM (SELECT c.idkelas, c.namakelas, c.tanggalrekap, c.jumlahpasien
                    , d.idjenismenu, e.namajenismenu, e.tanggal
                    , d.idwaktumenu, f.namawaktumenu, f.waktu
                    , d.idmasakan, g.namamasakan
                    , h.idbahan, i.namabahan, h.kuantitas
                    , (c.jumlahpasien*h.kuantitas) AS jumlahkuantitas
                    , h.satuan, i.jenis
                    FROM (SELECT a.idkelas, b.namakelas, a.tanggalrekap, SUM(a.jumlahpasien) AS jumlahpasien
                    FROM rekapjumlahpasien AS a
                    INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                    GROUP BY a.idkelas, b.namakelas, a.tanggalrekap) AS c
                    INNER JOIN menumasakan AS d ON c.idkelas = d.idkelas
                    INNER JOIN jenismenu AS e ON d.idjenismenu = e.idjenismenu
                    INNER JOIN waktumenu AS f ON d.idwaktumenu = f.idwaktumenu
                    INNER JOIN masakan AS g ON d.idmasakan = g.idmasakan
                    INNER JOIN masakanbahan AS h ON g.idmasakan = h.idmasakan
                    INNER JOIN bahan AS i ON h.idbahan = i.idbahan) AS j 
                    INNER JOIN (SELECT l.idbahan, l.idbahansupplier, l.hargasatuan AS hargasatuansupplier
                    , l.satuan AS satuansupplier, l.jenis AS jenissupplier
                    FROM supplier AS k
                    INNER JOIN bahansupplier AS l ON k.idsupplier = l.idsupplier
                    WHERE k.stat = 'aktif') AS m ON j.idbahan = m.idbahan
                    WHERE j.tanggalrekap = '$tglrekappasien'
                    AND j.idjenismenu = '$idjenismenu'
                    -- AND a.idkelas = '463ab30f-d105-11e9-a2b9-68f72820d6fc'
                    -- AND a.idwaktumenu = '18d6fb40-d773-11e9-8c14-68f72820d6fc'
                    ) AS k
                    GROUP BY k.tanggalrekap, k.idbahan, k.idbahansupplier, k.namabahan, k.satuan, k.hargasatuansupplier, k.satuansupplier
                    ORDER BY k.namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function jumlah_pasien($tglrekappasien)
    {
        $sql = "SELECT a.idkelas, b.namakelas, SUM(a.jumlahpasien) AS jumlahpasien
                FROM rekapjumlahpasien AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                WHERE a.tanggalrekap = '$tglrekappasien'
                GROUP BY a.idkelas, b.namakelas";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function jenismenumasakantgl($tgl)
    {
        $sql = "SELECT idjenismenu, namajenismenu, tanggal
                FROM jenismenu
                WHERE tanggal = $tgl";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function menumasakanwaktu($tgl)
    {
        $sql = "SELECT a.idjenismenu, c.namajenismenu
                , a.idwaktumenu, d.namawaktumenu, d.waktu
                FROM menumasakan AS a
                INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                INNER JOIN jenismenu AS c ON a.idjenismenu = c.idjenismenu
                INNER JOIN waktumenu AS d ON a.idwaktumenu = d.idwaktumenu
                WHERE c.tanggal = $tgl
                GROUP BY a.idjenismenu, c.namajenismenu
                , a.idwaktumenu, d.namawaktumenu,d.waktu
                ORDER BY d.waktu ASC";

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

    public function cektglpengajuanbahan($tglpengajuan) 
    {
        $sql = "SELECT a.tanggalpengajuan, a.idpengajuan
                FROM pengajuanbahandetail AS a
                WHERE a.tanggalpengajuan = '$tglpengajuan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function id()
    {
        $sql = "SELECT UUID() AS id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function genaratepengajuanbahan($tanggalrekappasien,$idjenismenu,$tanggalpengajuan)
    {
        $idpengguna = $this->session->userdata('idpengguna');

        $id = $this->id();
        $idpengajuan = $id[0]['id'];

        $sql = "INSERT INTO pengajuanbahandetail
                        (idpengajuanbahandetail,idpengajuan,tanggalrekap,tanggalpengajuan,jumlahpasien,idkelas,namakelas,idjenismenu,namajenismenu,
                        idwaktumenu,namawaktumenu,idmasakan,namamasakan,idbahan,namabahan,jumlahkuantitas,satuan,
                        hargasatuansupplier,satuansupplier,idbahansupplier,hargatotal,tanggalinsert,idpengguna)
                SELECT UUID() AS idpengajuanbahandetail, '$idpengajuan' AS idpengajuan, j.tanggalrekap, '$tanggalpengajuan' AS tanggalpengajuan
                    , j.jumlahpasien
                    , j.idkelas, j.namakelas
                    , j.idjenismenu, j.namajenismenu
                    , j.idwaktumenu, j.namawaktumenu
                    , j.idmasakan, j.namamasakan
                    , j.idbahan, j.namabahan, j.jumlahkuantitas, j.satuan
                    , m.hargasatuansupplier, m.satuansupplier, m.idbahansupplier
                    , (j.jumlahkuantitas*m.hargasatuansupplier) AS hargatotal
                    , NOW() AS tanggalinsert, '$idpengguna' AS idpengguna
                    FROM (SELECT c.idkelas, c.namakelas, c.tanggalrekap, c.jumlahpasien
                    , d.idjenismenu, e.namajenismenu, e.tanggal
                    , d.idwaktumenu, f.namawaktumenu, f.waktu
                    , d.idmasakan, g.namamasakan
                    , h.idbahan, i.namabahan, h.kuantitas
                    , (c.jumlahpasien*h.kuantitas) AS jumlahkuantitas
                    , h.satuan, i.jenis
                    FROM (SELECT a.idkelas, b.namakelas, a.tanggalrekap, SUM(a.jumlahpasien) AS jumlahpasien
                    FROM rekapjumlahpasien AS a
                    INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                    GROUP BY a.idkelas, b.namakelas, a.tanggalrekap) AS c
                    INNER JOIN menumasakan AS d ON c.idkelas = d.idkelas
                    INNER JOIN jenismenu AS e ON d.idjenismenu = e.idjenismenu
                    INNER JOIN waktumenu AS f ON d.idwaktumenu = f.idwaktumenu
                    INNER JOIN masakan AS g ON d.idmasakan = g.idmasakan
                    INNER JOIN masakanbahan AS h ON g.idmasakan = h.idmasakan
                    INNER JOIN bahan AS i ON h.idbahan = i.idbahan) AS j 
                    INNER JOIN (SELECT l.idbahan, l.idbahansupplier, l.hargasatuan AS hargasatuansupplier
                    , l.satuan AS satuansupplier, l.jenis AS jenissupplier
                    FROM supplier AS k
                    INNER JOIN bahansupplier AS l ON k.idsupplier = l.idsupplier
                    WHERE k.stat = 'aktif') AS m ON j.idbahan = m.idbahan
                    WHERE j.tanggalrekap = '$tanggalrekappasien'
                    AND j.idjenismenu = '$idjenismenu'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function get_kelaspengajuan($tglpengajuan)
    {
        $sql = "SELECT a.idkelas, b.namakelas
                FROM pengajuanbahandetail AS a INNER JOIN
                kelas AS b ON a.idkelas = b.idkelas
                WHERE a.tanggalpengajuan = '$tglpengajuan'
                GROUP BY a.idkelas, b.namakelas";

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

    public function pengajuanbahanfix($tglpengajuan,$idjenismenu)
    {
        /*
        $sql = "SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                    , y.idbahan, y.idbahansupplier
                    , y.namabahan, y.satuan
                    , y.hargasatuansupplier, y.satuansupplier
                    , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0)) AS totaljumlahkuantitas
                    , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))*y.hargasatuansupplier AS totalhargatotal
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
                            AND y.idbahan = x.idbahan
                ORDER BY y.namabahan ASC";
        */
        $sql = "SELECT
    aa.idpengajuan,
    aa.tanggalrekap,
    aa.tanggalpengajuan,
    aa.idbahan,
    aa.idbahansupplier,
    aa.namabahan,
    aa.satuan,
    aa.hargasatuansupplier,
    aa.satuansupplier,
    (
        aa.totaljumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)
    ) AS totaljumlahkuantitas,
    (
        aa.totaljumlahkuantitas - IFNULL(bb.jumlahkuantitas, 0)
    ) * aa.hargasatuansupplier AS totalhargatotal,
    aa.idpengajuandiet,
    bb.idsisabahan
FROM
    (
    SELECT
        Y.idpengajuan,
        Y.tanggalrekap,
        Y.tanggalpengajuan,
        Y.idbahan,
        Y.idbahansupplier,
        Y.namabahan,
        Y.satuan,
        Y.hargasatuansupplier,
        Y.satuansupplier,
        (
            Y.jumlahkuantitas - IFNULL(X.jmlkuantitaspengurangan, 0)
        ) AS totaljumlahkuantitas,
        (
            Y.jumlahkuantitas - IFNULL(X.jmlkuantitaspengurangan, 0)
        ) * Y.hargasatuansupplier AS totalhargatotal,
        X.idpengajuan AS idpengajuandiet
    FROM
        (
        SELECT
            a.idpengajuan,
            a.tanggalrekap,
            a.tanggalpengajuan,
            a.idbahan,
            a.idbahansupplier,
            b.namabahan,
            SUM(a.jumlahkuantitas) AS jumlahkuantitas,
            a.satuan,
            a.hargasatuansupplier,
            a.satuansupplier,
            SUM(a.hargatotal) AS hargatotal
        FROM
            pengajuanbahandetail AS a
        INNER JOIN bahan AS b
        ON
            a.idbahan = b.idbahan
        WHERE
            a.tanggalpengajuan = '$tglpengajuan' AND a.idjenismenu = '$idjenismenu'
        GROUP BY
            a.idpengajuan,
            a.tanggalrekap,
            a.tanggalpengajuan,
            a.idbahan,
            a.idbahansupplier,
            b.namabahan,
            a.satuan,
            a.hargasatuansupplier,
            a.satuansupplier
    ) AS Y
LEFT OUTER JOIN(
    SELECT
        z.idpengajuan,
        z.tanggalrekap,
        z.tanggalpengajuan,
        z.idbahan,
        z.namabahan,
        SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan,
        z.satuan
    FROM
        (
        SELECT
            a.idpengajuan,
            a.tanggalrekap,
            a.tanggalpengajuan,
            a.jumlahpasien,
            a.idbahan,
            b.namabahan,
            a.kuantitaspengurangan,
            (
                a.jumlahpasien * a.kuantitaspengurangan
            ) AS jmlkuantitaspengurangan,
            a.satuan
        FROM
            pengajuanbahandietdetail AS a
        INNER JOIN bahan AS b
        ON
            a.idbahan = b.idbahan
    ) AS z
GROUP BY
    z.idpengajuan,
    z.tanggalrekap,
    z.tanggalpengajuan,
    z.idbahan,
    z.namabahan,
    z.satuan
) AS X
ON
    Y.idpengajuan = X.idpengajuan AND Y.tanggalpengajuan = X.tanggalpengajuan AND Y.tanggalrekap = X.tanggalrekap AND Y.idbahan = X.idbahan
) AS aa
LEFT OUTER JOIN sisabahan AS bb
ON
    aa.idpengajuan = bb.idpengajuan AND aa.idbahan = bb.idbahan
ORDER BY
    aa.namabahan ASC";
        /*
        $sql = "SELECT aa.idpengajuan, aa.tanggalrekap, aa.tanggalpengajuan
                        , aa.idbahan, aa.idbahansupplier
                        , aa.namabahan, aa.satuan
                        , aa.hargasatuansupplier, aa.satuansupplier
                        , (aa.totaljumlahkuantitas-IFNULL(bb.jumlahkuantitas,0)) AS totaljumlahkuantitas
                        , (aa.totaljumlahkuantitas-IFNULL(bb.jumlahkuantitas,0))*aa.hargasatuansupplier AS totalhargatotal
                        , aa.idpengajuandiet
                        , bb.idsisabahan	    
                FROM (SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                        , y.idbahan, y.idbahansupplier
                        , y.namabahan, y.satuan
                        , y.hargasatuansupplier, y.satuansupplier
                        , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0)) AS totaljumlahkuantitas
                        , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))*y.hargasatuansupplier AS totalhargatotal
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
                        , a.hargasatuansupplier, a.satuansupplier) AS Y
                    LEFT OUTER JOIN (SELECT z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan
                    , SUM(z.jmlkuantitaspengurangan) AS jmlkuantitaspengurangan, z.satuan
                    FROM (SELECT a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan, a.jumlahpasien
                            , a.idbahan, b.namabahan
                            , a.kuantitaspengurangan
                            , (a.jumlahpasien*a.kuantitaspengurangan) AS jmlkuantitaspengurangan
                            , a.satuan
                        FROM pengajuanbahandietdetail AS a
                            INNER JOIN bahan AS b ON a.idbahan = b.idbahan) AS z
                        GROUP BY z.idpengajuan, z.tanggalrekap, z.tanggalpengajuan, z.idbahan, z.namabahan, z.satuan) AS X ON y.idpengajuan = x.idpengajuan
                            AND y.tanggalpengajuan = x.tanggalpengajuan
                            AND y.tanggalrekap = x.tanggalrekap
                            AND y.idbahan = x.idbahan) AS aa LEFT OUTER JOIN
                    sisabahan AS bb ON aa.idpengajuan = bb.idpengajuan AND aa.idbahan = bb.idbahan
                ORDER BY aa.namabahan ASC";
                */

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function resetpengajuanbahan($idpengajuan)
    {
        $delete = "DELETE
                FROM pengajuanbahandetail
                WHERE idpengajuan = '$idpengajuan';";

        $query = $this->db->query($delete);
        return $query;
    }

    public function pengajuanbahanfixcetak($data)
    {
        $idpengajuan = $data['idpengajuan'];
        $idkelas = $data['idkelas'];
        $idwaktumenu = $data['idwaktumenu'];

        if ($idkelas == 'pilihsemua') {
            $kelas = "";
        } else {
            $kelas = "AND a.idkelas = '$idkelas'";
        }

        if ($idwaktumenu == 'pilihsemua') {
            $waktumenu = "";
        } else {
            $waktumenu = "AND a.idwaktumenu = '$idwaktumenu'";
        }

        $sql = "SELECT aa.idpengajuan, aa.tanggalrekap, aa.tanggalpengajuan
                        , aa.idbahan, aa.idbahansupplier
                        , aa.namabahan, aa.satuan
                        , aa.hargasatuansupplier, aa.satuansupplier
                        , (aa.totaljumlahkuantitas-IFNULL(bb.jumlahkuantitas,0)) AS totaljumlahkuantitas
                        , (aa.totaljumlahkuantitas-IFNULL(bb.jumlahkuantitas,0))*aa.hargasatuansupplier AS totalhargatotal
                        , aa.idpengajuandiet
                        , bb.idsisabahan	    
                FROM (SELECT y.idpengajuan, y.tanggalrekap, y.tanggalpengajuan
                                    , y.idbahan, y.idbahansupplier
                                    , y.namabahan, y.satuan
                                    , y.hargasatuansupplier, y.satuansupplier
                                    , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0)) AS totaljumlahkuantitas
                                    , (y.jumlahkuantitas-IFNULL(x.jmlkuantitaspengurangan,0))*y.hargasatuansupplier AS totalhargatotal
                                    , x.idpengajuan AS idpengajuandiet
                                FROM ( SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                                    , a.idbahan, a.idbahansupplier
                                    , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                                    , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                                FROM pengajuanbahandetail AS a INNER JOIN 
                                    bahan AS b ON a.idbahan = b.idbahan
                                WHERE a.idpengajuan = '$idpengajuan'
                                        $kelas
                                        $waktumenu
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
                                            AND y.idbahan = x.idbahan) AS aa LEFT OUTER JOIN
                    sisabahan AS bb ON aa.idpengajuan = bb.idpengajuan AND aa.idbahan = bb.idbahan
                ORDER BY aa.namabahan ASC";

        /*
        $sql = "SELECT  a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                    , a.idbahan, a.idbahansupplier
                    , b.namabahan, SUM(a.jumlahkuantitas) AS jumlahkuantitas, a.satuan
                    , a.hargasatuansupplier, a.satuansupplier, SUM(a.hargatotal) AS hargatotal
                    FROM pengajuanbahandetail AS a INNER JOIN 
                    bahan AS b ON a.idbahan = b.idbahan
                    WHERE a.idpengajuan = '$idpengajuan'
                        $kelas
                        $waktumenu
                    GROUP BY a.idpengajuan, a.tanggalrekap, a.tanggalpengajuan
                    , a.idbahan, a.idbahansupplier
                    , b.namabahan, a.satuan
                    , a.hargasatuansupplier, a.satuansupplier
                    ORDER BY b.namabahan ASC";
        */

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

    public function pengajuanbahan_cek($tglpengajuan)
    {
        $sql = "SELECT idpengajuan
                FROM pengajuanbahan
                WHERE tanggalpengajuan = '$tglpengajuan'";

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

    public function list_diet()
    {
        $sql = "SELECT a.iddiet, b.namadiet
                FROM dietmasakanbahan AS a
                INNER JOIN diet AS b ON a.iddiet = b.iddiet
                GROUP BY a.iddiet, b.namadiet";
        /*        
        $sql = "SELECT iddiet, namadiet
                FROM diet
                ORDER BY urutan ASC"; 
        */

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function list_kelas()
    {
        $sql = "SELECT a.idkelas, b.kodekelas, b.namakelas
        FROM rekapjumlahpasien AS a
            INNER JOIN kelas AS b ON a.idkelas = b.idkelas
        WHERE jumlahpasien <> 0
        GROUP BY a.idkelas, b.kodekelas, b.namakelas"; 

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function list_bangsal()
    {
        $sql = "SELECT a.idbangsal, b.kodebangsal, a.namabangsal, a.jumlahpasien
                FROM rekapjumlahpasien AS a
                    INNER JOIN bangsal AS b ON a.idbangsal = b.idbangsal
                WHERE jumlahpasien <> 0
                GROUP BY a.idbangsal, b.kodebangsal, a.namabangsal
                ORDER BY b.kodebangsal ASC"; 

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function list_bangsal_tglrekap($tanggalrekap)
    {
        $sql = "SELECT a.idbangsal, b.kodebangsal, a.namabangsal, a.jumlahpasien
                FROM rekapjumlahpasien AS a
                    INNER JOIN bangsal AS b ON a.idbangsal = b.idbangsal
                WHERE tanggalrekap = '$tanggalrekap'
                    AND jumlahpasien <> 0
                GROUP BY a.idbangsal, b.kodebangsal, a.namabangsal
                ORDER BY b.kodebangsal ASC"; 

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function listDataPengajuanWhere($idpengajuan)
    {
        $sql = "SELECT idpengajuan, tanggalrekap, tanggalpengajuan
                    FROM pengajuanbahandetail
                    WHERE idpengajuan = '$idpengajuan'
                    GROUP BY idpengajuan, tanggalrekap, tanggalpengajuan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function ExecData_pengajuandiet($data)
    {
        $idpengajuanbahandietdetail = $data['idpengajuanbahandietdetail'];
        $idpengajuan = $data['idpengajuan'];
        $iddiet = $data['iddiet'];
        $idkelas = $data['idkelas']; 
        $idbangsal = $data['idbangsal'];
        $jumlahpasien = $data['jumlahpasien'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->listDataPengajuanWhere($idpengajuan);
        foreach ($q as $t){
            $tanggalrekap = $t['tanggalrekap'];
            $tanggalpengajuan = $t['tanggalpengajuan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($stat == 'delete') {
            
            $this->db->where('idpengajuanbahandietdetail', $idpengajuanbahandietdetail);
            $res = $this->db->delete('pengajuanbahandietdetail');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$tanggalrekap.' '.$tanggalpengajuan.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($idpengajuanbahandietdetail == '') {

                $sql = "INSERT INTO pengajuanbahandietdetail
                            (idpengajuanbahandietdetail,idpengajuan,tanggalrekap,tanggalpengajuan,jumlahpasien,
                            iddiet,namadiet,
                            idkelas,namakelas,
                            idbangsal,namabangsal,
                            idmasakan,namamasakan,
                            idbahan,namabahan,
                            kuantitaspengurangan,satuan,
                            tanggalinsert,idpengguna)
                SELECT UUID() AS idpengajuanbahandietdetail, '$idpengajuan' AS idpengajuan, '$tanggalrekap' AS tanggalrekap, '$tanggalpengajuan' AS tanggalpengajuan, $jumlahpasien AS jumlahpasien
                            , a.iddiet, a.namadiet
                            , b.idkelas, b.namakelas
                            , c.idbangsal, c.namabangsal
                            , d.idmasakan, e.namamasakan
                            , d.idbahan, f.namabahan
                            , d.pengurangan AS kuantitaspengurangan, d.satuan
                            , NOW() AS tanggalinsert, '$pembuatid' AS idpengguna
                            FROM diet AS a
                                INNER JOIN dietmasakanbahan AS d ON a.iddiet = d.iddiet
                                INNER JOIN masakan AS e ON d.idmasakan = e.idmasakan
                                INNER JOIN bahan AS f ON d.idbahan = f.idbahan
                                CROSS JOIN kelas AS b
                                CROSS JOIN bangsal AS c
                            WHERE a.iddiet = '$iddiet'
                                AND b.idkelas = '$idkelas'
                                AND c.idbangsal = '$idbangsal'";
                
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Tambah data: '.$tanggalrekap.' '.$tanggalpengajuan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                $sql = "UPDATE pengajuanbahandietdetail
                        SET jumlahpasien = $jumlahpasien,  
                            tanggalinsert = NOW(),
                            idpengguna = '$pembuatid'
                        WHERE idpengajuanbahandietdetail = '$idpengajuanbahandietdetail';";
                $res = $this->db->query($sql);
                
                if($res) {
                    $data['msg'] = 'Ubah data: '.$tanggalrekap.' '.$tanggalpengajuan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    $this->sistemlog->aktifitas($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function list_pengajuandetail($idpengajuan)
    {
        $sql = "SELECT a.idpengajuanbahandietdetail, a.idpengajuan, a.jumlahpasien
                    , a.iddiet, b.namadiet
                    , a.idkelas, c.namakelas
                    , a.idbangsal, d.namabangsal
                    , d.idruang, e.namaruang
                    , a.idbahan, f.namabahan
                    , a.kuantitaspengurangan, a.satuan
                FROM pengajuanbahandietdetail AS a
                    INNER JOIN diet AS b ON a.iddiet = b.iddiet
                    INNER JOIN kelas AS c ON a.idkelas = c.idkelas
                    INNER JOIN bangsal AS d ON a.idbangsal = d.idbangsal
                    INNER JOIN ruang AS e ON d.idruang = e.idruang
                    INNER JOIN bahan AS f ON a.idbahan = f.idbahan
                WHERE a.idpengajuan = '$idpengajuan'
                ORDER BY b.urutan ASC, e.namaruang ASC, d.namabangsal ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_datapengajuandiet($idpengajuanbahandietdetail)
    {
        $sql = "SELECT idpengajuanbahandietdetail, iddiet, idkelas, idbangsal, jumlahpasien
                FROM pengajuanbahandietdetail
                WHERE idpengajuanbahandietdetail = '$idpengajuanbahandietdetail'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_pengajuan($idpengajuan) 
    {
        $sql = "SELECT a.tanggalrekap 
                FROM pengajuanbahandetail AS a
                WHERE a.idpengajuan = '$idpengajuan'
                GROUP BY a.tanggalrekap";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_kelas_pengajuan($tanggalrekap)
    {
        $sql = "SELECT a.idkelas, b.kodekelas, b.namakelas
                FROM rekapjumlahpasien AS a
                    INNER JOIN kelas AS b ON a.idkelas = b.idkelas
                WHERE a.tanggalrekap = '$tanggalrekap'
                    AND jumlahpasien <> 0
                GROUP BY a.idkelas, b.kodekelas, b.namakelas"; 

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_bangsal_pengajuan()
    {
        $tanggalrekap = $this->input->post('tanggalrekap');
        $idkelas = $this->input->post('idkelas');
        
        $str = "SELECT a.idbangsal, b.kodebangsal, a.namabangsal, a.jumlahpasien
                FROM rekapjumlahpasien AS a
                    INNER JOIN bangsal AS b ON a.idbangsal = b.idbangsal
                WHERE tanggalrekap = '$tanggalrekap'
                    AND jumlahpasien <> 0
                    AND idkelas = '$idkelas'
                GROUP BY a.idbangsal, b.kodebangsal, a.namabangsal
                ORDER BY b.kodebangsal ASC";

        $query = $this->db->query($str);
        $res = $query->result_array();
        return json_encode($res);
    }

    public function get_pengajuan_tanggalpengajuan($tglpengajuan)
    {
        $str = "select idpengajuan, tanggalpengajuan
                from pengajuanbahandetail
                where tanggalpengajuan >= '$tglpengajuan'
                    and tanggalpengajuan <= '$tglpengajuan' + INTERVAL 2 DAY
                group by idpengajuan, tanggalpengajuan";

        $query = $this->db->query($str);
        $res = $query->result_array();
        return $res;
    }

    public function get_pengajuan_tanggal($tanggalpengajuan) 
    {
        $sql = "SELECT a.tanggalrekap 
                FROM pengajuanbahandetail AS a
                WHERE a.tanggalpengajuan = '$tanggalpengajuan'
                GROUP BY a.tanggalrekap";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function listDataPengajuanWhere_sat($tanggalpengajuan)
    {
        $sql = "SELECT idpengajuan, tanggalrekap, tanggalpengajuan
                    FROM pengajuanbahandetail
                    WHERE tanggalpengajuan = '$tanggalpengajuan'
                    GROUP BY idpengajuan, tanggalrekap, tanggalpengajuan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function ExecData_pengajuandiet_sat($data)
    {
        $idpengajuanbahandietdetail = $data['idpengajuanbahandietdetail'];
        $tanggalpengajuan = $data['tanggalpengajuan'];
        $iddiet = $data['iddiet'];
        $idkelas = $data['idkelas']; 
        $idbangsal = $data['idbangsal'];
        $jumlahpasien = $data['jumlahpasien'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->listDataPengajuanWhere_sat($tanggalpengajuan);
        foreach ($q as $t){
            $tanggalrekap = $t['tanggalrekap'];
            //$tanggalpengajuan = $t['tanggalpengajuan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($stat == 'delete') {
            
            // $this->db->where('idpengajuanbahandietdetail', $idpengajuanbahandietdetail);
            // $res = $this->db->delete('pengajuanbahandietdetail');
            
            // if($res) {
            //     $data['msg'] = 'Menghapus data: '.$tanggalrekap.' '.$tanggalpengajuan.', IP: '.$ip_address.', Browser: '.$user_agent;;
            //     $this->sistemlog->aktifitas($data);
            //     return TRUE;
            // } else {
            //     return FALSE;
            // }
        } else {
            if ($idpengajuanbahandietdetail == '') {

                $pengajuan = $this->get_pengajuan_tanggalpengajuan($tanggalpengajuan);
                
                foreach ($pengajuan as $ajukan){
                    $idpengajuan_x = $ajukan['idpengajuan'];
                    $tanggalpengajuan_x = $ajukan['tanggalpengajuan'];
                    
                    $sql = "INSERT INTO pengajuanbahandietdetail
                                (idpengajuanbahandietdetail,idpengajuan,tanggalrekap,tanggalpengajuan,jumlahpasien,
                                iddiet,namadiet,
                                idkelas,namakelas,
                                idbangsal,namabangsal,
                                idmasakan,namamasakan,
                                idbahan,namabahan,
                                kuantitaspengurangan,satuan,
                                tanggalinsert,idpengguna)
                    SELECT UUID() AS idpengajuanbahandietdetail, '$idpengajuan_x' AS idpengajuan, '$tanggalrekap' AS tanggalrekap, '$tanggalpengajuan_x' AS tanggalpengajuan, $jumlahpasien AS jumlahpasien
                                , a.iddiet, a.namadiet
                                , b.idkelas, b.namakelas
                                , c.idbangsal, c.namabangsal
                                , d.idmasakan, e.namamasakan
                                , d.idbahan, f.namabahan
                                , d.pengurangan AS kuantitaspengurangan, d.satuan
                                , NOW() AS tanggalinsert, '$pembuatid' AS idpengguna
                                FROM diet AS a
                                    INNER JOIN dietmasakanbahan AS d ON a.iddiet = d.iddiet
                                    INNER JOIN masakan AS e ON d.idmasakan = e.idmasakan
                                    INNER JOIN bahan AS f ON d.idbahan = f.idbahan
                                    CROSS JOIN kelas AS b
                                    CROSS JOIN bangsal AS c
                                WHERE a.iddiet = '$iddiet'
                                    AND b.idkelas = '$idkelas'
                                    AND c.idbangsal = '$idbangsal'";
                    
                    $res = $this->db->query($sql);
                    
                    // if($res) {
                    //     $data['msg'] = 'Tambah data: '.$tanggalrekap.' '.$tanggalpengajuan.', IP: '.$ip_address.', Browser: '.$user_agent;
                    //     $this->sistemlog->aktifitas($data);
                    //     return TRUE;
                    // } else {
                    //     return FALSE;
                    // }
                }
                return TRUE;
                
            } else {

                // $sql = "UPDATE pengajuanbahandietdetail
                //         SET jumlahpasien = $jumlahpasien,  
                //             tanggalinsert = NOW(),
                //             idpengguna = '$pembuatid'
                //         WHERE idpengajuanbahandietdetail = '$idpengajuanbahandietdetail';";
                // $res = $this->db->query($sql);
                
                // if($res) {
                //     $data['msg'] = 'Ubah data: '.$tanggalrekap.' '.$tanggalpengajuan.', IP: '.$ip_address.', Browser: '.$user_agent;
                //     $this->sistemlog->aktifitas($data);
                //     return TRUE;
                // } else {
                //     return FALSE;
                // }
            }
        }
    }

    public function list_pengajuandetail_tglpengajuan($tanggalpengajuan)
    {
        $sql = "SELECT a.idpengajuanbahandietdetail, a.idpengajuan, a.jumlahpasien
                    , a.iddiet, b.namadiet
                    , a.idkelas, c.namakelas
                    , a.idbangsal, d.namabangsal
                    , d.idruang, e.namaruang
                    , a.idbahan, f.namabahan
                    , a.kuantitaspengurangan, a.satuan
                FROM pengajuanbahandietdetail AS a
                    INNER JOIN diet AS b ON a.iddiet = b.iddiet
                    INNER JOIN kelas AS c ON a.idkelas = c.idkelas
                    INNER JOIN bangsal AS d ON a.idbangsal = d.idbangsal
                    INNER JOIN ruang AS e ON d.idruang = e.idruang
                    INNER JOIN bahan AS f ON a.idbahan = f.idbahan
                WHERE a.tanggalpengajuan = '$tanggalpengajuan'
                ORDER BY b.urutan ASC, e.namaruang ASC, d.namabangsal ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function list_bahansisa($tanggalpengajuan,$tanggalbahansisa)
    {
        $sql = "SELECT a.idbahan, a.namabahan, b.jumlahkuantitas, b.satuan 
                FROM pengajuanbahan AS a
                INNER JOIN (SELECT idbahan, namabahan, SUM(jumlahkuantitas) AS jumlahkuantitas, satuan
                        FROM pengajuanbahandetail
                        WHERE tanggalpengajuan = '$tanggalpengajuan'
                        GROUP BY idbahan, namabahan, satuan) AS b ON a.idbahan = b.idbahan
                WHERE a.tanggalpengajuan = '$tanggalbahansisa' 
                ORDER BY a.namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function list_satuan($tanggalbahansisa)
    {
        $sql = "SELECT satuan
                FROM pengajuanbahan
                WHERE tanggalpengajuan = '$tanggalbahansisa'
                GROUP BY satuan";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function ExecData_bahansisamasakan($data)
    {
        $idsisabahan = $data['idsisabahan'];
        $idpengajuan = $data['idpengajuan'];
        $tanggalpengajuan = $data['tanggalpengajuan'];
        $tanggalsisabahan = $data['tanggalbahansisa']; 
        $idbahansisa = $data['idbahansisa'];
        $jumlahkuantitas = $data['jumlahkuantitas'];
        $satuan = $data['satuan'];
        $pembuatid = $data['pembuatid'];
        $stat = $data['stat'];
        
        $q = $this->get_namabahan($idbahansisa);
        foreach ($q as $t){
            $namabahan = $t['namabahan'];
        }
        
        $data['type'] = 'staff';
        $data['username'] = $this->session->userdata('username');
        $data['url'] = $this->session->userdata('url');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();

        if ($stat == 'delete') {

            $q = $this->get_sisabahan($idsisabahan);
            foreach ($q as $t){
                $tanggalpengajuan = $t['tanggalpengajuan'];
                $namabahan = $t['namabahan'];
            }
            
            $this->db->where('idsisabahan', $idsisabahan);
            $res = $this->db->delete('sisabahan');
            
            if($res) {
                $data['msg'] = 'Menghapus data: '.$tanggalpengajuan.' '.$namabahan.', IP: '.$ip_address.', Browser: '.$user_agent;;
                $this->sistemlog->aktifitas($data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $sql = "INSERT INTO sisabahan
                                (idsisabahan,
                                idpengajuan,
                                tanggalsisabahan,
                                tanggalpengajuan,
                                idbahan,
                                namabahan,
                                jumlahkuantitas,
                                satuan,
                                tanggalinsert,
                                idpengguna)
                    VALUES (UUID(),
                            '$idpengajuan',
                            '$tanggalsisabahan',
                            '$tanggalpengajuan',
                            '$idbahansisa',
                            '$namabahan',
                            '$jumlahkuantitas',
                            '$satuan',
                            NOW(),
                            '$pembuatid')";
            
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

    public function list_sisabahanmasakan($idpengajuan)
    {
        $sql = "SELECT idsisabahan, idpengajuan, tanggalsisabahan, tanggalpengajuan, idbahan, namabahan, jumlahkuantitas, satuan
                FROM sisabahan
                WHERE idpengajuan = '$idpengajuan' ORDER BY namabahan ASC";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_namabahan($idbahan)
    {
        $sql = "SELECT idbahan, namabahan
                FROM bahan
                WHERE idbahan = '$idbahan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_sisabahan($idsisabahan)
    {
        $sql = "SELECT idsisabahan, idpengajuan, tanggalsisabahan, tanggalpengajuan, idbahan, namabahan, jumlahkuantitas, satuan
                FROM sisabahan
                WHERE idsisabahan = '$idsisabahan'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}