<?php 
if (array_key_exists('submit', $_POST)) {
$to = 'aminuhammayo2015@gmail.com';	
$subject = 'Aminu Hammayo 2015';

// list expected fields
$expected = array('name','phone' ,'comments');
// set required fields
$required = array('name', 'phone','comments');
// create empty array for any missing fields
$missing = array();

// assume that there is nothing suspect
$suspect = false;
// create a pattern to locate suspect phrases
$pattern = '/Content-Type:|Bcc:|Cc:/i';

// function to check for suspect phrases
function isSuspect($val, $pattern, &$suspect) {
// if the variable is an array, loop through each element
// and pass it recursively back to the same function
if (is_array($val)) {
foreach ($val as $item) {
isSuspect($item, $pattern, $suspect);
}
}
else {
// if one of the suspect phrases is found, set Boolean to true
if (preg_match($pattern, $val)) {
$suspect = true;
}
}
}
// check the $_POST array and any subarrays for suspect content
isSuspect($_POST, $pattern, $suspect);

if ($suspect) {
$mailSent = false;
unset($missing);
}
else {

//User Input
foreach ($_POST as $key => $value) {
// assign to temporary variable and strip whitespace if not an array
$temp = is_array($value) ? $value : trim($value);
// if empty and required, add to $missing array
if (empty($temp) && in_array($key, $required)) {
array_push($missing, $key);
}
// otherwise, assign to a variable of the same name as $key
elseif (in_array($key, $expected)) {
${$key} = $temp;
}
}
}

// validate the email address
if (!empty($email)) {
// regex to ensure no illegal characters in email address
$checkEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
// reject the email address if it doesn't match
if (!preg_match($checkEmail, $email)) {
array_push($missing, 'phone');
}
}


//build message
// go ahead only if all required fields OK
if (!$suspect && empty($missing)) {
// build the message
$message = "Name: $name\n\n";
$message .= "Phone: $phone\n\n";
$message .= "Comments: $comments";
// limit line length to 70 characters
$message = wordwrap($message, 70);



// send it
$mailSent = mail($to, $subject, $message);
if ($mailSent) {
// $missing is no longer needed if the email is sent, so unset it
unset($missing);
}
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Aminu Hammayo 2015 | Contacts</title>
<meta charset="utf-8">
<link rel="shortcut icon" href="images/pdp.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery-1.4.2.js" ></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
</head>
<body id="page5">
<!-- START PAGE SOURCE -->
<div class="body2">
  <div class="body7">
    <div class="body3">
      <div class="body4">
        <div class="main">
         <?php include("head.inc"); ?>
          <section id="content">
            <div class="wrapper">
              <div class="box_shadow">
                <div class="box">
                  <div class="wrapper pad_bot1">
           <?php
if ($_POST && isset($missing)) {
?>
<p class="warning">Please complete the missing item(s) indicated.</p>
<?php
}
elseif ($_POST && !$mailSent) {
?>
<p class="warning">Sorry, there was a problem sending your message.
Please try later.</p>
<?php
}
elseif ($_POST && $mailSent) {
?>
<p><strong>Your message has been sent. Thank you for Contacting Us.
</strong></p>
<?php } ?>        
                    <h2>Contact Form</h2>
                    <form action="" method="post" name="feedback"><div>
                    <span>Name:<?php
if (isset($missing) && in_array('name', $missing)) { ?>
<span class="warning">Please enter your Name</span><?php } ?></br>
                   
                    <input type="text" name="name"  placeholder="name"<?php if (isset($missing)) {
echo 'value="'.htmlentities($_POST['name']).'"';
} ?> /></span><br />
                   
                    
                    <span>Phone Number:<?php
if (isset($missing) && in_array('phone', $missing)) { ?>
<span class="warning">Please enter your Phone Number</span><?php } ?></span></br>
                 
                    <input name="phone" type="text"  placeholder="Phone Number"<?php if (isset($missing)) {
echo 'value="'.htmlentities($_POST['phone']).'"';
} ?>><br />
                 
                    
                    
                    <span>Comments:<?php
if (isset($missing) && in_array('comments', $missing)) { ?>
<span class="warning">Please enter your Comment</span><?php } ?></span></br>
                    
                    <textarea name="comments" id="comments" placeholder="your comments here" cols="30" rows="8"><?php if (isset($missing)) { echo htmlentities($_POST['comments']);
} ?></textarea></span><br />
                    
<input name="submit" type="submit" value="SEND MESSAGE" class="button">&nbsp;
<input type="reset" value="RESET" class="button" name="reset">
                    </div>
				  </form>
                    <h2>Our Contacts</h2>
                <div class="wrapper">
                  <p > <b>Country:</b>NIGERIA, BAUCHI STATE.</p>               
                  <p>  <b>Telephone:</b>+234 XXX XXX XXX</p>
                <p>  <b>Email:</b> aminuhammayo2015@gmail.com
                  </p>
                  </div>
                </div>
              </div>
            </div>
            <article class="col2 pad_left2">
                
                  
            </div>
            <div class="wrapper line3">
              
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("foot.inc"); ?>
<!-- END PAGE SOURCE -->
</body>
</html>