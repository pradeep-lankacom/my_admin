<?php

namespace App\Repositories\Contracts;

interface PermissionInterface
{
    public function getPermissionList();

    public function show($id);

    public function edit($id);

    public function store($data);

    public function getPermissionListWB();

    public function getPermissionBySlug($slug);
}
