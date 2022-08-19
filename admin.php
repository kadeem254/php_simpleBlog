<?php
  include_once( "./php/functions.php" );

  $NO_POSTS_HTML = <<<NO_POSTS_HTML
  <div class="no-posts">
    <p class="text">No Entries Found <i class="fa-solid fa-file-circle-xmark"></i> </p>
  </div>
  NO_POSTS_HTML;
  
?>


<!-- Can be accessed by both the admin -->
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
        
        <!-- Action bar: include add post feature -->
        <div class="post-actions">
          <!-- redirects to the post edit page to add a new post -->
          <a href="./post_editor.php?" class="btn btn-add-post">Add Post</a>
        </div>

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
              // show results here
              else{
                echo "Results are present";
              }
            }
            
            catch (Exception $err) {
              echo <<<POST_ERROR_P1
              <div class="post-error">
                <p class="text">Error Fetching Posts: 
              POST_ERROR_P1;

              echo $err->getMessage();

              echo <<<POST_ERROR_P2
                </p>
              </div>
              POST_ERROR_P2;
            }
          ?>
        </div>
        
      </div>
    </section>

  </main>

  <script defer src="./scripts/admin.js"></script>
</body>
</html>