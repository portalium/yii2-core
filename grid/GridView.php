<?php
namespace portalium\grid;

use diginova\pagesizer\LinkPageSizer;
use yii\helpers\ArrayHelper;

class GridView extends \yii\grid\GridView
{
    public $pageSizer = [];
    
    public $paginationParams;
    public function init()
    {
        parent::init();
        $this->pager = [
            'class' => 'yii\bootstrap5\LinkPager',
            'options' => [
                'class' => 'pagination justify-content-end',
            ],
        ];
        // $this->layout = "{items}<div class='panel-footer d-flex justify-content-between' style='margin-right:-10px;margin-left:-10px;'>{summary}{pager}</div>";
        // $this->layout = "{items}<div class='panel-footer d-flex justify-content-between'>{summary}{pager}</div>";
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
    public function renderPager()
    {
        $pager = parent::renderPager();

        if ($this->paginationParams && isset($this->paginationParams['urlParams'])) {
            $urlParams = $this->paginationParams['urlParams'];
            $anchorParams = [];

            foreach ((array) $urlParams as $key => $value) {
                if ($key === '#') {
                    $anchorParams[] = $value;
                } else {
                    $urlSeparator = (strpos($pager, '?') !== false) ? '&' : '?';
                    $pager = preg_replace('/href="([^"]*)"/', 'href="$1' . $urlSeparator . $key . '=' . $value . '"', $pager);
                }
            }

            if (!empty($anchorParams)) {
                $anchorParams = '#' . implode(',', $anchorParams);
                $pager = preg_replace('/href="([^"]*)"/', 'href="$1' . $anchorParams . '"', $pager);
            }
        }

        return $pager;
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
