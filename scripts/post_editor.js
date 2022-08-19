const SAVE_POST_URL = "./php/logic/save_post.php";
const WATCHERS = {
  canUploadPost: true,
}
const POST_OPTIONS = {
  operation: "save",
  post_id: null
}

function PageLoaded() {
  StartPostEditor();

  try {
    let post_form = document.getElementById("post-edit-form");
    post_form.addEventListener("submit", SubmitPost);
  } catch (error) {
    // handle unable to locate form
    console.error("Error handling post submission: " + error.message);
  }

  return;
}

window.addEventListener("load", PageLoaded);

/**Start medium editor for the post */
function StartPostEditor() {
  try {
    let element = document.querySelector(
      "#landing-section .post-edit-form .post-content"
    );
    let editor = new MediumEditor(element);
    return editor;
  } catch (error) {
    throw new Error("Failed to start editor: " + error.message);
  }
}

/**Called once the save post button is clicked */
function SubmitPost(event) {
  // validation of field
  // type of edit "new post" or editing "existing post"

  event.preventDefault();

  if( WATCHERS.canUploadPost ){
    WATCHERS.canUploadPost = false;
    SendPost();
  } else {
    console.log( "Pending Upload operation in progress" );
  }

  return;
}

/**Retrieves the fields from the form and returns the json | form data of that  */
function RetrievePostFields() {
  let post_data = new FormData();

  let errors = [];

  // title field
  try {
    let post_title = document.getElementById("post-title");
    post_data.append( "post_title", ValidatePostTitle(post_title.value) );
  } catch (error) {
    // throw new PostError( `Invalid Title: ${error.message}`  );
    errors.push( `Invalid Title: ${error.message}` );
  }

  // content field
  try{
    let post_content = document.getElementById("post-content");
    post_data.append( "post_content", ValidatePostContent( post_content ) );
  }catch (error){
    // throw new PostError( `Invalid Content: ${error.message}` );
    errors.push( `Invalid Content: ${error.message}` );
  }

  // active status
  try{
    let post_active = document.getElementById("post-active");
    if( post_active.checked !== false && post_active.checked !== true ){
      post_active.checked = true;
    }
    post_data.append( "post_active", post_active.checked );
  } catch( error ){
    // throw new PostError( `Invalid Active Status: ${error.message}` );
    errors.push( `Invalid Active Status: ${error.message}` );
  }

  // type of insert. ( save | update )
  post_data.append( "operation", "save" );
  post_data.append( "post_id", null );


  DisplayPostErrors( errors );

  if( errors.length > 0 ){
    return false;
  }

  let form_json

  // return the form data as json
  try{
    form_json = ConvertFormDataToJSON( post_data );
    return form_json;
  } catch (error){
    // throw new PostError( `Data Conversion Failed: ${error.message}` );
    errors = [ `Data Conversion Failed: ${error.message}` ];
    DisplayPostErrors( errors );
    return false;
  }
}

function ValidatePostTitle(title) {
  // validate title, ensure appropriate length etc
  title = title.trim();
  if( title.length < 3 ){
    throw new Error("Title Length cannot be less than 3 chracters long");
  }
  return title;
}

function ValidatePostContent( content ) {

  let text_content = content.textContent.trim();
  let html_content = content.innerHTML;

  if( text_content.length < 20 ){
    throw new Error("Content must be over 20 characters long");
  }

  return html_content;
}

function PostError( message ){
  this.message = message;
  this.name = "PostError";
  return;
}


function ConvertFormDataToJSON( form_data ){
  if( form_data instanceof FormData === false ){
    throw new Error( "Data must be of type 'FormData'" );
  }

  let form_object = {};
  for( const entry of form_data.entries() ){
    form_object[entry[0]] = entry[1];
  }

  try{
    let form_json = JSON.stringify( form_object );
    return form_json;
  } catch ( error ){
    throw new Error( `Failed to convert Form Data to Json: ${error.message}` );
  }
}

function DisplayPostErrors( errors_list ){

  let error_container = document.querySelector( "#landing-section .post-edit-form .form-errors" );
  while (error_container.firstChild ){
    error_container.removeChild( error_container.firstChild );
  }

  if ( errors_list.length == 0 ){
    // hide error container.
    error_container.classList.add( "--hidden" );
    return;
  }

  // show the error container.
  error_container.classList.remove( "--hidden" );

  errors_list.forEach(
    element => {
      let error = document.createElement( "li" );
      error.classList.add("error");

      let error_text = document.createTextNode( element );
      error.appendChild( error_text );

      error_container.appendChild( error );
    }
  );

  console

  return;
}

/** Sends the post to the server */
async function SendPost(){
  // generate form data to be sent
  let post = RetrievePostFields();

  // stop ecexution is failures have been encountered
  if( post == false ){
    // ############# ALERT USER ON FAIL ##############
    WATCHERS.canUploadPost = true;
    return;
  }

  let fetch_configuration = {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: post,
  }

  await fetch( SAVE_POST_URL, fetch_configuration )
  .then(
    async ( request ) => {
      if( request.ok === false ){

        /* #############################
        Handle Failed requests
        ############################# */

        // attempt to send the post x number of times
        let successful_retry = false;
        let attempts = 0;
        do{
          attempts++;
          await new Promise(
            function( res, rej ){
              fetch( SAVE_POST_URL, fetch_configuration )
              .then(
                function ( val ) {
                  if( val.ok ){
                    successful_retry = true;
                    return res();
                  }

                  return rej()
                }
              )
            }
          )

          if ( successful_retry ) break;
        } while ( attempts <= 5 );

        // if the retries are still unsuccessful inform the user
        if( !successful_retry ){
          //inform user
          console.log( "failed to send the post" );
        }

        WATCHERS.canUploadPost = true;
        return;
      }
      
      return request.json();
    }
  )
  .then(
    ( value ) => {

      /* #############################
      Handle Success Response
      ############################# */

      console.log( value );
    },
    ( error ) => {

      /* #############################
      Handle Failed Response
      ############################# */

      console.log( `error: ${error}` );
      return;
    }
  )
  .finally(
    function(){
      WATCHERS.canUploadPost = true;
      return;
    }
  )

  return;
}
