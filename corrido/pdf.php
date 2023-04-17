<?php
require('funciones/fpdf/fpdf.php');
/* PRIMER PASO
$pdf = new FPDF('P', 'mm', array(100,50)); ////P o L, mm o cm o pt, A4 o A5 o A3 o LETTER
$pdf->AddPage();
$pdf->SetMargins(4,4,0); //margenes
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!'); //SIN BORDE
//$pdf->Cell(40,10,'¡Hola, Mundo!',1); //CON BOIRDE
$pdf->Ln(); //NUEVA HOJA
$pdf->Cell(60,10,'Hecho con FPDF.',0,1,'C');
$pdf->Output();
*/
?>
<?php
$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
$pdf->AddPage(); // Agrega una hoja al documento.
$pdf->SetFont("Arial","",12); //Establece la fuente a utilizar, el formato Negrita y el tamaño

//La siguiente instrucción escribe el siguiente mensaje.

$pdf->Cell(40,10,'¡Hola, Mundo!'); //SIN BORDE

$pdf->Output(); //Envía como salida del documento
/*
class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('images/user.gif',15,16);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Movernos a la derecha
    $this->Cell(80);
    //Título
    $this->Cell(30,10,'Title',0,0,'C');
    //Salto de línea
    $this->Ln(20);
}

//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Imprimiendo hola '.$i,0,1);
$pdf->Output();
*/
?>
<?php
/*
class PDF extends FPDF
{
function Header()
{
    global $title;

    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Calculamos ancho y posición del título.
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    //Colores de los bordes, fondo y texto
    $this->SetDrawColor(0,80,180);
    $this->SetFillColor(230,230,0);
    $this->SetTextColor(220,50,50);
    //Ancho del borde (1 mm)
    $this->SetLineWidth(1);
    //Título
    $this->Cell($w,9,$title,1,1,'C',true);
    //Salto de línea
    $this->Ln(10);
}

function Footer()
{
    //Posición a 1,5 cm del final
    $this->SetY(-15);
    //Arial itálica 8
    $this->SetFont('Arial','I',8);
    //Color del texto en gris
    $this->SetTextColor(128);
    //Número de página
    $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
}

function ChapterTitle($num,$label)
{
    //Arial 12
    $this->SetFont('Arial','',12);
    //Color de fondo
    $this->SetFillColor(200,220,255);
    //Título
    $this->Cell(0,6,"Capítulo $num : $label",0,1,'L',true);
    //Salto de línea
    $this->Ln(4);
}

function ChapterBody($file)
{
    //Leemos el fichero
    $f=fopen($file,'r');
    $txt=fread($f,filesize($file));
    fclose($f);
    //Times 12
    $this->SetFont('Times','',12);
    //Imprimimos el texto justificado
    $this->MultiCell(0,5,$txt);
    //Salto de línea
    $this->Ln();
    //Cita en itálica
    $this->SetFont('','I');
    $this->Cell(0,5,'(fin del extracto)');
}

function PrintChapter($num,$title,$file)
{
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
}
}

$pdf=new PDF();
$title='20000 Leguas de Viaje Submarino';
$pdf->SetTitle($title);
$pdf->SetAuthor('Julio Verne');
$pdf->PrintChapter(1,'UN RIZO DE HUIDA','images/holas.txt');
$pdf->PrintChapter(2,'LOS PROS Y LOS CONTRAS','images/holas.txt');
$pdf->Output();
*/
?>
<?php
/*
class PDF extends FPDF
{
//Columna actual
var $col=0;
//Ordenada de comienzo de la columna
var $y0;

function Header()
{
    //Cabacera
    global $title;

    $this->SetFont('Arial','B',15);
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    $this->SetDrawColor(0,80,180);
    $this->SetFillColor(230,230,0);
    $this->SetTextColor(220,50,50);
    $this->SetLineWidth(1);
    $this->Cell($w,9,$title,1,1,'C',true);
    $this->Ln(10);
    //Guardar ordenada
    $this->y0=$this->GetY();
}

function Footer()
{
    //Pie de página
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
}

function SetCol($col)
{
    //Establecer la posición de una columna dada
    $this->col=$col;
    $x=10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    //Método que acepta o no el salto automático de página
    if($this->col<2)
    {
        //Ir a la siguiente columna
        $this->SetCol($this->col+1);
        //Establecer la ordenada al principio
        $this->SetY($this->y0);
        //Seguir en esta página
        return false;
    }
    else
    {
        //Volver a la primera columna
        $this->SetCol(0);
        //Salto de página
        return true;
    }
}

function ChapterTitle($num,$label)
{
    //Título
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,220,255);
    $this->Cell(0,6,"Capítulo $num : $label",0,1,'L',true);
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
}

function ChapterBody($fichier)
{
    //Abrir fichero de texto
    $f=fopen($fichier,'r');
    $txt=fread($f,filesize($fichier));
    fclose($f);
    //Fuente
    $this->SetFont('Times','',12);
    //Imprimir texto en una columna de 6 cm de ancho
    $this->MultiCell(60,5,$txt);
    $this->Ln();
    //Cita en itálica
    $this->SetFont('','I');
    $this->Cell(0,5,'(fin del extracto)');
    //Volver a la primera columna
    $this->SetCol(0);
}

function PrintChapter($num,$title,$file)
{
    //Añadir capítulo
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
}
}

$pdf=new PDF();
$title='20000 Leguas de Viaje Submarino';
$pdf->SetTitle($title);
$pdf->SetAuthor('Julio Verne');
$pdf->PrintChapter(1,'UN RIZO DE HUIDA','images/holas.txt');
$pdf->PrintChapter(2,'LOS PROS Y LOS CONTRAS','images/web.txt');
$pdf->Output();
*/
?>
<?php
/*
class PDF extends FPDF
{
//Cargar los datos
function LoadData($file)
{
    //Leer las líneas del fichero
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}

//Tabla simple
function BasicTable($header,$data)
{
    //Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

//Una tabla más completa
function ImprovedTable($header,$data)
{
    //Anchuras de las columnas
    $w=array(40,35,40,45);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

//Tabla coloreada
function FancyTable($header,$data)
{
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Cabecera
    $w=array(40,35,40,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF();
//Títulos de las columnas
$header=array('País','Capital','Superficie (km2)','Pobl. (en miles)');
//Carga de datos
$data=$pdf->LoadData('images/web.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
*/
/*
function orden($g)
{
	if ($g == 1)
	{
	$fcanti = 4;
	}
	else
	{
	$fcanti = 5;
	}
	return $fcanti;
}
function ancho($u)
{
	if($u == 1)
	{
	$fcanti = 40;
	}
	else
	{
	$fcanti = 60;
	}
	return $fcanti;
}
class PDF extends FPDF
{
	//Cabecera de p�gina
		function Header()
		{
			global $descm;
			$this->SetFont('Arial','B',12);
			$this->Cell(70); ////POSICION DE LA CABECERA
			$this->Cell(10,5,$descm,0,0,'C');
			$this->Ln(10);
		}
}
$pdf=new FPDF('P','mm', array(100,400)); ////HOJA DEL DOCUMENTO
$pdf->AddPage();
$pdf->SetAutoPageBreak(1,2); ///PASO A OTRA HOJA
$pdf->SetFont('Times','',10);
/*$pdf->Cell(10,4,'Title',0,0);
$pdf->Cell(30,4,'Hola como estas',0,0);
$pdf->Cell(20,4,'Probando',0,0);*/
/*for($i=1;$i<=40;$i++)
$pdf->Cell(4,4,'Imprimiendo hola '.$i,0,1);*/
/*
$pdf->Cell(ancho(1),4,orden(1),0,0);
$pdf->Cell(ancho(2),4,orden(2),1,1);
$pdf->Ln();
$pdf->Cell(ancho(1),4,orden(1),0,0);
$pdf->Cell(ancho(2),4,orden(2),1,1);
$pdf->Output();*/
?>