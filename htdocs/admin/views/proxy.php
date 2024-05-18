
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="csrf-param" content="_csrf_admin">
<meta name="csrf-token" content="pkPwi7kjT1WGn3MUH3zOGzUv2giPQ_5AMVgJSSKzi_WWL57p11MmZ9f-FHpPGP5KAQLtSbkriQVuLj4BT_y7hw==">
    <title>General</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://instasmm.club/css/main.css?v=1625229498" rel="stylesheet">  </head>
  <body class="">
    
    <noscript>You need to enable JavaScript to run this app.</noscript>

    <nav class="navbar navbar-fixed-top navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" data-nav="navbar-priority" id="bs-navbar-collapse">
            <ul id="w3" class="nav navbar-nav"><li><a href="/admin/users">Users</a></li>
<li><a href="/admin/orders">Orders</a></li>
<li><a href="/admin/services">Services</a></li>
<li><a href="/admin/payments">Payments</a></li>
<li><a href="/admin/tickets">Tickets <span class="badge badge-tickets"></span></a></li>
<li><a href="/admin/reports">Reports</a></li>
<li><a href="/admin/appearance">Appearance</a></li>
<li class="active"><a href="/admin/settings">Settings</a></li></ul><ul id="w4" class="nav navbar-nav navbar-right"><li id="dark" class="nav-dark-mode"><a href="#"><i class="fas fa-moon"></i></a></li>
<li><a href="/admin/account">Account</a></li>
<li><a href="/admin/logout">Logout</a></li></ul>        </div>
      </div>
    </nav>

    
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            
<ul class="nav nav-pills nav-stacked p-b">
                        <li class="active" ><a href="/admin/settings">General</a></li>
                                <li class="" ><a href="/admin/settings/providers">Providers</a></li>
                                <li class="" ><a href="/admin/settings/payments">Payments</a></li>
                                            <li class="" ><a href="/admin/settings/integrations">Integrations</a></li>
                                <li class="" ><a href="/admin/settings/notifications">Notifications</a></li>
                                <li class="" ><a href="/admin/settings/bonuses">Bonuses</a></li>
            </ul>        </div>
        <div class="col-md-8">
            


<form id="EditGeneralForm" action="/admin/settings" method="post" enctype="multipart/form-data">
<input type="hidden" name="_csrf_admin" value="pkPwi7kjT1WGn3MUH3zOGzUv2giPQ_5AMVgJSSKzi_WWL57p11MmZ9f-FHpPGP5KAQLtSbkriQVuLj4BT_y7hw=="><div class="panel panel-default">
    <div class="panel-body">
        <div id="EditGeneralFormErrors" class="error-summary alert alert-danger hidden"></div>                <div class="form-group">
            <div class="row">
                <div class="col-md-11">
                    <div class="form-group field-editgeneralform-favicon_file">
<label class="control-label" for="editgeneralform-favicon_file">Favicon</label>
<input type="hidden" name="EditGeneralForm[favicon_file]" value=""><input type="file" id="editgeneralform-favicon_file" name="EditGeneralForm[favicon_file]" data-target="#favicon_preview" accept=".png,.jpg,.jpeg,.gif,.ico,.swg">
</div>                    <p class="help-block">16 x 16px .png recommended</p>
                </div>
                <div class=" col-md-1">
                    <div class="image_container hidden">
                        <div class="modal-loader hidden"></div>
                        <div class="setting-block__image">
                            <img id="favicon_preview" class="img-thumbnail" src="">
                            <div class="setting-block__image-remove">
                                <a href="/admin/settings/delete-favicon"
                                   class="delete_image_action"><span class="glyphicon glyphicon-remove"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
                <div class="form-group field-editgeneralform-timezone required">
<label class="control-label" for="editgeneralform-timezone">Timezone</label>
<select id="editgeneralform-timezone" class="form-control" name="EditGeneralForm[timezone]" aria-required="true">
<option value="-43200">(UTC -12:00) Baker/Howland Island</option>
<option value="-39600">(UTC -11:00) Niue</option>
<option value="-36000">(UTC -10:00) Hawaii-Aleutian Standard Time, Cook Islands, Tahiti</option>
<option value="-34200">(UTC -9:30) Marquesas Islands</option>
<option value="-32400">(UTC -9:00) Alaska Standard Time, Gambier Islands</option>
<option value="-28800">(UTC -8:00) Pacific Standard Time, Clipperton Island</option>
<option value="-25200">(UTC -7:00) Mountain Standard Time</option>
<option value="-21600">(UTC -6:00) Central Standard Time</option>
<option value="-18000">(UTC -5:00) Eastern Standard Time, Western Caribbean Standard Time</option>
<option value="-16200">(UTC -4:30) Venezuelan Standard Time</option>
<option value="-14400">(UTC -4:00) Atlantic Standard Time, Eastern Caribbean Standard Time</option>
<option value="-12600">(UTC -3:30) Newfoundland Standard Time</option>
<option value="-10800">(UTC -3:00) Argentina, Brazil, French Guiana, Uruguay</option>
<option value="-7200">(UTC -2:00) South Georgia/South Sandwich Islands</option>
<option value="-3600">(UTC -1:00) Azores, Cape Verde Islands</option>
<option value="0" selected>(UTC) Greenwich Mean Time, Western European Time</option>
<option value="3600">(UTC +1:00) Central European Time, West Africa Time</option>
<option value="7200">(UTC +2:00) Central Africa Time, Eastern European Time, Kaliningrad Time</option>
<option value="10800">(UTC +3:00) Moscow Time, East Africa Time, Arabia Standard Time</option>
<option value="12600">(UTC +3:30) Iran Standard Time</option>
<option value="14400">(UTC +4:00) Azerbaijan Standard Time, Samara Time</option>
<option value="16200">(UTC +4:30) Afghanistan</option>
<option value="18000">(UTC +5:00) Pakistan Standard Time, Yekaterinburg Time</option>
<option value="19800">(UTC +5:30) Indian Standard Time, Sri Lanka Time</option>
<option value="20700">(UTC +5:45) Nepal Time</option>
<option value="21600">(UTC +6:00) Bangladesh Standard Time, Bhutan Time, Omsk Time</option>
<option value="23400">(UTC +6:30) Cocos Islands, Myanmar</option>
<option value="25200">(UTC +7:00) Krasnoyarsk Time, Cambodia, Laos, Thailand, Vietnam</option>
<option value="28800">(UTC +8:00) Australian Western Standard Time, Beijing Time, Irkutsk Time</option>
<option value="31500">(UTC +8:45) Australian Central Western Standard Time</option>
<option value="32400">(UTC +9:00) Japan Standard Time, Korea Standard Time, Yakutsk Time</option>
<option value="34200">(UTC +9:30) Australian Central Standard Time</option>
<option value="36000">(UTC +10:00) Australian Eastern Standard Time, Vladivostok Time</option>
<option value="37800">(UTC +10:30) Lord Howe Island</option>
<option value="39600">(UTC +11:00) Srednekolymsk Time, Solomon Islands, Vanuatu</option>
<option value="41400">(UTC +11:30) Norfolk Island</option>
<option value="43200">(UTC +12:00) Fiji, Gilbert Islands, Kamchatka Time, New Zealand Standard Time</option>
<option value="45900">(UTC +12:45) Chatham Islands Standard Time</option>
<option value="46800">(UTC +13:00) Samoa Time Zone, Phoenix Islands Time, Tonga</option>
<option value="50400">(UTC +14:00) Line Island</option>
</select>
</div>        <div class="form-group field-editgeneralform-currency_format required">
<label class="control-label" for="editgeneralform-currency_format">Currency format</label>
<select id="editgeneralform-currency_format" class="form-control" name="EditGeneralForm[currency_format]" aria-required="true">
<option value="0" selected>1000.00</option>
<option value="1">1000,00</option>
<option value="2">1,000.12</option>
<option value="3">1,000</option>
</select>
</div>        <div class="form-group field-editgeneralform-service_auto_rate_format">
<label class="control-label" for="editgeneralform-service_auto_rate_format">Rates rounding&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title=" When import and sync"></span></label>
<select id="editgeneralform-service_auto_rate_format" class="form-control" name="EditGeneralForm[service_auto_rate_format]">
<option value="0">Ones (1)</option>
<option value="2">Hundredth (1.11)</option>
<option value="3" selected>Thousandth (1.111)</option>
</select>
</div>        <hr />
        <div class="form-group field-editgeneralform-ticket_system required">
<label class="control-label" for="editgeneralform-ticket_system">Ticket system</label>
<select id="editgeneralform-ticket_system" class="form-control" name="EditGeneralForm[ticket_system]" aria-required="true">
<option value="1" selected>Enabled</option>
<option value="0">Disabled</option>
</select>
</div>
        <div id="ticket_per_user" class="">
            <div class="form-group field-editgeneralform-ticket_per_user required">
<label class="control-label" for="editgeneralform-ticket_per_user">Max pending tickets per user</label>
<select id="editgeneralform-ticket_per_user" class="form-control" name="EditGeneralForm[ticket_per_user]" aria-required="true">
<option value="1">1 ticket</option>
<option value="2">2 tickets</option>
<option value="3">3 tickets</option>
<option value="4">4 tickets</option>
<option value="5">5 tickets</option>
<option value="6">6 tickets</option>
<option value="7">7 tickets</option>
<option value="8">8 tickets</option>
<option value="9">9 tickets</option>
<option value="0" selected>Unlimited</option>
</select>
</div>
            <hr />
        </div>

        <div class="form-group field-editgeneralform-registration_page required">
<label class="control-label" for="editgeneralform-registration_page">Signup page&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Allows user signup"></span></label>
<select id="editgeneralform-registration_page" class="form-control" name="EditGeneralForm[registration_page]" aria-required="true">
<option value="1" selected>Enabled</option>
<option value="0">Disabled</option>
</select>
</div>        <div class="form-group field-editgeneralform-email_confirmation">
<label class="control-label" for="editgeneralform-email_confirmation">Email confirmation&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Enables mandatory email confirmation for the user after signing up"></span></label>
<select id="editgeneralform-email_confirmation" class="form-control" name="EditGeneralForm[email_confirmation]">
<option value="1">Enabled</option>
<option value="0" selected>Disabled</option>
</select>
</div>        <div class="form-group field-editgeneralform-skype_field required">
<label class="control-label" for="editgeneralform-skype_field">Skype field&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Set up Skype field on the Signup page"></span></label>
<select id="editgeneralform-skype_field" class="form-control" name="EditGeneralForm[skype_field]" aria-required="true">
<option value="1">Enabled</option>
<option value="0" selected>Disabled</option>
</select>
</div>        <div class="form-group field-editgeneralform-name_fields required">
<label class="control-label" for="editgeneralform-name_fields">Name fields&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Set up First name and Last name fields on the Signup page"></span></label>
<select id="editgeneralform-name_fields" class="form-control" name="EditGeneralForm[name_fields]" aria-required="true">
<option value="1">Enabled</option>
<option value="0" selected>Disabled</option>
</select>
</div>        <div class="form-group field-editgeneralform-terms_checkbox required">
<label class="control-label" for="editgeneralform-terms_checkbox">Terms checkbox&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="User must agree with the Terms of Service before sign up"></span></label>
<select id="editgeneralform-terms_checkbox" class="form-control" name="EditGeneralForm[terms_checkbox]" aria-required="true">
<option value="1">Enabled</option>
<option value="0" selected>Disabled</option>
</select>
</div>        <div class="form-group field-editgeneralform-forgot_password required">
<label class="control-label" for="editgeneralform-forgot_password">Reset password&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Allows user to reset password by email"></span></label>
<select id="editgeneralform-forgot_password" class="form-control" name="EditGeneralForm[forgot_password]" aria-required="true">
<option value="1" selected>Enabled</option>
<option value="0">Disabled</option>
</select>
</div>        <div class="form-group field-editgeneralform-minimum_drip_feed_interval">
<label class="control-label" for="editgeneralform-minimum_drip_feed_interval">Minimum drip-feed interval&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Set up a minimum drip-feed interval (in minutes) for all services"></span></label>
<input type="text" id="editgeneralform-minimum_drip_feed_interval" class="form-control" name="EditGeneralForm[minimum_drip_feed_interval]" value="1">
</div>                <hr />

                    <div class="form-group field-editgeneralform-google_verification_code">
<label class="control-label" for="editgeneralform-google_verification_code">Google verification code&nbsp;<span class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Copy and paste HTML-tag code using URL prefixed resource method"></span></label>
<input type="text" id="editgeneralform-google_verification_code" class="form-control" name="EditGeneralForm[google_verification_code]" value="fEEotTNAIqLCrImqSEzEyvuXkAtI_rhkUeEZKD9AHKc">
</div>        
        <hr />
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</div>

</form>        </div>
    </div>
</div>

    <script src="https://instasmm.club/js/jquery.min.js?v=1625229498"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://instasmm.club/assets/f20f7bf3/yii.js?v=1625229512"></script>
<script src="https://instasmm.club/assets/cd8e1cb7/js/bootstrap.js?v=1625229512"></script>
<script src="https://instasmm.club/assets/b2b1b357/bootstrap-notify.min.js?v=1604490963"></script>
<script src="https://instasmm.club/js/admin/nav-priority.js?v=1625229498"></script>
<script src="https://instasmm.club/js/underscore.js?v=1625229498"></script>
<script src="https://instasmm.club/js/admin.js?v=1625229498"></script>
<script>window.modules.layouts = {"theme_id":21,"auth":1};
window.modules.settingsGeneralController = [];</script>  </body>
</html>
