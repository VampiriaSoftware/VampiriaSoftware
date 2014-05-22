/**
* nosotros.js
* Funciones para la sección de quienes somos
* @copyright Copyright (c) 2014 
* @author José Francisco Montaño Andriano
* @version 1.0
* @link http://www.vampiriasoftware.tk
*/


$(document).on('ready',function(){
	$('#mision').hide();
	$('#vision').hide();
	$('#valores').hide();
	$('#quienes').show();
});

$('#quienesLink').on('click',function(){
	$(this).addClass('active');
	$('#misionLink').removeClass('active');
	$('#visionLink').removeClass('active');
	$('#valoresLink').removeClass('active');
	$('#mision').hide();
	$('#vision').hide();
	$('#valores').hide();
	$('#quienes').show();
});

$('#misionLink').on('click',function(){
	$(this).addClass('active');
	$('#quienesLink').removeClass('active');
	$('#visionLink').removeClass('active');
	$('#valoresLink').removeClass('active');
	$('#mision').show();
	$('#vision').hide();
	$('#valores').hide();
	$('#quienes').hide();
});

$('#visionLink').on('click',function(){
	$(this).addClass('active');
	$('#quienesLink').removeClass('active');
	$('#misionLink').removeClass('active');
	$('#valoresLink').removeClass('active');
	$('#mision').hide();
	$('#vision').show();
	$('#valores').hide();
	$('#quienes').hide();
});

$('#valoresLink').on('click',function(){
	$(this).addClass('active');
	$('#quienesLink').removeClass('active');
	$('#visionLink').removeClass('active');
	$('#misionLink').removeClass('active');
	$('#mision').hide();
	$('#vision').hide();
	$('#valores').show();
	$('#quienes').hide();
});