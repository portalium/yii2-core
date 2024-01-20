<?php
namespace portalium\grid;

use Yii;

class ActionColumn extends \yii\grid\ActionColumn
{
    public function init()
    {
        $this->headerOptions = ['class' => 'col-md-2'];
        parent::init();
    }

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', [
            'class' => 'btn btn-info btn-xs',
            'style' => 'padding: 2px 9px 2px 9px; display: inline-block;'
        ]);
        $this->initDefaultButton('update', 'pencil', [
            'class' => 'btn btn-primary btn-xs',
            'style' => 'padding: 2px 9px 2px 9px; display: inline-block;'
        ]);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn btn-danger btn-xs',
            'style' => 'padding: 2px 9px 2px 9px; display: inline-block;'
        ]);

        parent::initDefaultButtons();
    }
}