<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_query extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    public function get_datepasien()
    {
        $sql = "SELECT a.tanggalrekap
                FROM rekapjumlahpasien AS a
                GROUP BY a.tanggalrekap
                ORDER BY a.tanggalrekap DESC";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_pasien($tgl_sekarang)
    {
        $sql = "SELECT a.idkelas, a.namakelas, SUM(a.jumlahpasien) AS jumlah, a.tanggalrekap
                FROM rekapjumlahpasien AS a
                WHERE a.tanggalrekap = '$tgl_sekarang'
                GROUP BY a.idkelas, a.namakelas, a.tanggalrekap
                ORDER BY a.namakelas";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_detailpasien($idkelas,$tanggalrekap)
    {
        $sql = "SELECT a.idruang, b.koderuang, a.namaruang
                    , a.idbangsal, c.kodebangsal, a.namabangsal
                    , a.idkelas, a.namakelas, a.jumlahpasien, a.tanggalrekap
                FROM rekapjumlahpasien AS a
                    INNER JOIN ruang AS b ON a.idruang = b.idruang
                    INNER JOIN bangsal AS c ON a.idbangsal = c.idbangsal
                WHERE a.tanggalrekap = '$tanggalrekap'
                    AND a.idkelas = '$idkelas'
                    AND a.jumlahpasien <> 0
                ORDER BY b.koderuang ASC, c.kodebangsal ASC";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_tglterakhir($tanggalrekap)
    {
        $sql = "SELECT tanggalrekap
            FROM rekapjumlahpasien
            WHERE tanggalrekap = '$tanggalrekap'
            GROUP BY tanggalrekap
            ORDER BY tanggalrekap DESC LIMIT 1";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_grupkelas($tglterakhir)
    {
        $sql = "SELECT namakelas
            FROM rekapjumlahpasien
            WHERE tanggalrekap = '$tglterakhir'
            GROUP BY namakelas, tanggalrekap";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_grupruangan($tglterakhir)
    {
        $sql = "SELECT b.namaruang, b.namabangsal, c.jml, SUM(b.jumlahpasien) AS jumlahpasien
                    FROM rekapjumlahpasien AS b
                    INNER JOIN (SELECT a.namaruang, COUNT(namabangsal) AS jml
                    FROM (SELECT namaruang, namabangsal
                    FROM rekapjumlahpasien
                    WHERE tanggalrekap = '$tglterakhir'
                    GROUP BY namaruang, namabangsal, tanggalrekap) AS a GROUP BY a.namaruang) AS c ON c.namaruang = b.namaruang
                    WHERE b.tanggalrekap = '$tglterakhir'
                    GROUP BY b.namaruang, b.namabangsal, b.tanggalrekap
                    ORDER BY b.namaruang ASC, b.namabangsal ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_jumlahpasien($tglterakhir)
    {
        $sql = "SELECT idrekapjumlahpasien, namabangsal, namakelas, jumlahpasien
                FROM rekapjumlahpasien
                WHERE tanggalrekap = '$tglterakhir'";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_grupkelas_tmp()
    {
        $sql = "SELECT namakelas
            FROM rekapjumlahpasien_tmp
            GROUP BY namakelas, tanggalrekap";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_grupruangan_tmp()
    {
        $sql = "SELECT b.namaruang, b.namabangsal, c.jml, SUM(b.jumlahpasien) AS jumlahpasien
                    FROM rekapjumlahpasien_tmp AS b
                    INNER JOIN (SELECT a.namaruang, COUNT(namabangsal) AS jml
                    FROM (SELECT namaruang, namabangsal
                    FROM rekapjumlahpasien_tmp
                    GROUP BY namaruang, namabangsal, tanggalrekap) AS a GROUP BY a.namaruang) AS c ON c.namaruang = b.namaruang
                    GROUP BY b.namaruang, b.namabangsal, b.tanggalrekap
                    ORDER BY b.namaruang ASC, b.namabangsal ASC";

        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_jumlahpasien_tmp()
    {
        $sql = "SELECT namabangsal, namakelas, jumlahpasien
                FROM rekapjumlahpasien_tmp";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_tanggalrekappasien_tmp()
    {
        $sql = "SELECT tanggalrekap
                FROM rekapjumlahpasien_tmp
                GROUP BY tanggalrekap";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function import_data_json($sheet)
    {
        $data = array();

        $numrow = 1;
		foreach($sheet['data'] as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'koderuang' => $row['kd_ruang'],
					'kodebangsal' => $row['kd_bangsal'], 
					'kodekelas' => $row['kd_kelas'], 
                    'namaruang' => $row['nm_ruang'], 
                    'namabangsal' => $row['nm_bangsal'],
                    'namakelas' => $row['nm_kelas'],
                    'jumlahpasien' => $row['jml_pasien'],
                    'tanggalrekap' => $row['tanggalrekap'],
				));
			}
			
			$numrow++;
        }

        $this->db->truncate('rekapjumlahpasien_tmp');

        $insert = $this->db->insert_batch('rekapjumlahpasien_tmp', $data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function importdata($tglrekap)
    {
        $insert = "INSERT INTO rekapjumlahpasien
                (idrekapjumlahpasien, idruang, namaruang, idbangsal, namabangsal, idkelas, namakelas, jumlahpasien, tanggalrekap, tanggalupdate)
                SELECT UUID(), d.idruang, d.namaruang
                    , d.idbangsal, d.namabangsal
                    , d.idkelas, d.namakelas
                    , IFNULL(e.jumlahpasien, 0) AS jumlahpasien, '$tglrekap' AS tanggalrekap
                    , NOW() AS tanggalupdate
                FROM (SELECT a.idruang, a.koderuang, a.namaruang
                            , b.idbangsal, b.kodebangsal, b.namabangsal
                            , c.idkelas, c.kodekelas, c.namakelas
                        FROM ruang AS a
                        INNER JOIN bangsal AS b ON a.idruang = b.idruang
                    CROSS JOIN kelas AS c
                WHERE a.koderuang IS NOT NULL) AS d
                LEFT OUTER JOIN (SELECT namaruang, koderuang, namabangsal, kodebangsal, namakelas, kodekelas, jumlahpasien, tanggalrekap FROM rekapjumlahpasien_tmp WHERE tanggalrekap = '$tglrekap') AS e ON d.koderuang = e.koderuang
                AND d.kodebangsal = e.kodebangsal
                AND d.kodekelas = e.kodekelas";

                echo $insert;

        $query = $this->db->query($insert);
        if ($query) {
            $this->db->truncate('rekapjumlahpasien_tmp');
            return true;
        } else {
            return false;
        }
    }

    public function get_pengajuan($tgl_sekarang)
    {
        $sql = "select z.stat
                    , z.tanggalpengajuan
                    , sum(z.hargatotal) as hargatotal		
                from (
                        select a.namabahan, a.tanggalpengajuan
                                , sum(a.jumlahpasien) as jumlahpasien
                                , sum(a.jumlahkuantitas) as jumlahkuantitas
                                , a.hargasatuansupplier
                                , sum(a.hargatotal) as hargatotal
                                , 'pengajuan' as stat
                        from pengajuanbahandetail as a
                        where a.tanggalrekap = '$tgl_sekarang'
                        group by a.namabahan, a.tanggalpengajuan, a.hargasatuansupplier ) as z
                group by z.tanggalpengajuan";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function get_pengecekan($tgl_sekarang)
    {
        $sql = "select y.stat
                    , y.tanggalpengajuan
                    , sum(y.hargatotalreal) as hargatotal
                from (
                    select b.namabahan, b.tanggalpengajuan
                        , sum(b.hargatotalreal) as hargatotalreal
                        , 'pengecekan' as stat
                    from pengajuanbahan as b
                    where b.tanggalrekappasien = '$tgl_sekarang'
                    group by b.namabahan, b.tanggalpengajuan) as y
                group by y.tanggalpengajuan";
            
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

}