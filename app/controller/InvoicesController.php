<?php

namespace app\controller;

use support\Request;

class InvoicesController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
