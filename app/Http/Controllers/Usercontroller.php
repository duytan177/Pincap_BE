<?php

namespace App\Http\Controllers;

use App\Enums\User\Role;
use App\Models\ReportReason;
use App\Models\MediaReport;
use App\Models\User;
use App\Repositories\UserRepo\UserRepo;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    protected $userRepo;
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function index(Request $request)
    {
        $listUser = User::with(['albums','tags','mediaOwner','reportMedias'])->get();
        return response()->json([
            'listUser' => $listUser
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listRole = Role::getKeys();
        return response()->json([
            'listRole' => $listRole
        ],200);
    }


    public function store(Request $request)
    {
        //
        $attribute = $request->all();
        if(!$attribute){
            return response()->json([
                "message"=>"Created user failed"
            ],400);
        }
        $attribute['password'] = Hash::make($attribute['password']);
        if($this->userRepo->create($attribute)){
            return response()->json([
                "message"=>"Created user successfully"
            ],200);
        }

    }


    public function show($id)
    {
        if(($userDetail = $this->userRepo->find($id)) ===null) {
            return response()->json([
                'message' => "Not found user"
            ], 404);
        }
            return response()->json([
                'userDetail' => $userDetail
            ],200);
    }

    public function edit($id)
    {
        if(($userDetail = $this->userRepo->find($id)) ===null) {
            return response()->json([
                'message' => "Not found user"
            ], 404);
        }
        return response()->json([
            'userDetail' => $userDetail
        ],200);
    }

    public function update(Request $request, $id)
    {
        //
        $creadistal = $request->all();
        if($this->userRepo->update($id,$creadistal)){
            return response()->json([
                'message' => "Updated user successfully"
            ], 200);
        }
        return response()->json([
            'message' => "Updated user failed"
        ], 404);
    }

    public function destroy($id)
    {
        if( $this->userRepo->delete($id)){
            return response()->json([
                'message' => "Deteled user successfully"
            ], 200);
        }
        return response()->json([
            'message' => "Deteled user failed"
        ], 400);
    }

    public function findUser(Request $request){
        $params = [
            'email',
            'firstName'
        ];
        return $this->userRepo->findByField($params,$request->input('searchUser'));
    }
}
