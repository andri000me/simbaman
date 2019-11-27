<?php 

include_once dirname(dirname(__FILE__)) . "/fpdf.php";


class PDF_username_password extends FPDF
{
	protected $participants;
    // Page header
	public function setDataPeserta($peserta)
	{
		$this -> participants = $peserta;
	}
	
	function Header()
	{
		/* $this->Image(dirname(__FILE__).'/logo.png',10,5,20);


		$this->SetFont('Arial', 'B', 20);		
		$this->Text(90,16, 'LAPORAN PEMBUATAN SOAL PER KONTRIBUTOR');
		$this->SetFont('Arial', '', 10);
		$this->Text(30,20, '');
		
		$this->Line(350, 26, 5, 26);
		
		$this->Ln(25); */

	}
        
        //Page Content
	function Content()
	{
		$width_nama = 85;
		$width_no = 22;
		$width_upass = 45;
		$height = 14;
		$value_height = 21;
        $this->setFont('Arial','',14);
        $this->setFillColor(237,237,237);
		foreach($this -> participants as $key => $participant){
			$this->cell($width_no,$height,'NO',1,0,'C',1);
			$this->cell($width_nama,$height,'NAMA',1,0,'C',1);
			$this->cell($width_upass,$height,'USERNAME',1,0,'C',1);
			$this->cell($width_upass,$height,'PASSWORD',1,0,'C',1);
			$this->Ln();
			$this->cell($width_no,$value_height,$key+1,1,0,'C',0);
			$this->cell($width_nama,$value_height,$participant['namalengkap'],1,0,'C',0);
			$this->cell($width_upass,$value_height,$participant['username'],1,0,'C',0);
			$this->cell($width_upass,$value_height,$participant['pwd_from_userid'],1,0,'C',0);
			$this->Ln();
			$this->Ln(9);
		}
    }
        
	function WordWrap(&$text, $maxwidth)
	{
		$text = trim($text);
		if ($text==='')
			return 0;
		$space = $this->GetStringWidth(' ');
		$lines = explode("\n", $text);
		$text = '';
		$count = 0;

		foreach ($lines as $line)
		{
			$words = preg_split('/ +/', $line);
			$width = 0;

			foreach ($words as $word)
			{
				$wordwidth = $this->GetStringWidth($word);
				if ($wordwidth > $maxwidth)
				{
					// Word is too long, we cut it
					for($i=0; $i<strlen($word); $i++)
					{
						$wordwidth = $this->GetStringWidth(substr($word, $i, 1));
						if($width + $wordwidth <= $maxwidth)
						{
							$width += $wordwidth;
							$text .= substr($word, $i, 1);
						}
						else
						{
							$width = $wordwidth;
							$text = rtrim($text)."\n".substr($word, $i, 1);
							$count++;
						}
					}
				}
				elseif($width + $wordwidth <= $maxwidth)
				{
					$width += $wordwidth + $space;
					$text .= $word.' ';
				}
				else
				{
					$width = $wordwidth + $space;
					$text = rtrim($text)."\n".$word.' ';
					$count++;
				}
			}
			$text = rtrim($text)."\n";
			$count++;
		}
		$text = rtrim($text);
		return $count;
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