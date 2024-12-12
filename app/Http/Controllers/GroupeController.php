<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Groupe;
use App\Models\GroupeMembers;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupeController extends Controller
{
    public function create_group(GroupRequest $request, $user_id) {

        
        DB::beginTransaction();
        try {

            $request->validated();

            // Gestion de l'avatar
            $avatar = "src/public/db/image_default.jpg";
            if ($request->hasFile('groupe_image')) {
                $avatar = move_uploaded_file($request->file('avatar'), 'group');
            }
            // Création du groupe
            $group = Groupe::create([
                'name' => $request->name, // Assure-toi que 'groupe_name' est bien reçu et transféré
                'image' => $avatar,
                'actuality' => $request->actuality,
                'user_id' => $user_id, //auth()->id()
            ]);

            $data = [
                'groupe_id' => $group->id,
                'member_id' => $user_id
            ];

            GroupeMembers::create($data);

            DB::commit();

            return ApiResponse::sendResponse(
                // true, 
                // [new UserResource($user)], 
                // 'Connexion réussie.', 
                // 201
                $group,
                $data,
                'Groupe crée avec succes.',
                $group ? 201 : 401
            );

            // return response()->json(['message' => 'Group created successfully', 'group_id' => $group->id], 201);
        } catch (\Throwable $th) {
            return $th;
            return ApiResponse::rollback($th);
        }
            
    }

    
}
