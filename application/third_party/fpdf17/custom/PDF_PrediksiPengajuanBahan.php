<?php 

include_once dirname(dirname(__FILE__)) . "/fpdf.php";

class PDF_absensi extends FPDF
{
    protected $prediksi;
    protected $bulan;
    protected $tgl_sekarang;
    protected $tgl_prediksi;

    public function setPrediksiBahan($prediksi)
	{
		$this -> prediksi = $prediksi;
    }

    public function setBulan($bulan)
	{
		$this -> bulan = $bulan;
    }

    public function setTglSekarang($tgl_sekarang)
	{
		$this -> tgl_sekarang = $tgl_sekarang;
    }

    public function setTglPrediksi($tgl_prediksi)
	{
		$this -> tgl_prediksi = $tgl_prediksi;
    }
    
    function Header()
	{
        $this->SetFont('Arial', 'B', 9);		
        $this->Text(40,6, 'PREDIKSI PENGAJUAN BAHAN MASAKAN');
        $this->Text(40,10, 'INSTALASI GIZI RS');
		$this->Line(40,12,106,12);
		$this->SetFont('Arial', '', 9);
        $this->Text(40,16, 'Prediksi Kebutuhan Bahan Selama '.$this -> bulan.' Bulan');
        $this->Text(40,20, 'Mulai tanggal '.$this -> tgl_prediksi.' s/d '.$this -> tgl_sekarang.'.');
        
        $this->Line(205, 26, 5, 26);
		
        $this->Ln(25); /* */
        
        $width_no = 12;
        $width_namabahan = 55;
        $width_jumlah = 35;
        $width_satuan = 20;
        $width_harga = 35;
        $width_hargatotal = 45;
        
		$height = 9;
		$value_height = 8;
        $this->setFont('Arial','B',10);
        $this->setFillColor(237,237,237);

		$this->cell($width_no,$height,'No',1,0,'C',1);
		$this->cell($width_namabahan,$height,'Nama Bahan',1,0,'C',1);
        $this->cell($width_jumlah,$height,'Jumlah Kebutuhan',1,0,'C',1);
        $this->cell($width_satuan,$height,'Satuan',1,0,'C',1);
        $this->cell($width_harga,$height,'Harga Supplier',1,0,'C',1);
        $this->cell($width_hargatotal,$height,'Harga Total',1,0,'C',1);
        $this->Ln();
    }

    //Page Content
	function Content()
	{        
        $width_no = 12;
        $width_namabahan = 55;
        $width_jumlah = 35;
        $width_satuan = 20;
        $width_harga = 35;
        $width_hargatotal = 45;
        
		$height = 9;
		$value_height = 8;
        // $this->setFont('Arial','',10);
        // $this->setFillColor(237,237,237);

		// $this->cell($width_no,$height,'No',1,0,'C',1);
		// $this->cell($width_namabahan,$height,'Nama Bahan',1,0,'C',1);
        // $this->cell($width_jumlah,$height,'Jumlah Kebutuhan',1,0,'C',1);
        // $this->cell($width_satuan,$height,'Satuan',1,0,'C',1);
        // $this->cell($width_harga,$height,'Harga Supplier',1,0,'C',1);
        // $this->cell($width_hargatotal,$height,'Harga Total',1,0,'C',1);
        // $this->cell($width_ceklist,$height,'Ceklist',1,0,'C',1);
        // $this->Ln();
        $this->setFont('Arial','',9);
        $this->setFillColor(255,255,255);
        $hargatotal = 0;
        foreach($this -> prediksi as $key => $data){
            $nomor = $key+1;
            $this->cell($width_no,$value_height,$nomor,1,0,'C',1);
            $this->cell($width_namabahan,$value_height,$data['namabahan'],1,0,'L',1);
            $this->cell($width_jumlah,$value_height,number_format($data['rata_kuantitasreal'],2),1,0,'R',1);
            $this->cell($width_satuan,$value_height,$data['satuan'],1,0,'C',1);
            $this->cell($width_harga,$value_height,number_format($data['hargasatuansupplier'],2),1,0,'R',1);
            $this->cell($width_hargatotal,$value_height,number_format($data['rata_totalreal'],2,",","."),1,0,'R',1);
            $this->Ln();
            $hargatotal = $hargatotal + $data['rata_totalreal'];
        }
        $this->setFont('Arial','',10);
        $this->setFillColor(237,237,237);
        $this->cell(157,$height,'Harga Total Pengajuan Bahan Masakan',1,0,'C',1);
        $this->cell($width_hargatotal,$height,number_format($hargatotal,2,",","."),1,0,'R',1);
        
    }
    // Page footer
	function Footer()
	{            
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}