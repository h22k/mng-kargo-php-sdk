# WARNING

This project is no longer being developed. 

# MngKargo PHP Client

This is a PHP client for the MngKargo API. It provides a simple and convenient way to interact with the API, allowing you to focus on writing your application.

## Requirements

- PHP 8.1 or higher
- Composer

[//]: # (## Installation)

[//]: # ()
[//]: # (Use Composer to install the MngKargo PHP Client:)

[//]: # ()
[//]: # (```bash)

[//]: # (composer require h22k/mngkargo)

[//]: # (```)

## Usage

Here's a basic example of how to use the client:

```php
<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use H22k\MngKargo\Factory;

$mng = Factory::create(
    'API_KEY',
    'API_SECRET',
    'PASS',
    'CLIENT_NUMBER'
)
    ->setBaseUrl('https://testapi.mngkargo.com.tr/mngapi/api/')
    ->setDebug(true)
    ->make();

$cities = $mng->cbsInfo()->getCities(); // H22k\MngKargo\Model\Response\CbsInfo\CityResponse
$cities = $cities->cities(); // H22k\MngKargo\Model\Response\CbsInfo\Object\City[]

$city = $cities[0]; // H22k\MngKargo\Model\Response\CbsInfo\Object\City
$districts = $mng->cbsInfo()->getDistricts($city); // H22k\MngKargo\Model\Response\CbsInfo\DistrictResponse
```

[//]: # (For more detailed examples, see the [examples]&#40;./examples&#41; directory.)

[//]: # (## Contributing)

[//]: # ()
[//]: # (Contributions are welcome! Please read our [contributing guide]&#40;./CONTRIBUTING.md&#41; to get started.)

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.
