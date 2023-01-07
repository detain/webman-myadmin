<?php

namespace app\controller;

use support\Request;
use support\Db;
use Respect\Validation\Validator as v;

class VpsController
{
    public function index(Request $request)
    {
        $accountInfo = $request->accountInfo;
        $where = [];
        $where[] = ['vps_custid', '=', $accountInfo->account_id];
        $total = Db::table('vps')
            ->where($where)
            ->count();
        $vps = Db::table('vps')
            ->where($where)
            ->get();
        $return = $vps->all();
        return json($return);
    }

}
