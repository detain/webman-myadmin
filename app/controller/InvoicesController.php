<?php

namespace app\controller;

use support\Request;
use support\Response;
use support\Db;
use Respect\Validation\Validator as v;

class InvoicesController
{
    /**
    * returns a json response
    *
    * @param array $body array of data to pass
    * @param int $status status code
    * @return \support\Response
    */
    public function jsonResponse($body, $status = 200) : Response {
        return new Response($status, ['Content-Type' => 'application/json'], \json_encode($body, JSON_UNESCAPED_UNICODE));
    }

    /**
    * returns a json error response
    *
    * @param string $message the error details
    * @param int $status the error code
    * @return \support\Response
    */
    public function jsonErrorResponse($message, $status = 200) : Response {
        return new Response($status, ['Content-Type' => 'application/json'], \json_encode(['code' => $status, 'message' => $message], JSON_UNESCAPED_UNICODE));
    }

    public function index(Request $request)
    {
        $accountInfo = $request->accountInfo;
        $limit = $request->get('limit', 1000);
        $skip = $request->get('skip', 0);
        $search = $request->get('search', '');
        $startDate = $request->get('startDate', null);
        $endDate = $request->get('endDate', null);
        if (!v::anyOf(v::dateTime('Y-m-d H:i:s'), v::nullType())->validate($startDate))
            return $this->jsonErrorResponse('The specified startDate value '.var_export($startDate,true).' was invalid.', 400);
        if (!v::anyOf(v::dateTime('Y-m-d H:i:s'), v::nullType())->validate($endDate))
            return $this->jsonErrorResponse('The specified endDate value '.var_export($endDate,true).' was invalid.', 400);
        if (!v::intVal()->validate($skip))
            return $this->jsonErrorResponse('The specified skip value was invalid.', 400);
        if (!v::intVal()->positive()->max(10000)->validate($limit))
            return $this->jsonErrorResponse('The specified limit value was invalid.', 400);
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
