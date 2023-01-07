<?php

namespace app\controller;

use support\Request;

class LicensesController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
