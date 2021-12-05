<?php

class Felveteli_Controller
{
    public $baseName = 'felveteli';

    public function main(array $vars)
    {

        $model = new Felveteli_Model();
        $model->read_from_db();
        if (isset($_POST['operation']) && $_POST['operation'] == 'get_kepzes')
        {
            $model->get_kepzes_json();
        }
        elseif (isset($_POST['operation']) && $_POST['operation'] == 'get_nem')
        {
            $model->get_nem_json();
        }
        elseif (isset($_POST['operation']) && $_POST['operation'] == 'get_sorrend')
        {
            $model->get_sorrend_json();
        }
        elseif (isset($_POST['operation']) && !empty($_POST['kepzes']) && !empty($_POST['nem']) && !empty($_POST['sorrend'])  && $_POST['operation'] == 'get_felveteli_statisztika')
        {
            $model->get_felveteli_statisztika($_POST['kepzes'], $_POST['nem'], $_POST["sorrend"]);
        }
        elseif (isset($_POST['operation']) && $_POST['operation'] == 'get_felveteli_statisztika')
        {
            $model->get_graph_data_json();
        }
        else
        {
            $view = new View_Loader($this->baseName . "_main");
        }
    }
}
