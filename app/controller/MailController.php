<?php

namespace app\controller;

use support\Request;

class MailController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
