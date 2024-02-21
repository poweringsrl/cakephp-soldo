# Soldo plugin for CakePHP

<p>
	<a href="https://github.com/poweringsrl/cakephp-soldo/blob/master/LICENSE"><img src="https://img.shields.io/github/license/poweringsrl/cakephp-soldo" alt="License"></a>
	<a href="https://github.com/poweringsrl/cakephp-soldo/commits"><img src="https://img.shields.io/github/last-commit/poweringsrl/cakephp-soldo" alt="Last commit"></a>
	<a href="https://github.com/poweringsrl/cakephp-soldo/releases/latest"><img src="https://img.shields.io/github/v/tag/poweringsrl/cakephp-soldo?label=last%20release" alt="Last release"></a>
</p>

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org):

```
$ composer require nedgen/cakephp-soldo
```

### Load the plugin

Launch the following command:

```console
$ bin/cake plugin load Soldo -b
```

You should see this in `src/Application.php`:

```php
class Application extends BaseApplication
{
    public function bootstrap()
    {
        $this->addPlugin('Soldo', ['bootstrap' => true]);

        // ...
    }

    // ...
}
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
            'client_id' => '', // Replace with the actual value
            'client_secret' => '', // Replace with the actual value
            'token' => '', // Replace with the actual value
            'private_key' => '', // Replace with the RSA private key you shared with Soldo, encoded in Base64
            'environment' => '', // One of "production" or "demo"
        ],
    ],
];
```

The _token_ and _private_key_ items are optional, but they are both needed if you need to make requests where the [advanced authentication](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#advanced-authentication) is required.

Examples:

```php
return [
    // ...
    'Datasources' => [
        // ...
        'soldo' => [
            'className' => \Muffin\Webservice\Connection::class,
            'service' => \Soldo\Webservice\Driver\Soldo::class,
            'client_id' => 'sHR2rMC7yVAxWxkgRPg0LEIHpCXmpj1s',
            'client_secret' => 'LTVBbG2EnUB1mc30ep3pTgheyCh5WK8O',
            'environment' => 'production',
        ],
    ],
];
```

```php
return [
    // ...
    'Datasources' => [
        // ...
        'soldo' => [
            'className' => \Muffin\Webservice\Connection::class,
            'service' => \Soldo\Webservice\Driver\Soldo::class,
            'client_id' => 'NF1gtE1dhuwR6Yk5bDcUsdGXtnSgTaGW',
            'client_secret' => 'g50Xc5TOzMqa2jdBa3dNZ8H7ysKd9mYl',
            'token' => 'VK6AEW2IAF3SR29SJW4L',
            'private_key' => 'LS0tLS1CRUdJTiBSU0EgUFJJVkFURSBLRVktLS0tLQpjYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkCm9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2wKZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zbwpsZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zCm9sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC0Kc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocAotc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBoCnAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXAKaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZQpwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrCmVwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2EKa2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvYwpha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvCmNha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGQKb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbApkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvCmxkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXMKb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLQpzb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwCi1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGgKcC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcApocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlCnBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWsKZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYQprZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaAotLS0tLUVORCBSU0EgUFJJVkFURSBLRVktLS0tLQ==',
            'environment' => 'production',
        ],
    ],
];
```

## Usage

The following Soldo resources are currently supported:

- [Addresses](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#addresses);
- [Cards](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#cards);
  <!-- - [Company](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#company); -->
- [Employees](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#users);
- [Groups](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#groups);
- [Orders](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#orders);
- [Roles](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#permissions);
- [Subscriptions](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#subscriptions);
- [Transactions](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#transactions);
- [Vehicles](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#vehicles);
- [Wallets](https://developer.soldo.com/v2/f073ovxenbeb2jesx2oif1u2i3awgkyk.html#wallets).

The following code shows an example for the _Card_ resource:

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
            ->select([
                'id',
                'number' => 'masked_pan',
                'custom_field' => 'foo'
            ])
            // GET parameters as expected from Soldo for this resource
            ->where([
                'type' => 'wallet',
                'customreferenceId' => '1368e647-842b-4d17-9a1a-2ad225e6dc1a'
            ])
            ->order(['name' => 'DESC'])
            ->limit(10)
            ->toArray();

        $card = $this->Cards->get('ef12ee12-5cfa-4175-b7e6-665d112aea0e');
    }
}
```

`$cards` will look like this:

```php
array (size=10)
  0 =>
    object(Muffin\Webservice\Model\Resource)[2554]
      public 'id' => string 'df832760-e49b-4699-b34a-46824060bf40' (length=36)
      public 'number' => string '098765******4321' (length=16)
      public 'custom_field' => string 'foo' (length=3)
  1 =>
    object(Muffin\Webservice\Model\Resource)[3094]
      public 'id' => string 'a438c8d6-1d94-4ed3-8895-d4565246f647' (length=36)
      public 'number' => string '123456******7890' (length=16)
      public 'custom_field' => string 'foo' (length=3)
  ...
```

`$card` will look like this:

```php
object(Muffin\Webservice\Model\Resource)[2555]
  public 'id' => string 'ef12ee12-5cfa-4175-b7e6-665d112aea0e' (length=36)
  public 'name' => string 'Bar' (length=12)
  public 'masked_pan' => string '012345******6789' (length=16)
  public 'expiration_date' => string '2025-12-31T23:59:59Z' (length=20)
  public 'creation_time' => string '2022-12-10T19:11:18Z' (length=20)
  public 'last_update' => string '2023-04-11T08:07:38Z' (length=20)
  public 'type' => string 'PLASTIC' (length=7)
  public 'status' => string 'Normal' (length=6)
  public 'owner_type' => string 'company' (length=7)
  public 'wallet_id' => string 'a73b9699-9436-4381-951d-a9da2fd6d439' (length=36)
  public 'currency_code' => string 'EUR' (length=3)
  public 'emboss_line4' => string 'Baz' (length=13)
  public 'active' => boolean true
  public 'method3ds' => string 'USER' (length=4)
  public 'assignees' =>
    array (size=0)
      empty
```

> **Note**: Only read queries are currently supported.
