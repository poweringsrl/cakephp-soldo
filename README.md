# Soldo plugin for CakePHP

<p>
	<a href="https://gitlab.com/antognoPW/cakephp-soldo/blob/master/LICENSE"><img src="https://img.shields.io/gitlab/license/antognoPW/cakephp-soldo" alt="License"></a>
	<a href="https://gitlab.com/antognoPW/cakephp-soldo/commits"><img src="https://img.shields.io/gitlab/last-commit/antognoPW/cakephp-soldo" alt="Last commit"></a>
	<a href="https://gitlab.com/antognoPW/cakephp-soldo/releases"><img src="https://img.shields.io/gitlab/v/tag/antognoPW/cakephp-soldo?label=last%20release" alt="Last release"></a>
</p>

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
- [Subscriptions](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#subscriptions);
  <!-- - [Transactions](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#transactions); -->
- [Vehicles](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#vehicles);
- [Wallets](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#wallets).

```php
namespace App\Controller;

use Cake\Event\Event;

/**
 * ...
 *
 * @property \Soldo\Model\Endpoint\CardsEndpoint $Cards
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
