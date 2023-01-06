<?php

namespace app\controller;

use support\Request;
use support\Db;
use Respect\Validation\Validator as v;

class InvoicesController
{
    public function index(Request $request)
    {
        $accountInfo = $request->accountInfo;
        $limit = $request->get('limit', 100);
        $skip = $request->get('skip', 0);
        $search = $request->get('search', '');
        $startDate = $request->get('startDate', null);
        $endDate = $request->get('endDate', null);
        if (!v::anyOf(v::intVal(), v::nullType())->validate($startDate))
            return new Response(400, ['Content-Type' => 'application/json'], json_encode(['code' => 400, 'message' => 'The specified startDate value '.var_export($startDate).' was invalid.'], JSON_UNESCAPED_UNICODE));
        if (!v::anyOf(v::intVal(), v::nullType())->validate($endDate))
            return new Response(400, ['Content-Type' => 'application/json'], json_encode(['code' => 400, 'message' => 'The specified endDate value '.var_export($endDate).' was invalid.'], JSON_UNESCAPED_UNICODE));
        if (!v::intVal()->validate($skip))
            return new Response(400, ['Content-Type' => 'application/json'], json_encode(['code' => 400, 'message' => 'The specified skip value was invalid.'], JSON_UNESCAPED_UNICODE));
        if (!v::intVal()->validate($limit))
            return new Response(400, ['Content-Type' => 'application/json'], json_encode(['code' => 400, 'message' => 'The specified limit value was invalid.'], JSON_UNESCAPED_UNICODE));
        $where = [];
        $where[] = ['invoices_custid', '=', $accountInfo->account_id];
        $where[] = ['invoices_deleted', '=', 0];
        if (!is_null($startDate))
            $where[] = ['invoices_date', '>=', date('Y-m-d H:i:s', $startDate)];
        if (!is_null($endDate))
            $where[] = ['invoices_date', '<=', date('Y-m-d H:i:s', $endDate)];
        $total = Db::table('invoices')
            ->where($where)
            ->count();
        //error_log('Mail Total:'.$total);
        $return = [
            'total' => $total,
            'skip' => $skip,
            'limit' => $limit,
            'invoices' => []
        ];
        $invoices = Db::table('invoices')
            ->where($where)
            ->select('invoices_id', 'invoices_description', 'invoices_amount', 'invoices_type', 'invoices_date', 'invoices_extra', 'invoices_paid', 'invoices_module', 'invoices_due_date', 'invoices_service', 'invoices_currency')
            ->offset($skip)
            ->limit($limit)
            ->get();
        $return['invoices'] = $invoices->all();
        return json($return);
    }

}
