<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Task;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{

    public function listToday(){

        $today = Carbon::now()->format('Y-m-d');

        $tasks = Task::where('date', $today)->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);

    }

    public function searchDay(Request $request){
        $json = $request->input('json',null);
        $param_array = json_decode($json,true);

        if(($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            $validate = \Validator::make($param_array, [
                'date'   => 'required|date'
            ], [
                'date.required' => 'El campo fecha es obligatorio.',
                'date.date' => 'El campo fecha debe ser una fecha válida.'
            ]);
            
            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Task not added',
                    'errors' => $validate->errors()
                );
    
            }else{
                $tasks = Task::where('date', $param_array['date'])->get();
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'totalTask' => $tasks->count(),
                    'tasks' => $tasks
                ]);
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Error search',
            );
        }

        return response()->json($data,$data['code']);

    }

    public function searchDayEarring(Request $request){
        $json = $request->input('json',null);
        $param_array = json_decode($json,true);

        if(($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            $validate = \Validator::make($param_array, [
                'date'   => 'required|date'
            ], [
                'date.required' => 'El campo fecha es obligatorio.',
                'date.date' => 'El campo fecha debe ser una fecha válida.'
            ]);
            
            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Task not added',
                    'errors' => $validate->errors()
                );
    
            }else{
                $tasks = Task::where('date', $param_array['date'])
                                    ->where('finished','false')
                                    ->get();
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'totalTask' => $tasks->count(),
                    'tasks' => $tasks
                ]);
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Error search',
            );
        }

        return response()->json($data,$data['code']);

    }

    public function searchDayFinished(Request $request){
        $json = $request->input('json',null);
        $param_array = json_decode($json,true);

        if(($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            $validate = \Validator::make($param_array, [
                'date'   => 'required|date'
            ], [
                'date.required' => 'El campo fecha es obligatorio.',
                'date.date' => 'El campo fecha debe ser una fecha válida.'
            ]);
            
            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Task not added',
                    'errors' => $validate->errors()
                );
    
            }else{
                $tasks = Task::where('date', $param_array['date'])
                                    ->where('finished','true')
                                    ->get();
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'totalTask' => $tasks->count(),
                    'tasks' => $tasks
                ]);
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Error search',
            );
        }

        return response()->json($data,$data['code']);

    }

    public function searchDayTwo(Request $request){
        $json = $request->input('json',null);
        $param_array = json_decode($json,true);

        if(($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            $validate = \Validator::make($param_array, [
                'dateOne'   => 'required|date',
                'dateTwo'   => 'required|date',
            ], [
                'dateOne.required' => 'El campo fecha es obligatorio.',
                'dateOne.date' => 'El campo fecha debe ser una fecha válida.',
                'dateTwo.required' => 'El campo fecha es obligatorio.',
                'dateTwo.date' => 'El campo fecha debe ser una fecha válida.'
            ]);
            
            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Task not added',
                    'errors' => $validate->errors()
                );
    
            }else{
                $tasks = Task::whereBetween('date', [$param_array['dateOne'], $param_array['dateTwo']])->get();
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'totalTask' => $tasks->count(),
                    'tasks' => $tasks
                ]);
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Error search',
            );
        }

        return response()->json($data,$data['code']);

    }

    public function addTask(Request $request){
        $json = $request->input('json',null);
        $param = json_decode($json); //devuelve un objeto
        $param_array = json_decode($json,true); //devuelve un array
        if(($param != null) &&  ($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            // validar datos
        $validate = \Validator::make($param_array, [
            'name'   => 'required|alpha_num',
            'description'   => 'required|alpha_num',
            'date'   => 'required|date',
            'finished'   => 'required|alpha',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.alpha' => 'El campo nombre solo puede contener letras del alfabeto.',
            'description.required' => 'El campo descripción es obligatorio.',
            'description.alpha' => 'El campo descripción solo puede contener letras del alfabeto.',
            'date.required' => 'El campo fecha es obligatorio.',
            'date.date' => 'El campo fecha debe ser una fecha válida.',
            'finished.required' => 'El campo finished es obligatorio.',
            'finished.alpha' => 'El campo finished solo puede contener letras del alfabeto.',
        ]);

        if($validate->fails()){
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Task not added',
                'errors' => $validate->errors()
            );

        }else{

            //crear usuario
            $task = new Task();
            $task->name = $param_array['name'];
            $task->description = $param_array['description'];
            $task->date = $param_array['date'];
            $task->finished = $param_array['finished'];
            //guardar usuario
            $task->save();
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Task add',
                'task' => $task
            );
        }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Task not added',
            );
        }
        return response()->json($data,$data['code']);
    }

    public function nowTaksFinished(){
        $today = Carbon::now()->format('Y-m-d');
        $tasks = Task::where('date', $today)
                            ->where('finished', 'true')
                            ->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);

    }

    public function nowTaksEarring(){
        $today = Carbon::now()->format('Y-m-d');
        $tasks = Task::where('date', $today)
                            ->where('finished', 'false')
                            ->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);

    }

    public function taskId($id){
        $tasks = Task::where('id', $id)
                            ->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);
    }

    public function taksEarring(){
        $today = Carbon::now()->format('Y-m-d');
        $tasks = Task::where('date','<', $today)
                            ->where('finished','false')
                            ->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'day' => $today,
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);
    }

    public function taksNext(){
        $today = Carbon::now()->format('Y-m-d');
        $tasks = Task::where('date','>', $today)
                            ->where('finished','false')
                            ->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'day' => $today,
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);
    }

    public function dayTasks($day){
        $tasks = Task::where('date', $day)
                            ->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'day' => $day,
            'totalTask' => $tasks->count(),
            'tasks' => $tasks
        ]);
    }

    public function finishedTask($id){
        $today = Carbon::now()->format('Y-m-d');
        $user_update = Task::where('id', $id)->update([
            'finished' => "true",
            'dateFinished' => $today
        ]);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'tasks' => $user_update
        ]);
    }

    public function updatedTask(Request $request){
        $json = $request->input('json',null);
        $param = json_decode($json);
        $param_array = json_decode($json,true);
        if(($param != null) &&  ($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            // validar datos
        $validate = \Validator::make($param_array, [
            'id' => 'required',
            'name'   => 'required|alpha_num',
            'description'   => 'required|alpha_num',
            'date'   => 'required|date',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.alpha' => 'El campo nombre solo puede contener letras del alfabeto.',
            'description.required' => 'El campo descripción es obligatorio.',
            'description.alpha' => 'El campo descripción solo puede contener letras del alfabeto.',
            'date.required' => 'El campo fecha es obligatorio.',
            'date.date' => 'El campo fecha debe ser una fecha válida.',
        ]);

        if($validate->fails()){
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Task not added',
                'errors' => $validate->errors()
            );

        }else{
            Task::where('id', $param_array['id'])->update($param_array);
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Task updated',
                'task' => $param_array
            );
        }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Task not added',
            );
        }
        return response()->json($data,$data['code']);
    }
}
