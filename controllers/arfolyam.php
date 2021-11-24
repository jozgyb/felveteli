<?php

class Arfolyam_Controller
{
    public $baseName = 'arfolyam';

    public function main(array $vars)
    {

        $arfolyamModel = new Arfolyam_Model;
        if(!empty($_POST['day']) && !empty($_POST['currencyDataList']))
        {
            $napiArfolyam = $arfolyamModel->getDailyExchangeRates($_POST['day'], $_POST['currencyDataList']);
        }
        if(!empty($_POST['month']) && !empty($_POST['monthlyCurrencyNames']))
        {
            $startDate = new DateTime($_POST['month'] . '-1');
            $startDateString = $startDate->format('Y-m-d');
            $endDateString = $startDate->format('Y-m-t');
            $haviArfolyam = $arfolyamModel->getMonthlyExchangeRates($startDateString, $endDateString, $_POST['monthlyCurrencyNames']);
        }

        $view = new View_Loader($this->baseName . "_main");

        if(isset($napiArfolyam))
        {
            $view->assign('napiArfolyam', $napiArfolyam);
            $currencies = explode(',', $_POST['currencyDataList']);
            $view->assign('currencyDataList', $currencies);
            $view->assign('day', $_POST['day']);
        }
        if(!empty($haviArfolyam))
        {
            $rendezettArfolyam = array_reverse($haviArfolyam['Day']);
            $view->assign('haviArfolyam', $rendezettArfolyam);
            $view->assign('monthlyCurrencyNames', $_POST['monthlyCurrencyNames']);
        }

        $availableCurrencies = $arfolyamModel->getCurrencies()['Currencies']->Curr;
        // HUF törlése
        unset($availableCurrencies[0]);
        $view->assign('currencies', $availableCurrencies);

        $limits = $arfolyamModel->getDateLimits();
        $view->assign('FirstDate', $limits['FirstDate']);
        $view->assign('LastDate', $limits['LastDate']);
    }
}
