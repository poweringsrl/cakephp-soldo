<?php

namespace Soldo\Webservice\Driver;

use Muffin\Webservice\AbstractDriver;
use Soldo\Error\FailedStandardAuthenticationException;
use Soldo\Error\InvalidEnvironmentException;
use Soldo\Error\NoStandardCredentialsException;

class Soldo extends AbstractDriver
{
	protected const API_PRODUCTION_HOST = 'api.soldo.com';
	protected const API_DEMO_HOST = 'api-demo.soldocloud.net';
	protected const API_AUTHORIZE_PATH = '/oauth/authorize';
	protected const ACCESS_TOKEN_CACHE_KEY = 'soldo_access_token';

	/**
	 * @var \Cake\Http\Client
	 */
	protected $_client;

	/**
	 * @return \Cake\Http\Client
	 */
	public function getClient()
	{
		return parent::getClient();
	}

	public function initialize()
	{
		$this->setClient(new \Cake\Http\Client($this->getClientConfig($this->isAutologinEnabled())));
	}

	public function authenticate()
	{
		$this->setClient(new \Cake\Http\Client($this->getClientConfig(true)));

		return $this;
	}

	protected function getHost()
	{
		return $this->getEnvironment() === 'production'
			? static::API_PRODUCTION_HOST
			: static::API_DEMO_HOST;
	}

	protected function getAccessToken()
	{
		$client_id = $this->getConfig('client_id');
		$client_secret = $this->getConfig('client_secret');
		$environment = $this->getEnvironment();

		$access_token_cache_key = self::ACCESS_TOKEN_CACHE_KEY . '_' . sha1($client_id . $client_secret . $environment);

		if (\Cake\Cache\Cache::read($access_token_cache_key) !== false) {
			return \Cake\Cache\Cache::read($access_token_cache_key);
		}

		if (empty($client_id) || empty($client_secret)) {
			throw new NoStandardCredentialsException();
		}

		$host = $this->getHost();

		$authorizer = new \Cake\Http\Client([
			'host' => $host,
			'scheme' => 'https',
		]);

		$response = $authorizer->post(self::API_AUTHORIZE_PATH, [
			'client_id' => $client_id,
			'client_secret' => $client_secret,
		]);

		if (!$response->isOk()) {
			throw new FailedStandardAuthenticationException();
		}

		$data = $response->getJson();

		if (
			empty($data['access_token']) ||
			empty($data['token_type']) ||
			empty($data['expires_in']) ||
			$data['token_type'] !== 'bearer'
		) {
			throw new FailedStandardAuthenticationException('Could not retrieve the access token');
		}

		$token = $data['access_token'];
		$expiration = intval($data['expires_in']);

		$engine = \Cake\Cache\Cache::engine(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY);
		$engine->setConfig(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY, '+' . $expiration . ' seconds');

		\Cake\Cache\Cache::write($access_token_cache_key, $token, SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY);

		return $token;
	}

	private function getEnvironment()
	{
		$environment = $this->getConfig('environment');

		if (empty($environment) || !in_array($environment, ['production', 'demo'])) {
			throw new InvalidEnvironmentException($environment);
		}

		return $environment;
	}

	protected function getClientConfig(bool $authenticate)
	{
		$host = $this->getHost();

		$config = [
			'host' => $host,
			'scheme' => 'https',
		];

		if ($authenticate === true) {
			$token = $this->getAccessToken();
			$config['headers'] = ['Authorization' => 'Bearer ' . $token];
		}

		return $config;
	}

	private function isAutologinEnabled()
	{
		$autologin = $this->getConfig('autologin');

		return $autologin === true || $autologin === null;
	}
}
