<?php

    namespace app\connectors;

    interface DatabaseConnector {
        public function getConnection();
    }