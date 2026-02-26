<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class DepartmentsController extends Controller
{

    public function storedepartments(Request $request)
    {
        try {

            $user = $request->user(); // better than Auth::user()

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            // 🔒 Only Admin Allowed
            if ($user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only Admin can create Departments',
                ], 403);
            }

            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'name'        => 'required|string|max:255|unique:departments,name',
                'description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Failed',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $department = Departments::create([
                'name'        => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Department Created Successfully',
                'data'    => $department,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(), // remove in production
            ], 500);
        }
    }

    public function fetchdepartments()
    {
        try {

            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            $departments = Departments::all();
            if((!$departments)){
                return response()->json([
                    'success'=>false,
                    'messsage'=> 'Departments not found'
                ]);
            }
             return response()->json([
                    'success'=>true,
                    'messsage'=> 'All Departments Retrived Successsfully',
                    'data'=>$departments
                ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(), // remove in production
            ], 500);
        }
    }
    public function viewdepartments($id)
    {
        try {

            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            $departments = Departments::find($id);
            if((!$departments)){
                return response()->json([
                    'success'=>false,
                    'messsage'=> 'Departments not found'
                ]);
            }
             return response()->json([
                    'success'=>true,
                    'messsage'=> 'All Departments Retrived Successsfully',
                    'data'=>$departments
                ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(), // remove in production
            ], 500);
        }
    }

    public function update(Request $request, $id)
{
    try {

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Admin can update Departments',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255|unique:departments,name,' . $id,
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $department = Departments::find($id);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found'
            ], 404);
        }

       $department->update($request->only(['name', 'description']));
        return response()->json([
            'success' => true,
            'message' => 'Department updated Successfully',
            'data'    => $department,
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage(),
        ], 500);
    }
}
  public function destroy(Request $request, $id)
{
    try {

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Admin can delete Departments',
            ], 403);
        }

        $department = Departments::find($id);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found'
            ], 404);
        }

       $department->delete();
        return response()->json([
            'success' => true,
            'message' => 'Department deleted Successfully',
            'data'    => $department,
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage(),
        ], 500);
    }
}
}
