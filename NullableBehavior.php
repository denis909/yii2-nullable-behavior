<?php

namespace denis909\yii;

use yii\db\ActiveRecord;

abstract class NullableBehavior extends \yii\base\Behavior
{

    public $attributes = [];

    public $enableBeforeSave = true;

    public $enableBeforeValidate = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave'
        ];
    }

    protected function _setAttributes()
    {
        foreach($this->attributes as $attribute)
        {
            if (!$this->owner->{$attribute})
            {
                $this->owner->{$attribute} = null;
            }
        }
    }

    public function beforeValidate($event)
    {
        if ($this->enableBeforeValidate)
        {
            $this->_setAttributes();
        }
    }

    public function beforeSave($event)
    {
        if ($this->enableBeforeSave)
        {
            $this->_setAttributes();
        }
    }

}