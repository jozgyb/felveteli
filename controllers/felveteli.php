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
            } elseif ($_POST['operation'] == 'print_pdf') {
                $this->print_pdf();
            } elseif (!empty($_POST['kepzes']) && !empty($_POST['nem']) && !empty($_POST['sorrend'])  && $_POST['operation'] == 'get_felveteli_statisztika') {
                $model->get_felveteli_statisztika($_POST['kepzes'], $_POST['nem'], $_POST["sorrend"]);
            }
        } else {
            $view = new View_Loader($this->baseName . "_main");
        }
    }

}
