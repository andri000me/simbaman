<?php
include('./mpdf60/mpdf.php');
$mpdf=new mPDF();
$mpdf->WriteHTML('<div>Hallo World</div>');
$mpdf->Output();