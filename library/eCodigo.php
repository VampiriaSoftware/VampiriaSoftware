<?php
/***********************************
eCodigo v1.0 Copyright � 2007 - 2008
Autor: Daniel Osorio "Electros"
Web: www.electros.tk
Licencia: GNU General Public License
***********************************/

/*
* eCodigo
Esta clase permite utilizar un c�digo especial en los formularios de texto
para darle estilo a su contenido sin los riesgos que implica utilizar (X)HTML
o cualquier otro lenguaje de forma directa. Transforma los c�digos de los
caretos en im�genes y el c�digo especial en un equivalente en (X)HTML.

* Glosario
Texto c�digo - Es el texto contenido entre las etiquetas [cod] y [/cod].
Texto no c�digo - Es el texto que se encuentra fuera de las etiquetas [cod] y [/cod].
Nota: Esta clasificaci�n permite que los caretos y el c�digo especial no se aplique
al texto c�digo.

� Ejemplo de uso

$eCodigo = new eCodigo($texto) ;
$eCodigo->codigo() ; # Aplicar c�digo especial
$eCodigo->caretos() ; # Aplicar caretos
$nuevo_texto = $eCodigo->resultado() ;

Dudas u opiniones vis�tanos en www.electros.tk.
*/

class eCodigo {
	public function eCodigo($texto) {
		# > Modificar los colores por defecto de PHP para colorear c�digo (utilizados por la funci�n highlight_string() de PHP).
		@ini_set('highlight.string','#00a0a0') ; # Cadenas de texto
		@ini_set('highlight.comment','#a000a0') ; # Comentarios
		@ini_set('highlight.keyword','#0025ff') ; # Funciones y c�digo propios de PHP
		@ini_set('highlight.bg','') ; # Fondo
		@ini_set('highlight.default','#ff5000') ; # Etiquetas de apertura y cierre, funciones del usuario, variables, etc.
		@ini_set('highlight.html','#00a050') ; # C�digo HTML
		# > Se parte el texto para poder alternar entre texto c�digo y no c�digo (ver glosario).
		$this->texto = preg_split('/\[cod\](.+)\[\/cod\]/sU',$texto,-1,PREG_SPLIT_DELIM_CAPTURE) ;
	}
	# * Formatear URL
	# Si la URL supera la longitud predefinida, se corta para no descuadrar el dise�o (no se afecta el enlace real).
	public function url($url) {
		$a = $url[1] ;
		$b = count($url) == 2 ? $url[1] : $url[2] ;
		$max_car_palabra = &$GLOBALS['conf']['max_car_palabra'] ;
		if(!preg_match('/^\w{3,5}:\/\//',$a)) $a = 'http://'.$a ;
		if(strlen($b) > $max_car_palabra && !preg_match('/\[img\].+\[\/img\]/U',$b)) $b = substr($b,0,$max_car_palabra - 13).'...'.substr($b,-10) ;
		return '<a href="'.$a.'" target="_blank">'.$b.'</a>' ;
	}
	# * Colorear c�digo
	# Convierte las entidades HTML a sus caract�res reales para poder aplicar highlight_string() que colorea el c�digo
	public function colorear($texto) {
		$texto = trim($texto) ;
		$texto = str_replace(array('&lt;','&gt;','&quot;','&amp;'),array('<','>','"','&'),$texto) ;
		$texto = highlight_string($texto,1) ;
		$texto = str_replace(array("\r","\n"),'',$texto) ;
		return '<pre>'.$texto.'</pre>' ;
	}
	# * Funci�n para transformar los c�digos de los caretos en im�genes
	public function conv_caretos($texto) {
		$caretos = array(
		':alegre:' => 'alegre.gif',
		':ansioso:' => 'ansioso.gif',
		':asustado:' => 'asustado.gif',
		':burla:' => 'burla.gif',
		':confundido:' => 'confundido.gif',
		':contento:' => 'contento.gif',
		':enojado:' => 'enojado.gif',
		':guino:' => 'guino.gif',
		':incredulo:' => 'incredulo.gif',
		':llorando:' => 'llorando.gif',
		':malo:' => 'malo.gif',
		':malo_sonriendo:' => 'malo_sonriendo.gif',
		':relajado:' => 'relajado.gif',
		':riendo:' => 'riendo.gif',
		':sonriendo:' => 'sonriendo.gif',
		':sonrojado:' => 'sonrojado.gif',
		':sorprendido:' => 'sorprendido.gif',
		':triste:' => 'triste.gif'
		) ;
		foreach($caretos as $a => $b) {
			$texto = str_replace($a,'<img src="' . BASEURL . 'public/img/caretos/'.$b.'" border="0" width="15" height="15" align="top" />',$texto) ;
		}
		return $texto ;
	}
	# * Funci�n para convertir el c�digo especial a un equivalente en HTML y colorear el texto entre [cod] y [/cod]
	public function conv_codigo($texto) {
		# > Reemplaza [etiqueta] por <etiqueta>.
		$etiquetas = array(
		'[b]'    => '<b>',
		'[/b]'   => '</b>',
		'[i]'    => '<i>',
		'[/i]'   => '</i>',
		'[u]'    => '<span style="text-decoration: underline">',
		'[/u]'   => '</span>'
		) ;
		foreach($etiquetas as $a => $b) {
			$texto = str_replace($a,$b,$texto) ;
		}
		# > Reemplaza usando tambi�n expresiones regulares.
		$texto = preg_replace_callback('/\[url\](.+)\[\/url\]/U',array($this,'url'),$texto) ;
		$texto = preg_replace_callback('/\[url=(.+)\](.+)\[\/url\]/U',array($this,'url'),$texto) ;
		$texto = preg_replace('/\[email\](.+)\[\/email\]/U','<a href="mailto:$1" class="eforo_enlace">$1</a>',$texto) ;
		$texto = preg_replace('/\[img\](.+)\[\/img\]/U','<img src="$1" border="0" alt="Imagen obtenida de $1" />',$texto) ;
		$texto = preg_replace('/\[color=(#?[a-z0-9]+)\]/','<span style="color: $1">',$texto) ;
		$texto = str_replace('[/color]','</span>',$texto) ;
		$texto = str_replace('[citar]','<div class="eforo_tabla_citar">',$texto) ;
		$texto = preg_replace('/\[citar autor=(.+)\]/','<div class="eforo_tabla_citar">Escrito originalmente por: <b>$1</b><hr class="separador" />',$texto) ;
		$texto = str_replace('[/citar]','</div>',$texto) ;
		$texto = preg_replace('/\[you\](.*?)\[\/you\]/is','<embed src="http://www.youtube.com/v/$1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed>',$texto);
		return $texto ;
	}
	# * Aplicar la funci�n colorear() al texto c�digo y conv_codigo() al texto no c�digo
	public function codigo() {
		$t = count($this->texto) ;
		for($i = 0 ; $i < $t ; $i++) {
			$this->texto[$i] = ($i % 2 == 0) ? $this->conv_codigo($this->texto[$i]) : $this->colorear($this->texto[$i]) ;
		}
	}
	# * Aplicar la funci�n conv_caretos() al texto no c�digo
	public function caretos() {
		$t = count($this->texto) ;
		for($i = 0 ; $i < $t ; $i++) {
			$this->texto[$i] = ($i % 2 == 0) ? $this->conv_caretos($this->texto[$i]) : $this->texto[$i] ;
		}
	}
	# * Devolver el texto modificado
	public function resultado() {
		return implode('',$this->texto) ;
	}
}
?>
