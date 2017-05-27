<?php

function my_form(){
	
	if (isset($_POST['submit'])){
		
		  $user_login = esc_attr($_POST['user']);
		$user_email = esc_attr($_POST['emaile']);
        $user_pass = esc_attr($_POST['passworde']);
		
		?>
	<form id="msform" action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Profession</li>
    <li>Phone Number</li>
    <li>Finish</li>
  </ul>
  <!-- fieldsets -->
  <fieldset>
    <h2 class="fs-title">Choose your Category</h2>
	
<input type="hidden"   name="user"  value="<?php echo $user_login; ?>" />
<input type="hidden"   name="emaile"  value="<?php echo $user_email; ?>" />
<input type="hidden"   name="passworde"  value="<?php echo $user_pass; ?>" />
<div class="wrapper">
<label class="checkbox">
    <input type="checkbox" name="contractor" class="radio" value="Contractor"/>
      <div class="box a">Contractor</div>
</label>
<label class="checkbox">
    <input type="checkbox" name="contractor" class="radio" value="Homeowner"/>
      <div class="box b">Homeowner</div>
</label>

</div>
    <input type="button" name="next" class="next action-button" value="Next" />
  </fieldset>
  <fieldset>
    <h2 class="fs-title">Submit your Phone Number</h2>
   
    <input type="text" name="phone" placeholder="Phone Number" />
    <input type="button" name="previous" class="previous action-button" value="Previous" />
    <input type="button" name="next" class="next action-button" value="Next" />
  </fieldset>
  <fieldset>
    <h2 class="">Your registration is almost complete. Press the submit button to complete your
	registration</h2>
   
    <input type="button" name="previous" class="previous action-button" value="Previous" />
    <input type="submit" name="submitt" class="submit action-button" value="Submit" />
  </fieldset>
</form>
		
		
		<?php
		
	}else{
	
	
	?>
	
	<form class="form-container" action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
	<h2 class ="formtitle" >Create your Account</h2>
	<?php
	 if(defined('REGISTRATION_ERROR')){
            foreach(unserialize(REGISTRATION_ERROR) as $error){
				 echo '<ul>';
              echo '<li class="error">'.$error.'</li>';
			   echo '</ul>';
            }
          }
		?>
		 <div class="field">
    <input type="text"  class="" name="user" id="user" placeholder="" >
    <label  for="username">Username</label>
    </div>
	
		<div class="field">
    <input type="email"  class="" name="emaile" id="emaile" placeholder="" >
    <label  for="Email">Email Address</label>
    </div>
	<div class="field">
		<input type="password"  class="" name="passworde" id="passworde" placeholder="" required>
    <label  for="Password">Password</label>
	</div>
	<div class="field">
		<button  type="submit" name="submit" class=""  >Continue</button>
    </div>
	
    <span class="button-content"> Already a member ? Please  <a  class="button-contentlink" href="">Sign In </span>
	</form>
	


	<?php
}
}
function deliver_mail() {

    // if the submit button is clicked, send the email, the second is to prevent page refresh from submitting form
    if ( isset( $_POST['submitt'] ) ) {
		
		

	$errors = array();
        // sanitize form values
		
		  $contractor = esc_attr($_POST['contractor']);
		  $user_login = esc_attr($_POST['user']);
		  $user_email = esc_attr($_POST['emaile']);
          $user_pass = esc_attr($_POST['passworde']);
        
		 $sanitized_user_login = sanitize_user($user_login);
$user_email = apply_filters('user_registration_email', $user_email);
  
    if(!is_email($user_email)) 
       $errors[] = 'Invalid e-mail.<br>';
    elseif(email_exists($user_email)) 
       $errors[] = 'This email is already registered.<br>';
	   
	  if(username_exists($sanitized_user_login)) 
       $errors[] = 'User name already exists.<br>';
  
    if(empty($errors)):
      $user_id = wp_create_user($sanitized_user_login, $user_pass, $user_email);
  
    if(!$user_id):
      $errors[] = 'Registration failed';
    else:
      update_user_option($user_id, 'default_password_nag', true, true);
      wp_new_user_notification($user_id, $user_pass);
      update_user_meta ($user_id, 'user_phone', $user_phone);
      wp_cache_delete ($user_id, 'users');
      wp_cache_delete ($user_login, 'userlogins');
      do_action ('user_register', $user_id);
      $user_data = get_userdata ($user_id);
   /*   if ($user_data !== false) {
         wp_clear_auth_cookie();
         wp_set_auth_cookie ($user_data->ID, true);
         do_action ('wp_login', $user_data->user_login, $user_data);
         // Redirect user.
       //  wp_redirect ('/wp_login');
        // exit();
       } */
      endif;
    endif;
  
    if(!empty($errors)) 
      define('REGISTRATION_ERROR', serialize($errors));
  
 }      
 
}
function form_shortcode() {
    ob_start();
	deliver_mail();
    my_form();
	

    return ob_get_clean();
}

add_shortcode( 'reg_form', 'form_shortcode' );


function my_contactform(){

?>

<form id="msformm" action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Profession</li>
    <li>Phone Number</li>
    <li>Finish</li>
	 
  </ul>
  <!-- fieldsets -->
  <fieldset >
            <h2 class="fs-title">What Do you Need Help with ?</h2>    
      <input type="text" name="description" placeholder="Ex: Home addition" />
    
      <input type="button" name="next" class="next action-button" value="Continue" />

	  <div class="predefined">Popular Projects:</div>  
	  <div class="wrapii next">

	  <label class="checkboxa">
    <input type="checkbox" name="remodel"  class="radio" value="Bathroom Remodel"/>
      <div class="box a">Bathroom Remodel</div>
</label>

<label class="checkboxb">
    <input type="checkbox" name="remodel"  class="radio" value="Kitchen Remodel"/>
      <div class="box b">Kitchen Remodel</div>
</label>
<label class="checkboxc">
    <input type="checkbox" name="remodel"  class="radio" value="Multi-room" />
      <div class="box c">Multi-room</div>
</label>
<label class="checkboxd">
    <input type="checkbox" name="remodel"  class="radio" value="Home Addition" />
      <div class="box a">Home Addition</div>
</label>


 <label class="checkboxe">
    <input type="checkbox" name="remodel"  class="radio" value="New Home Construction"/>
      <div class="box a">New Construction</div>
</label>
<label class="checkboxf">
    <input type="checkbox" name="remodel"  class="radio" value="Roofing"/>
      <div class="box b">Roofing</div>
</label>
<label class="checkboxg">
    <input type="checkbox" name="remodel"  class="radio" value="Solar" />
      <div class="box c">Solar</div>
</label>
<label class="checkboxh">
    <input type="checkbox" name="remodel"  class="radio" value="Commercial Remodel" />
      <div class="box a">Commercial</div>
</label>
	  </div>
        </fieldset>
 <fieldset>
           <img src="/wp-content/uploads/2016/11/favicon-16x16.png" class="wrap align-left"> <h2 class="fs-title">When Do you Want to Start?</h2>    
      <div class="wrappe next">
<label class="checkbox">
    <input type="checkbox" name="flexible"  class="radio" value="I'm Flexible"/>
      <div class="box a">I'm Flexible</div>
</label>
<label class="checkbox">
    <input type="checkbox" name="flexible"  class="radio" value="As soon as possible"/>
      <div class="box b">As soon as possible</div>
</label>
<label class="checkbox">
    <input type="checkbox" name="flexible"  class="radio" value="Within a few weeks" />
      <div class="box c">Within a few weeks</div>
</label>
<label class="checkbox">
    <input type="checkbox" name="flexible"  class="radio" value="Within a few months" />
      <div class="box a">Within a few months</div>
</label>

</div>
      
        </fieldset>
		<fieldset>
      <h2 class="fs-title">What type of Property is this ?</h2>     
     <div class="wrapper next">
<label class="checkboxu">
    <input type="checkbox" name="family"  class="radio" value="Single Home Family"/>
      <div class="box a">Single Home Family</div>
</label>
<label class="checkboxr">
    <input type="checkbox" name="family"  class="radio" value="Condo Apartment" />
      <div class="box b">Condo Apartment</div>
</label>
<label class="checkboxl">
    <input type="checkbox"  name="family"  class="radio" value="Office" />
      <div class="box b">Office</div>
</label>
<label class="checkboxk">
    <input type="checkbox" name="family"  class="radio" value="Other" />
      <div class="box b">Other</div>
</label>

</div>
    </fieldset>
    <fieldset>
      <h2 class="fs-title">Please Enter your Contact Details</h2>
      <input type="text" name="nam" placeholder="Full name" required/>
      <input type="email" name="emai" placeholder="Email" required/>
      <input type="tel" name="phon" placeholder="Phone number" />
      <input type="submit" name="submite" class="submit action-button" value="Submit" />
    </fieldset>
</form>

<?php


}

function delivery_mail() {

    // if the submit button is clicked, send the email, the second is to prevent page refresh from submitting form
	
    if ( isset( $_POST['submite'] ) ) {
		
		  // sanitize form values
        $name    = sanitize_text_field( $_POST["nam"] );
		$description    = sanitize_text_field( $_POST["description"] );
        $email   = sanitize_email( $_POST["emai"] );
        $phone =  esc_attr($_POST["phon"]);
		$flexible =  esc_attr($_POST["flexible"]);
		$family =  esc_attr($_POST["family"]);
		
		

        // get the blog administrator's email address
        $to = get_option( 'admin_email' );

        $headers = "From: $name <$email>" . "\r\n";

        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $subject, $message, $headers ) ) {
            echo '<div>';
            echo '<p>Thanks for contacting me, expect a response soon.</p>';
            echo '</div>';
        } else {
            echo 'An unexpected error occurred';
        }
    }
		
		}
		

function formm_shortcode() {
    ob_start();
   delivery_mail();
    my_contactform();
	

    return ob_get_clean();
}

add_shortcode( 'reg_formm', 'formm_shortcode' );