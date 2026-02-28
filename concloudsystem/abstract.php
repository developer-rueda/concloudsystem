<?php
include_once("includes/frontend.init.php");
include_once("includes/function.registration.php");
include_once("includes/function.delegate.php");
include_once("includes/function.invoice.php");
include_once("includes/function.workshop.php");
include_once("includes/function.dinner.php");
include_once("includes/function.accompany.php");
include_once("includes/function.abstract.php");
include_once('includes/function.accommodation.php');

//$mycms->redirect("login.php");

$mycms->removeAllSession();
$mycms->removeSession('SLIP_ID');

if ($cfg['ABSTRACT.SUBMIT.LASTDATE'] < date('Y-m-d')) {
  $isAbstractDate = false;
  //   $mycms->redirect("profile.php");
}

if (isset($_REQUEST['abstractDelegateId']) && trim($_REQUEST['abstractDelegateId']) != '') {
  $abstractDelegateId  = trim($_REQUEST['abstractDelegateId']);
  $userRec = getUserDetails($abstractDelegateId);
}


$sql   =  array();
$sql['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
											WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]	=	array('FILD' => 'status' ,     		 'DATA' => 'A' ,       	           'TYP' => 's');					 
$result = $mycms->sql_select($sql);
$row         = $result[0];

$header_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['logo_image'];
if ($row['logo_image'] != '') {
  $emailHeader  = $header_image;
}


$currentCutoffId  = getTariffCutoffId();

// $sqlcutoff['QUERY']   = "SELECT * FROM "._DB_TARIFF_CUTOFF_." WHERE status = 'A' AND `id` = ?";
// $sqlcutoff['PARAM'][] = array('FILD' => 'id', 'DATA' =>$currentCutoffId,  'TYP' => 's');
// $rescutoff          = $mycms->sql_select($sqlcutoff);
// $endDate          = $rescutoff[0]['end_date'];

// $endDate          = $cfg['ABSTRACT.SUBMIT.LASTDATE'] ;
// $dateArr          = explode("-",$endDate);

//========= fetching countdown date from abstract countdown ==========================//
$sqlFetchCountdown           = array();
$sqlFetchCountdown['QUERY']     = "SELECT * 
                    FROM " . _DB_COMPANY_INFORMATION_ . "
                    WHERE `id` != ''";
$resultFetchCountdown         = $mycms->sql_select($sqlFetchCountdown);
$rowFetchCountdownDate         = $resultFetchCountdown[0]['abstract_countdown_date'];
$dateArr          = explode("-", $rowFetchCountdownDate);
//print_r($dateArr);

if ($cfg['ABSTRACT.SUBMIT.LASTDATE'] >= date('Y-m-d')) {

  $_SESSION['PROCEED_2_ABSTRACT'] = 'OK';
  $_SESSION['PROCEED_EXPIRY'] = $_REQUEST['EXPIRY'];

  $operate        = true;
  $resultAbstractType   = false;
  if ($delegateId != '') {
    $rowUserDetails   = getUserDetails($delegateId);
    $invoiceList    = getConferenceContents($delegateId);
    $currentCutoffId  = getTariffCutoffId();

    $sql          = array();
    $sql['QUERY']     = " SELECT * 
                    FROM " . _DB_ABSTRACT_REQUEST_ . " 
                     WHERE `status` = ?
                     AND `applicant_id` = ?";
    //AND `abstract_child_type` IN ('Oral','Poster')

    $sql['PARAM'][]   = array('FILD' => 'status',         'DATA' => 'A',          'TYP' => 's');
    $sql['PARAM'][]   = array('FILD' => 'applicant_id',   'DATA' => $delegateId, 'TYP' => 's');
    $resultAbstractType = $mycms->sql_select($sql);

    $abstractCatArray = array();
    foreach ($resultAbstractType as $key => $cat_val) {
      //echo $cat_val['abstract_cat'];
      array_push($abstractCatArray, trim($cat_val['abstract_cat']));
    }

    //echo '<pre>'; print_r($resultAbstractType);
  }
}
?>



<!DOCTYPE html>
<html>

<?php
javaScriptDefinedValue();

include_once('header.php');

$cutoffs       = fullCutoffArray();
$currentCutoffId  = getTariffCutoffId();

$loginDetails   = login_session_control(false);
$delegateId    = $loginDetails['DELEGATE_ID'];

$operate     = false;

if (isset($_REQUEST['TOKEN']) && trim($_REQUEST['TOKEN']) != '') {
  $token = unserialize(base64_decode($_REQUEST['TOKEN']));
  if (is_array($token) && sizeof($token) > 0) {
    foreach ($token as $key => $val) {
      $_REQUEST[$key] = $val;
    }
  }
}

if ($_SESSION['PROCEED_2_ABSTRACT'] == 'OK') {
  $_REQUEST['PROCEED'] = 'OK';
  $_REQUEST['EXPIRY'] = $_SESSION['PROCEED_EXPIRY'];
}


$sqlHeader  = array();
$sqlHeader['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
                      WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]  = array('FILD' => 'status' ,         'DATA' => 'A' ,                   'TYP' => 's');          
$resultHeader = $mycms->sql_select($sqlHeader);
$rowHeader         = $resultHeader[0];

$header_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $rowHeader['logo_image'];
if ($rowHeader['logo_image'] != '') {
  $emailHeader  = $header_image;
}

?>

<body>

  <main>

    <?php include_once('sidebar_icon.php');

    //fetching website name from company information
    $sql   =  array();
    $sql['QUERY'] = "SELECT `invoice_website_name` FROM " . _DB_COMPANY_INFORMATION_ . " 
                WHERE `id`!=''";
    $result    = $mycms->sql_select($sql);
    $websiteName = $result[0]['invoice_website_name'];
    ?>

    <div class="mail-home"><a href="<?= $cfg['SITE_LINK'] ?>"><img src="<?= _BASE_URL_ ?>images/arrow-mail.png" alt="" /><?= " " . $cfg['SITE_URL'] ?></a></div>
    <!-- ============= PRIVACY SECTION ======================== -->
    <?php $sql   =  array();
    $sql['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
                    WHERE `id`!='' AND `purpose`='Side Icon' AND status ='A' ORDER BY `id`";
    // $sql['PARAM'][]	=	array('FILD' => 'status' ,  'DATA' => 'A' , 'TYP' => 's');					 
    $result    = $mycms->sql_select($sql);
    if ($result) {
    ?>
      <div class="policy-section">
        <ul>
          <?php
          foreach ($result as $i => $row) {
            @$i++;
            $icon_image = $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['icon']; ?>
            <li>
              <a href="<?= _BASE_URL_ . $row['page_link'] ?>"><img src="<?= $icon_image ?>" alt="" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="500" /> <span><?= $row['title'] ?></span></a>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>
      </div>


      <div class="login-wrap">
        <section class="login-main-section abstract-login">
          <div class="login-greadient-sec">
            <div class="login-section">
              <div class="logo">
                <img src="<?= $emailHeader ?>" />
              </div>
              <div class="log-in-heading mb-0">
                <?
                // REGISTRATION RELATED OPERATION
                $registrationClassificationId   = $mycms->getSession('CLSF_ID_FRONT');
                $registrationCutoffId           = $mycms->getSession('CUTOFF_ID_FRONT');
                $registrationMode             = $mycms->getSession('REGISTRATION_MODE');

                $sql   =  array();
                $sql['QUERY']    = "SELECT * FROM " . _DB_COMPANY_INFORMATION_ . " 
                                WHERE `id` = 1";
                $result       = $mycms->sql_select($sql);
                $row         = $result[0];
                $invalidEmail = $row['notification_invalid_email'];
                $registeredEmail = $row['notification_registered_email'];
                $emptyEmail = $row['notification_empty_email'];
                ?>
                <form name="absRegisterForm" id="absRegisterForm" method="post" action="<?= _BASE_URL_ ?>abstract.user.entrypoint.process.php" enctype="multipart/form-data">
                  <input type="hidden" name="act" value="step1" />
                  <input type="hidden" name="reg_area" value="FRONT" />
                  <input type="hidden" name="otp_id" id="otp_id" value="" />
                  <input type="hidden" name="registration_request" id="registration_request" value="ABSTRACT" />
                  <input type="hidden" name="registration_cutoff" id="registration_cutoff" value="<?= $registrationCutoffId ?>" />
                  <input type="hidden" name="registration_classification_id[]" id="registration_classification_id" value="<?= $registrationClassificationId ?>" />
                  <input type="hidden" name="registrationMode" id="registrationMode" value="<?= $registrationMode ?>" />
                  <div class="morefildinfo">
                    <div class="form-group mb-4">
                      <label for="floatingInput">Email Address</label>
                      <div class="index-go align-items-center d-flex">
                        <span class="emailicon"> <img src="images/email-R.png" alt=""></span>
                        <input type="hidden" id="registeredEmail" value="<?= $registeredEmail ?>">
                        <input type="hidden" id="invalidEmail" value="<?= $invalidEmail ?>">
                        <input type="hidden" id="emptyEmail" value="<?= $emptyEmail ?>">
                        <input type="abstract_presenter_email" class="form-control" id="abstract_presenter_email" placeholder="E-mail" name="user_email_id" <?php if ($cfg['ABSTRACT.SUBMIT.LASTDATE'] < date('Y-m-d')) {
                                                                                                                                                              echo 'style="pointer-events:none;filter: blur(1.2px)"';
                                                                                                                                                            } ?>>
                       
                      </div>
                       <div class="d-flex justify-content-end">
                         <button type="button" id="checkUserEmail" class="btn">Go</button>
                       </div>
                    </div>
                    <div class="form-group mb-4" id="unique" style="display:none;">
                      <label for="floatingInput">unique Sequence</label>
                      <div class="index-go align-items-center d-flex">
                        <span class="emailicon"> <img src="images/password-line-icon.png" alt=""></span>
                        <input class="form-control" type="text" name="user_unique_sequence" id="user_unique_sequence" value="#" placeholder="Ex: #00000000" onkeypress="return isNumber(event)">
                        <!-- <button type="button" class="btn" id="login_operation">Login</button> -->
                      </div>
                    </div>
                    <div style="display: none;" id="abstract_basic_details">
                      <div class="form-group mb-4">
                        <label for="floatingInput">Mobile</label>
                        <!-- <input type="text" class="form-control" id="floatingInput" placeholder=""> -->
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/phone-R.png" alt=""></span>
                          <input type="text" class="form-control " name="user_mobile" id="user_mobile" maxlength="10" onkeypress="return isNumber(event)" required validate="Please enter mobile No.">
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label>Title</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/Name-R.png" alt=""></span>
                          <div class="checkbox-wrap">
                            <label class="container-box custom-radio" style="float:left; margin:0 10px;">Dr
                              <input type="radio" name="user_initial_title" value="Dr" required>
                              <span class="checkmark"></span>
                            </label>
                            <label class="container-box custom-radio" style="float:left; margin:0 10px;">Prof
                              <input type="radio" name="user_initial_title" value="Prof">
                              <span class="checkmark"></span>
                            </label>
                            <label class="container-box custom-radio" style="float:left; margin:0 10px;">Mr
                              <input type="radio" name="user_initial_title" value="Mr">
                              <span class="checkmark"></span>
                            </label>
                            <label class="container-box custom-radio" style="float:left; margin:0 10px;">Ms
                              <input type="radio" name="user_initial_title" value="Ms">
                              <span class="checkmark"></span>
                            </label>
                            <label class="container-box custom-radio" style="float:left; margin:0 10px;">Mrs
                              <input type="radio" name="user_initial_title" value="Mrs">
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label for="floatingInput">First name</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/Name-R.png" alt=""></span>
                          <input type="text" class="form-control " id="user_first_name" name="user_first_name" placeholder="" validate="Please enter first name">
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label for="floatingInput">Middle Name</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/Name-R.png" alt=""></span>
                          <input type="text" class="form-control " id="user_middle_name" name="user_middle_name" placeholder="" validate="Please enter middle name">
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label for="floatingInput">Last Name</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/Name-R.png" alt=""></span>
                          <input type="text" class="form-control " id="user_last_name" name="user_last_name" placeholder="" validate="Please enter last name">
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label for="floatingSelect">Country</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/country-R.png" alt=""></span>
                          <select class="form-control select" name="user_country" id="user_country" forType="country" style="text-transform:uppercase;" required validate="Please select country">
                            <option value="">-- Select Country --</option>
                            <?php
                            $sqlFetchCountry   = array();
                            $sqlFetchCountry['QUERY']    = "SELECT * FROM " . _DB_COMN_COUNTRY_ . " 
                                                         WHERE `status` =? 
                                                      ORDER BY `country_name` ASC";

                            $sqlFetchCountry['PARAM'][]   = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');

                            $resultFetchCountry = $mycms->sql_select($sqlFetchCountry);
                            if ($resultFetchCountry) {
                              foreach ($resultFetchCountry as $keyCountry => $rowFetchCountry) {
                            ?>
                                <option value="<?= $rowFetchCountry['country_id'] ?>"><?= $rowFetchCountry['country_name'] ?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label for="floatingSelect">State</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/state-R.png" alt=""></span>
                          <select class="form-control select" name="user_state" id="user_state" forType="state" style="text-transform:uppercase;" required validate="Please select state">
                            <option value="">-- Select Country First --</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <label for="floatingInput">City</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/city-R.png" alt=""></span>
                          <input type="text" class="form-control " name="user_city" id="user_city" value="" style="text-transform:uppercase;" required validate="Please enter the city">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="floatingInput">Postal Code</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/postal-R.png" alt=""></span>
                          <input type="text" class="form-control " name="user_postal_code" id="user_postal_code" onkeypress="return isNumber(event)" required validate="Please enter the postal code">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="floatingInput">Institute</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/postal-R.png" alt=""></span>
                          <input type="text" class="form-control " name="user_institution" id="user_institution" required validate="Please enter the institution name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="floatingInput">Department</label>
                        <div class="index-go align-items-center d-flex">
                          <span class="emailicon"> <img src="images/postal-R.png" alt=""></span>
                          <input type="text" class="form-control " name="user_depertment" id="user_depertment" required validate="Please enter department">
                        </div>
                      </div>
                      <!-- <button type="button" class="btn" id="abstractSubmit">Submit</button> -->
                    </div>
                  </div>

                </form>

              </div>

              <div class="login-buttons">
                <!-- <a href="<?= _BASE_URL_ ?>index.php" class="login-btns">Login</a> -->
                <br><br><br>

                <!-- <a href="<?= _BASE_URL_ ?>registration.tariff.php" class="login-btns">Register Now</a> -->
                <a href="javascript:void(0)" id="login_operation" class="login-btns" style="display: none;">Login</a>
                <a href="javascript:void(0)" id="abstractSubmit" class="login-btns" style="display: none;">Submit</a>
                <!--<a href="#" class="login-btns">Pay Now</a>-->
              </div>
            </div>
          </div>
          <div class="login-greadient-sec">
            <div class="login-section">
              <div class="countdown-wraper">
                <?php
                $sqlFetchCountdown           = array();
                $sqlFetchCountdown['QUERY']     = "SELECT * 
                                    FROM " . _DB_COMPANY_INFORMATION_ . "
                                    WHERE `id` != ''";
                $resultFetchCountdown         = $mycms->sql_select($sqlFetchCountdown);
                $rowFetchCountdown             = $resultFetchCountdown[0];
                if ($rowFetchCountdown) {
                ?>
                  <h5><?= $rowFetchCountdown['abstract_countdown_text'] ?></h5>
                <?php } ?>
                <div class="countdown">


                  <div class="col-xs-3 timeLeftDays">
                    <p style="margin-bottom: 0; color: white;"><span id="dday">000</span></p>
                    <p>DAY</p>
                  </div>
                  <div class="col-xs-3 bloc-time hours">
                    <p style="margin-bottom: 0;color: white;"><span id="dhour">00</span>

                    </p>
                    <p>HOUR</p>
                  </div>
                  <div class="col-xs-3 bloc-time min">
                    <p style="margin-bottom: 0;color: white;"><span id="dmin">00</span>
                    <p>MIN</p>
                  </div>
                  <div class="col-xs-3 bloc-time sec">
                    <p style="margin-bottom: 0;color: white;"><span id="dsec">00</span>
                    <p>SEC</p>
                  </div>

                </div>
                <div class="hour-text">


                </div>
              </div>
              <div class="slider-home">
                <?php
                $sqlFlyer    =   array();
                $sqlFlyer['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
                                      WHERE status='A' AND title='Flyer' ";

                $resultFlyer      = $mycms->sql_select($sqlFlyer);
                if ($resultFlyer) {
                ?>
                  <div class="slider-home-inner" id="popup-slider">
                    <?php
                    foreach ($resultFlyer as $k => $val) {
                      $icon_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $val['image'];
                    ?>
                      <div class="slider-home-inner-popup"> <img src="<?= $icon_image ?>" width="100%" />
                      </div>
                    <?php
                    }
                    ?>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </section>
      </div>
  </main>

  <script type="text/javascript">
    $(document).ready(function() {

      // var isAbstractDate = <?= $isAbstractDate ?>;
      // if (isAbstractDate==false) {

      //   toastr.success("The abstract submission deadline has passed!", 'Error', {
      //     "progressBar": true,
      //     "timeOut": 5000,
      //     "showMethod": "slideDown",
      //     "hideMethod": "slideUp"
      //   });

      // }

      $('#checkUserEmail').click(function() {
        var emailId = $('#abstract_presenter_email').val();
        var flag = 0;
        if (emailId != '') {
          var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

          if (filter.test(emailId)) {
            console.log(jsBASE_URL + 'returnData.process.php?act=getEmailValidation&email=' + emailId);

            setTimeout(function() {

              $.ajax({

                type: "POST",
                url: jsBASE_URL + 'returnData.process.php',
                data: 'act=getEmailValidationStatusAbstract&email=' + emailId,
                dataType: 'json',
                async: false,
                success: function(JSONObject) {
                  console.log(JSONObject);

                  if (JSONObject.STATUS == 'IN_USE') {
                    $('#abstractDelegateId').val(JSONObject.ID);
                    var registeredEmail = $("#registeredEmail").val();
                    toastr.success(registeredEmail, 'Success', {
                      "progressBar": true,
                      "timeOut": 1000,
                      "showMethod": "slideDown",
                      "hideMethod": "slideUp"
                    });
                    setTimeout(function() {
                      $('#login_operation').show();
                      $('#login_operation').attr('id', 'login_final_operation');
                      $('#unique').show();
                      $('#checkUserEmail').hide();
                      //  window.location.href= jsBASE_URL;

                    }, 3000);

                  } else if (JSONObject.STATUS == 'NOT_PAID' || JSONObject.STATUS == 'NOT_PAID_OFFLINE') {
                    if (emailId != '') {
                      $.ajax({
                        type: "POST",
                        url: jsBASE_URL + 'login.process.php',
                        data: 'action=getPaymentVoucharDetails&user_email_id=' + emailId,
                        dataType: 'json',
                        async: false,
                        success: function(JSONObject) {
                          console.log(JSONObject);

                          if (JSONObject.error == 400) {
                            toastr.error(JSONObject.msg, 'Error', {
                              "progressBar": true,
                              "timeOut": 3000,
                              "showMethod": "slideDown",
                              "hideMethod": "slideUp"
                            });
                          } else if (JSONObject.succ == 200) {
                            $('#user_email_id').val("");
                            $('#loading_indicator').show();
                            $('#payModal').hide();
                            $('#paymentVoucherBody').append(JSONObject.data);

                            $('#slip_id').val(JSONObject.slipId);
                            $('#delegate_id').val(JSONObject.delegateId);
                            $('#mode').val(JSONObject.invoice_mode);

                            $('#loginBtn').prop('disabled', true);

                            toastr.success(JSONObject.msg, 'Success', {
                              "progressBar": true,
                              "timeOut": 2000,
                              "showMethod": "slideDown",
                              "hideMethod": "slideUp"
                            });
                            setTimeout(function() {
                              $('#loading_indicator').hide();
                              $('#paymentVoucherModal').show();
                              $('#loginBtn').prop('disabled', false);
                              //window.location.href= jsBASE_URL + 'profile.php';

                            }, 2000);
                          }


                        }
                      });
                    }
                  } else if (JSONObject.STATUS == 'NOT_PAID_OFFLINE') {
                    if (emailId != '') {
                      $.ajax({
                        type: "POST",
                        url: jsBASE_URL + 'login.process.php',
                        data: 'action=getPaymentVoucharDetails&user_email_id=' + emailId,
                        dataType: 'json',
                        async: false,
                        success: function(JSONObject) {
                          console.log(JSONObject);

                          if (JSONObject.error == 400) {
                            toastr.error(JSONObject.msg, 'Error', {
                              "progressBar": true,
                              "timeOut": 3000,
                              "showMethod": "slideDown",
                              "hideMethod": "slideUp"
                            });
                          } else if (JSONObject.succ == 200) {
                            $('#user_email_id').val("");
                            $('#loading_indicator').show();
                            $('#payModal').hide();
                            $('#paymentVoucherBody').append(JSONObject.data);

                            $('#slip_id').val(JSONObject.slipId);
                            $('#delegate_id').val(JSONObject.delegateId);
                            $('#mode').val(JSONObject.invoice_mode);

                            $('#loginBtn').prop('disabled', true);

                            toastr.success(JSONObject.msg, 'Success', {
                              "progressBar": true,
                              "timeOut": 2000,
                              "showMethod": "slideDown",
                              "hideMethod": "slideUp"
                            });
                            setTimeout(function() {
                              $('#loading_indicator').hide();
                              $('#paymentVoucherModal').show();
                              $('#loginBtn').prop('disabled', false);
                              //window.location.href= jsBASE_URL + 'profile.php';

                            }, 2000);
                          }


                        }
                      });
                    }
                  } else if (JSONObject.STATUS == 'NOT_AVAILABLE') {

                    $('#abstract_basic_details').show();
                    $('#abstractSubmit').show();
                    $('#checkUserEmail').hide();
                    var registerDiv = $("#registerModal");

                    try {
                      var JSONObjectData = JSONObject.DATA;
                      $(registerDiv).find('#email_div').html('');
                      $(registerDiv).find('#user_first_name').val(JSONObjectData.FIRST_NAME);
                      $(registerDiv).find('#user_middle_name').val(JSONObjectData.MIDDLE_NAME);
                      $(registerDiv).find('#user_last_name').val(JSONObjectData.LAST_NAME);
                      $(registerDiv).find('#user_mobile').val(JSONObjectData.MOBILE_NO);
                      $(registerDiv).find('#user_usd_code').val(JSONObjectData.MOBILE_ISD_CODE);

                      $(registerDiv).find('#user_phone_no').val(JSONObjectData.PHONE_NO);
                      $(registerDiv).find('#user_address').val(JSONObjectData.ADDRESS);
                      $(registerDiv).find('#user_city').val(JSONObjectData.CITY);
                      $(registerDiv).find('#user_postal_code').val(JSONObjectData.PIN_CODE);

                      $(registerDiv).find('#user_country').val(JSONObjectData.COUNTRY_ID);
                      $(registerDiv).find('#user_country').trigger("change");
                      $(registerDiv).find('#user_state').val(JSONObjectData.STATE_ID);
                    } catch (e) {
                      $(registerDiv).find('#email_div').html('');
                      $(registerDiv).find('input[type=text]').val('');
                      $(registerDiv).find("input[type=checkbox]").prop("checked", false);
                      $(registerDiv).find("input[type=checkbox]").prop("checked", false);
                      $(registerDiv).find('#user_country').val('');
                      $(registerDiv).find('#user_country').trigger("change");
                    }

                    $(registerDiv).find("#user_email_id").val(emailId);

                    var regClassIdVal = $.trim($(registerDiv).find("#regClassId").val());


                  } else {

                    $.ajax({
                      type: "POST",
                      url: jsBASE_URL + 'abstract.user.entrypoint.process.php',
                      data: 'act=triggerOTPSMS&id=' + JSONObject.ID,
                      dataType: 'text',
                      async: false,
                      success: function(dataObj) {
                        var registeredEmail = $("#registeredEmail").val();
                        toastr.error(registeredEmail, 'Error', {
                          "progressBar": true,
                          "timeOut": 3000,
                          "showMethod": "slideDown",
                          "hideMethod": "slideUp"
                        });
                        setTimeout(function() {
                          $('#login_operation').show();
                          $('#login_operation').attr('id', 'login_final_operation');
                          $('#unique').show();
                          $('#checkUserEmail').hide();

                          // window.location.href = jsBASE_URL + 'index.php';

                        }, 3000);
                      }
                    });

                  }


                }
              });
            }, 500);
          } else {
            var invalidEmail = $("#invalidEmail").val();
            toastr.error(invalidEmail, 'Error', {
              "progressBar": true,
              "timeOut": 3000,
              "showMethod": "slideDown",
              "hideMethod": "slideUp"
            });
          }
        } else {
          var emptyEmail = $("#emptyEmail").val();
          toastr.error(emptyEmail, 'Error', {
            "progressBar": true,
            "timeOut": 3000,
            "showMethod": "slideDown",
            "hideMethod": "slideUp"
          });
        }


      });

      $(document).on("click", "#login_final_operation", function(e) {
        e.preventDefault();
        var user_email_id = $('#abstract_presenter_email').val();
        var user_unique_sequence = $('#user_unique_sequence').val();

        var flag = 0;

        if (user_email_id == '') {
          var emptyEmail = $("#emptyEmail").val();
          toastr.error(emptyEmail, 'Error', {
            "progressBar": true,
            "timeOut": 3000,
            "showMethod": "slideDown",
            "hideMethod": "slideUp"
          });

          flag = 1;
          return false;
        }
        if (user_unique_sequence != '') {

          var regex = /^#\d+$/;
          if (regex.test(user_unique_sequence)) {
            //console.log("String matches the pattern.");
          } else {
            //console.log("String does not match the pattern.");
            toastr.error('Please enter the unique sequence', 'Error', {
              "progressBar": true,
              "timeOut": 3000,
              "showMethod": "slideDown",
              "hideMethod": "slideUp"
            });

            flag = 1;
            return false;
          }

        }

        if (user_email_id != '') {
          var filter =
            /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
          if (!filter.test(user_email_id)) {

            var invalidEmail = $("#invalidEmail").val();
            toastr.error(invalidEmail, 'Error', {
              "progressBar": true,
              "timeOut": 3000,
              "showMethod": "slideDown",
              "hideMethod": "slideUp"
            });

            flag = 1;
            return false;

          }
        }

        if (flag == 0) {
          $.ajax({
            type: "POST",
            url: jsBASE_URL + 'login.process.php',
            data: 'action=getLoginValidationAbstract&user_email_id=' + user_email_id + '&user_unique_sequence=' + user_unique_sequence,
            dataType: 'json',
            async: false,
            success: function(JSONObject) {
              console.log(JSONObject);

              if (JSONObject.error == 400) {
                if (JSONObject.msg) {
                  toastr.error(JSONObject.msg, 'Error', {
                    "progressBar": true,
                    "timeOut": 5000,
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                  });
                }
              } else if (JSONObject.succ == 200) {

                $('#loading_indicator').show();
                $('#login_final_operation').prop('disabled', true);
                if (JSONObject.msg) {
                  toastr.success(JSONObject.msg, 'Success', {
                    "progressBar": true,
                    "timeOut": 3000,
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                  });
                }

                setTimeout(function() {
                  $('#loading_indicator').hide();
                  $('#login_final_operation').prop('disabled', false);
                  window.location.href = jsBASE_URL + 'profile.php';

                }, 1500);
              }


            }
          });
        }
      });
    });
  </script>

  <script>
    //  Change the items below to create your countdown target date and announcement once the target date and time are reached.  
    var current =
      ""; //enter what you want the script to display when the target date and time are reached, limit to 20 characters
    var year = <?= $dateArr[0] ?>; //Enter the count down target date YEAR
    var month = <?= $dateArr[1] ?>; //Enter the count down target date MONTH
    var day = <?= $dateArr[2] ?>; //>Enter the count down target date DAY
    var hour = 23; //Enter the count down target date HOUR (24 hour clock)
    var minute = 59; //Enter the count down target date MINUTE
    var tz =
      5.5; //Offset for your timezone in hours from UTC (see http://wwp.greenwichmeantime.com/index.htm to find the timezone offset for your location)

    // DO NOT CHANGE THE CODE BELOW! 
    var montharray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
      "Dec");

    console.log('yy=' + year + 'mm=' + month)

    function countdown(yr, m, d, hr, min) {
      theyear = yr;
      themonth = m;
      theday = d;
      thehour = hr;
      theminute = min;
      var today = new Date();
      var todayy = today.getYear();
      if (todayy < 1000) {
        todayy += 1900;
      }
      var todaym = today.getMonth();
      var todayd = today.getDate();
      var todayh = today.getHours();
      var todaymin = today.getMinutes();
      var todaysec = today.getSeconds();
      var todaystring1 = montharray[todaym] + " " + todayd + ", " + todayy + " " + todayh + ":" +
        todaymin + ":" + todaysec;
      var todaystring = Date.parse(todaystring1) + (tz * 1000 * 60 * 60);
      var futurestring1 = (montharray[m - 1] + " " + d + ", " + yr + " " + hr + ":" + min);
      var futurestring = Date.parse(futurestring1) - (today.getTimezoneOffset() * (1000 * 60));
      var dd = futurestring - todaystring;
      var dday = Math.floor(dd / (60 * 60 * 1000 * 24) * 1);
      var dhour = Math.floor((dd % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
      var dmin = Math.floor(((dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
      var dsec = Math.floor((((dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);

      if (dday <= 0 && dhour <= 0 && dmin <= 0 && dsec <= 0) {
        document.getElementById('dday').style.display = "none";
        document.getElementById('dhour').style.display = "none";
        document.getElementById('dmin').style.display = "none";
        document.getElementById('dsec').style.display = "none";
        return;
      } else {
        document.getElementById('dday').innerHTML = (dday < 10) ? ('0' + dday) : dday;
        document.getElementById('dhour').innerHTML = (dhour < 10) ? ('0' + dhour) : dhour;
        document.getElementById('dmin').innerHTML = (dmin < 10) ? ('0' + dmin) : dmin;
        document.getElementById('dsec').innerHTML = (dsec < 10) ? ('0' + dsec) : dsec;

        setTimeout("countdown(theyear,themonth,theday,thehour,theminute)", 1000);
      }
    }
    countdown(year, month, day, hour, minute);

    $('#abstractSubmit').click(function() {

      isValid = true;

      $("input[type='text'], input[type='radio'], input[type='checkbox'], select").each(function(index) {

        if ($(this).attr('type') === 'text' && !$.trim($(this).val()) && $(this).attr('id') != 'user_middle_name') {
          var msg = $(this).attr('validate');
          toastr.error(msg, 'Error', {
            "progressBar": true,
            "timeOut": 3000, // 3 seconds
            "showMethod": "slideDown", // Animation method for showing
            "hideMethod": "slideUp",
            "direction": 'ltr', // Animation method for hiding
          });

          isValid = false;

          return false;
        } else if ($(this).attr('type') === 'radio') {
          if (!$("input[type='radio'][name='user_initial_title']:checked").length) {

            toastr.error('Please select user title', 'Error', {
              "progressBar": true,
              "timeOut": 3000, // 3 seconds
              "showMethod": "slideDown", // Animation method for showing
              "hideMethod": "slideUp",
              "direction": 'ltr', // Animation method for hiding
            });

            isValid = false;

            return false;
          }

        } else if ($(this).prop('tagName').toLowerCase() === 'select') {

          if ($.trim($(this).val()) == '') {

            var msg = $(this).attr('validate');
            toastr.error(msg, 'Error', {
              "progressBar": true,
              "timeOut": 3000,
              "showMethod": "slideDown",
              "hideMethod": "slideUp"
            });

            isValid = false;
            return false;

          }
        }


      });

      if (isValid) {
        $('#absRegisterForm').submit();
      }
    });
  </script>



</body>

</html>