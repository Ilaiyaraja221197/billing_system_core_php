<?php

namespace App;

use mysqli;
use Dotenv\Dotenv;

class Database
{
	private $host;
	private $db;
	private $user;
	private $pass;
	private $mysqli;

	public function __construct()
	{
		$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
		$dotenv->load();

		$this->host = $_ENV['DB_HOST'];
		$this->db = $_ENV['DB_NAME'];
		$this->user = $_ENV['DB_USER'];
		$this->pass = $_ENV['DB_PASS'];
	}

	public function connect()
	{
		$this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);

		if ($this->mysqli->connect_error) {
			die("Connection failed: " . $this->mysqli->connect_error);
		}

		return $this->mysqli;
	}
}
