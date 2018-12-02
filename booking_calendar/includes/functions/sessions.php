<?php
  function wrap_session_start() {

    return session_start();

  }

  function wrap_session_register($name, $variable = '') {

    $_SESSION[$name] = $variable;
    
  }

  function wrap_session_is_registered($variable) {

    return isset($_SESSION[$variable]);

  }

  function wrap_session_unregister($variable) {

    unset( $_SESSION[$variable]);
    return true;

  }

  function wrap_session_id($sessid='') {

    if ($sessid) 
       return session_id($sessid);
    else
       return session_id();
      
  }

  function wrap_session_name($name='') {

    if ($name)
      return session_name($name);
    else
      return session_name();

  }

  function wrap_session_close() {

    if (function_exists('session_close')) {
      return session_close();
    }

  }

  function wrap_session_destroy() {

    session_destroy();
    return true;

  }

