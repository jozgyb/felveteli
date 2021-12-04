<?php

class Felveteli_Controller
{
    public $baseName = 'felveteli';

    public function main(array $vars)
    {

        $model = new Felveteli_Model();
        $model->read_from_db();
        if (isset($_POST['operation']) && $_POST['operation'] == 'get_kepzes')
            $model->get_kepzes_json();
        elseif (isset($_POST['operation']) && $_POST['operation'] == 'get_nem')
        {
            $model->get_nem_json();
        }
        elseif (isset($_POST['operation']) && $_POST['operation'] == 'get_sorrend')
        {
            $model->get_sorrend_json();
        }
        else
            $view = new View_Loader($this->baseName . "_main");
    }
}
