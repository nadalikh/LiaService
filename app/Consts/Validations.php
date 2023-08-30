<?php

namespace App\Consts;

class Validations
{
    const REQUIRED = "required";
    const EMAIL = "email|regex:/^[-_a-zA-Z0-9.+!%]*@[a-zA-z]*.[a-zA-Z]*$/";
    const STRING = "string";
    const PASSWORD = "string|confirmed||min:6";

}
