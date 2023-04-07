<?php
namespace portalium\widgets;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public function init()
    {
        parent::init();
        $this->tag = "ol";
        $this->itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";
        $this->activeItemTemplate = "<li class=\"breadcrumb-item active\" aria-current=\"page\">{link}</li>\n";
    }
}