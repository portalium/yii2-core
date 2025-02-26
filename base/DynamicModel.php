<?php

namespace portalium\base;

class DynamicModel extends \yii\base\DynamicModel
{
    public function addAttribute($name, $value = null)
    {
        if (!$this->hasAttribute($name)) {
            $this->defineAttribute($name, $value);
        }
    }
    
    public function removeAttribute($name)
    {
        if ($this->hasAttribute($name)) {
            $this->undefineAttribute($name); 
        }
    }
    
}
