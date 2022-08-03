<?php
require('../res/fpdf/fpdf.php');
require('names.php');
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
            $this->MultiCell(195,6,'CONTINUAÇÃO DO TERMO DE EXAME E AVERIGUAÇÃO DE MATERIAL Nº ______/'.date('Y'),0,'C',false);
            $this->Ln(10);
        }
    }

    function Footer(){
        if ($this->footer == 1 ){
            $this->SetY(-15);
            $this->MultiCell(195,6,'CONTINUAÇÃO DO TERMO DE EXAME E AVERIGUAÇÃO DE MATERIAL Nº ______/'.date('Y'),0,'C',false);
        }
    }
}
//variaveis do formulario
$nomeacao = $_POST["inputNomeacao"];
$nomePresidente = $_POST['inputNome']." - ".$_POST['inputNomePosto'];
$nomeMembro1 = $_POST['inputNome2']." - ".$_POST['inputNomePosto2'];
$nomeMembro2 = $_POST['inputNome3']." - ".$_POST['inputNomePosto3'];

$dataNomeacao = $_POST['inputDataNomeacao'];

$dependencia = $_POST['selectDependencia1'];
$patrimonio = $_POST['inputPatrimonio1'];
$descricao = $_POST['inputDescricao1'];
$valorEntrada = $_POST['inputInclusaoValor1'];
$dataInclusao = $_POST['inputInclusaoData1'];

$estadoGeral = $_POST['inputEstadoGeral'];
$custoManutencao = $_POST['inputCusto'];
$selectDescarga = $_POST['selectDescarga'];
$qtdMotivo = $_POST['qtdMotivo'];
$qtdMaterial = $_POST['qtdMaterial'];

$aux = str_replace('.','',$_POST['inputPrecoNovo']);
$precoNovo = str_replace(',','.',$aux);

$aux2 = str_replace('.','',$_POST['inputPrecoUsado']);
$precoUsado = str_replace(',','.',$aux2);


//novo objeto do tipo PDF
$pdf = new PDF();
$pdf->nomeOM = $nomeOM;
$pdf->desigHistorica = $desigHistorica;
$pdf->cidade = $ciadade;
//inicia footer e header
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
$pdf->setFont('Calibri Bold',"",12);$pdf->Text(50,65,"TERMO DE EXAME E AVERIGUAÇÃO DO MATERIAL Nº:      /".date('Y'));
$pdf->Text(20,80,"1. NOMEAÇÃO DA COMISSÃO: BI Nr ".$nomeacao.", de ".$dataNomeacao);
$pdf->setXY(19,90);$pdf->MultiCell(150,5,'2. MATERIAL PERTENCENTE À CARGA DA: '.$dependencia.'.',0,'J',false);


//EXAME DO MATERIAL
$pdf->Text(20,110,"3. EXAME DO MATERIAL");
$pdf->setXY(30,115);$pdf->MultiCell(150,5,"a. Identificação do material");

if ($qtdMaterial == 1){
    $pdf->setFont('Calibri',"",12);$pdf->setXY(30,130);$pdf->MultiCell(150,5,'Patrimonio Nr: 1004101000'.$patrimonio.' Data de inclusão em carga: '.$dataInclusao.' DESCRIÇÃO: '.$descricao.'Valor de inclusão em carga em R$: '.$valorEntrada.'.',0,'J',false);
    $pdf->setFont('Calibri Bold',"",12);$pdf->setXY(30,155);$pdf->MultiCell(150,5,"b. Estado geral");
    $pdf->setFont('Calibri',"",12);$pdf->setXY(30,165);$pdf->MultiCell(150,5,$estadoGeral,0,'J',false);
    $pdf->Ln(10);
} else if ($qtdMaterial > 1) {
    for ($i=1; $i <= $qtdMaterial; $i++) { 
        $pdf->Ln(10);$pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,'Patrimonio Nr: 1004101000'.$_POST['inputPatrimonio'.$i].' Data de inclusão em carga: '.$_POST['inputInclusaoValor'.$i].' DESCRIÇÃO: '.$_POST['inputDescricao'.$i].'Valor de inclusão em carga em R$: '.$_POST['inputInclusaoValor'.$i].'.',0,'J',false);
        
    }
    $pdf->Ln(10);  
    $pdf->setFont('Calibri Bold',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,"b. Estado geral");
    $pdf->setFont('Calibri',"",12);$pdf->setX(30);$pdf->MultiCell(150,5,$estadoGeral,0,'J',false);
    $pdf->Ln(10);
}




//CUSTOS DE MANUTENCAO
$pdf->setFont('Calibri Bold',"",12);$pdf->setX(20);$pdf->MultiCell(150,5,'4. CUSTOS DE MANUTENÇÃO',0,'J',false);

if ($selectDescarga == 'sim'){
    $pdf->setFont('Calibri',"",12);$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'Os seguintes serviços com aplicação de peças são necessários: ',0,'J',false);
} else {
    $pdf->setFont('Calibri',"",12);$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'Não recomenda-se a descarga, pois os seguintes serviços são possiveis de ser executados:',0,'J',false);
}
//por quantitativo vindo do formulario
for($i=1;$i<=$qtdMotivo;$i++){
    $pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,$_POST['motivo'.$i],0,'J',false);
}
$pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'O valor total estimado da manutenção incluindo o serviço e peças é de R$: '.$custoManutencao,0,'J',false);






//CONCLUSÃ0
$pdf->setFont('Calibri Bold',"",12);$pdf->Ln(10);$pdf->setX(20);$pdf->MultiCell(150,5,'5. CONCLUSÃO',0,'J',false);
if ($selectDescarga == 'sim') {
    $pdf->setFont('Calibri',"",12);
    $pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'O material avaliado ('.$descricao.') deve ser descarregado tendo em vista os seguintes motivos:',0,'J',false);
    $pdf->Ln(5);$pdf->setX(30);$pdf->MultiCell(150,5,'O valor de mercado de um ativo similar a este, usado e em boas condições, é de: R$ '.$_POST['inputPrecoUsado'].';',0,'L',false);

    $count_indisp = 0;

    if($custoManutencao >= $precoNovo ){
        $count_indisp +=1;
        $pdf->Ln(10);$pdf->setX(30);$pdf->MultiCell(150,5,$count_indisp.'. A recuperação é antieconômica, pois o custo da manutenção (peças e serviços) ultrapassa 60% do valor real como material novo;',0,'FJ',false);
    }

    if ($custoManutencao >= $precoUsado*0.6){
        $count_indisp +=1;
        $pdf->Ln(10);$pdf->setX(30);$pdf->MultiCell(150,5,$count_indisp.'. A recuperação é antieconômica, pois o custo da manutenção (peças e serviços) ultrapassa o seu valor real como material usado;',0,'FJ',false);
    }
    $count_indisp +=1;
    $pdf->Ln(10);$pdf->setX(30);$pdf->MultiCell(150,5,$count_indisp.'. O material foi utilizado em condições severas nas diversas obras do 9º BEC, acelerando assim o desgaste de alguns componentes.',0,'FJ',false);
} else {
    $pdf->setFont('Calibri',"",12);
    $pdf->Ln(10);$pdf->setX(30);$pdf->MultiCell(150,5,'O material avaliado ('.$descricao.') não deve ser descarregado tendo em vista os seguintes motivos:',0,'J',false);
    $pdf->Ln(10);$pdf->setX(30);$pdf->MultiCell(150,5,'A recuperação do material é pertinente e possível de ser realizada, açém de não apresentar motivo para indisponibilidade total.',0,'J',false);
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

