EZ Locate PHP SDK
============================

PHP SDK for [EZ Locate API](https://www.ezlocate.us/docs/api/).

## Installation
```term
$ composer require ezlocate/ezlocate-php-sdk
```

## Usage
```php
use \EZLocate\EZLocate;
use \EZLocate\Order;

const EZL_USERNAME = 'YOUR_EZL_USERNAME';
const EZL_ACCESS_TOKEN = 'YOUR_EZL_ACCESS_TOKEN';

$ezl = new EZLocate(EZL_USERNAME, EZL_ACCESS_TOKEN);

$data = [
    'notes' => 'My order notes',
    'ref' => 'XXXX',
    'ref_2' => 'YYYY',
    'person' => [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'ssn' => 'XXXX'
    ]
];

$order = $ezl->createOrder($data);
print_r($order);
```

## License
Released under the [MIT License](http://opensource.org/licenses/MIT).
See [LICENSE](LICENSE) file.