<?php

namespace OpsWay\Migration\Logger;
use OpsWay\Migration\Writer\File\Csv;

class OutOfStockLogger
{

	private $conf;
	private $csvWriter;
	
	public function __construct()
	{
		$this->conf = include __DIR__ . '/../../config/logger.php';
		$this->csvWriter = new Csv(['filename' => $this->conf['out_of_stock_file']]);
		
	}

    public function __invoke($item, $status, $msg)
    {

		$this->csvWriter->write($item);
		
        if (!$status) {
            echo "Warning: " . $msg . print_r($item, true) . PHP_EOL;
        }
    }
}
