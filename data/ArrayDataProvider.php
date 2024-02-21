<?php
namespace portalium\data;

use Yii;

class ArrayDataProvider extends \yii\data\ArrayDataProvider
{
    public function init()
    {
        parent::init();
    }

    protected function prepareModels()
    {
        if(!Yii::$app->request->get('per-page') && isset($this->getPagination()->pageSize)  && $this->getPagination() != false && $this->getPagination()->pageSize == 20) {
            $sessionPageSize = Yii::$app->session->get('theme::page_size');
            $this->getPagination()->pageSize = !$sessionPageSize ? Yii::$app->setting->getValue('theme::page_size') : $sessionPageSize;
        }
        if ($this->getPagination() != false && $this->getPagination()->getPageSize() && isset($_GET['per-page'])) {
            $sessionPageSize = Yii::$app->session->get('theme::page_size');
            if ($sessionPageSize == null) {
                $sessionPageSize = Yii::$app->setting->getValue('theme::page_size');
            }
            $this->getPagination()->pageSize = isset(Yii::$app->request->queryParams['per-page']) ? Yii::$app->request->queryParams['per-page'] : $sessionPageSize;
            Yii::$app->session->set('theme::page_size', $this->getPagination()->pageSize);
        }
//        Yii::$app->session->set('theme::page_size', $this->pagination->pageSize);
        return parent::prepareModels();
    }
}