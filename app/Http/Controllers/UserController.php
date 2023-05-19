<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function updateUser(Request $request, string $id) {
        //dd($request);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $result = $user->save();
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

    public function getUser(string $id) {
        $user = User::find($id);

        if(!empty($user) || $user != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Operation completed successfully.',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No user found.',
                'data' => []
            ], 204);
        }
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport, 'my_export.xlsx');
    }
}
