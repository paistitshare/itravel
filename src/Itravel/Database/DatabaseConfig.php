<?php

namespace Itravel\Database;

class DatabaseConfig
{

    /**
     * Database host
     * @var string
     */
    private $driver;

    /**
     * Database host
     * @var string
     */
    private $host;

    /**
     * Database name
     * @var string
     */
    private $database;

    /**
     * Database user
     * @var string
     */
    private $username;

    /**
     * Database password
     * @var string
     */
    public $password;

    public function __construct()
    {
        $parsedConfig = $this->getParsedConfig();

        if ($parsedConfig) {
            $this->driver = $parsedConfig->driver;
            $this->host = $parsedConfig->host;
            $this->database = $parsedConfig->database;
            $this->username = $parsedConfig->username;
            $this->password = $parsedConfig->password;
        }
    }

    /**
     * @return mixed
     */
    private function getConfig() {
        return yaml_parse_file('database.yml');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function getParsedConfig() {
        $parsedConfig = $this->getConfig();

        if ($parsedConfig) {
            if ($parsedConfig->ENVIRONMENT) {
                return $parsedConfig;
            } else {
                throw new \Exception('No database conifg is present for current environment');
            }
        } else {
            throw new \Exception('No database.yml config file provided');
        }
    }

    public function getDriver() {
        return $this->driver;
    }

    public function getHost() {
        return $this->host;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
}