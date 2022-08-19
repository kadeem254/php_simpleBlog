<!-- Can be accessed by both the admin -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title> Admin </title>

  <link rel="stylesheet" href="./css/post_editor.css">
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
        
        <h2 class="sub-heading">Post Editor</h2>

        <form class="post-edit-form" id="post-edit-form">
          <ul class="form-field form-errors --hidden">
          </ul>
          <div class="form-field post-title-field">
            <label class="label" for="post-title">Post Title</label>
            <input class="input contrasted-input" type="text" name="post_title" id="post-title">
          </div>
          <div class="form-field post-content-field">
            <p class="label">Post Content</p>
            <div class="input post-content contrasted-input" id="post-content">

            </div>
          </div>
          <div class="form-field form-submission-field">
            <div class="micro-field">
              <label class="label" for="post_active"> Active: </label>
              <input type="checkbox" name="post-active" id="post-active" checked >
            </div>
            <button class="btn form-submit-button">Save Post</button>
          </div>
        </form>
      </div>
    </section>

  </main>

  <script src="./scripts/dist/lodash.min.js"></script>
  <script type="module" defer src="./scripts/post_editor.js"></script>
</body>
</html>