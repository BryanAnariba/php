<?php
    class Email {
        private $para;
        private $titulo;
        private $mensaje;
        private $cabeceraMensaje;

        public function  __construct($para, $titulo, $mensaje, $cabeceraMensaje) {
            $this->para = $para;
            $this->titulo = $titulo;
            $this->mensaje = $mensaje;
            $this->cabeceraMensaje = $cabeceraMensaje;
        }

        public function enviarEmail () {
            
        }
    }