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
include_once('webmaster/includes/function.php');

if (strtolower($_SERVER['HTTP_HOST']) == 'localhost' || $_SESSION['SHOW'] == 'YES') {
    //
} else {

    //header("location: https://www.ruedakolkata.com/aiccrcog2019_ver0/profile.php");
}
$placeName = '';
if (isset($_SESSION['WEATHER_DATA'])) {
    $weatherApiData = $_SESSION['WEATHER_DATA'];
    $placeName = $weatherApiData['place_name'] == '' ? getPlaceName($weatherApiData['latitude'], $weatherApiData['longitude']) : $weatherApiData['place_name'];
} else {
    $weatherApiData = weatherApi();
}

// echo $cfg['CONF_START_DATE'] ; die;
// echo '<pre>'; print_r($weatherApiData); die;

foreach ($weatherApiData['days'] as $k => $val) {
    if ($val['datetime'] == date('Y-m-d', strtotime($cfg['CONF_START_DATE']))) {
        $loc = $weatherApiData['address'];
        $todayMaxTemp = $val['tempmax'];
        $todayMinTemp = $val['tempmin'];
        $todayconditions = $val['conditions'];
        $todayhumidity = $val['humidity'];
        $todayPrecipitation = $val['precipprob'];
        $todaywindspeed = $val['windspeed'];
        $todayDate = $val['datetime'];
        $totayTemp = $val['temp'];
        $todayTempIcon = $val['icon'];
    } else {
    }
}

$firstFiveValuesTemp = array_slice($weatherApiData['days'], 1, 7);

//echo '<pre>'; print_r($firstFiveValues); die;


if ($todayTempIcon == 'partly-cloudy-day') {
    $tempIcon = 'cloud-3.png';
} else if ($todayTempIcon == 'clear-day') {
    $tempIcon = 'cloud-1.png';
} else {
    $tempIcon = 'cloud-2.png';
}

//echo '<pre>'; print_r($weatherApiData['days']);

$title = 'Profile';
// echo $mycms->getSession('LOGGED.USER.ID');
$loginDetails      = login_session_control();

$delegateId      = $loginDetails['DELEGATE_ID'];
$rowUserDetails  = getUserDetails($delegateId);
$invoiceList      = getConferenceContents($delegateId);
// echo '<pre>'; print_r($invoiceList[$delegateId]); die;
$currentCutoffId = getTariffCutoffId();

$accompany_tariff   = getCutoffTariffAmnt($currentCutoffId);
// echo '<pre>'; print_r($accompany_tariff); die;
$registrationAmount   = getCutoffTariffAmnt($currentCutoffId);


$conferenceInvoiceDetails   = reset($invoiceList[$delegateId]['REGISTRATION']);

$workshopDetails   = $invoiceList[$delegateId]['WORKSHOP'];
$accompanyDtlsArr  = $invoiceList[$delegateId]['ACCOMPANY'];
$delgDinner    = getDinnerDetailsOfDelegate($delegateId);

$offline_payments = json_decode($cfg['PAYMENT.METHOD']);

$dinnerDtls  = array();
if ($delgDinner && !empty($delgDinner)) {
    $dinnerDtls[$delegateId]                = $delgDinner;
    $dinnerDtls[$delegateId]['INVOICE']     = getInvoiceDetails($delgDinner['refference_invoice_id']);
    $dinnerDtls[$delegateId]['USER']        = $rowUserDetails;
}

$dinnerDtlsAccm                 = array();
foreach ($accompanyDtlsArr as $key => $accompanyFullDtls) {
    $accomDtlsForDinnr                                  = $accompanyFullDtls['ROW_DETAIL'];
    $accompDinnrDet                                     = getDinnerDetailsOfDelegate($accomDtlsForDinnr['id']);

    if (!empty($accompDinnrDet)) {
        $dinnerDtlsAccm[$accomDtlsForDinnr['id']]               = $accompDinnrDet;
        $dinnerDtlsAccm[$accomDtlsForDinnr['id']]['INVOICE']    = getInvoiceDetails($accompDinnrDet['refference_invoice_id']);
        $dinnerDtlsAccm[$accomDtlsForDinnr['id']]['USER']       = $accomDtlsForDinnr;
    }
}


//echo '<pre>'; print_r($dinnerDtlsAccm); die;

$sqlFetchCountdown        = array();
$sqlFetchCountdown['QUERY']    = "SELECT * 
                                FROM " . _DB_LANDING_PAGE_SETTING_;
$resultFetchCountdown       = $mycms->sql_select($sqlFetchCountdown);

$dateArr          = explode("-", $resultFetchCountdown[0]['countdownDate']);



// abstract related work by weavers stat
$operate = false;

if ($cfg['ABSTRACT.SUBMIT.LASTDATE'] >= date('Y-m-d')) {
    $operate = true;
}

//==================================================== ABSTRACT DATA =================================================================
$sqlInfo  = array();
$sqlInfo['QUERY']    = "SELECT * FROM " . _DB_COMPANY_INFORMATION_ . " 
             WHERE `status` = ?";
$sqlInfo['PARAM'][] = array('FILD' => 'status',         'DATA' => 'A',                   'TYP' => 's');
$resultInfo      = $mycms->sql_select($sqlInfo);
$rowInfo         = $resultInfo[0];
$startD = $rowInfo['conf_start_date'];
$endD = $rowInfo['conf_end_date'];
$startDate = new DateTime($startD);
$endDate = new DateTime($endD);

$formatted = $startDate->format('M d Y \a\t g:i a');
$hod_consent_file_types = $rowInfo['hod_consent_file_types']; //JSON array
$abstract_file_types = $rowInfo['abstract_file_types'];
$hod_consent_file_types_decoded = json_decode($rowInfo['hod_consent_file_types']);

$unpaid_offline_temp = $rowInfo['notification_unpaid_offline'];
$unpaid_online_msg = $rowInfo['notification_unpaid_online'];

$find = ['[CONF NAME]', '[PHONE NUMBER]'];
$replacement = [$cfg['EMAIL_CONF_NAME'], $cfg['EMAIL_CONF_CONTACT_US']];
$unpaid_offline_msg = str_replace($find, $replacement, $unpaid_offline_temp);

$abstract_details = delegateAbstractDetailsSummeryWithoutTopic($delegateId);


$sqlAbstractTopic              =    array();
$sqlAbstractTopic['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_TOPIC_CATEGORY_ . " 
                              WHERE `status` IN ('A')
                           ORDER BY `category` ASC";


$resultAbstractTopic = $mycms->sql_select($sqlAbstractTopic);
$topicId = $value['abstract_topic_id'];

$sqlAbstractSubmission              =    array();
$sqlAbstractSubmission['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_SUBMISSION_ . " 
                              WHERE  `status` IN ('A')
                           ORDER BY `category` ASC";


$resultAbstractSubmission = $mycms->sql_select($sqlAbstractSubmission);

$sqlAbstractPresentation             =    array();
$sqlAbstractPresentation['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_PRESENTATION_ . " 
                              WHERE `status` ='A'
                           ORDER BY `id` ASC";


$resultAbstractPresentation = $mycms->sql_select($sqlAbstractPresentation);


// abstract related work by weavers end

$sqlHeader    =   array();
$sqlHeader['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
	                        WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]  =   array('FILD' => 'status' ,           'DATA' => 'A' ,                   'TYP' => 's');                    
$resultHeader = $mycms->sql_select($sqlHeader);
$rowHeader  = $resultHeader[0];

$header_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $rowHeader['header_image'];


$sqlFetchHotel      = array();
$sqlFetchHotel['QUERY'] = "SELECT * 
                                     FROM " . _DB_MASTER_HOTEL_ . "
                                    WHERE `status` =  ? ";

$sqlFetchHotel['PARAM'][] = array('FILD' => 'status',    'DATA' => 'A',     'TYP' => 's');
$resultFetchHotel        = $mycms->sql_select($sqlFetchHotel);


//echo count($resultFetchHotel);

$countAcc = ($resultFetchHotel) ? '1' : '0';

// setTemplateStyleSheet();
// setTemplateBasicJS();
// backButtonOffJS();




$sqlFlyer    =   array();
$sqlFlyer['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
                            WHERE status='A' AND title='Profile Flyer' ";

$resultFlyer      = $mycms->sql_select($sqlFlyer);

$sqlVenue    =   array();
$sqlVenue['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
                            WHERE status='A' AND `title`='Venue' ";

$resultVenue  = $mycms->sql_select($sqlVenue);

$sqlProfilePic    =   array();
$sqlProfilePic['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
                            WHERE status='A' AND `title`='Profile Picture' ";

$resultProfilePic  = $mycms->sql_select($sqlProfilePic);
$profile_pic_src = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultProfilePic[0]['image'];


$sqlSidePanelicon             =    array();
$sqlSidePanelicon['QUERY']  = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
								   WHERE `id`!='' AND `purpose`='Profile Side Panel Icon' ORDER BY `id`";
$resultSidePanelicon        = $mycms->sql_select($sqlSidePanelicon);
$workshop_icon = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultSidePanelicon[0]['icon'];
$accompanying_icon = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultSidePanelicon[1]['icon'];
$banquet_icon = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultSidePanelicon[2]['icon'];
$accomodation_icon = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultSidePanelicon[3]['icon'];
$abstract_icon = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $resultSidePanelicon[4]['icon'];
if ($rowUserDetails['isRegistration'] == 'N') {
    $disabled = "disabled='disabled' style='filter: blur(1px);'";
} else {
    $disabled = "";
}


$sql   =  array();
$sql['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
											WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]	=	array('FILD' => 'status' ,     		 'DATA' => 'A' ,       	           'TYP' => 's');					 
$result = $mycms->sql_select($sql);
$row         = $result[0];

$site_logo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['logo_image'];
$mailer_logo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['mailer_logo'];
$cutoffs             = fullCutoffArray();
$currentWorkshopCutoffId     = getWorkshopTariffCutoffId();
$dinnerTariffArray   = getAllDinnerTarrifDetails($currentCutoffId);
?>
<body>
    <!-- 
    <div class="profile_left_menu">
        <div class="logo_wrap">
            <img src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/LOGO_0001_250526185928.png" alt="">
        </div>
        <ul>
            <li><a href="#" class="active"><i class="fal fa-window-alt"></i>Registration Overview</a></li>
            <li><a href="#"><?php user(); ?>Profile Settings</a></li>
            <li><a href="#"><?php credit(); ?>Payment & Invoice</a></li>
            <li><a href="#"><i class="fal fa-question-circle"></i>Contact Support</a></li>
        </ul>
        <p><a href="#"><?php logout(); ?>Log Out</a></p>
        <div id="touch-taget"></div>
    </div> -->
    <img src="<?=$cfg['OUTER_BG_IMG']?>" alt="" class="body_bk">

    <? include_once("header.php");?>
    <header>
        <div class="header_left">
            <div class="logo_wrap">
                <img src="<?= $site_logo ?>" alt="">
               
            </div>
        </div>
        <div class="header_right">
            
            <button type="button"><?php bell(); ?></button>
            <a href="<?= _BASE_URL_ ?>login.process.php?action=logout"><?php logout(); ?>Log Out</a>
        </div>
    </header>
    <div class="profile_body">
        <div class="profile_right_menu">
            <div class="profile_top">
                <div class="profile_top_left">
                    <h6>Dashboard</h6>
                    <h2>Manage Your Booking</h2>
                </div>
                <div class="profile_top_right">
                     <?php
                        $sqlFile = array();
                        $sqlFile['QUERY'] = "SELECT registration_confirm_file FROM " . _DB_USER_REGISTRATION_ . " WHERE id = ?";
                        $sqlFile['PARAM'][] = array('FILD' => 'id', 'DATA' => $delegateId, 'TYP' => 'i');
                        $resultFile = $mycms->sql_select($sqlFile);
                        $filePath = __DIR__ . "/uploads/registration_confirmation/" . $resultFile[0]['registration_confirm_file'];
                           
                         if (!empty($resultFile[0]['registration_confirm_file']) && file_exists($filePath)) {
                         ?>
                         <a href="<?php echo _BASE_URL_; ?>download_confirmation.php?file=<?php echo urlencode($resultFile[0]['registration_confirm_file']); ?>">
                            <i class="fal fa-download"></i> Download Confirmation
                        </a>
                         <!-- <a href="download_confirmation.php"><i class="fal fa-download"></i>Download Confirmation</a> -->
                         <!-- <a href="<?php echo _BASE_URL_; ?>uploads/registration_confirmation/<?php echo $resultFile[0]['registration_confirm_file']; ?>" download><i class="fal fa-download"></i>Download Confirmation</a> -->
                         <? 
                         }
                    ?>                
                </div>
            </div>
            <div class="profile_grid">
                <!-- <div class="span_grid span_6">
                    <div class="profile_detail profile_detaile_box">
                        <div class="profile_detail_left">
                            <div class="profile_detail_img">
                                <img src="<?= $profile_pic_src ?>" alt="">
                                <input type="file" id="profileimg" style="display: none;">
                            </div>
                            <div class="profile_detail_content">
                                <h2><?= $rowUserDetails['user_full_name'] ?></h2>
                                <h5><span><?=$invoiceList[$delegateId]['REGISTRATION'][$delegateId]['USER']['REG_TYPE']?> |  <?= ($rowUserDetails['registration_payment_status']=='UNPAID' && $rowUserDetails['isRegistration']=='Y')?'<b style="color: #c70606e6">Processing</b>':( $rowUserDetails['isRegistration']!='Y'?'N/A':$rowUserDetails['user_registration_id']) ?></span> • <n><?= $rowUserDetails['user_email_id'] ?></n>
                                </h5>
                                <? if($rowUserDetails['registration_payment_status']=='UNPAID' && $rowUserDetails['isRegistration']=='Y'){
                               ?>
                               <h6><span class="badge_danger"><?php bill(); ?>Registration Pending</span><span class="badge_danger"><?php credit(); ?>Payment Unpaid</span></h6>
                                <?
                                }else{
                                ?>
                                    <h6><span class="badge_success"><?php bill(); ?>Registration Confirmed</span><span class="badge_success"><?php credit(); ?>Paid</span></h6>
                                <?
                                }
                                ?>
                                </div>
                        </div>
                       
                        <i class="fal fa-shield-check"></i>
                    </div>
                </div> -->
                 <div class="span_6">
                    <div class="profile_detail profile_detaile_box">
                        <div class="profile_detail_left">
                            <div class="profile_detail_img">
                                <img src="<?= $profile_pic_src ?>" alt="">
                                <input type="file" id="profileimg" style="display: none;">
                                <!-- <label for="profileimg"><?php edit(); ?></label> -->
                            </div>
                            <div class="profile_detail_content">
                                <h2><?= $rowUserDetails['user_full_name'] ?></h2>
                                <h5><span><?=$invoiceList[$delegateId]['REGISTRATION'][$delegateId]['USER']['REG_TYPE']?> |  <?= ($rowUserDetails['registration_payment_status']=='UNPAID' && $rowUserDetails['isRegistration']=='Y')?'<b style="color: #c70606e6">Processing</b>':( $rowUserDetails['isRegistration']!='Y'?'N/A':$rowUserDetails['user_registration_id']) ?></span>
                                </h5>
                                <? if($rowUserDetails['registration_payment_status']=='UNPAID' && $rowUserDetails['isRegistration']=='Y'){
                                ?>
                                <h6><span class="badge_danger"><?php bill(); ?>Registration Pending</span><span class="badge_danger"><?php credit(); ?>Payment Unpaid</span></h6>
                                    <?
                                    }else{
                                    ?>
                                        <h6><span class="badge_success"><?php bill(); ?>Registration Confirmed</span><span class="badge_success"><?php credit(); ?>Paid</span></h6>
                                    <?
                                    }
                                    ?>                                
                                <ul class="profile_detail_list profile_grid">
                                    <li class="span_grid span_3">
                                        <span><?php email() ?> Email Id</span>
                                        <p><?= $rowUserDetails['user_email_id'] ?></p>
                                    </li>
                                    <li class="span_grid span_3">
                                        <span><?php call() ?> Mobile Number</span>
                                        <p><?= $rowUserDetails['user_mobile_no'] ?></p>
                                    </li>
                                    <li class="span_grid span_6">
                                        <span><?php address() ?> Full Address</span>
                                        <p><?= $rowUserDetails['user_address'] ?></p>
                                    </li>
                                    <li class="span_grid span_3">
                                        <span># Unique Sequence</span>
                                        <p><?=strtoupper($rowUserDetails['user_unique_sequence'])?></p>
                                    </li>
                                </ul>
                                <!-- <div class="profile_detail_right">
                                    <a href="#"><?php printi(); ?>Print Badge</a>
                                </div> -->
                            </div>

                        </div>


                        <i class="fal fa-shield-check"></i>
                    </div>
                </div>
                <div class="span_grid span_4">
                    <div class="profile_grid">
                        <div class="span_6 accom_detail profile_detaile_box "  style="display: none;">
                            <div class="profile_detaile_box_head">
                                <h3><span><?php hotel(); ?></span>Your Accommodation</h3>
                                <!-- if hotel booked -->
                                <!-- <button type="button" class="popup_btn" data-tab="addstay"><?php edit(); ?>Change Hotel</button> -->
                                <!-- if hotel booked -->
                            </div>
                            <!-- if hotel booked -->
                            <div class="profile_detaile_box_body">
                                <ul class="profile_accm_list">
                                    <li>
                                        <div class="profile_accm_list_left">
                                            <div class="hotel_owl owl-carousel owl-theme">
                                                <div class="item">
                                                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" alt="">
                                                </div>
                                                <div class="item">
                                                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile_accm_list_right">
                                            <h5>ITC Royal Bengal</h5>
                                            <h6><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></h6>
                                            <p><?php address(); ?>JBS Haldane Avenue</p>
                                            <p><?php calendar(); ?>Date - Date</p>
                                            <p><?php hotel(); ?>1 Room</p>
                                            <h4><span class="badge_secondary">single Occupancy</span><span class="badge_success"><?php check(); ?>Booking Confirmed</span></h4>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- if hotel booked -->
                            <!-- else -->
                            <div class="hotel_blank">
                                <span><?php hotel(); ?></span>
                                <p>Stay at the heart of the action with our partner hotels.</p>
                                <button type="button" class="popup_btn" data-tab="addstay"><?php add(); ?>Book Hotel</button>
                            </div>
                            <!-- else -->
                        </div>
                        <?php
                        $workshopDetailsArray    = getAllWorkshopTariffs($currentCutoffId);
                        if (count($workshopDetailsArray) > 0) {
                        ?>
                        <div class="span_6 workshop_detail profile_detaile_box">
                            <div class="profile_detaile_box_head">
                                <h3><span><?php workshop(); ?></span>Workshops</h3>
                                <!-- if guest added -->
                                <!-- <button type="button" class="popup_btn" data-tab="addworkshop"><?php edit(); ?>Manage</button> -->
                                <!-- if guest added -->
                            </div>
                            <!-- if workshop added -->
                             <?php
                              if($workshopDetails) {
                                 ?>
                            <div class="profile_detaile_box_body">
                                <ul>
                                    
                                    <!-- <li class="abstract-list-content" style="padding-right: 0;">
                                        <h4 class="abs-modal-submission">Workshop</h4> -->

                                        <?php
                                       
                                            $wrksp_Cnt = 0;
                                            $existingWorkShops = array();
                                            foreach ($workshopDetails as $key => $rowWorkshopDetails) {

                                                if ($rowWorkshopDetails && $rowWorkshopDetails['INVOICE']['status'] == 'A') {

                                                    $existingWorkShops[] = $rowWorkshopDetails['ROW_DETAIL']['type'];
                                                    $workshopStatus = true;
                                                    $wrksp_Cnt++;

                                                    if ($rowWorkshopDetails['INVOICE']['service_roundoff_price'] > 0) {
                                                        $workshopAmountDisp = $rowWorkshopDetails['INVOICE']['currency'] . ' ' . $rowWorkshopDetails['INVOICE']['service_roundoff_price'];
                                                    } else {
                                                        $workshopAmountDisp = 'Included in package';
                                                    }


                                                    if (!empty($rowWorkshopDetails['ROW_DETAIL']['workshop_date'])) {
                                                        $workshop_date = '(' . $rowWorkshopDetails['ROW_DETAIL']['workshop_date'] . ')';
                                                    } else {
                                                        $workshop_date = '';
                                                    }

                                                    if (!empty($rowWorkshopDetails['ROW_DETAIL'])) {

                                                        if ($rowWorkshopDetails['INVOICE']['id']) { ?>
                                                            <li><span><?php clock(); ?></span>
                                                                <p><?= $rowWorkshopDetails['REG_DETAIL'] ?><n><?= $workshop_date ?></n>
                                                                </p>
                                                                <a href="#"><?php close(); ?></a>
                                                            </li>
                                                            <!-- <a href="pdf.download.invoice.php?user_id=<?= $delegateId ?>&invoice_id=<?= $rowWorkshopDetails['INVOICE']['id'] ?>" target="blank" class="btn" style="background:none">INVOICE</a> -->
                                                            <?php

                                                            if ($rowWorkshopDetails['INVOICE']['payment_status'] == 'UNPAID' && $rowWorkshopDetails['INVOICE']['invoice_mode'] == 'ONLINE') {
                                                            ?>


                                                                <!-- <a onclick="onlinePayNow('<?= $rowWorkshopDetails['INVOICE']['slip_id'] ?>', '<?= $delegateId ?>')" class="btn" style=" border-radius: 20px;  margin-right: 10px;  display: inline-block; padding: 5px 15px;">PAY NOW</a> -->

                                                    <?php

                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                       ?>
                                    <!-- </li> -->
                                   
                                    <button type="button" class="popup_btn" data-tab="addworkshop"><?php add(); ?>Add More Workshop</button>
                                </ul>
                            </div>
                            <?php
                            } 
                             else{

                                $workshopDetailsArray    = getAllWorkshopTariffs($currentCutoffId);
                                //echo count($workshopDetailsArray);
                                
                                if (count($workshopDetailsArray) > 0) {
                                    ?>
                                    <div class="hotel_blank">
                                        <span><?php workshop(); ?></span>
                                        <p>No workshops added yet.</p>
                                        <button type="button" class="popup_btn" data-tab="addworkshop"><?php add(); ?>Add Workshop</button>
                                    </div>
                                    <!-- <br><a href="<?= _BASE_URL_ . "profile-add.php?section=3" ?>" <?= $disabled ?> class="btn">Add Workshop</a> -->
                          
                            <?
                            }
                             }
                            ?>
                            <!-- if workshop added -->
                            <!-- else -->
                            
                            <!-- else -->
                        </div>
                        <?php } ?>

                       <?php 
                        if ($accompany_tariff) {
                        ?>
                        <div class="span_6 guest_detail profile_detaile_box d-none">
                            <div class="profile_detaile_box_head">
                                <h3><span><?php duser(); ?></span>Accompany Management</h3>
                                <!-- if guest added -->
                                <!-- <button type="button" class="popup_btn" data-tab="addguest"><?php edit(); ?>Manage</button> -->
                                <!-- if guest added -->
                            </div>
                            <!-- if guest added -->
                            <?   if (sizeof($accompanyDtlsArr) > 0) { ?>
                            <div class="profile_detaile_box_body">  
                                 <ul>
                                <?php
                                
                                    foreach ($accompanyDtlsArr as $key => $accompanyFullDtls) {

                                    $accompanyDtls        = $accompanyFullDtls['ROW_DETAIL'];

                                    $accompanySlipDtls    = $accompanyFullDtls['SLIP_DETAILS'];
                                    $accompanInvoiceDtls  = $accompanyFullDtls['INVOICE'];
                                    $accompanyPaymentDtls = $accompanyFullDtls['SLIP_PAYMENT'];
                                    $dataVal              = $accompanInvoiceDtls['currency'] . ' ' . $accompanInvoiceDtls['service_roundoff_price'];

                                    //echo 'ID='. $accompanyDtls['id'];

                                    $dinnerDetails  = $dinnerDtlsAccm[$accompanyDtls['id']];

                                    // echo '<pre>'; print_r($accompanInvoiceDtls);
                                ?>
                                <li><span><?php duser(); ?></span>
                                    <p>Accompany Name<n><?= strtoupper($accompanyDtls['user_full_name']) ?></n>
                                    </p>
                                    <!-- <a href="#"><?php delete(); ?></a> -->
                                </li>
                                 <? } 
                                ?>
                             </ul>
                                <div class="hotel_blank">

                                    <button type="button" class="popup_btn" data-tab="addguest"><?php add(); ?>Add More Guest</button>
                               </div>
                             
                               
                            
                            </div>
                             <? }else{ ?> 
                                <div class="hotel_blank">
                                    <span><?php duser(); ?></span>
                                    <p>Bringing family? Add them to your registration.</p>
                                    <button type="button" class="popup_btn" data-tab="addguest"><?php add(); ?>Add Guest</button>
                                </div>
                              <? }  ?>
                          
                        </div>
                      <?php } ?>
                       <?php
                        $dinnerTariffArray   = getAllDinnerTarrifDetails($currentCutoffId);
                        if ($dinnerTariffArray) {
                        ?>
                        <div class="span_6 guest_detail profile_detaile_box">
                            <div class="profile_detaile_box_head">
                                <h3><span><?php dinner(); ?></span>Gala Dinner</h3>
                                <!-- if guest added -->
                                <!-- <button type="button" class="popup_btn" data-tab="adddinner"><?php edit(); ?>Manage</button> -->
                                <!-- if guest added -->
                            </div>
                            <!-- if guest added -->
                            <?php
                            if (sizeof($dinnerDtls) > 0) {
                            ?>
                            <div class="profile_detaile_box_body">
                                <ul>
                                  <?php


                                  foreach ($dinnerDtls as $uId => $dinnerDetails) {
                                        $dinrCount++;
                                        if ($dinrCount % 2 == 1) {
                                            $dinrClass  = "gala_dinner_accompany";
                                            $dinrBG     = "#2393c3";
                                            $dinrInvBG  = "#27a5db";
                                        } else {
                                            $dinrClass  = "gala_dinner_workshop";
                                            $dinrBG     = "#27a5db";
                                            $dinrInvBG  = "#2393c3";
                                        }

                                        $dinrInvAmtDisp = 'Included in Package';
                                        $hasInvoice     = false;
                                        if ($dinnerDetails['INVOICE']['service_type'] == 'DELEGATE_DINNER_REQUEST') {
                                            $dinrInvAmtDisp = $dinnerDetails['INVOICE']['currency'] . ' ' . $dinnerDetails['INVOICE']['service_roundoff_price'];
                                            $hasInvoice     = true;
                                        }


                                    ?>
                                    <li><span><?php duser(); ?></span>
                                        <p>Dinner Name : <?= $dinnerDetails['dinner_classification_name'] ?><n><?= $dinnerDetails['dinnerDate'] ?></n>
                                        </p>
                                        <a href="#"><?php delete(); ?></a>
                                    </li>
                                   <? } ?>
                                    <button type="button" class="popup_btn" data-tab="adddinner"><?php add(); ?>Add More Dinner</button>
                                </ul>
                            </div>
                            <!-- if guest added -->
                             <? } else {
                                ?>
                              
                            <!-- else -->
                            <div class="hotel_blank">
                                <span><?php dinner(); ?></span>
                                <p>No Dinner added yet.</p>
                                <button type="button" class="popup_btn" data-tab="adddinner"><?php add(); ?>Add Dinner</button>
                            </div>
                              <?
                             }
                             ?>
                            <!-- else -->
                        </div>
                        <? } ?>
                    </div>
                </div>

                <div class="span_grid span_2">
                    <div class="profile_bottom">
                        <div class="profile_bottom_box">
                            <h4><?php address(); ?>Venue</h4>
                            <p><?=$rowInfo['company_conf_venue']?></p>
                            <a href="<?= $cfg['WEATHER_CITY'] ?>" target="_blank">Navigation Guide</a>
                        </div>
                        <div class="profile_bottom_box">
                            <h4><?php calendar(); ?>Schedule</h4>
                            <p>Conference starts on <?= $formatted?></p>
                            <!-- <a href="#">Download Itinerary</a> -->
                            <a href="#">Coming Soon</a>

                        </div>
                        <div class="profile_bottom_box">
                            <h4><?php pending(); ?>Inclusions</h4>
                             <?php
                                $sqlMailClassification     =    array();

                                $sqlMailClassification['QUERY']        = "SELECT RC.*, R.id, R.registration_classification_id
                                                        FROM " . _DB_REGISTRATION_CLASSIFICATION_ . " RC 
                                                        INNER JOIN " . _DB_USER_REGISTRATION_ . " R ON
                                                        RC.id = R.registration_classification_id
                                                    WHERE RC.status = ? 
                                                            AND R.status = ?	
                                                        AND  R.id = ? ";

                                $sqlMailClassification['PARAM'][]   = array('FILD' => 'RC.status',   'DATA' => 'A',                             'TYP' => 's');
                                $sqlMailClassification['PARAM'][]   = array('FILD' => 'R.status',   'DATA' => 'A',                             'TYP' => 's');
                                $sqlMailClassification['PARAM'][]   = array('FILD' => 'R.id',       'DATA' => $rowUserDetails['id'],   'TYP' => 's');
                                $resMailClassification    = $mycms->sql_select($sqlMailClassification);
                                $rowaMailClassification = $resMailClassification[0];
                                $selected_inclusion_lunch_date = json_decode($rowaMailClassification['inclusion_lunch_date']);
                                $selected_inclusion_dinner_date = json_decode($rowaMailClassification['inclusion_conference_kit_date']);
                                $lunch = "";
                                $i = 0;
                                foreach ($selected_inclusion_lunch_date as $key => $date) {
                                    if ($i == 0) {
                                        $lunch .= " " . date('d/m/Y', strtotime($date));
                                    } else {
                                        $lunch .= ", " . date('d/m/Y', strtotime($date));
                                    }
                                    $i++;
                                }
                                $dinner = "";
                                $i = 0;
                                foreach ($selected_inclusion_dinner_date as $key => $date) {
                                    if ($i == 0) {
                                        $dinner .= " " . date('d/m/Y', strtotime($date));
                                    } else {
                                        $dinner .= ", " . date('d/m/Y', strtotime($date));
                                    }
                                    $i++;
                                }
                                $sql     =    array();
                                $sql['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
                                                    WHERE `id`!='' AND `purpose`='Mailer' AND status IN ('A', 'I')";
                                $result      = $mycms->sql_select($sql);
                                // echo '<pre>'; print_r($result);
                                ?>
                            <ul>
                                <?php if ($rowaMailClassification['inclusion_sci_hall'] == 'Y') { ?>
                                    <li><img src="<?= _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['icon'] ?>" alt="" /><?= $result[0]['title'] ?></li>
                                <?php }
                                if ($rowaMailClassification['inclusion_exb_area'] == 'Y') { ?>
                                    <li><img src="<?= _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[1]['icon'] ?>" alt="" /><?= $result[1]['title'] ?></li>
                                <?php }
                                if ($rowaMailClassification['inclusion_tea_coffee'] == 'Y') { ?>
                                    <li><img src="<?= _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[3]['icon'] ?>" alt="" /><?= $result[3]['title'] ?></li>
                                <?php }
                                if ($rowaMailClassification['inclusion_conference_kit'] == 'Y') { ?>
                                    <li><img src="<?= _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[2]['icon'] ?>" alt="" /><?= $result[2]['title'] ?></li>
                                <?php }
                                if (!empty($selected_inclusion_lunch_date)) { ?>
                                    <li><img src="<?= _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[4]['icon'] ?>" alt="" /><?= 'Lunch on ' . $lunch  ?></li>
                                <?php }
                                if (!empty($selected_inclusion_dinner_date)) { ?>
                                    <li><img src="<?= _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[5]['icon'] ?>" alt="" /><?= 'Dinner on ' . $dinner  ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile_left_menu">
            <div class="help_detail profile_detaile_box">
                <div class="profile_detaile_box_head">
                    <h3><span><i class="fal fa-question-circle"></i></span>Payments & Invoice</h3>
                </div>

                <div class="profile_detaile_box_body">
                     <?php
                        $sqlFetchInvoice                = getRegistrationInvoiceCancelInvoiceDetails("",$rowUserDetails['id'], "");
                        // echo '<pre>'; print_r($rowUserDetails['id']);																
                        $resultFetchInvoice             = $mycms->sql_select($sqlFetchInvoice);
                        $totalAmountAll = 0;
                        $invoiceCounter                 = 0;
                        if ($resultFetchInvoice) {
                            //print_r($resultFetchInvoice);
                            foreach ($resultFetchInvoice as $key => $rowFetchInvoice) {
                                $showTheRecord 		= true;
                                $invoiceCounter++;

                                $slip = getInvoice($rowFetchInvoice['slip_id']);
                                //print_r($slip);
                                $returnArray    = discountAmount($rowFetchInvoice['id']);
                                $percentage     = $returnArray['PERCENTAGE'];

                                $totalAmount    = $returnArray['TOTAL_AMOUNT'];

                                $discountAmount = $returnArray['DISCOUNT'];
                                $thisUserDetails = getUserDetails($rowFetchInvoice['delegate_id']);
                                $type			 = "";
                                if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                    $type = "CONFERENCE REGISTRATION ";
                                }
                                if ($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION") {
                                    $workShopDetails = getWorkshopDetails($rowFetchInvoice['refference_id']);
                                    $type =  strtoupper(getWorkshopName($workShopDetails['workshop_id'])) . " REGISTRATION - " . $thisUserDetails['user_full_name'];
                                    if ($workShopDetails['showInInvoices'] != 'Y') {
                                        $showTheRecord 		= false;
                                    }
                                }
                                if ($rowFetchInvoice['service_type'] == "ACCOMPANY_CONFERENCE_REGISTRATION") {
                                    $thisUserAccompanyDetails = getUserDetails($rowFetchInvoice['refference_id']);
                                    $type = "ACCOMPANY REGISTRATION - " . $thisUserAccompanyDetails['user_full_name'];
                                }
                                if ($rowFetchInvoice['service_type'] == "DELEGATE_RESIDENTIAL_REGISTRATION") {
                                    if ($rowFetchUser['registration_classification_id'] == 3) {
                                        $type = $cfg['RESIDENTIAL_NAME'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 7) {
                                        $type = $cfg['RESIDENTIAL_NAME_IN_2N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 8) {
                                        $type = $cfg['RESIDENTIAL_NAME_IN_3N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 9) {
                                        $type = $cfg['RESIDENTIAL_NAME_SH_2N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 10) {
                                        $type = $cfg['RESIDENTIAL_NAME_SH_3N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 11) {
                                        $type = $cfg['RESIDENTIAL_NAME_IN_2N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 12) {
                                        $type = $cfg['RESIDENTIAL_NAME_IN_3N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 13) {
                                        $type = $cfg['RESIDENTIAL_NAME_SH_2N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 14) {
                                        $type = $cfg['RESIDENTIAL_NAME_SH_3N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 15) {
                                        $type = $cfg['RESIDENTIAL_NAME_IN_2N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 16) {
                                        $type = $cfg['RESIDENTIAL_NAME_IN_3N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 17) {
                                        $type = $cfg['RESIDENTIAL_NAME_SH_2N'] . " - " . $thisUserDetails['user_full_name'];
                                    } else if ($rowFetchUser['registration_classification_id'] == 18) {
                                        $type = $cfg['RESIDENTIAL_NAME_SH_3N'] . " - " . $thisUserDetails['user_full_name'];
                                    }
                                }
                                if ($rowFetchInvoice['service_type'] == "DELEGATE_ACCOMMODATION_REQUEST") {
                                    $type = "ACCOMMODATION BOOKING";
                                }
                                if ($rowFetchInvoice['service_type'] == "DELEGATE_DINNER_REQUEST") {
                                    $type = $cfg['BANQUET_DINNER_NAME'] . " - " . getInvoiceTypeStringForMail($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "DINNER");
                                }
                                if ($rowFetchInvoice['status'] == 'C') {
                                    $styleColor = 'background: #FFCCCC;';
                                } else {
                                    $styleColor = 'background: rgb(204, 229, 204);';
                                }

                                if ($rowFetchInvoice['has_gst'] == 'Y' && $rowFetchInvoice['invoice_mode'] == 'ONLINE') {
                                    $invRowSpan = 2;
                                } else {
                                    $invRowSpan = 1;
                                }

                                if ($showTheRecord) {
                        ?>
                    <div class="help_top">
                        <h6><i class="fal fa-question-circle"></i> <?= $type ?></h6>
                        <h6>Invoice No</h6>
                        <h6> <?= $rowFetchInvoice['invoice_number'] ?></h6>
                        <p>Invoice Date: <?= setDateTimeFormat2($rowFetchInvoice['invoice_date'], "D") ?></p>
                        <h4><a>Invoice Amount: <?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmount, 2) ?> </a><a href="pdf.download.invoice.php?user_id=<?= $rowFetchUser['id'] ?>&invoice_id=<?= $rowFetchInvoice['id'] ?>" target="_blank" title="Invoice Download" class="badge_primary icon_hover action-transparent"><i class="fal fa-download"></i> DownLoad Invoice</a></h4>
                    </div>
                    <?
                     } 
                            } 
                            }
                            ?>
                </div>
            </div>
            <div class="help_detail profile_detaile_box">
                <div class="profile_detaile_box_head">
                    <h3><span><i class="fal fa-question-circle"></i></span>Help & Support</h3>
                </div>
                <?php
                $sqlFooterIcon  = array();
                $sqlFooterIcon['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
                                        WHERE `status`='A' AND purpose='Footer' order by id ";
                $resultFooterIcon = $mycms->sql_select($sqlFooterIcon);
                 ?>
                <div class="profile_detaile_box_body">
                    <div class="help_top">
                        <h6><i class="fal fa-question-circle"></i>Need Assistance?</h6>
                        <p>If you're having trouble managing your registration, our support desk is active 10 AM to 6 PM IST.</p>
                        <h4>
                            <?      
                            foreach ($resultFooterIcon as $k => $val) {
                                 if ($val['title'] == 'Email') {
                                    $href = 'mailto:' . $val['page_link'];
                                ?>
                                 <a href="<?= $href?>">Email Help : <?=$val['page_link']?></a>
                                <?
                                 }if ($val['title'] == 'Phone') {
                                     $href = 'tel:+:' . $val['page_link'];
                                    ?>
                                <a href="<?= $href?>">Talk to us : <?=$val['page_link']?></a>
                                    <?
                            }
                            }
                            ?>
                            </h4>
                    </div>
                    <!-- <div class="help_bottom badge_danger">
                        <h6><?php pending(); ?>Registration Cancellation</h6>
                        <p><?php echo $rowInfo['cancellation_page_info']; ?></p>
                    </div> -->
                    <div class="help_bottom badge_danger">
                        <h6><?php pending(); ?>Registration Cancellation</h6>
                        <?php
                            $cancellationHtml = $rowInfo['cancellation_page_info'];

                            libxml_use_internal_errors(true); // prevent HTML warnings

                            $dom = new DOMDocument();
                            $dom->loadHTML($cancellationHtml);

                            $rows = $dom->getElementsByTagName('tr');

                            $policies = [];

                            foreach ($rows as $index => $row) {

                                // Skip first row (header row: Date / Deduction)
                                if ($index == 0) continue;

                                $cells = $row->getElementsByTagName('td');

                                if ($cells->length >= 2) {
                                    $date = trim($cells->item(0)->textContent);
                                    $deduction = trim($cells->item(1)->textContent);

                                    $policies[] = $date . " " . $deduction;
                                }
                            }
                            ?>
                       <ul>
                            <?php foreach($policies as $policy) { ?>
                                <li><?= htmlspecialchars($policy); ?></li>
                            <?php } ?>
                        </ul>
                        <h4><a class="popup_btn" style="cursor:pointer;" data-tab="cancelation">View Full Cancellation</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<div class="popup_wrap">
    <div class="popup_inner">
        
    <form name="frmAddWorkshopfromProfile" id="frmAddWorkshopfromProfile" action="registration.process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="act" value="add_workshop">
        <input type="hidden" id="cutoff_id" name="cutoff_id" value="<?= $currentWorkshopCutoffId ?>" cutoffid="1">
        <input type="hidden" name="delegateClasfId" value="<?= $rowUserDetails['registration_classification_id'] ?>">
        <input type="hidden" id="registrationRequest" name="registrationRequest" value="GENERAL">
        <input type="hidden" name="gst_flag" id="gst_flag" value="<?= $cfg['GST.FLAG'] ?>" />
        <div class="popup_body registration_right_wrap" id="addworkshop">
            <div class="registration_right_head">
                <span><?=$cfg['WORKSHOP_TITLE']?></span>
                <button type="button" class="popup_close"><?php close(); ?></button>
            </div>
            <div class="registration_right_body" id="section3">
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
                        if ($currentCutoffId > 0) {

                            $conferenceTariffArray   = getAllRegistrationTariffs($currentCutoffId);
                            $workshopDetailsArray   = getAllWorkshopTariffs($currentWorkshopCutoffId);
                            $workshopCountArr       = totalWorkshopCountReport();

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
                                // echo '<pre>'; print_r($registrationDetailsVal);
                                $classificationType = getRegClsfType($key);
                                if ($classificationType == 'DELEGATE') {


                                    $getSeatlimitToClassificationID = getSeatlimitToClassificationID($registrationDetailsVal['REG_CLASSIFICATION_ID']);

                                    if ($getSeatlimitToClassificationID < 0) {
                                        $disableClass = "disabled";
                                        $spanCss = 'style="cursor:not-allowed;"';
                                    } else {
                                        $disableClass = "";
                                        $spanCss = '';
                                    }

                                    $icon = $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $registrationDetailsVal['ICON'];
                        }
                            }
                        }
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
                            <button type="button" class="active wrkshp_tab_btn" id="wrkshp_tab_btn" data-tab="<?= $rowsl['workshop_date'] ?>"><?= displayDateFormat($rowsl['workshop_date']) ?></button>
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
                      $registration_classification_id = isset($rowUserDetails['registration_classification_id']) ? (int)$rowUserDetails['registration_classification_id'] : '';

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
                <button type="button" name="previous" class="previous action-button-previous popup_close">Cancel</button>
                <button  type="button" formPay="frmAddWorkshopfromProfile"  class="next action-button next"><?php save(); ?> Save</button>
            </div>
            
        </div>
       
        </form>
        <div class="popup_body registration_right_wrap" id="addstay">
            <div class="registration_right_head">
                <span>Stay</span><button type="button" class="popup_close"><?php close(); ?></button>
            </div>
            <div class="registration_right_body">
                <div class="registration_right_body_head">
                    <div class="registration_right_body_head_left">
                        <h4>Hotel Accommodation (Optional)</h4>
                        <h5>Add a room to your individual registration.</h5>
                    </div>
                    <div class="registration_right_body_head_right">
                        <a class="text_danger">Clear</a>
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
                        <div class="hotel_check form_grid g_2">
                            <div class="frm_grp span_1">
                                <p class="frm-head">Check In</p>
                                <input type="date">
                            </div>
                            <div class="frm_grp span_1">
                                <p class="frm-head">Check Out</p>
                                <input type="date">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="registration_right_body_tab">
                    <div class="hotel_link_owl owl-carousel owl-theme">
                        <button type="button" class="active hotel_tab_btn" data-tab="hotel1">Hotel Sonar Bangla, Mandarmani new</button>
                        <button type="button" class="hotel_tab_btn" data-tab="hotel2">Hotel 2</button>
                    </div>
                </div>
                <div class="registration_right_body_content">
                    <div class="hotel_box" id="hotel1" style="display: block;">
                        <div class="hotel_box_inner">
                            <div class="hotel_box_left">
                                <div class="hote_box_left_top">
                                    <t><?php star(); ?>5 Star</t>
                                    <div class="hotel_owl owl-carousel owl-theme">
                                        <div class="item">
                                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" alt="">
                                        </div>
                                        <div class="item">
                                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" alt="">
                                        </div>
                                    </div>
                                </div>
                                <ul class="hote_box_left_bottom">
                                    <li><img src="" alt="">Aminity 1</li>
                                    <li><img src="" alt="">Aminity 2</li>
                                </ul>
                            </div>
                            <div class="hotel_box_right">
                                <div class="stay_li_right">
                                    <n>
                                        <g>Deluxe Room
                                            <ii>Elegant city views.</ii>
                                        </g>
                                        <div>
                                            <div class="accomdationroomqty-input">
                                                <button  class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                                <input  class="accmomdation-qty" type="number" name="accmomdation-qty" min="1" max="10" value="1">
                                                <button  class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                            </div>
                                        </div>
                                    </n>
                                    <div class="cus_check_wrap g2">
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Single</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Twin</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="stay_li_right">
                                    <n>
                                        <g>Junior Suite
                                            <ii>Dedicated lounge area.</ii>
                                        </g>
                                        <div class="accomdationroomqty-input">
                                            <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                            <input class="accmomdation-qty" type="number" name="accmomdation-qty" min="1" max="10" value="1">
                                            <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                        </div>
                                    </n>
                                    <div class="cus_check_wrap g2">
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Single</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Twin</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="stay_li_right">
                                    <n class="stay_note">
                                        <g>
                                            <ii><?php pending(); ?>Room rates are per night and exclusive of GST.</ii>
                                        </g>
                                    </n>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hotel_box" id="hotel2">
                        <div class="hotel_box_inner">
                            <div class="hotel_box_left">
                                <div class="hote_box_left_top">
                                    <t><?php star(); ?>5 Star</t>
                                    <div class="hotel_owl owl-carousel owl-theme">
                                        <div class="item">
                                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" alt="">
                                        </div>
                                    </div>
                                </div>
                                <ul class="hote_box_left_bottom">
                                    <li><img src="" alt="">Aminity 2</li>
                                </ul>
                            </div>
                            <div class="hotel_box_right">
                                <div class="stay_li_right">
                                    <n>
                                        <g>ITC Royal Bengal
                                            <ii><?php address(); ?>JBS Haldane Avenue</ii>
                                        </g>
                                    </n>
                                    <div class="cus_check_wrap g2">
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Single</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Twin</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="stay_li_right">
                                    <n>
                                        <g>ITC Royal Bengal
                                            <ii><?php address(); ?>JBS Haldane Avenue</ii>
                                        </g>
                                    </n>
                                    <div class="cus_check_wrap g2">
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Single</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                        <label class="cus_check stay_select">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">
                                                <n>Twin</n>
                                                <h>₹ 12,000</h>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="stay_li_right">
                                    <n class="stay_note">
                                        <g>
                                            <ii><?php pending(); ?>Room rates are per night and exclusive of GST.</ii>
                                        </g>
                                    </n>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="accomdationprice_total">
                    <li>
                        <p>Hotel Sonar Bangla, Mandarmani new<span>Single</span></p>
                        <h6>
                            <span>Delux<br>2 Rooms<br>3 Nights</span><span>Delux<br>2 Rooms<br>3 Nights</span><span>Delux<br>2 Rooms<br>3 Nights</span><span>Delux<br>2 Rooms<br>3 Nights</span>
                        </h6>
                        <h5>Sub-total<span>2000</span></h5>
                    </li>
                </ul>
                <div class="accomdation_total">
                    <h5>Total<span>2000<n>With 18% GST</n></span></h5>
                </div>
            </div>
            <div class="registration_right_bottom">
                <button type="button" name="previous" class="previous action-button-previous popup_close">Cancel</button>
                <button type="button" name="next" class="next action-button"><?php save(); ?> Save</button>
            </div>
        </div>
        <form name="frmAddAccompanyfromProfile" id="frmAddAccompanyfromProfile" action="registration.process.php" method="post" enctype="multipart/form-data">
        <div class="popup_body registration_right_wrap " id="addguest">
            <div class="registration_right_head">
                <span><?=$cfg['ACCOMAPNY_TITLE']?></span><button type="button" class="popup_close"><?php close(); ?></button>
            </div>
                <div class="registration_right_body"  id="section4">
                    <div class="registration_right_body_head">
                        <div class="registration_right_body_head_left">
                            <h4>Accompanying Persons</h4>
                            <h5>Add family members (Includes meals & gala dinner).</h5>
                        </div>
                    </div>
                    <div class="registration_right_body_content">
                        <div class="guest_wrap"  id="accompanyingTableBody">
                            <?php
                                $accompanyIndex = 0;
                                $accompanyCatagory = 1; // same as old
                                $registrationCurrency = $conferenceTariffArray[$accompanyCatagory]['CURRENCY'];

                                // For initial guest row (first accompany)
                                ?>
                                <input type="hidden" id="cutoff_id" name="cutoff_id" value="<?= $currentCutoffId ?>" cutoffid="<?= $currentCutoffId ?>" />
                                <input type="hidden" name="accompanyClasfId" value="<?= $accompanyCatagory ?>" />
                                <input type="hidden" name="act" value="add_accompany" />
                                <input type="hidden" name="registration_request" id="registration_request" value="GENERAL" />

                                <input type="hidden" name="gst_flag" id="gst_flag" value="<?= $cfg['GST.FLAG'] ?>" />

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
                                                countindex="<?= $accompanyIndex ?>">
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
                        <button type="button" class="add_guest" id="add-accompany-btn"><?php add(); ?> Add Guest</button>
                    </div>
                </div>
                <div class="registration_right_bottom">
                    <button type="button" name="previous" class="previous action-button-previous popup_close">Cancel</button>
                    <button type="button" name="next" formPay="frmAddAccompanyfromProfile" class="next action-button"><?php save(); ?> Save</button>
                </div>
            </div>    
            <div class="popup_body registration_right_wrap checkout-main-wrap" id="checkout-main-wrap" >
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
                <span> Review</span>
                <button type="button" class="popup_close"><?php close(); ?></button>
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
                          <p class="frm-head d-flex justify-content-between align-items-center">Included GST (18%)<k use="totalGstAmount">₹ 0.00</k>
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
                      <button   type="button" class="active"
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
                        <?php qr(); ?> Cards
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
                      <input type="radio" name="payment_mode" use="payment_mode_select" value="Neft" hidden checked>
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
                        <li>
                          <h6 class="d-flex justify-content-between align-items-center">Transfer via Net Banking or NEFT/IMPS.</h6>
                          <div>
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
                          <input type="date" class="form-control mandatory" name="neft_date" id="neft_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                        </li>
                         <?php
                          if (in_array("Neft", $offline_payments)) {
                          ?>
                        <li class="for-neft-rtgs-only"  style="display: none;" >
                          <h6 class="d-flex justify-content-between align-items-center">UTR Number</h6>
                          <input type="text" class="form-control mandatory utrnft" name="neft_transaction_no" id="neft_transaction_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
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
                         
                          <h6 class="d-flex justify-content-between align-items-center">Accepted Cards</h6>
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
              <button type="submit" name="submit" id="confirmPayment" class="submit action-button">Confirm<?php check(); ?></button>
            </div>
        </div>      
        </form>
        <div class="popup_body registration_right_wrap" id="adddinner">
            <div class="registration_right_head">
                <span>Gala Dinner</span><button type="button" class="popup_close"><?php close(); ?></button>
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
                        <label class="cus_check workshop_select gala_select">
                            <input type="checkbox" name="regimood" checked>
                            <span class="checkmark">
                                <n>
                                    <?php dinner(); ?>
                                    <iii></iii>
                                </n>
                                <g>Welcome Gala Night
                                    <ii><?php calendar(); ?>Dec 19, 2025 (Day 1)</ii>
                                    <k>A traditional Bengali themed evening with live classical music.</k>
                                </g>
                                <h>
                                    <l>₹ 2,500</l>
                                </h>
                            </span>
                        </label>
                        <label class="cus_check workshop_select gala_select">
                            <input type="checkbox" name="regimood">
                            <span class="checkmark">
                                <n>
                                    <?php dinner(); ?>
                                    <iii></iii>
                                </n>
                                <g>Welcome Gala Night
                                    <ii><?php calendar(); ?>Dec 19, 2025 (Day 1)</ii>
                                    <k>A traditional Bengali themed evening with live classical music.</k>
                                </g>
                                <h>
                                    <l>₹ 2,500</l>
                                </h>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="registration_right_bottom">
                <button type="button" name="previous" class="previous action-button-previous popup_close">Cancel</button>
                <button type="button" name="next" class="next action-button"><?php save(); ?> Save</button>
            </div>
        </div>
          <div class="popup_body registration_right_wrap" id="cancelation">
            <div class="registration_right_head">
                <span>Cancellation Policy</span><button class="popup_close"><?php close(); ?></button>
            </div>
            <div class="registration_right_body registration_right_body_withou_bottom">
                <?php echo $rowInfo['cancellation_page_info']; ?>
            </div>
        </div>
    </div>
</div>
<?php include_once("includes/js-source.php"); ?>
<script>
    $('.popup_close').click(function() {
        $(".popup_wrap").hide();
        $(".popup_body").hide();
    });
    $('#touch-taget').click(function() {
        $(".profile_left_menu").toggleClass('active');
    });
  $(document).ready(function() {

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
      $(document).ready(function() {
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
        // When a payment radio is clicked
        $("input[type=radio][use=payment_mode_select]").click(function() {
            var val = $(this).val(); // Get selected payment value
            //  alert(val);

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

            } else {
                $('.for-upi-only').hide();
                $('.for-neft-rtgs-only').show();
                $('#neft_transaction_no').addClass('mandatory');

            }
        });
    // $("input[type=radio][use=payment_mode_select]").click(function() {

    //         var val = $(this).val();
    //         var forVal = $(this).attr('for');
    //         var formPay = $(this).attr('formPay');
    //         var form = $("#" + formPay);
    //         // alert(form);

    //         $("div[use=offlinePaymentOption]").hide();
    //         if (val != undefined) {
    //             form.find("div[use=offlinePaymentOption][for=" + forVal + "]").show();
    //             if (val === 'Card') {
    //                 form.find('#registrationMode').val('ONLINE');
    //                 form.find('#paymentDetailsSection').hide();
    //                 form.find('#paymentDetailsSectionOnline').show();
    //             } else {
    //                 if ($(this).attr('act') == 'Upi') {
    //                     $('.for-upi-only').show();
    //                     $('.for-neft-rtgs-only').hide();
    //                 } else {
    //                     $('.for-upi-only').hide();
    //                     $('.for-neft-rtgs-only').show();

    //                 }
    //                 form.find('#registrationMode').val('OFFLINE');
    //                 form.find('#paymentDetailsSection').show();
    //                 form.find('#paymentDetailsSectionOnline').hide();
    //             }
    //         }

    //     });
        // Trigger click on page load if you want default selection
        var defaultChecked = $("input[type=radio][use=payment_mode_select]:checked");

        if(defaultChecked.length) {
            defaultChecked.trigger('click');
        }
    });
    $("form").on("submit", function(e) {
    var selectedOption = $("input[type=radio][name='payment_mode']:checked").val();
    var flag = 0;

    if (!selectedOption) {
        toastr.error('Please select payment mode', 'Error', {
            "progressBar": true,
            "timeOut": 5000,
            "showMethod": "slideDown",
            "hideMethod": "slideUp"
        });
        flag = 1;
    } else {
        // Validate inputs inside the visible payment box
        $(".review_right_box:visible input.mandatory").each(function() {
            var type = $(this).attr('type');
            if (type === 'radio') {
                if (!$("input[type='radio'][name='card_mode']:checked").length) {
                    toastr.error('Please select the card', 'Error', {
                        "progressBar": true,
                        "timeOut": 5000,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp"
                    });
                    flag = 1;
                    return false; // stop .each loop
                }
            } else {
                if ($(this).val().trim() === '') {
                    toastr.error($(this).attr('validate'), 'Error', {
                        "progressBar": true,
                        "timeOut": 5000,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp"
                    });
                    flag = 1;
                    return false; // stop .each loop
                }
            }
        });
    }

    if (flag > 0) {
        e.preventDefault(); // stop form submission
        return false;
    }
 
    // If we reach here, validation passed → form submits normally
});
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
</script>
    <script>
        
        $(document).ready(function() {
            var currentSection = '<?= $section ?>';
            showSection(currentSection);
            var activeForm = null;

            // //alert(currentSection);
            //$('.next').click(function() {
            $(document).on("click", ".next", function() {
                     var formId = $(this).attr("formPay");
                    var form = $("#" + formId);

                    if (validateSection(currentSection, form)) {

                        // hide other sections inside this form only
                        form.find(".checkout-main-wrap").show();

                        form.find("#addworkshop, #addguest").hide();
                    }
                    // var formPay = $(this).attr('formPay');

                    // var formPay = $('#' + formPay);
                    //  if (validateSection(currentSection, formPay)) {

                    //     $('#pageTitle').text("");
                    //     $('#pageTitle').text($(this).attr('title'));

                        
                    //     if (formPay.length && formPay.find('#checkout-main-wrap').length) {
                    //         // Show the element with ID 'checkout-main-wrap'
                    //         // alert(formPay.length);

                    //         formPay.find('#checkout-main-wrap').show();
                    //           $('#addworkshop').hide();
                    //               $('#addguest').hide();
                    //         formPay.find('#pay-button').show();
                    //     } else {
                    //         console.error('Form or element not found.');
                    //     }




                //  } // end validation if 
               // Check if there is at least one accompanying name filled
                var hasName = false;
                $(".accompany_name").each(function() {
                    if ($(this).val().trim() !== "") {
                        hasName = true;
                        return false; // exit loop early
                    }
                });

                if (hasName) {
                    $(".accompanyCount").prop("checked", true);
                    calculateTotalAmount();
                }
            });
            $(document).on("click", "#confirmPayment", function () {

               
                var form = $(this);

                var visiblePayment = form.find(".checkout-main-wrap:visible");

                var flag = 0;

                visiblePayment.find(".mandatory").each(function() {
                    if ($(this).val().trim() === "") {
                        toastr.error($(this).attr("validate"));
                        flag = 1;
                        return false;
                    }
                });

                if (flag === 1) {
                    e.preventDefault();
                    return false;
                }
            });


            function isAnyCheckboxChecked(className) {
                var checkboxes = document.querySelectorAll('.' + className);

                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        return true; // At least one checkbox is checked
                    }
                }

                return false; // No checkbox is checked
            }

            function validateSection(section, formPay) {
                //alert(section); 
                var isValid = true;
                var accomArr = [];
                var galaDinnerDiv = '';
                var hasExecuted = false;
                //alert(formPay);
                $("#section" + section + " input[type='text'], #section" + section + " input[type='radio'], #section" + section + " input[type='checkbox'], #section" + section + " select").each(function(index) {


                    if ($(this).attr('type') === 'text' && !$.trim($('.accompany_name').val())) {


                        //alert(1);

                        if (section == 2) {

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

                        }

                        if (section == 4) {
                            if ($("input[type='checkbox'][name='accompanyCount']:checked").length) {
                                //alert($(this).attr('name'))

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
                            }

                            // 
                        }


                    } else if ($(this).attr('type') === 'radio') {





                        if (section == 1) {
                            // Check if at least one radio button is checked
                            if (!$("input[name='" + $(this).attr('name') + "']:checked").length) {
                                // Perform validation, show an error message, or take necessary action
                                console.log("Please select a value for radio button " + $(this).attr('name'));
                                toastr.error('Please select a category', 'Error', {
                                    "progressBar": true,
                                    "timeOut": 3000, // 3 seconds
                                    "showMethod": "slideDown", // Animation method for showing
                                    "hideMethod": "slideUp" // Animation method for hiding
                                });

                                isValid = false;
                                return false;
                            }

                        }

                        if (section == 2) {
                            // Check if at least one radio button is checked
                            if (!$("input[name='" + $(this).attr('name') + "']:checked").length) {

                                //console.log("Please select a value for radio button " + $(this).attr('name'));
                                toastr.error('Please select a gender', 'Error', {
                                    "progressBar": true,
                                    "timeOut": 3000, // 3 seconds
                                    "showMethod": "slideDown", // Animation method for showing
                                    "hideMethod": "slideUp" // Animation method for hiding
                                });

                                isValid = false;
                                return false;
                            }
                        }

                        if (section == 3) {
                            //alert($(this).attr('name'));
                            if (!$("input[name='workshop_id[]']:checked").length) {

                                //console.log("Please select a value for radio button " + $(this).attr('name'));
                                toastr.error('Please select a workshop', 'Error', {
                                    "progressBar": true,
                                    "timeOut": 3000, // 3 seconds
                                    "showMethod": "slideDown", // Animation method for showing
                                    "hideMethod": "slideUp" // Animation method for hiding
                                });

                                isValid = false;
                                return false;
                            }
                        }

                        if (section == 4) {

                            if (!$("input[type='checkbox'][name='accompanyCount']:checked").length) {

                                toastr.error('Please select a accompany', 'Error', {
                                    "progressBar": true,
                                    "timeOut": 3000, // 3 seconds
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp"
                                });

                                isValid = false;
                                return false;

                            } //end if
                            // else if ($("input[type='checkbox'][name='accompanyCount']:checked").length) {

                            //     var totalAccomCount = Number($("input[type='checkbox'][name='accompanyCount']:checked").length) - 1;

                            //     //alert(totalAccomCount);

                            //     if (!$("input[name='accompany_food_choice[" + totalAccomCount + "]']:checked").length) {

                            //         toastr.error('Please select a food preference', 'Error', {
                            //             "progressBar": true,
                            //             "timeOut": 3000, // 3 seconds
                            //             "showMethod": "slideDown", // Animation method for showing
                            //             "hideMethod": "slideUp" // Animation method for hiding
                            //         });

                            //         isValid = false;
                            //         return false;

                            //     }

                            // } //else if



                        }


                    } else if ($(this).attr('type') === 'checkbox' && section == 5) {
                        //alert(12);
                        var isAnyChecked = isAnyCheckboxChecked('checkboxClassDinner');
                        if (isAnyChecked) {
                            console.log('At least one checkbox is checked.');
                        } else {
                            toastr.error('Please select at least one banquet', 'Error', {
                                "progressBar": true,
                                "timeOut": 3000,
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp"
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

                $('.gala-dinner-select').append(galaDinnerDiv);

                return isValid;


            } //end if validation

            function showSection(section) {
                $('.section').removeClass('active');
                $('#section' + section).addClass('active');
            }

        });

        function checkUserEmail(obj) {

            var liParent = $(obj).parent().closest("div[use=registrationUserDetails]");
            var emailId = $.trim($(obj).val());
            // alert(emailId);

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

                                    enableAllFileds(liParent);


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
                                }
                            }
                        });
                    }, 500);
                } else {
                    toastr.error('Enter Valid Email Id', 'Error', {
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

        function validateMobile(mobile) {


            if (mobile != '') {
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

                        } else {
                            $('#user_details').show();
                            console.log('>>' + $(parent).find(
                                "div[use=mobileProcessing]").find(
                                "input[name=user_mobile_validated]").val());
                        }
                    }
                });
            }

        }

        $(document).on("click", "#pay-button-vouchar", function() {

            //alert(12);
            // Checking if a radio button with name "gender" is checked
            if ($('input[name="card_mode"]:checked').length > 0) {
                $("form[name='frmApplyPayment']").submit();
            } else {
                toastr.error('Please select a payment method', 'Error', {
                    "progressBar": true,
                    "timeOut": 3000,
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                });

                flag = 1;
                return false;
            }
        });


        $("input[type=radio][operationMode=registration_tariff]").each(function() {
            $(this).click(function() {

                $("#bill_details").show();

                var currChkbxStatus = $(this).attr("chkStatus");

                $("input[type=checkbox][operationMode=registration_tariff]").prop(
                    "checked", false);
                $("input[type=checkbox][operationMode=registration_tariff]").attr(
                    "chkStatus", "false");

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
                    $(this).attr("chkStatus", "false");

                    $("div[operationMode=chhoseServiceOptions][use=residentialOperations]")
                        .hide();
                    $("div[operationMode=chhoseServiceOptions][use=defaultChoices]")
                        .slideDown();
                    window.location.reload();
                } else {
                    $(this).prop("checked", true);
                    $(this).attr("chkStatus", "true");

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

        $("input[type=radio][operationMode=workshopId]").each(function() {
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


            });
        });

        // $("input[type=checkbox][use=accompanyCountSelect]").click(function() {
        //     var count = parseInt($(this).val());

        //     calculateTotalAmount();
        // });

        $(document).on("click", "input[type=checkbox], input[type=radio]", function() {

            var key = $(this).attr('key');
            if (key != undefined && key != '') {

                if ($("#accomodation_package_checkin_id" + key).is(":checked")) {
                    console.log("Radio button with ID 'radioButton1' is checked");
                    calculateTotalAmount();
                } else {

                    alert('Please select check in date first')
                    return false;
                }
            } else {
                calculateTotalAmount();
            }

            //alert(key);


        });

        // function calculateTotalAmount() {
        //     console.log("====calculateTotalAmount====");

        //     var totalAmount = 0;
        //     var totTable = $("table[use=totalAmountTable]");
        //     $(totTable).children("tbody").find("tr").remove();
        //     var gst_flag = $('#gst_flag').val();


        //     $('input[type=checkbox]:checked,input[type=radio]:checked,#accomodation_package_checkout_id option').each(function() {
        //         var attr = $(this).attr('amount');
        //         var operation = $(this).attr('operationmodetype');
        //         var regtype = $(this).attr('regtype');
        //         var reg = $(this).attr('reg');

        //         var package = $(this).attr('package');
        //         var key = $(this).attr('key');

        //         //alert(11)

        //         if (typeof attr !== typeof undefined && attr !== false) {
        //             var amt = parseFloat(attr);


        //             if (typeof package !== typeof undefined && package !== false) {



        //                 // alert(checkedValue);

        //                 var checkInVal = $('#accomodation_package_checkin_id').val();
        //                 var checkOutVal = $('#accomodation_package_checkout_id').val();

        //                 console.log('checkInVal====', checkInVal)
        //                 console.log('checkOutVal====', checkOutVal)





        //                 if (checkInVal !== undefined && checkOutVal !== undefined) {




        //                     const checkInArray = checkInVal.split("/");
        //                     var checkInID = checkInArray[0];
        //                     var checkInDate = checkInArray[1];

        //                     //alert('checkindate',checkInDate);

        //                     const checkOutArray = checkOutVal.split("/");
        //                     var checkOutID = checkOutArray[0];
        //                     var checkOutDate = checkOutArray[1];


        //                     var date1 = new Date(checkInDate);
        //                     var date2 = new Date(checkOutDate);

        //                     // Calculate the difference in milliseconds
        //                     var differenceMs = Math.abs(date2 - date1);

        //                     var accommodation_room = $('#accommodation_room').val();
        //                     if (typeof accommodation_room !== typeof undefined && accommodation_room !== false && !isNaN(accommodation_room)) {
        //                         var roomQty = accommodation_room;
        //                     } else {
        //                         var roomQty = 1;
        //                     }

        //                     var differenceDays = Math.ceil(differenceMs / (1000 * 60 * 60 * 24));


        //                     console.log('accoAmnt=' + differenceDays);
        //                     var amt = parseFloat(amt) * parseInt(differenceDays) * parseInt(roomQty);

        //                     if (isNaN(amt)) {
        //                         amt = 0;
        //                     }
        //                 }



        //             }
        //             if (regtype !== 'combo') {

        //                 if (gst_flag == 1) {
        //                     var cgstP = <?= $cfg['INT.CGST'] ?>;
        //                     var cgstAmnt = (amt * cgstP) / 100;

        //                     var sgstP = <?= $cfg['INT.SGST'] ?>;
        //                     var sgstAmnt = (amt * sgstP) / 100;

        //                     var totalGst = cgstAmnt + sgstAmnt;
        //                     var totalGstAmount = cgstAmnt + sgstAmnt + amt;
        //                     totalAmount = totalAmount + totalGstAmount;
        //                 } else {
        //                     totalAmount = totalAmount + amt;
        //                 }

        //                 if (reg != undefined && reg == 'reg') {
        //                     $('#confPrc').text((amt).toFixed(2));
        //                 }

        //             }

        //             console.log(">>amt" + amt + ' ==> ' + totalAmount);

        //             var attrReg = $(this).attr('operationMode');
        //             var isConf = false;
        //             if (typeof attrReg !== typeof undefined && attrReg !== false && attrReg ===
        //                 'registration_tariff') {
        //                 isConf = true;
        //             }
        //             var isMastCls = false;
        //             if (typeof attrReg !== typeof undefined && attrReg !== false && attrReg ===
        //                 'workshopId') {
        //                 isMastCls = true;
        //             }

        //             // november22 workshop related work by weavers start

        //             var isNovWorkshop = false;
        //             if (typeof attrReg !== typeof undefined && attrReg !== false && attrReg ===
        //                 'workshopId_nov') {
        //                 isNovWorkshop = true;
        //             }

        //             // november22 workshop related work by weavers end

        //             var cloneIt = false;
        //             var amtAlterTxt = 'Complimentary';

        //             if (amt > 0) {
        //                 cloneIt = true;
        //             } else if (isConf) {
        //                 cloneIt = true;
        //                 amtAlterTxt = 'Complimentary'
        //             } else if (isMastCls || isNovWorkshop) {
        //                 cloneIt = true;
        //                 amtAlterTxt = 'Included in Registration'
        //             }

        //             if (cloneIt) {

        //                 //alert($(this).attr('invoiceTitle'));
        //                 var cloned = $(totTable).children("tfoot").find("tr[use=rowCloneable]").first()
        //                     .clone();
        //                 $(cloned).attr("use", "rowCloned");
        //                 var imageElement = $('<img>').attr('src', "< _BASE_URL_ ?>" + $(this).attr('icon'));
        //                 //alert("< _BASE_URL_ ?>"+$(this).attr('icon'));
        //                 $(cloned).find("span[use=icon]").append(imageElement);
        //                 $(cloned).find("span[use=invTitle]").append($(this).attr('invoiceTitle'));
        //                 if (regtype === 'combo') {

        //                     $(cloned).find("span[use=amount]").text((amt > 0) ? ('Included') : amtAlterTxt);
        //                 } else {

        //                     $(cloned).find("span[use=amount]").text((amt > 0) ? (amt).toFixed(2) : amtAlterTxt);
        //                 }

        //                 $(cloned).show();
        //                 $(totTable).children("tbody").append(cloned);
        //             }

        //             if (regtype !== 'combo') {

        //                 if (gst_flag == 1) {

        //                     if (cloneIt) {

        //                         var cgstP = <?= $cfg['INT.CGST'] ?>;
        //                         var cgstAmnt = (amt * cgstP) / 100;

        //                         var sgstP = <?= $cfg['INT.SGST'] ?>;
        //                         var sgstAmnt = (amt * sgstP) / 100;

        //                         var totalGst = cgstAmnt + sgstAmnt;
        //                         var totalGstAmount = cgstAmnt + sgstAmnt + amt;


        //                         var cloned = $(totTable).children("tfoot").find("tr[use=rowCloneable]").first()
        //                             .clone();
        //                         $(cloned).attr("use", "rowCloned");
        //                         $(cloned).find("span[use=invTitle]").text("GST 18%");
        //                         $(cloned).find("span[use=amount]").text((totalGst).toFixed(2));
        //                         $(cloned).show();
        //                         $(totTable).children("tbody").append(cloned);
        //                     }
        //                 }
        //             }
        //         }

        //         if ($(this).attr('operationMode') == 'registrationMode' && $(this).attr('use') ==
        //             'tariffPaymentMode') {

        //             if ($(this).val() == 'ONLINE') {
        //                 var internetHandling = <?= $cfg['INTERNET.HANDLING.PERCENTAGE'] ?>;
        //                 var internetAmount = (totalAmount * internetHandling) / 100;
        //                 totalAmount = totalAmount + internetAmount;

        //                 console.log(">>amt" + internetAmount + ' ==> ' + totalAmount);



        //                 var cloned = $(totTable).children("tfoot").find("tr[use=rowCloneable]").first()
        //                     .clone();

        //                 $(cloned).attr("use", "rowCloned");
        //                 $(cloned).find("span[use=invTitle]").text("Internet Handling Charge");
        //                 $(cloned).find("span[use=amount]").text((internetAmount).toFixed(2));
        //                 $(cloned).show();
        //                 $(totTable).children("tbody").append(cloned);
        //             }
        //         }
        //     });

        //     totalAmount = Math.round(totalAmount, 0);


        //     $(totTable).children("tfoot").find("span[use=totalAmount]").text((totalAmount).toFixed(2));
        //     $("div[use=totalAmount]").find("span[use=totalAmount]").text((totalAmount).toFixed(2));
        //     $("div[use=totalAmount]").find("span[use=totalAmount]").attr('theAmount', totalAmount);
        //     $("div[use=totalAmount]").show();

        //     $('#subTotalPrc').text((totalAmount).toFixed(2));

        //     totTable.show();
        // }

          function calculateTotalAmount() {
            console.log("====calculateTotalAmount====");
            var totalAmount = 0;
            var totalDinnerAmount = 0;
            var subTotalAmount = 0;
            var totalGstAmt = 0;
            var totTable = $("ul[use=totalAmountTable]");
            $(totTable).find("li[use='rowCloned']").remove();
            // $(totTable).find("li").remove();
            var gst_flag = $('#gst_flag').val();
          
            var dinnerFlag = false;

            $('input[type=checkbox]:checked,input[type=radio]:checked,#accomodation_package_checkout_id option,#accommodation_room option').each(function() {

                var attr = $(this).attr('amount');
                var operation = $(this).attr('operationmodetype');
                var regtype = $(this).attr('regtype');
                var reg = $(this).attr('reg');
                var qty = $(this).attr('qty');
                console.log('Qty=' + qty);
                var hasTotalAmntFlag = false;

                // alert(attr);

                var package = $(this).attr('package');

                //alert(11)

                if (typeof attr !== typeof undefined && attr !== false) {
                    var amt = parseFloat(attr);


                    if (typeof package !== typeof undefined && package !== false) {



                        // alert(checkedValue);

                        /*var checkInVal = $("input[name='accomodation_package_checkin_id']:checked").val();
                        var checkOutVal = $("input[name='accomodation_package_checkout_id']:checked").val();*/

                        var checkInVal = $('#accomodation_package_checkin_id').val();
                        var checkOutVal = $('#accomodation_package_checkout_id').val();

                        console.log('checkInVal====', checkInVal)
                        // alert(checkInVal);


                        if (checkInVal !== undefined && checkOutVal !== undefined) {
                            const checkInArray = checkInVal.split("/");
                            var checkInID = checkInArray[0];
                            var checkInDate = checkInArray[1];

                            //alert('checkindate',checkInDate);

                            const checkOutArray = checkOutVal.split("/");
                            var checkOutID = checkOutArray[0];
                            var checkOutDate = checkOutArray[1];


                            var date1 = new Date(checkInDate);
                            var date2 = new Date(checkOutDate);

                            // Calculate the difference in milliseconds
                            var differenceMs = Math.abs(date2 - date1);

                            var accommodation_room = $('#accommodation_room').val();
                            if (typeof accommodation_room !== typeof undefined && accommodation_room !== false && !isNaN(accommodation_room)) {
                                var roomQty = accommodation_room;
                            } else {
                                var roomQty = 1;
                            }

                            console.log('room qty=' + roomQty);

                            var differenceDays = Math.ceil(differenceMs / (1000 * 60 * 60 * 24));


                            console.log('accoAmnt=' + differenceDays);
                            var amt = parseFloat(amt) * parseInt(differenceDays) * parseInt(roomQty);

                            if (isNaN(amt)) {
                                amt = 0;
                            }

                            hasTotalAmntFlag = true;
                        }



                    }
                    if (regtype !== 'combo') {

                        if (gst_flag == 1) {
                            if (isNaN(amt)) {

                            } else {
                                var cgstP = <?= $cfg['INT.CGST'] ?>;
                                var cgstAmnt = (amt * cgstP) / 100;

                                var sgstP = <?= $cfg['INT.SGST'] ?>;
                                var sgstAmnt = (amt * sgstP) / 100;

                                var totalGst = cgstAmnt + sgstAmnt;
                                var totalGstAmount = cgstAmnt + sgstAmnt + amt;
                                 
                                totalAmount = totalAmount + totalGstAmount;
                                totalGstAmt = totalGstAmt+totalGst;
                                subTotalAmount =subTotalAmount+amt;
                            }

                        } else {
                            if (isNaN(amt)) {

                            } else {
                                totalAmount = totalAmount + amt;
                                subTotalAmount =totalAmount;
                            }


                        }

                        console.log('reg===' + reg);

                        if (reg != undefined && reg == 'reg') {
                            if (isNaN(amt)) {
                                $('#confPrc').text(0.00.toFixed(2));
                            } else {
                                $('#confPrc').text((amt).toFixed(2));
                            }

                        }

                        //alert(reg);

                        if (reg != undefined && reg == 'workshop') {
                            if (isNaN(amt)) {
                                $('#workshopPrc').text(0.00.toFixed(2));
                            } else {
                                $('#workshopPrc').text((amt).toFixed(2));
                            }

                            if (Number(amt) > 0) {
                                $('#wrkshopPrcdiv').show();
                            }

                        } else {
                            $('#wrkshopPrcdiv').hide();

                        }

                        if (reg != undefined && reg == 'accompany') {
                            if (isNaN(amt)) {
                                $('#accompanyPrc').text(0.00.toFixed(2));
                            } else {
                                $('#accompanyPrc').text((amt).toFixed(2));
                            }

                            $('.accompanyPrcdiv').show();
                        } else {
                            $('#accompanyPrcdiv').hide();

                        }

                        if (reg != undefined && reg == 'dinner' && qty != undefined) {

                            var checkedCount = $('.checkboxClassDinner:checked').length;
                            console.log("Number of checked checkboxes: " + checkedCount);

                            var totalDinnerAmounts = checkedCount * amt;

                            $('#dinnerPrc').text((totalDinnerAmounts).toFixed(2));
                            $('.dinnerPrcdiv').show();

                        } else {
                            $('#dinnerPrcdiv').hide();

                        }

                    }


                    console.log(">>amt" + amt + ' ==> ' + totalAmount);

                    var attrReg = $(this).attr('operationMode');
                    var isConf = false;
                    if (typeof attrReg !== typeof undefined && attrReg !== false && attrReg === 'registration_tariff') {
                        isConf = true;
                    }
                    var isMastCls = false;
                    if (typeof attrReg !== typeof undefined && attrReg !== false && attrReg === 'workshopId') {
                        isMastCls = true;
                    }

                    // november22 workshop related work by weavers start

                    var isNovWorkshop = false;
                    if (typeof attrReg !== typeof undefined && attrReg !== false && attrReg === 'workshopId_nov') {
                        isNovWorkshop = true;
                    }

                    // november22 workshop related work by weavers end

                    var cloneIt = false;
                    var amtAlterTxt = 'Complimentary';

                    if (amt > 0) {
                        cloneIt = true;
                    } else if (isConf) {
                        cloneIt = true;
                        amtAlterTxt = 'Complimentary'
                    } else if (isMastCls || isNovWorkshop) {
                        cloneIt = true;
                        amtAlterTxt = 'Included in Registration'
                    }

                    if (cloneIt) {
                        // alert($(this).attr('invoiceName'));
                           if(cloneIt) {
                                const el = $(this);

                                const title  = el.attr('invoiceTitle');
                                const name   = el.attr('invoiceName');
                                const amount = parseFloat(el.attr('amount')).toFixed(2);
                                const icon   = el.attr('icon');
                                const reg    = el.attr('reg');
                                // alert(name);
                                const cloned = $(totTable).find("li[use=rowCloneable]").first().clone();
                                $(cloned).attr("use", "rowCloned");

                                // set icon
                                if(icon) {
                                    const img = $('<img>').attr('src', "<?= _BASE_URL_ ?>" + icon);
                                    $(cloned).find("[use=icon]").append(img);
                                }

                                // set title, name, amount
                               cloned.find("[use=invTitle]").html(`${title}<br>${name}`);
                                $(cloned).find("[use=invName]").text(name);
                                $(cloned).find("[use=amount]").text("₹ " + amount);

                                // delete button if needed
                                if(reg != 'reg') {
                                    const deleteBtn = $('<i></i>')
                                        .addClass('fas fa-times delete-accompany-btn')
                                        .attr('reg', reg)
                                        .attr('val', el.val())
                                        .text('delete');
                                    $(cloned).find("[use=deleteIcon]").append(deleteBtn).show();
                                }

                                $(cloned).show();
                               const subtotalRow = $(totTable).find('li[use=subtotalRow]');
                               $(cloned).insertBefore(subtotalRow);
                            }
                            if (reg != 'reg') {
                            // <i class="fas fa-times"></i>
                            var deleteLink = $('<i></i>')
                                .attr('id', 'deleteItem')
                                .attr('class', 'fas fa-times delete-accompany-btn')
                                .attr('reg', reg)
                                .attr('val', $(this).attr('value'))
                                .attr('regClsId', $(this).attr('registrationclassfid'))
                                .text('delete')
                            $(cloned).find("span[use=deleteIcon]").append(deleteLink);
                            $(cloned).find("span[use=deleteIcon]").show();
                        }


                        $(cloned).show();
                        $(totTable).append(cloned);


                    }
                    if (regtype !== 'combo') {
                        if (gst_flag == 1) {
                            if (cloneIt) {
                                var cgstP = <?= $cfg['INT.CGST'] ?>;
                                var cgstAmnt = (amt * cgstP) / 100;

                                var sgstP = <?= $cfg['INT.SGST'] ?>;
                                var sgstAmnt = (amt * sgstP) / 100;

                                var totalGst = cgstAmnt + sgstAmnt;
                                var totalGstAmount = cgstAmnt + sgstAmnt + amt;


                                var cloned = $(totTable).children("tfoot").find("tr[use=rowCloneable]").first()
                                    .clone();
                                $(cloned).attr("use", "rowCloned");
                                $(cloned).find("span[use=invTitle]").text("GST 18%");
                                $(cloned).find("span[use=amount]").text((totalGst).toFixed(2));
                                $(cloned).show();
                                $(totTable).children("tbody").append(cloned);
                            }
                        }
                    }
                }

                if ($(this).attr('operationMode') == 'registrationMode' && $(this).attr('use') ==
                    'tariffPaymentMode') {

                    if ($(this).val() == 'ONLINE') {
                        var internetHandling = <?= $cfg['INTERNET.HANDLING.PERCENTAGE'] ?>;
                        var internetAmount = (totalAmount * internetHandling) / 100;
                        totalAmount = totalAmount + internetAmount;

                        console.log(">>amt" + internetAmount + ' ==> ' + totalAmount);



                        var cloned = $(totTable).find("li[use=rowCloneable]").first()
                            .clone();

                        $(cloned).attr("use", "rowCloned");
                        $(cloned).find("span[use=invTitle]").text("Internet Handling Charge");
                        $(cloned).find("span[use=amount]").text((internetAmount).toFixed(2));
                        $(cloned).show();
                        $(totTable).append(cloned);
                    }
                }
            });

            totalAmount = Math.round(totalAmount, 0);
            totalDinnerAmount = Math.round(totalDinnerAmount, 0);
            subTotalAmount = Math.round(subTotalAmount, 0);
            totalGstAmt= Math.round(totalGstAmt, 0);

            

            $(totTable).find("span[use=totalAmount]").text((totalAmount).toFixed(2));
            $("div[use=totalAmount]").find("h3[use=totalAmount]").text((totalAmount).toFixed(2));
            $("div[use=totalAmount]").find("h3[use=totalAmount]").attr('theAmount', totalAmount);
            $("div[use=totalAmount]").show();
            $('[use=subtotalAmount]').text(
                '₹ ' + subTotalAmount.toLocaleString('en-IN')
            );
             $('[use=totalGstAmount]').text(
                '₹ ' + totalGstAmt.toLocaleString('en-IN')
            );
            $('[use=totalAmountpay]').text(
                '₹ ' + totalAmount.toLocaleString('en-IN')
            );
           $('#subTotalPrc').text(
                '₹ ' + totalAmount.toLocaleString('en-IN')
            );
            
        }
     
        function getAccommodationDetails(hotel_id) {

            if (hotel_id > 0) {

                //alert(jsBASE_URL);
                var abstractDelegateId = '<?= $delegateId ?>';
                $.ajax({
                    type: "POST",
                    url: jsBASE_URL + 'returnData.process.php',
                    data: 'act=getAccommodationDetailsProfile&hotel_id=' + hotel_id + '&abstractDelegateId=' + abstractDelegateId,
                    async: false,
                    dataType: 'html',
                    success: function(JSONObject) {
                        $('#section7').html(JSONObject);
                        $('.section').removeClass('active');
                        $('#section7').addClass('active');
                    }
                });
            }
        }

        function get_checkin_val(val) {
            if (typeof val !== 'undefined' && val != '') {
                var checkOutVal = $('#accomodation_package_checkout_id').val("");
            }
        }

        function get_checkout_val(val) {
            // alert(val);
            var checkInVal = $('#accomodation_package_checkin_id').val();
            var checkOutVal = val;
            const checkInArray = checkInVal.split("/");
            var checkInID = checkInArray[0];
            var checkInDate = checkInArray[1];

            const checkOutArray = checkOutVal.split("/");
            var checkOutID = checkOutArray[0];
            var checkOutDate = checkOutArray[1];

            var date1 = new Date(checkInDate);
            var date2 = new Date(checkOutDate);

            // Calculate the difference in milliseconds
            var differenceMs = Math.abs(date2 - date1);

            // Convert the difference to days
            var differenceDays = Math.ceil(differenceMs / (1000 * 60 * 60 * 24));

            var totalAmount = 0;
            var totTable = $("table[use=totalAmountTable]");
            $(totTable).children("tbody").find("tr").remove();
            var gst_flag = $('#gst_flag').val();
            var cloneIt = false;
            $("input[name=package_id]").each(function() {
                if ($(this).prop('checked') == true) {
                    var packageID = $(this).val();
                    var amount = ($(this).attr('amount'));
                    var amountIncludedDay = parseFloat(amount) * parseInt(differenceDays);
                    calculateTotalAmount();

                }
            });


        }



        function getPackageVal(val) {
            if (typeof val !== 'undefined' && val != '') {

                $("input[name='accomodation_package_checkout_id']").prop('checked', false);
                $("input[name='accomodation_package_checkin_id']").prop('checked', false);
                calculateTotalAmount();
            }
        }


        $(document).on("click", "#paynowbtn", function() {

            $('#checkout-main-wrap').show();

        });

        $(document).on("change", "#accommodation_room", function() {

            calculateTotalAmount();
        });

    





        function payNow(section, formName) {

            var form = $("#" + formName);

            var selectedOption = form.find("input[type=radio][name='payment_mode']:checked").val();
            var specSelected = selectedOption + section;
            var flag = 0;

            // alert(specSelected);

            if (selectedOption) {

                form.find("div[use='offlinePaymentOption'][for='" + specSelected + "'] input[type='text'], div[use='offlinePaymentOption'][for='" + specSelected + "'] input[type='date'], div[use='offlinePaymentOption'][for='" + specSelected + "'] input[type='radio'],div[use='offlinePaymentOption'][for='" + specSelected + "'] input[type='file']").each(function() {

                    var form = $(this).closest('form');


                    if ($(this).attr('type') === 'radio') {

                        if (!$("input[type='radio'][name='card_mode']:checked").length) {

                            toastr.error('Please select the card', 'Error', {
                                "progressBar": true,
                                "timeOut": 4000,
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp"
                            });


                            flag = 1;
                            return false;
                        }
                    } else {

                        var textBoxValue = $(this).val();
                        // alert(textBoxValue);
                        if (textBoxValue === '') {
                            toastr.error($(this).attr('validate'), 'Error', {
                                "progressBar": true,
                                "timeOut": 4000,
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp"
                            });


                            flag = 1;
                            return false;


                        }
                    }


                });
            } else {
                //alert("No option selected!");
                toastr.error('Please select payment mode', 'Error', {
                    "progressBar": true,
                    "timeOut": 4000,
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                });

                flag = 1;
            }

            if (flag == 0) {
                //alert(1212);

                $("form[name='" + formName + "']").submit();
            }

        }


        $(document).ready(function() {
            // Get the URL parameters
            var urlParams = new URLSearchParams(window.location.search);

            // Get the value of the 'id' parameter from the URL
            var idParam = urlParams.get('id');

            // Check if the 'id' parameter is empty or not
            if (idParam === null || idParam.trim() === '') {
                console.log("ID parameter is empty or not found in the URL.");
            } else {
                console.log("ID parameter is present and not empty. ID: " + idParam);
                getAccommodationDetails(idParam);
            }
        });
    </script>
   
</html>