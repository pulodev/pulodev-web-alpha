<?php

namespace App\Repositories\Interfaces;

interface LinkRepository 
{
    public function search(string $query = '');
}