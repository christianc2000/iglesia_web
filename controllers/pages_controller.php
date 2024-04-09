<?php
class PagesController
{
  public function home()
  {
    $first_name = 'REGISTRO DE IGLESIA';
    $last_name  = 'CRISTO';
    require_once('views/pages/home.php');
  }
  //pagina inicial después de hacer login
  public function dashboard()
  {
    $first_name = 'BIENVENIDO A LA IGLESIA';
    $last_name  = 'CRISTO';
    require_once('views/dashboard.php');
  }
  public function error()
  {
    require_once('views/pages/error.php');
  }
}
