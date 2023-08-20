<?php
$pageTitle = 'Add Listing';
require_once 'inc/head.php';
?>

<div id="dashboard">
    <?php require_once 'inc/sidebar.php'; ?>

	<div class="utf_dashboard_content"> 
        <div id="titlebar" class="dashboard_gradient">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dashboard</h2>
                    <nav id="breadcrumbs">
                    <ul>
                        <li><a href="<?=DEF_FULL_BASE_PATH_URL;?>">Home</a></li>
                        <li><a href="app/">Dashboard</a></li>
                        <li>Add Listing</li>
                    </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div id="utf_add_listing_part">
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-tag"></i> Categories & Tags</h3>
                        </div>              
                        <div class="row with-forms">
                            <div class="col-md-6">
                                <h5>Listing Title</h5>
                                <input type="text" class="search-field" name="listing_title" id="listing_title" placeholder="Listing Title" value="">
                            </div>
                            <div class="col-md-6">
                                <h5>Keywords</h5>                  
                                <input type="text" name="keywords" id="keywords" placeholder="Keywords..." value="">
                            </div>
                        </div>              
                        <div class="row with-forms">                 
                            <div class="col-md-6">
                                <h5>Category</h5>
                                <div class="intro-search-field utf-chosen-cat-single">
                                    <select class="selectpicker default" data-selected-text-format="count" data-size="7" title="Select Category">
                                        <option>Eat & Drink</option>
                                        <option>Shops</option>
                                        <option>Hotels</option>
                                        <option>Restaurants</option>
                                        <option>Fitness</option>
                                        <option>Events</option>						
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Tags(optional)</h5>
                                <div class="intro-search-field utf-chosen-cat-single">
                                    <select class="selectpicker default" data-selected-text-format="count" data-size="7" title="Select Tags">
                                        <option>One</option>
                                        <option>Two</option>
                                        <option>Three</option>
                                        <option>Four</option>
                                        <option>Five</option> 						
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row with-forms">
                            <div class="col-md-12">
                                <h5>Listing Tags</h5>
                                <input type="text" class="search-field" name="listing_title" id="listing_title" placeholder="Listing Tags" value="">
                            </div>				
                        </div>
                    </div>
                    
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-map"></i> Location</h3>
                        </div>
                        <div class="utf_submit_section"> 
                            <div class="row with-forms"> 				
                                <div class="col-md-6">
                                    <h5>City</h5>
                                    <div class="intro-search-field utf-chosen-cat-single">
                                        <select class="selectpicker default" data-selected-text-format="count" data-size="7" title="Select City">
                                            <option>New York</option>
                                            <option>Argentina</option>
                                            <option>Chicago</option>
                                            <option>Azerbaijan</option>
                                            <option>Indonesia</option>
                                            <option>India</option>
                                            <option>Thailand</option>
                                            <option>Gambia</option>
                                            <option>Spain</option>
                                            <option>Iraq</option> 						
                                        </select>
                                    </div>
                                </div>                  
                                <div class="col-md-6">
                                    <h5>Address</h5>                    
                                    <input type="text" class="input-text" name="address" id="address" placeholder="Address" value="">
                                </div>                  
                                <div class="col-md-12">
                                    <h5>Decimal Degrees</h5>                    
                                    <div class="row with-forms">
                                        <div class="col-md-6">
                                            <input type="text" class="input-text" name="latitude" id="latitude" placeholder="40.7324319" value="">
                                        </div>
                                        <div class="col-md-6">                    
                                            <input type="text" class="input-text" name="longitude" id="longitude" placeholder="-73.824807777775" value="">
                                        </div> 
                                    </div> 	
                                </div>				  				  
                                <div id="utf_listing_location" class="col-md-12 utf_listing_section">
                                    <div id="utf_single_listing_map_block">
                                        <div id="utf_single_listingmap" data-latitude="40.7324319" data-longitude="-73.824807777775" data-map-icon="im im-icon-Hamburger"></div>
                                        <a href="#" id="utf_street_view_btn">Street View</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-picture"></i> Images</h3>
                        </div>			  
                        <div class="row with-forms">              
                            <div class="utf_submit_section col-md-4">
                                <h4>Logo</h4>
                                <form action="http://ulisting.utouchdesign.com/ulisting_ltr/file-upload" class="dropzone"></form>
                            </div>
                            <div class="utf_submit_section col-md-4">
                                <h4>Cover Image</h4>
                                <form action="http://ulisting.utouchdesign.com/ulisting_ltr/file-upload" class="dropzone"></form>
                            </div>
                            <div class="utf_submit_section col-md-4">
                                <h4>Gallery Images</h4>
                                <form action="http://ulisting.utouchdesign.com/ulisting_ltr/file-upload" class="dropzone"></form>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-list"></i> Name & Description</h3>
                        </div>              
                        <div class="row with-forms">
                            <div class="col-md-6">
                                <h5>Name</h5>
                                <input type="text" placeholder="Name">
                            </div>	
                            <div class="col-md-6">
                                <h5>Email</h5>
                                <input type="text" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <h5>Title</h5>
                                <input type="text" placeholder="Title">
                            </div>
                            <div class="col-md-6">
                                <h5>Tagline</h5>
                                <input type="text" placeholder="Tagline">
                            </div>				  				 
                            <div class="col-md-12">
                                <h5>Description</h5>
                                <textarea name="summary" cols="40" rows="3" id="description" placeholder="Description..." spellcheck="true"></textarea>
                            </div>
                        </div>                
                    </div>

                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-home"></i> Amenities</h3>
                        </div>              
                        <div class="checkboxes in-row amenities_checkbox">
                            <ul>
                                <li>
                                    <input id="check-a" type="checkbox" name="check">
                                    <label for="check-a">Car Parking</label>
                                </li>
                                <li>
                                    <input id="check-b" type="checkbox" name="check">
                                    <label for="check-b">Takes Reservations</label>
                                </li>
                                <li>
                                    <input id="check-c" type="checkbox" name="check">
                                    <label for="check-c">Street Parking</label>
                                </li>
                                <li>
                                    <input id="check-d" type="checkbox" name="check">
                                    <label for="check-d">Elevator in Building</label>
                                </li>
                                <li>
                                    <input id="check-e" type="checkbox" name="check">
                                    <label for="check-e">Outdoor Seating</label>
                                </li>
                                <li>
                                    <input id="check-f" type="checkbox" name="check">
                                    <label for="check-f">Friendly Workspace</label>	
                                </li>
                                <li>
                                    <input id="check-g" type="checkbox" name="check">
                                    <label for="check-g">Wireless Internet</label>
                                </li>
                                <li>
                                    <input id="check-h" type="checkbox" name="check" >
                                    <label for="check-h">Good for Kids</label>
                                </li>
                                <li>
                                    <input id="check-i" type="checkbox" name="check" >
                                    <label for="check-i">Events</label>
                                </li>
                                <li>
                                    <input id="check-j" type="checkbox" name="check">
                                    <label for="check-j">Smoking Allowed</label>
                                </li>
                                <li>
                                    <input id="check-k" type="checkbox" name="check">
                                    <label for="check-k">Wheelchair Accessible</label>
                                </li>
                                <li>
                                    <input id="check-l" type="checkbox" name="check">
                                    <label for="check-l">Accepted Bank Cards</label>
                                </li>
                            </ul>
                        </div>          
                    </div>
                    
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-clock"></i> Opening Hours</h3>                
                        </div>              
                        <div class="switcher-content"> 
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Monday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                            
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Tuesday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                            
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Wednesday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                            
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Thursday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                            
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Friday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                            
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Saturday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                            
                            <div class="row utf_opening_day utf_js_demo_hours">
                                <div class="col-md-2">
                                    <h5>Sunday :-</h5>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Open Time"></select>
                                </div>
                                <div class="col-md-5">
                                    <select class="utf_chosen_select" data-placeholder="Close Time"></select>
                                </div>
                            </div>
                        </div>                            
                    </div>
                    
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-tag"></i> Add Pricing</h3>
                        </div>              
                        <div class="row">
                        <div class="col-md-12">
                            <table id="utf_pricing_list_section">
                            <tbody class="ui-sortable">
                                <tr class="pricing-list-item pattern ui-sortable-handle">
                                <td><div class="fm-move"><i class="sl sl-icon-cursor-move"></i></div>
                                    <div class="fm-input pricing-name">
                                    <input type="text" placeholder="Title">
                                    </div>
                                    <div class="fm-input pricing-ingredients">
                                    <input type="text" placeholder="Description">
                                    </div>
                                    <div class="fm-input pricing-price"><i class="data-unit">$</i>
                                    <input type="text" placeholder="Price" data-unit="$">
                                    </div>
                                    <div class="fm-close"><a class="delete" href="#"><i class="fa fa-remove"></i></a></div></td>
                                </tr>
                            </tbody>
                            </table>
                            <a href="#" class="button add-pricing-list-item">Add Item</a> <a href="#" class="button add-pricing-submenu">Add Category</a> </div>
                        </div>                          
                    </div>					
                    
                    <div class="add_utf_listing_section margin-top-45"> 
                        <div class="utf_add_listing_part_headline_part">
                            <h3><i class="sl sl-icon-docs"></i> Your Listing Feature</h3>
                        </div>              
                        <div class="checkboxes in-row amenities_checkbox">
                            <ul>
                                <li>
                                    <input id="check-a1" type="checkbox" name="check">
                                    <label for="check-a1">Accepts Credit Cards</label>
                                </li>
                                <li>
                                    <input id="check-b1" type="checkbox" name="check">
                                    <label for="check-b1">Smoking Allowed</label>
                                </li>
                                <li>
                                    <input id="check-c1" type="checkbox" name="check">
                                    <label for="check-c1">Bike Parking</label>
                                </li>
                                <li>
                                    <input id="check-d1" type="checkbox" name="check">
                                    <label for="check-d1">Hostels</label>
                                </li>
                                <li>
                                    <input id="check-e1" type="checkbox" name="check">
                                    <label for="check-e1">Wheelchair Accessible</label>
                                </li>
                                <li>
                                    <input id="check-f1" type="checkbox" name="check">
                                    <label for="check-f1">Wheelchair Internet</label>	
                                </li>
                                <li>
                                    <input id="check-g1" type="checkbox" name="check">
                                    <label for="check-g1">Wheelchair Accessible</label>
                                </li>
                                <li>
                                    <input id="check-h1" type="checkbox" name="check">
                                    <label for="check-h1">Parking Street</label>
                                </li>
                                <li>
                                    <input id="check-i1" type="checkbox" name="check">
                                    <label for="check-i1">Wireless Internet</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="#" class="button preview">Save & Preview</a> </div>
                </div>
            </div>
		
            <?php require_once 'inc/footer.php'; ?>

        </div>
    </div>
</div>

<?php
$arAdditionalJs[] = <<<EOQ
    <script src="scripts/dropzone.js"></script>
EOQ;
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#profileForm #btnSubmit').click(function ()
    {
        var formId = '#profileForm';
        var fname = $(formId+' #fname').val();
        var lname = $(formId+' #lname').val();
        var phone = $(formId+' #phone').val();
        var businessName = $(formId+' #business_name').val();
        var businessInfo = $(formId+' #business_info').val();
        var addressCity = $(formId+' #address_city').val();
        var addressState = $(formId+' #address_state').val();

        if (fname.length < 3 || lname.length < 3 || phone.length < 11 || phone.length > 15 ||businessName.length < 5 || businessInfo.length < 20 || addressCity.length < 3 || addressState.length < 3)
        {
            throwError('Please fill all required fields');
        }
        else
        {
            var formData = new FormData(this.form);
            $.ajax({
                url: 'inc/actions',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
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
                        throwSuccess('Business details updated successfully!');
                        $(formId+' #fname').val(data.data['fname']);
                        $(formId+' #lname').val(data.data['lname']);
                        $(formId+' #phone').val(data.data['phone']);
                        $(formId+' #business_name').val(data.data['business_name']);
                        $(formId+' #business_type_id').val(data.data['business_type_id']);
                        $(formId+' #business_info').val(data.data['business_info']);
                        $(formId+' #address_street').val(data.data['address_street']);
                        $(formId+' #address_city').val(data.data['address_city']);
                        $(formId+' #address_state').val(data.data['address_state']);
                        $(formId+' #facebook').val(data.data['facebook']);
                        $(formId+' #instagram').val(data.data['instagram']);
                        $(formId+' #twitter').val(data.data['twitter']);
                        $(formId+' #logo').val('');
                        $(formId+' #cover_img').val('');
                        $('#userLogo').attr('src', 'images/Lamba/users/'+data.data['logo']);
                    }
                    else
                    {
                        if(data.info !== undefined)
                        {
                            throwInfo(data.msg);
                        }
                        else
                        {
                            throwError(data.msg);
                        }
                    }
                }
            });
        }
    });
EOQ;

require_once 'inc/foot.php';
?>