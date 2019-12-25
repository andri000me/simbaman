<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
    
    protected $data = '';

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('dashboard_query');
		
    }

    function pingAddress($ip) {
        $pingresult = exec("/bin/ping -n 3 $ip", $outcome, $status);
        if (0 == $status) {
            $status = "alive";
        } else {
            $status = "dead";
        }
        return $status;
    }
    
    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('access/login', 'refresh');
        } else {
            $data['namamodul'] = 'Dashboard';
            $data['keteranganmodul'] = 'Dashboard';
            $data['namamenu'] = 'Dashboard';

            $tgl_sekarang = $this->dashboard_query->get_datepasien();
            $data['pasien'] = $this->dashboard_query->get_pasien($tgl_sekarang[0]['tanggalrekap']);  
            
            $data['pengajuan'] = $this->dashboard_query->get_pengajuan($tgl_sekarang[0]['tanggalrekap']);
            $data['pengecekan'] = $this->dashboard_query->get_pengecekan($tgl_sekarang[0]['tanggalrekap']);

            $bahanmasakan = $this->dashboard_query->get_bahanmasakan();

            foreach ( $bahanmasakan as $row ){
                $res_nama[] = $row['namabahan'].' ('.$row['satuan'].')';
                $res_angka[] = $row['jumlahkuantitas'];                
            }

            $data['grafik_nama'] = json_encode($res_nama, true);
            $data['grafik_angka'] = json_encode($res_angka, true);

            $masakan = $this->dashboard_query->get_masakan();

            foreach ( $masakan as $row ){
                $res_nama_masakan[] = $row['namamasakan'];
                $res_pasien[] = $row['jmlpasien'];                
            }

            $data['grafik_nama_masakan'] = json_encode($res_nama_masakan, true);
            $data['grafik_pasien'] = json_encode($res_pasien, true);

            $this->template
                    ->set_layout('default')
                    ->build('dashboard_view',$data);
        }
    }

    public function detail_pasien()
    {
        $idkelas = $this->security->xss_clean($this->input->post('idkelas'));
        $tanggalrekap = $this->security->xss_clean($this->input->post('tanggalrekap'));
        $data['detail'] = $this->dashboard_query->get_detailpasien($idkelas,$tanggalrekap);
        $data['tanggalsekarang'] = $tanggalrekap;

        $this->load->view('dashboard_detailpasien', $data);
    }
    
    public function cekrekap_pasien()
    {
        $stat_ping = $this->pingAddress("http://sididik.rsjsoerojo.co.id");
        
        if ($stat_ping == 'dead') {
            $data['tanggalsekarang'] = date('Y-m-d');
            
            $data['informasi'] = '<div class="row" style="margin-bottom:10px">
                        <div class="col-lg-12" style="text-align: center;">
                            <div class="alert alert-danger alert-dismissible">
                                <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
                                Halaman http://sididik.rsjsoerojo.co.id putus, mohon untuk menghubungi IT.
                            </div>
                        </div>
                    </div>';

            $this->load->view('rekappasien_informasi', $data);

        } else {
            
            $data['tanggalsekarang'] = date('Y-m-d');
            // $data['tanggalsekarang'] = $this->security->xss_clean($this->input->post('tanggalsekarang'));

            $tglterakhir = $this->dashboard_query->get_tglterakhir($data['tanggalsekarang']);

            if (count($tglterakhir) == 0) {
                $tglrekap = $data['tanggalsekarang'];

                $url='http://sididik.rsjsoerojo.co.id/ranap/pasiengizi/'.$data['tanggalsekarang'];
                $json = file_get_contents($url);
                $pasien = json_decode($json,true);
                $data_pasien = $pasien['data'];
                if (count($data_pasien) == 0) {
                    $data['informasi'] = '<div class="row" style="margin-bottom:10px">
                        <div class="col-lg-12" style="text-align: center;">
                            <div class="alert alert-danger alert-dismissible">
                                <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
                                Data pasien tanggal '.$tglrekap.'belum tersedia, silahkan membuka tanggal yang lain.
                            </div>
                        </div>
                    </div>';
                    $this->load->view('rekappasien_informasi', $data);
                } else {
                    $this->dashboard_query->import_data_json($pasien);

                    $data['grupkelas'] = $this->dashboard_query->get_grupkelas_tmp();
                    $data['grupruangan'] = $this->dashboard_query->get_grupruangan_tmp();
                    $data['jumlahpasien'] = $this->dashboard_query->get_jumlahpasien_tmp();
                    $tglrekap = $this->dashboard_query->get_tanggalrekappasien_tmp();

                    $data['tglrekap'] = $tglrekap[0]['tanggalrekap'];

                    $this->load->view('rekap_pasien_tmp', $data);
                }
            } else {
                echo '100';
            }
        }
    }

    public function importdata()
    {
        $tglrekap = $this->security->xss_clean($this->input->post('tglrekap'));

        $result = $this->dashboard_query->importdata($tglrekap);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}