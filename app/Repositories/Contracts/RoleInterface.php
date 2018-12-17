<?php

namespace App\Repositories\Contracts;

interface RoleInterface
{
  public function getRolesToUsers();

  public function getRolesDetails();
}
