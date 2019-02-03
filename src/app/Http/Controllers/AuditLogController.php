<?php

namespace App\Http\Controllers;

use App\AuditLog;

class AuditLogController extends BaseController
{

    public function viewAuditLog()
    {
        if (!$this->request->auth->isAdmin) {
            return response('Access denied', 401);
        }

        $this->logAuditLogRecord('get', 'Requested audit log');
        return response()->json(AuditLog::all(), 201);
    }
}