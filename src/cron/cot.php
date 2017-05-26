<?php

const DB_CONNECT = '/etc/webconf/market/connect.powerUser.pgsql';

class COT {
	const READ_ONLY = 'r';
	const URL = 'http://www.cftc.gov/files/dea/history/deahistfo2017.zip';
	const ZIP = '/tmp/cot.zip';

	private $exchanges = [];
	private static $fieldNames = [
		"Market and Exchange Names",
		"As of Date in Form YYMMDD",
		"As of Date in Form YYYY-MM-DD",
		"CFTC Contract Market Code",
		"CFTC Market Code in Initials",
		"CFTC Region Code",
		"CFTC Commodity Code",
		"Open Interest (All)",
		"Noncommercial Positions-Long (All)",
		"Noncommercial Positions-Short (All)",
		"Noncommercial Positions-Spreading (All)",
		"Commercial Positions-Long (All)",
		"Commercial Positions-Short (All)",
		" Total Reportable Positions-Long (All)",
		"Total Reportable Positions-Short (All)",
		"Nonreportable Positions-Long (All)",
		"Nonreportable Positions-Short (All)",
		"Open Interest (Old)",
		"Noncommercial Positions-Long (Old)",
		"Noncommercial Positions-Short (Old)",
		"Noncommercial Positions-Spreading (Old)",
		"Commercial Positions-Long (Old)",
		"Commercial Positions-Short (Old)",
		"Total Reportable Positions-Long (Old)",
		"Total Reportable Positions-Short (Old)",
		"Nonreportable Positions-Long (Old)",
		"Nonreportable Positions-Short (Old)",
		"Open Interest (Other)",
		"Noncommercial Positions-Long (Other)",
		"Noncommercial Positions-Short (Other)",
		"Noncommercial Positions-Spreading (Other)",
		"Commercial Positions-Long (Other)",
		"Commercial Positions-Short (Other)",
		"Total Reportable Positions-Long (Other)",
		"Total Reportable Positions-Short (Other)",
		"Nonreportable Positions-Long (Other)",
		"Nonreportable Positions-Short (Other)",
		"Change in Open Interest (All)",
		"Change in Noncommercial-Long (All)",
		"Change in Noncommercial-Short (All)",
		"Change in Noncommercial-Spreading (All)",
		"Change in Commercial-Long (All)",
		"Change in Commercial-Short (All)",
		"Change in Total Reportable-Long (All)",
		"Change in Total Reportable-Short (All)",
		"Change in Nonreportable-Long (All)",
		"Change in Nonreportable-Short (All)",
		"% of Open Interest (OI) (All)",
		"% of OI-Noncommercial-Long (All)",
		"% of OI-Noncommercial-Short (All)",
		"% of OI-Noncommercial-Spreading (All)",
		"% of OI-Commercial-Long (All)",
		"% of OI-Commercial-Short (All)",
		"% of OI-Total Reportable-Long (All)",
		"% of OI-Total Reportable-Short (All)",
		"% of OI-Nonreportable-Long (All)",
		"% of OI-Nonreportable-Short (All)",
		"% of Open Interest (OI)(Old)",
		"% of OI-Noncommercial-Long (Old)",
		"% of OI-Noncommercial-Short (Old)",
		"% of OI-Noncommercial-Spreading (Old)",
		"% of OI-Commercial-Long (Old)",
		"% of OI-Commercial-Short (Old)",
		"% of OI-Total Reportable-Long (Old)",
		"% of OI-Total Reportable-Short (Old)",
		"% of OI-Nonreportable-Long (Old)",
		"% of OI-Nonreportable-Short (Old)",
		"% of Open Interest (OI) (Other)",
		"% of OI-Noncommercial-Long (Other)",
		"% of OI-Noncommercial-Short (Other)",
		"% of OI-Noncommercial-Spreading (Other)",
		"% of OI-Commercial-Long (Other)",
		"% of OI-Commercial-Short (Other)",
		"% of OI-Total Reportable-Long (Other)",
		"% of OI-Total Reportable-Short (Other)",
		"% of OI-Nonreportable-Long (Other)",
		"% of OI-Nonreportable-Short (Other)",
		"Traders-Total (All)",
		"Traders-Noncommercial-Long (All)",
		"Traders-Noncommercial-Short (All)",
		"Traders-Noncommercial-Spreading (All)",
		"Traders-Commercial-Long (All)",
		"Traders-Commercial-Short (All)",
		"Traders-Total Reportable-Long (All)",
		"Traders-Total Reportable-Short (All)",
		"Traders-Total (Old)",
		"Traders-Noncommercial-Long (Old)",
		"Traders-Noncommercial-Short (Old)",
		"Traders-Noncommercial-Spreading (Old)",
		"Traders-Commercial-Long (Old)",
		"Traders-Commercial-Short (Old)",
		"Traders-Total Reportable-Long (Old)",
		"Traders-Total Reportable-Short (Old)",
		"Traders-Total (Other)",
		"Traders-Noncommercial-Long (Other)",
		"Traders-Noncommercial-Short (Other)",
		"Traders-Noncommercial-Spreading (Other)",
		"Traders-Commercial-Long (Other)",
		"Traders-Commercial-Short (Other)",
		"Traders-Total Reportable-Long (Other)",
		"Traders-Total Reportable-Short (Other)",
		"Concentration-Gross LT = 4 TDR-Long (All)",
		"Concentration-Gross LT =4 TDR-Short (All)",
		"Concentration-Gross LT =8 TDR-Long (All)",
		"Concentration-Gross LT =8 TDR-Short (All)",
		"Concentration-Net LT =4 TDR-Long (All)",
		"Concentration-Net LT =4 TDR-Short (All)",
		"Concentration-Net LT =8 TDR-Long (All)",
		"Concentration-Net LT =8 TDR-Short (All)",
		"Concentration-Gross LT =4 TDR-Long (Old)",
		"Concentration-Gross LT =4 TDR-Short (Old)",
		"Concentration-Gross LT =8 TDR-Long (Old)",
		"Concentration-Gross LT =8 TDR-Short (Old)",
		"Concentration-Net LT =4 TDR-Long (Old)",
		"Concentration-Net LT =4 TDR-Short (Old)",
		"Concentration-Net LT =8 TDR-Long (Old)",
		"Concentration-Net LT =8 TDR-Short (Old)",
		"Concentration-Gross LT =4 TDR-Long (Other)",
		"Concentration-Gross LT =4 TDR-Short(Other)",
		"Concentration-Gross LT =8 TDR-Long (Other)",
		"Concentration-Gross LT =8 TDR-Short(Other)",
		"Concentration-Net LT =4 TDR-Long (Other)",
		"Concentration-Net LT =4 TDR-Short (Other)",
		"Concentration-Net LT =8 TDR-Long (Other)",
		"Concentration-Net LT =8 TDR-Short (Other)",
		"Contract Units",
		"CFTC Contract Market Code (Quotes)",
		"CFTC Market Code in Initials (Quotes)",
		"CFTC Commodity Code (Quotes)",
	];
	private $instruments = [];
	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public static function copyMissingFile($filename = self::ZIP, $url = self::URL) {
		if (!file_exists($filename)) {
			copy($url, $filename);
		}
		return 'zip://' . $filename . '#annualof.txt';
	}

	public function checkFields($fields) {
		$unknownFieldNames = array_diff($fields, self::$fieldNames);
		if (!empty($unknownFieldNames)) {
			print_r($unknownFieldNames);
			throw new \Exception('Unknown field names!');
		}
	}

	public function getExchangeId($exchange) {
		if (array_key_exists($exchange, $this->exchanges)) {
			$exchangeId = $this->exchanges[$exchange];
		} else {
			$params = ['exchange' => $exchange];
			$sql = "SELECT id FROM exchange WHERE name = :exchange";
			$statement = $this->pdo->prepare($sql);
			$success = $statement->execute($params);
			$exchangeId = $statement->fetchColumn();
			if ($exchangeId === false) {
				$sql = "INSERT INTO exchange (name) VALUES (:exchange) RETURNING id";
				$statement = $this->pdo->prepare($sql);
				$success = $statement->execute($params);
				$exchangeId = $statement->fetchColumn();
			}
			$this->exchanges[$exchange] = $exchangeId;
		}
		return $exchangeId;
	}

	public function getInstrumentId($exchangeId, $market) {
		if (array_key_exists($market, $this->instruments)) {
			$instrumentId = $this->instruments[$market];
		} else {
			$params = ['instrument' => $market];
			$sql = "SELECT id FROM instrument WHERE name = :instrument";
			$statement = $this->pdo->prepare($sql);
			$success = $statement->execute($params);
			$instrumentId = $statement->fetchColumn();
			if ($instrumentId === false) {
				$params['exchangeId'] = $exchangeId;
				$sql = "INSERT INTO instrument (exchange_id, name) VALUES (:exchangeId, :instrument) RETURNING id";
				$statement = $this->pdo->prepare($sql);
				$success = $statement->execute($params);
				$instrumentId = $statement->fetchColumn();
			}
			$this->instruments[$market] = $instrumentId;
		}
		return $instrumentId;
	}

	public static function indexOfFieldName($fieldName) {
		return array_search($fieldName, self::$fieldNames);
	}

	public function parseFile($filename) {
		$firstLine = true;
		$fp = fopen($filename, self::READ_ONLY);
		while ($line = fgetcsv($fp)) {
			if ($firstLine) {
				$this->checkFields($line);
				$firstLine = false;
			} else {
				$fieldIndex = $this->indexOfFieldName('Market and Exchange Names');
				list($market, $exchange) = preg_split('~ - (?!.* - )~', $line[$fieldIndex]);
				$exchangeId = $this->getExchangeId($exchange);
				$instrumentId = $this->getInstrumentId($exchangeId, $market, $line[$this->indexOfFieldName('Contract Units')]);
				var_dump($line);exit('asdfghjk');
			}
		}
	}
}



$pdo = new \PDO('uri:file://' . DB_CONNECT);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$cot = new COT($pdo);
$filename = $cot->copyMissingFile();
$cot->parseFile($filename);
