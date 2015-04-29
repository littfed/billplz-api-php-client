<?php

interface Billplz_HttpRequest
{
    public function setUrl($value);
    public function setMethod($value);
    public function setData($value);
    public function setApiKey($value);
    public function execute();
    public function close();
}