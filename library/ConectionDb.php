<?php

/** 
 * ConectionDb.php
 * Clase para conexiones a bases de datos MySql por medio del patrón de diseño Singleton
 * @copyright (c) 2014 Vampiria Software
 * @author Lestat de Lioncourt
 * @version 1.0
 * @link http://www.vampiriasoftware.tk
 */


class ConectionDb {
	private $_dbh;
	private $_username = 'root';
	private $_password = '';
	private $_dsn = 'mysql:host=localhost;dbname=inventarios';
	private static $_instance = null;
	
	/**
	 * Método que comprueba si existe instancia de la clase y si no la crea
	 * @return ConectionDb
	 */
	public static function getInstance(){
		if (!(self::$_instance instanceof ConectionDb)){
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Método constructor, crea la conexión a la base de datos
	 */
	private function __construct(){
		try{
			$this->_dbh = new PDO($this->_dsn, $this->_username, $this->_password);
		}catch(PDOException $e){
			echo 'Hubo un error al conectarse a la base de datos. Error reportado: ' . $e->getMessage();
			die();
		}
	}
	
	/**
	 * Método que retorna el objeto con la conexión a la base de datos
	 * @return PDO
	 */
	public function getCon(){
		if ($this->_dbh === null){
			self::getInstance();
		}
		
		return $this->_dbh;
	}
	
	/**
	 * Método destructor, cierra la conexión a la base de datos
	 */
	public function __destruct(){
		$this->_dbh = null;
	}
}
