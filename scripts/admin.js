function PageLoaded(){

  // new post button
  try{
    let new_post_link = document.querySelector( "#post-section .post-actions .btn-add-post" );
    new_post_link.addEventListener( "click", GenerateNewPost );
  } catch( error ){
    console.error( "Create Post Link Error: " + error.message );
  }

  return;
}

window.addEventListener( "load", PageLoaded );

function GenerateNewPost( event ){
  event.preventDefault();

  // submit as a post request with new post
  let new_post_form = CreateForm( "./post_editor.php" );

  document.body.appendChild( new_post_form );
  new_post_form.submit();

  return;
}

function CreateForm( path, method = "post" ){
  let form = document.createElement( "form" );
  form.action = path;
  form.method = method;

  return form;
}