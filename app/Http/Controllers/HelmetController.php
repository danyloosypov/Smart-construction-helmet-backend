<?php

namespace App\Http\Controllers;

use App\Models\Helmet;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Exports\HelmetExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\HelmetImport;
use Exception;

class HelmetController extends Controller
{
    public function getAll() {
        $helmets = Helmet::paginate(10);
        if(!empty($helmets) || $helmets != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $helmets
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No helmets found.',
                'data' => []
            ], 204);
        } 
    }

    public function getAllHelmets() {
        $helmets = Helmet::all();
        if(!empty($helmets) || $helmets != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $helmets
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No helmets found.',
                'data' => []
            ], 204);
        } 
    }

    public function getHelmetById(string $id) {
        $helmet = Helmet::findOrFail($id);
        if(!empty($helmet) || $helmet != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $helmet
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No helmet found.',
                'data' => []
            ], 204);
        }
    }

    public function getHelmetByWorkerId(string $id) {
        $helmet = Helmet::where('worker_id', $id)->first();
        if(!empty($helmet) || $helmet != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $helmet
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No helmet found.',
                'data' => []
            ], 204);
        }
    }



    public function getHelmetsWithoutWorkers() {
        $helmets = Helmet::whereNull('worker_id')->get();
        if(!empty($helmets) || $helmets != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $helmets
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No helmet found.',
                'data' => []
            ], 204);
        }
    }
    
    
    

    public function createHelmet(Request $request) {
        $helmet = new Helmet();
        $helmet->name = $request->name;
        $helmet->description = $request->description;
        $helmet->worker_id = $request->worker_id;
        $result = $helmet->save();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
            //return ["result" => "Created successfully"];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
            //return ["result" => "Failed to create"];
        }
    }

    public function updateHelmet(Request $request, string $id) {
        $helmet = Helmet::find($id);
        $helmet->name = $request->name;
        $helmet->description = $request->description;
        $helmet->worker_id = $request->worker_id;
        $result = $helmet->save();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
            //return ["result" => "Updated successfully"];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
            //return ["result" => "Failed to update"];
        }
    }

    public function setWorker(Request $request, string $id) {
        $helmet = Helmet::find($id);
        $helmet->worker_id = $request->worker_id;
        $result = $helmet->save();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
            //return ["result" => "Updated successfully"];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
            //return ["result" => "Failed to update"];
        }
    }

    public function deleteHelmet(string $id) {
        $helmet = Helmet::find($id);
        $result = $helmet->delete();
        if($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => []
            ], 200);
            //return ["result" => "Deleted successfully"];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation was failed.',
                'data' => []
            ], 500);
            //return ["result" => "Failed to delete"];
        }
    }

    public function exportExcel()
    {
        return Excel::download(new HelmetExport, 'my_export.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            $file = $request->file('file');
    
            // Import the data from the file using the WorkerImport class
            Excel::import(new HelmetImport, $file);
    
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
