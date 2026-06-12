<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/fpdf.php';
require_once __DIR__ . '/../models/ProductoRepository.php';

// Creamos una subclase optimizada para manejar la estética profesional de Mass
class PDF_Corporativo extends FPDF 
{
    private function latin(string $t): string
    {
        return mb_convert_encoding($t, 'ISO-8859-1', 'UTF-8');
    }

    // Cabecera de página automática (Se ejecuta en cada AddPage y cambio de hoja)
    public function Header(): void
    {
        // Logotipo o Banner superior estilizado (Verde Institucional)
        $this->SetFillColor(46, 125, 50); // Verde Mass / Caja
        $this->Rect(0, 0, 210, 35, 'F');
        
        // Texto del Banner (Cambiamos el punto conflictivo por un guion limpio)
        $this->SetFont('Arial', 'B', 22);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 10, $this->latin('MASS - SISTEMA DE CAJA'), 0, 1, 'L');
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $this->latin('Reporte Oficial de Inventario y Catálogo'), 0, 1, 'L');
        
        // Bloque de metadatos del documento (Lado derecho de la cabecera)
        $this->SetXY(130, 12);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(70, 5, $this->latin('FECHA: ' . date('d/m/Y')), 0, 1, 'R');
        $this->SetX(130);
        $this->Cell(70, 5, $this->latin('ESTABLECIMIENTO: Mass Cayma'), 0, 1, 'R');
        $this->SetX(130);
        $this->Cell(70, 5, $this->latin('DOCUMENTO: Interno / Confidencial'), 0, 1, 'R');
        
        // Espaciado de seguridad después del banner
        $this->Ln(18);
        
        // Cabecera de la tabla (Diseño limpio y moderno)
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(240, 244, 241); // Fondo gris verdoso muy suave
        $this->SetTextColor(33, 33, 33);    // Texto oscuro ejecutivo
        $this->SetDrawColor(200, 200, 200); // Bordes tenues
        
        // CORRECCIÓN: Agregados los métodos $this->latin() para limpiar los títulos con tilde
        $this->Cell(45, 9, $this->latin(' Código de Barras'), 1, 0, 'L', true);
        $this->Cell(75, 9, $this->latin(' Descripción del Producto'), 1, 0, 'L', true);
        $this->Cell(35, 9, $this->latin('Precio Base '), 1, 0, 'R', true);
        $this->Cell(35, 9, $this->latin('Stock Disp. '), 1, 1, 'R', true);
    }

    // Pie de página automático
    public function Footer(): void
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->SetDrawColor(220, 220, 220);
        
        // Línea divisoria superior en el pie de página
        $this->Line(10, $this->GetY() - 2, 200, $this->GetY() - 2);
        
        // Contenido del pie
        $this->Cell(100, 5, $this->latin('Generado por: Administrador Sistema'), 0, 0, 'L');
        $this->Cell(90, 5, $this->latin('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

class ReporteController
{
    private function latin(string $t): string
    {
        return mb_convert_encoding($t, 'ISO-8859-1', 'UTF-8');
    }

    public function catalogoPdf(): void
    {
        $repo      = new ProductoRepository();
        $productos = $repo->obtenerTodos();

        // Instanciamos nuestra clase personalizada
        $pdf = new PDF_Corporativo('P', 'mm', 'A4');
        $pdf->AliasNbPages(); // Necesario para calcular el total dinámico de páginas ({nb})
        $pdf->SetAutoPageBreak(true, 20); // Margen de seguridad inferior para el salto de página
        $pdf->AddPage();

        // ---- Impresión de Filas del Catálogo ----
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(50, 50, 50);     // Texto gris corporativo para las filas
        $pdf->SetDrawColor(230, 230, 230);  // Bordes internos aún más suaves
        
        $contador = 0;
        
        foreach ($productos as $p) {
            // Efecto cebra opcional: Alterna un fondo blanco y uno gris claro para facilitar la lectura
            $fondo = ($contador % 2 === 0) ? false : true;
            $pdf->SetFillColor(250, 250, 250);
            
            // Renderizado de las celdas de datos
            $pdf->Cell(45, 8, '  ' . $p->getCodigo(), 'B', 0, 'L', $fondo);
            $pdf->Cell(75, 8, '  ' . $this->latin($p->getNombre()), 'B', 0, 'L', $fondo);
            $pdf->Cell(35, 8, 'S/ ' . number_format($p->getPrecio(), 2) . ' ', 'B', 0, 'R', $fondo);
            
            // Si el stock está muy bajo, podemos resaltarlo sutilmente si lo deseas
            $pdf->Cell(35, 8, $p->getStock() . '', 'B', 1, 'R', $fondo);
            $contador++;
        }

        // ---- Salida limpia al navegador ----
        $pdf->Output('I', 'catalogo_mass_profesional.pdf');
    }
}