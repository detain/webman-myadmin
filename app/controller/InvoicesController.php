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
        $limit = $request->get('limit', 1000);
        $skip = $request->get('skip', 0);
        $search = $request->get('search', '');
        $startDate = $request->get('startDate', null);
        $endDate = $request->get('endDate', null);
        if (!v::anyOf(v::dateTime('Y-m-d H:i:s'), v::nullType())->validate($startDate))
            return jsonErrorResponse('The specified startDate value '.var_export($startDate,true).' was invalid.', 400);
        if (!v::anyOf(v::dateTime('Y-m-d H:i:s'), v::nullType())->validate($endDate))
            return jsonErrorResponse('The specified endDate value '.var_export($endDate,true).' was invalid.', 400);
        if (!v::intVal()->validate($skip))
            return jsonErrorResponse('The specified skip value was invalid.', 400);
        if (!v::intVal()->positive()->max(10000)->validate($limit))
            return jsonErrorResponse('The specified limit value was invalid.', 400);
        $where = [];
        $where[] = ['invoices_custid', '=', $accountInfo->account_id];
        $where[] = ['invoices_deleted', '=', 0];
        if (!is_null($startDate))
            $where[] = ['invoices_date', '>=', $startDate];
        if (!is_null($endDate))
            $where[] = ['invoices_date', '<=', $endDate];
        $total = Db::table('invoices')
            ->where($where)
            ->count();
        $return = [
            'total' => $total,
            'skip' => $skip,
            'limit' => $limit,
            'invoices' => []
        ];
        $invoices = Db::table('invoices')
            ->where($where)
            ->select('invoices_id as id', 'invoices_description as description', 'invoices_amount as amount', 'invoices_type as type', 'invoices_date as date', 'invoices_extra as extra', 'invoices_paid as paid', 'invoices_module as module', 'invoices_due_date as due_date', 'invoices_service as service', 'invoices_currency as currency')
            ->offset($skip)
            ->limit($limit)
            ->get();
        $return['invoices'] = $invoices->all();
        return json($return);
    }

    public function get(Request $request, $id)
    {
        $accountInfo = $request->accountInfo;
        if (!v::intVal()->validate($id))
            return jsonErrorResponse('The specified id was invalid.', 400);
        $return = Db::table('invoices')
            ->where('invoices_custid', '=', $accountInfo->account_id)
            ->where('invoices_id', '=', $id)
            ->select('invoices_id as id', 'invoices_description as description', 'invoices_amount as amount', 'invoices_type as type', 'invoices_date as date', 'invoices_extra as extra', 'invoices_paid as paid', 'invoices_module as module', 'invoices_due_date as due_date', 'invoices_service as service', 'invoices_currency as currency')
            ->first();
        return json($return);
    }
}
