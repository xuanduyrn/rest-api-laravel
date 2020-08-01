<?php
namespace App\Helpers;

class APIHelpers {
  
  public static function createAPIResponse($is_error, $code, $message, $content, $error) {
    $result = [];
    if (!$is_error) {
      $result['success'] = false;
      $result['code'] = $code;
      $result['message'] = $message;
      $result['error'] = $error;
    } else {
      $result['success'] = true;
      $result['code'] = $code;
      if ($content === null) {
        $result['message'] = $message;
      } else {
        $result['data'] = $content;
      }
      $result['error'] = null;
    }
    return $result;
  }
}
