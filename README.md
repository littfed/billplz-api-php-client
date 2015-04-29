# BillplzAPI #

## Usage ##


### Initialization ###

```PHP
<?php

require_once 'billplz-api-php-client/src/Billplz/autoload.php'; // or wherever autoload.php is located

// LiveMode
$billplzAPI = Billplz_API::factory('my-api-key', 'callbackurl'); 

// SandboxMode
$billplzAPI = Billplz_API::factory('my-api-key', 'callbackurl')->sandboxMode(); 

```

### Create Bill

```PHP

try
{
    $collection_id = 'ebdmqj6z';
    $optional = ['redirect_url' => 'http://my-site-redire.ct/url', 'deliver' => true, 'metadata' => ['orderId' => 1, 'customerID' => 1]];
    $result = $billplzAPI->createBill($collection_id, 'my-customer-email@gmail.com', 'Custo Mer', 1000, $optional);
    var_dump($result);
}
catch (Billplz_Exception $e)
{
    echo $e->getType().' | '.$e->getMessage().PHP_EOL;
}

```

