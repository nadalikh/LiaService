<?php

namespace App\Services;

class MySweetAbility
{
    static function missingResponse(){
        return response()->json(["errors" => [\App\Consts\Response::ENTITY_NOT_FOUND]], 404);
    }
}
