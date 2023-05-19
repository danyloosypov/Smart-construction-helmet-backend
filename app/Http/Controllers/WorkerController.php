<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Helmet;
use Illuminate\Support\Facades\Response;
use App\Exports\WorkerExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkerImport;
use Exception;
use Illuminate\Support\Facades\Auth;


class WorkerController extends Controller
{
    public function getAll() {
        $workers = Worker::paginate(10);

        if(!empty($workers) || $workers != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $workers
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No workers found.',
                'data' => []
            ], 204);
        }
    }

    public function getWorkerByHelmetId(string $id) {
        $helmet = Helmet::findOrFail($id);
        if ($helmet->worker_id !== null) {
            $worker = Worker::findOrFail($helmet->worker_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $worker
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No worker found for the given helmet ID.',
                'data' => []
            ], 204);
        }
    }

    public function getWorkersWithoutHelmets()
    {
        $workersWith = Helmet::whereNotNull('worker_id')->pluck('worker_id');

        $workersWithout = Worker::whereNotIn('id', $workersWith)->get();

        if ($workersWithout->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No workers without helmets found.',
                'data' => []
            ], 204);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Operation completed successfully.',
            'data' => $workersWithout
        ], 200);
    }


    public function getWorkerById(string $id) {
        $worker = Worker::find($id);

        if(!empty($worker) || $worker != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $worker
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No worker found.',
                'data' => []
            ], 204);
        }
    }


    public function createWorker(Request $request) {
        $worker = new Worker();
        $worker->name = $request->name;
        $worker->username = $request->username;
        $worker->password = $request->password;
        $result = $worker->save();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => ['id' => $worker->id]
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
        }
    }

    public function updateWorker(Request $request, string $id) {
        $worker = Worker::find($id);
        $worker->name = $request->name;
        $worker->username = $request->username;
        $worker->password = $request->password;
        $result = $worker->save();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
        }
    }

    public function deleteWorker(string $id) {
        $worker = Worker::find($id);
        $result = $worker->delete();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
        }
    }

    public function loginWorker(Request $request)
    {
        $worker = Worker::where('username', $request->username)
            ->where('password', $request->password)
            ->first();

        if ($worker !== null) {
            $token = $worker->createToken('myapptoken')->plainTextToken;
            $workerId = $worker->id;

            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => [
                    'token' => $token,
                    'worker_id' => $workerId,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation failed. Invalid credentials.',
                'data' => [],
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.',
            'data' => []
        ], 200);
    }




    public function exportExcel()
    {
        return Excel::download(new WorkerExport, 'my_export.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            $file = $request->file('file');
    
            // Import the data from the file using the WorkerImport class
            Excel::import(new WorkerImport, $file);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
        } catch (Exception $e) {
            // Handle the exception, e.g. log it, display an error message, etc.
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to import data. Please check the file format or try again later.',
                'data' => []
            ], 500);
        }
    }

}
