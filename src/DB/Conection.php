<?php

namespace DB;

class Conection
{
    private static $instance = null;

    private function __contruct()
    {

    }

    public static function getInstance()
    {
        if(is_null(self::$instance)) {
			self::$instance = new \PDO('mysql:dbname=formacao_php;host=127.0.0.1', 'igorlamas', 'Q1w2e3r4!');

			self::$instance->exec('SET NAMES UTF8');
		}

		return self::$instance;
    }
}