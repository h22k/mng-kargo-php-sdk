
# MngKargo PHP Client

!!! Will be updated.

This is a PHP client for the MngKargo API. It provides a simple and convenient way to interact with the API, allowing you to focus on writing your application.

## Requirements

- PHP 8.0 or higher
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

use H22k\MngKargo\MngClient;
use H22k\MngKargo\Factory;

$manager = Factory::create(/* parameters */)
    ->make();

$manager->cbsInfo()->getCities();
```

[//]: # (For more detailed examples, see the [examples]&#40;./examples&#41; directory.)

[//]: # (## Contributing)

[//]: # ()
[//]: # (Contributions are welcome! Please read our [contributing guide]&#40;./CONTRIBUTING.md&#41; to get started.)

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.
