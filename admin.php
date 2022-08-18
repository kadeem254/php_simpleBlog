<?php
  include_once( "./php/functions.php" );

  $NO_POSTS_HTML = <<<NO_POSTS_HTML
  <div class="no-posts">
    <p class="text">No Entries Found <i class="fa-solid fa-folder-closed"></i> </p>
  </div>
  NO_POSTS_HTML;

  /** Returns an array containing existing posts,
   * null if no posts exist and
   * throws an error if issues are encountered.
   */
  
?>


<!-- Can be accessed by both the admin and normal users -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title> Admin </title>

  <link rel="stylesheet" href="./css/admin.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="fontawesome/css/solid.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/css/medium-editor.min.css" integrity="sha512-zYqhQjtcNMt8/h4RJallhYRev/et7+k/HDyry20li5fWSJYSExP9O07Ung28MUuXDneIFg0f2/U3HJZWsTNAiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/js/medium-editor.min.js" integrity="sha512-5D/0tAVbq1D3ZAzbxOnvpLt7Jl/n8m/YGASscHTNYsBvTcJnrYNiDIJm6We0RPJCpFJWowOPNz9ZJx7Ei+yFiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
  
  <header id="page-header" class="header">
    <div class="inner">

      <div class="logo-container">
        <a href="./index.php" class="logo">Fake Blog</a>
      </div>

      <nav class="nav main-menu menu">
        <ul class="links-list">

          <li class="navlink"> <a href="">Home</a> </li>
          <?php
            include("./php/components/header.php");
          ?>

        </ul>
      </nav>

    </div>
  </header>

  <main class="main" id="page-content">

    <section id="landing-section">
      <div class="inner">
        
        <h2 class="sub-heading">Admin Page</h2>
        <p class="text">
          This page allows the admin to manage existing blogs within the system as well as
          generate new blogs.
        </p>

      </div>
    </section>

    <section id="post-section">
      <div class="inner">

        <!-- search bar for posts -->

        <!-- list of existing posts, displays empty if none exist -->
        <div class="posts-list">

          <?php
            // check if posts exist
            // if there is an error in getting the posts - inform user;
            // if no posts exist (no errors) - ;
            try{
              $posts = FetchPosts();

              if( $posts === NULL ){
                echo $NO_POSTS_HTML;
              }
            }
            catch (Exception $err) {
              echo $err->getMessage();
            }
          ?>
        </div>
        
      </div>
    </section>

  </main>

</body>
</html>