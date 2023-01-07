<?php

namespace app\controller;

use support\Request;

class DomainsController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
