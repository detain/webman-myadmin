<?php

namespace app\controller;

use support\Request;

class WebhostingController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
