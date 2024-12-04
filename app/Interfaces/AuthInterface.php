<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function register(array $data);
    public function checkOtpCode($data);
    public function login(array $data);
}
