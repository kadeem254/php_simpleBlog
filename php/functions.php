<?php
  /**Returns a mysqli connection object or throws an exception if an issue
   * is encountered during the connection process;
   */
  function CreateDatabaseConnection( $server = "localhost", $user = "root", $password = "", $database = "simple_blog_db" ){

    try{
      $connection = new mysqli( $server, $user, $password, $database );
    }
    catch( Exception $err ){
      throw new Exception( $err->getMessage() );
    }

    if( $connection->connect_error ){
      throw new Exception( $connection->connect_error );
    }

    return $connection;
  }
?>