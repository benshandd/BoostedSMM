<?php

function admin_controller($controllerName){
  $controllerName = strtolower($controllerName);
  return PATH.'/admin/controller/'.$controllerName.'.php';
}

function admin_view($viewName){
  $viewName = strtolower($viewName);
  return PATH.'/admin/views/'.$viewName.'.php';
}

function servicePackageType($type){
  switch ($type) {
    case '1':
      return "Service";
      break;
    case '2':
      return "Package";
      break;
    case '3':
      return "Private comment";
      break;
    case '4':
      return "Package comment";
      break;

    default:
      return "Package comment";
      break;
  }
}