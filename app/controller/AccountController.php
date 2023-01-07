<?php

namespace app\controller;

use support\Request;

class AccountController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
