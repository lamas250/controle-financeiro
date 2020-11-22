<?php

namespace DB;

use PDO;

class Conection
{
    private static $instance = null;

    private function __contruct()
    {

    }

    public static function getInstance()
    {
        if(is_null(self::$instance)) {
			self::$instance = new \PDO('mysql:dbname=myexpense;host=127.0.0.1', 'igorlamas', 'Q1w2e3r4!');
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			self::$instance->exec('SET NAMES UTF8');
		}

		return self::$instance;
    }
}