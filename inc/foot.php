<!-- Footer -->
<div id="footer" class="footer_sticky_part"> 
    <div class="container">
      <div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12"> 
          <h4>About Us</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>          
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h4>Useful Links</h4>
          <ul class="social_footer_link">
            <li><a href="#">Home</a></li>
            <li><a href="#">Listing</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h4>My Account</h4>
          <ul class="social_footer_link">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">My Listing</a></li>
            <li><a href="#">Favorites</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h4>Pages</h4>
          <ul class="social_footer_link">
            <li><a href="#">Blog</a></li>
            <li><a href="#">Our Partners</a></li>
            <li><a href="#">How It Work</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h4>Help</h4>
          <ul class="social_footer_link">
            <li><a href="#">Sign In</a></li>
            <li><a href="#">Register</a></li>
            <li><a href="#">Add Listing</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
        </div>        
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="footer_copyright_part">Copyright © 2022 All Rights Reserved.</div>
        </div>
      </div>
    </div>
  </div>  
  <div id="bottom_backto_top"><a href="#"></a></div>
</div>

<!-- Scripts --> 
<script src="scripts/jquery-3.4.1.min.js"></script> 
<script src="scripts/chosen.min.js"></script> 
<script src="scripts/slick.min.js"></script> 
<script src="scripts/rangeslider.min.js"></script> 
<script src="scripts/magnific-popup.min.js"></script> 
<script src="scripts/jquery-ui.min.js"></script> 
<script src="scripts/bootstrap-select.min.js"></script> 
<script src="scripts/mmenu.js"></script>
<script src="scripts/tooltips.min.js"></script> 
<script src="scripts/color_switcher.js"></script>
<script src="scripts/jquery_custom.js"></script>
<script src="scripts/typed.js"></script>
<script src="scripts/functions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
var typed = new Typed('.typed-words', {
strings: ["Hair Sales"," Hair Rentals"," Hair Business Partnership","Jewelleries","Skincare","Perfumes"],
	typeSpeed: 80,
	backSpeed: 80,
	backDelay: 4000,
	startDelay: 1000,
	loop: true,
	showCursor: true
});

<?php
if (count($arAdditionalJs) > 0)
{
  echo implode(PHP_EOL, $arAdditionalJs);
}
?>

</script>

<script>
$(document).ready(function() {
  <?php
  if (count($arAdditionalJsOnLoad) > 0)
  {
    echo implode(PHP_EOL, $arAdditionalJsOnLoad);
  }
  ?>
  
  //REGISTER
  $('#registerForm #btnSubmit').click(function ()
  {
    var formId = '#registerForm';
    var fname = $(formId+' #fname').val();
    var lname = $(formId+' #lname').val();
    var email = $(formId+' #email').val();
    var password1 = $(formId+' #password1').val();
    var password2 = $(formId+' #password2').val();

    if ((fname.length < 3 || lname.length < 3) || (fname.length > 50 || lname.length > 50))
    {
      throwError('Name is invalid');
    }
    else if (email.length < 13 || email.length > 100)
    {
      throwError('Email is incorrect');
    }
    else if (password1.length < 6)
    {
      throwError('Password must contain at least 6 characters');
    }
    else if (password1 != password2)
    {
      throwError('Passwords do not match');
    }
    else
    {
      var $form = $("#registerForm");
      $.ajax({
        url: 'inc/actions',
        type: 'POST',
        dataType: 'json',
        data: $form.serialize(),
        beforeSend: function() {
          enableDisableBtn(formId+' #btnSumbmit', 0);
        },
        complete: function() {
          enableDisableBtn(formId+' #btnSumbmit', 1);
        },
        success: function(data)
        {
          if(data.status == true)
          {
            showAlert('Registration successful!', 'alert_register', 'success');
            $form[0].reset();
            //redirect to dashboard
            window.location.href = "/app/";
          }
          else
          {
            if(data.info !== undefined)
            {
              showAlert(data.msg, 'alert_register', 'notice');
            }
            else
            {
              showAlert(data.msg, 'alert_register', 'error');
            }
          }
        }
      });
    }
  });

  //LOGIN
  $('#loginForm #btnSubmit').click(function ()
  {
    var formId = '#loginForm';
    var email = $(formId+' #email').val();
    var password = $(formId+' #password').val();

    if (email.length < 13 || email.length > 100)
    {
      throwError('Email is invalid');
    }
    else if (password.length < 6)
    {
      throwError('Password is invalid');
    }
    else
    {
      var $form = $("#loginForm");
      $.ajax({
        url: 'inc/actions',
        type: 'POST',
        dataType: 'json',
        data: $form.serialize(),
        beforeSend: function() {
          enableDisableBtn(formId+' #btnSumbmit', 0);
        },
        complete: function() {
          enableDisableBtn(formId+' #btnSumbmit', 1);
        },
        success: function(data)
        {
          if(data.status == true)
          {
            showAlert('Login successful!', 'alert_login', 'success');
            $form[0].reset();
            //redirect to dashboard
            window.location.href = '<?=DEF_FULL_BASE_PATH_URL; ?>'+'app/';
          }
          else
          {
            if(data.info !== undefined)
            {
              showAlert(data.msg, 'alert_login', 'notice');
            }
            else
            {
              showAlert(data.msg, 'alert_login', 'error');
            }
          }
        }
      });
    }
  });
});
</script>
</body>
</html>