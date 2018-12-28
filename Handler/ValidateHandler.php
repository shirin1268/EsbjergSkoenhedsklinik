<?php

class ValidateHandler extends ServerHandler
{
    static function validinput($input,$connection) {

        $viewtext = filter_var($input, FILTER_SANITIZE_STRING);
        $sanoutput=mysqli_real_escape_string($connection,$viewtext);
        $specialchars=htmlspecialchars($sanoutput);
        $secure = trim($specialchars);
        return $secure;
     }

    static function hashing($pass){
        $iterations = ['cost' => 15];
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT, $iterations);
        return $hashed_pass;
    }

    static function adminlevelvalidation($adminlevel){

        if($adminlevel=="administrator"){
            return $adminlevel;
        }
        else{
            echo "Adminpass is not correct!";
        }
    }
}



?>