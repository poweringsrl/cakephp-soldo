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

Add the following to the "Datasources" item in the `config/app.php` file:

```php
return [
    // ...
    'Datasources' => [
        // ...
        'soldo' => [
            'className' => \Muffin\Webservice\Connection::class,
            'service' => \Soldo\Webservice\Driver\Soldo::class,
            'client_id' => '********************************', // Replace with the actual client_id
            'client_secret' => '********************************', // Replace with the actual client_secret
            'environment' => 'production', // One of 'production' and 'demo'
        ],
    ],
];
```

## Usage

```php
namespace App\Controller;

use Cake\Event\Event;

class CardsController extends AppController
{
    public function initialize()
    {
        // Instead of 'Cards', any of the Soldo resources (e.g.: 'Wallets', 'Groups', 'Permissions', etc.) can be used
        $this->loadModel('Soldo/Soldo.Cards', 'Endpoint');
    }

    public function index()
    {
        $cards = $this->Cards->find()->where([
            // ...
        ]);

        $this->set('cards', $cards);
    }
}
```
