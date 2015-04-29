<?php
/**
 * Created by PhpStorm.
 * User: littfed
 * Date: 4/30/15
 * Time: 12:22 AM
 */

class Billplz_API_Test extends PHPUnit_Framework_TestCase {


    public function testNewWithOutCallbackUrl()
    {
        $api_key = 'my_api_key';
        $billplzHttpRequest = new Billplz_HttpRequest_Curl();
        // Arrange
        $billplzAPI = new Billplz_API($billplzHttpRequest, $api_key);
        // Assert
        $this->assertEquals($api_key, $billplzAPI->getApiKey());
    }

    public function testNewWithCallbackUrl()
    {
        $api_key = 'my_api_key';
        $callbackurl = 'my_callback_url';

        $billplzHttpRequest = new Billplz_HttpRequest_Curl();

        // Arrange
        $billplzAPI = new Billplz_API($billplzHttpRequest, $api_key, $callbackurl);

        // Assert
        $this->assertEquals($api_key, $billplzAPI->getApiKey());
        $this->assertEquals($callbackurl, $billplzAPI->getCallbackUrl());
    }

    public function testFactory()
    {
        $api_key = 'my_api_key';
        $callbackurl = 'my_callback_url';

        $billplzAPI = Billplz_API::factory($api_key, $callbackurl);

        // Assert
        $this->assertEquals($api_key, $billplzAPI->getApiKey());
        $this->assertEquals($callbackurl, $billplzAPI->getCallbackUrl());

    }

    public function testFactoryWithHttpRequest()
    {
        $api_key = 'my_api_key';
        $callbackurl = 'my_callback_url';

        $billplzHttpRequest = new Billplz_HttpRequest_Curl();

        $billplzAPI = Billplz_API::factory($api_key, $callbackurl, $billplzHttpRequest);

        // Assert
        $this->assertEquals($api_key, $billplzAPI->getApiKey());
        $this->assertEquals($callbackurl, $billplzAPI->getCallbackUrl());

    }

}
