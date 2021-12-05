<?php

class Felveteli_Controller
{
    public $baseName = 'felveteli';

    public function main(array $vars)
    {

        $model = new Felveteli_Model();
        $model->read_from_db();
        if (!empty($_POST['operation'])) {
            if ($_POST['operation'] == 'get_kepzes') {
                $model->get_kepzes_json();
            } elseif ($_POST['operation'] == 'get_nem') {
                $model->get_nem_json();
            } elseif ($_POST['operation'] == 'get_sorrend') {
                $model->get_sorrend_json();
            } elseif ($_POST['operation'] == 'get_graph_data_ajax') {
                $model->get_graph_data_json();
            } elseif ($this->is_form_filled() && $_POST['operation'] == 'print_pdf') {
                $this->print_pdf($model->get_felveteli_statisztika($_POST['kepzes'], $_POST['nem'], $_POST["sorrend"]));
            } elseif ($this->is_form_filled() && $_POST['operation'] == 'get_felveteli_statisztika_json') {
                $model->get_felveteli_statisztika_json($_POST['kepzes'], $_POST['nem'], $_POST["sorrend"]);
            }
        } else {
            $view = new View_Loader($this->baseName . "_main");
        }
    }

    private function is_form_filled()
    {
        return !empty($_POST['kepzes']) && !empty($_POST['nem']) && !empty($_POST['sorrend']);
    }


    private function print_pdf($statisztika)
    {
        // Include the main TCPDF library
        require_once('tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Web-programozás II');
        $pdf->SetTitle('FELHASZNÁLÓK');
        $pdf->SetSubject('Web-programozás II - 3. Labor - TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, Web-programozás II, Labor3');

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        $pdf->AddPage();
        $html = "
        <html>
            <head></head>
            <body>
                {$statisztika}
            </body>
        </html>
        ";

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('statisztika.pdf', 'I');
    }
}
