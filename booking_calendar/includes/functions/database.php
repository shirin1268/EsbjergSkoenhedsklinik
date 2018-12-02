<?php
  function wrap_db_connect() {
	global $db_link;
        
	if (USE_PCONNECT) {
            @$db_link = mysqli_connect('p:'.DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
        } else {
            @$db_link = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
        }
	return $db_link;
  }

  function wrap_db_close() {
	global $db_link;
	
	$result = mysqli_close($db_link);
	
	return $result;
  }

  function wrap_db_query($db_query) {
	global $db_link;
	
	if (STORE_DB_TRANSACTIONS) {
		error_log("QUERY " . $db_query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
	}
	$result = mysqli_query($db_link, $db_query);
	
	if (STORE_DB_TRANSACTIONS) {
		$result_error = mysqli_error($db_link);
		error_log("RESULT " . $result . " " . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
	}
	
	return $result;
  }

  function wrap_db_fetch_array($db_query) {
	
	@ $result = mysqli_fetch_array($db_query);
	
	return $result;
  }

  function wrap_db_num_rows($db_query) {
	
	@ $result = mysqli_num_rows($db_query);
	
	return $result;
  }

  function wrap_db_data_seek($db_query, $row_number) {
	
	@ $result = mysqli_data_seek($db_query, $row_number);
	
	return $result;
  }

  function wrap_db_insert_id() {
	global $db_link;
        
	@ $result = mysqli_insert_id($db_link);
	
	return $result;
  }

  function wrap_db_free_result($db_query) {
	global $db_link;
	
	@ $result = mysqli_free_result($db_query);
	
	return $result;
  }

  function wrap_db_escape_string($string = '') {
        global $db_link;
        
        $result = mysqli_real_escape_string($db_link, $string);
      
        return $string;
  }
  
  