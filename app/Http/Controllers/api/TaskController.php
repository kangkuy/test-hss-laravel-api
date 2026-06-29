<?php

namespace App\Http\Controllers\api;

use App\Helpers\Datatable;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function data(Request $request){
        try{
            $data = Task::query();

            $response = Datatable::make($request, $data)
                ->addColumn('id', fn($item) => $item->id)
                ->addColumn('title', fn($item) => $item->title)
                ->addColumn('status', fn($item) => self::status($item->status))
                ->response();
            return $response;
        }catch(Exception $e){
            return response()->json([
                "success"=> false,
                "data" => [],
                "message" => "Data Gagal ditampilkan"
            ]);
        }
    }

    private function status($status = 0){
        $isStatus = ["Pending", "Done"];
        return $isStatus[$status];
    }

    public function store(Request $request){
        $task = new Task();
        $task->title = $request->title;
        $task->status = $request->status;
        $task->save();

        return response()->json([], 200);
    }

    public function destroy($id){
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
        // return response()->json($id);
    }
}
