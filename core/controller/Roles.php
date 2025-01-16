<?php


class Roles{

    public static function hasAdmin(){
      if(isset($_SESSION['user_id'])){
              return UsuarioData::hasRoleAdmin($_SESSION['user_id']);
      }
    }

    public static function hasSeller(){
      if(isset($_SESSION['user_id'])){
              return UsuarioData::hasRoleSeller($_SESSION['user_id']);
      }
    }

    public static function hasRepairMan(){
      if(isset($_SESSION['user_id'])){
              return UsuarioData::hasRepairMan($_SESSION['user_id']);
      }
    }

    public static function validHasAdmin(){
      if(!Roles::hasAdmin()){
        http_response_code(404);
        echo json_encode(['msg' => "Tiene que tener privilegios de administrador"]);
        exit;
    }
    }



}
?>