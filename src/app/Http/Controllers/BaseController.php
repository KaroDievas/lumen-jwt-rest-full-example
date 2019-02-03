<?php

namespace App\Http\Controllers;


use App\User;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function logAuditLogRecord($actionType, $action)
    {
        User::find($this->request->auth->id)->auditLog()->Create(['actionType' => $actionType, 'action' => $action]);
    }
}