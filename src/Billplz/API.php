<?php

class Billplz_API {

    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var null|string
     */
    protected $callbackUrl = NULL;

    /**
     * @var string
     */
    protected $apiEndpoint = 'https://www.billplz.com/api/v3/';

    /**
     * @var string
     */
    protected $apiSandboxEndpointUrl = 'https://billplz-staging.herokuapp.com/api/v3/';

    /**
     * @var Billplz_HttpRequest
     */
    protected $httpRequest;

    /**
     * @param Billplz_HttpRequest $httpRequest
     * @param string $apiKey
     * @param null $callbackUrl
     * @return Billplz_API
     */
    function __construct(Billplz_HttpRequest $httpRequest, $apiKey, $callbackUrl = NULL)
    {
        $this->httpRequest = $httpRequest;
        if (isset($callbackUrl)) $this->setCallbackUrl($callbackUrl);
        return $this->setApiKey($apiKey);
    }

    /**
     * @param $apiKey
     * @param null $callbackUrl
     * @param Billplz_HttpRequest $httpRequest
     * @return Billplz_API
     */
    public static function factory($apiKey, $callbackUrl = NULL, Billplz_HttpRequest $httpRequest = NULL)
    {
        $httpRequest = is_null($httpRequest) ? new Billplz_HttpRequest_Curl() : $httpRequest;
        return new Billplz_API($httpRequest, $apiKey, $callbackUrl);
    }

    /**
     * @param null $apiSandboxEndpointUrl
     * @return $this
     */
    public function sandboxMode($apiSandboxEndpointUrl = NULL)
    {
        $this->apiEndpoint = isset($apiSandboxEndpointUrl) ? $apiSandboxEndpointUrl : $this->apiSandboxEndpointUrl;
        return $this;
    }


    /**
     * @param string $apiKey
     * @return class Billplz_API
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
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
     * @param string $callbackUrl
     * @return Billplz_API
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @param $title
     * @param array $optional
     * @return mixed
     * @throws Billplz_Exception
     */
    public function createCollection($title, array $optional = array())
    {
        $data['title'] = $title;
        $data = $data + $optional;

        return $this->request('POST', 'collections', $data);
    }

    /**
     * @param $collection_id
     * @param string $email
     * @param string $name
     * @param $amount
     * @param array $optional
     * @return mixed
     * @throws Billplz_Exception
     */
    public function createBill($collection_id, $email, $name, $amount, $description, array $optional = array())
    {
        $data['collection_id']  = $collection_id;
        $data['email']          = $email;
        $data['name']           = $name;
        $data['amount']         = $amount;
        $data['description']    = $description;
        $data['callback_url']   = $this->callbackUrl;
        $data = $data + $optional;

        return $this->request('POST', 'bills', $data);
    }

    /**
     * @param $billID
     * @return mixed
     * @throws Billplz_Exception
     */
    public function getBill($billID)
    {
        return $this->request('GET', 'bills/'.$billID);
    }

    /**
     * @param $billID
     * @return mixed
     * @throws Billplz_Exception
     */
    public function deleteBill($billID)
    {
        return $this->request('DELETE', 'bills/'.$billID);
    }

    /**
     * @return mixed
     */
    public function webhookHandler()
    {
        $data = json_decode($_POST);
        return $data;
    }

    /**
     * @param $method
     * @param $path
     * @param null $data
     * @return mixed
     * @throws Billplz_Exception
     */
    private function request($method, $path, $data = NULL)
    {
        $response = $this->httpRequest
            ->setUrl($this->apiEndpoint.$path)
            ->setMethod($method)
            ->setApiKey($this->apiKey)
            ->setData($data)
            ->execute();

        $result = json_decode($response);

        if (!is_object($result)) {

            // TODO Not valid answer from API

        } elseif (isset($result->error)) {

            throw new Billplz_Exception($result);

        }

        return $result;
    }

}

