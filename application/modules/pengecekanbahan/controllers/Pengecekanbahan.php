<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-10-06 10:36:15
 * @modify date 2019-10-06 10:36:15
 * @desc [description]
 */

class Pengecekanbahan extends MX_Controller {

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('pengecekanbahan_query');
        $this->load->module('access'); 
        $this->load->module('listmenu');
        
        $cek = $this->session->userdata('logged_in');
        if (!$cek) {
            header('location:'.base_url().'access');
        }
    }

    public function index()
    {
        $idgrup = $this->session->userdata('idgrup');
        $url = $this->uri->segment(1);
        $cekhakakses = $this->access->hakakses($idgrup,$url);
        if ($cekhakakses == 1) {
            $modul = $this->listmenu->namamodul($url);
            foreach($modul->result() as $t){
                $sess_data['idmodul'] = $t->idmodul;
                $data['idmodul'] = $t->idmodul;
                $data['idmenu'] = $t->idmenu;
                $data['namamodul'] = $t->namamodul;
                $data['keteranganmodul'] = $t->keterangan;
                $data['namamenu'] = $t->namamenu;
            }
            $this->session->set_userdata($sess_data);
            
            $idmodul = $this->session->userdata('idmodul');
            $btnaksi = $this->listmenu->btnaksi($idmodul,$idgrup);
            foreach($btnaksi->result() as $t){
                $data['add'] = $t->created;
                $data['edit'] = $t->updated;
                $data['delete'] = $t->deleted;
            }

            $data['tanggalsekarang'] = date("Y-m-d");
            
            $this->template
                    ->set_layout('default')
                    ->build('pengecekanbahan_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function tanggalrekappasien()
    {
        $idgrup = $this->session->userdata('idgrup');
        $idmodul = $this->session->userdata('idmodul');
        $btnaksi = $this->listmenu->btnaksi($idmodul,$idgrup);
        foreach($btnaksi->result() as $t){
            $data['add'] = $t->created;
            $data['edit'] = $t->updated;
            $data['delete'] = $t->deleted;
        }

        $data['tglpengajuanbahan'] = $this->security->xss_clean($this->input->post('tglpengajuanbahan'));
        $tglpengajuan = $data['tglpengajuanbahan'];
        $data['cektglpengajuanbahan'] = $this->pengecekanbahan_query->cektglpengajuanbahan($tglpengajuan);

        if (count($data['cektglpengajuanbahan']) == 0) {
            $this->load->view('pengecekanbahan_tglpengajuan_cek', $data);
        } else {        
            //tanggal pengajuan sudah terisi

            $tanggal = $this->pengecekanbahan_query->get_tanggalpengajuan($tglpengajuan);
            $tglpengajuan_1 = $tanggal[0]['tanggalrekap'];
            $daypengajuan_1 = date('D', strtotime($tglpengajuan_1));
            $tglrekappasien_1 = $tanggal[0]['tanggalpengajuan'];
            $dayrekappasien_1 = date('D', strtotime($tglrekappasien_1));

            $dayList = array(
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            );

            $data['tglpengajuan'] = $tglpengajuan_1.', '.$dayList[$daypengajuan_1];
            $data['tglrekappasien'] = $tglrekappasien_1.', '.$dayList[$dayrekappasien_1];
            $data['jumlahpasien'] = $this->pengecekanbahan_query->jumlah_pasienpengajuan($tglpengajuan);
            $data['jenismenumasakan'] = $this->pengecekanbahan_query->jenismenumasakanpengajuan($tglpengajuan);
            $idjenismenu_1 = $data['jenismenumasakan'][0]['idjenismenu'];
            $data['menumasakanwaktu'] = $this->pengecekanbahan_query->get_waktumenupengajuan($tglpengajuan);
            $data['pengajuanbahan'] = $this->pengecekanbahan_query->pengajuanbahanfix($tglpengajuan,$idjenismenu_1);
            $data['idpengajuan'] = $tanggal[0]['idpengajuan'];

            $data['bahantambahan'] = $this->pengecekanbahan_query->pengajuanbahanfix_tambahan($tglpengajuan);

            $this->load->view('pengecekanbahan_tglpengajuan_cek', $data);
        }        
    }

    public function detailmenumasakan()
    {
        $data['idjenismenu'] = $this->security->xss_clean($this->input->post('idjenismenu'));

        $data['jenismenumasakan'] = $this->pengecekanbahan_query->jenismenumasakan($data['idjenismenu']);

        $data['kelasmenumasakan'] = $this->pengecekanbahan_query->kelasmenumasakan($data['idjenismenu']);
        $data['waktumenumasakan'] = $this->pengecekanbahan_query->waktumenumasakan($data['idjenismenu']);
        $data['menumasakan'] = $this->pengecekanbahan_query->menumasakan($data['idjenismenu']);

        $this->load->view('pengecekanbahan_detailmenumasakan', $data);
    }

    public function cek_pengajuan()
    {
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $data['idbahansupplier'] = $this->security->xss_clean($this->input->post('idbahansupplier'));
        $data['pengajuan'] = $this->security->xss_clean($this->input->post('pengajuan'));

        $data['get_pengajuanbahansupplier'] = $this->pengecekanbahan_query->get_pengajuanbahansupplier($data['idpengajuan'],$data['idbahansupplier']);

        if ($data['pengajuan'] == 'tidak_sesuai') {
            $this->load->view('pengecekanbahan_form_realisasi_bahan', $data);
        } elseif ($data['pengajuan'] == 'sesuai') {
            $result = $this->pengecekanbahan_query->submit_pengajuanbahan($data['get_pengajuanbahansupplier'],$data['pengajuan']);            
        } else {
            $result = $this->pengecekanbahan_query->delete_pengajuanbahan($data['idpengajuan'],$data['idbahansupplier']);
        }
    }

    public function simpanpengajuanbahancek()
    {
        $data['pengajuan'] = $this->security->xss_clean($this->input->post('pengajuan'));
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $data['idbahansupplier'] = $this->security->xss_clean($this->input->post('idbahansupplier'));

        $real['jumlahkuantitasreal'] = $this->security->xss_clean($this->input->post('jumlahkuantitasreal'));
        $real['hargatotalreal'] = $this->security->xss_clean($this->input->post('hargatotalreal'));

        $data['get_pengajuanbahansupplier'] = $this->pengecekanbahan_query->get_pengajuanbahansupplier($data['idpengajuan'],$data['idbahansupplier']);

        $result = $this->pengecekanbahan_query->submit_pengajuanbahan($data['get_pengajuanbahansupplier'],$data['pengajuan'],$real);
    }

    public function cetakpengecekan()
    {
        $idpengajuan = $this->uri->segment(3);

        $kelas = $this->pengecekanbahan_query->pengajuanbahan_kelas('pilihsemua',$idpengajuan);
        $waktumenu = $this->pengecekanbahan_query->pengajuanbahan_waktumenu('pilihsemua',$idpengajuan);
        $pengajuanbahan = $this->pengecekanbahan_query->get_pengecekanbahanfix($idpengajuan);
        $tanggalpengajuan = $this->pengecekanbahan_query->tanggalpengajuan($idpengajuan);

        $klss = array();
        foreach ($kelas as $kls) {
            $klss[] = $kls['namakelas'];
        }
        $kelas_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($klss))));

        $wkts = array();
        foreach ($waktumenu as $wkt) {
            $wkts[] = $wkt['namawaktumenu'];
        }
        $waktu_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($wkts))));

        $tanggalpengajuan = $tanggalpengajuan[0]['tanggalpengajuan'];

        include_once APPPATH."third_party/fpdf17/custom/PDF_PengecekanBahanMasakan.php";

        $pdf=new PDF_absensi('P','mm','A4');
        $pdf -> setPengajuanBahan($pengajuanbahan);
        $pdf -> setKelasPengajuanBahan($kelas_pengajuan);
        $pdf -> setWaktuPengajuanBahan($waktu_pengajuan);
        $pdf -> setTanggalPengajuanBahan($tanggalpengajuan);

		$pdf->SetMargins(5,5,5,5);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Content();
        // $pdf->Output();
        $tanggal = str_replace("-","",$tanggalpengajuan);
        $fileName = 'penerimaan_bm'.$tanggal.'.pdf';
        $pdf->Output($fileName, 'D');
    }

    public function cetakpengecekan_jenisbahan()
    {
        $idpengajuan = $this->uri->segment(3);

        $kelas = $this->pengecekanbahan_query->pengajuanbahan_kelas('pilihsemua',$idpengajuan);
        $waktumenu = $this->pengecekanbahan_query->pengajuanbahan_waktumenu('pilihsemua',$idpengajuan);
        $pengajuanbahan = $this->pengecekanbahan_query->get_pengecekanbahanfix($idpengajuan);
        $tanggalpengajuan = $this->pengecekanbahan_query->tanggalpengajuan($idpengajuan);

        $jenisbahanpengajuan = $this->pengecekanbahan_query->get_jenisbahan($idpengajuan);

        $klss = array();
        foreach ($kelas as $kls) {
            $klss[] = $kls['namakelas'];
        }
        $kelas_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($klss))));

        $wkts = array();
        foreach ($waktumenu as $wkt) {
            $wkts[] = $wkt['namawaktumenu'];
        }
        $waktu_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($wkts))));

        $tanggalpengajuan = $tanggalpengajuan[0]['tanggalpengajuan'];

        include_once APPPATH."third_party/fpdf17/custom/PDF_PengecekanBahanMasakan_JenisBahan.php";

        $pdf=new PDF_absensi('P','mm','A4');
        $pdf -> setPengajuanBahan($pengajuanbahan);
        $pdf -> setKelasPengajuanBahan($kelas_pengajuan);
        $pdf -> setWaktuPengajuanBahan($waktu_pengajuan);
        $pdf -> setTanggalPengajuanBahan($tanggalpengajuan);
        $pdf -> setJenisBahanPengajuan($jenisbahanpengajuan);

		$pdf->SetMargins(5,5,5,5);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Content();
        // $pdf->Output();
        $tanggal = str_replace("-","",$tanggalpengajuan);
        $fileName = 'penerimaan_bm'.$tanggal.'_jenisbahan.pdf';
        $pdf->Output($fileName, 'D');
    }

    public function form_bahantambahan()
    {
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $pengajuan = $this->pengecekanbahan_query->get_pengajuan($data['idpengajuan']);
        $data['tanggalrekappasien'] = $pengajuan[0]['tanggalrekap'];
        $data['tanggalpengajuan'] = $pengajuan[0]['tanggalpengajuan'];
        $data['bahantambahan'] = $this->pengecekanbahan_query->get_bahansupplier();
        $data['satuan'] = $this->pengecekanbahan_query->get_satuan();
        
        $this->load->view('form_bahantambahan', $data);
    }

    public function savedata_bahantambahan()
    {
        $up['idbahanpengajuan'] = $this->security->xss_clean($this->input->post('idbahanpengajuan'));
        $up['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $up['tanggalrekappasien'] = $this->security->xss_clean($this->input->post('tanggalrekappasien'));
        $up['tanggalpengajuan'] = $this->security->xss_clean($this->input->post('tanggalpengajuan'));
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['jumlahkuantitas'] = $this->security->xss_clean($this->input->post('jumlahkuantitas'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['hargatotal'] = $this->security->xss_clean($this->input->post('hargatotal'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $this->pengecekanbahan_query->ExecData_pengajuanbahantambahan($up);        
    }

    public function batalpengajuanbahancek()
    {
        $data['pengajuan'] = $this->security->xss_clean($this->input->post('pengajuan'));
        $data['idpengajuan'] = $this->security->xss_clean($this->input->post('idpengajuan'));
        $data['idbahansupplier'] = $this->security->xss_clean($this->input->post('idbahansupplier'));

        $real['jumlahkuantitasreal'] = $this->security->xss_clean($this->input->post('jumlahkuantitasreal'));
        $real['hargatotalreal'] = $this->security->xss_clean($this->input->post('hargatotalreal'));

        $data['get_pengajuanbahansupplier'] = $this->pengecekanbahan_query->get_pengajuanbahansupplier($data['idpengajuan'],$data['idbahansupplier']);

        $result = $this->pengecekanbahan_query->batal_pengajuanbahan($data['get_pengajuanbahansupplier'],$data['pengajuan'],$real);
    }

    public function hitung_hargatotal()
    {
        $idbahan = $this->security->xss_clean($this->input->post('idbahan'));
        $jumlahkuantitas = $this->security->xss_clean($this->input->post('jumlahkuantitas'));

        $result = $this->pengecekanbahan_query->hitung_hargatotal($idbahan,$jumlahkuantitas);
    }

    public function cetakpengecekan_fix()
    {
        $idpengajuan = $this->uri->segment(3);

        $kelas = $this->pengecekanbahan_query->pengajuanbahan_kelas('pilihsemua',$idpengajuan);
        $waktumenu = $this->pengecekanbahan_query->pengajuanbahan_waktumenu('pilihsemua',$idpengajuan);
        $pengajuanbahan = $this->pengecekanbahan_query->get_pengecekanbahanfix_fix($idpengajuan);
        $tanggalpengajuan = $this->pengecekanbahan_query->tanggalpengajuan($idpengajuan);

        $klss = array();
        foreach ($kelas as $kls) {
            $klss[] = $kls['namakelas'];
        }
        $kelas_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($klss))));

        $wkts = array();
        foreach ($waktumenu as $wkt) {
            $wkts[] = $wkt['namawaktumenu'];
        }
        $waktu_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($wkts))));

        $tanggalpengajuan = $tanggalpengajuan[0]['tanggalpengajuan'];

        include_once APPPATH."third_party/fpdf17/custom/PDF_PengecekanBahanMasakan_fix.php";

        $pdf=new PDF_absensi('P','mm','A4');
        $pdf -> setPengajuanBahan($pengajuanbahan);
        $pdf -> setKelasPengajuanBahan($kelas_pengajuan);
        $pdf -> setWaktuPengajuanBahan($waktu_pengajuan);
        $pdf -> setTanggalPengajuanBahan($tanggalpengajuan);

		$pdf->SetMargins(5,5,5,5);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Content();
        // $pdf->Output();
        $tanggal = str_replace("-","",$tanggalpengajuan);
        $fileName = 'penerimaan_fix_bm'.$tanggal.'.pdf';
        $pdf->Output($fileName, 'D');
    }

    public function cetakpengecekan_jenisbahan_fix()
    {
        $idpengajuan = $this->uri->segment(3);

        $kelas = $this->pengecekanbahan_query->pengajuanbahan_kelas('pilihsemua',$idpengajuan);
        $waktumenu = $this->pengecekanbahan_query->pengajuanbahan_waktumenu('pilihsemua',$idpengajuan);
        $pengajuanbahan = $this->pengecekanbahan_query->get_pengecekanbahanfix_fix($idpengajuan);
        $tanggalpengajuan = $this->pengecekanbahan_query->tanggalpengajuan($idpengajuan);

        $jenisbahanpengajuan = $this->pengecekanbahan_query->get_jenisbahan($idpengajuan);

        $klss = array();
        foreach ($kelas as $kls) {
            $klss[] = $kls['namakelas'];
        }
        $kelas_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($klss))));

        $wkts = array();
        foreach ($waktumenu as $wkt) {
            $wkts[] = $wkt['namawaktumenu'];
        }
        $waktu_pengajuan = str_replace("]",'',str_replace("[",'',str_replace('"','', json_encode($wkts))));

        $tanggalpengajuan = $tanggalpengajuan[0]['tanggalpengajuan'];

        include_once APPPATH."third_party/fpdf17/custom/PDF_PengecekanBahanMasakan_fix_JenisBahan.php";

        $pdf=new PDF_absensi('P','mm','A4');
        $pdf -> setPengajuanBahan($pengajuanbahan);
        $pdf -> setKelasPengajuanBahan($kelas_pengajuan);
        $pdf -> setWaktuPengajuanBahan($waktu_pengajuan);
        $pdf -> setTanggalPengajuanBahan($tanggalpengajuan);
        $pdf -> setJenisBahanPengajuan($jenisbahanpengajuan);

		$pdf->SetMargins(5,5,5,5);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Content();
        // $pdf->Output();
        $tanggal = str_replace("-","",$tanggalpengajuan);
        $fileName = 'penerimaan_fix_bm'.$tanggal.'_jenisbahan.pdf';
        $pdf->Output($fileName, 'D');
    }

}