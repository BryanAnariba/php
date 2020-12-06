<?php
    class Response {
        private $statusHttp;
        private $data;
        private $response;

        public function __construct($data) {
            $this->statusHttp = $data['status'];
            $this->data = $data['messages'];
        }

        public function responseData () {
            http_response_code($this->statusHttp);
            $this->response = array(
                'status' => $this->statusHttp,
                'data' => $this->data
            );
            
            echo json_encode($this->response);
        }
    }