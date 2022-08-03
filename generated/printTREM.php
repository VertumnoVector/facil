<?php
require('../res/fpdf/fpdf.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

class PDF extends FPDF{
    function Header(){
        if ($this->header == 1 ) {
            // Logo
            $this->Image('../assets/img/logo.png',95,6,20);
            $this->SetFont('Calibri Bold',"",12);
            // Move to the right
            $this->setY(25);
            $this->Cell(46);
            $this->MultiCell(100,6,'MINISTÉRIO DA DEFESA',0,'C',false);
            $this->Cell(46);
            $this->MultiCell(100,6,'EXÉRCITO BRASILEIRO',0,'C',false);
            $this->Cell(46);
            $this->MultiCell(100,6,$this->nomeOM,0,'C',false);
            $this->Cell(46);
            $this->MultiCell(100,6,'(3º BE / 1917)',0,'C',false);
            $this->Cell(46);
            $this->MultiCell(100,6,$this->desigHistorica,0,'C',false);
            // Line break
            $this->Ln(20);
        }
        if ($this->header == 2 ){
            $this->setFont('Calibri Bold','',12);
            $this->MultiCell(195,6,'CONTINUAÇÃO DO TERMO DE EXAME E RECEBIMENTO DE MATERIAL Nº ______/'.date('Y'),0,'C',false);
            $this->Ln(10);
        }
    }

    function Footer(){
        if ($this->footer == 1 ){
            $this->SetY(-15);
            $this->MultiCell(195,6,'CONTINUAÇÃO DO TERMO DE EXAME E RECEBIMETO DE MATERIAL Nº ______/'.date('Y'),0,'C',false);
        }
    }
}
//variaveis do formulario
$nomeacao = $_POST["inputNomeacao"];
$nomePresidente = $_POST['inputNome']." - ".$_POST['inputNomePosto'];
$nomeMembro1 = $_POST['inputNome2']." - ".$_POST['inputNomePosto2'];
$nomeMembro2 = $_POST['inputNome3']." - ".$_POST['inputNomePosto3'];

$dataNomeacao = $_POST['inputDataNomeacao'];

$qtdMaterial = $_POST['qtdMaterial'];
$descricao = $_POST['inputDescricao1'];
$fornecedor = $_POST['inputFornecedor'];
$cnpj = $_POST['inputCNPJ'];
$contrato = $_POST['inputContrato'];
$nrDoc = $_POST['inputNrDoc'];
$dataDoc = $_POST['inputDataFornecimento'];
$flagAcompanhamento = $_POST['flagAcompanhamento'];
$textEstadoGeral = $_POST['textEstadoGeral'];
$textCondicoes = $_POST['textCondicoes'];
$inputNE = $_POST['inputNE'];

$selectFavoravel = $_POST['selectFavoravel'];


//novo objeto do tipo PDF
$pdf = new PDF();
//inicia footer e header
$pdf->nomeOM = $nomeOM;
$pdf->desigHistorica = $desigHistorica;
$pdf->cidade = $ciadade;

$pdf->header = 1;
$pdf->footer = 0;
//configurar fontes
$pdf->AddFont('Calibri','','calibri.php');
$pdf->AddFont('Calibri Bold','','calibrib.php');
//capa
$pdf->AddPage();
//muda o header para uma possivel quebra de página
$pdf->header = 2;
$pdf->setFont('Calibri',"",12);

$ano = date('Y');
$pdf->setFont('Calibri Bold',"",12);$pdf->Text(50,65,"TERMO DE EXAME E RECEBIMENTO DO MATERIAL Nº:      /".date('Y'));
$pdf->Text(21,80,"1. NOMEAÇÃO DA COMISSÃO: BI Nr ".$nomeacao.", de ".$dataNomeacao);
$pdf->Ln(10);



//IDENTIFICAÇÃO
$pdf->setX(20);$pdf->MultiCell(150,5,"2. IDENTIFICAÇÃO DO MATERIAL",0,'J',false);
$pdf->Ln(5);
if ($qtdMaterial == 1 && $flagAcompanhamento == 'ok') {
    $i = 1;
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputDescricao'.$i],0,'J',false);
    $pdf->Ln(5);
    $pdf->setFont('Calibri Bold',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Acompanha o material os seguintes itens',0,'J',false);
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputAcompanhamento1'],0,'J',false);

} elseif ($qtdMaterial == 1) {
    $i = 1;
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputDescricao'.$i],0,'J',false);

} else if ($qtdMaterial > 1 && $flagAcompanhamento == 'ok') {
    for ($i=1; $i <= $qtdMaterial; $i++) { 
        $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputDescricao'.$i],0,'J',false);
        $pdf->Ln(5);
        $pdf->setFont('Calibri Bold',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Acompanha o material os seguintes itens',0,'J',false);
        $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputAcompanhamento'.$i],0,'J',false);
    }
} else if ($qtdMaterial > 1 && $flagAcompanhamento == 'ok') {
    for ($i=1; $i <= $qtdMaterial; $i++) { 
        $pdf->setFont('Calibri Bold',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Material '.$i,0,'J',false);
        $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputDescricao'.$i],0,'J',false);
        $pdf->Ln(5);
        $pdf->setFont('Calibri Bold',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Acompanha o material os seguintes itens',0,'J',false);
        $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputAcompanhamento'.$i],0,'J',false);
    }

} else if ($qtdMaterial > 1) {
    for ($i=1; $i <= $qtdMaterial; $i++) { 
        $pdf->setFont('Calibri Bold',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Material '.$i,0,'J',false);
        $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['inputDescricao'.$i],0,'J',false);
        $pdf->Ln(5);
    }
}
$pdf->Ln(10);



$pdf->setFont('Calibri Bold',"",12);$pdf->setX(20);$pdf->MultiCell(150,5,"3. PROCEDÊNCIA",0,'J',false);
$pdf->Ln(5);

if ($cnpj =='') {
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Empresa ou OM: '.$fornecedor.'. CNPJ: Não informado;',0,'J',false);
} else if  ($cnpj !=''){
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Empresa ou OM: '.$fornecedor.'. CNPJ: '.$cnpj.';',0,'J',false);
}


if ($contrato == '') {
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Contrato: Não possui;',0,'J',false);
} else if ($contrato != '') {
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Contrato: '.$contrato.';',0,'J',false);
}
$pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Nota fiscal: '.$nrDoc.';',0,'J',false);
$pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Data do documento: '.$dataDoc.'.',0,'J',false);
$pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Nota de empenho: '.$inputNE.'.',0,'J',false);
$pdf->Ln(10);



//ALTERAÇÕES
$pdf->setFont('Calibri Bold',"",12);$pdf->setX(20);$pdf->MultiCell(150,5,'4. ALTERAÇÕES',0,'J',false);

$pdf->setFont('Calibri',"",12);$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'a. Estado de conservação: '.$textEstadoGeral,0,'J',false);
$pdf->setFont('Calibri',"",12);$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'b. Condições de funcionamento: '.$textCondicoes,0,'J',false);




//CONCLUSÃ0
$pdf->setFont('Calibri Bold',"",12);$pdf->Ln(5);$pdf->setX(20);$pdf->MultiCell(150,5,'5. OBSERVAÇÕES',0,'J',false);

if ($selectFavoravel === 'sim'){
   
    $pdf->setFont('Calibri',"",12);$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'Esta comissão é favorável quanto ao recebimento do material.',0,'J',false);
} else {

    $pdf->setFont('Calibri',"",12);$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'Esta comissão não é favorável quanto ao recebimento do material, pois as possiveis avarias e mal-funcionamento podem comprometer o uso e ou manipulação.',0,'J',false);
}


$data = strftime('%A, %d de %B de %Y', strtotime('today'));
$pdf->Ln(20);$pdf->setX(0);$pdf->MultiCell(220,5,'Quartel em '.$this->cidade.', '.utf8_encode($data).'.',0,'C',false);
$pdf->Ln(20);$pdf->setX(0);$pdf->MultiCell(220,5,$nomePresidente,0,'C',false);
$pdf->Ln(1);$pdf->setX(0);$pdf->MultiCell(220,5,'Presidente',0,'C',false);
$pdf->Ln(20);$pdf->setX(0);$pdf->MultiCell(220,5,$nomeMembro1,0,'C',false);
$pdf->Ln(1);$pdf->setX(0);$pdf->MultiCell(220,5,'Membro',0,'C',false);
$pdf->Ln(20);$pdf->setX(0);$pdf->MultiCell(220,5,$nomeMembro2,0,'C',false);
$pdf->Ln(1);$pdf->setX(0);$pdf->MultiCell(220,5,'Membro',0,'C',false);


$pdf->SetTitle('Imprimir TEAM');
$pdf->Output();
?>

