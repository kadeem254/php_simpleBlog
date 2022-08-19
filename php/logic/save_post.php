<?php

  require ("../functions.php");
  
  // All possible status codes that can be returned.
  $STATUS_CODES = [
    // ... errors
    "100"=>"Trouble Recieving Data",
    "101"=>"Database Failure",
    "110"=>"Failed to process request",
    // success codes
    "200"=>"Success",
    // language errors
    "300"=> "Data Error",
    "301"=> "Internal Error"
    // database errors
  ];

  function GenerateResponse( $status, $ok, $statusText, $data = NULL, $details = "N/A" ){
    $response = new stdClass;

    global $STATUS_CODES;

    try{
      $response->status = $status;
      $response->ok = $ok;
      $response->statusText = $statusText;
      $response->data = $data;
      $response->details = $details;
    } catch ( Exception $error ){
      $response->status = 300;
      $response->ok = FALSE;
      $response->statusText = $STATUS_CODES["300"];
      $response->data = NULL;
      $response->details = $error->getMessage();
    }

    echo json_encode( $response );
    exit();
  }

  $receieved_json = file_get_contents( "php://input" );
  $receieved_data = json_decode( $receieved_json );


  // ######### NON EMPTY #############
  // Ensure The data sent is not empty
  if( count( get_object_vars( $receieved_data ) ) <= 0 || $receieved_json == NULL){
    $msg = "System did not recieve the post data";
    GenerateResponse( 100, FALSE, $STATUS_CODES["100"], NULL, $msg );
  }

  $connection;
  try {
    $connection = CreateDatabaseConnection();
  }
  catch ( Exception $error ){
    $msg = "Database Connection Failed: " . $error->getMessage();
    GenerateResponse( 101, FALSE, $STATUS_CODES["101"], NULL, $msg );
  }

  // after connecting to database attempt to save the post
  if( $receieved_data->operation == "save" ){

    mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

    $connection->begin_transaction();

    try{
      $active = $receieved_data->post_active == false ? 0 : 1;

      // Disable Foregin Key Checks
      // $sql_disable_fk_check = "SET FOREIGN_KEY_CHECKS=0";
      // $connection->query( $sql_disable_fk_check );

      // Insert Main Blog Details
      $sql_insert_1 = "INSERT INTO blog( title, active ) VALUES ( '$receieved_data->post_title', $active ) ";

      $connection->query( $sql_insert_1 );

      // Disable Foregin Key Checks
      $selectquery="SELECT post_id FROM blog ORDER BY post_id DESC LIMIT 1";
      $result = $connection->query($selectquery);
      $post_id = 0;
      if( $result->num_rows > 0 ){
        $row = $result->fetch_assoc();
        $post_id = $row['post_id'];
      }

      // Insert Blog Content
      $blog_content = $receieved_data->post_content;
      $clean_blog_content = EncodeBlogContent( $blog_content );
      if( $clean_blog_content == FALSE ){
        throw new Exception("Could not Encode Blog Content");
      }

      $sql_insert_2 = "INSERT INTO blog_content(post_id, post_content) VALUES ( $post_id, '$clean_blog_content' )";

      $connection->query( $sql_insert_2 );

      // Enable Foregin Key Checks
      // $sql_enable_fk_check = "SET FOREIGN_KEY_CHECKS=1";
      // $connection->query( $sql_enable_fk_check );

      $connection->commit();

      // send the post id as the data
      $connection->close();
      $msg = "Successfully added the records to the database";
      GenerateResponse( 200, TRUE, $STATUS_CODES["200"], $post_id, $msg );
    } catch ( mysqli_sql_exception $error ){
      $connection->rollback();

      $connection->close();
      $msg = "Failed to add the post to the database: " . $error->getMessage();
      GenerateResponse( 101, FALSE, $STATUS_CODES["101"], NULL, $msg );
    } catch ( Exception $error ){
      $connection->close();
      $msg = $error->getMessage() ;
      GenerateResponse( 301, FALSE, $STATUS_CODES["301"], NULL, $msg );
    }

  }

  // ##################          END         ####################################
  // if no statement process the request up to this point send a default response
  $connection->close();
  $msg = "The request failed to trigger any processing code and has reached the end of the script.";
  GenerateResponse( 110, FALSE, $STATUS_CODES["110"], NULL, $msg );
?>