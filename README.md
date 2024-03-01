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
            'autologin' => true, // Whether to try to authenticate as soon as the plugin is initialized, or wait until needed
        ],
    ],
];
```

The _token_ and _private_key_ items are optional, but they are both needed if you need to make requests where the [advanced authentication](https://developer.soldo.com/docs/advanced-authentication) is required.

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
            'environment' => 'demo',
            'autologin' => true,
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
            'autologin' => false,
        ],
    ],
];
```

## Usage

The following Soldo resources are currently supported:

- [Addresses](https://developer.soldo.com/reference/addresse-search);
- [Cards](https://developer.soldo.com/reference/card-search);
  <!-- - [Company](https://developer.soldo.com/reference/company-get); -->
- [Employees](https://developer.soldo.com/reference/user-search);
- [Groups](https://developer.soldo.com/reference/group-search);
- [Orders](https://developer.soldo.com/reference/order-search);
- [Roles](https://developer.soldo.com/reference/roles-list);
- [Subscriptions](https://developer.soldo.com/reference/subscription-search);
- [Transactions](https://developer.soldo.com/reference/transaction-search);
- [Vehicles](https://developer.soldo.com/reference/vehicle-search);
- [Wallets](https://developer.soldo.com/reference/wallet-search).

> **Note**: For all the resources listed above, **only read queries are currently supported, except for [internal transfers](#internal-transfers)**.

### Reading

The following code shows an example for the _Card_ resource:

```php
namespace App\Controller;

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
                'custom_field' => 'foo',
            ])
            ->where([
                // GET parameters as expected from Soldo for this resource
                'type' => 'wallet',
                'customreferenceId' => '1368e647-842b-4d17-9a1a-2ad225e6dc1a',
            ])
            ->order(['name' => 'DESC'])
            ->limit(10)
            ->toArray();

        $card = $this->Cards->get('ef12ee12-5cfa-4175-b7e6-665d112aea0e', [
            'conditions' => [
                // GET parameters as expected from Soldo for this resource
                'showSensitiveData' => 'true',
            ]
        ]);
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
  public 'sensitive_data' =>
    array (size=3)
      'encrypted_full_pan' => string 'MDEyMzQ1MDAwMDAwNjc4OWNha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHA=' (length=344)
      'encrypted_cvv' => string 'MTIzY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHA=' (length=344)
      'encrypted_pin' => string 'MTIzNGNha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGhwLXNvbGRvY2FrZXBocC1zb2xkb2Nha2VwaHAtc29sZG9jYWtlcGg=' (length=344)
  public 'assignees' =>
    array (size=0)
      empty
```

### Internal transfers

The only non-reading request currently supported by this plugin are [internal transfers](https://developer.soldo.com/reference/wallet-internal-transfer).

The following code shows an example on how to make one:

```php
namespace App\Controller;

/**
 * ...
 *
 * @property \Soldo\Model\Endpoint\TransfersEndpoint $Transfers
 */
class WalletsController extends AppController
{
    public function initialize()
    {
        $this->loadModel('Soldo/Soldo.Transfers', 'Endpoint');
    }

    public function add()
    {
        $transfer = $this->Transfers->newEntity([
            'fromWalletId' => '288ae0a2-4d53-4d3f-b8f9-63cbe3b06429',
            'toWalletId' => '655192d7-80eb-4018-a9d3-2b9843aa4a64',
            'amount' => 10,
            'currencyCode' => 'EUR'
        ]);

        $result = $this->Transfers->save($transfer);
    }
}
```

`$result` will look like this:

```php
object(Muffin\Webservice\Model\Resource)[1319]
  public 'amount' => int 10
  public 'currency' => string 'EUR' (length=3)
  public 'datetime' => string '2024-03-01T07:36:29.509Z' (length=24)
  public 'from_wallet' =>
    array (size=7)
      'id' => string '288ae0a2-4d53-4d3f-b8f9-63cbe3b06429' (length=36)
      'name' => string 'Foo' (length=3)
      'currency_code' => string 'EUR' (length=3)
      'available_amount' => float 90
      'blocked_amount' => float 0
      'primary_user_type' => string 'main' (length=4)
      'visible' => boolean true
  public 'to_wallet' =>
    array (size=8)
      'id' => string '655192d7-80eb-4018-a9d3-2b9843aa4a64' (length=36)
      'name' => string 'Bar' (length=3)
      'currency_code' => string 'EUR' (length=3)
      'available_amount' => float 10
      'blocked_amount' => float 0
      'primary_user_type' => string 'employee' (length=8)
      'primary_user_public_id' => string 'ABCD1234-000000' (length=15)
      'visible' => boolean true
```
