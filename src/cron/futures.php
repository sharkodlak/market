<?php

declare(strict_types=1);
require __DIR__ . '/../../vendor/autoload.php';

const DB_CONNECT = '/etc/webconf/market/connect.powerUser.pgsql';
const QUANDL_API_KEY = '/etc/webconf/quandl.api.key';

$apiKey = trim(file_get_contents(QUANDL_API_KEY));
$di = new class($apiKey) implements \Sharkodlak\Db\Di, \Sharkodlak\Market\Quandl\Di {
	private $privateApiKey;
	private $services = [];
	public function __construct($apiKey) {
		$this->privateApiKey = $apiKey;
	}
	public function __get($name) {
		if (!isset($services[$name])) {
			$method = "get$name";
			$services[$name] = $this->$method();
		}
		return $services[$name];
	}
	public function getApiKey(): string {
		return $this->privateApiKey;
	}
	public function getQuery(...$args): \Sharkodlak\Db\Queries\Query {
		return new \Sharkodlak\Db\Queries\Query(...$args);
	}
	public function getConnector(): \Sharkodlak\Market\Quandl\Connector {
		return new Sharkodlak\Market\Quandl\Connector($this);
	}
	public function getFutures(): \Sharkodlak\Market\Futures {
		return new Sharkodlak\Market\Futures();
	}
	public function getLogger(): \Psr\Log\LoggerInterface {
		$logger = new class extends \Psr\Log\AbstractLogger {
			public function log($level, $message, array $context = []) {
				switch ($level) {
					case \Psr\Log\LogLevel::EMERGENCY:
					case \Psr\Log\LogLevel::ALERT:
					case \Psr\Log\LogLevel::CRITICAL:
					case \Psr\Log\LogLevel::ERROR:
						$style = "\e[91m";
						$message .= "\n";
					break;
					case \Psr\Log\LogLevel::WARNING:
						$style = "\e[33m";
						$message .= "\n";
					break;
					case \Psr\Log\LogLevel::NOTICE:
						$style = "\e[93m";
						$message .= "\n";
					break;
					default:
						$style = "\x0D\e[2m";
				}
				echo "$style$message\e[0m";
			}
		};
		return $logger;
	}
	public function getRootDir(): string {
		return '/vagrant';
	}
};
$pdo = new \PDO('uri:file://' . DB_CONNECT);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$dbAdapter = new \Sharkodlak\Db\Adapter\Postgres($pdo);
$db = new \Sharkodlak\Db\Db($di, $dbAdapter);
$futures = new Sharkodlak\Market\Quandl\Futures($di);
$futures->getAndStoreContracts($db);
$futures->getAndStoreData($db, 'ICE', 'CC', 2016, 3);
