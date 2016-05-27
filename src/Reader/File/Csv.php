<?php

namespace OpsWay\Migration\Reader\File;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use OpsWay\Migration\Reader\ReaderInterface;

class Csv implements ReaderInterface
{

	protected $skippedHeader = false;
	protected $handle;

    public function __construct(array $connectionParams)
    {
        $this->connection = DriverManager::getConnection($connectionParams, new Configuration());
		
		$this->handle = fopen(__DIR__ . "/../../../data/export.csv", "r");
    }

    /**
     * @return array|null
     */
    public function read()
    {
		if (!$this->skippedHeader)
		{
			fgetcsv($this->handle);
			$this->skippedHeader = true;
		}
		
		if ($row = fgetcsv($this->handle))
		{
			return [
				'id' => $row[0],
				'sku' => $row[1],
				'name' => $row[2],
				'qty' => $row[3],
				'is_stock' => $row[4]
			];
		}
		else
		{
			return null;
		}
		
    }
}
