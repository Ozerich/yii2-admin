<?php

namespace ozerich\admin\interfaces;

interface IAdminUser
{
    public function checkAdminLogin($login, $password);

    public function getDashboardName();
}