<?php

namespace portalium\data;

use Yii;

class ActiveDataProvider extends \yii\data\ActiveDataProvider
{
    public function init()
    {
        parent::init();
    }

    protected function prepareModels()
    {
        $pageParam = 'per-page';
        if (!isset(Yii::$app->request->queryParams[$pageParam])) {
            $pageParam = 'dp-1-per-page';
        }
        if(!Yii::$app->request->get('per-page') && isset($this->pagination->pageSize)  && $this->pagination != false) {
            $sessionPageSize = Yii::$app->session->get('theme::page_size');
            $this->pagination->pageSize = !$sessionPageSize ? Yii::$app->setting->getValue('theme::page_size') : $sessionPageSize;
            Yii::$app->session->set('theme::page_size', $this->pagination->pageSize);
        }
        if ($this->pagination != false && $this->pagination->getPageSize() && isset(Yii::$app->request->queryParams[$pageParam])) {
            $sessionPageSize = Yii::$app->session->get('theme::page_size');
            if ($sessionPageSize == null) {
                $sessionPageSize = Yii::$app->setting->getValue('theme::page_size');
            }
            $this->pagination->pageSize = isset(Yii::$app->request->queryParams[$pageParam]) ? Yii::$app->request->queryParams[$pageParam] : $sessionPageSize;
            Yii::$app->session->set('theme::page_size', $this->pagination->pageSize);
        }
//         Yii::warning('theme::page_size: ' . $this->pagination->pageSize);
//        Yii::$app->session->set('theme::page_size', $this->pagination->pageSize);
        return parent::prepareModels();
    }
}
