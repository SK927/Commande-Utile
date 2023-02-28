<?php

  function encrypt_data($data)
  {
    return openssl_encrypt($data, "aes-128-cbc", "#KEY", 0, "#IV");
  }
  
  function decrypt_data($data)
  {
    return openssl_decrypt($data, "aes-128-cbc", "#KEY", 0, "#IV");
  }
  
?>
  