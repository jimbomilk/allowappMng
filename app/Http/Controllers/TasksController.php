<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:owner');
    }

    public function index(Request $request)
    {
        $groups = ["Todos los grupos"];
        $groups += $request->user()->getGroups()->pluck('name','id')->toArray();
        $group_id  = $request->get('group');

        $tasks = Task::all()->whereIn('group_id', $request->user()->getGroups()->pluck('id'))->sortBy(function ($element) {
            return $element->done.$element->priority;
        });
        return view('common.index', [ 'name' => 'tasks','hide_new'=>!$request->user()->checkRole('admin'), 'set' => $tasks,'groups'=>$groups,'group'=>$group_id]);
    }

    public function sendView(Request $request,$element=null)
    {
        $groups = $request->user()->getGroups()->pluck('name','id');
        if (isset($element)) {
            return view('common.edit', ['name' => 'tasks', 'element' => $element, 'groups'=>$groups]);
        }
        else
            return view('common.create',['name'=>'tasks', 'groups'=>$groups]);
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }

    /**
     * @param CreateTaskRequest $request
     * @param $location
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateTaskRequest $request,$location)
    {
        $task = new Task($request->all());
        $task->save();
        return redirect('tasks');
    }

    public function edit(Request $request,$location,$id)
    {
        $task = Task::find($id);
        if (isset ($task))
        {
            return $this->sendView($request,$task);
        }

    }


    /**
     * @param EditTaskRequest $request
     * @param $location
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EditTaskRequest $request, $location , $id)
    {
        $task = Task::find($id);
        if (isset($task)) {
            $task->fill($request->all());
            $task->save();
        }

        return redirect('tasks');
    }

    public function destroy($location,$id,Request $request)
    {
        $task = Task::findOrFail($id);

        $task->delete();
        $message = $task->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Task::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect('tasks');
    }

}
