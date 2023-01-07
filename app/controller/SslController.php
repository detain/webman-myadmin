<?php

namespace app\controller;

use support\Request;

class SslController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
