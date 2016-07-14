<?php
/**
 * Esta clase es el marco para manejar los archivos ini.
 */
define('__INIDRIVER__', 123);

    class Inidriver
    {
        private $dirini = '../config/'; //ubicacion por defecto del archivo ini
            private $nameini = 'config.ini'; //nombre por defecto del archivo ini
            private $inifile = []; //los datos del archivo ini en formato array
            public $error;

        public function __construct($ruta = '')
        {
            if ($ruta == '') {
                $locatefileini = $this->dirini.$this->nameini;
            } else {
                $locatefileini = $ruta;
            }
            try {
                $this->inifile = parse_ini_file($locatefileini, true);
            } catch (Exception $e) {
                $this->error = 'Ruta incorrecta||revise permisos';
            }
        }

        /*retorna un array multidimensional del archivo ini enviado por parametros o por defecto*/
        public function getIniFile()
        {
            return $this->inifile;
        }

        /*funcion no testeada requiere
         * $arrayini (la matriz de donde se sacaran los datos)
         * la ubicacion exacta de donde se escribiria el archivo
         * Si la matriz tiene mas de una seccion para configuracion por defecto si
         * */
        public function SetiniFile($arrayini, $archivo, $multi_secciones = true)
        {
            $salida = '';
            if (PHP_OS == 'WINNT') {
                define('SALTO', "\r\n");
            } else {
                define('SALTO', "\n");
            }
            if (!is_array(current($arrayini))) {
                $tmp = $arrayini;
                $arrayini['tmp'] = $tmp; // no importa el nombre de la sección, no se usará
                 unset($tmp);
            }
            foreach ($arrayini as $clave => $matriz_interior) {
                if ($multi_secciones) {
                    $salida .= '['.$clave.']'.SALTO;
                }
                foreach ($matriz_interior as $clave2 => $valor) {
                    $salida .= $clave2.' = "'.$valor.'"'.SALTO;
                }

                if ($multi_secciones) {
                    $salida .= SALTO;
                }
            }
            $puntero_archivo = fopen($archivo, 'w');
            if ($puntero_archivo !== false) {
                $escribo = fwrite($puntero_archivo, $salida);

                if ($escribo === false) {
                    $devolver = -2;
                } else {
                    $devolver = $escribo;
                }
                fclose($puntero_archivo);
            } else {
                $devolver = -1;
            }

            return $devolver;
        }
    }
