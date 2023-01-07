<?php

namespace app\controller;

use support\Request;

class ServersController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
