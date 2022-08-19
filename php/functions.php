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

  /**Fetches Posts based on a given query */
  function FetchPosts( $query = "SELECT * FROM blog" ){
    // establish a connection to the database
    try{
      $conn = CreateDatabaseConnection();
    } catch ( Exception $err ){
      throw new Exception( $err->getMessage() );
      return false;
    }

    // get the posts currently in the database
    try{
      $results = $conn->query( $query );
      
      // if no results return Null
      if( $results->num_rows <= 0 ){
        $conn->close();
        return NULL;
      }

    }
    catch( Exception $err ){
      throw new Exception( $err->getMessage() );
      $conn->close();
      return false;
    }

    // Pack the results in and object
    try{
      $blog_list = array();

      while( $row = $results->fetch_assoc() ){
        $entry = array(
          "blog_id"=>$row["blog_id"],
          "title"=>$row["title"],
          "active"=>$row["active"],
          "created_on"=>$row["created_on"],
          "last_update"=>$row["last_update"],
        );

        array_push( $blog_list, $entry );

        // close connection when done
        $conn->close();
        return $blog_list;
      }
    }
    catch( Exception $err ){
      throw new Exception( $err->getMessage() );
      $conn->close();
      return false;
    }

  }

  function EncodeBlogContent( $content ){
    try{
      $encoded_content = htmlentities( addslashes( $content ) );
      return $encoded_content;
    } catch (Exception $error){
      return FALSE;
    }
  }
  function DecodeBlogContent( $content ){
    try{
      $decoded_content = html_entity_decode( stripslashes( $content ) );
      return $decoded_content;
    } catch (Exception $error){
      return FALSE;
    }
  }
?>