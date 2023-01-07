<?php

namespace app\controller;

use support\Request;

class QuickserversController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
