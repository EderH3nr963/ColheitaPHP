<?php

class HomeController{
    public function index() {
        unset($_SESSION['usuario']);
    }
};