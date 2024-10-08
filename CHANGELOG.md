# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [Version 1.3.0][v1.3.0] - 2024-09-09

### Added

- Support for array query parameters.

### Changed

- Replaced deprecated way of loading plugins.

### Fixed

- Requesting results without specifying pagination would return an error if the results spanned multiple pages.

## [Version 1.2.1][v1.2.1] - 2024-03-05

### Added

- Decryption function.

## [Version 1.2.0][v1.2.0] - 2024-03-01

### Added

- Auto-login option.
- Complete fingerprint order support.
- Internal transfers support.

### Changed

- There are now specific exceptions for each error.

### Fixed

- Constant definition of the cache config key.
- The cache key where the access token is stored is also based on the current environment.

## [Version 1.1.0][v1.1.0] - 2023-12-07

### Added

- You can now select only the wanted fields when querying.
- You can add custom fields with custom values while selecting.
- Advanced authentication support.
- Transaction resource support.

### Fixed

- The cache key where the access token is stored is also based on credentials.

## [Version 1.0.0][v1.0.0] - 2023-11-27

### Initial release

[Unreleased]: https://github.com/poweringsrl/cakephp-soldo/compare/v1.3.0...HEAD
[v1.3.0]: https://github.com/poweringsrl/cakephp-soldo/compare/v1.2.1...v1.3.0
[v1.2.1]: https://github.com/poweringsrl/cakephp-soldo/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/poweringsrl/cakephp-soldo/compare/v1.1.0...v1.2.0
[v1.1.0]: https://github.com/poweringsrl/cakephp-soldo/compare/v1.0.0...v1.1.0
[v1.0.0]: https://github.com/poweringsrl/cakephp-soldo/releases/tag/v1.0.0
