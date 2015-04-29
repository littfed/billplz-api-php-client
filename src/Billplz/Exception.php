<?php

class Billplz_Exception extends Exception{

    protected $type = NULL;

    function __construct($message, $code = 0, Exception $previous = null)
    {
        if (is_object($message))
        {
            $this->type = $message->error->type;
            $this->message = implode((array)$message->error->message, ', ');
        }
        else
        {
            $this->message = $message;
        }

        parent::__construct($this->message, $code, $previous);
    }

    public function getType()
    {
        return $this->type;
    }
}