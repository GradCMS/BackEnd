<?php

namespace App\Http\RepoInterfaces;

interface RepoRegisteryInterface
{
    public function register(string $key, CRUDRepoInterface $concrete);
    public function get(string $key);
}
