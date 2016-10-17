/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Resumiendo
 * Si lo que necesitamos es saber simplemente si una variable tiene el dato null o no ha sido definida, podemos utilizar el operador de negación:
 * var dato;
 * if (!dato) //true
 * 
 * Si necesitamos saber si una variable contiene realmente el dato null, hemos de utilizar el operador de identidad:
 * var dato = null;
 * if (dato === null) //true
 * 
 * Si necesitamos saber si una variable es de tipo undefined, para ello hemos de utilizar el operador typeof , el cual retorna en formato String, el nombre del tipo de dicha variable: 
 * var dato;
 * if (typeof (dato) == "undefined") //true
 * 
 */

//	VALIDACIONES 
function soloLetra(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esLetra(String.fromCharCode(tecla));
}

function esLetra(dato) {
//    expresion = /^[a-zA-Z\sÑñ]+$/;
    expresion = /^[a-zA-Z\s]+$/;
    return expresion.test(dato);
}

function soloMinuscula(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esMinuscula(String.fromCharCode(tecla));
}

function esMinuscula(dato) {
//    expresion = /^[a-z\sñ]+$/;
    expresion = /^[a-z\s]+$/;
    return expresion.test(dato);
}

function soloMinusculaNumero(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esMinusculaNumero(String.fromCharCode(tecla));
}

function esMinusculaNumero(dato) {
    expresion = /^[a-z\d\s]+$/;
    return expresion.test(dato);
}

function soloMayuscula(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esMayuscula(String.fromCharCode(tecla));
}

function esMayuscula(dato) {
    //expresion = /^[A-Z\sÑ]+$/;
    expresion = /^[A-Z\s]+$/;
    return expresion.test(dato);
}

function soloMayusculaNumero(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esMayusculaNumero(String.fromCharCode(tecla));
}

function esMayusculaNumero(dato) {    
    expresion = /^[A-Z\d\s]+$/;
    return expresion.test(dato);
}

function soloNumero(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esNumero(String.fromCharCode(tecla));
}

function esNumero(dato) {
    expresion = /^\d+$/;
    return expresion.test(dato);
}

function soloAlfanumerico(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esAlfanumerico(String.fromCharCode(tecla));
}

function esAlfanumerico(dato) {
//    expresion = /^[\w\sñÑ]+$/;
    expresion = /^[\w\s]+$/;
    return expresion.test(dato);
}

function soloAlfanumericoAcento(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esAlfanumericoAcento(String.fromCharCode(tecla));
}

function esAlfanumericoAcento(dato) {
  expresion = /^[\w\sñÑáéíóúÁÉÍÓÚ]+$/;
  return expresion.test(dato);
}



function soloDecimal(event) {
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return esDecimal(String.fromCharCode(tecla));
}

function soloEntero(){
    tecla = (document.all) ? event.keyCode : event.which;
    if (tecla < 13) {
        return true;
    }
    if (tecla === 13) {
        return false;
    }
    return validarEntero(String.fromCharCode(tecla));
}

function esDecimal(dato) {
    expresion = /[-\+,.\d]/;
    return expresion.test(dato);
}

function validarDecimal(dato) {
//    expresion = /^[-\+]?\d+[,.]?\d+$/;        // todo ok, exepto cuando es de un solo numero
//    expresion = /^([-\+]?\d|[-\+]?\d+[,|.]?\d)+$/; //  todo ok
    expresion = /^[-\+]?(\d|\d+[,|.]\d)+$/;         //  todo ok resumen
    return expresion.test(dato);
}
/*function empiezaPunto(dato) {
 //    expresion = /^(.\d+$|,\d+$)*$/;       // Ej.: .23 ó ,23 es valido
 expresion = /^(.\d+$|,\d+$)*$/;
 return expresion.test(dato);
 }*/

function validarDecimalPositivo(dato) {
//    expresion = /^\d+(?:\.\d{0,2})$/;
    expresion = /^(\d|\d+[,|.]\d)+$/;
    return expresion.test(dato);
}

function validarEntero(dato) {
    expresion = /^[-\+]?\d+$/;
    return expresion.test(dato);
}

function validarEnteroPositivo(dato) {
    expresion = /^\+?\d+$/;
    return expresion.test(dato);
}

function validarCorreo(dato) {
//    expresion = /[\w.]+@\w+\.\w{3}(\.\w{2})?/;
    expresion = /([\w-]{3})+@[a-zA-Z]+\.[a-zA-Z]{3}(\.[a-zA-Z]{2})?/;
    return expresion.test(dato);
}

function rango(min, max, dato){
    return (dato >= min && dato <= max);
}

//  Método que verifica si un string está vacío, null o undefined.
function isEmpty(dato) {
    return (!dato || 0 === dato.length);
}

//  Método que elimina los espacios iniciales y finales de la cadena, devolviendo una copia de la misma. 
function trim(dato) {
//    return dato.replace(/^\s+|\s+$/gm, "");
    return $.trim(dato);
}

//  Método que elimina todos los espacios de la cadena, devolviendo una copia de la misma.
function trimAll(dato) {
    return dato.replace(/\s/g, "");
}