<?php  
  
  function hashUserID($id, $key)
  {
    return hash_hmac('md5', $id, $key);
  }
  
?>