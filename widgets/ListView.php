<?php

namespace portalium\widgets;

use diginova\pagesizer\LinkPageSizer;
use yii\helpers\ArrayHelper;

class ListView extends \yii\widgets\ListView
{
    public $pageSizer = [];
    public function init()
    {
        parent::init();
    }
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
     * @return string|bool the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case "{pagesizer}":
                return $this->renderPagesizer();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * Renders the page sizer.
     * @return string the rendering result
     */
    public function renderPagesizer()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPageSizer */
        $pageSizer = $this->pageSizer;
        $class = ArrayHelper::remove($pageSizer, 'class', LinkPageSizer::className());
        $pageSizer['pagination'] = $pagination;
        $pageSizer['view'] = $this->getView();

        return $class::widget($pageSizer);
    }
}
