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
            case '{summary}':
                break;
                // return $this->renderSummary();
            case '{items}':
                return $this->renderItems();
            case '{pager}':
                return "<div class='panel-footer d-flex justify-content-between' style='margin-right:-6px;margin-left:-6px;'>" . $this->renderSummary() . $this->renderPager() . "</div>";
            case '{sorter}':
                return $this->renderSorter();
            default:
                return false;
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



    
}
