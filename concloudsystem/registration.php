<?php
include_once("includes/source.php");
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
// echo "<pre>";
// print_r(get_included_files());

$totalSection = 7;

$title = 'Registration';

if (isset($_REQUEST['abstractDelegateId']) && trim($_REQUEST['abstractDelegateId']) != '') {
  $abstractDelegateId = trim($_REQUEST['abstractDelegateId']);
  $userRec = getUserDetails($abstractDelegateId);
} else {
  $mycms->removeAllSession();
  $mycms->removeSession('SLIP_ID');
}

?>
<?
$cutoffs      = fullCutoffArray();
$currentCutoffId  = getTariffCutoffId();
$currentWorkshopCutoffId  = getWorkshopTariffCutoffId();
$dinnerTariffArray   = getAllDinnerTarrifDetails($currentCutoffId);

$disabled = count($userRec) > 0 ? "" : "disabled='disabled'";

$disabledclass = count($userRec) > 0 ? "" : "disable";

$workshopDetailsArray    = getAllWorkshopTariffs($currentWorkshopCutoffId);
$workshopCountArr      = totalWorkshopCountReport();

//  echo '<pre>'; print_r($currentWorkshopCutoffId);die;


$registrationAmount   = getCutoffTariffAmnt($currentCutoffId);
//  echo '<pre>'; print_r($registrationAmount);die;
//echo 'title=='. $userRec['user_title'];
// First, check if there is at least one dinner with amount > 0
$hasDinnerAmount = false;
foreach ($dinnerTariffArray as $dinnerValue) {
    if (isset($dinnerValue[$currentCutoffId]['AMOUNT']) && $dinnerValue[$currentCutoffId]['AMOUNT'] > 0) {
        $hasDinnerAmount = true;
        break; // No need to check further, we found a valid amount
    }
}
// echo '<pre>'; print_r($hasDinnerAmount);die;

$sql_logo  = array();
$sql_logo['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
                      WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]  = array('FILD' => 'status' ,         'DATA' => 'A' ,                   'TYP' => 's');          
$result = $mycms->sql_select($sql_logo);
$row         = $result[0];

$header_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['logo_image'];

if ($row['logo_image'] != '') {
  $emailHeader  = $header_image;
}


$sqlIcon  = array();
$sqlIcon['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
                      WHERE `status`='A' AND purpose='Registration' order by seq ";
//$sql['PARAM'][]  = array('FILD' => 'status' ,'DATA' => 'A' ,'TYP' => 's');          
$resultIcon = $mycms->sql_select($sqlIcon);

//echo '<pre>'; print_r($resultIcon);

$sqlInfo  = array();
$sqlInfo['QUERY']    = "SELECT * FROM " . _DB_COMPANY_INFORMATION_ . " 
             WHERE `status` = ?";
$sqlInfo['PARAM'][] = array('FILD' => 'status',         'DATA' => 'A',                   'TYP' => 's');
$resultInfo      = $mycms->sql_select($sqlInfo);
$rowInfo         = $resultInfo[0];
$available_registration_fields = json_decode($rowInfo['available_registration_fields']);

$sqlSocialIcon  = array();
$sqlSocialIcon['QUERY'] = "SELECT * FROM " . _DB_SOCIAL_ICON_SETTING_ . " 
              WHERE `id`!='' AND `purpose`='Regular Icon' AND status='A' ";

$resultSocialIcon    = $mycms->sql_select($sqlSocialIcon);

$sqlSocialButtonIcon  = array();
$sqlSocialButtonIcon['QUERY'] = "SELECT * FROM " . _DB_SOCIAL_ICON_SETTING_ . " 
              WHERE `id`!='' AND `purpose`='Button Icon' AND status='A' ";

$resultSocialButtonIcon    = $mycms->sql_select($sqlSocialButtonIcon);


$sqlFooterIcon  = array();
$sqlFooterIcon['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
                      WHERE `status`='A' AND purpose='Footer' order by id ";
//$sql['PARAM'][]  = array('FILD' => 'status' ,         'DATA' => 'A' ,                   'TYP' => 's');          
$resultFooterIcon = $mycms->sql_select($sqlFooterIcon);

$sqlLogo    =   array();
$sqlLogo['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
                            WHERE title='Online Payment Logo' ";

$resultLogo      = $mycms->sql_select($sqlLogo);
$logo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultLogo[0]['image'];


$sqlAccompany   = array();
$sqlAccompany['QUERY']    = "SELECT COUNT(*) AS COUNTDATA FROM " . _DB_ACCOMPANY_CLASSIFICATION_ . " 
                     WHERE `status` = ?";
$sqlAccompany['PARAM'][]  = array('FILD' => 'status',         'DATA' => 'A',                   'TYP' => 's');
$resultAccompany       = $mycms->sql_select($sqlAccompany);

$accompanyCount = $resultAccompany[0]['COUNTDATA'];


$sqlLogo    =   array();
$sqlLogo['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
                        WHERE title='Online Payment Logo' ";

$resultLogo      = $mycms->sql_select($sqlLogo);
$logo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultLogo[0]['image'];

$accomCount = ($registrationAmount) ? '1' : '0';

$sqlFetchHotel      = array();
$sqlFetchHotel['QUERY'] = "SELECT * 
                                         FROM " . _DB_MASTER_HOTEL_ . "
                                        WHERE `status` =  ? ";

$sqlFetchHotel['PARAM'][] = array('FILD' => 'status',    'DATA' => 'A',     'TYP' => 's');
$resultFetchHotel        = $mycms->sql_select($sqlFetchHotel);


//echo count($resultFetchHotel);

$countAcc = ($resultFetchHotel) ? '1' : '0';
$blurclass = count($userRec) > 0 ? "" : "blur_bw";



//echo '<pre>'; print_r($userRec);


?>

<body>
  <img src="<?=$cfg['OUTER_BG_IMG']?>" alt="" class="body_bk">

  <style>

  </style>
  <?php


  setTemplateStyleSheet();
  setTemplateBasicJS();
  backButtonOffJS();


  include_once("header.php");

  ?>
  <form class="body-frm" name="registrationForm" enctype="multipart/form-data" method="post" autocomplete="off" action="<?= _BASE_URL_ ?>registration.process.php">
    <input type="hidden" name="act" value="combinedRegistrationProcess" />
    <input type="hidden" id="cutoff_id" name="cutoff_id" value="<?= $currentCutoffId ?>" />
    <input type="hidden" name="reg_area" value="FRONT" />
    <input type="hidden" name="registration_request" id="registration_request" value="GENERAL" />
    <input type="hidden" name="registration_cutoff" id="registration_cutoff" value="<?= $currentCutoffId ?>" />
    <input type="hidden" name="abstractDelegateId" id="abstractDelegateId" value="<?= $abstractDelegateId ?>" />
    <input type="hidden" name="gst_flag" id="gst_flag" value="<?= $cfg['GST.FLAG'] ?>" />
    <div class="registration_wrap">
      <div class="registartion_head">
        <a href="index.php"><i class="fal fa-arrow-left"></i>Back</a>

        <p><span>Registered Email Id</span>
          <script>
            document.write(localStorage.getItem('user_email_id') || '');

            function setRegistration(id) {
              
              $.ajax({
                url: 'registration.php',
                type: 'POST',
                data: {
                  registration_classi_id: id
                },
                success: function(response) {
                  $('#workShops').html($(response).find('#workShops').html());
                  initializeworkShopPlugins(); // re-run your JS for the new content

                  // populate check-in/check-out selects here
                }
              });

            }
          </script>
        </p>
      </div>
      <div class="registration_inner">
        <div class="registration_left">
          <div class="registration_left_head">
            <h5><?=$rowInfo['company_conf_name']?></h5>
            <h6>Registration Portal</h6>
          </div>
          <ul id="progressbar">
            <li class="active" id="personal"><?php user(); ?><span>Personal</span></li>
            <!-- <li id="path"><i class="fal fa-road"></i><span>Path</span></li> -->
            <li id="category"><?php conregi(); ?><span>Category</span></li>
            <?
            if (!empty($resultFetchHotel)) {
            ?>
            <li id="stay"><?php hotel(); ?><span>Accommodation</span></li>
            <?
            }
            if ((!empty($workshopDetailsArray))  && $currentWorkshopCutoffId > 0) {
            ?>
            <li id="workshop"><?php workshop(); ?><span>Workshop</span></li>
            <?
            }
            if ($hasDinnerAmount){
             ?>
            <li id="galadinner"><?php dinner(); ?><span>Gala Dinner</span></li>
            <?
            }if ($registrationAmount != '' && $registrationAmount > 0) {
            ?>
            <li id="guests"><?php duser(); ?><span>Accompanying</span></li>
            <?
            }
            ?>
            <li id="review"><?php check(); ?><span>Review</span></li>
          </ul>
          <div class="registration_left_bottom">
            <h6>Total Payable</h6>
            <h5><span id="subTotalPrc" style="color: var(--sky);"></span></h5>
          </div>
        </div>
        <div class="registration_right">


          <!-- persoanl -->
          <fieldset class="registration_right_wrap">
            <div class="registration_right_head">
             <?=$cfg['USER_TITLE']?>
            </div>
            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Personal Details</h4>
                  <h5>Please provide your details for official records.</h5>
                </div>
              </div>
              <div class="registration_right_body_content" use="registrationUserDetails">
                <div class="form_grid">
                  <?php
                  if (in_array("Address", $available_registration_fields)) {
                    $disply = 'block';
                  } else {
                    $disply = 'none';
                  }
                  if (in_array("Country", $available_registration_fields)) {
                    $disply = 'block';
                  } else {
                    $disply = 'none';
                  }
                  if (in_array("State", $available_registration_fields)) {
                    $disply = 'block';
                  } else {
                    $disply = 'none';
                  }
                  if (in_array("City", $available_registration_fields)) {
                    $disply = 'block';
                  } else {
                    $disply = 'none';
                  }
                  if (in_array("Pin", $available_registration_fields)) {
                    $disply = 'block';
                  } else {
                    $disply = 'none';
                  }
                  if (in_array("Gender", $available_registration_fields)) {
                    $disply = 'block';
                  } else {
                    $disply = 'none';
                  }

                  $sql_notification   =  array();
                  $sql_notification['QUERY']    = "SELECT * FROM " . _DB_COMPANY_INFORMATION_ . " 
                                                        WHERE `id` = ?";
                  $sql_notification['PARAM'][]  =  array('FILD' => 'id',          'DATA' => $_REQUEST['id'],                    'TYP' => 's');
                  $result       = $mycms->sql_select($sql_notification);
                  $row         = $result[0];
                  $invalidEmail = $row['notification_invalid_email'];

                  ?>
                  <div class="frm_grp span_2">
                    <p class="frm-head">Email Address <i class="mandatory">*</i></p>
                    <div class="d-flex align-items-center">
                      <!-- Hidden field for validation -->
                      <input type="hidden" id="invalidEmail" value="<?= $invalidEmail ?>">

                      <!-- Email icon -->
                      <!-- <span style="margin-right:5px;">
                                            <img src="images/email-R.png" alt="" style="width:24px;height:24px;">
                                        </span> -->

                      <!-- Actual email input -->
                      <input type="text"
                        class="form-control"
                        name="user_email_id"
                        id="user_email_id"
                        value="<?= !empty($userRec['user_email_id']) ? $userRec['user_email_id'] : '' ?>"
                        placeholder="Email"
                        validate="Please Enter Email Address"
                        autocomplete="nope"
                        style="flex:1;background-color: transparent!important;" disabled>
                    </div>
                  </div>
                  <div class="frm_grp span_2">
                    <p class="frm-head">Mobile Number <i class="mandatory">*</i></p>
                    <div class="d-flex align-items-center">
                      <!-- Phone icon -->
                      <!-- <span style="margin-right:5px;">
                                            <img src="images/phone-R.png" alt="" style="width:24px;height:24px;">
                                        </span> -->

                      <!-- Mobile input -->
                      <input type="text"
                        class="form-control"
                        name="user_mobile"
                        id="user_mobile"
                        value="<?= (!empty($userRec['user_mobile_isd_code']) ? $userRec['user_mobile_isd_code'] : '') ?><?= (!empty($userRec['user_mobile_no']) ? $userRec['user_mobile_no'] : '') ?>"
                        maxlength="10"
                        onkeypress="return isNumber(event)"
                        required
                        placeholder="Mobile"
                        validate="Please Enter Mobile Number"
                        autocomplete="nope"
                        style="flex:1;">
                    </div>
                  </div>

                  <div class="frm_grp span_1">
                    <p class="frm-head">Title</p>
                    <select name="user_initial_title"
                      class="<?= $disabledclass ?>"
                      <?= $disabled ?>
                      validate="Please select your title"
                      style="width:100%; padding:5px;" >
                      <option value="">Select Title</option>
                      <option value="Dr" <?= strtoupper($userRec['user_title']) == 'DR' ? 'selected' : '' ?>>Dr.</option>
                      <option value="Prof" <?= strtoupper($userRec['user_title']) == 'PROF' ? 'selected' : '' ?>>Prof.</option>
                      <option value="Mr" <?= strtoupper($userRec['user_title']) == 'MR' ? 'selected' : '' ?>>Mr.</option>
                      <option value="Ms" <?= strtoupper($userRec['user_title']) == 'MS' ? 'selected' : '' ?>>Ms.</option>
                    </select>
                  </div>
                  <div class="frm_grp span_3">
                    <p class="frm-head">First Name <i class="mandatory">*</i></p>
                    <input type="text" <?= $disabledclass ?>" required placeholder="First Name" name="user_first_name" id="user_first_name" validate="Please Enter First Name" autocomplete="off" <?= $disabled ?> value="<?= ($userRec['user_first_name'] != '') ? ($userRec['user_first_name']) : '' ?>" autocomplete="nope">
                  </div>
                  <div class="frm_grp span_2">
                    <p class="frm-head">Middle Name</p>
                    <input type="text" <?= $disabledclass ?>"  placeholder="Middle Name" name="user_middle_name" id="user_middle_name" value="<?= ($userRec['user_middle_name'] != '') ? ($userRec['user_middle_name']) : '' ?>" autocomplete="off" <?= $disabled ?> autocomplete="nope">

                  </div>
                  <div class="frm_grp span_2">
                    <p class="frm-head">Last Name <i class="mandatory">*</i></p>
                    <input type="text" <?= $disabledclass ?>" required placeholder="Last Name" name="user_last_name" id="user_last_name" value="<?= ($userRec['user_last_name'] != '') ? ($userRec['user_last_name']) : '' ?>" validate="Please Enter Last Name" autocomplete="off" <?= $disabled ?> autocomplete="nope">

                  </div>

                  <?php
                  if (in_array("Address", $available_registration_fields)) {
                  ?>
                    <div class="frm_grp span_4">
                      <p class="frm-head">Address</p>
                      <div class="d-flex align-items-center">
                        <input type="text"
                          class=" <?= $disabledclass ?>"
                          name="user_address"
                          id="user_address" 
                          required
                          value="<?= !empty($userRec['user_address']) ? $userRec['user_address'] : '' ?>"
                          placeholder="Address"
                          autocomplete="off"
                          <?= $disabled ?>
                          validate="Please Enter Your Address"
                          style="flex:1;">
                      </div>
                    </div>

                  <?php
                  }
                  if (in_array("Country", $available_registration_fields)) {
                  ?>
                    <div class="frm_grp span_2">
                      <p class="frm-head">Country</p>
                      <div class="d-flex align-items-center">
                        <!-- Country icon -->
                        <!-- <span style="margin-right:5px;">
                                                <img src="images/country-R.png" alt="" style="width:24px;height:24px;">
                                            </span> -->

                        <!-- Country select -->
                        <select class=" <?= $disabledclass ?>"
                          name="user_country"
                          id="user_country"
                          forType="country"
                          required
                          <?= $disabled ?>
                          validate="Please Select Country"
                          style="flex:1;">
                          <option value="">-- Select Country --</option>
                          <?php
                          $sqlFetchCountry = array();
                          $sqlFetchCountry['QUERY'] = "SELECT * FROM " . _DB_COMN_COUNTRY_ . " 
                                                                            WHERE `status` = ? 
                                                                            ORDER BY `country_name` ASC";
                          $sqlFetchCountry['PARAM'][] = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');

                          $resultFetchCountry = $mycms->sql_select($sqlFetchCountry);
                          if ($resultFetchCountry) {
                            foreach ($resultFetchCountry as $keyCountry => $rowFetchCountry) {
                          ?>
                              <option value="<?= $rowFetchCountry['country_id'] ?>" <?= ($rowFetchCountry['country_id'] == $userRec['user_country_id']) ? 'selected' : '' ?>>
                                <?= $rowFetchCountry['country_name'] ?>
                              </option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  <?php
                  }
                  if (in_array("State", $available_registration_fields)) {
                  ?>

                    <div class="frm_grp span_2">
                      <p class="frm-head">State</p>
                      <div class="d-flex align-items-center">
                        <!-- Country icon -->
                        <!-- <span style="margin-right:5px;">
                                                <img src="images/country-R.png" alt="" style="width:24px;height:24px;">
                                            </span> -->

                        <!-- Country select -->
                        <select class=" <?= $disabledclass ?>"
                          name="user_state"
                          id="user_state"
                          forType="state"
                          required
                          <?= $disabled ?>
                          validate="Please Select State"
                          style="flex:1;">
                          <option value="">-- Select Country First --</option>
                          <?php
                          $sqlFetchState   = array();
                          $sqlFetchState['QUERY']    = "SELECT * FROM " . _DB_COMN_STATE_ . " 
                                                                                    WHERE `status` =? 
                                                                                  ORDER BY `state_name` ASC";

                          $sqlFetchState['PARAM'][]   = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');

                          $resultFetchState = $mycms->sql_select($sqlFetchState);
                          if ($resultFetchState) {
                            foreach ($resultFetchState as $keyState => $rowFetchState) {
                          ?>
                              <option value="<?= $rowFetchState['st_id'] ?>" <?= ($rowFetchState['st_id'] == $userRec['user_state_id']) ? 'selected' : '' ?>>
                                <?= $rowFetchState['state_name'] ?>
                              </option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  <?php
                  }
                  if (in_array("City", $available_registration_fields)) {
                  ?>
                    <div class="frm_grp span_2">
                      <p class="frm-head">City</p>
                      <div class="d-flex align-items-center">
                        <!-- Icon -->
                        <!-- <span>
                                                <img src="images/city-R.png" alt="" style="width:24px;height:24px;">
                                            </span> -->
                        <!-- Input field -->
                        <input type="text"
                          class=" <?= $disabledclass ?>"
                          name="user_city"
                          id="user_city"
                          value="<?= !empty($userRec['user_city']) ? $userRec['user_city'] : '' ?>"
                          placeholder="City"
                          <?= $disabled ?>
                          validate="Please Enter City"
                          autocomplete="nope"
                          style="flex:1;" required>
                      </div>
                    </div>
                  <?php
                  }
                  if (in_array("Pin", $available_registration_fields)) {
                  ?>
                    <div class="frm_grp span_2">
                      <p class="frm-head">Pin</p>
                      <div class="d-flex align-items-center">

                        <input type="text"
                          class=" <?= $disabledclass ?>"
                          name="user_postal_code"
                          id="user_postal_code"
                          value="<?= !empty($userRec['user_pincode']) ? $userRec['user_pincode'] : '' ?>"
                          placeholder="Postal Code"
                          <?= $disabled ?>
                          validate="Please enter postal code"
                          autocomplete="nope"
                          style="flex:1;" onkeypress="return isNumber(event)" autocomplete="nope" required>
                      </div>
                    </div>
                  <?php
                  }
                  if (in_array("Gender", $available_registration_fields)) {
                  ?>
                    <div class="frm_grp span_2">
                      <p class="frm-head">Gender <i class="mandatory">*</i></p>
                      <div class="cus_check_wrap flex-row" id="radioGender">
                        <label class="cus_check gender_check">
                          <input required type="radio"
                            name="user_gender"
                            id="user_gender_male"
                            value="Male"
                            groupname="user_gender"
                            validate="Please select a gender"
                            <?= $disabled ?>
                            <?= (!empty($userRec['user_gender']) && $userRec['user_gender'] == 'Male') ? 'checked' : '' ?>>
                          <span class="checkmark">Male</span>
                        </label>

                        <label class="cus_check gender_check">
                          <input required type="radio"
                            name="user_gender"
                            id="user_gender_female"
                            value="Female"
                            groupname="user_gender"
                            validate="Please select a gender"
                            <?= $disabled ?>
                            <?= (!empty($userRec['user_gender']) && $userRec['user_gender'] == 'Female') ? 'checked' : '' ?>>
                          <span class="checkmark">Female</span>
                        </label>

                        <label class="cus_check gender_check">
                          <input required type="radio"
                            name="user_gender"
                            id="user_gender_others"
                            value="Others"
                            groupname="user_gender"
                            validate="Please select a gender"
                            <?= $disabled ?>
                            <?= (!empty($userRec['user_gender']) && $userRec['user_gender'] == 'Others') ? 'checked' : '' ?>>
                          <span class="checkmark">Others</span>
                        </label>
                      </div>
                    </div>
                  <?php
                  }
                  if (in_array("Food", $available_registration_fields)) {
                  ?>
                    <div class="frm_grp span_2">
                      <p class="frm-head">Food Preference:</p>
                      <div class="cus_check_wrap flex-row" id="radioGender">
                        <label class="cus_check gender_check">
                          <input type="radio" groupname="user_food_choice" name="user_food_choice" id="user_food_choice_veg" validate="Please select your food preference" value="veg" <?= $disabled ?> required="">
                          <span class="checkmark">Veg</span>
                        </label>


                        <label class="cus_check gender_check">
                          <input type="radio" groupname="user_food_choice" name="user_food_choice" id="user_food_choice_nonveg" validate="Please select your food preference" value="nonveg" <?= $disabled ?> required>
                          <span class="checkmark">Non-Veg</span>
                        </label>

                      </div>
                    </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="registration_right_bottom justify-content-end">
              <!-- <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button> -->
              <button type="button" name="next" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
              <!-- <button class="next action-button <?php if (count($userRec) > 0) {
                                                        echo '';
                                                      } else {
                                                        echo 'disabled-click';
                                                      } ?>" id="user_details" style="display:<?php if (count($userRec) > 0) {
                                                                                                echo 'block';
                                                                                              } else {
                                                                                                echo 'block';
                                                                                              } ?>" workshop-count="<?= count($workshopDetailsArray) ?>" accompany-count="<?= $accompanyCount ?>" banquet-count="<?= count($dinnerTariffArray) ?>" accommodation-count="<?= $countAcc ?>" title="<?= $nextSectionTitle ?>">Continue <i class="fal fa-angle-right"></i>
              </button> -->
            </div>
          </fieldset>
          <!-- persoanl -->
          <!-- path -->
          <!-- <fieldset class="registration_right_wrap">
            <div class="registration_right_head">
              Path
            </div>

            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Select Registration Path</h4>
                  <h5>Choose how you would like to attend NATCON 2025.</h5>
                </div>
              </div>
              <div class="registration_right_body_content">
                <div class="cus_check_wrap g2">
                  <label class="cus_check workshop_select gala_select">
                    <input type="radio" name="path">
                    <span class="checkmark">
                      <n>
                        <i class="fal fa-columns"></i>
                        <iii></iii>
                      </n>
                      <g>Individual Delegate
                        <k>Customize your experience. Pick only what you need—registration, specific workshops, and dinners separately.</k>
                      </g>
                    </span>
                  </label>
                  <label class="cus_check workshop_select gala_select">
                    <input type="radio" name="path">
                    <span class="checkmark">
                      <n>
                        <i class="fal fa-box"></i>
                        <iii></iii>
                      </n>
                      <g>Residential Package
                        <k>All-inclusive bundle: Registration + Hotel Stay + All Meals + Choice of 1 Workshop. Simplified and better value.</k>
                      </g>
                    </span>
                  </label>
                </div>
              </div>
            </div>
            <div class="registration_right_bottom">
              <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>
              <button type="button" name="next" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
            </div>
          </fieldset> -->
          <!-- path -->
          <!-- category -->
          <fieldset class="registration_right_wrap category">
            <div class="registration_right_head">
             <?=$cfg['CATEGORY_TITLE']?>
            </div>
            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Select Category</h4>
                  <h5>Choose the option that best describes your role.</h5>
                </div>
              </div>
              <div class="registration_right_body_content">
                <div class="cus_check_wrap">

                  <?php
                  if ($currentCutoffId > 0) {

                    $conferenceTariffArray = getAllRegistrationTariffs($currentCutoffId);
                    $workshopCountArr      = totalWorkshopCountReport();

                    //echo '<pre>'; print_r($workshopCountArr);

                    $comboTariffArray   = getAllRegistrationComboTariffs($currentCutoffId);

                    $workshopRegChoices = array();

                    //echo '<pre>'; print_r($comboTariffArray);
                    $workshoDefinedDate = '';
                    foreach ($workshopDetailsArray as $keyWorkshopclsf => $rowWorkshopclsf) {
                      foreach ($rowWorkshopclsf as $keyRegClasf => $rowRegClasf) {
                        //echo '<pre>'; print_r($rowRegClasf['WORKSHOP_DATE']);
                        $workshopRegChoices[$rowRegClasf['WORKSHOP_TYPE']][$keyWorkshopclsf][$keyRegClasf] = $rowRegClasf;
                        $workshoDefinedDate = $rowRegClasf['WORKSHOP_DATE'];
                      }
                    }
                    foreach ($conferenceTariffArray as $key => $registrationDetailsVal) {

                      $classificationType = getRegClsfType($key);

                      if ($classificationType == 'DELEGATE') {

                        $getSeatlimitToClassificationID = getSeatlimitToClassificationID($registrationDetailsVal['REG_CLASSIFICATION_ID']);

                        $disableClass = ($getSeatlimitToClassificationID < 0) ? "disabled" : "";

                        $icon = $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $registrationDetailsVal['ICON'];
                             
                        $amountText = floatval($registrationDetailsVal['AMOUNT']) > 0
                          ? $registrationDetailsVal['CURRENCY'].' ' . number_format($registrationDetailsVal['AMOUNT'])
                          : "Complimentary";
                  ?>

                        <label class="cus_check regi_category <?= $disableClass ?>" data-aos="fade-up" data-aos-delay="0">
                          <!-- IMPORTANT: Keep original name/id for jQuery support -->
                          <input type="radio" name="registration_classification_id[]" onclick="toggleMemberField(this)" onchange="setRegistration(this.value)" id="registration_classification_id" operationMode="registration_tariff" operationModeType="conference" reg="reg" value="<?= $registrationDetailsVal['REG_CLASSIFICATION_ID'] ?>" currency="<?= $registrationDetailsVal['CURRENCY'] ?>" amount="<?= $registrationDetailsVal['AMOUNT'] ?>" invoiceTitle="Registration" invoiceName="<?= $registrationDetailsVal['CLASSIFICATION_TITTLE'] ?>" <?= $disableClass ?> icon="<?= $icon ?>">

                              <!-- <img src="<?= $icon ?>" -->
                          <span class="checkmark">
                            <n>
                              <i><img src="<?= $icon ?>" alt="" style="width:24px;height:24px;"></i>
                              <g>
                                <?= $registrationDetailsVal['CLASSIFICATION_TITTLE'] ?>
                                <ii><?= $registrationDetailsVal['TITTLE_DESCRIPTION'] ?></ii>
                              </g>
                            </n>
                            <h><?= $amountText ?><i></i></h>
                          </span>
                          <div class="regi_category_sublabel d-none" >
                            <div class="frm_grp">
                              <p class="frm-head">Membership Id <i class="mandatory">*</i></p>
                              <input type="text" name="membership_number" validate="Please Enter Member Id">
                            </div>
                          </div>
                        </label>

                  <?php
                      } // end if DELEGATE
                    } // end foreach
                  }
                  ?>

                </div>
              </div>
            </div>

            <div class="registration_right_bottom">
              <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>

              <button name="next" type="button"  value="button" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
            </div>
          </fieldset>
          <!-- category -->
          <!-- accommodation -->
          <?
          if (!empty($resultFetchHotel)) {
          ?>
          <fieldset class="registration_right_wrap accomodationFindset">
            <?
            $sqlFetchHotel      = array();
            $sqlFetchHotel['QUERY'] = "SELECT * 
                                          FROM " . _DB_MASTER_HOTEL_ . "
                                          WHERE `status` =  ? ";

            $sqlFetchHotel['PARAM'][] = array('FILD' => 'status',    'DATA' => 'A',     'TYP' => 's');
            $resultFetchHotel        = $mycms->sql_select($sqlFetchHotel);
            //echo '<pre>'; print_r($resultFetchHotel);
            $hotel_count = count($resultFetchHotel) - 1;


            ?>
            <div class="registration_right_head">
              <?=$cfg['ACCOMODATION_TITLE']?>
            </div>
            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Hotel Accommodation (Optional)</h4>
                  <h5>Add a room to your individual registration.</h5>
                </div>
                <div class="registration_right_body_head_right">
                  <a class="text_danger text_danger_clear">Clear</a>
                </div>
              </div>

              <div class="registration_right_body_head registration_right_body_sub_head">
                <div class="registration_right_body_head_left">
                  <span><?php hotel() ?></span>
                  <div>
                    <h4>Accommodation</h4>
                    <h5>Select stay duration</h5>
                  </div>
                </div>
                <div class="registration_right_body_head_right">
                  <div id="hotelDateStore"></div>

                  <div class="hotel_check form_grid g_2" id="accoOp">
                    <?php
                    if (isset($_POST['hotelIdDate'])) {
                      $hotelIdDate = $_POST['hotelIdDate']; // this is the selected hotel ID

                      $dates = array();
                      $dCount = 0;
                      $packageCheckDate = array();
                      $packageCheckDate['QUERY'] = "SELECT * FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . " 
                                                              WHERE `hotel_id` = ?
                                                              AND `status` = ?
                                                            ORDER BY  check_in_date";
                      $packageCheckDate['PARAM'][]  =  array('FILD' => 'hotel_id',     'DATA' => $hotelIdDate,   'TYP' => 's');
                      $packageCheckDate['PARAM'][]  =  array('FILD' => 'status',       'DATA' => 'A',     'TYP' => 's');
                      $resCheckIns = $mycms->sql_select($packageCheckDate);
                      $check_in_array = array();
                      foreach ($resCheckIns as $key => $rowCheckIn) {
                        $packageCheckoutDate = array();
                        $packageCheckoutDate['QUERY'] = "SELECT *, TIMESTAMPDIFF(DAY,'" . $rowCheckIn['check_in_date'] . "',`check_out_date`) AS dayDiff
                                                                FROM " . _DB_ACCOMMODATION_CHECKOUT_DATE_ . " 
                                                                WHERE `hotel_id` = ?
                                                                AND `status` = ?
                                                                AND `check_out_date` > ?
                                                              ORDER BY check_out_date";
                        $packageCheckoutDate['PARAM'][]  =  array('FILD' => 'hotel_id',     'DATA' => $hotelIdDate,       'TYP' => 's');
                        $packageCheckoutDate['PARAM'][]  =  array('FILD' => 'status',       'DATA' => 'A',       'TYP' => 's');
                        $packageCheckoutDate['PARAM'][]  =  array('FILD' => 'check_out_date',  'DATA' => $rowCheckIn['check_in_date'],       'TYP' => 's');


                        $resCheckOut = $mycms->sql_select($packageCheckoutDate);
                        //     echo "<pre>";
                        // print_r($resCheckOut);
                        foreach ($resCheckOut as $key => $rowCheckOut) {
                          $dates[$dCount]['CHECKIN']     =  $rowCheckIn['check_in_date'];
                          $dates[$dCount]['CHECKINID']  =  $rowCheckIn['id'];
                          $dates[$dCount]['CHECKOUT']   =  $rowCheckOut['check_out_date'];
                          $dates[$dCount]['CHECKOUTID'] =  $rowCheckOut['id'];
                          $dates[$dCount]['DAYDIFF']    =  $rowCheckOut['dayDiff'];

                          $dCount++;
                        }
                      }
                      // Database connection
                      // Now you can use $hotelId in your SQL query safely
                      $tempCheckIN = array_unique(array_column($dates, 'CHECKIN', 'CHECKINID'));
                      $tempCheckOUT = array_unique(array_column($dates, 'CHECKOUT', 'CHECKOUTID'));
                    }
                    ?>
                    <div class="frm_grp span_1">
                      <p class="frm-head">Check In</p>
                      <select id="accomodation_package_checkin_id_<?= $hotelIdDate ?>" 
                            name="accomodation_package_checkin_id[<?= $hotelIdDate ?>]" 
                            onchange="get_checkin_val(this.value, <?= $hotelIdDate ?>)">
                        <option value="">Select Check In Date</option>

                        <?php
                        foreach ($tempCheckIN as $key => $value) {
                          $checkInVal = $key . "/" . $value;

                        ?>
                          <option value="<?= $checkInVal ?>"><?= $value ?></option>
                        <?php
                        }
                        ?>

                      </select>
                    </div>
                    <div class="frm_grp span_1">
                      <p class="frm-head">Check Out</p>
                    <select id="accomodation_package_checkout_id_<?= $hotelIdDate ?>" 
                            name="accomodation_package_checkout_id[<?= $hotelIdDate ?>]" 
                            onchange="get_checkout_val(this.value, <?= $hotelIdDate ?>)">                        
                            <option value="">Select Check Out Date</option>

                        <?
                        foreach ($tempCheckOUT as $key => $value) {
                          $checkOutVal = $key . "/" . $value;
                        ?>

                          <option value="<?= $checkOutVal ?>"><?= $value ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="registration_right_body_tab">
                <div class="hotel_link_owl owl-carousel owl-theme">
                  <?php
                  if (count($resultFetchHotel)) {
                    foreach ($resultFetchHotel as $k => $val) {
                      // 🔍 HOTEL VALIDITY CHECK
                    $sqlValidHotel = array();
                    $sqlValidHotel['QUERY'] = "SELECT 1
                                                FROM " . _DB_TARIFF_ACCOMMODATION_ . "
                                                WHERE status = ?
                                                AND tariff_cutoff_id = ?
                                                AND hotel_id = ?
                                                AND inr_amount > 0
                                                LIMIT 1";

                    $sqlValidHotel['PARAM'][] = array('FILD'=>'status','DATA'=>'A','TYP'=>'s');
                    $sqlValidHotel['PARAM'][] = array('FILD'=>'tariff_cutoff_id','DATA'=>$currentCutoffId,'TYP'=>'s');
                    $sqlValidHotel['PARAM'][] = array('FILD'=>'hotel_id','DATA'=>$val['id'],'TYP'=>'s');

                    $hotelHasValidAmount = $mycms->sql_select($sqlValidHotel);

                    // ❌ Skip hotel completely if no valid amount
                    if (empty($hotelHasValidAmount)) {
                        continue;
                    }
                  ?>
                      <button class="active hotel_tab_btn" data-tab="<?= $val['id'] ?>"><?= $val['hotel_name'] ?></button>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
              <div class="registration_right_body_content">
                <input type="hidden" name="hotel_id" id="hotel_id">
                <input type="hidden" name="hotel_select_acco_id" id="hotel_select_acco_id">
                <input type="hidden" name="accommodation_room" id="accommodation_room">
                <?php



                if (count($resultFetchHotel)) {
                  foreach ($resultFetchHotel as $k => $val) {
                    //========= Fetch Hotel Accessories Start ==========//
                    $delegateId = $_REQUEST['abstractDelegateId'];
                    $getAccommodationMaxRoom = getAccommodationMaxRoom($delegateId);
                    $totalCount = 3 - $getAccommodationMaxRoom;
                    //========= Fetch Hotel Accessories End ==========//

                    $sql_Count_hotel  =   array();
                    $sql_Count_hotel['QUERY'] =   "SELECT COUNT(*) AS countdata 
                                                  FROM " . _DB_REQUEST_ACCOMMODATION_ . "
                                                  WHERE `status`  = ?
                                                  AND `hotel_id`  = ?
                                                  ORDER BY `id` ASC";

                    $sql_Count_hotel['PARAM'][]   =   array('FILD' => 'status',      'DATA' => 'A',         'TYP' => 's');
                    $sql_Count_hotel['PARAM'][]   =   array('FILD' => 'hotel_id',     'DATA' => $val['id'],         'TYP' => 's');

                    $row_Count_hotel = $mycms->sql_select($sql_Count_hotel);
                    $countSeatLimit = $row_Count_hotel[0]['countdata'];


                    $sql_package  =   array();
                    $sql_package['QUERY'] =   "SELECT * 
                                                FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                WHERE `status`  = ?
                                                AND `hotel_id`  = ?
                                                ORDER BY `id` ASC";

                    $sql_package['PARAM'][]   =   array('FILD' => 'status',      'DATA' => 'A',         'TYP' => 's');
                    $sql_package['PARAM'][]   =   array('FILD' => 'hotel_id',     'DATA' => $val['id'],         'TYP' => 's');

                    $row_package = $mycms->sql_select($sql_package);
                    // print_r($sql_package); die;

                    $sql_hotel  =   array();
                    $sql_hotel['QUERY'] =   "SELECT * 
                                                FROM " . _DB_MASTER_HOTEL_ . "
                                                WHERE `status`  = ?
                                                AND `id`  = ?
                                                ORDER BY `id` ASC";

                    $sql_hotel['PARAM'][]   =   array('FILD' => 'status',      'DATA' => 'A',         'TYP' => 's');
                    $sql_hotel['PARAM'][]   =   array('FILD' => 'id',     'DATA' => $val['id'],         'TYP' => 's');

                    $row_hotel = $mycms->sql_select($sql_hotel);

                    //print_r($row_hotel[0]['hotel_name']);
                    //die();
                    $hotel_seat_limit = $row_hotel[0]['seat_limit'];
                    //hotel_image -> hotel_background_image
                    // $hotel_image = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row_hotel[0]['hotel_background_image'];
                    $presentSeatLimit = $hotel_seat_limit - $countSeatLimit;
                    //  $presentSeatLimit = 500; // test
                    // print_r($row_hotel[0]['hotel_name']);
                    // die();

                ?>
                    <div class="hotel_box" id="<?= $val['id'] ?>" style="display: block;">
                      <div class="hotel_box_inner">
                        <div class="hotel_box_left">
                          <div class="hote_box_left_top">
                            <t><?php star(); ?><?= $val['hotelRatings'] ?> Star</t>
                            <div class="hotel_owl owl-carousel owl-theme">
                              <?php
                              $sqlRoom = array();
                              $sqlRoom['QUERY'] = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . " 
                                                          WHERE `hotel_id` = ? AND status='A' AND purpose='room'  
                                                          ORDER BY `id` ASC";
                              $sqlRoom['PARAM'][] = array('FILD' => 'hotel_id', 'DATA' => $val['id'], 'TYP' => 's');

                              $querySlider = $mycms->sql_select($sqlRoom, false);

                              if ($querySlider) {
                                foreach ($querySlider as $row) {
                                  $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];
                              ?>
                                  <div class="item">
                                    <img src="<?= $icon ?>" alt="Hotel Accessory">
                                  </div>
                              <?php
                                }
                              }
                              ?>
                            </div>
                          </div>
                          <ul class="hote_box_left_bottom">
                            <?php
                            $sqlAcc = array();
                            $sqlAcc['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $val['id'] . "' AND status='A' AND purpose='aminity'  ORDER BY `id` ASC";

                            $queryAcc = $mycms->sql_select($sqlAcc, false);

                            if ($queryAcc) {
                              foreach ($queryAcc as $keyqueryAcc => $aminity) {
                                $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $aminity['accessories_icon'];
                            ?>
                                <li><img src=<?= $icon ?> alt=""><?= $aminity['accessories_name'] ?></li>
                            <?
                              }
                            }
                            ?>
                          </ul>
                        </div>
                        <div class="hotel_box_right">
                          <?php
                            $room_type_status  =   array();
                            $room_type_status['QUERY'] =   "SELECT `room_type_status` 
                                                        FROM " . _DB_MASTER_HOTEL_ . "
                                                        WHERE `status`  = ?
                                                        AND `id`  = ?
                                                        ORDER BY `id` ASC";

                            $room_type_status['PARAM'][]   =   array('FILD' => 'status',      'DATA' => 'A',         'TYP' => 's');
                            $room_type_status['PARAM'][]   =   array('FILD' => 'id',     'DATA' => $val['id'],         'TYP' => 's');

                            $row_hotel_status = $mycms->sql_select($room_type_status);
                           
                          $sqlRoom = array();
                          $sqlRoom['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $val['id'] . "' AND status='A' AND purpose='room'  ORDER BY `id` ASC";

                          $queryRoom = $mycms->sql_select($sqlRoom, false);
                          if ($queryRoom  && $row_hotel_status[0]['room_type_status'] == 'yes') {
                            foreach ($queryRoom as $k => $rowRoom) {
                              // $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];
                             $hasValidPackage = false;
                              $sqlFetchPack        =  array();
                              $sqlFetchPack['QUERY']    =  "SELECT `package_name` ,`id`
                                                                  FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                                  WHERE `status` 		= 	 ?
                                                                  AND `hotel_id` 		= 	 ? ";

                              $sqlFetchPack['PARAM'][]  =  array('FILD' => 'status',     'DATA' => 'A',     'TYP' => 's');
                              $sqlFetchPack['PARAM'][]  =  array('FILD' => 'hotel_id',     'DATA' => $val['id'],     'TYP' => 's');

                              $resultFetchPack        = $mycms->sql_select($sqlFetchPack);
                              foreach ($resultFetchPack as $pkg) {

                                $sqlCheckAmount = array();
                                $sqlCheckAmount['QUERY'] = "SELECT inr_amount
                                                            FROM " . _DB_TARIFF_ACCOMMODATION_ . "
                                                            WHERE status = ?
                                                            AND tariff_cutoff_id = ?
                                                            AND hotel_id = ?
                                                            AND roomTypeId = ?
                                                            AND package_id = ?
                                                            AND inr_amount > 0
                                                            LIMIT 1";

                                $sqlCheckAmount['PARAM'][] = array('FILD'=>'status','DATA'=>'A','TYP'=>'s');
                                $sqlCheckAmount['PARAM'][] = array('FILD'=>'tariff_cutoff_id','DATA'=>$currentCutoffId,'TYP'=>'s');
                                $sqlCheckAmount['PARAM'][] = array('FILD'=>'hotel_id','DATA'=>$val['id'],'TYP'=>'s');
                                $sqlCheckAmount['PARAM'][] = array('FILD'=>'roomTypeId','DATA'=>$rowRoom['id'],'TYP'=>'s');
                                $sqlCheckAmount['PARAM'][] = array('FILD'=>'package_id','DATA'=>$pkg['id'],'TYP'=>'s');

                                $checkAmount = $mycms->sql_select($sqlCheckAmount);

                                if (!empty($checkAmount)) {
                                    $hasValidPackage = true;
                                    break;
                                }
                            }

                            // ❌ NO valid package → hide entire room
                            if (!$hasValidPackage) {
                                continue;
                            }
                          ?>
                              <div class="stay_li_right">
                                <n>
                                  <g><?= $rowRoom['accessories_name'] ?>
                                    <ii>Elegant city views.</ii>
                                  </g>
                                  <div class="accomdationroomqty-input">
                                    <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                    <input class="accmomdation-qty" type="number" name="accmomdation-qty[<?=$val['id']?>][<?= $rowRoom['id'] ?>]" min="1" max="10" value="1">
                                    <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                  </div>
                                </n>
                                <div class="cus_check_wrap">
                                  <?php
                                
                                  
                                  if ($resultFetchPack) {
                                    foreach ($resultFetchPack as $k => $row) {
                                      // $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];
                                      $sqlPackageCheckoutDate1  =  array();
                                      // query in tariff table
                                      $sqlPackageCheckoutDate1['QUERY'] = "select * 
                                                                                  FROM " . _DB_TARIFF_ACCOMMODATION_ . " accomodation
                                                                                  WHERE status = ?
                                                                                  AND tariff_cutoff_id = ?
                                                                                  AND hotel_id = ?
                                                                                  AND roomTypeId = ?
                                                                                  AND package_id = ?";
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'status',       'DATA' => 'A',           'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'tariff_cutoff_id', 'DATA' => $currentCutoffId,     'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'hotel_id',     'DATA' => $val['id'],     'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'roomTypeId',     'DATA' => $rowRoom['id'],     'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'package_id',     'DATA' => $row['id'],     'TYP' => 's');
                                      // echo "<pre>";
                                      // print_r($sqlPackageCheckoutDate1);
                                      $resPackageCheckoutDate1 = $mycms->sql_select($sqlPackageCheckoutDate1);
                                      if ($resPackageCheckoutDate1[0]['inr_amount'] <= 0) {
                                          continue;
                                      }
                                      $invoiceTitle =  $row['package_name'] . "@" . $rowRoom['accessories_name'];

                                  ?>
                                      <label class="cus_check stay_select">
                                        <!-- <input type="hidden" name="tariff_package_id[]" value="<?= $resPackageCheckoutDate1[0]['id'] ?>"> -->

                                        <input type="checkbox"   name="package_id[]" data-hotel-id="<?= $val['id'] ?>" value="<?= $resPackageCheckoutDate1[0]['id'] ?>" invoiceTitle="Residential package" invoiceName="<?= $invoiceTitle ?>" amount="<?= $resPackageCheckoutDate1[0]['inr_amount'] ?>" data-base-amount="<?= $resPackageCheckoutDate1[0]['inr_amount'] ?>" hotel_id="<?= $val['id'] ?>" hotel_select_acco_id="<?= $val['id'] ?>" accommodation_room="<?= $rowRoom['id'] ?>">
                                        <span class="checkmark">
                                          <n><?= $row['package_name'] ?></n>
                                          <h class="package-price">₹ <?= $resPackageCheckoutDate1[0]['inr_amount'] ?? 0.00 ?></h>
                                        </span>
                                      </label>
                                  <?php
                                    }
                                  }

                                  ?>

                                </div>
                              </div>
                          <?php
                            }
                          }else if($row_hotel_status[0]['room_type_status']== 'no'){
                            ?>
                               <div class="stay_li_right">
                                 <n>
                                    <!-- <g><?= $rowRoom['accessories_name'] ?>
                                      <ii>Elegant city views.</ii>
                                    </g> -->
                                    <div class="accomdationroomqty-input">
                                      <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                      <input class="accmomdation-qty" type="number" name="accmomdation-qty[<?=$val['id']?>][]" min="1" max="10" value="1">
                                      <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                    </div>
                                  </n>
                                <div class="cus_check_wrap">
                                  
                                  <?php
                                  $sqlFetchPack        =  array();
                                  $sqlFetchPack['QUERY']    =  "SELECT `package_name` ,`id`
                                                                      FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                                      WHERE `status` 		= 	 ?
                                                                      AND `hotel_id` 		= 	 ? ";

                                  $sqlFetchPack['PARAM'][]  =  array('FILD' => 'status',     'DATA' => 'A',     'TYP' => 's');
                                  $sqlFetchPack['PARAM'][]  =  array('FILD' => 'hotel_id',     'DATA' => $val['id'],     'TYP' => 's');

                                  $resultFetchPack        = $mycms->sql_select($sqlFetchPack);
                                  if ($resultFetchPack) {
                                    foreach ($resultFetchPack as $k => $row) {
                                      // $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];
                                      $sqlPackageCheckoutDate1  =  array();
                                      // query in tariff table
                                      $sqlPackageCheckoutDate1['QUERY'] = "select * 
                                                                                  FROM " . _DB_TARIFF_ACCOMMODATION_ . " accomodation
                                                                                  WHERE status = ?
                                                                                  AND tariff_cutoff_id = ?
                                                                                  AND hotel_id = ?
                                                                                  AND roomTypeId = ?
                                                                                  AND package_id = ?";
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'status',       'DATA' => 'A',           'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'tariff_cutoff_id', 'DATA' => $currentCutoffId,     'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'hotel_id',     'DATA' => $val['id'],     'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'roomTypeId',     'DATA' => '0',     'TYP' => 's');
                                      $sqlPackageCheckoutDate1['PARAM'][]  =  array('FILD' => 'package_id',     'DATA' => $row['id'],     'TYP' => 's');
                                      // echo "<pre>";
                                      // print_r($sqlPackageCheckoutDate1);
                                      $resPackageCheckoutDate1 = $mycms->sql_select($sqlPackageCheckoutDate1);
                                      if ($resPackageCheckoutDate1[0]['inr_amount'] <= 0) {
                                          continue;
                                      }
                                      $invoiceTitle =  $row['package_name'] . "@" . $rowRoom['accessories_name'];

                                  ?>
                                        
                                      <label class="cus_check stay_select">
                                        <!-- <input type="hidden" name="tariff_package_id[]" value="<?= $resPackageCheckoutDate1[0]['id'] ?>"> -->
                                        
                                        <input type="checkbox" name="package_id[]" data-hotel-id="<?= $val['id'] ?>" value="<?= $resPackageCheckoutDate1[0]['id'] ?>" invoiceTitle="Residential package" invoiceName="<?= $invoiceTitle ?>" amount="<?= $resPackageCheckoutDate1[0]['inr_amount'] ?>" data-base-amount="<?= $resPackageCheckoutDate1[0]['inr_amount'] ?>" hotel_id="<?= $val['id'] ?>" hotel_select_acco_id="<?= $val['id'] ?>" accommodation_room="<?= $rowRoom['id'] ?>">
                                        <span class="checkmark">
                                          <n><?= $row['package_name'] ?></n>
                                          <h class="package-price">₹ <?= $resPackageCheckoutDate1[0]['inr_amount'] ?? 0.00 ?></h>
                                        </span>
                                      </label>
                                  <?php
                                    }
                                  }

                                  ?>

                                </div>
                                <?
                          } if($val['room_type_status'] == 'yes'){
                          ?>
                          <div class="stay_li_right">
                            <n class="stay_note">
                              <g>
                                <ii><?php pending(); ?>Room rates are per night and exclusive of GST.</ii>
                              </g>
                            </n>
                          </div>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                }

                ?>
              </div>
              <ul class="accomdationprice_total">
                    <li>
                        <p><?= $val['hotel_name'] ?><span>Single</span></p>
                        <h6>
                            <span>Delux<br>2 Rooms<br>3 Nights</span><span>Delux<br>2 Rooms<br>3 Nights</span><span>Delux<br>2 Rooms<br>3 Nights</span><span>Delux<br>2 Rooms<br>3 Nights</span>
                        </h6>
                        <h5>Sub-total<span>0.00</span></h5>
                    </li>
                </ul>
                <div class="accomdation_total">
                    <h5>Total<span>2000<n>With 18% GST</n></span></h5>
                </div>
            </div>
            <div class="registration_right_bottom">
              <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>

              <button type="button" name="next" class="skip-button skip"><?php skip() ?>Skip</button>
              <button type="button" name="next" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
            </div>
          </fieldset>
          <?
            }
            ?>
          <!-- accommodation -->
          <!-- workshop -->
          <?
          if ((!empty($workshopDetailsArray))  && $currentWorkshopCutoffId > 0) {
          ?>
          <fieldset class="registration_right_wrap WorkshopFindset">
            <div class="registration_right_head">
             <?=$cfg['WORKSHOP_TITLE']?>
            </div>

            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Add Workshops</h4>
                  <h5>Hands-on training sessions (Optional).</h5>
                </div>
                <div class="registration_right_body_head_right">
                  <a class="selected-count">0 Selected</a>
                </div>
              </div>
              <div class="registration_right_body_tab">
                <div class="hotel_link_owl owl-carousel owl-theme">
                  <?
                  $conferenceTariffArray   = getAllRegistrationTariffs($currentCutoffId);
                  $workshopCountArr      = totalWorkshopCountReport();

                  //echo '<pre>'; print_r($workshopDetailsArray);

                  $comboTariffArray   = getAllRegistrationComboTariffs($currentCutoffId);

                  $workshopRegChoices = array();


                  $workshoDefinedDate = '';
                  foreach ($workshopDetailsArray as $keyWorkshopclsf => $rowWorkshopclsf) {
                    foreach ($rowWorkshopclsf as $keyRegClasf => $rowRegClasf) {

                      $workshopRegChoices[$rowRegClasf['WORKSHOP_TYPE']][$keyWorkshopclsf][$keyRegClasf] = $rowRegClasf;
                      $workshoDefinedDate = $rowRegClasf['WORKSHOP_DATE'];
                    }
                  }
                  // echo "<pre>";
                  // print_r($workshopDetailsArray);
                  $sql_cal  =  array();
                  $sql_cal['QUERY']  =  "SELECT DISTINCT `workshop_date`
                                          FROM " . _DB_WORKSHOP_CLASSIFICATION_ . " 
                                          WHERE status = 'A' 
                                          ORDER BY `display` ASC";
                  $res_cal = $mycms->sql_select($sql_cal);
                  foreach ($res_cal as $key => $rowsl) {
                  ?>
                    <button class="active wrkshp_tab_btn" id="wrkshp_tab_btn" data-tab="<?= $rowsl['workshop_date'] ?>"><?= displayDateFormat($rowsl['workshop_date']) ?></button>
                  <?
                  }
                  ?>
                </div>
              </div>
              <div class="registration_right_body_content" id="workShops">
                <?
                foreach ($res_cal as $key => $rowsl) {
                  $sql_cal1  =  array();
                  $sql_cal1['QUERY']  =  "SELECT * 
                                              FROM " . _DB_WORKSHOP_CLASSIFICATION_ . " 
                                              WHERE workshop_date = '" . $rowsl['workshop_date'] . "' 
                                              AND  status = 'A' 
                                              ";
                  $res_cal1 = $mycms->sql_select($sql_cal1);

                ?>

                  <div class="wrkshp_box" id="<?= $rowsl['workshop_date'] ?>" style="display: block;">

                    <div class="cus_check_wrap g2">
                      <?
                      $registration_classification_id = isset($_POST['registration_classi_id']) ? (int)$_POST['registration_classi_id'] : '';

                      foreach ($res_cal1 as $key_cal1 => $rowslcal1) {

                        $sqlTarrif = array();
                        $sqlTarrif['QUERY'] = "SELECT *
                                          FROM " . _DB_TARIFF_WORKSHOP_ . " 
                                          WHERE workshop_id = '" . $rowslcal1['id'] . "'
                                          AND tariff_cutoff_id = '" . $currentWorkshopCutoffId . "'
                                          AND registration_classification_id ='" . $registration_classification_id . "'";

                        $resTarrif      = $mycms->sql_select($sqlTarrif);

                        if ($resTarrif && $resTarrif[0]['inr_amount'] > 0) {
                          $rowTarrif    = $resTarrif[0];

                          $amountInr = $rowTarrif['inr_amount'];
                          $amountUsd = $rowTarrif['usd_amount'];
                          $amountDis = $registrationDetailsVal['CURRENCY'] . ' ' . number_format($amountInr);

                        } else {
                          $amountInr = '0.00';
                          $amountUsd =  '0.00';
                          $amountDis = 'Included in Registration';
                        }

                      ?>
                        <label class="cus_check workshop_select">
                          <!-- <input type="checkbox" name="regimood" checked> -->
                          <input type="checkbox" name="workshop_id[]" value="<?= $rowslcal1['id'] ?>" id="workshop_id_<?= $key_cal1 . '_' . $keyRegClasf ?>" data-type="<?= $rowslcal1['type'] ?> value=" <?= $rowslcal1['id'] ?>" <?= $style ?> workshopName="<?= $rowslcal1['sequence_by'] ?>" operationMode="workshopId" amount="<?= $amountInr ?>" invoiceTitle="Workshop" invoiceName="<?= $rowslcal1['classification_title'] ?>" registrationClassfId="<?= $keyRegClasf ?>" workshopCount="<?= $workshopCount ?>" icon="<?= $workshopIcon ?>" reg="workshop">

                          <span class="checkmark">
                            <n>
                              <?php workshop(); ?>
                              <g><?= $rowslcal1['classification_title'] ?><ii><?= $amountDis ?></ii>
                              </g>
                              <iii></iii>
                            </n>
                            <h>
                              <l><?php address(); ?> <?= $rowslcal1['venue'] ?></l>
                              <l><?php calendar(); ?><?= displayDateFormat($rowslcal1['workshop_date']) ?></l>
                            </h>
                          </span>
                        </label>
                      <?
                      }
                      ?>

                    </div>
                  </div>
                <?php
                }
                ?>

              </div>
            </div>
            <div class="registration_right_bottom">
              <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>
              <button type="button" name="next" class="skip-button skip"><?php skip() ?>Skip</button>
              <button type="button" name="next" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
            </div>
          </fieldset>
          <?
          }
          ?>
          <!-- workshop -->
          <!-- galadinner -->
          <?
          if (count($dinnerTariffArray) > 0 && $hasDinnerAmount) {

            //  echo '<pre>'; print_r($dinnerTariffArray);        
          ?>

            <fieldset class="registration_right_wrap dinnerFieldset">
              <div class="registration_right_head">
               <?=$cfg['DINNER_TITLE']?>
              </div>

              <div class="registration_right_body">
                <div class="registration_right_body_head">
                  <div class="registration_right_body_head_left">
                    <h4>Add Gala Dinner</h4>
                    <h5>Join us for exclusive networking evenings.</h5>
                  </div>
                </div>
                <div class="registration_right_body_content">
                  <div class="cus_check_wrap g2">
                    <?php
                    foreach ($dinnerTariffArray as $keyDinner => $dinnerValue) {
                    if ($dinnerValue[$currentCutoffId]['AMOUNT'] > 0) {

                    ?>
                      <label class="cus_check workshop_select gala_select">
                        <input type="checkbox" class="checkboxClassDinner" name="dinner_value[]" value="<?= $dinnerValue[$currentCutoffId]['ID'] ?>" operationMode="dinner" use="dinner" amount="<?= $dinnerValue[$currentCutoffId]['AMOUNT'] ?>" invoiceTitle="Gala Dinner" invoiceName="<?= $dinnerValue[$currentCutoffId]['DINNER_TITTLE'] ?>-conference" icon="<?= $banquetIcon ?>" reg="dinner" qty="1">
                        <span class="checkmark">
                          <n>
                            <?php dinner(); ?>
                            <iii></iii>
                          </n>
                          <g><?= $dinnerValue[$currentCutoffId]['dinner_hotel_name'] ?>
                            <ii><?php calendar(); ?><?= $dinnerValue[$currentCutoffId]['DATE'] ?></ii>
                            <k>A traditional Bengali themed evening with live classical music.</k>
                          </g>
                          <h>
                            <l><?=  $registrationDetailsVal['CURRENCY'] . ' ' . number_format($dinnerValue[$currentCutoffId]['AMOUNT']) ?></l>
                          </h>
                        </span>
                      </label>
                    <?
                    }
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="registration_right_bottom">
                <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>
                <button type="button" name="next" class="skip-button skip"><?php skip() ?>Skip</button>
                <button type="button" name="next" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
              </div>
            </fieldset>
          <?
          }
          ?>
          <!-- galadinner -->
          <!-- guest -->
           <?
           if ($registrationAmount != '' && $registrationAmount > 0) {
            ?>
          <fieldset class="registration_right_wrap accompanyfieldset">
            <div class="registration_right_head">
             <?=$cfg['ACCOMAPNY_TITLE']?>
            </div>
            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Accompanying Persons</h4>
                  <h5>Add family members.</h5>
                </div>
              </div>
              <div class="registration_right_body_content">
                <div class="guest_wrap" id="accompanyingTableBody">
                  <?php
                  $accompanyIndex = 0;
                  $accompanyCatagory = 1; // same as old
                  $registrationCurrency = $conferenceTariffArray[$accompanyCatagory]['CURRENCY'];

                  // For initial guest row (first accompany)
                  ?>
                  <?php
                  //echo '<pre>'; print_r($dinnerTariffArray);
                  foreach ($dinnerTariffArray as $keyDinner => $dinnerValue) {
                    if (floatval($dinnerValue[$currentCutoffId]['AMOUNT']) > 0) {
                      $dinner_amnt_display = '<strong>' . number_format($dinnerValue[$currentCutoffId]['AMOUNT'], 2) . '</strong> <br>' . $registrationDetailsVal['CURRENCY'];
                  ?>
                      <input type="hidden" name="dinner_amnt_display" id="dinner_amnt_display" value="<?= $dinner_amnt_display ?>" />

                      <input type="hidden" name="dinner_classification_id" id="dinner_classification_id" value="<?= $dinnerValue[$currentCutoffId]['ID'] ?>" />

                      <input type="hidden" name="dinner_amnt" id="dinner_amnt" value="<?= $dinnerValue[$currentCutoffId]['AMOUNT'] ?>" />

                      <input type="hidden" name="dinner_title" id="dinner_title" value="<?= $dinnerValue[$currentCutoffId]['DINNER_TITTLE'] ?>" />

                      <input type="hidden" name="dinner_hotel_name" id="dinner_hotel_name" value="<?= $dinnerValue[$currentCutoffId]['dinner_hotel_name'] ?>" />

                      <input type="hidden" name="dinner_hotel_link" id="dinner_hotel_link" value="<?= $dinnerValue[$currentCutoffId]['link'] ?>" />

                      <input type="hidden" name="dinner_date" id="dinner_date" value="<?= $dinnerValue[$currentCutoffId]['DATE'] ?>" />


                  <?php

                    }
                  }
                  $sql_icon['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
                                                              WHERE `id`='3' AND `purpose`='Registration' AND status IN ('A', 'I')";
                  $result    = $mycms->sql_select($sql_icon);
                  $accompanyingIcon = $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['icon'];

                  ?>
                  <li>
                    <div class="guest_wrap_box">
                      <span class="guest_wrap_grp_icon"><?php duser(); ?></span>
                      <div class="guest_wrap_inner">
                        <div class="guest_wrap_grp">
                          <label class="guest_wrap_grp_head">Guest Name</label>
                          <input type="text" class="form-control accompany_name"
                            name="accompany_name_add[<?= $accompanyIndex ?>]"
                            placeholder="Enter full Name"
                            validate="Enter the accompany name"
                            countindex="<?= $accompanyIndex ?>" required>
                          <input type="hidden" name="accompany_selected_add[<?= $accompanyIndex ?>]" value="0" />
                          <input type="checkbox" style="display:none;" class="accompanyCount" name="accompanyCount" id="accompanyCount" use="accompanyCountSelect" value="1" amount="<?= $registrationAmount ?>" invoiceTitle="Accompanying Person" invoiceName="" icon="<?= $accompanyingIcon ?>" reg="accompany">

                        </div>
                        <div class="guest_wrap_grp">
                          <?php
                          // Fetch food preference from DB (if any)
                          $sql_cal = array();
                          $sql_cal['QUERY'] = "SELECT * FROM " . _DB_ACCOMPANY_CLASSIFICATION_ . " WHERE `status` != 'D'";
                          $res_cal = $mycms->sql_select($sql_cal);

                          if (!empty($res_cal) && $res_cal[0]['food_preference'] == 'A') { ?>
                            <!-- <div class="food-preference">
                                                <div class="custom-checkbox accompanying">
                                                    <input type="radio" name="accompany_food_choice[<?= $accompanyIndex ?>]" id="veg_<?= $accompanyIndex ?>" value="VEG">
                                                    <label for="veg_<?= $accompanyIndex ?>"><span>Veg</span></label>
                                                </div>
                                                <div class="custom-checkbox accompanying">
                                                    <input type="radio" name="accompany_food_choice[<?= $accompanyIndex ?>]" id="nonveg_<?= $accompanyIndex ?>" value="NON_VEG">
                                                    <label for="nonveg_<?= $accompanyIndex ?>"><span>Non-Veg</span></label>
                                                </div>
                                            </div> -->

                            <label class="guest_wrap_grp_head">Food Preference</label>
                            <div class="cus_check_wrap g2">
                              <label class="cus_check stay_select">
                                <input type="radio" name="accompany_food_choice[<?= $accompanyIndex ?>]" id="veg_<?= $accompanyIndex ?>" value="VEG" validate="Please select your food preference" >
                                <span class="checkmark">
                                  <n>Veg</n>
                                </span>
                              </label>
                              <label class="cus_check stay_select">
                                <input type="radio" name="accompany_food_choice[<?= $accompanyIndex ?>]" id="nonveg_<?= $accompanyIndex ?>" value="NON_VEG" validate="Please select your food preference" >
                                <span class="checkmark">
                                  <n>Non-veg</n>
                                </span>
                              </label>
                            </div>
                        </div>
                      <?php } ?>
                      <div class="guest_wrap_grp">
                        <label class="guest_wrap_grp_head">Tariff</label>
                        <h><span class="accompanyAmountDisplay"><?=   $registrationDetailsVal['CURRENCY'] . ' ' . number_format($registrationAmount) ?></span></h>
                      </div>
                      </div>
                    </div>
                    <a href="#" class="guest_action removeGuest"><?php delete(); ?></a>
                    <input type="hidden" 
                        name="accompanyAmountSet" 
                        value="<?= $registrationAmount ?>" 
                        data-currency="<?= $registrationDetailsVal['CURRENCY'] ?>">
                    <!-- <td class="guest_action removeGuest"><a href="#"><?php delete(); ?></a></td> -->
                    <input type="hidden" name="accompanyAmount" id="accompanyAmount" value="<?= $registrationAmount ?>">
                    <input type="hidden" name="accompanyTariffAmount" id="accompanyTariffAmount" value="<?= $registrationAmount ?>">
                    <input type="hidden" name="accompanyCounts" id="accompanyCounts" value="1">
                  </li>

                </div>
                <button type="button" class="add_guest" id="add-accompany-btn">Add Guest</button>
              </div>
            </div>
            <div class="registration_right_bottom">
              <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>
              <button type="button" name="next" class="skip-button skip"><?php skip() ?>Skip</button>
              <button type="button" name="next" class="next action-button">Continue<i class="fal fa-angle-right"></i></button>
            </div>
          </fieldset>
          <?
           }
          ?>
          <!-- guest -->


          <!-- review -->
          <fieldset class="registration_right_wrap">
            <?php
            $offline_payments = json_decode($cfg['PAYMENT.METHOD']);

            $sql_qr = array();
            $sql_qr['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . "
                                                        WHERE `id`!='' AND `title`IN ('QR Code','Online Payment Logo')";
            $result = $mycms->sql_select($sql_qr);
            $onlinePaymentLogo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['image'];
            $QR_code = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[1]['image'];
            // echo $cfg['PAYMENT.METHOD'];
            ?>
            <div class="registration_right_head">
              Review
            </div>
            <div class="registration_right_body">
              <div class="registration_right_body_head">
                <div class="registration_right_body_head_left">
                  <h4>Order Summary</h4>
                  <!-- <h5>Invoice #NC25-2836</h5> -->
                </div>
              </div>
              <div class="registration_right_body_content">

                <div class="review_wrap">
                  <div class="review_left">
                    <ul use="totalAmountTable">
                      <li use=rowCloneable style="display:none;">
                        <span><?php user() ?></span>
                        <n use="invTitle">
                          <h use="invName"></h>
                        </n>
                        <k use="amount"></k>
                      </li>

                      <li use="subtotalRow">
                        <div class="w-100">
                          <p class="frm-head d-flex justify-content-between align-items-center">Subtotal<k use="subtotalAmount">₹ 0.00</k>
                          </p>
                          <? 
                          if($cfg['GST.FLAG']!=3){
                            ?>
                          <p class="frm-head d-flex justify-content-between align-items-center gstcharge">GST (18%)<k use="totalGstAmount">₹ 0.00</k>
                          </p>
                          <?
                          }
                          ?>
                           <p class="frm-head d-flex justify-content-between align-items-center internetcharge">Internet Handling Charges<k use="internetAmount">₹ 0.00</k>
                          </p>
                        </div>
                      </li>
                      <li>
                        <div class="w-100" use="totalAmount">
                          <h5 class="frm-head d-flex justify-content-between align-items-center mb-0">Total Payable<k use="totalAmountpay" style="color: var(--sky);">₹ 0.00</k>
                          </h5>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="review_right">
                  <div class="review_tab">
                    <div class="hotel_link_owl owl-carousel owl-theme">
                     <input type="hidden" name="registrationMode" id="registrationMode">

                      <?php if (in_array("Neft", $offline_payments)) { ?>
                      <button type="button" class="active"
                        onclick="
                          $('#banktransfer').show();$('#upi').hide();$('#Cards').hide();$('#DD').hide();$('#cash').hide();
                          $('.review_tab button').removeClass('active');$(this).addClass('active');
                          $('input[type=radio][use=payment_mode_select][value=Neft]').prop('checked',true).trigger('click');
                        ">
                        <i class="fal fa-building"></i> NEFT
                      </button>
                      <?php } ?>

                      <?php if (in_array("Upi", $offline_payments)) { ?>
                      <button type="button"
                        onclick="
                          $('#banktransfer').show();$('#upi').hide();$('#Cards').hide();$('#DD').hide();$('#cash').hide();
                          $('.review_tab button').removeClass('active');$(this).addClass('active');
                          $('input[type=radio][use=payment_mode_select][value=Upi]').attr('act','Upi').prop('checked',true).trigger('click');
                        ">
                        <?php qr(); ?> UPI
                      </button>
                      <?php } ?>

                      <?php if (in_array("Card", $offline_payments)) { ?>
                      <button type="button"
                        onclick="
                          $('#banktransfer').hide();$('#upi').hide();$('#Cards').show();$('#DD').hide();$('#cash').hide();
                          $('.review_tab button').removeClass('active');$(this).addClass('active');
                          $('input[type=radio][use=payment_mode_select][value=Card]').prop('checked',true).trigger('click');
                        ">
                        <?php qr(); ?> Razorpay
                      </button>
                      <?php } ?>

                      <?php if (in_array("Cheque/DD", $offline_payments)) { ?>
                      <button type="button"
                        onclick="
                          $('#banktransfer').hide();$('#upi').hide();$('#Cards').hide();$('#DD').show();$('#cash').hide();
                          $('.review_tab button').removeClass('active');$(this).addClass('active');
                          $('input[type=radio][use=payment_mode_select][value=Cheque]').prop('checked',true).trigger('click');
                        ">
                        <?php qr(); ?> DD
                      </button>
                      <?php } ?>

                      <?php if (in_array("Cash", $offline_payments)) { ?>
                      <button type="button"
                        onclick="
                          $('#banktransfer').hide();$('#upi').hide();$('#Cards').hide();$('#DD').hide();$('#cash').show();
                          $('.review_tab button').removeClass('active');$(this).addClass('active');
                          $('input[type=radio][use=payment_mode_select][value=Cash]').prop('checked',true).trigger('click');
                        ">
                        <?php qr(); ?> Cash
                      </button>
                      <?php } ?>

                      <!-- Hidden radios (logic only – REQUIRED) -->
                      <input type="radio" name="payment_mode" use="payment_mode_select" value="Neft" hidden>
                      <input type="radio" name="payment_mode" use="payment_mode_select" value="Upi" hidden>
                      <input type="radio" name="payment_mode" use="payment_mode_select" value="Card" hidden>
                      <input type="radio" name="payment_mode" use="payment_mode_select" value="Cheque" hidden>
                      <input type="radio" name="payment_mode" use="payment_mode_select" value="Cash" hidden>

                    </div>
                   </div>
                    <div class="review_right_box" id="banktransfer" style="display: block;">
                      <ul>
                        <?php
                          if (in_array("Neft", $offline_payments)) {
                          ?>
                        <li class="for-neft-rtgs-only">
                          <h6 class="d-flex justify-content-between align-items-center">Bank Details</h6>
                          <div>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-start" style="flex-direction: column;gap: 2px;border-bottom: 1px dashed var(--border);padding-bottom: 6px;">Beneficiary Name<span class="text-white"><?= $cfg['INVOICE_BENEFECIARY'] ?></span></p>
                            <!-- <p class="frm-head text_dark d-flex justify-content-between align-items-center">Beneficiary Name<span class="text-white"><?= $cfg['INVOICE_BENEFECIARY'] ?></span></p> -->
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Bank<span class="text-white"><?= $cfg['INVOICE_BANKNAME'] ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Account<span class="text-white"><?= $cfg['INVOICE_BANKACNO'] ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center mb-0">IFSC<span class="text-white"><?= $cfg['INVOICE_BANKIFSC'] ?></span></p>
                          </div>
                        </li>
                         <?php } ?>
                         <?php
                          if (in_array("Upi", $offline_payments)) {
                          ?>
                          
                                <li class="text-center for-upi-only" style="display: none;">
                                  <img src="<?= $QR_code ?>" alt="">
                                  <h6 class="d-flex justify-content-center align-items-center">Scan QR</h6>
                                </li>
                          <?php } ?>
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">Drawee Bank</h6>
                          <input type="text" class="form-control mandatory" name="neft_bank_name" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                        </li>
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">Date</h6>
                          <input type="date" class="form-control mandatory" name="neft_date" id="neft_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select date">
                        </li>
                         <?php
                          if (in_array("Upi", $offline_payments)) {
                          ?>
                        <li class="for-upi-only"  style="display: none;" >
                          <h6 class="d-flex justify-content-between align-items-center">UPI Transaction No.</h6>
                          <input class="for-upi-only" type="text" class="form-control mandatory utrnft" name="txn_no" id="txn_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                        </li>
                         <?php } ?>
                         <?php
                          if (in_array("Neft", $offline_payments)) {
                          ?>
                        <li class="for-neft-rtgs-only"  style="display: none;" >
                          <h6 class="d-flex justify-content-between align-items-center">UTR Number</h6>
                          <input type="text" class="form-control mandatory utrnft" name="neft_transaction_no" id="neft_transaction_no" validate="Please enter transaction Id" placeholder="Enter Transaction Id">
                        </li>
                         <?php } ?>
                        <!-- <li>
                          <span id="neft_file_name" style="display:none;"></span>
                          <button type="button" id="neft_remove_btn" class="remove-file" style="display:none;">&times;</button>
                       <input style="display:none;" type="file" accept="image/*,application/pdf" name="neft_document" id="neft_document" class="mandatory" style="display:none" validate="Please upload a image">
                          <label for="neft_document" class="file-label">Upload Payment Receipt</label>
                        </li> -->
                        <li>
                          <span id="neft_file_name" style="display:none;" class="upload_name" style="">download (1).png</span>
                          <button type="button" style="display:none;"  id="neft_remove_btn" class="remove-file upload_delet" style=""><i class="fal fa-trash-alt"></i></button>
                          <input style="display:none;" type="file" accept="image/*,application/pdf" name="neft_document" id="neft_document" class="mandatory" validate="Please upload a image" data-gtm-form-interact-field-id="9">
                          <label for="neft_document" class="file-label" style="display: block;">Upload Payment Receipt</label>
                      </li>

                      </ul>
                    </div>
                    <style>
                      #qrPopupOverlay {
                          display: none;
                          position: fixed;
                          top: 0; left: 0;
                          width: 100%;
                          height: 100%;
                          background: rgba(0,0,0,0.7);
                          justify-content: center;
                          align-items: center;
                          z-index: 9999;
                      }
                      #qrPopupOverlay img {
                          max-width: 40%;
                          max-height: 40%;
                          border: 2px solid #fff;
                          box-shadow: 0 0 10px #fff;
                      }
                      #qrPopupOverlay .closePopup {
                          position: absolute;
                          top: 20px;
                          right: 30px;
                          font-size: 30px;
                          color: #fff;
                          cursor: pointer;
                      }
                      </style>
                    <div id="qrPopupOverlay">
                      <span class="closePopup">&times;</span>
                      <img src="" alt="QR Code">
                  </div>
                    <div class="review_right_box" id="DD">
                      <ul>
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">Drawee Bank</h6>
                          <input type="text" class="form-control mandatory" name="cheque_drawn_bank" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                        </li>
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">Date</h6>
                          <input type="date" class="form-control mandatory" name="cheque_date" id="cheque_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                        </li>
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">DD No.</h6>
                          <input type="number" class="form-control mandatory" name="cheque_number" id="cheque_number" validate="Please enter cheque/DD number" placeholder="Enter DD No." type="number" maxlength="6" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;">
                        </li>
                      </ul>
                    </div>
                    <div class="review_right_box" id="cash">
                      <ul>
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">Date</h6>
                          <input type="date" class="form-control mandatory" name="cash_deposit_date" id="cash_deposit_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select date" placeholder="Date">
                        </li>
                        <!-- <li>
                              <span id="cash_file_name" style="display:none;"></span>
                              <button type="button" id="cash_remove_btn" class="remove-file" style="display:none;">&times;</button>
                          <input type="file" accept="image/*,application/pdf" name="cash_document" class="mandatory" id="cash_document" style="display:none" validate="Please upload a image">
                          <label for="cash_document">Upload Payment Receipt</label>

                        </li> -->
                         <li>
                          <span id="cash_file_name" style="display:none;" class="upload_name" style="">download (1).png</span>
                          <button type="button" style="display:none;"  id="cash_remove_btn" class="remove-file upload_delet" style=""><i class="fal fa-trash-alt"></i></button>
                          <input style="display:none;" type="file" accept="image/*,application/pdf" name="cash_document" id="cash_document" class="mandatory" validate="Please upload a image" data-gtm-form-interact-field-id="9">
                          <label for="cash_document" class="file-label" style="display: block;">Upload Payment Receipt</label>
                      </li>
                      </ul>
                    </div>
                    <div class="review_right_box" id="Cards">
                      <ul>
                        <li>
                            <ol>
                                <li><?=$rowInfo['card_info']?></li>
                            </ol>
                        </li>
                        <li>
                         
                          <!-- <h6 class="d-flex justify-content-between align-items-center">Accepted Cards</h6> -->
                          <p>
                            <img src="<?= $onlinePaymentLogo ?>" style="width: 100%;    object-fit: contain;height: auto;background: transparent;filter: brightness(16.5); margin_bottom:0; padding-bottom:0;">
                            <!-- <img src=""> -->
                          </p>
                        </li>
                        <!-- <li>
                          <h6 class="d-flex justify-content-between align-items-center">Transfer via Net Banking or NEFT/IMPS.</h6>
                          <div>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Bank<span class="text-white"><?= $cfg['INVOICE_BANKNAME'] ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Account<span class="text-white"><?= $cfg['INVOICE_BANKACNO'] ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Benefeciary Name<span class="text-white"><?= $cfg['INVOICE_BENEFECIARY'] ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center mb-0">IFSC<span class="text-white"><?= $cfg['INVOICE_BANKIFSC'] ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center mb-0">Branch<span class="text-white"><?= $cfg['INVOICE_BANKBRANCH'] ?></span></p>
                          </div>

                        </li> -->
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="registration_right_bottom">
              <button type="button" name="previous" class="previous action-button-previous"><i class="fal fa-angle-left"></i>Previous</button>
              <button type="submit" name="submit" class="submit action-button">Confirm<?php check(); ?></button>
            </div>
          </fieldset>
          <!-- review -->
        </div>
      </div>
    </div>
    <?php include_once('cart.php'); ?>

  </form>
</body>
<?php include_once("includes/js-source.php"); ?>
<script>
  function initializeworkShopPlugins() {
    $('#wrkshp_tab_btn').click(function() {
      var selectedHotelId = $(this).data('tab'); // get $val['id']
      // Call your function / AJAX
      //  fetchHotelData(selectedHotelId);
    });

    // Trigger first tab on page load
    var firstTab = $('#wrkshp_tab_btn').first();
    firstTab.click(); // This triggers the handler
    const workshopCheckboxes = document.querySelectorAll('input[reg="workshop"]');

    workshopCheckboxes.forEach(chk => {
      chk.addEventListener('change', function() {
        const selectedDate = this.dataset.date;
        const selectedType = this.dataset.type;

        if (this.checked) {
          // Disable other checkboxes of the same type on the same date
          workshopCheckboxes.forEach(otherChk => {
            if (otherChk !== this &&
              otherChk.dataset.date === selectedDate &&
              otherChk.dataset.type === selectedType) {
              otherChk.disabled = true;
            }
          });
        } else {
          // Re-enable checkboxes when this one is unchecked
          workshopCheckboxes.forEach(otherChk => {
            if (otherChk.dataset.date === selectedDate &&
              otherChk.dataset.type === selectedType) {
              otherChk.disabled = false;
            }
          });
        }
      });
    });
    $("input[type=checkbox][operationMode=workshopId]").each(function() {
      $(this).click(function() {

        var currChkbxStatus = $(this).attr("chkStatus");

        if (currChkbxStatus == "true") {
          $(this).prop("checked", false);
          $(this).attr("chkStatus", "false");
        } else {
          $(this).prop("checked", true);
          $(this).attr("chkStatus", "true");
        }

        calculateTotalAmount();
        // Count all checked checkboxes
        var selectedCount = $("input[type=checkbox][operationMode=workshopId]:checked").length;

        // Set the value in your input field (replace #selectedCountInput with your input's ID)
        $("a.selected-count").text(selectedCount + " Selected");


      });

    });
  }
  document.addEventListener("DOMContentLoaded", initializeworkShopPlugins);

  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.checkboxClassDinner').forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        calculateTotalAmount();
      });
    });
  });
  $(document).ready(function() {

    $('#subTotalPrc').text((0.00).toFixed(2));

    // Trigger click on the first hotel tab button

  });
  // Object to store selected dates per hotel
  var hotelDates = {};

  $(document).ready(function() {
    $('.hotel_tab_btn').click(function() {
      var hotelId = $(this).data('tab');
      var hotelName = $(this).text(); 

      // Save current hotel's dates before switching
      var currentHotelId = $('#hotel_id').val();
      if (currentHotelId) {
        hotelDates[currentHotelId] = {
          checkin: $('#accomodation_package_checkin_id_' + currentHotelId).val(),
          checkout: $('#accomodation_package_checkout_id_' + currentHotelId).val()
        };
      }

      // Load new hotel's content
      $.ajax({
        url: 'registration.php',
        type: 'POST',
        data: { hotelIdDate: hotelId },
        success: function(response) {
          $('#accoOp').html($(response).find('#accoOp').html());
          initializeAccoPlugins();

          // Update hidden hotel id
          $('#hotel_id').val(hotelId);

          // Restore previously selected dates if available
          if (hotelDates[hotelId]) {
            $('#accomodation_package_checkin_id_' + hotelId).val(hotelDates[hotelId].checkin);
            $('#accomodation_package_checkout_id_' + hotelId).val(hotelDates[hotelId].checkout);
          } else {
            $('#accomodation_package_checkin_id_' + hotelId).val('');
            $('#accomodation_package_checkout_id_' + hotelId).val('');
          }
          
        }
      });
    });

    // Trigger first tab on page load
    $('.hotel_tab_btn').first().click();
  });
  function syncHotelDates(hotelId) {
      var checkin = $('#accomodation_package_checkin_id_' + hotelId).val() || '';
      var checkout = $('#accomodation_package_checkout_id_' + hotelId).val() || '';

      var html = `
        <input type="hidden" name="hotel_dates[${hotelId}][checkin]" value="${checkin}">
        <input type="hidden" name="hotel_dates[${hotelId}][checkout]" value="${checkout}">
      `;

      $('#hotelDateStore')
        .find('[data-hotel="' + hotelId + '"]').remove();

      $('#hotelDateStore').append(
        `<div data-hotel="${hotelId}">${html}</div>`
      );
    }
  function initializeAccoPlugins() {
    $(document).on('change', "input[type=checkbox][name='package_id[]']", function() {
      var el = $(this);
      var hotelId = el.data('hotel-id'); // get hotel id for this checkbox

      var checkInVal = $('#accomodation_package_checkin_id_' + hotelId).val();
      var checkOutVal = $('#accomodation_package_checkout_id_' + hotelId).val();

      if (!checkInVal || !checkOutVal) {
        if (!$(".toast:contains('Please select check-in and check-out dates')").length) {
          toastr.error('Please select check-in and check-out dates', 'Error', { progressBar: true, timeOut: 3000 });
        }
        el.prop('checked', false);
        return;
      }

      var pkgName = el.closest('label').find('n').text().trim().toLowerCase(); // get package name
      var checkedAll = $("input[type=checkbox][name='package_id[]']:checked");

      if (pkgName === 'individual') {
        var checkedIndividual = checkedAll.filter(function() {
          return $(this).closest('label').find('n').text().trim().toLowerCase() === 'individual';
        });

        if (checkedIndividual.length > 3) {
          toastr.error('Maximum 3 Individual packages allowed across all hotels', 'Limit reached');
          el.prop('checked', false);
          return;
        }
      } else {
        $("input[type=checkbox][name='package_id[]']").not(el).prop('checked', false);
      }

      console.log('Selected package:', {
        hotel_id: el.attr("hotel_id"),
        hotel_select_acco_id: el.attr("hotel_select_acco_id"),
        accommodation_room: el.attr("accommodation_room")
      });
      var subtotal = $(this).attr('amount');
      $("#hotel_id").val(el.attr("hotel_id"));
      $("#hotel_select_acco_id").val(el.attr("hotel_select_acco_id"));
      $("#accommodation_room").val(el.attr("accommodation_room"));

      calculateTotalAmount();
    });
    $(document).on('click', '.qty-count', function () {
      var btn = $(this);
      var input = btn.siblings('.accmomdation-qty');

      var currentVal = parseInt(input.val()) || 1;
      var min = parseInt(input.attr('min')) || 1;
      var max = parseInt(input.attr('max')) || 10;

      // if (btn.data('action') === 'add' && currentVal < max) {
      //   input.val(currentVal + 1);
      // }

      // if (btn.data('action') === 'minus' && currentVal > min) {
      //   input.val(currentVal - 1);
      // }

      // 🔥 Trigger recalculation using existing checkout logic
      var hotelId = $('#hotel_id').val();
      var checkoutVal = $('#accomodation_package_checkout_id_' + hotelId).val();

      if (checkoutVal) {
        get_checkout_val(checkoutVal, hotelId);
      }
    });
    // Clear button handler
    $(document).on('click', '.registration_right_body_head_right .text_danger', function(e) {
      e.preventDefault();

      var hotelId = $(this).closest('.registration_right_body_head_right').find('select[id^="accomodation_package_checkin_id_"]').data('hotel-id');

      $("input[type=checkbox][name='package_id[]'][data-hotel-id='" + hotelId + "']").prop('checked', false);

      $("input[name='package_id[]'][data-hotel-id='" + hotelId + "']").each(function() {
        var baseAmount = parseFloat($(this).data('base-amount')) || 0;
        $(this).attr('amount', baseAmount);
        $(this).closest('label').find('.package-price').text('₹ ' + baseAmount.toFixed(2));
      });

      $('#accommodation_room').val(1);
      $('#accomodation_package_checkin_id_' + hotelId).val('');
      $('#accomodation_package_checkout_id_' + hotelId).val('');

      calculateTotalAmount();
    });
    window.get_checkin_val = function(val, hotelId) {
      if (!val) return;
      $('#accomodation_package_checkout_id_' + hotelId).val('');
        syncHotelDates(hotelId);
    };

    window.get_checkout_val = function(val, hotelId) {
      var checkInVal = $('#accomodation_package_checkin_id_' + hotelId).val();
      if (!checkInVal || !val) return;

      const checkInDate = checkInVal.split("/")[1];
      const checkOutDate = val.split("/")[1];

      var date1 = new Date(checkInDate);
      var date2 = new Date(checkOutDate);

      if (date1 >= date2) {
        toastr.error('Please select proper checkout date!', 'Error', { progressBar: true, timeOut: 4000 });
        $('#accomodation_package_checkout_id_' + hotelId).val('');
        return false;
      }

      var differenceDays = Math.ceil((date2 - date1) / (1000 * 60 * 60 * 24));
      // var roomQty = 1;
      
      $("input[name='package_id[]']").each(function() {

        var baseAmount = parseFloat($(this).data('base-amount')) || 0;

        var roomId = $(this).attr('accommodation_room');
        var roomQty = parseInt(
          $("input[name='accmomdation-qty[" + hotelId + "][" + roomId + "]']").val()
        ) || 1;

        var nightTotal = baseAmount * differenceDays * roomQty;

        $(this).attr('amount', nightTotal.toFixed(2));
        $(this).closest('label').find('.package-price')
          .text('₹ ' + nightTotal.toFixed(2));
      });
       syncHotelDates(hotelId);

       calculateTotalAmount();
    };
  }
  document.addEventListener("DOMContentLoaded", initializeAccoPlugins);

  $(document).ready(function() {
    var storageEmail = localStorage.getItem("user_email_id");
    // var storageMobile = localStorage.getItem("user_mobile");
    if (storageEmail != '' && storageEmail !== undefined) {
      $('#user_email_id').val(storageEmail);
      // checkUserEmail(document.querySelector('.pay-button'));

      // $('input[type=radio][operationmode=registration_tariff][value=3]')


    }
    //////////next,skip,previous start////
    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar")
        .css("width", percent + "%")
    }
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;
    console.log(steps);
    setProgressBar(current);

    /////////////for continue and previous button start////////////
    $(".next").click(function() {
      console.log('yesNext');
      var current_fs = $(this).closest("fieldset");
      var next_fs = current_fs.next("fieldset");

      var isValid = true;
      if (current_fs.hasClass("category")) {

        // check if any category is selected
        if (!current_fs.find("input[name='registration_classification_id[]']:checked").length) {

          toastr.error('Please select a category', 'Error', {
            progressBar: true,
            timeOut: 3000,
            showMethod: "slideDown",
            hideMethod: "slideUp"
          });

          isValid = false;
          // return false; // ⛔ stop Continue
        }
      }
      if (current_fs.hasClass("accomodationFindset")) {

        // check if any category is selected
        if (!current_fs.find("input[name='package_id[]']:checked").length) {

          toastr.error('Please select a room', 'Error', {
            progressBar: true,
            timeOut: 3000,
            showMethod: "slideDown",
            hideMethod: "slideUp"
          });

          isValid = false;
          // return false; // ⛔ stop Continue
        }
      }
      if (current_fs.hasClass("WorkshopFindset")) {

        // check if any category is selected
        if (!current_fs.find("input[operationMode=workshopId]:checked").length) {

          toastr.error('Please select a workshop', 'Error', {
            progressBar: true,
            timeOut: 3000,
            showMethod: "slideDown",
            hideMethod: "slideUp"
          });

          isValid = false;
          // return false; // ⛔ stop Continue
        }
      }
      if (current_fs.hasClass("dinnerFieldset")) {

        // check if any category is selected
        if (!current_fs.find("input[operationMode=dinner]:checked").length) {
          toastr.error('Please select at least one banquet', 'Error', {
            progressBar: true,
            timeOut: 3000,
            showMethod: "slideDown",
            hideMethod: "slideUp"
          });

          isValid = false;
          // return false; // ⛔ stop Continue
        }
      }
      if (current_fs.hasClass("accompanyfieldset")) {

        // check if any category is selected
        if (current_fs.find("#accompanyingTableBody li").length === 0) {
          toastr.error('Please select a accompany', 'Error', {
            progressBar: true,
            timeOut: 3000,
            showMethod: "slideDown",
            hideMethod: "slideUp"
          });

          isValid = false;
          // return false; // ⛔ stop Continue
        }
        // if (!current_fs.find("input[name='user_food_choice']:checked").length) {
        //   toastr.error('Please select a food preference', 'Error', {
        //     progressBar: true,
        //     timeOut: 3000,
        //     showMethod: "slideDown",
        //     hideMethod: "slideUp"
        //   });

        //   isValid = false;
        //   // return false; // ⛔ stop Continue
        // }

      }
      if (current_fs.hasClass("accompanyfieldset")) {
        // Loop through each guest row
        // console.log(("#accompanyingTableBody li").length);
        $("#accompanyingTableBody li").each(function() {
          $(".accompanyCount").prop("checked", true);

          calculateTotalAmount();

        });
         current_fs.find(".accompany_name").prop("required", true);

        // Recalculate the total
      }
      current_fs.find("input, select, textarea").each(function() {

        if ($(this).prop("required") && $(this).val().trim() === "") {

          var msg = $(this).attr("validate") || "This field is required";

          toastr.error(msg, "Error", {
            progressBar: true,
            timeOut: 3000,
            showMethod: "slideDown",
            hideMethod: "slideUp",
            direction: "ltr"
          });

          $(this).focus();
          isValid = false;
          return false; // ⛔ stop `.each()` loop
        }
      });

      if (!isValid) {
        return false; // ⛔ stop going to next step
      }

      // -----------------------------
      // MOVE TO NEXT FIELDSET
      // -----------------------------

      if (next_fs.length === 0) return;

      $("#progressbar li")
        .eq($("fieldset").index(next_fs))
        .addClass("active");

      next_fs.show();

      current_fs.animate({
        opacity: 0
      }, {
        step: function(now) {
          var opacity = 1 - now;
          current_fs.css({
            display: "none",
            position: "relative"
          });
          next_fs.css({
            opacity: opacity
          });
        },
        duration: 500
      });

      setProgressBar(++current);
    });


    $(".previous").click(function() {
      var current_fs = $(this).closest("fieldset");
      var previous_fs = current_fs.prev("fieldset");

      if (previous_fs.length === 0) return;

      // Remove class active from progress bar
      $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

      // Show previous fieldset
      previous_fs.show();

      // Hide current fieldset with animation
      current_fs.animate({
        opacity: 0
      }, {
        step: function(now) {
          var opacity = 1 - now;
          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          previous_fs.css({
            'opacity': opacity
          });
        },
        duration: 500
      });

      setProgressBar(--current);
      console.log(current);

    });
    $('.skip').click(function() {


      // $('input[type=radio][operationMode=workshopId]').prop('checked', false);
      // // Uncheck all radio buttons
      // // $('input[type="radio"]').prop('checked', false);

      // $('input[type=checkbox][name=accompanyCount]').prop('checked', false);
      // // Uncheck all radio buttons
      // // $('input[type="radio"]').prop('checked', false);
      // $('input[type=checkbox][operationMode=dinner]').prop('checked', false);

      // Current fieldset
      var current_fs = $(this).closest("fieldset");
      var next_fs = current_fs.next("fieldset"); // next fieldset
      if (current_fs.hasClass("accomodationFindset")) {
        $("input[type=checkbox][name='package_id[]']").prop('checked', false);

        calculateTotalAmount();
      }
      if (current_fs.hasClass("WorkshopFindset")) {
        // $('input[type=radio][operationMode=workshopId]').prop('checked', false);
        $("input[operationMode=workshopId]").prop('checked', false);

        calculateTotalAmount();
      }
      if (current_fs.hasClass("dinnerFieldset")) {

        $('.checkboxClassDinner').prop('checked', false).trigger('change');
        calculateTotalAmount();

      }

      if (current_fs.hasClass("accompanyfieldset")) {

        // 1️⃣ Uncheck the main accompany checkbox
        $("#accompanyCount").prop("checked", false);
        $("#accompanyCounts").prop("checked", false);

        // 2️⃣ Loop through each guest row
        $("#accompanyingTableBody li").each(function(index) {
          var $row = $(this);

          if (index === 0) {
            // First row: reset its values
            $row.find(".accompany_name").val("");
            // $row.find(".accompanyAmountDisplay").text("0.00");
          } else {
            // Remove all other rows
            $row.remove();
          }
        });
         current_fs.find(".accompany_name").prop("required", false);

        // 3️⃣ Reset accompanying count to 1 (only first row remains)
        $("#accompanyCounts").val(1);

        // 4️⃣ Recalculate total
        calculateTotalAmount();
      }
      if (next_fs.length === 0) return; // stop if no next

      // Add class active to progress bar
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      // Show next fieldset
      next_fs.show();

      // Hide current fieldset with animation
      current_fs.animate({
        opacity: 0
      }, {
        step: function(now) {
          var opacity = 1 - now; // fade out current
          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          next_fs.css({
            'opacity': opacity
          });
        },
        duration: 500
      });

      // Update progress bar function
      setProgressBar(++current);
      console.log(current);
    });
    //////////next,skip,previous end////

    $(document).ready(function() {
      const $mobile = $("#user_mobile");

      // Trigger the existing Go button logic automatically when user leaves the field
      $mobile.on('blur', function() {
        $("#goBtn").trigger('click'); // calls checkUserEmail(this)
      });

      // Optional: Trigger after typing stops for 500ms (debounce)
      let typingTimer;
      $mobile.on('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
          $("#goBtn").trigger('click');
        }, 500);
      });
    });
    $("#user_mobile").on('blur', function() {
      checkUserEmail(this); // `this` is the mobile input instead of the button
    });

    function checkUserEmail(obj) {

      var liParent = $(obj).parent().closest("div[use=registrationUserDetails]");
      // var emailIdObj = $(liParent).find("#user_email_id");
      // var emailId = $.trim($(emailIdObj).val());
      var emailId = $.trim($("#user_email_id").val());
      // alert(emailId);

      //var emailId = $.trim($(obj).val());
      // alert(emailId);

      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailRegex.test(emailId)) {} else {
        toastr.error("Please enter valid email address", 'Error', {
          "progressBar": true,
          "timeOut": 3000,
          "showMethod": "slideDown",
          "hideMethod": "slideUp"
        });
        return false;
      }

      if (emailId != '') {
        var filter =
          /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(emailId)) {
          // $(obj).hide();

          console.log(jsBASE_URL + 'returnData.process.php?act=getEmailValidationStatus&email=' +
            emailId);
          setTimeout(function() {
            $.ajax({
              type: "POST",
              url: jsBASE_URL + 'returnData.process.php',
              data: 'act=getEmailValidationStatus&email=' + emailId,
              dataType: 'json',
              async: false,
              success: function(JSONObject) {
                console.log(JSONObject);

                if (JSONObject.STATUS == 'IN_USE') {
                  $('#abstractDelegateId').val(JSONObject.ID);

                  toastr.success('You have already registered with this email Id, login now please', 'Success', {
                    "progressBar": true,
                    "timeOut": 3000,
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                  });
                  setTimeout(function() {

                    window.location.href = jsBASE_URL;

                  }, 3000);

                } else if (JSONObject.STATUS == 'NOT_PAID') {

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
                } else if (JSONObject.STATUS == 'PAY_NOT_SET_OFFLINE') {
                  var payNotSetModalOffline = $('#payNotSetModalOffline');
                  $(payNotSetModalOffline).modal('show');
                  $(payNotSetModalOffline).modal('show');

                  $(obj).show();
                } else if (JSONObject.STATUS == 'AVAILABLE') {
                  emailflag = 1;
                  //Mobile validation 
                  var mobile = $("#user_mobile").val();
                  if (mobile == '') {
                    toastr.error("Please enter your mobile number.", 'Error', {
                      "progressBar": true,
                      "timeOut": 2000,
                      "showMethod": "slideDown",
                      "hideMethod": "slideUp"
                    });
                    return false;
                  }
                  if (mobile != '') {
                    if (mobile.length < 10) {
                      toastr.error("Please enter a valid mobile number.", 'Error', {
                        "progressBar": true,
                        "timeOut": 2000,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp"
                      })
                      $('#user_details').addClass('disabled-click'); //
                    } else {
                      $.ajax({
                        type: "POST",
                        url: jsBASE_URL + 'returnData.process.php',
                        data: 'act=getMobileValidation&mobile=' + mobile,
                        dataType: 'text',
                        async: false,
                        success: function(returnMessage) {

                          returnMessage = returnMessage.trim();
                          if (returnMessage == 'IN_USE') {
                            //popoverAlert(mobileObj, "Mobile no. is already in use.");

                            toastr.error("Mobile no. is already in use.", 'Error', {
                              "progressBar": true,
                              "timeOut": 3000,
                              "showMethod": "slideDown",
                              "hideMethod": "slideUp"
                            });
                            $('#user_mobile').val("");

                          } else {
                            // $('#user_details').show();
                            $('#user_details').removeClass('disabled-click');

                            // console.log('>>' + $(parent).find(
                            //   "div[use=mobileProcessing]").find(
                            //   "input[name=user_mobile_validated]").val());

                            // if(emailflag==1){

                            enableAllFileds(liParent);
                            $('#radioGender').removeClass('blur_bw');
                            $('#radioFood').removeClass('blur_bw');

                            $('#user_email_id').addClass('disabled-user-input');
                            $('#user_mobile').addClass('disabled-user-input');



                            var JSONObjectData = JSONObject.DATA;
                            if (JSONObjectData) {

                              $('#abstractDelegateId').val(JSONObjectData.ID);
                              $(liParent).find('#user_first_name').val(JSONObjectData
                                .FIRST_NAME);
                              $(liParent).find('#user_middle_name').val(JSONObjectData
                                .MIDDLE_NAME);
                              $(liParent).find('#user_last_name').val(JSONObjectData
                                .LAST_NAME);
                              $(liParent).find('#user_mobile').val(JSONObjectData
                                .MOBILE_NO);

                              if ($(liParent).find('#user_mobile').val() != '') {
                                checkMobileNo($(liParent).find('#user_mobile'));
                              }

                              $(liParent).find('#user_phone_no').val(JSONObjectData
                                .PHONE_NO);
                              $(liParent).find('#user_address').val(JSONObjectData
                                .ADDRESS);
                              $(liParent).find('#user_city').val(JSONObjectData.CITY);
                              $(liParent).find('#user_postal_code').val(JSONObjectData
                                .PIN_CODE);

                              $(liParent).find('#user_country').val(JSONObjectData
                                .COUNTRY_ID);
                              $(liParent).find('#user_country').trigger("change");

                              $(liParent).find('#user_state').val(JSONObjectData
                                .STATE_ID);
                            }

                            // }
                          }
                        }
                      });
                    }
                  }


                }
              }
            });
          }, 500);
        } else {
          var invalidEmail = $("#invalidEmail").val();
          toastr.error('Enter Valid Emailll Id', 'Error', {
            "progressBar": true,
            "timeOut": 5000, // 3 seconds
            "showMethod": "slideDown", // Animation method for showing
            "hideMethod": "slideUp" // Animation method for hiding
          });
        }
      } else {
        //popoverAlert(emailIdObj);
      }


    }
 $('.review_tab button.active').trigger('click');

    $('#neft_document').on('change', function() {
        var file = this.files[0];
        if (file) {
            $('#neft_file_name').text(file.name).show();  // show file name
            $('#neft_remove_btn').show();  // show file name
            $("label[for='neft_document']").hide();       // hide the upload label
        } else {
            $('#neft_file_name').hide();
            $('#neft_remove_btn').hide();  // show file name
            $("label[for='neft_document']").show();
        }
    });

    // Trash button to remove selected file
    $('#neft_remove_btn').on('click', function() {
        $('#neft_document').val('');                 // reset input
        $('#neft_file_name').hide();                 // hide filename
        $('#neft_remove_btn').hide();  // show file name
        $("label[for='neft_document']").show();      // show upload label
    });

   $('#cash_document').on('change', function() {
        var file = this.files[0];

        if (file) {
            $('#cash_file_name').text(file.name).show(); // show filename
           $('#cash_remove_btn').show();
            $("label[for='cash_document']").hide();       // hide upload label
        } else {
            $('#cash_file_name').hide();
            $('#cash_remove_btn').hide();
            $("label[for='cash_document']").show();
        }
    });

    $('#cash_remove_btn').on('click', function() {
        $('#cash_document').val('');                 // clear input
        $('#cash_file_name').hide();     
        $('#cash_remove_btn').hide();            // hide filename
        $("label[for='cash_document']").show();      // show label again
    });
    function validateMobile(mobile) {


    }
    ////////////////////////////end///////////////
    /////////////



    // $(".submit").click(function() {
    //   return false;
    // })
    $("form").on("keydown", function(e) {
        if (e.key === "Enter" && e.target.type !== "textarea") {
            e.preventDefault();
            return false;
        }
    });
    $("form").on("submit", function(e) {
      console.log(steps);
     var selectedOption = $("input[type=radio][name='payment_mode']:checked").val();
    var flag = 0;

    if (selectedOption) {
        // Only validate inputs inside the visible container
        $(".review_right_box:visible input.mandatory").each(function() {
            var type = $(this).attr('type');
              console.log(type);
            if (type === 'radio') {
                if (!$("input[type='radio'][name='card_mode']:checked").length) {
                    toastr.error('Please select the card', 'Error', {
                        "progressBar": true,
                        "timeOut": 5000,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp"
                    });
                    flag = 1;
                    return false;
                }
            } else {
                if ($(this).val() === '') {
                    toastr.error($(this).attr('validate'), 'Error', {
                        "progressBar": true,
                        "timeOut": 5000,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp"
                    });
                    flag = 1;
                    return false;
                }
            }
        });
    } else {
        toastr.error('Please select payment mode', 'Error', {
            "progressBar": true,
            "timeOut": 5000,
            "showMethod": "slideDown",
            "hideMethod": "slideUp"
        });
        flag = 1;
        return false;
    }

    if (flag === 0) {
        // $("form[name='registrationForm']").submit();
    } else {
        return false;
    }
      // if (current !== steps) {
      //   e.preventDefault();
      //   toastr.error("Please complete all steps before submitting.", "Error", {
      //     progressBar: true,
      //     timeOut: 3000
      //   });
      //   return false;
      // }
      // 🔒 allow submit ONLY from <button type="submit" name="submit">
      const submitter = e.originalEvent.submitter;

      if (!submitter || submitter.type !== "submit" || submitter.name !== "submit" || flag>0) {
        e.preventDefault();
        return false;
      }

      // ✅ FINAL VALIDATION HERE
      // If valid → allow submit
    });
    //////////////for category chooose////
    $("input[type=radio][operationMode=registration_tariff]").each(function() {
      $(this).click(function() {

        $("#bill_details").show();

        var currChkbxStatus = $(this).attr("chkStatus");

        $("input[type=checkbox][operationMode=registration_tariff]").prop(
          "checked", false);
        $("input[type=checkbox][operationMode=registration_tariff]").attr(
          "chkStatus", false);

        $("div[operetionMode=workshopTariffTr]").hide();

        $("input[type=checkbox][operationMode=workshopId]").prop("checked",
          false);
        $("input[type=checkbox][operationMode=workshopId_postconference]").prop(
          "checked", false);
        // november22 workshop related work by weavers start  
        $("input[type=checkbox][operationMode=workshopId_nov]").prop("checked",
          false);
        // november22 workshop related work by weavers end
        $("div[operetionMode=checkInCheckOutTr]").hide();
        $("div[use=ResidentialAccommodationAccompanyOption]").hide();



        if (currChkbxStatus == "true") {
          $(this).prop("checked", false);
          $(this).attr("chkStatus", false);

          $("div[operationMode=chhoseServiceOptions][use=residentialOperations]")
            .hide();
          $("div[operationMode=chhoseServiceOptions][use=defaultChoices]")
            .slideDown();
          // window.location.reload();
        } else {
          $(this).prop("checked", true);
          $(this).attr("chkStatus", true);

          var regType = $(this).attr('operationModeType');
          var regClsfId = $(this).val();
          var currency = $(this).attr('currency');
          var offer = $(this).attr('offer');



          if (regType == 'residential') {
            var accommodationType = $(this).attr("accommodationType");
            var packageId = $(this).attr("accommodationPackageId");
            var hotel_id = $(this).attr("hotel_id");
            var accomDetails = $(this).attr("invoiceTitle");
            $("div[operationMode=chhoseServiceOptions][use=defaultChoices]")
              .hide();
            $("div[operationMode=chhoseServiceOptions][use=residentialOperations]")
              .slideDown();

            $("input[type=hidden][name=accomPackId]").attr("value",
              packageId);
            $("input[type=hidden][name=hotel_id]").attr("value", hotel_id);
            $("input[type=hidden][name=accomDetails]").attr("value",
              accomDetails);


            $("div[operetionMode=checkInCheckOutTr][use='" + packageId +
              "']").slideDown();

            if (accommodationType == 'SHARED') {
              $("div[use=ResidentialAccommodationAccompanyOption]")
                .slideDown();
            }

            $("div[operetionMode=workshopTariffTr][use=" + regClsfId + "]")
              .show();
          } else if (regType == 'conference') {
            $("div[operationMode=chhoseServiceOptions][use=defaultChoices]")
              .hide();
            $("div[operationMode=chhoseServiceOptions][use=residentialOperations]")
              .hide();

            $("div[operetionMode=workshopTariffTr][use=" + regClsfId + "]")
              .show();



            // disable "IAP - NNF NRP FGM" ,"NNF Accredited- Advance NRP" workshop type if registration is selected rather then "Member"


            $("div[operetionMode=workshopTariffTr][use=" + regClsfId + "]")
              .find('input[type="radio"]').each(function() {
                var workshopIDVal = $(this).val();
                // alert(workshopIDVal);
                //$(this).attr("disabled","");
                $(this).removeAttr('disabled');
                //var workshop_type_id = $(this).val();

                var workshop_amount = $(this).attr('amount');
                var workshopCount = $(this).attr('workshopCount');

                $('.workCombo[operetionDisplay=workshopDisplay' + workshopIDVal + ']').find('.itemPrice').text("INR " + workshop_amount);
                //console.log(workshop_type_id)
                //if(workshop_type_id == 11 && regClsfId != 1){
                if (workshop_amount == 0 && regClsfId != 1) {
                  /*$(this).attr("disabled", "disabled");
                  $(this).parent().css({
                      "cursor": "not-allowed"
                  })*/
                  //}else if(workshop_type_id == 21 && regClsfId != 1){
                } else if (workshop_amount == 0 && regClsfId != 1) {
                  /*$(this).attr("disabled", "disabled");
                  $(this).parent().css({
                      "cursor": "not-allowed"
                  })*/
                } else if (workshopCount < 1) {
                  $(this).attr("disabled", "disabled");
                  $(this).parent().css({
                    "cursor": "not-allowed"
                  })
                }

              });



          } else {
            $("div[operationMode=chhoseServiceOptions][use=residentialOperations]")
              .hide();
            $("div[operationMode=chhoseServiceOptions][use=defaultChoices]")
              .slideDown();
          }


        }

        calculateTotalAmount();
      });

    });
    ////////////////////end////////////////////

  });

  $(document).ready(function() {

    // function calculateTotalAmount() {
    //     var total = 0;
    //     alert(total);
    //     $(".accompanyAmountDisplay").each(function() {
    //         total += parseFloat($(this).text());
    //     });
    //     // Example if needed:
    //     // $('#subTotalPrc').text(total.toFixed(2));
    // }
    function addGuest() {

      var $body = $("#accompanyingTableBody");

      // ALWAYS read from the ORIGINAL hidden input (first one)
      var registrationAmount = parseFloat(
        $("input[name='accompanyAmount']:first").val()
      ) || 0;
       var currencyCode = $("input[name='accompanyAmountSet']:first").data("currency") || '';

      var index = $body.find("li").length;

      var $row = $body.find("li:first").clone(false);

      // ❌ remove duplicate ID (CRITICAL)
      $row.find("#accompanyAmount").removeAttr("id");

      // reset name input
      $row.find("input.accompany_name")
        .val("")
        .attr({
          name: "accompany_name_add[" + index + "]",
          countindex: index
        });

      // reset radios
      $row.find("input[type='radio']")
        .prop("checked", false)
        .each(function() {
          var baseId = $(this).attr("id").split("_")[0];
          $(this).attr({
            id: baseId + "_" + index,
            name: "accompany_food_choice[" + index + "]"
          });
        });

      // reset hidden selected flag
      
      $row.find("input[name^='accompany_selected_add']")
        .val(index)
        .attr("name", "accompany_selected_add[" + index + "]");

      // restore amount display (FIXES 00 issue)
     var formattedAmount = new Intl.NumberFormat('en-IN', {
        maximumFractionDigits: 0
    }).format(registrationAmount);

     // Set display
     $row.find(".accompanyAmountDisplay").text(currencyCode + ' ' + formattedAmount);
      $row.find(".removeGuest").show();

      $body.append($row);

      $("#accompanyCounts").val(index + 1);
      $("#accompanyCount").prop("checked", true);

      // calculateTotalAmount();
    }
    // $("#accompanyCount").prop("checked", true);
    $("#add-accompany-btn").on("click", function(e) {
      e.preventDefault();
      addGuest();
    });

    $(document).on("click", ".removeGuest", function(e) {
      e.preventDefault();

      var $body = $("#accompanyingTableBody");

      if ($body.find("li").length === 1) return;

      $(this).closest("li").remove();

      $body.find("li").each(function(i) {

        $(this).find("#accompanyAmount").removeAttr("id");
       var currencyCode = $("input[name='accompanyAmountSet']:first").data("currency") || '';

        $(this).find("input.accompany_name").attr({
          name: "accompany_name_add[" + i + "]",
          countindex: i
        });

        $(this).find("input[name^='accompany_selected_add']")
          .attr("name", "accompany_selected_add[" + i + "]");

        $(this).find("input[type='radio']").each(function() {
          var baseId = $(this).attr("id").split("_")[0];
          $(this).attr({
            id: baseId + "_" + i,
            name: "accompany_food_choice[" + i + "]"
          });
        });

        // restore amount text
        var amt = parseFloat(
          $("input[name='accompanyAmount']:first").val()
        ) || 0;
        var formattedAmount = new Intl.NumberFormat('en-IN', {
            maximumFractionDigits: 0
        }).format(registrationAmount);

          // Set display
          $(this).find(".accompanyAmountDisplay").text(currencyCode + ' ' + formattedAmount);

        });

      $("#accompanyCounts").val($body.find("li").length);

      // calculateTotalAmount();
    });


  });
    
  /////
    var QtyInput = (function() {
        var $qtyInputs = $(".accomdationroomqty-input");

        if (!$qtyInputs.length) {
            return;
        }

        var $inputs = $qtyInputs.find(".accmomdation-qty");
        var $countBtn = $qtyInputs.find(".qty-count");
        var qtyMin = parseInt($inputs.attr("min"));
        var qtyMax = parseInt($inputs.attr("max"));

        $inputs.change(function() {
            var $this = $(this);
            var $minusBtn = $this.siblings(".qty-count--minus");
            var $addBtn = $this.siblings(".qty-count--add");
            var qty = parseInt($this.val());

            if (isNaN(qty) || qty <= qtyMin) {
                $this.val(qtyMin);
                $minusBtn.attr("disabled", true);
            } else {
                $minusBtn.attr("disabled", false);

                if (qty >= qtyMax) {
                    $this.val(qtyMax);
                    $addBtn.attr('disabled', true);
                } else {
                    $this.val(qty);
                    $addBtn.attr('disabled', false);
                }
            }
        });

        $countBtn.click(function() {
            var operator = this.dataset.action;
            var $this = $(this);
            var $input = $this.siblings(".accmomdation-qty");
            var qty = parseInt($input.val());

            if (operator == "add") {
                qty += 1;
                if (qty >= qtyMin + 1) {
                    $this.siblings(".qty-count--minus").attr("disabled", false);
                }

                if (qty >= qtyMax) {
                    $this.attr("disabled", true);
                }
            } else {
                qty = qty <= qtyMin ? qtyMin : (qty -= 1);

                if (qty == qtyMin) {
                    $this.attr("disabled", true);
                }

                if (qty < qtyMax) {
                    $this.siblings(".qty-count--add").attr("disabled", false);
                }
            }

            $input.val(qty);
        });
    })();
</script>
<script>
$(document).ready(function() {
    // When a payment radio is clicked
    $("input[type=radio][use=payment_mode_select]").click(function() {
        var val = $(this).val(); // Get selected payment value
                calculateTotalAmount();

        // Set registrationMode based on ONLINE/OFFLINE
        if (val === 'Card') {
            $('#registrationMode').val('ONLINE');
        } else {
            $('#registrationMode').val('OFFLINE');
        }

        // Optional: Handle special case for UPI
        if ($(this).attr('act') === 'Upi') {
            $('.for-upi-only').show();
            $('.for-neft-rtgs-only').hide();
            $('#neft_transaction_no').removeClass('mandatory').val('');
            $('#txn_no').addClass('mandatory');

        } else {
            $('.for-upi-only').hide();
            $('.for-neft-rtgs-only').show();
            $('#neft_transaction_no').addClass('mandatory');
            $('#txn_no').removeClass('mandatory').val('');

        }

    });

    // Trigger click on page load if you want default selection
    var defaultChecked = $("input[type=radio][use=payment_mode_select]:checked");
    if(defaultChecked.length) {
        defaultChecked.trigger('click');
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show popup on QR image click
    document.querySelectorAll('.for-upi-only img').forEach(function(img) {
        img.addEventListener('click', function() {
            var popup = document.getElementById('qrPopupOverlay');
            popup.querySelector('img').src = this.src;
            popup.style.display = 'flex';
        });
    });

    // Close popup when clicking X
    document.querySelector('#qrPopupOverlay .closePopup').addEventListener('click', function() {
        this.parentElement.style.display = 'none';
    });

    // Close when clicking outside image
    document.getElementById('qrPopupOverlay').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
});
function toggleMemberField(element) {

    // Hide all member ID blocks first
    $('.regi_category_sublabel')
        .addClass('d-none')
        .find('input')
        .prop('disabled', true)
        .prop('required', false);   // ✅ remove required

    var title = $(element).attr('invoiceName');

    // Show only if it is Member (NOT Non Member)
    if (title && title.includes('Member') && !title.includes('Non Member')) {

        $(element).closest('.regi_category')
                  .find('.regi_category_sublabel')
                  .removeClass('d-none')
                  .find('input')
                  .prop('disabled', false)
                  .prop('required', true);   // ✅ add required back
    }
}
</script>
</html>