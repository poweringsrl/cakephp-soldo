# Soldo plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org):

```
$ composer require antogno-pw/cakephp-soldo
```

### Load the plugin

Load the plugin in the `config/bootstrap.php` file:

```php
use Cake\Core\Plugin;

Plugin::load('Soldo', ['bootstrap' => true]);
```

### Configure the datasource

Add the following to the _Datasources_ item in the `config/app.php` file:

```php
return [
    // ...
    'Datasources' => [
        // ...
        'soldo' => [
            'className' => \Muffin\Webservice\Connection::class,
            'service' => \Soldo\Webservice\Driver\Soldo::class,
            'client_id' => '', // Replace with the actual client_id
            'client_secret' => '', // Replace with the actual client_secret
            'environment' => 'production', // One of 'production' or 'demo'
        ],
    ],
];
```

## Usage

The following code shows an example for the _Card_ resource, but any of the Soldo resources can be used.

In detail, the following resources are currently supported:

- [Addresses](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#addresses);
- [Cards](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#cards);
  <!-- - [Company](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#company); -->
- [Employees](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#users);
- [Groups](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#groups);
- [Orders](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#orders);
- [Roles](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#permissions);
- [Subscription](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#subscriptions);
  <!-- - [Transaction](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#transactions); -->
- [Vehicles](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#vehicles);
- [Wallets](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#wallets).

```php
namespace App\Controller;

use Cake\Event\Event;

/**
 * ...
 *
 * @property \Muffin\Webservice\Model\Endpoint $Cards
 */
class CardsController extends AppController
{
    public function initialize()
    {
        $this->loadModel('Soldo/Soldo.Cards', 'Endpoint');
    }

    public function index()
    {
        $cards = $this->Cards->find()
            // GET parameters as expected from Soldo for this resource
            ->where([
                'type' => 'wallet',
                'customreferenceId' => '1368e647-842b-4d17-9a1a-2ad225e6dc1a'
            ])
            ->order(['name' => 'DESC'])
            ->limit(10);

        $card = $this->Cards->get('ef12ee12-5cfa-4175-b7e6-665d112aea0e');

        $this->set('cards', $cards);
        $this->set('card', $card);
    }
}
```

> **Note**: Only read queries are currently supported.
