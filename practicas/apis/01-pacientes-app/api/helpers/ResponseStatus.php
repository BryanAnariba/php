<?php
    class ResponseStatus {
        private $statusHttp;
        private $data;
        private $response;

        public function __construct($statusHttp, $data) {
            $this->statusHttp = $statusHttp;
            $this->data = $data;
        }

        public function responseData () {
            http_response_code($this->statusHttp);
            if ($this->data != []) {
                $this->response = array(
                    'status' => $this->statusHttp,
                    'data' => $this->data
                );
            } else {
                $this->response = array(
                    'status' => $this->statusHttp,
                    'data' => array(
                        'message' => 'No hay resultados'
                    )
                );
            }
            
            echo json_encode($this->response);
        }
    }