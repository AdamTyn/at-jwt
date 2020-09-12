<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Exceptions\NonConfigureException;

class Config
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var string
     */
    protected $defaultFile = '.env.example';

    /**
     * Config constructor.
     * @throws NonConfigureException
     */
    protected function __construct()
    {
        $data = parse_ini_file($this->fileName());

        if ($data === false) {
            throw new NonConfigureException;
        }

        $this->data = $data;
    }

    /**
     * @return Config
     */
    protected static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function getValue(string $key)
    {
        return self::getInstance()->data[$key] ?? null;
    }

    /**
     * @return string
     */
    public function fileName()
    {
        $fileName = root_path('.env');

        if (!file_exists($fileName)) {
            return $this->defaultFile;
        }

        return $fileName;
    }
}