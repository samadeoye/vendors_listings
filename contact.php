<?php
require_once 'inc/utils.php';
$pageTitle = 'Contact';
require_once 'inc/head.php';

?>

<div id="titlebar" class="gradient margin-bottom-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Contact Us</h2>     
                <nav id="breadcrumbs">
                    <ul>
                    <li><a href="">Home</a></li>
                    <li>Contact Us</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row"> 
        <div class="col-md-8">
            <section id="contact" class="margin-bottom-70">
                <h4><i class="sl sl-icon-phone"></i> Contact Form</h4>          
                <form id="contactForm" onsubmit="return false;">
                    <div class="row">
                        <input type="hidden" name="action" id="action" value="sendContactForm">
                        <div class="col-md-6">  
                            <input name="fname" id="fname" type="text" placeholder="First Name">                
                        </div>
                        <div class="col-md-6">                
                            <input name="lname" id="lname" type="text" placeholder="Last Name">                
                        </div>
                        <div class="col-md-6">                
                            <input name="email" id="email" type="email" placeholder="Email">                
                        </div>
                        <div class="col-md-6">
                            <input name="subject" id="subject" type="text" placeholder="Subject">              
                        </div>
                        <div class="col-md-12">
                            <textarea  name="msg" id="msg" cols="40" rows="2" id="comments" placeholder="Your Message"></textarea>
                        </div>
                    </div>
                    <input type="submit" class="submit button" id="submit" value="Submit" />
                </form>
            </section>
        </div>
      
        <div class="col-md-4">
            <div class="utf_box_widget margin-bottom-70">
                <h3><i class="sl sl-icon-map"></i> Office Address </h3>
                <div class="utf_sidebar_textbox">
                    <ul class="utf_contact_detail">
                        <li><strong>Phone: </strong> <span><a href="tel:<?=SITE_PHONE;?>"> <?=SITE_PHONE;?> </a></span></li>
                        <li><strong>Website: </strong> <span><a href="<?=SITE_URL;?>"> <?=SITE_DOMAIN;?> </a></span></li>
                        <li><strong>E-mail: </strong> <span><a href="mailto:<?=SITE_EMAIL;?>"><?=SITE_EMAIL;?></a></span></li>
                        <li><strong>Address: </strong> <span> <?=SITE_ADDRESS;?> </span></li>
                    </ul>
                </div>	
            </div>
        </div>
    </div>
</div>

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#contactForm #submit').click(function()
    {
        var formId = '#contactForm';
        var fname = $(formId+' #fname').val();
        var lname = $(formId+' #lname').val();
        var email = $(formId+' #email').val();
        var subject = $(formId+' #subject').val();
        var message = $(formId+' #msg').val();

        if (fname.length < 3 || fname.length > 50)
        {
            throwError('First name is invalid');
        }
        else if (lname.length < 3 || lname.length > 50)
        {
            throwError('Last name is invalid');
        }
        else if (email.length < 13 || email.length > 100)
        {
            throwError('Email is invalid');
        }
        else if (subject.length > 0 && (subject.length < 5 || subject.length > 200))
        {
            throwError('Please enter a valid subject or leave it empty');
        }
        else if (message.length < 20)
        {
            throwError('Please enter a valid message');
        }
        else
        {
            var form = $('#contactForm');
            $.ajax({
                url: 'inc/actions',
                type: 'POST',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function() {
                    enableDisableBtn(formId+' #submit', 0);
                },
                complete: function() {
                    enableDisableBtn(formId+' #submit', 1);
                },
                success: function(data)
                {
                    if(data.status)
                    {
                        throwSuccess('Message sent successfully!');
                        form[0].reset();
                    }
                    else
                    {
                        throwError(data.msg);
                    }
                }
            });
        }
    });
EOQ;
require_once 'inc/foot.php';
?>