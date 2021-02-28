<?php
Header("Access-Control-Allow-Origin: http://host2.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");

session_start();
session_unset();

echo json_encode(array('ok'=>true));
