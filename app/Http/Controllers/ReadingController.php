<?php

namespace App\Http\Controllers;

use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReadingExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ReadingImport;
use Exception;

class ReadingController extends Controller
{
    public function getAll() {
        $readings = Reading::all();

        if(!empty($readings) || $readings != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $readings
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No readings found.',
                'data' => []
            ], 204);
        } 
    }

    public function getReadingById(string $id) {
        $reading = Reading::find($id);
        if(!empty($reading) || $reading != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $reading
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No reading found.',
                'data' => []
            ], 204);
        }
    }

    public function getLastCoordinates(string $id)
    {
        $reading = Reading::where('sensor_id', 5)
                        ->where('helmet_id', $id)
                        ->latest()
                        ->first();
        
        if ($reading) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $reading
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No reading found.',
                'data' => []
            ], 204);
        }
    }


    public function createReading(Request $request) {
        $reading = new Reading();
        $reading->sensor_value = $request->sensor_value;
        $reading->sensor_id = $request->sensor_id;
        $reading->helmet_id = $request->helmet_id;
        $result = $reading->save();
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

    public function updateReading(Request $request, string $id) {
        $reading = Reading::find($id);
        $reading->sensor_value = $request->sensor_value;
        $reading->sensor_id = $request->sensor_id;
        $reading->helmet_id = $request->helmet_id;
        $result = $reading->save();
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

    public function deleteReading(string $id) {
        $reading = Reading::find($id);
        $result = $reading->delete();
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


    public function getReadings(Request $request) {
        $sensor_ids = $request->input('sensor_id');
        $helmet_ids = $request->input('helmet_id');
        $minValue = $request->input('min_value');
        $maxValue = $request->input('max_value');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $readings = Reading::query();

        if(!is_null($startDate)) {
            $readings = $readings->where('created_at', '>=', $startDate);
        }

        if(!is_null($endDate)) {
            $readings = $readings->where('created_at', '<=', $endDate);
        }
    
        if (!is_null($helmet_ids)) {
            $readings = $readings->whereIn('helmet_id', $helmet_ids);
        }
    
        if (!is_null($sensor_ids)) {
            $readings = $readings->whereIn('sensor_id', $sensor_ids);
        }
    
        $readings = $readings->when($minValue !== null, function ($query) use ($minValue) {
                return $query->where('sensor_value', '>=', $minValue);
            })
            ->when($maxValue !== null, function ($query) use ($maxValue) {
                return $query->where('sensor_value', '<=', $maxValue);
            })
            ->paginate(50);

            if(!empty($readings) || $readings != null) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Operation completed successfully.',
                    'data' => $readings
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No readings found.',
                    'data' => []
                ], 204);
            } 

    }
    
    

    public function getStatistics(Request $request) {
        $sensor_id = $request->input('sensor_id');
        $helmet_id = $request->input('helmet_id');
        $minValue = $request->input('min_value');
        $maxValue = $request->input('max_value');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $readings = Reading::query();

        if (!is_null($startDate)) {
            $readings = $readings->where('created_at', '>=', $startDate);
        }

        if (!is_null($endDate)) {
            $readings = $readings->where('created_at', '<=', $endDate);
        }

        if (!is_null($helmet_id)) {
            $readings = $readings->where('helmet_id', '=', $helmet_id);
        }

        if (!is_null($sensor_id)) {
            $readings = $readings->where('sensor_id', '=', $sensor_id);
        }

        $readings = $readings
            ->when($minValue !== null, function ($query) use ($minValue) {
                return $query->where('sensor_value', '>=', $minValue);
            })
            ->when($maxValue !== null, function ($query) use ($maxValue) {
                return $query->where('sensor_value', '<=', $maxValue);
            })
            ->select('sensor_value', 'created_at')
            ->get();

            if(!empty($readings) || $readings != null) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Operation completed successfully.',
                    'data' => $readings
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No readings found.',
                    'data' => []
                ], 204);
            } 

        /*return response()->json($readings)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');*/


    }

    public function exportExcel()
    {
        return Excel::download(new ReadingExport, 'my_export.xlsx');
    }


    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            $file = $request->file('file');
    
            // Import the data from the file using the WorkerImport class
            Excel::import(new ReadingImport, $file);
    
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
