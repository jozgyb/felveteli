<?php

class Arlista_Controller
{
    public $baseName = 'arlista';
    public function main(array $vars)
    {
        $arlistaModel = new Arlista_Model;
        $mentes = (isset($_POST['mentes'])) ? $_POST['mentes'] : '';
        $sutik = $arlistaModel->getSutik($mentes);

        $view = new View_Loader($this->baseName . "_main");
        $view->assign('sutik', $sutik->sutik);
        $view->assign('mentes', $mentes);
    }
}
