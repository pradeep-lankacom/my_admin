<?php

namespace App\Repositories\Contracts;

interface AdminInterface
{
    public function getUsersByRole($role);

    public function getUserList();
}
