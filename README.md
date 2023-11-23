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

Plugin::load('Muffin/Webservice', ['bootstrap' => true]);
```

### Configure the datasource

Add the following to the "Datasources" item in the `config/app.php` file:

```php
return [
    // ...
    'Datasources' => [
        // ...
        'cards' => [
            'className' => \Muffin\Webservice\Connection::class,
            'service' => \Soldo\Webservice\Driver\Soldo::class,
            'client_id' => '********************************', // replace with the actual client_id
            'client_secret' => '********************************', // replace with the actual client_secret
            'environment' => 'production' // 'production' or 'demo'
        ]
    ]
];
```

## Usage

```php
namespace App\Controller;

use Cake\Event\Event;

class FooController extends AppController
{
    public function initialize()
    {
        // ...
        $this->loadModel('Soldo/Cards.Cards', 'Endpoint');
    }

    public function index()
    {
        $cards = $this->Cards->find()->toArray();

        $this->set('cards', $cards);
    }
}
```
