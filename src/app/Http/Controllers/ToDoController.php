<?php

namespace App\Http\Controllers;

use App\ToDo;
use App\User;

class ToDoController extends BaseController
{
    public function getAllToDo()
    {
        if (!$this->request->auth->isAdmin) {
            return response('Access denied', 401);
        }
        $this->logAuditLogRecord('get', 'Requested all to do list');
        return response()->json(ToDo::all(), 201);
    }

    public function getAllMyToDo()
    {
        $this->logAuditLogRecord('get', 'Requested self to do list');
        return response()->json(ToDo::where('userId', '=', $this->request->auth->id)->get(), 201);
    }

    public function createToDo()
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $toDo = User::find($this->request->auth->id)->todo()->Create($this->request->all());
        $this->logAuditLogRecord('create', sprintf('Created todo: %s', $this->request->get('name')));
        return response()->json($toDo, 201);
    }

    public function editToDoById($id)
    {
        $this->validate($this->request, [
            'name' => 'required'
        ]);

        $toDo = ToDo::findOrFail($id);

        if ($toDo->userId != $this->request->auth->id) {
            return response('Access denied', 401);
        }

        $toDo->update($this->request->all());
        $this->logAuditLogRecord('update', sprintf('Updated todo: %s', $this->request->get('name')));
        return response()->json($toDo, 200);
    }


    public function deleteToDoById($id) {

        if (!$this->request->auth->isAdmin) {
            return response('Access denied', 401);
        }

        $todo = Todo::findOrFail($id);
        $this->logAuditLogRecord('delete', sprintf('Deleted todo "%s" from user with id %s', $todo->name, $todo->userId));
        $todo->delete();
        return response('Deleted Successfully', 200);
    }

}