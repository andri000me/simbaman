<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prediksipengajuan extends MX_Controller {

    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('prediksipengajuan_query');
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
            
            $tglprediksi = date('Y-m-d', strtotime("-30 day"));
            $harix = 30;
            
            $data['prediksi'] = $this->prediksipengajuan_query->get_prediksibahan($tglprediksi,$harix);

            $data['tgl_sekarang'] = date('Y-m-d');
            $data['tgl_prediksi'] = $tglprediksi;
            
            $this->template
                    ->set_layout('default')
                    ->build('prediksipengajuan_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function get_prediksi()
    {
        $data['bulan'] = $this->security->xss_clean($this->input->post('bulan'));

        switch ($data['bulan']) {
            case 1:
                $hari = '-30 days';
                break;
            case 3:
                $hari = '-91 days';
                break;
            case 6:
                $hari = '-182 days';
                break;
            case 12:
                $hari = '-365 days';
                break;
            default:
                $hari = '0 days';
        } 

        switch ($data['bulan']) {
            case 1:
                $harix = 30;
                break;
            case 3:
                $harix = 91;
                break;
            case 6:
                $harix = 182;
                break;
            case 12:
                $harix = 365;
                break;
            default:
                $harix = 0;
        }

        $tglprediksi = date('Y-m-d', strtotime($hari));
            
        $data['prediksi'] = $this->prediksipengajuan_query->get_prediksibahan($tglprediksi,$harix);

        $data['tgl_sekarang'] = date('Y-m-d');
        $data['tgl_prediksi'] = $tglprediksi;

        $this->load->view('prediksikebutuhan_bahan', $data);
    }

    public function cetakprediksi()
    {
        $data['bulan'] = $this->uri->segment(3);

        switch ($data['bulan']) {
            case 1:
                $hari = '-30 days';
                break;
            case 3:
                $hari = '-90 days';
                break;
            case 6:
                $hari = '-180 days';
                break;
            default:
                $hari = '0 days';
        } 

        switch ($data['bulan']) {
            case 1:
                $harix = 30;
                break;
            case 3:
                $harix = 91;
                break;
            case 6:
                $harix = 182;
                break;
            case 12:
                $harix = 365;
                break;
            default:
                $harix = 0;
        }

        $tglprediksi = date('Y-m-d', strtotime($hari));
            
        $prediksi = $this->prediksipengajuan_query->get_prediksibahan($tglprediksi,$harix);

        $bulan = $data['bulan'];
        $tgl_sekarang = date('Y-m-d');
        $tgl_prediksi = $tglprediksi;

        include_once APPPATH."third_party/fpdf17/custom/PDF_PrediksiPengajuanBahan.php";

        $pdf=new PDF_absensi('P','mm','A4');
        $pdf -> setPrediksiBahan($prediksi);
        $pdf -> setBulan($bulan);
        $pdf -> setTglSekarang($tgl_sekarang);
        $pdf -> setTglPrediksi($tgl_prediksi);

		$pdf->SetMargins(5,5,5,5);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Content();
		$pdf->Output();
    }

}