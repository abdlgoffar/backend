<?php

namespace App\Validator;

use App\Exceptions\ForeignKeyException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Validation\ValidationException;
use PDOException;
use Illuminate\Support\Facades\Hash;

class Validate
{
    public static function validCreate(Request $request, array $rules, array $fieldResponse, string $entityModel, array $fkModel): JsonResponse
    {

        $validator = Facades\Validator::make(
            $request->all(),
            $rules,
            [
                "numeric" => "The :attribute field must be a number"
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator, null);
        } else {

            if (!empty($request->password)) {
                Hash::make($request->password);
            }

            if (!empty($fkModel)) {
                foreach ($fkModel as $i) {
                    $c = explode("\\", $i);
                    $fkm = end($c);
                    if (is_null($request->input(strtolower($fkm))) === false) {
                        $fkr = strtolower($fkm);
                        if (strtolower($fkm) == $fkr) {
                            $byIdObject = new $i;
                            if (is_null($byIdObject::find($request->$fkr))) throw new Exception("Foreign Key {$fkr}  Not Found");
                        }
                    }
                }
            }
            $createObject =  new $entityModel;
            $createObject->create($request->all());
            return response()->json(
                ["status" => true, "messages" => $validator->errors(), "payload" => $request->only($fieldResponse)],
                200,
                ["Content-Type" => "application/json"]
            );
        }
    }

    public static function validUpdate($id, Request $request, array $rules, array $fieldResponse, string $entityModel, array $fkModel): JsonResponse
    {

        $validator = Facades\Validator::make(
            $request->all(),
            $rules,
            [
                "numeric" => "The :attribute field must be a number"
            ]
        );
        if ($validator->fails()) {
            throw new ValidationException($validator, null);
        } else {
            if (!empty($fkModel)) {
                foreach ($fkModel as $i) {
                    $c = explode("\\", $i);
                    $fkm = end($c);
                    if (is_null($request->input(strtolower($fkm))) === false) {
                        $fkr = strtolower($fkm);
                        if (strtolower($fkm) == $fkr) {
                            $byIdObject = new $i;
                            if (is_null($byIdObject::find($request->$fkr))) throw new Exception("Foreign Key {$fkr}  Not Found");
                        }
                    }
                }
            }

            $createObject =  new $entityModel;
            $createObject->where('id', $id)->update($request->all());
            return response()->json(
                ["status" => true, "messages" => $validator->errors(), "payload" => $request->only($fieldResponse)],
                200,
                ["Content-Type" => "application/json"]
            );
        }
    }
}
