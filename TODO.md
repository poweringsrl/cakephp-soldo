# TODO

This is the Markdown TODO file for [Soldo plugin for CakePHP](https://github.com/poweringsrl/cakephp-soldo).

## Features

- [x] Add [Transactions](https://developer.soldo.com/reference/transaction-search) support
- [x] Support for using GET parameters when requesting resources where the [advanced authentication](https://developer.soldo.com/docs/advanced-authentication) is required, by using the "fingerprint order"
- [x] Add support for [internal transfers](https://developer.soldo.com/reference/wallet-internal-transfer)

## Codebase

- [ ] Add tests
- [x] Add PHPDoc
- [x] Add specific exceptions for each error
- [ ] Make query results be of own `Soldo\Model\Resource` class instead of the generic `Muffin\Webservice\Model\Resource`
