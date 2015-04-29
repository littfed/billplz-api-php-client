<?php

class Billplz_HttpRequest_Curl implements Billplz_HttpRequest
{
    private $handle = null;
    private $url;
    private $method;
    private $data;
    private $apiKey;

    public function __construct() {
        $this->handle = curl_init();
    }


    /**
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return BillplzAPICurl
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return BillplzAPICurl
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return BillplzAPICurl
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     * @return BillplzAPICurl
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function execute()
    {
        curl_setopt($this->handle, CURLOPT_URL, $this->url);
        curl_setopt($this->handle, CURLOPT_USERPWD, $this->apiKey.':');
        curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_VERBOSE, true);
        if (isset($this->data)) curl_setopt($this->handle, CURLOPT_POSTFIELDS, http_build_query($this->data, '', '&'));
        return curl_exec($this->handle);
    }

    public function getInfo($name)
    {
        return curl_getinfo($this->handle, $name);
    }

    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);
    }

    public function close()
    {
        curl_close($this->handle);
    }
}