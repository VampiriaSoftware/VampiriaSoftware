<?php

/** 
 * Helpers.php
 * Clase con métodos comunes para el sistema
 * @copyright (c) 2014 Vampiria Software
 * @author Lestat de Lioncourt
 * @version 1.0
 * @link http://www.vampiriasoftware.tk
 * 
 */
class Helpers {
	
	/**
	 * Método para cortar una palabra o frase
	 *
	 * @param string $word        	
	 * @param int $number        	
	 * @return string
	 */
	public static function cutWord($word, $number) {
		$string = substr ( $word, 0, $number );
		return $string;
	}
	
	/**
	 * Método para validar direcciones de correo electrónico
	 * 
	 * @param string $email        	
	 * @return boolean
	 */
	public static function emailValido($email) {
		$mail_correcto = 0;
		// compruebo unas cosas primeras
		if ((strlen ( $email ) >= 6) && (substr_count ( $email, "@" ) == 1) && (substr ( $email, 0, 1 ) != "@") && (substr ( $email, strlen ( $email ) - 1, 1 ) != "@")) {
			if ((! strstr ( $email, "'" )) && (! strstr ( $email, "\"" )) && (! strstr ( $email, "\\" )) && (! strstr ( $email, "\$" )) && (! strstr ( $email, " " ))) {
				// miro si tiene caracter .
				if (substr_count ( $email, "." ) >= 1) {
					// obtengo la terminacion del dominio
					$term_dom = substr ( strrchr ( $email, '.' ), 1 );
					// compruebo que la terminacion del dominio sea correcta
					if (strlen ( $term_dom ) > 1 && strlen ( $term_dom ) < 5 && (! strstr ( $term_dom, "@" ))) {
						// compruebo que lo de antes del dominio sea correcto
						$antes_dom = substr ( $email, 0, strlen ( $email ) - strlen ( $term_dom ) - 1 );
						$caracter_ult = substr ( $antes_dom, strlen ( $antes_dom ) - 1, 1 );
						if ($caracter_ult != "@" && $caracter_ult != ".") {
							$mail_correcto = 1;
						}
					}
				}
			}
		}
		if ($mail_correcto)
			return true;
		else
			return false;
	}
	
	/**
	 * Método para validar datos vacios
	 * 
	 * @param array $data        	
	 * @return boolean
	 */
	public static function validData($data) {
		$empty = "";
		
		foreach ( $data as $d ) {
			if ($d == $empty) {
				return false;
			}
		}
		
		return true;
	}
}