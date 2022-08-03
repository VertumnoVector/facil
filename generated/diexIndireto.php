<?php
require('../res/fpdf/fpdf.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//VARIAVEIS DE FORMULARIO
$qtdMaterial =$_POST['qtdMaterial'];
$detentor =$_POST['inputDetentor'].' - '.$_POST['inputDetentorPG'];
$diex ='DIEx de descarga Nr '.$_POST['inputNup'];
$secao = $_POST['inputSecao'];


class PDF extends FPDF{
    function Header(){
        $data = strftime('%A, %d de %B de %Y', strtotime('today'));
        if ($this->header == 1 ) {
            // Logo
            $this->setFont('Calibri Bold','',12);
            $width_cell=array(30,160,190);

            $this->Cell($width_cell[0],25,$this->om,1,0,'C'); // First header column 
            $this->MultiCell($width_cell[1],10,'DIEx DE DESCARGA DE MATERIAL PERMANENTE ','LRT',0); // Second header column
            $this->setFont('Calibri',"",12);$this->SetX(40);$this->MultiCell($width_cell[1],5,utf8_encode($data).'.
'.$this->diex.' - '.$this->secao.'.
Ao Sr Fisc Adm','BLR',0); 
            $this->MultiCell($width_cell[2],5,'Solicito que o material permanente abaixo relacionado seja examinado para descarga, conforme  §2º, art. 76 do EB10-R-01.003 (RAE).','BLR',0);
           
            $this->Ln(20);
        }
    }

    function Footer(){


        //SUPRIMIDO
        if ($this->footer == 2 ){
            $this->SetY($this->fim_texto);
            $width_cell=array(95,95);

            $this->setFont('Calibri',"",12);$this->MultiCell($width_cell[0],5,'Do Fisc Adm
Ao Sr Dirigente Máximo
Parecer nº______/Fisc Adm
Sou de parecer que seja descarregado o material constante no presente DIEx, de acordo com o Art. 79 do EB10-R-01.003 (RAE).  
Quartel em Cuiabá-MT, ____ de ________de '.date('Y').'

__________________________________________
           '.$this->fiscal.'
                                        Fisc adm
             ',1,0);
            $this->setFont('Calibri',"",12);$this->SetXY(105,$this->fim_texto);$this->MultiCell($width_cell[0],5,'DESPACHO DO DIRIGENTE MÁXIMO
DESCARGA DE MATERIAL - ORDEM       
1.  Concordo com o parecer do Fiscal Administrativo.
2.  Nomeie-se uma CEAM para examinar o material constante do presente DIEx, de acordo com o item 3 do Art. 79 do EB10-R-01.003 (RAE).      
Quartel em Cuiabá-MT, ____de_______de '.date('Y').'.

  __________________________________________
'.$this->cmt.'
                                Cmt do '.$this->om.'
            ',1,0);
        }
    }
}

//NÃO ALTERAR O CÓDIGO DAQUI PARA BAIXO
//NÃO É BIZU MEXER NAS FORMATAÇÕES

//novo objeto do tipo PDF
$pdf = new PDF();
$pdf->om = $om;
$pdf->cmt = $cmt;
$pdf->fiscal = $fiscal;
$pdf->secao = $secao;
$pdf->diex = $diex;
$pdf->header = 1;


//configurar fontes
$pdf->AddFont('Calibri','','calibri.php');
$pdf->AddFont('Calibri Bold','','calibrib.php');
//capa
$pdf->AddPage();
$pdf->setFont('Calibri',"",12);

    //MONTAR CABEÇALHO
    $x = $pdf->GetX();
    $y = $pdf->GetY()-18;

    $pdf->setY($y);
    $pdf->MultiCell(20, 10, 'Ficha', 1, 1);

    $pdf->SetXY($x + 20, $y);
    $pdf->MultiCell(35, 10, 'Patr Nr', 1);

    $pdf->SetXY($x + 55, $y);
    $pdf->MultiCell(80, 10, 'Descrição', 1);

    $pdf->SetXY($x + 135, $y);
    
    $pdf->setFont('Calibri',"",10);
    $pdf->MultiCell(30, 5, 'Inclusão em carga', 1);
    $pdf->SetXY($x + 135, $y+5);
    $pdf->MultiCell(10, 5, 'dia', 1);
    $pdf->SetXY($x + 145, $y+5);
    $pdf->MultiCell(10, 5, 'mes', 1);
    $pdf->SetXY($x + 155, $y+5);
    $pdf->MultiCell(10, 5, 'ano', 1);

    $pdf->setFont('Calibri',"",12);
    $pdf->SetXY($x + 165, $y);
    $pdf->MultiCell(25, 10, 'Vlr. Un. R$', 1);

    
 
    //LAÇO DE ITENS - DECLARAÇÃO
    for ($i=0; $i < $qtdMaterial; $i++) {

        $intervaloCheck = $_POST['intervaloCheck'.$i+1];
        $patrimonioIncial = $_POST['inputPatrimonioInicial'.$i+1];
        $patrimonioFinal = $_POST['inputPatrimonioFinal'.$i+1];

        $ficha = $_POST['inputFicha'.$i+1];
        $patrimonio = $_POST['inputPatrimonio'.$i+1];
        $descricao = $_POST['inputDescricao'.$i+1];
        $valor = $_POST['inputInclusaoValor'.$i+1];
        $dataEntrada = $_POST['inputInclusaoData'.$i+1];

        //CONFIGURA OS ESPAÇAMENTOS ENTRE LINHAS DENTRO DAS NECESSIDADES DE BREAKLINE
        switch (strlen($descricao)) {

            case strlen($descricao) > 34 && strlen($descricao) <= 67:
                $line_height = 5;
                $line_break = "\n";
                break;
    
            case strlen($descricao) >= 68 && strlen($descricao) <= 101:
                $line_height = 5;
                $line_break = "\n\n";
                break;
    
            case strlen($descricao) >= 102 && strlen($descricao) <= 135:
                $line_height = 5;
                $line_break = "\n\n\n";
                break;
    
            case strlen($descricao) >= 136 && strlen($descricao) <= 169:
                $line_height = 5;
                $line_break = "\n\n\n\n";
                break;
    
            case strlen($descricao) >= 170 && strlen($descricao) <= 203:
                $line_height = 5;
                $line_break = "\n\n\n\n\n";
                break;
    
            case strlen($descricao) >= 204 && strlen($descricao) <= 237:
                $line_height = 5;
                $line_break = "\n\n\n\n\n\n";
                break;
    
            case strlen($descricao) >= 238 && strlen($descricao) <= 271:
                $line_height = 5;
                $line_break = "\n\n\n\n\n\n\n";
                break;
    
            case strlen($descricao) >= 272 && strlen($descricao) <= 305:
                $line_height = 5;
                $line_break = "\n\n\n\n\n\n\n\n";
                break;
    
            case strlen($descricao) >= 306 && strlen($descricao) <= 339:
                $line_height = 5;
                $line_break = "\n\n\n\n\n\n\n\n\n";
                break;
    
            case strlen($descricao) >= 340 && strlen($descricao) <= 373:
                $line_height = 5;
                $line_break = "\n\n\n\n\n\n\n\n\n\n";
                break;
    
            case strlen($descricao) >= 374 && strlen($descricao) <= 408:
                $line_height = 5;
                $line_break = "\n\n\n\n\n\n\n\n\n\n";
                break;
            
            default:
            $line_height = 5;
            $line_break = "";
                break;
        }
    


        //ESCRITAS
        $nb = $pdf->PageNo();
        $pdf->Ln(0);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        
        $pdf->MultiCell(20, $line_height, $ficha.$line_break.' ', 1, 1);
    
        $pdf->SetXY($x + 20, $y);
        if ($intervaloCheck == 1) {
            $pdf->setFont('Calibri',"",11);$pdf->MultiCell(35, $line_height, '1004101000'.$patrimonioIncial.'... 1004101000'.$patrimonioFinal.$line_break, 1,'C');
        } else {
            $pdf->setFont('Calibri',"",11);$pdf->MultiCell(35, $line_height, '1004101000'.$patrimonio.$line_break.' ', 1,'C');
        }
        
        $pdf->setFont('Calibri',"",12);
    
        $pdf->SetXY($x + 55, $y);
        $pdf->MultiCell(80, 5,$descricao, 1);
    
        $pdf->setFont('Calibri',"",11);
        $pdf->SetXY($x + 135, $y);
        $pdf->MultiCell(10, $line_height, substr($dataEntrada,0,2).$line_break.' ', 1);
        $pdf->SetXY($x + 145, $y);
        $pdf->MultiCell(10, $line_height, substr($dataEntrada,3,2).$line_break.' ', 1);
        $pdf->SetXY($x + 155, $y);
        $pdf->MultiCell(10, $line_height, substr($dataEntrada,6,4).$line_break.' ', 1);
       
        $pdf->SetXY($x + 165, $y);
        $pdf->MultiCell(25, $line_height, $valor.$line_break.' ', 1);


        $pdf->footer = 0;
        $y = $pdf->GetY();
        if ($y>230) {
            $pdf->addPage();
            $pdf->SetY(45);
        }

       
    }
    $line_break1 = "\n\n";
    $y = $pdf->GetY();
    $pdf->MultiCell(190,5, $line_break1.$detentor, 'LRT','C');
    $pdf->MultiCell(190,5,'Detentor do material', 'LRB','C');
    $pdf->fim_texto = $y+20;
    $pdf->footer =2;

$pdf->SetTitle('DIEx de descarga direta');
$pdf->Output();
?>

