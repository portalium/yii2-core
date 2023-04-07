<?php
namespace portalium\grid;



class GridView extends \yii\grid\GridView
{
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

        $this->layout = "{items}<div class='row'><div class='col-md-6'>{summary}</div><div class='col-md-6'>{pager}</div></div>";
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



    
}
