<?php

class DomyModel extends CActiveRecord
{
    private $_oldAttributes = array();
	
    public function setOldAttributes($value)
    {
        $this->_oldAttributes = $value;
    }
    public function getOldAttributes()
    {
        return $this->_oldAttributes;
    }

    public function init()
    {
        $this->attachEventHandler("onAfterFind", function ($event)
        {
            $event->sender->OldAttributes = $event->sender->Attributes;
        });
    }
}

?>