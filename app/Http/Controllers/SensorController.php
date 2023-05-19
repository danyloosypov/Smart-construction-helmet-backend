<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Exports\SensorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SensorImport;
use Exception;

class SensorController extends Controller
{
    public function getAll() {
        $sensors = Sensor::paginate(10);
        if(!empty($sensors) || $sensors != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $sensors
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No sensors found.',
                'data' => []
            ], 204);
        } 
    }

    public function getAllSensors() {
        $sensors = Sensor::all();
        if(!empty($sensors) || $sensors != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $sensors
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No sensors found.',
                'data' => []
            ], 204);
        } 
    }

    public function getSensorById(string $id) {
        $sensor = Sensor::find($id);

        if(!empty($sensor) || $sensor != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $sensor
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No sensor found.',
                'data' => []
            ], 204);
        }
    }

    public function createSensor(Request $request) {
        $sensor = new Sensor();
        $sensor->name = $request->name;
        $sensor->description = $request->description;
        $result = $sensor->save();
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

    public function updateSensor(Request $request, string $id) {
        $sensor = Sensor::find($id);
        $sensor->name = $request->name;
        $sensor->description = $request->description;
        $result = $sensor->save();
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

    public function deleteSensor(string $id) {
        $sensor = Sensor::find($id);
        $result = $sensor->delete();
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

    public function exportExcel()
    {
        return Excel::download(new SensorExport, 'my_export.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            $file = $request->file('file');
    
            // Import the data from the file using the WorkerImport class
            Excel::import(new SensorImport, $file);
    
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
