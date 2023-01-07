<?php

namespace app\controller;

use support\Request;

class BackupsController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
