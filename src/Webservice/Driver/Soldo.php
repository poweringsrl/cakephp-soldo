<?php

namespace Soldo\Webservice\Driver;

use Cake\Cache\Cache;
use Cake\Http\Client;
use Exception;
use Muffin\Webservice\AbstractDriver;
use Soldo\Http\Client\Adapter\SoldoCurl;

class Soldo extends AbstractDriver
{
	protected const API_PRODUCTION_HOST = 'api.soldo.com';
	protected const API_DEMO_HOST = 'api-demo.soldocloud.net';
	protected const API_AUTHORIZE_PATH = '/oauth/authorize';
	protected const ACCESS_TOKEN_CACHE_KEY = 'soldo_access_token';

	public function initialize()
	{
		$host = $this->getHost();

		$token = $this->getAccessToken();

		$this->setClient(
			new Client([
				'host' => $host,
				'scheme' => 'https',
				'headers' => ['Authorization' => 'Bearer ' . $token],
			])
		);
	}

	protected function getHost()
	{
		$environment = $this->getConfig('environment');

		if (!in_array($environment, ['production', 'demo'])) {
			throw new Exception();
		}

		return $environment === 'production' ? static::API_PRODUCTION_HOST : static::API_DEMO_HOST;
	}

	protected function getAccessToken()
	{
		$client_id = $this->getConfig('client_id');
		$client_secret = $this->getConfig('client_secret');

		$access_token_cache_key = self::ACCESS_TOKEN_CACHE_KEY . '_' . sha1($client_id . $client_secret);

		if (Cache::read($access_token_cache_key) !== false) {
			return Cache::read($access_token_cache_key);
		}

		if (empty($client_id) || empty($client_secret)) {
			throw new Exception();
		}

		$host = $this->getHost();

		$authorizer = new Client([
			'host' => $host,
			'scheme' => 'https',
		]);

		$response = $authorizer->post(self::API_AUTHORIZE_PATH, [
			'client_id' => $client_id,
			'client_secret' => $client_secret,
		]);

		if (!$response->isOk()) {
			throw new Exception();
		}

		$data = $response->getJson();

		if (
			empty($data['access_token']) ||
			empty($data['token_type']) ||
			empty($data['expires_in']) ||
			$data['token_type'] !== 'bearer'
		) {
			throw new Exception();
		}

		$token = $data['access_token'];
		$expiration = intval($data['expires_in']);

		$engine = Cache::engine(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY);
		$engine->setConfig(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY, '+' . $expiration . ' seconds');

		Cache::write($access_token_cache_key, $token, SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY);

		return $token;
	}
}
