<?php

include_once(__DIR__. "/init.php");

include_once("../../includes/icons.php");
include_once('function.php');
include_once('includes/function.workshop.php');
include_once(__DIR__ . "/../../includes/function.registration.php");
include_once(__DIR__. "/../../includes/function.delegate.php");
include_once(__DIR__. "/../../includes/function.invoice.php");
include_once(__DIR__. "/../../includes/function.workshop.php");
include_once(__DIR__. "/../../includes/function.dinner.php");
include_once(__DIR__. "/../../includes/function.accompany.php");
include_once(__DIR__. "/../../includes/function.accommodation.php");
include_once(__DIR__. "/../../includes/function.abstract.php");

// include_once('js-source.php');
// $cfg['SECTION_BASE_URL'] = "https://ruedakolkata.com/natcon_25/conference_registration/webmaster/";
$WorkshopId   = isset($_POST['workshop_id']) ? $_POST['workshop_id'] : null;
$RegClassId   = isset($_POST['registration_classification_id']) ? $_POST['registration_classification_id'] : null;
$title   = isset($_POST['title']) ? $_POST['title'] : null;
$classification   = isset($_POST['classification']) ? $_POST['classification'] : null;
$hotelId   = isset($_POST['hotelId']) ? $_POST['hotelId'] : null;
$hotelTarrifId   = isset($_POST['hotelTarrifId']) ? $_POST['hotelTarrifId'] : null;
$packageId   = isset($_POST['packageId']) ? $_POST['packageId'] : null;
$roomId   = isset($_POST['roomId']) ? $_POST['roomId'] : null;
$editHotelId   = isset($_POST['editHotelId']) ? $_POST['editHotelId'] : null;
$classificationId   = isset($_POST['classificationId']) ? $_POST['classificationId'] : null;
$classId   = isset($_POST['classId']) ? $_POST['classId'] : null;
$accompanyId   = isset($_POST['accompanyId']) ? $_POST['accompanyId'] : null;
$accompanytariffId   = isset($_POST['accompanytariffId']) ? $_POST['accompanytariffId'] : null;
$delegateId   = isset($_POST['userId']) ? $_POST['userId'] : null;
$selectedCutoffId   = isset($_POST['selectedCutoffId']) ? $_POST['selectedCutoffId'] : null;
if($selectedCutoffId!=''){
    $currentCutoffId = $selectedCutoffId;

}else{
    $currentCutoffId = getTariffCutoffId();

}
$edituserId   = isset($_POST['edituserId']) ? $_POST['edituserId'] : null;
$registrationAmount = 	getCutoffTariffAmnt($currentCutoffId);

// // Enable error reporting for debugging
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// // Safely get POST variables
// $WorkshopId   = isset($_POST['workshop_id']) ? $_POST['workshop_id'] : null;
// $RegClassId   = isset($_POST['registration_classification_id']) ? $_POST['registration_classification_id'] : null;

// // Debugging: check if the data is coming through
// echo "<pre>POST received:\n";
// var_dump($_POST);
// var_dump($WorkshopId, $RegClassId);
?>
<style>
    .previewImage {
    max-width: 200px;
    max-height: 200px;
    display: block;
    border: 2px solid red;
}
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script type="text/javascript" language="javascript" src="scripts/registration.tariff.js"></script>
    <script type="text/javascript" language="javascript" src="scripts/registration.js"></script>
	<script type="text/javascript" language="javascript" src="section_login/scripts/CountryStateRetriver.js"></script>
    <script type="text/javascript" language="javascript" src="scripts/registration.js"></script>
    <script type="text/javascript" language="javascript" src="scripts/dinner_registration.js"></script>
    <script type="text/javascript" language="javascript" src="scripts/accompany_registration.js"></script>
    <script>
    var jsBASE_URL	= "<?=_BASE_URL_?>";
    var jsWemaster_BASE_URL	= "<?=$cfg['SECTION_BASE_URL']?>";
    var CFG = { BASE_URL : "<?=_BASE_URL_?>" };
        </script>

<div class="pop_up_wrap">
    <div class="pop_up_inner">
        <!-- profile pop up -->
        <?
            $sqlFetchUser           = registrationDetailsQuerySet($delegateId);
            $resultFetchUser        = $mycms->sql_select($sqlFetchUser);
            $rowFetchUser           = $resultFetchUser[0];

            $loggedUserId			= $mycms->getLoggedUserId();

            // FETCHING LOGGED USER DETAILS
            $sqlSystemUser = array();
            $sqlSystemUser['QUERY']      	= "SELECT * FROM " . _DB_CONF_USER_ . " 
                                                WHERE `a_id` = '" . $loggedUserId . "'";

            $resultSystemUser   	= $mycms->sql_select($sqlSystemUser);
            $rowSystemUser      	= $resultSystemUser[0];
        ?>
        <div class="pop_up_body" id="profile">
            <div class="profile_pop_up">
                <div class="profile_pop_left">
                    <div class="profile_left_box text-center ">
                        <div class="regi_img_circle m-auto">
                            <!-- <img src="" alt="" class="w-100 h-100"> -->
                            <span>AM</span>
                        </div>
                        <h5><?= strtoupper($rowFetchUser['user_full_name']) ?></h5>
                        <h6><?=$rowFetchUser['user_registration_id']?></h6>
                        <div class="regi_type justify-content-center">
                            <span class="badge_padding badge_primary"><?= $rowFetchUser['classification_title'] ?></span>
                        </div>
                    </div>
                    <div class="profile_left_box">
                        <h4>Contact Info</h4>
                        <ul>
                            <li>
                                <?php  email();?>
                                <p>
                                    <b>Email</b>
                                    <span><?= $rowFetchUser['user_email_id'] ?></span>
                                </p>
                            </li>
                            <li>
                                <?php call(); ?>
                                <p>
                                    <b>Phone</b>
                                    <span><?= $rowFetchUser['user_mobile_no'] ?></span>
                                </p>
                            </li>
                            <li>
                                <?php calendar(); ?>
                                <p>
                                    <b>Registered On</b>
                                    <span><?= date('d/m/Y h:i A', strtotime($rowFetchUser['created_dateTime'])) ?></span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="profile_left_box">
                        <h4>Address</h4>
                        <ul>
                            <li>
                                <?php address(); ?>
                                <p>
                                    <b>Location</b>
                                    <span><?= $rowFetchUser['user_address'] ?></span>
                                </p>
                            </li>
                            <li>
                                <i class="fal fa-tags"></i>
                                <p>
                                    <b>Tags</b>
                                    <span><?= $rowFetchUser['tags'] ?></span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="profile_left_box">
                        <div class="profile_uniq_sque">
                            Unique Sequence<span><?=strtoupper($rowFetchUser['user_unique_sequence'])?></span>
                        </div>
                    </div>
                </div>
                <div class="profile_pop_right">
                    <div class="profile_pop_right_heading">
                        <span>Registration Details</span>
                        <p>
                            <!-- <a href="javascript:void(null)" class="icon_hover badge_primary action-transparent"><?php export(); ?></a> -->
                            <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                        </p>
                    </div>
                    <div class="profile_pop_right_body">
                        <?php
                            $sqlFetchInvoice                = getRegistrationInvoiceCancelInvoiceDetails("", $delegateId, "");

                            //echo '<pre>'; print_r($sqlFetchInvoice);																
                            $resultFetchInvoice             = $mycms->sql_select($sqlFetchInvoice);
                            $totalAmountAll = 0;
                            //   echo '<pre>'; print_r($resultFetchInvoice ); echo '</pre>'; 
                            if ($resultFetchInvoice) {
                                foreach ($resultFetchInvoice as $key => $rowFetchInvoice) {
                                    $showTheRecord = true;
                                    $resPaymentDetails      = paymentDetails($rowFetchInvoice['slip_id']);
                                    $resFetchSlip	  = slipDetailsOfUser($delegateId, true);
                                    $invoiceCounter++;
                                    $slip = getInvoice($rowFetchInvoice['slip_id']);
                                    $returnArray    = discountAmount($rowFetchInvoice['id']);
                                    $percentage     = $returnArray['PERCENTAGE'];
                                    $totalAmount    = $returnArray['TOTAL_AMOUNT'];
                                    $discountAmount = $returnArray['DISCOUNT'];

                                    // echo '<pre>'; print_r($totalAmount ); echo '</pre>'; 

                                    $thisUserDetails 	= getUserDetails($rowFetchInvoice[$delegateId]);
                                    $thisUserClasfId 	= getUserClassificationId($rowFetchInvoice[$delegateId]);
                                    $thisUserClasfName 	= getRegClsfName(getUserClassificationId($rowFetchInvoice[$delegateId]));
                            
                                    $totalAmountAll += $totalAmount;
                                }

                            }
                        ?>
                        <ul class="profile_payments_grid_ul">
                            <li>
                                <h6>Total Amount</h6>
                                <h5>₹ <?=$totalAmountAll?></h5>
                            </li>
                            <li>
                                <h6>Payment Status</h6>
                                <?
                                if ($resPaymentDetails['payment_status'] == "PAID") {
                                ?>
                                <h5><span class="mi-1 badge_padding badge_success d-flex w-max-con text-uppercase"><?php paid(); ?>Paid</span></h5>
                                <?
                                }else if($resPaymentDetails['payment_status'] == "UNPAID"){
                                 ?>
                                <h5><span class="mi-1 badge_padding badge_danger d-flex w-max-con text-uppercase"><?php paid(); ?>Unpaid</span></h5>

                                 <?     
                                }
                                else if ($rowFetchSlip['payment_status'] == "COMPLIMENTARY") {
                                ?>
                                <h5><span class="mi-1 badge_padding badge_success d-flex w-max-con text-uppercase"><?php paid(); ?>Complimentary</span></h5>
                                 <?
                                } else {
                                ?>
                                <h5><span class="mi-1 badge_padding badge_success d-flex w-max-con text-uppercase"><?php paid(); ?>Zero Value</span></h5>
                                <?
                                }  
                                ?>
                            </li>
                            <li>
                                <h6>Invoice No.</h6>
                                <h5>NATCON 2025-000334</h5>
                                <small class="text-muted">UPI TXN ID:00000001</small>
                            </li>
                        </ul>
                        <div class="service_breakdown_wrap">
                            <h4><?php windowi(); ?>Invoice Breakdown</h4>
                            <div class="table_wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Service / Item</th>
                                            <th>Invoice Details</th>
                                            <th class="text-right">Amount</th>
                                            <th class="text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                                            $sqlFetchInvoice                = getRegistrationInvoiceCancelInvoiceDetails("", $delegateId, "");

                                            //echo '<pre>'; print_r($sqlFetchInvoice);																
                                            $resultFetchInvoice             = $mycms->sql_select($sqlFetchInvoice);
                                            $totalAmountAll = 0;
                                            //   echo '<pre>'; print_r($resultFetchInvoice ); echo '</pre>'; 
                                            if ($resultFetchInvoice) {
                                                    foreach ($resultFetchInvoice as $key => $rowFetchInvoice) {
                                                        $showTheRecord = true;

                                                        $invoiceCounter++;
                                                        $slip = getInvoice($rowFetchInvoice['slip_id']);
                                                        $returnArray    = discountAmount($rowFetchInvoice['id']);
                                                        $percentage     = $returnArray['PERCENTAGE'];
                                                        $totalAmount    = $returnArray['TOTAL_AMOUNT'];
                                                        $discountAmount = $returnArray['DISCOUNT'];

                                                        // echo '<pre>'; print_r($slip ); echo '</pre>'; 

                                                        $thisUserDetails 	= getUserDetails($rowFetchInvoice[$delegateId]);
                                                        $thisUserClasfId 	= getUserClassificationId($rowFetchInvoice[$delegateId]);
                                                        $thisUserClasfName 	= getRegClsfName(getUserClassificationId($rowFetchInvoice[$delegateId]));
                                                
                                                        $totalAmountAll += $totalAmount;
                                                        
                                                    	$type			 	= "";
                                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "CONFERENCE");
                                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-gift" aria-hidden="true"></i>&nbsp;Conference Registration';
                                                        }
                                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_RESIDENTIAL_REGISTRATION") {
                                                            $isResReg = true;
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "RESIDENTIAL");
                                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-gift" aria-hidden="true"></i>&nbsp;' . $type;

                                                            $sqlAccomm = array();
                                                            $sqlAccomm['QUERY']    = " SELECT accomm.*, hotel.hotel_name
                                                                                            FROM " . _DB_REQUEST_ACCOMMODATION_ . " accomm
                                                                                    INNER JOIN " . _DB_MASTER_HOTEL_ . " hotel
                                                                                            ON accomm.hotel_id = hotel.id
                                                                                            WHERE accomm.`user_id` = ?
                                                                                            AND accomm.`refference_invoice_id` = ?";
                                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'user_id',  				'DATA' => $delegate_id,  			'TYP' => 's');
                                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'refference_invoice_id',  	'DATA' => $rowFetchInvoice['id'],  	'TYP' => 's');
                                                            $resAccomm = $mycms->sql_select($sqlAccomm);

                                                            foreach ($resAccomm as $kk => $row) {
                                                                $serviceSummary[$rowFetchInvoice['id'] . 'accm'] = '';

                                                                $accommodationRecords[$rowFetchInvoice['id']]['KEY'] 			= $rowFetchInvoice['id'] . 'accm';
                                                                $accommodationRecords[$rowFetchInvoice['id']]['BOOK-TYP'] 		= 'RES-PACK';
                                                                $accommodationRecords[$rowFetchInvoice['id']]['accomId'] 		= $row['id'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['packageId']	 	= $cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'] 	= $row['hotel_name'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['checkin_date'] 	= $row['checkin_date'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['checkout_date'] 	= $row['checkout_date'];

                                                                $accommodationRecords[$rowFetchInvoice['id']]['WILL-SHARE'] 	= false;
                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE'] 			= array();

                                                                //$serviceSummary[$rowFetchInvoice['id'].'accm'] = '<i class="fa fa-building" aria-hidden="true" style="cursor:pointer;" onClick="openAccmDateEditPopup(this)" accomId="'.$row['id'].'" packageId="'.$cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId].'"></i>&nbsp;Accommodation @ '.$row['hotel_name'].' <span style="font-size:12px;">['.$row['checkin_date'].' to '.$row['checkout_date'].']</span>';

                                                                if (in_array($thisUserClasfId, $cfg['RESIDENTIAL_SHARING_CLASF_ID'])) {
                                                                    $accommodationRecords[$rowFetchInvoice['id']]['WILL-SHARE'] 			= true;
                                                                    $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['KEY'] 			= $rowFetchInvoice['id'] . 'accmshr';
                                                                    $serviceSummary[$rowFetchInvoice['id'] . 'accmshr']						= '';

                                                                    if (trim($row['preffered_accommpany_name']) != '') {
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['accomId'] 		= $row['id'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefName'] 		= $row['preffered_accommpany_name'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefMobile'] 	= $row['preffered_accommpany_mobile'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefEmail'] 	= $row['preffered_accommpany_email'];
                                                                        /*$serviceSummary[$rowFetchInvoice['id'].'accmshr'] = '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o" aria-hidden="true" style="cursor:pointer;" onClick="openSharePrefEditPopup(this)" accomId="'.$row['id'].'" prefName="'.$row['preffered_accommpany_name'].'"  prefMobile="'.$row['preffered_accommpany_mobile'].'"  prefEmail="'.$row['preffered_accommpany_email'].'"></i>&nbsp;'.$row['preffered_accommpany_name'].'<br>
                                                                                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;'.$row['preffered_accommpany_mobile'].'<br>
                                                                                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;'.$row['preffered_accommpany_email'].'';*/
                                                                    } else {
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['accomId'] = $row['id'];
                                                                        //$serviceSummary[$rowFetchInvoice['id'].'accmshr'] = '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o" aria-hidden="true" style="cursor:pointer;" onClick="openSharePrefEditPopup(this)" accomId="'.$row['id'].'"></i>&nbsp;-';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION") {
                                                            $workShopDetails = getWorkshopDetails($rowFetchInvoice['refference_id'], true);
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "WORKSHOP");
                                                            if ($workShopDetails['showInInvoices'] != 'Y') {
                                                                $showTheRecord 		= false;
                                                            }
                                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp;' . $workShopDetails['classification_title'];
                                                        }
                                                        if ($rowFetchInvoice['service_type'] == "ACCOMPANY_CONFERENCE_REGISTRATION") {
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "ACCOMPANY");
                                                            $accompanyDetails = getUserDetails($rowFetchInvoice['refference_id']);
                                                            if ($accompanyDetails['registration_request'] == 'GUEST') {
                                                                $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-smile-o" aria-hidden="true"></i>&nbsp;Accompaning Guest - ' . $accompanyDetails['user_full_name'];
                                                            } else {
                                                                $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-users" aria-hidden="true"></i>&nbsp;Accompany - ' . $accompanyDetails['user_full_name'];
                                                            }
                                                        }
                                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_ACCOMMODATION_REQUEST") {
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "ACCOMMODATION");
                                                            //$serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-building" aria-hidden="true"></i>&nbsp;Accomodation';

                                                            //$showTheRecord = false;
                                                            $sqlAccomm = array();
                                                            $sqlAccomm['QUERY']    = " SELECT accomm.*, hotel.hotel_name
                                                                                            FROM " . _DB_REQUEST_ACCOMMODATION_ . " accomm
                                                                                    INNER JOIN " . _DB_MASTER_HOTEL_ . " hotel
                                                                                            ON accomm.hotel_id = hotel.id
                                                                                            WHERE accomm.`user_id` = ?
                                                                                            AND accomm.`refference_invoice_id` = ?";
                                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'user_id',  				'DATA' => $delegate_id,  			'TYP' => 's');
                                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'refference_invoice_id',  	'DATA' => $rowFetchInvoice['id'],  	'TYP' => 's');
                                                            $resAccomm = $mycms->sql_select($sqlAccomm);
                                                            //echo "<pre>";print_r($resAccomm);echo "</pre>";
                                                            foreach ($resAccomm as $kk => $row) {
                                                                $accommodationRecords[$rowFetchInvoice['id']]['BOOK-TYP'] = 'ACCOMMODATION';
                                                                $accommodationRecords[$rowFetchInvoice['id']]['accomId'] = $row['id'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['packageId'] = $row['package_id'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'] = $row['hotel_name'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['checkin_date'] = $row['checkin_date'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['checkout_date'] = $row['checkout_date'];
                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE'] = array();
                                                                //$serviceSummary[$rowFetchInvoice['id'].'accm'] = '<i class="fa fa-building" aria-hidden="true" style="cursor:pointer;" onClick="openAccmDateEditPopup(this)" accomId="'.$row['id'].'" packageId="'.$cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId].'"></i>&nbsp;Accommodation @ '.$row['hotel_name'].' <span style="font-size:12px;">['.$row['checkin_date'].' to '.$row['checkout_date'].']</span>';
                                                            }

                                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-building" aria-hidden="true"></i>&nbsp;Accommodation @ ' . $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'];
                                                        }
                                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_TOUR_REQUEST") {
                                                            $tourDetails = getTourDetails($invoiceDetails['refference_id']);
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "TOUR");
                                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-bus" aria-hidden="true"></i>&nbsp;Tour';
                                                        }
                                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_DINNER_REQUEST") {
                                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "DINNER");
                                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Dinner';
                                                        }
                                                        if (isset($rowFetchInvoice['Refund_status']) && $rowFetchInvoice['Refund_status'] == 'Not_refunded') {
                                                            $rowBackGround = "#FFFFCA";
                                                        } elseif (isset($rowFetchInvoice['Refund_status']) && $rowFetchInvoice['Refund_status'] == 'Refunded') {
                                                            $rowBackGround = "#FFCCCC";
                                                        } else {
                                                            $rowBackGround = "#FFFFFF";
                                                        }

                                                        if ($rowFetchInvoice['payment_status'] == "COMPLIMENTARY") {
                                                            $payment_status = ' <span style="color:#5E8A26;">Complimentary</span>';
                                                        ?>
                                                        <?php
                                                        } elseif ($rowFetchInvoice['payment_status'] == "ZERO_VALUE") {
                                                            $payment_status =' <span style="color:#009900;">Zero Value</span>';
                                                        ?>
                                                        <?php
                                                        } else if ($rowFetchInvoice['payment_status'] == "PAID") {
                                                            if (!($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION" && $workShopDetails['display'] == 'N')) {
                                                                $totalPaid += $totalAmount;
                                                            }
                                                            $paymentModeDisplay = $resPaymentDetails['payment_mode'] == 'NEFT' ? 'NEFT/UPI' : ($resPaymentDetails['payment_mode'] == 'Cheque' ? 'Cheque/DD' : $resPaymentDetails['payment_mode']);
                                                            $payment_status = ' <span style="color:#5E8A26;">Paid</span>';
                                                        } else if ($rowFetchInvoice['payment_status'] == "UNPAID") {
                                                            $hasUnpaidBill	 = true;
                                                            $totalUnpaid 	+= $totalAmount;
                                                            $payment_status= ' <span style="color:#C70505;">Unpaid</span>';
                                                        ?>
                                                        <?php
                                                        }

                                                        // if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                                            
                                            ?>
                                        <tr>
                                            <td>
                                                <?=$type?><br>
                                                <small class="text-muted"><?= $slip['slip_number'] ?></small>
                                            </td>
                                            <td>
                                                <?= $rowFetchInvoice['invoice_number'] ?> <span class="badge_padding badge_dark"><?= $rowFetchInvoice['invoice_mode'].  ' ('.$rowFetchUser['reg_type'].')'?></span><br>
                                                <small class="text-muted"><?= $rowFetchInvoice['invoice_date'] ?></small>
                                            </td>
                                            <td class="text-right">
                                                <?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmount, 2) ?>
                                            </td>
                                            <td class="text-right">
                                                 <?
                                                    if ($rowFetchInvoice['payment_status'] == "PAID") {
                                                    ?>
                                                    <span class="mi-1 badge_padding badge_success d-flex w-max-con text-uppercase"><?php paid(); ?>Paid</span>
                                                    <?
                                                    }else if($rowFetchInvoice['payment_status'] == "UNPAID"){
                                                    ?>
                                                    <span class="mi-1 badge_padding badge_danger d-flex w-max-con text-uppercase"><?php paid(); ?>Unpaid</span>

                                                    <?     
                                                    }
                                                    else if ($rowFetchInvoice['payment_status'] == "COMPLIMENTARY") {
                                                    ?>
                                                    <span class="mi-1 badge_padding badge_success d-flex w-max-con text-uppercase"><?php paid(); ?>Complimentary</span>
                                                    <?
                                                    } else {
                                                    ?>
                                                    <span class="mi-1 badge_padding badge_success d-flex w-max-con text-uppercase"><?php paid(); ?>Zero Value</span>
                                                    <?
                                                    }  
                                                    ?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- profile pop up -->
        <!-- New Registration pop up -->
        <div class="pop_up_body" id="newregistartion">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>New Registration<i class="ml-1 badge_padding badge_dark"></i></span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
               <form class="body-frm" name="registrationForm" enctype="multipart/form-data" method="post" autocomplete="off" action="<?= _BASE_URL_ ?>registration.process.php">
                    <input type="hidden" id="actInput" name="act" value="combinedRegistrationProcess" />
                    <input type="hidden" name="abstractDelegateId" value="<?= $_REQUEST['delegateId'] ?>" />
                     <input type="hidden" id="cutoff_id" name="cutoff_id" value="<?= $currentCutoffId ?>" />
                    <input type="hidden" name="reg_area" value="BACK" />
                    <input type="hidden" name="registration_request" id="registration_request" value="GENERAL" />
                    <input type="hidden" name="registration_Pay_mode" id="registration_Pay_mode" value="GENERAL" />
                    <!-- <input type="hidden" name="registration_cutoff" id="registration_cutoff" value="<?= $currentCutoffId ?>" /> -->
                    <input type="hidden" name="abstractDelegateId" id="abstractDelegateId" value="<?= $abstractDelegateId ?>" />
                    <input type="hidden" name="gst_flag" id="gst_flag" value="<?= $cfg['GST.FLAG'] ?>" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner noWorkshop">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php calendar(); ?>Conference Details</span>
                            </h4>
                            <?
                                $sqlConfDate = array();
                                $sqlConfDate['QUERY']    = " SELECT MIN(conf_date) AS startDate, MAX(conf_date) AS endDate
                                                                FROM " . _DB_CONFERENCE_DATE_ . " 
                                                                WHERE `status` = ?";
                                $sqlConfDate['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
                                $resConfDate = $mycms->sql_select($sqlConfDate);
                                $rowConfDate = $resConfDate[0];

                                $cutoffArray  = array();
                                $sqlCutoff['QUERY']    = " SELECT * 
                                                                FROM " . _DB_TARIFF_CUTOFF_ . " 
                                                                WHERE `status` = ? 
                                                            ORDER BY `cutoff_sequence` ASC";
                                $sqlCutoff['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
                                $resCutoff = $mycms->sql_select($sqlCutoff);
                                if ($resCutoff) {
                                    foreach ($resCutoff as $i => $rowCutoff) {
                                        $cutoffArray[$rowCutoff['id']] = $rowCutoff['cutoff_title'];
                                    }
                                }

                                $workshopCutoffArray  = array();
                                $sqlWorkshopCutoff['QUERY']    = " SELECT * 
                                                                FROM " . _DB_WORKSHOP_CUTOFF_ . " 
                                                                WHERE `status` = ? 
                                                            ORDER BY `cutoff_sequence` ASC";
                                $sqlWorkshopCutoff['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
                                $resWorkshopCutoff = $mycms->sql_select($sqlWorkshopCutoff);
                                if ($resWorkshopCutoff) {
                                    foreach ($resWorkshopCutoff as $i => $rowWorkshopCutoff) {
                                        $workshopCutoffArray[$rowWorkshopCutoff['id']] = $rowWorkshopCutoff['cutoff_title'];
                                    }
                                }

                           
                                $currentWorkshopCutoffId = getWorkshopTariffCutoffId();

                                $conferenceTariffArray   = getAllRegistrationTariffs("", false);

                                $workshopDetailsArray 	 = getAllWorkshopTariffs();
                                $workshopCountArr 		 = totalWorkshopCountReport();

                                $userREGtype           	 = $_REQUEST['userREGtype'];
                                $abstractDelegateId      = $_REQUEST['delegateId'];
                                $userRec 		         = getUserDetails($abstractDelegateId);

                                // echo "<pre>"; print_r($workshopDetailsArray); die;

                            ?>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Registration Cutoff</p>
                                    <!-- <div class="cus_check_wrap">
                                        <?
                                        if ($cutoffArray) {
												foreach ($cutoffArray as $cutoffId => $cutoffName) {
                                                $checked = ($cutoffId == $currentCutoffId) ? 'checked' : '';
                                                 $currency = getRegistrationCurrency($cutoffId);
                                                 $amount = getCutoffTariffAmnt($cutoffId);
											?>
                                        <label class="cus_check mode_check mode_check_reg" data-tab="<?=$cutoffId?>">
                                            <input type="radio" name="registration_cutoff"  data-currency="<?=$currency ?>"   data-amount="<?=$amount?>" value="<?=$cutoffId?>" operationMode='regCutoff' required <?= $checked; ?>>
                                            <span class="checkmark"><?= $cutoffName ?></span>
                                        </label>
                                        <?php
                                                }
                                        }
                                        ?>
                                    </div> -->
                                     <div class="hotel_link_owl owl-carousel owl-theme">
                                         <?
                                        if ($cutoffArray) {
												foreach ($cutoffArray as $cutoffId => $cutoffName) {
                                                $checked = ($cutoffId == $currentCutoffId) ? 'checked' : '';
                                                 $currency = getRegistrationCurrency($cutoffId);
                                                 $amount = getCutoffTariffAmnt($cutoffId);
											?>
                                           <label class="cus_check mode_check mode_check_reg" data-tab="<?=$cutoffId?>">
                                                <input type="radio" name="registration_cutoff"  data-currency="<?=$currency ?>"   data-amount="<?=$amount?>" value="<?=$cutoffId?>" operationMode='regCutoff' required <?= $checked; ?>>
                                                <span class="checkmark"><?= $cutoffName ?></span>
                                            </label>
                                         <?php
                                                }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Select Category</p>
                                    <?
                                    foreach ($cutoffArray as $cutoffId => $cutoffName) {
                                        $display = ($cutoffId == $currentCutoffId) ? 'block' : 'none';
                                        
                                    ?>
                                    <div class="regi_category" id="<?=$cutoffId?>" style="display: <?= $display ?>;">
                                        <div class="cus_check_wrap flex-column">
                                            <?
                                           	if ($conferenceTariffArray) {
												foreach ($conferenceTariffArray as $key => $registrationDetailsVal) {
                                                    // encode all cutoff prices for this category
                                                    $tariffsJson = htmlspecialchars(json_encode($registrationDetailsVal), ENT_QUOTES, 'UTF-8');

                                                    $rowCutoff = $registrationDetailsVal[$cutoffId];
                                                    // $RegistrationTariffDisplay = $rowCutoff['CURRENCY'] . "&nbsp;" . $rowCutoff['AMOUNT'];
                                                      $RegistrationTariffDisplay = floatval($rowCutoff['AMOUNT']) > 0
                                                        ? $rowCutoff['CURRENCY']  ."&nbsp;" .$rowCutoff['AMOUNT']
                                                        : "Complimentary";
                                                                                                
                                            ?>
                                            <label class="cus_check category_check">
                                                <input type="radio"  name="registration_classification_id[]"  tariffAmount="<?= $rowCutoff['AMOUNT'] ?>" operationMode="registration_tariff" value="<?=$key?>" currency="<?= $registrationDetailsVal[1]['CURRENCY'] ?>" registrationType="<?= $classificationType ?>" accommodationPackageId="<?= $residentialAccommodationPackageId[$key] ?>" checked>
                                                <span class="checkmark"><?= getRegClsfName($key) ?><i><?= $RegistrationTariffDisplay ?></i></span>
                                            </label>
                                             <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?
                         if ((!empty($workshopDetailsArray))  && $currentWorkshopCutoffId > 0) {
                         ?>
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php workshop(); ?>Workshops<label class="toggleswitch">
                                        <input  id="workshopToggle"  class="toggleswitch-checkbox" type="checkbox">
                                        <div class="toggleswitch-switch"></div>Only Workshop
                                    </label></span>
                               <a href="#" class="add mi-1" id="selectAllWorkshops">
                                    <?php check(); ?> Select All
                                </a>
                            </h4>
                                <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Workshop Cutoff</p>
                                    <div class="cus_check_wrap">
                                        <?
                                        if ($workshopCutoffArray) {
												foreach ($workshopCutoffArray as $cutoffId => $cutoffName) {
                                                $checked = ($cutoffId == $currentWorkshopCutoffId) ? 'checked' : '';
											?>
                                        <label class="cus_check mode_check mode_check_work" data-tab="<?=$cutoffId?>">
                                            <input type="radio"  name="workshop_cutoff" operationMode='workshopCutoff'  value="<?=$cutoffId?>" required <?= $checked; ?>>
                                            <span class="checkmark"><?= $cutoffName ?></span>
                                            <!-- Hidden checkboxes for Only Workshop -->
                                            <input type="radio" name="registration_classification_id[]" operationMode="registration_tariff" spUse="regClsId" value="8" accommodationPackageId="0" style="display:none" />
                                        </label>
                                        <?php
                                                }
                                        }
                                        ?>
                                    </div>
                                </div>
       
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Select Workshops</p>
                                    <?
                                    foreach ($workshopCutoffArray as $cutoffId => $cutoffName) {
                                        $display = ($cutoffId == $currentWorkshopCutoffId) ? 'block' : 'none';
                                    ?>
                                    <div class="work_category" id="<?=$cutoffId?>" style="display: <?= $display ?>;">
                                        <div class="cus_check_wrap flex-column">
                                            <?
                                           	if ($workshopDetailsArray) {
												foreach ($workshopDetailsArray as $keyWorkshopclsf => $rowWorkshopclsf) {
                                                    // encode all cutoff prices for this category
                                                    // $tariffsJson = htmlspecialchars(json_encode($rowWorkshopclsf), ENT_QUOTES, 'UTF-8');
													foreach ($rowWorkshopclsf as $keyRegClasf => $rowRegClasf) {

                                                        $cutoffvalue = $rowRegClasf[$cutoffId];
                                                        $WorkshopTariffDisplay = $cutoffvalue['CURRENCY'] . "&nbsp;" . $cutoffvalue[$cutoffvalue['CURRENCY']];
                                                        if ($cutoffvalue[$cutoffvalue['CURRENCY']] <= 0) {
                                                            $WorkshopTariffDisplay = "Included in Registration";
                                                        }     
                                                        // echo "<pre>";
                                                        // print_r($keyRegClasf);
                                                        //  print_r($rowWorkshopclsf);
                                                        if ($cutoffvalue['WORKSHOP_TYPE']) {
                                                                $workshopCount = $workshopCountArr[$keyWorkshopclsf]['TOTAL_LEFT_SIT'];
                                                    
                                                                if ($workshopCount < 1) {
                                                                    $style = 'disabled="disabled"';
                                                                    $span	= '<span class="tooltiptext">No More Seat Available For This Workshop</span>';
                                                                } else {
                                                                    $style = '';
                                                                    $span	= '';
                                                                }           
                                                                $workshopDate = $mycms->cDate('Y-m-d', getWorkshopDate($keyWorkshopclsf));
                                                                                
                                                ?>
                                                <label class="cus_check category_check workshop_check" use="<?= $keyRegClasf ?>" style="display:none">
                                                    <input type="checkbox" operationMode='workshopId' data-type="<?= $cutoffvalue['WORKSHOP_TYPE'] ?>" data-date="<?= $workshopDate ?>" <?= $style ?> name="workshop_id[]"  tariffAmount="<?= $cutoffvalue[$cutoffvalue['CURRENCY']] ?>" tariffCurrency="<?= $cutoffvalue['CURRENCY'] ?>" value="<?= $keyWorkshopclsf ?> ">
                                                    <span class="checkmark" ><?=getWorkshopName($keyWorkshopclsf). ' (' . $mycms->cDate('m-d-Y', getWorkshopDate($keyWorkshopclsf)) . ')'?><i><?=$WorkshopTariffDisplay?></i></span>
                                                </label>
                                                <?php
                                                }
                                                }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="cus_check_wrap flex-column">
                                <label class="cus_check category_check workshop_check">
                                    <input type="radio" name="workshop1">
                                    <span class="checkmark">TB & Critical Care Workshop<i>₹ 4000</i></span>
                                </label>
                                <label class="cus_check category_check workshop_check">
                                    <input type="radio" name="workshop2">
                                    <span class="checkmark">TB & Critical Care Workshop<i>₹ 4000</i></span>
                                </label>
                            </div> -->
                            
                        </div>
                        <? } ?>
                        <!-- <div class="registration-pop_body_box_inner noWorkshop">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php hotel(); ?>Accommodation</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Hotel</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check In</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check Out</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Room Type</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="roomtype">
                                            <span class="checkmark">Room Type 1</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="roomtype">
                                            <span class="checkmark">Room Type 2</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Package Type</p>
                                    <div class="cus_check_wrap flex-column">
                                        <label class="cus_check category_check">
                                            <input type="radio" name="packagetype">
                                            <span class="checkmark">Individual<i>₹ 4000</i></span>
                                        </label>
                                        <label class="cus_check category_check">
                                            <input type="radio" name="packagetype">
                                            <span class="checkmark">Sharing<i>₹ 2500</i></span>
                                        </label>
                                    </div>
                                </div>
                                <p class="frm-head span_4 mb-0 text_info"><i class="fal fa-exclamation-circle mr-2"></i>Room rates are per night and exclusive of GST.</p>
                                <div class="span_4">
                                    <h6 class="due_balance d-flex justify-content-between align-items-center badge_info py-2 px-2">Amount<span class="text-white mt-0">₹ 12,980</span></h6>
                                </div>
                            </div>
                        </div> -->
                        <?php
                        $hasDinnerAmount = false;
                        $dinnerTariffArray   = getAllDinnerTarrifDetails($currentCutoffId);
                        foreach ($dinnerTariffArray as $dinnerValue) {
                           
                            if (isset($dinnerValue[$currentCutoffId]['AMOUNT']) && $dinnerValue[$currentCutoffId]['AMOUNT'] > 0) {
                                $hasDinnerAmount = true;
                                
                                break; // No need to check further, we found a valid amount
                            }
                        }
                        // echo '<pre>'; print_r($dinnerTariffArray);

                         if ($hasDinnerAmount){
                        ?>
                        <div class="registration-pop_body_box_inner noWorkshop">
                            <?php
                               $dinnerTariffArray   = getAllDinnerTarrifDetails($currentCutoffId);
                            ?>
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php dinner(); ?>Gala Dinner</span>
                            </h4>
                            <div class="form_grid">
                                 <div class="frm_grp span_4">
                                    <p class="frm-head">Select Dinner</p>
                                    <?
                                     foreach ($dinnerTariffArray as $keyDinner => $dinnerValue) {
                                        // $display = ($cutoffId == $currentWorkshopCutoffId) ? 'block' : 'none';
                                    ?>
                                    <div class="dinner_category" >
                                        <div class="cus_check_wrap flex-column">
                                            <?
                                            foreach ($cutoffArray as $cutoffId => $cutoffName) {
                                                    $displayDinner = ($cutoffId == $currentCutoffId) ? 'block' : 'none';

                                           	 if ($dinnerValue[$cutoffId]['AMOUNT'] > 0) {
												  ?>
                                               <label class="cus_check category_check workshop_check dinner_check" use="<?= $cutoffId ?>" style="display: <?= $displayDinner ?>;">
                                                <input type="checkbox"
                                                    operationMode="dinnerTariffTr"
                                                    <?= $style ?>
                                                    name="dinner_value[]"
                                                    value="<?= $dinnerValue[$cutoffId]['ID'] ?>"
                                                    tariffAmount="<?= $dinnerValue[$cutoffId]['AMOUNT'] ?>"
                                                    tariffCurrency="<?= $cutoffvalue['CURRENCY'] ?>">

                                                <span class="checkmark">
                                                    <?= $dinnerValue[$cutoffId]['DINNER_TITTLE'] ?>
                                                    (<?= $mycms->cDate('m-d-Y', $dinnerValue[$cutoffId]['DATE']) ?>)
                                                    &nbsp;—&nbsp;
                                                    <strong>₹ <?= $dinnerValue[$cutoffId]['AMOUNT'] ?></strong>
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
                                    ?>
                                    <div class="span_4">
                                            <h6 class="due_balance d-flex justify-content-between align-items-center badge_info py-2 px-2">Amount<span class="text-white mt-0" use="TOTDinner">₹ 0.00</span></h6>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php user(); ?>Delegate Profile</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_1">
                                    <p class="frm-head">Title</p>
                                    <select name="user_initial_title" id="user_initial_title" tabindex="4" required>
										<option value="Dr" selected="selected">Dr</option>
										<option value="Prof">Prof</option>
										<option value="Mr">Mr</option>
										<option value="Ms">Ms</option>
									</select>
                                </div>
                                <div class="frm_grp span_3">
                                    <p class="frm-head">First Name <i class="mandatory">*</i></p>
                                    <input type="text" name="user_first_name" id="user_first_name" tabindex="5" value="<?= ($userRec['user_first_name'] != '') ? ($userRec['user_first_name']) : '' ?>" required />
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Middle Name</p>
                                   	<input type="text" name="user_middle_name" id="user_middle_name"  value="<?= ($userRec['user_middle_name'] != '') ? ($userRec['user_middle_name']) : '' ?>" implementvalidate="y" tabindex="6" />
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Last Name <i class="mandatory">*</i></p>
                                    <input type="text" name="user_last_name" id="user_last_name" tabindex="7"  value="<?= ($userRec['user_last_name'] != '') ? ($userRec['user_last_name']) : '' ?>" required implementvalidate="y" />
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Email Address <i class="mandatory">*</i></p>
                                    <input type="email" name="user_email_id" id="user_email_id" forType="emailValidate" value="<?= ($userRec['user_email_id'] != '') ? ($userRec['user_email_id']) : '' ?>" tabindex="1" required />
									<input type="hidden" name="email_id_validation" id="email_id_validation" />
									<input type="hidden" name="abstractDelegateId" id="abstractDelegateId" />
                                        &nbsp;&nbsp; <div style="padding:10px" id="email_div"></div>
                                </div>
                                
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Mobile Number <i class="mandatory">*</i></p>
                                    <input type="hidden" name="user_usd_code" id="user_mobile_isd_code"  tabindex="2" value="<?= ($userRec['user_mobile_isd_code'] != '') ? ($userRec['user_mobile_isd_code']) : '+91' ?>" required /> 
									<input type="tel" name="user_mobile" id="user_mobile_no" forType="mobileValidate"  pattern="^\d{10}$" tabindex="3" value="<?= ($userRec['user_mobile_no'] != '') ? ($userRec['user_mobile_no']) : '' ?>" required />
									<input type="hidden" name="mobile_validation" id="mobile_validation" />
                                    &nbsp;&nbsp; <div style="padding:10px" id="mobile_div"></div>
                                </div>
                                <!-- <div class="frm_grp span_4">
                                    <p class="frm-head">Institute / Org</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">GST Number</p>
                                    <input>
                                </div> -->
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Gender</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input  type="radio"  name="user_gender" id="user_gender_male" checked="checked" value="MALE" tabindex="8" required >
                                            <span class="checkmark">Male</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="user_gender" id="user_gender_female" value="FEMALE" tabindex="9" required >
                                            <span class="checkmark">Female</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Food</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="user_food_preference" id="user_food_preference_veg" checked="checked" value="VEG" tabindex="15">
                                            <span class="checkmark">Veg</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio"  name="user_food_preference" id="user_food_preference_non_veg" value="NON VEG" tabindex="16" >
                                            <span class="checkmark">Non Veg</span>
                                            <input type="hidden" name="gst_flag" id="gst_flag" value="<?= $cfg['GST.FLAG']; ?>">
									        <input type="hidden" name="service_tax_percentage" id="service_tax_percentage" value="<?= $cfg['SERVICE.TAX.PERCENTAGE']; ?>">

                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner ">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php address(); ?>Address Details</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Full Address</p>
                                    <input  name="user_address" id="user_address" >
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country</p>
                                   <select required implementvalidate="y" name="user_country" id="user_country" forType="countryState" stateId="user_state" onchange="stateRetriver(this);" tabindex="11" sequence="1">
										<option value="">-- Select Country --</option>
										<?php
										$sqlCountry['QUERY']    = "SELECT * FROM " . _DB_COMN_COUNTRY_ . " 
																	           WHERE `status` = 'A' 
											                                ORDER BY `country_name`";
										$resultCountry = $mycms->sql_select($sqlCountry);
										if ($resultCountry) {
											foreach ($resultCountry as $i => $rowFetchUserCountry) {
										?>
												<option value="<?= $rowFetchUserCountry['country_id'] ?>" <?= ($rowFetchUserCountry['country_id'] == $userRec['user_country_id']) ? 'selected' : '' ?>><?= $rowFetchUserCountry['country_name'] ?></option>
												<!-- -- FOR DEFAULT INDIA ---------- -->
												<!-- <option value="<?= $rowFetchUserCountry['country_id'] ?>" <?= ($rowFetchUserCountry['country_id'] == '1') ? 'selected' : '' ?>><?= $rowFetchUserCountry['country_name'] ?></option> -->
										<?php
											}
										}
										?>

										<? //getCountryList("1") 
										?>
									</select>
									<?
									if ($userRec['user_country_id'] != '') {
										// if ($userRec['user_country_id'] == '') {
									?>
										<script>
                                            
											$(document).ready(function() {
												jBaseUrl = jsBASE_URL;
												generateSateList(<?= $userRec['user_country_id'] ?>, jBaseUrl);
												$('#user_state option[value="<?= $userRec['user_state_id'] ?>"]').prop('selected', true);
                                                console.log($userRec['user_state_id']);
												//------- FOR DEFAULT WEST BENGAL -------
												// generateSateList(1, jBaseUrl);
												// $('#user_state option[value="730"]').prop('selected', true);
											});
										</script>
									<?php
									}
									?>
                                </div>
                                <div class="frm_grp span_2"  use='stateContainer'>
                                    <p class="frm-head">State</p>
                                    <select name="user_state" id="user_state" forType="state" tabindex="12" sequence="1" disabled="disabled" required implementvalidate="y">
											<option value="">-- Select Country First --</option>
											<!-- <option value="730">WEST BENGAL</option> -->
										</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">City</p>
                                   	<input type="text" name="user_city" id="user_city" tabindex="13"  value="<?= ($userRec['user_city'] != '') ? ($userRec['user_city']) : '' ?>" required implementvalidate="y" />
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Pincode</p>
									<input type="text" name="user_postal_code" id="user_postal_code" tabindex="14" value="<?= ($userRec['user_pincode'] != '') ? ($userRec['user_pincode']) : '' ?>"  required implementvalidate="y" />
                                </div>
                            </div>
                        </div>
                         <?
                        if ($registrationAmount != '' && $registrationAmount > 0) {
                            ?>
                        <div class="registration-pop_body_box_inner noWorkshop">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php duser(); ?>Accompanying (1)</span>
                                <a class="add mi-1" id="add_accompany_1"><?php add(); ?>Add</a>
                            </h4>
                            <div class="accm_add_wrap" id="accm_add_wrap_5">
                                <h6 class="accm_add_empty"  id="accm_add_empty5">No accompanying persons</h6>
                                <div class="accm_add_box accm_add_acco_box"  id="package_box5">
                                    <?php
                                    	$registrationAmount = 	getCutoffTariffAmnt($currentCutoffId);
                                        $accompanyIndex = 0;
                                    ?>
                                    <div class="form_grid">
                                        <div class="frm_grp span_4">
                                          <input type="text" 
                                            operationMode="accompany_relationship" 
                                            name="accompany_name_add[<?= $accompanyIndex ?>]"  onkeyup="calculateRegistrationTariff(this)">
                                             <input type="hidden" name="accompany_selected_add[<?= $accompanyIndex ?>]" value="0" />
                                             <input type="checkbox" style="display:none;" class="accompanyCount" name="accompanyCount" id="accompanyCount" use="accompanyCountSelect" value="1" amount="<?= $registrationAmount ?>" invoiceTitle="Accompanying Person" invoiceName="" icon="<?= $accompanyingIcon ?>" reg="accompany">

                                        </div>
                                        <div class="frm_grp span_2">
                                            <div class="cus_check_wrap">
                                                <label class="cus_check gender_check">
                                                    <input type="radio"  name="accompany_food_choice[<?= $accompanyIndex ?>]">
                                                    <span class="checkmark">Veg</span>
                                                </label>
                                                <label class="cus_check gender_check">
                                                    <input type="radio" name="accompany_food_choice[<?= $accompanyIndex ?>]">
                                                    <span class="checkmark">Non Veg</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span_2">
                                            <h6 class="due_balance d-flex justify-content-center align-items-center badge_info py-2 px-2 accompanyTariffAmount"><span class="text-white mt-0"  id="accompanyTariffAmount"><?= getRegistrationCurrency($currentCutoffId) ?> <?=$registrationAmount?></span></h6>
                                        </div>
                                        <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                        <input type="hidden" name="accompanyAmount" id="accompanyAmount" value="<?= $registrationAmount ?>">
                                        <input type="hidden" name="accompanyTariffAmount" id="accompanyTariffAmount" value="<?= $registrationAmount ?>">
                                        <input type="hidden" name="accompanyCounts" id="accompanyCounts" value="1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <? } ?>
                    </div>
                    <div class="registration-pop_body_box">


                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php bill(); ?>Bill Summary</span>
                            </h4>
                            <!-- <p class="frm-head text_dark d-flex justify-content-between align-items-center">Registration (Regular) <span class="text-white">₹ 4,000</span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Registration (Regular) <span class="text-white">₹ 4,000</span></p> -->
                            <div id="billSummaryItems"></div>

                            <hr class="my-3" style="height: 0;border-top: 1px dashed currentColor;background: transparent;">
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Discount <span class="text-white">₹ <input class="dis_input" type="number" id="discountAmount" name="discountAmount" operationMode="discountAmount"></span></p>
                            <hr class="my-3" style="height: 0;border-top: 1px dashed currentColor;background: transparent;">
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Subtotal <span class="text-white" use="TOTAMT">₹ 0.00</span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">GST (18%) <span class="text-white"  use="TOTAMTGST">₹ 0.00</span></p>
                            <h5 class="regi_total">
                                Total<span  use="GSTTOTAMT">₹ 0.00</span>
                            </h5>
                        </div>
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php credit(); ?>Payment Details</span>
                            </h4>
                             <?php
                                $offline_payments = json_decode($cfg['PAYMENT.METHOD']);

                                $sql_qr = array();
                                $sql_qr['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . "
                                                                            WHERE `id`!='' AND `title`IN ('QR Code','Online Payment Logo')";
                                $result = $mycms->sql_select($sql_qr);
                                $onlinePaymentLogo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['image'];
                                $QR_code = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[1]['image'];
                                // echo $offline_payments;
                                ?>
                              <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Payment Mode</p>
                                    <input type="hidden" name="registrationMode" id="registrationMode">

                                    <div class="cus_check_wrap">
                                         <?php if (in_array("Neft", $offline_payments)) { ?>
                                          <label class="cus_check pay_check" data-tab="Neft">
                                            <input type="radio" name="payment_mode" value="Neft"  checked>
                                            <span class="checkmark">Neft</span>
                                        </label>
                                         <?php } ?>

                                        <?php if (in_array("Upi", $offline_payments)) { ?>
                                        <label class="cus_check pay_check" data-tab="Neft">
                                            <input type="radio" value="Upi"  name="payment_mode">
                                            <span class="checkmark">UPI</span>
                                        </label>
                                         <?php } ?>
                                       <?php if (in_array("Card", $offline_payments)) { ?>
                                            <label class="cus_check pay_check" data-tab="card">
                                                <input type="radio" value="Card" name="payment_mode">
                                                <span class="checkmark">Card</span>
                                            </label>
                                           <?php } ?>

                                          <?php if (in_array("Cheque/DD", $offline_payments)) { ?>
                                          <label class="cus_check pay_check" data-tab="DD">
                                            <input type="radio" value="Cheque" name="payment_mode" >
                                            <span class="checkmark">Cheque/DD</span>
                                        </label>
                                        <?php } ?>
                                       <?php if (in_array("Cash", $offline_payments)) { ?>
                                        <label class="cus_check pay_check" data-tab="cash">
                                            <input type="radio" value="Cash"  name="payment_mode" >
                                            <span class="checkmark">Cash</span>
                                        </label>
                                        <?php } ?>
                                        

                                    </div>
                                </div>
                                <div class="payment_details span_4" id="Neft" style="display: block;">
                                    <div class="form_grid">
                                          <!-- <h6 class="d-flex justify-content-between align-items-center">Transfer via Net Banking or NEFT/IMPS.</h6> -->
                                            <!-- <div>
                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center">Bank<span class="text-white"><?= $cfg['INVOICE_BANKNAME'] ?></span></p>
                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center">Account<span class="text-white"><?= $cfg['INVOICE_BANKACNO'] ?></span></p>
                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center mb-0">IFSC<span class="text-white"><?= $cfg['INVOICE_BANKIFSC'] ?></span></p>
                                            </div> -->
                                            <?php
                                            if (in_array("Upi", $offline_payments)) {
                                            ?>
                                            <!-- <div class="text-center for-upi-only frm_grp span_4" >
                                                <img style="margin-bottom: 10px; padding: 5px;border-radius: 5px; vertical-align: middle; background: white; width: 100px;height: 100px;" src="<?= $QR_code ?>" alt="">

                                                <p>Scan QR</p>
                                            </div> -->
                                            <?php } ?>
                                            <div class="frm_grp span_4">
                                                <p class="frm-head">Drawee Bank</p>
                                                <input type="text" class="form-control mandatory" name="neft_bank_name" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                            </div>
                                        
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <input type="date" class="form-control mandatory" name="neft_date" id="neft_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                            </div>
                                          <?php
                                            if (in_array("Neft", $offline_payments)) {
                                            ?>
                                        <div class="frm_grp span_2 for-neft-rtgs-only">
                                            <p class="frm-head">UTR Number</p>
                                            <input type="text" class="form-control mandatory utrnft" name="neft_transaction_no" id="neft_transaction_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                                        </div>
                                        <?php } ?>
                                         <?php
                                            if (in_array("Upi", $offline_payments)) {
                                            ?>
                                            <li class="frm_grp span_2 for-upi-only" >
                                             <p class="frm-head">UPI Transaction No.</p>
                                            <input type="text" class="form-control mandatory utrnft" name="txn_no" id="txn_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                                            </li>
                                            <?php } ?>
                                        <!-- <div class="frm_grp span_4">
                                            <p class="frm-head">Upload Payment Receipt</p>
                                            <input type="file" accept="image/*,application/pdf" name="neft_document" id="neft_document" class="mandatory" validate="Please upload a image">
                                            <span id="neft_file_name" style="display:none;"></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="payment_details span_4" id="cash" style="display: block;">
                                    <div class="form_grid">
                                        <div class="frm_grp span_4">
                                            <p class="frm-head">Date</p>
                                            <input type="date" class="form-control mandatory" name="cash_deposit_date" id="cash_deposit_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select date" placeholder="Date">
                                        </div>
                                    
                                        <!-- <div class="frm_grp span_4">
                                            <p class="frm-head">Upload Payment Receipt</p>
                                            <input type="file" accept="image/*,application/pdf" name="cash_document" class="mandatory" id="cash_document"  validate="Please upload a image">
                                            <span id="cash_file_name" style="display:none;"></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="payment_details span_4" id="DD"  style="display: block;">
                                    <div class="form_grid">
                                        <div class="frm_grp span_4">
                                            <p class="frm-head">Drawee Bank</p>
                                            <input type="text" class="form-control mandatory" name="cheque_drawn_bank" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                        </div>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">Date</p>
                                             <input type="date" class="form-control mandatory" name="cheque_date" id="cheque_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                        </div>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">DD No.</p>
                                            <input type="number" class="form-control mandatory" name="cheque_number" id="cheque_number" validate="Please enter cheque/DD number" placeholder="Enter DD No." type="number" maxlength="6" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;">
                                        </div>
                                    </div>
                                </div>
                                <div class="payment_details span_4" id="card"  style="display: block;">
                                    <p>
                                        <img src="<?= $onlinePaymentLogo ?>" style="width: 100%;    object-fit: contain;height: auto;background: transparent;filter: brightness(16.5); margin_bottom:0; padding-bottom:0;">
                                        <!-- <img src=""> -->
                                    </p>
                                     <div class="form_grid">
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Card Number</p>
                                                <input type="text" class="form-control mandatory" name="card_number" validate="Please enter card number" placeholder="Enter card number">
                                            </div>
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <input type="date" class="form-control mandatory" name="card_date"  max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                            </div>
                                     </div>
                                </div>
                            </div>
                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_danger py-2 px-2">Balance Due<span class="text-white mt-0" use="GSTTOTAMT">₹ 0.00</span></h6>
                            <a href="#" class="due_balance badge_info p-2 mt-1 d-flex justify-content-center align-items-center">Auto-Fill Full Amount</a>
                            <div class="frm_grp span_4 mt-3">
                                <p class="frm-head">Payment Status</p>
                                <div class="cus_check_wrap">
                                    <label class="cus_check pay_check" >
                                        <input type="radio" name="paymentstatus" value='PAID'>
                                        <span class="checkmark">Paid</span>
                                    </label>
                                    <label class="cus_check pay_check" >
                                        <input type="radio" name="paymentstatus" value='UNPAID'>
                                        <span class="checkmark">Unpaid</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Confirm Registration</button>
                    </div>
                </div>
             </form>
            </div>
        </div>
        <!-- New Registration pop up -->
        <!-- Edit Registration pop up -->
       <div class="pop_up_body" id="editregistartion">
            <div class="registration_pop_up">
                <? $userData = getUserDetails($edituserId);?>
                <div class="registration-pop_heading">
                    <span>Edit Registration<i class="ml-1 badge_padding badge_dark">ID: <?=$userData['user_registration_id']?></i> <i class="ml-1 badge_padding badge_dark"> Unique Sequence: <?=$userData['user_unique_sequence']?></i></span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                 <form class="body-frm registration-form" name="registrationForm" enctype="multipart/form-data" method="post" autocomplete="off" action="<?= _BASE_URL_ ?>webmaster/registration.process.php">
                    <input type="hidden" id="actInput" name="act" value="combinedEditRegistrationProcess" />
                    <input type="hidden" name="abstractDelegateId" value="<?= $edituserId?>" />
                    <input type="hidden" name="delegate_id" value="<?= $edituserId?>">

                    <?
                    $delegate_id = $edituserId;

                    //  echo '<pre>';
                    //  print_r($userData);
                    if (empty($userData)) {
                        // echo '<p>User not found</p>';
                    }
                    $cutoffArray = array();
                    $sqlCutoff= array();
                    $sqlCutoff['QUERY'] = " SELECT * 
                                                    FROM " . _DB_TARIFF_CUTOFF_ . " 
                                                    WHERE `status` = 'A' 
                                                ORDER BY `cutoff_sequence` ASC";

                    $resCutoff = $mycms->sql_select($sqlCutoff);
                  
                    if ($resCutoff) {
                        foreach ($resCutoff as $i => $rowCutoff) {
                            $cutoffArray[$rowCutoff['id']] = $rowCutoff['cutoff_title'];
                        }
                    }
                    
                    $workshopCutoffArray = array();
                    $sqlWorkshopCutoff  = array();
                    $sqlWorkshopCutoff['QUERY'] = " SELECT * 
                                                    FROM " . _DB_WORKSHOP_CUTOFF_ . " 
                                                    WHERE `status` = ? 
                                                ORDER BY `cutoff_sequence` ASC";
                    $sqlWorkshopCutoff['PARAM'][] = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');
                    $resWorkshopCutoff = $mycms->sql_select($sqlWorkshopCutoff);
                    if ($resWorkshopCutoff) {
                        foreach ($resWorkshopCutoff as $i => $rowWorkshopCutoff) {
                            $workshopCutoffArray[$rowWorkshopCutoff['id']] = $rowWorkshopCutoff['cutoff_title'];
                        }
                    }

                    $currentCutoffId = getTariffCutoffId();

                    $conferenceTariffArray = getAllRegistrationTariffs("", false);

                    $workshopDetailsArray = getAllWorkshopTariffs();
                    $workshopCountArr = totalWorkshopCountReport();

                    // $userREGtype = $_REQUEST['userREGtype'];
                    $abstractDelegateId = $delegate_id;
                    $userRec = $userData;
                 
                    $sqlConfDate = array();
                    $sqlConfDate['QUERY'] = " SELECT MIN(conf_date) AS startDate, MAX(conf_date) AS endDate
                                                FROM " . _DB_CONFERENCE_DATE_ . " 
                                                WHERE `status` = ?";
                    $sqlConfDate['PARAM'][] = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');
                    $resConfDate = $mycms->sql_select($sqlConfDate);
                    $rowConfDate = $resConfDate[0];




                    //accompany

                     $sqlaccompanyCutoff = array();
                    $accompanyTariffMap = [];
                    $sqlaccompanyCutoff['QUERY'] = "SELECT * FROM " . _DB_TARIFF_ACCOMPANY_ . " WHERE `status` = ?";

                    $sqlaccompanyCutoff['PARAM'][] = [
                        'FILD' => 'status',
                        'DATA' => 'A',
                        'TYP' => 's'
                    ];

                    $resaccompanyCutoff = $mycms->sql_select($sqlaccompanyCutoff);

                    if ($resaccompanyCutoff) {
                        foreach ($resaccompanyCutoff as $row) {

                            $accompanyTariffMap[$row['tariff_cutoff_id']] = [
                                'amount' => $row['amount'],
                                'currency' => $row['currency']
                            ];
                        }
                    }
                    //print_r($accompanyTariffMap);


                    ?>

                <script>

                    jQuery(document).ready(function ($) {
                        $(document).on('click', '.CheckAllWorkshop', function (e) {

                            e.preventDefault();

                            let $workshops = $(".workshop_check input[type='checkbox']");
                            let allChecked = $workshops.length === $workshops.filter(":checked").length;

                            // Toggle
                            $workshops.prop("checked", !allChecked).trigger("change");

                            // Optional: change text
                            $(this).text(allChecked ? "Select All" : "Unselect All");
                        });

                    });
                </script>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php calendar(); ?>Conference Details</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Registration Mode</p>
                                     <div class="hotel_link_owl owl-carousel owl-theme">

                                        <?php if (!empty($cutoffArray)): ?>
                                            <?php foreach ($cutoffArray as $cutoffId => $cutoffName): ?>
                                                <?php $tabId = strtolower(str_replace(' ', '', $cutoffName)); ?>

                                                <label class="cus_check mode_check registration_cutoff pay_check" data-tab="<?= $tabId; ?>">
                                                    <input type="radio" name="registration_cutoff" value="<?= $cutoffId; ?>"
                                                    
                                                        <?= ($userRec['registration_tariff_cutoff_id'] == $cutoffId) ? 'checked' : '' ?> disabled>
                                                    <span class="checkmark" disabled>
                                                        <?= $cutoffName ?>
                                                    </span>
                                                </label>


                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                             	<div class="frm_grp span_4">
                                    <p class="frm-head">Select Category</p>
                                    <?php

                                    if (!empty($cutoffArray)):

                                        foreach ($cutoffArray as $cutoffId => $cutoffName):
                                            $tabId = strtolower(str_replace(' ', '', $cutoffName)); ?>
                                            <div class="regi_category class_cat" id="<?= $tabId ?>">
                                                <div class="cus_check_wrap flex-column">

                                                    <?php
 

                                                    foreach ($conferenceTariffArray as $categoryKey => $tariffRow):

                                                        $clsfType = getRegClsfType($categoryKey);
                                                        $categoryName = getRegClsfName($categoryKey);

                                                        if ($clsfType == 'ACCOMPANY')
                                                            continue;
                                                        if ($clsfType == 'COMBO' && $categoryKey != 3)
                                                            continue;


                                                        $amount = $tariffRow[$cutoffId]['AMOUNT'];
                                                        $currency = $tariffRow[$cutoffId]['CURRENCY'];

                                                        $displayAmount = ($amount <= 0)
                                                            ? (($clsfType == 'FULL_ACCESS') ? "Complimentary" : "Zero Value")
                                                            : $currency . " " . $amount;
                                                        ?>

                                                       <label class="cus_check category_check">
                                                            <input class="category_check_input" type="radio"
                                                                name="registration_classification_id"
                                                                value="<?= $categoryKey ?>"
                                                                <?= ((int)$userRec['registration_classification_id'] === (int)$categoryKey) ? 'checked' : '' ?>
                                                                disabled>

                                                            <span class="checkmark"
                                                                style="<?= ((int)$userRec['registration_classification_id'] === (int)$categoryKey) ? 'background-color: var(--danger1); color: #ffa8a8; border-color: var(--danger1);' : '' ?>">
                                                                <?= $categoryName ?><i><?=$currency?> <?= $amount?></i>
                                                            </span>
                                                        </label>

                                                    <?php endforeach; ?>

                                                </div>

                                            </div>

                                        <?php endforeach;
                                    endif; ?>

                                </div>
                            </div>
                            <!-- <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Registration Mode</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check mode_check" data-tab="earlybird">
                                            <input type="radio" name="regimood" checked>
                                            <span class="checkmark">Early Bird</span>
                                        </label>
                                        <label class="cus_check mode_check" data-tab="regular">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">Regular</span>
                                        </label>
                                        <label class="cus_check mode_check" data-tab="spot">
                                            <input type="radio" name="regimood">
                                            <span class="checkmark">Spot</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Select Category</p>
                                    <div class="regi_category" id="earlybird" style="display: block;">
                                        <div class="cus_check_wrap flex-column">
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory" checked>
                                                <span class="checkmark">Early Bird<i>₹ 4000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">PGT<i>₹ 2500</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">TB Worker<i>₹ 2000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Faculty<i>₹ 0</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Student<i>₹ 2000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Exhibitor<i>₹ 10000</i></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="regi_category" id="regular">
                                        <div class="cus_check_wrap flex-column">
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Early Bird<i>₹ 4000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">PGT<i>₹ 2500</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">TB Worker<i>₹ 2000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Faculty<i>₹ 0</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Student<i>₹ 2000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Exhibitor<i>₹ 10000</i></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="regi_category" id="spot">
                                        <div class="cus_check_wrap flex-column">
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Early Bird<i>₹ 4000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">PGT<i>₹ 2500</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">TB Worker<i>₹ 2000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Faculty<i>₹ 0</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Student<i>₹ 2000</i></span>
                                            </label>
                                            <label class="cus_check category_check">
                                                <input type="radio" name="regicategory">
                                                <span class="checkmark">Exhibitor<i>₹ 10000</i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="registration-pop_body_box_inner d-none">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php workshop(); ?>Workshops<label class="toggleswitch">
                                        <input class="toggleswitch-checkbox" type="checkbox">
                                        <div class="toggleswitch-switch"></div>Only Workshop
                                    </label></span>
                                <a class="add mi-1"><?php check(); ?>Select All</a>
                            </h4>
                            <div class="cus_check_wrap flex-column">
                                <label class="cus_check category_check workshop_check">
                                    <input type="radio" name="workshop1">
                                    <span class="checkmark">TB & Critical Care Workshop<i>₹ 4000</i></span>
                                </label>
                                <label class="cus_check category_check workshop_check">
                                    <input type="radio" name="workshop2">
                                    <span class="checkmark">TB & Critical Care Workshop<i>₹ 4000</i></span>
                                </label>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner  d-none">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php hotel(); ?>Accommodation</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Hotel</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check In</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check Out</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Room Type</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="roomtype">
                                            <span class="checkmark">Room Type 1</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="roomtype">
                                            <span class="checkmark">Room Type 2</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Package Type</p>
                                    <div class="cus_check_wrap flex-column">
                                        <label class="cus_check category_check">
                                            <input type="radio" name="packagetype">
                                            <span class="checkmark">Individual<i>₹ 4000</i></span>
                                        </label>
                                        <label class="cus_check category_check">
                                            <input type="radio" name="packagetype">
                                            <span class="checkmark">Sharing<i>₹ 2500</i></span>
                                        </label>
                                    </div>
                                </div>
                                <p class="frm-head span_4 mb-0 text_info"><i class="fal fa-exclamation-circle mr-2"></i>Room rates are per night and exclusive of GST.</p>
                                <div class="span_4">
                                    <h6 class="due_balance d-flex justify-content-between align-items-center badge_info py-2 px-2">Amount<span class="text-white mt-0">₹ 12,980</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner  d-none">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php dinner(); ?>Gala Dinner</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Hotel</p>
                                    <select>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Date</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="checkbox">
                                            <span class="checkmark">Date 1</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="checkbox">
                                            <span class="checkmark">Date 2</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="checkbox">
                                            <span class="checkmark">Date 3</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="span_4">
                                    <h6 class="due_balance d-flex justify-content-between align-items-center badge_info py-2 px-2">Amount<span class="text-white mt-0">₹ 12,980</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php user(); ?>Delegate Profile</span>
                            </h4>
                            <div class="form_grid">
                            <div class="frm_grp span_1">
                                <p class="frm-head">Title</p>
                                <select name="user_initial_title" id="user_initial_title" tabindex="4" required>
                                    <option value="Dr" <?= ($userRec['user_initial_title'] == 'Dr') ? 'selected' : '' ?>>Dr
                                    </option>
                                    <option value="Prof" <?= ($userRec['user_initial_title'] == 'Prof') ? 'selected' : '' ?>>Prof
                                    </option>
                                    <option value="Mr" <?= ($userRec['user_initial_title'] == 'Mr') ? 'selected' : '' ?>>Mr
                                    </option>
                                    <option value="Ms" <?= ($userRec['user_initial_title'] == 'Ms') ? 'selected' : '' ?>>Ms
                                    </option>
                                </select>
                            </div>
                            <div class="frm_grp span_3">
                                <p class="frm-head">First Name <i class="mandatory">*</i></p>
                                <input type="text" name="user_first_name" id="user_first_name" style="text-transform:uppercase;"
                                    tabindex="5" value="<?= $userRec['user_first_name'] ?>" required />
                            </div>
                            <div class="frm_grp span_2">
                                <p class="frm-head">Middle Name</p>
                                <input type="text" name="user_middle_name" id="user_middle_name" style="text-transform:uppercase;"
                                    value="<?= $userRec['user_middle_name'] ?>" tabindex="6" />
                            </div>
                            <div class="frm_grp span_2">
                                <p class="frm-head">Last Name <i class="mandatory">*</i></p>
                                <input type="text" name="user_last_name" id="user_last_name" tabindex="7"
                                    style="text-transform:uppercase;" value="<?= $userRec['user_last_name'] ?>" required />
                            </div>
                            <div class="frm_grp span_4">
                                <p class="frm-head">Email Address <i class="mandatory">*</i></p>
                                <input type="text" name="user_email_id" id="user_email_id" value="<?= $userRec['user_email_id'] ?>"
                                    required />
                                <input type="hidden" name="abstractDelegateId" value="<?= $userRec['delegate_id'] ?>" />
                            </div>
                            <div class="frm_grp span_4">
                                <p class="frm-head">Mobile Number <i class="mandatory">*</i></p>
                                <input type="tel" name="user_usd_code" id="user_mobile_isd_code"
                                    style="width:12% !important;  text-align:right;" tabindex="2"
                                    value="<?= ($userRec['user_mobile_isd_code'] != '') ? ($userRec['user_mobile_isd_code']) : '+91' ?>"
                                    required />
                                <input type="tel" name="user_mobile" id="user_mobile_no" style="width: 86% !important;"
                                    forType="mobileValidate" pattern="^\d{10}$" tabindex="3"
                                    value="<?= ($userRec['user_mobile_no'] != '') ? ($userRec['user_mobile_no']) : '' ?>"
                                    required />
                            </div>
                            <!-- <div class="frm_grp span_4">
                                <p class="frm-head">Institute / Org</p>
                                <input name="user_institute_name" value="<?= $userRec['user_institute_name'] ?>">
                            </div> -->
                            <!-- <div class="frm_grp span_4">
                                                <p class="frm-head">GST Number</p>
                                                <input>
                                            </div> -->
                            <div class="frm_grp span_2">
                                <p class="frm-head">Gender</p>
                                <div class="cus_check_wrap">
                                    <label class="cus_check gender_check">
                                        <input type="radio" name="user_gender" value="Male" <?= ($userRec['user_gender'] == 'Male') ? 'checked' : '' ?>>
                                        <span class="checkmark">Male</span>
                                    </label>
                                    <label class="cus_check gender_check">
                                        <input type="radio" name="user_gender" value="Female" <?= ($userRec['user_gender'] == 'Female') ? 'checked' : '' ?>>
                                        <span class="checkmark">Female</span>
                                    </label>
                                </div>
                            </div>
                            <div class="frm_grp span_2">
                                <p class="frm-head">Food</p>
                                <div class="cus_check_wrap">
                                    <label class="cus_check gender_check">
                                        <input type="radio" name="user_food_preference" value="VEG"
                                            <?= ($userRec['user_food_preference'] == 'VEG') ? 'checked' : '' ?>>
                                        <span class="checkmark">Veg</span>
                                    </label>
                                    <label class="cus_check gender_check">
                                        <input type="radio" name="user_food_preference" value="NON VEG"
                                            <?= ($userRec['user_food_preference'] == 'NON VEG') ? 'checked' : '' ?>>
                                        <span class="checkmark">Non Veg</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php address(); ?>Address Details</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Full Address</p>
                                    <textarea name="user_address"><?= $userRec['user_address'] ?></textarea>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country</p>
                                    <select required implementvalidate="y" name="user_country" id="user_country" forType="country"
                                        stateId="user_state" onchange="stateRetriver(this);" tabindex="11" sequence="1">
                                        <option value="">-- Select Country --</option>
                                        <?php
                                        $sqlCountry['QUERY'] = "SELECT * FROM " . _DB_COMN_COUNTRY_ . " 
                                                                                    WHERE `status` = 'A' 
                                                                                ORDER BY `country_name`";
                                        $resultCountry = $mycms->sql_select($sqlCountry);
                                        if ($resultCountry) {
                                            foreach ($resultCountry as $i => $rowFetchUserCountry) {
                                                ?>
                                                <option value="<?= $rowFetchUserCountry['country_id'] ?>"
                                                    <?= ($rowFetchUserCountry['country_id'] == $userRec['user_country_id']) ? 'selected' : '' ?>>
                                                    <?= $rowFetchUserCountry['country_name'] ?>
                                                </option>
                                                <!-- -- FOR DEFAULT INDIA ---------- -->
                                                <!-- <option value="<?= $rowFetchUserCountry['country_id'] ?>" <?= ($rowFetchUserCountry['country_id'] == '1') ? 'selected' : '' ?>><?= $rowFetchUserCountry['country_name'] ?></option> -->
                                                <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                    <?
                                    if ($userRec['user_country_id'] != '') {

                                        ?>
                                        <script>
                                            $(document).ready(function () {

                                                generateSateList(<?= $userRec['user_country_id'] ?>, jsBASE_URL);
                                                $('#user_state option[value="<?= $userRec['user_state_id'] ?>"]').prop('selected', true);

                                            });
                                        </script>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">State</p>
                                    <div use='stateContainer'>
                                        <select name="user_state" id="user_state" forType="state" tabindex="12" sequence="1"
                                            disabled="disabled" required implementvalidate="y">
                                            <option value="">-- Select Country First --</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">City</p>
                                    <input type="text" name="user_city" id="user_city" tabindex="13" style="text-transform:uppercase;"
                                        value="<?= ($userRec['user_city'] != '') ? ($userRec['user_city']) : '' ?>" required
                                        implementvalidate="y" />
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Pincode</p>
                                    <input type="text" name="user_postal_code" id="user_postal_code" tabindex="14"
                                        value="<?= ($userRec['user_pincode'] != '') ? ($userRec['user_pincode']) : '' ?>"
                                        style="text-transform:uppercase;" required implementvalidate="y" />
                                </div>
                            </div>
                        </div>
                           <?php
                            $accSql = [];
                            $accSql['QUERY'] = "SELECT * FROM " . _DB_USER_REGISTRATION_ . " WHERE `status` = 'A' AND `refference_delegate_id` = '" . $delegate_id . "' ";
                            $resultAcc = $mycms->sql_select($accSql);

                            ?>

                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Accompanying</span>
                                    <a href="javascript:void(0)" class="add mi-1 add_accompany"><i class="fal fa-plus"></i>Add</a>
                                </h4>
                                <div class="accm_add_wrap">

                                    <?php if (!empty($resultAcc)) { ?>
                                        <?php if (!empty($cutoffArray)): ?>
                                            <p class="frm-head">Accompanying Mode</p>
                                            <div class="cus_check_wrap">
                                                <?php if (!empty($cutoffArray)): ?>
                                                    <?php foreach ($cutoffArray as $cutoffId => $cutoffName): ?>

                                                        <?php
                                                        $amount = $accompanyTariffMap[$cutoffId]['amount'] ?? 0;
                                                        $currency = $accompanyTariffMap[$cutoffId]['currency'] ?? 'INR';
                                                        $tabId = strtolower(str_replace(' ', '', $cutoffName));
                                                        ?>

                                                        <label class="cus_check mode_check registration_acc_cutoff d-none" data-tab="<?= $tabId; ?>">
                                                            <input type="radio" name="registration_acc_cutoff" value="<?= $cutoffId; ?>"
                                                                data-amount="<?= $amount; ?>" data-currency="<?= $currency; ?>"
                                                                <?= ($userRec['registration_tariff_cutoff_id'] == $cutoffId) ? 'checked' : '' ?> disabled>

                                                            <span class="checkmark"><?= $cutoffName ?></span>
                                                        </label>

                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>


                                        <?php foreach ($resultAcc as $key => $acc) { ?>

                                            <div class="accompany_box accm_add_box accm_edit_acco_box" data-id="<?= $acc['id'] ?>">
                                                <div class="form_grid">
                                                    <input type="hidden" name="accompany_selected_add[<?= $acc['id'] ?>]"
                                                        value="<?= $acc['id'] ?>" autocomplete="off" data-existing="1">
                                                    <div class="frm_grp span_4">
                                                        <label class="frm-head">Full Name</label>
                                                        <input type="text" name="accompany_name_add[<?= $acc['id'] ?>][user_full_name]"
                                                            value="<?= htmlspecialchars($acc['user_full_name']) ?>">
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <div class="cus_check_wrap">
                                                            <label class="cus_check gender_check">
                                                                <input type="radio" name="accompany_food_choice[<?= $acc['id'] ?>]" value="VEG"
                                                                    <?= ($acc['user_food_preference'] == 'VEG') ? 'checked' : '' ?>>
                                                                <span class="checkmark">Veg</span>
                                                            </label>
                                                            <label class="cus_check gender_check">
                                                                <input type="radio" name="accompany_food_choice[<?= $acc['id'] ?>]"
                                                                    value="NON VEG" <?= ($acc['user_food_preference'] == 'NON VEG') ? 'checked' : '' ?>>
                                                                <span class="checkmark">Non Veg</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="span_2">
                                                        <h6 class="due_balance d-flex justify-content-center align-items-center badge_info py-2 px-2 accompanyTariffAmount"><span class="text-white mt-0"  id="accompanyTariffAmount"><?= getRegistrationCurrency($currentCutoffId) ?> <?=$registrationAmount?></span></h6>
                                                    </div>
                                                    <!-- <div class="frm_grp span_4">
                                                                <a href="registration.process.php?act=cancel_invoice&user_id=<?= $acc['id'] ?>&invoice_id=1329&curntUserId=<?= $acc['id'] ?>"
                                                                    class="accm_delet icon_hover badge_danger action-transparent "><i class="fal fa-times"></i></a>

                                                            </div> -->

                                                </div>
                                            </div>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <!-- <h6 class="accm_add_empty">No accompanying persons</h6> -->

                                    <?php } ?>

                                    <input type="hidden" name="accompanyTariffAmount" id="accompanyTariffAmount" value="0" />

                                 <input type="hidden" name="registration_acc_cutoff" value="<?= $currentCutoffId; ?>">

                                 <input type="hidden" name="tariff_cutoff_id" value="<?= $currentCutoffId; ?>">

                                </div>
                            </div>
                        </div>
                    <div class="registration-pop_body_box" >


                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php bill(); ?>Bill Summary</span>
                            </h4>
                            <?php
                            $sqlFetchInvoice                = getRegistrationInvoiceCancelInvoiceDetails("", $edituserId, "");
                            $id =$edituserId;
                            // echo '<pre>'; print_r($sqlFetchInvoice);																
                            $resultFetchInvoice             = $mycms->sql_select($sqlFetchInvoice);
                            //    echo '<pre>'; print_r($resultFetchInvoice ); echo '</pre>'; 
                            
                            //   echo '<pre>'; print_r($resultFetchInvoice ); echo '</pre>'; 
                           
                            if ($resultFetchInvoice && $edituserId) {
                                    $totalAmountAll = 0;
                                    foreach ($resultFetchInvoice as $key => $rowFetchInvoice) {
                                    $showTheRecord = true;
                                    $resPaymentDetails      = paymentDetails($rowFetchInvoice['slip_id']);
                                    $resFetchSlip	  = slipDetailsOfUser($edituserId, true);

                                    //  echo '<pre>'; print_r($resPaymentDetails ); echo '</pre>'; 

                                    $thisUserDetails 	= getUserDetails($rowFetchInvoice[$edituserId]);
                                    $thisUserClasfId 	= getUserClassificationId($rowFetchInvoice[$edituserId]);
                                    $thisUserClasfName 	= getRegClsfName(getUserClassificationId($rowFetchInvoice[$edituserId]));
                            
                                        $showTheRecord = true;

                                        $invoiceCounter++;
                                        $slip = getInvoice($rowFetchInvoice['slip_id']);
                                        $returnArray    = discountAmount($rowFetchInvoice['id']);
                                        $percentage     = $returnArray['PERCENTAGE'];
                                        $totalAmount    = $returnArray['TOTAL_AMOUNT'];
                                        $discountAmount = $returnArray['DISCOUNT'];

                                        // echo '<pre>'; print_r($totalAmount ); echo '</pre>'; 

                                        $thisUserDetails 	= getUserDetails($rowFetchInvoice[$id]);
                                        $thisUserClasfId 	= getUserClassificationId($rowFetchInvoice[$id]);
                                        $thisUserClasfName 	= getRegClsfName(getUserClassificationId($rowFetchInvoice[$id]));
                                
                                        // $totalAmountAll += $totalAmount;
                                        
                                        $type			 	= "";
                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "CONFERENCE");
                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-gift" aria-hidden="true"></i>&nbsp;Conference Registration';
                                        }
                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_RESIDENTIAL_REGISTRATION") {
                                            $isResReg = true;
                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "RESIDENTIAL");
                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-gift" aria-hidden="true"></i>&nbsp;' . $type;

                                            $sqlAccomm = array();
                                            $sqlAccomm['QUERY']    = " SELECT accomm.*, hotel.hotel_name
                                                                            FROM " . _DB_REQUEST_ACCOMMODATION_ . " accomm
                                                                    INNER JOIN " . _DB_MASTER_HOTEL_ . " hotel
                                                                            ON accomm.hotel_id = hotel.id
                                                                            WHERE accomm.`user_id` = ?
                                                                            AND accomm.`refference_invoice_id` = ?";
                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'user_id',  				'DATA' => $delegate_id,  			'TYP' => 's');
                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'refference_invoice_id',  	'DATA' => $rowFetchInvoice['id'],  	'TYP' => 's');
                                            $resAccomm = $mycms->sql_select($sqlAccomm);

                                            foreach ($resAccomm as $kk => $row) {
                                                $serviceSummary[$rowFetchInvoice['id'] . 'accm'] = '';

                                                $accommodationRecords[$rowFetchInvoice['id']]['KEY'] 			= $rowFetchInvoice['id'] . 'accm';
                                                $accommodationRecords[$rowFetchInvoice['id']]['BOOK-TYP'] 		= 'RES-PACK';
                                                $accommodationRecords[$rowFetchInvoice['id']]['accomId'] 		= $row['id'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['packageId']	 	= $cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId];
                                                $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'] 	= $row['hotel_name'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['checkin_date'] 	= $row['checkin_date'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['checkout_date'] 	= $row['checkout_date'];

                                                $accommodationRecords[$rowFetchInvoice['id']]['WILL-SHARE'] 	= false;
                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE'] 			= array();

                                                //$serviceSummary[$rowFetchInvoice['id'].'accm'] = '<i class="fa fa-building" aria-hidden="true" style="cursor:pointer;" onClick="openAccmDateEditPopup(this)" accomId="'.$row['id'].'" packageId="'.$cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId].'"></i>&nbsp;Accommodation @ '.$row['hotel_name'].' <span style="font-size:12px;">['.$row['checkin_date'].' to '.$row['checkout_date'].']</span>';

                                                if (in_array($thisUserClasfId, $cfg['RESIDENTIAL_SHARING_CLASF_ID'])) {
                                                    $accommodationRecords[$rowFetchInvoice['id']]['WILL-SHARE'] 			= true;
                                                    $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['KEY'] 			= $rowFetchInvoice['id'] . 'accmshr';
                                                    $serviceSummary[$rowFetchInvoice['id'] . 'accmshr']						= '';

                                                    if (trim($row['preffered_accommpany_name']) != '') {
                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['accomId'] 		= $row['id'];
                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefName'] 		= $row['preffered_accommpany_name'];
                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefMobile'] 	= $row['preffered_accommpany_mobile'];
                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefEmail'] 	= $row['preffered_accommpany_email'];
                                                        /*$serviceSummary[$rowFetchInvoice['id'].'accmshr'] = '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o" aria-hidden="true" style="cursor:pointer;" onClick="openSharePrefEditPopup(this)" accomId="'.$row['id'].'" prefName="'.$row['preffered_accommpany_name'].'"  prefMobile="'.$row['preffered_accommpany_mobile'].'"  prefEmail="'.$row['preffered_accommpany_email'].'"></i>&nbsp;'.$row['preffered_accommpany_name'].'<br>
                                                                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;'.$row['preffered_accommpany_mobile'].'<br>
                                                                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;'.$row['preffered_accommpany_email'].'';*/
                                                    } else {
                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['accomId'] = $row['id'];
                                                        //$serviceSummary[$rowFetchInvoice['id'].'accmshr'] = '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o" aria-hidden="true" style="cursor:pointer;" onClick="openSharePrefEditPopup(this)" accomId="'.$row['id'].'"></i>&nbsp;-';
                                                    }
                                                }
                                            }
                                        }
                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION") {
                                            $workShopDetails = getWorkshopDetails($rowFetchInvoice['refference_id'], true);
                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "WORKSHOP");
                                            if ($workShopDetails['showInInvoices'] != 'Y') {
                                                $showTheRecord 		= false;
                                            }
                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp;' . $workShopDetails['classification_title'];
                                        }
                                        if ($rowFetchInvoice['service_type'] == "ACCOMPANY_CONFERENCE_REGISTRATION") {
                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "ACCOMPANY");
                                            $accompanyDetails = getUserDetails($rowFetchInvoice['refference_id']);
                                            if ($accompanyDetails['registration_request'] == 'GUEST') {
                                                $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-smile-o" aria-hidden="true"></i>&nbsp;Accompaning Guest - ' . $accompanyDetails['user_full_name'];
                                            } else {
                                                $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-users" aria-hidden="true"></i>&nbsp;Accompany - ' . $accompanyDetails['user_full_name'];
                                            }
                                        }
                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_ACCOMMODATION_REQUEST") {
                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "ACCOMMODATION");
                                            //$serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-building" aria-hidden="true"></i>&nbsp;Accomodation';

                                            //$showTheRecord = false;
                                            $sqlAccomm = array();
                                            $sqlAccomm['QUERY']    = " SELECT accomm.*, hotel.hotel_name
                                                                            FROM " . _DB_REQUEST_ACCOMMODATION_ . " accomm
                                                                    INNER JOIN " . _DB_MASTER_HOTEL_ . " hotel
                                                                            ON accomm.hotel_id = hotel.id
                                                                            WHERE accomm.`user_id` = ?
                                                                            AND accomm.`refference_invoice_id` = ?";
                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'user_id',  				'DATA' => $delegate_id,  			'TYP' => 's');
                                            $sqlAccomm['PARAM'][]  = array('FILD' => 'refference_invoice_id',  	'DATA' => $rowFetchInvoice['id'],  	'TYP' => 's');
                                            $resAccomm = $mycms->sql_select($sqlAccomm);
                                            //echo "<pre>";print_r($resAccomm);echo "</pre>";
                                            foreach ($resAccomm as $kk => $row) {
                                                $accommodationRecords[$rowFetchInvoice['id']]['BOOK-TYP'] = 'ACCOMMODATION';
                                                $accommodationRecords[$rowFetchInvoice['id']]['accomId'] = $row['id'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['packageId'] = $row['package_id'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'] = $row['hotel_name'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['checkin_date'] = $row['checkin_date'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['checkout_date'] = $row['checkout_date'];
                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE'] = array();
                                                //$serviceSummary[$rowFetchInvoice['id'].'accm'] = '<i class="fa fa-building" aria-hidden="true" style="cursor:pointer;" onClick="openAccmDateEditPopup(this)" accomId="'.$row['id'].'" packageId="'.$cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId].'"></i>&nbsp;Accommodation @ '.$row['hotel_name'].' <span style="font-size:12px;">['.$row['checkin_date'].' to '.$row['checkout_date'].']</span>';
                                            }

                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-building" aria-hidden="true"></i>&nbsp;Accommodation @ ' . $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'];
                                        }
                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_TOUR_REQUEST") {
                                            $tourDetails = getTourDetails($invoiceDetails['refference_id']);
                                            $type = getInvoiceTypeString($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "TOUR");
                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-bus" aria-hidden="true"></i>&nbsp;Tour';
                                        }
                                        if ($rowFetchInvoice['service_type'] == "DELEGATE_DINNER_REQUEST") {
    
                                            $sqlDetails  = array();
                                            $sqlDetails['QUERY'] = "  SELECT dinnerReq.*,  
                                                                            dinner.dinner_classification_name, dinner.date AS dinnerDate,
                                                                            user.user_full_name, dinner.dinner_hotel_name,
                                                                            inv.id AS invoiceId
                                                                        FROM "._DB_REQUEST_DINNER_." dinnerReq
                                                                INNER JOIN "._DB_DINNER_CLASSIFICATION_." dinner
                                                                        ON dinner.id = dinnerReq.package_id
                                                                INNER JOIN "._DB_USER_REGISTRATION_." user
                                                                        ON user.id = dinnerReq.refference_id
                                                            LEFT OUTER JOIN "._DB_INVOICE_." inv
                                                                        ON inv.id = dinnerReq.refference_invoice_id
                                                                        AND inv.status = 'A'
                                                                        AND inv.service_type IN('DELEGATE_DINNER_REQUEST','DELEGATE_CONFERENCE_REGISTRATION','DELEGATE_RESIDENTIAL_REGISTRATION','ACCOMPANY_CONFERENCE_REGISTRATION')
                                                                    WHERE dinnerReq.status = ?
                                                                        AND dinnerReq.`refference_invoice_id` = ?";
                                                                        
                                            $sqlDetails['PARAM'][]  = array('FILD' => 'status', 'DATA' =>'A',            	'TYP' => 's');
                                            $sqlDetails['PARAM'][]  = array('FILD' => 'refference_invoice_id', 'DATA' =>$rowFetchInvoice['id'],  		'TYP' => 's');
                                            
                                            $resDetails = $mycms->sql_select($sqlDetails);
                                        
                                            $type =$resDetails[0]['dinner_classification_name']."-".$resDetails[0]['dinner_hotel_name']."<br>".$resDetails[0]['dinnerDate'];
                                                                                                        
                                            $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Dinner';
                                            
                                        }
                                         $totalAmountAll += $totalAmount;

                                        if (isset($rowFetchInvoice['Refund_status']) && $rowFetchInvoice['Refund_status'] == 'Not_refunded') {
                                            $rowBackGround = "#FFFFCA";
                                        } elseif (isset($rowFetchInvoice['Refund_status']) && $rowFetchInvoice['Refund_status'] == 'Refunded') {
                                            $rowBackGround = "#FFCCCC";
                                        } else {
                                            $rowBackGround = "#FFFFFF";
                                        }

                                        if ($rowFetchInvoice['payment_status'] == "COMPLIMENTARY") {
                                            $payment_status = ' <span style="color:#5E8A26;">Complimentary</span>';
                                        ?>
                                        <?php
                                        } elseif ($rowFetchInvoice['payment_status'] == "ZERO_VALUE") {
                                            $payment_status =' <span style="color:#009900;">Zero Value</span>';
                                        ?>
                                        <?php
                                        } else if ($rowFetchInvoice['payment_status'] == "PAID") {
                                            if (!($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION" && $workShopDetails['display'] == 'N')) {
                                                $totalPaid += $totalAmount;
                                            }
                                            $paymentModeDisplay = $resPaymentDetails['payment_mode'] == 'NEFT' ? 'NEFT/UPI' : ($resPaymentDetails['payment_mode'] == 'Cheque' ? 'Cheque/DD' : $resPaymentDetails['payment_mode']);
                                            $payment_status = ' <span style="color:#5E8A26;">Paid</span>';
                                        } else if ($rowFetchInvoice['payment_status'] == "UNPAID") {
                                            $hasUnpaidBill	 = true;
                                            $totalUnpaid 	+= $totalAmount;
                                            $payment_status= ' <span style="color:#C70505;">Unpaid</span>';
                                        ?>
                                        
                                        <?php
                                        }

                                        // if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                            
                            ?>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center"><?=$type?><span class="text-white"><?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmount, 2) ?></span></p>
                           <?php
                            }
                            }
                            ?>
                            <hr class="my-3" style="height: 0;border-top: 1px dashed currentColor;background: transparent;">
                            <!-- <p class="frm-head text_dark d-flex justify-content-between align-items-center">Discount<span class="text-white">₹ <input value="<?=$discountAmount?>" class="dis_input" type="number"></span></p> -->
                            <hr class="my-3" style="height: 0;border-top: 1px dashed currentColor;background: transparent;">
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Subtotal <span class="text-white"><?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmountAll, 2) ?></span></p>
                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">GST (18%) <span class="text-white">Included</span></p>
                            <h5 class="regi_total">
                                Total<span><?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmountAll, 2) ?></span>
                            </h5>
                        </div>
                       <div class="registration-pop_body_box_inner d-none">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?php credit(); ?>Payment Details</span>
                            </h4>
                             <?php
                                $offline_payments = json_decode($cfg['PAYMENT.METHOD']);

                                $sql_qr = array();
                                $sql_qr['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . "
                                                                            WHERE `id`!='' AND `title`IN ('QR Code','Online Payment Logo')";
                                $result = $mycms->sql_select($sql_qr);
                                $onlinePaymentLogo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['image'];
                                $QR_code = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[1]['image'];
                                // echo $offline_payments;
                                ?>
                              <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Payment Mode</p>
                                    <input type="hidden" name="registrationMode" id="registrationMode">

                                    <div class="cus_check_wrap">
                                         <?php if (in_array("Neft", $offline_payments)) { ?>
                                          <label class="cus_check pay_check" data-tab="Neft1">
                                            <input type="radio" name="payment_mode" value="Neft"  checked>
                                            <span class="checkmark">Neft</span>
                                        </label>
                                         <?php } ?>

                                        <?php if (in_array("Upi", $offline_payments)) { ?>
                                        <label class="cus_check pay_check" data-tab="Neft1">
                                            <input type="radio" value="Upi"  name="payment_mode">
                                            <span class="checkmark">UPI</span>
                                        </label>
                                         <?php } ?>
                                       <?php if (in_array("Card", $offline_payments)) { ?>
                                            <label class="cus_check pay_check" data-tab="card1">
                                                <input type="radio" value="Card" name="payment_mode">
                                                <span class="checkmark">Card</span>
                                            </label>
                                           <?php } ?>

                                          <?php if (in_array("Cheque/DD", $offline_payments)) { ?>
                                          <label class="cus_check pay_check" data-tab="DD1">
                                            <input type="radio" value="Cheque" name="payment_mode" >
                                            <span class="checkmark">Cheque/DD</span>
                                        </label>
                                        <?php } ?>
                                       <?php if (in_array("Cash", $offline_payments)) { ?>
                                        <label class="cus_check pay_check" data-tab="cash1">
                                            <input type="radio" value="Cash"  name="payment_mode" >
                                            <span class="checkmark">Cash</span>
                                        </label>
                                        <?php } ?>
                                        

                                    </div>
                                </div>
                                <div class="payment_details span_4" id="Neft1" style="display: block;">
                                    <div class="form_grid">
                                          <!-- <h6 class="d-flex justify-content-between align-items-center">Transfer via Net Banking or NEFT/IMPS.</h6> -->
                                            <!-- <div>
                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center">Bank<span class="text-white"><?= $cfg['INVOICE_BANKNAME'] ?></span></p>
                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center">Account<span class="text-white"><?= $cfg['INVOICE_BANKACNO'] ?></span></p>
                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center mb-0">IFSC<span class="text-white"><?= $cfg['INVOICE_BANKIFSC'] ?></span></p>
                                            </div> -->
                                            <?php
                                            if (in_array("Upi", $offline_payments)) {
                                            ?>
                                            <!-- <div class="text-center for-upi-only frm_grp span_4" >
                                                <img style="margin-bottom: 10px; padding: 5px;border-radius: 5px; vertical-align: middle; background: white; width: 100px;height: 100px;" src="<?= $QR_code ?>" alt="">

                                                <p>Scan QR</p>
                                            </div> -->
                                            <?php } ?>
                                            <div class="frm_grp span_4">
                                                <p class="frm-head">Drawee Bank</p>
                                                <input type="text" class="form-control mandatory" name="neft_bank_name" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                            </div>
                                        
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <input type="date" class="form-control mandatory" name="neft_date" id="neft_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                            </div>
                                          <?php
                                            if (in_array("Neft", $offline_payments)) {
                                            ?>
                                        <div class="frm_grp span_2 for-neft-rtgs-only">
                                            <p class="frm-head">UTR Number</p>
                                            <input type="text" class="form-control mandatory utrnft" name="neft_transaction_no" id="neft_transaction_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                                        </div>
                                        <?php } ?>
                                         <?php
                                            if (in_array("Upi", $offline_payments)) {
                                            ?>
                                            <li class="frm_grp span_2 for-upi-only" >
                                             <p class="frm-head">UPI Transaction No.</p>
                                            <input type="text" class="form-control mandatory utrnft" name="txn_no" id="txn_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                                            </li>
                                            <?php } ?>
                                        <!-- <div class="frm_grp span_4">
                                            <p class="frm-head">Upload Payment Receipt</p>
                                            <input type="file" accept="image/*,application/pdf" name="neft_document" id="neft_document" class="mandatory" validate="Please upload a image">
                                            <span id="neft_file_name" style="display:none;"></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="payment_details span_4" id="cash1" style="display: block;">
                                    <div class="form_grid">
                                        <div class="frm_grp span_4">
                                            <p class="frm-head">Date</p>
                                            <input type="date" class="form-control mandatory" name="cash_deposit_date" id="cash_deposit_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select date" placeholder="Date">
                                        </div>
                                    
                                        <!-- <div class="frm_grp span_4">
                                            <p class="frm-head">Upload Payment Receipt</p>
                                            <input type="file" accept="image/*,application/pdf" name="cash_document" class="mandatory" id="cash_document"  validate="Please upload a image">
                                            <span id="cash_file_name" style="display:none;"></span>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="payment_details span_4" id="DD1"  style="display: block;">
                                    <div class="form_grid">
                                        <div class="frm_grp span_4">
                                            <p class="frm-head">Drawee Bank</p>
                                            <input type="text" class="form-control mandatory" name="cheque_drawn_bank" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                        </div>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">Date</p>
                                             <input type="date" class="form-control mandatory" name="cheque_date" id="cheque_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                        </div>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">DD No.</p>
                                            <input type="number" class="form-control mandatory" name="cheque_number" id="cheque_number" validate="Please enter cheque/DD number" placeholder="Enter DD No." type="number" maxlength="6" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;">
                                        </div>
                                    </div>
                                </div>
                                <div class="payment_details span_4" id="card1"  style="display: block;">
                                    <p>
                                        <img src="<?= $onlinePaymentLogo ?>" style="width: 100%;    object-fit: contain;height: auto;background: transparent;filter: brightness(16.5); margin_bottom:0; padding-bottom:0;">
                                        <!-- <img src=""> -->
                                    </p>
                                     <div class="form_grid">
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Card Number</p>
                                                <input type="text" class="form-control mandatory" name="card_number" validate="Please enter card number" placeholder="Enter card number">
                                            </div>
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <input type="date" class="form-control mandatory" name="card_date"  max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                            </div>
                                     </div>
                                </div>
                            </div>
                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_danger py-2 px-2">Balance Due<span class="text-white mt-0" use="GSTTOTAMT">₹ 0.00</span></h6>
                            <a href="#" class="due_balance badge_info p-2 mt-1 d-flex justify-content-center align-items-center">Auto-Fill Full Amount</a>
                            <div class="frm_grp span_4 mt-3">
                                <p class="frm-head">Payment Status</p>
                                <div class="cus_check_wrap">
                                    <label class="cus_check pay_check" >
                                        <input type="radio" name="paymentstatus" value='PAID'>
                                        <span class="checkmark">Paid</span>
                                    </label>
                                    <label class="cus_check pay_check" >
                                        <input type="radio" name="paymentstatus" value='UNPAID'>
                                        <span class="checkmark">Unpaid</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
             <div class="edit_registration_invoice spot_listing">
                         <?php
                $paymentCounter   = 0;
                $resFetchSlip	  = slipDetailsOfUser($edituserId, true);
                if ($resFetchSlip) {
                    foreach ($resFetchSlip as $key => $rowFetchSlip) {
                        $counter++;
                        $resPaymentDetails      = paymentDetails($rowFetchSlip['id']);
                        
                        $paymentDescription     = "-";
                        if ($key == 0) {
                            $paymentId = $resPaymentDetails['id'];
                            $slipId    = $rowFetchSlip['id'];
                        }
                        $isChange 		= "YES";
                        $excludedAmount = invoiceAmountOfSlip($rowFetchSlip['id'], false, false);
                        $totalNoOfUnpaidCount = unpaidCountOfPaymnet($slip);

                        $amount 		= invoiceAmountOfSlip($rowFetchSlip['id']);
                        $discountDeductionAmount = ($excludedAmount - $amount);
                        //$discountAmountofSlip= ($discountDeductionAmount/1.18);
                        foreach ($resultFetchInvoice as $key => $rowFetchInvoice) {
                            if ($rowFetchInvoice['service_type'] == "DELEGATE_ACCOMMODATION_REQUEST") {
                                $discountAmountofSlip = $discountDeductionAmount;
                            } else {
                                $discountAmountofSlip = ($discountDeductionAmount / 1.18);
                            }
                        }

                        $DiscountAmount = invoiceDiscountAmountOfSlip($rowFetchSlip['id'], true);
                    ?>
                       <div class="spot_box">
                        <div class="spot_box_top">
                            <div class="spot_name">
                                <div class="regi_name">PV No <?= $rowFetchSlip['slip_number'] ?></div>
                                <div class="regi_contact">
                                    <span>
                                        <?php call(); ?>Mode <?= $rowFetchSlip['invoice_mode'] ?>
                                    </span>
                                    <span>
                                        <?php email(); ?>Date <?= setDateTimeFormat2($rowFetchSlip['slip_date'], "D") ?>
                                    </span>
                                </div>
                            </div>
                            <div class="spot_details">
                                <div class="spot_details_box">
                                    <h5>PV Amount</h5>
                                    <h6></h6>
                                    <small>Discount: <?= ($DiscountAmount > 0) ? ($rowFetchSlip['currency'] . '&nbsp;' . number_format($DiscountAmount, 2)) : '-' ?></small>
                                </div>
                                <div class="spot_details_box">
                                    <h5>Total Amount</h5>
                                    <h6><?= $rowFetchSlip['currency'] . '&nbsp;' . number_format($amount, 2) ?></h6>
                                </div>
                                <div class="spot_details_box">
                                    <h5>Paid Amount</h5>
                                    <h6><?
										if ($resPaymentDetails['totalAmountPaid'] > 0) {
											echo $rowFetchSlip['currency'] . '&nbsp;' . number_format($resPaymentDetails['totalAmountPaid'], 2);
											// echo $rowFetchSlip['currency'] . '&nbsp;' . number_format($amount, 2);
										} else {
											echo $rowFetchSlip['currency'] . '&nbsp;' . "0.00";
										}
										?></h6>

                                </div>
                                <div class="spot_details_box align-items-end">
                                    <h5>Slip Created</h5>
                                    <?
                                       $historyOfSlip = historyOfslip($rowFetchSlip['id']);
                                       // Remove the text part
                                       if ($historyOfSlip) {
                                            foreach ($historyOfSlip as $key => $value) {

                                                // Remove the text part
                                                $cleanDateTime = str_replace('Slip Created On ', '', $value);

                                                // Create DateTime object
                                                $dt = DateTime::createFromFormat('d/m/Y h:i:s A', trim($cleanDateTime));

                                                if ($dt) {
                                                    $onlyDate = $dt->format('d/m/Y');
                                                    $onlyTime = $dt->format('h:i:s A');
                                                }
                                            }
                                        }
                                    ?>
                                    <h6><?php calendar(); ?><?= $onlyDate?></h6>
                                    <h6><?php clock() ?><?= $onlyTime?></h6>
                                
                                </div>
                            </div>
                        </div>
                        <?

                        foreach ($resPaymentDetails['paymentDetails'] as $key => $rowPayment) {

                            $paymentCounter++;
                            $lastPaymentStatus = $rowPayment['payment_status'];

                            // Start box
                            $paymentDescription = '<div class="pv_box_mid badge_success">';

                            switch ($rowPayment['payment_mode']) {
                                 case 'Cash':
                                    $paymentDescription .= '<small>Paid by Cash.</small>';
                                    $paymentDescription .= '<small>Date of Deposit: ' .
                                        setDateTimeFormat2($rowPayment['cash_deposit_date'], "D") . '</small>';
                                      
                                    if (!empty($rowPayment['cash_document'])) {
                                        $paymentDescription .= '<small>
                                            Document:
                                            <a href="' . _BASE_URL_ . $cfg['FILES.ABSTRACT.REQUEST'] . $rowPayment['cash_document'] . '" target="_blank">View</a> |
                                            <a href="' . _BASE_URL_ . $cfg['FILES.ABSTRACT.REQUEST'] . $rowPayment['cash_document'] . '" download>Download</a>
                                        </small>';
                                    }
                                    $payMode= 'Cash';
                                    break;

                                case 'Online':
                                    $paymentDescription .= '<small>Paid by Online.</small>';
                                    $paymentDescription .= '<small>Date of Payment: ' .
                                        setDateTimeFormat2($rowPayment['payment_date'], "D") . '</small>';

                                    if (!empty($rowPayment['atom_atom_transaction_id'])) {
                                        $paymentDescription .= '<small>Transaction Number: ' .
                                            $rowPayment['atom_atom_transaction_id'] . '</small>';
                                    }

                                    if (!empty($rowPayment['atom_bank_transaction_id'])) {
                                        $paymentDescription .= '<small>Bank Transaction Number: ' .
                                            $rowPayment['atom_bank_transaction_id'] . '</small>';
                                    }
                                   $payMode= 'Online';
                                    break;

                                case 'Card':
                                    $paymentDescription .= '<small>Paid by Card.</small>';
                                    $paymentDescription .= '<small>Reference Number: ' .
                                        $rowPayment['card_transaction_no'] . '</small>';
                                    $paymentDescription .= '<small>Date of Payment: ' .
                                        setDateTimeFormat2($rowPayment['card_payment_date'], "D") . '</small>';
                                        $payMode= 'Card';
                                    break;

                                case 'Draft':
                                    $paymentDescription .= '<small>Paid by Draft.</small>';
                                    $paymentDescription .= '<small>Draft Number: ' .
                                        $rowPayment['draft_number'] . '</small>';
                                    $paymentDescription .= '<small>Draft Date: ' .
                                        setDateTimeFormat2($rowPayment['draft_date'], "D") . '</small>';
                                    $paymentDescription .= '<small>Bank: ' .
                                        $rowPayment['draft_bank_name'] . '</small>';
                                         $payMode= 'Draft';
                                    break;

                                case 'NEFT':
                                    $paymentDescription .= '<small>Paid by NEFT/UPI.</small>';
                                    $paymentDescription .= '<small>Transaction Number: ' .
                                        $rowPayment['neft_transaction_no'] . '</small>';
                                    $paymentDescription .= '<small>Transaction Date: ' .
                                        setDateTimeFormat2($rowPayment['neft_date'], "D") . '</small>';
                                    $paymentDescription .= '<small>Bank: ' .
                                        $rowPayment['neft_bank_name'] . '</small>';

                                    if (!empty($rowPayment['neft_document'])) {
                                        $paymentDescription .= '<small>
                                            Document:
                                            <a href="' . _BASE_URL_ . $cfg['FILES.ABSTRACT.REQUEST'] . $rowPayment['neft_document'] . '" target="_blank">View</a> |
                                            <a href="' . _BASE_URL_ . $cfg['FILES.ABSTRACT.REQUEST'] . $rowPayment['neft_document'] . '" download>Download</a>
                                        </small>';
                                    }
                                     $payMode= 'Neft';
                                    break;

                                case 'RTGS':
                                    $paymentDescription .= '<small>Paid by RTGS.</small>';
                                    $paymentDescription .= '<small>Transaction Number: ' .
                                        $rowPayment['rtgs_transaction_no'] . '</small>';
                                    $paymentDescription .= '<small>Transaction Date: ' .
                                        setDateTimeFormat2($rowPayment['rtgs_date'], "D") . '</small>';
                                    $paymentDescription .= '<small>Bank: ' .
                                        $rowPayment['rtgs_bank_name'] . '</small>';
                                         $payMode= 'RTGS';
                                    break;

                                case 'Cheque':
                                    $paymentDescription .= '<small>Paid by Cheque.</small>';
                                    $paymentDescription .= '<small>Cheque Number: ' .
                                        $rowPayment['cheque_number'] . '</small>';
                                    $paymentDescription .= '<small>Cheque Date: ' .
                                        setDateTimeFormat2($rowPayment['cheque_date'], "D") . '</small>';
                                    $paymentDescription .= '<small>Bank: ' .
                                        $rowPayment['cheque_bank_name'] . '</small>';
                                          $payMode= 'Cheque';
                                    break;

                                case 'UPI':
                                    $paymentDescription .= '<small>Paid by UPI.</small>';

                                    if (!empty($rowPayment['txn_no'])) {
                                        $paymentDescription .= '<small>Transaction Number: ' .
                                            $rowPayment['txn_no'] . '</small>';
                                    }

                                    if (!empty($rowPayment['upi_transaction_number'])) {
                                        $paymentDescription .= '<small>Transaction Number: ' .
                                            $rowPayment['upi_transaction_number'] . '</small>';
                                    }

                                    if (!empty($rowPayment['upi_bank_name'])) {
                                        $paymentDescription .= '<small>Bank: ' .
                                            $rowPayment['upi_bank_name'] . '</small>';
                                    }

                                    if (!empty($rowPayment['upi_date'])) {
                                        $paymentDescription .= '<small>Date: ' .
                                            setDateTimeFormat2($rowPayment['upi_date'], "D") . '</small>';
                                    }
                                     if (!empty($rowPayment['neft_document'])) {
                                        $paymentDescription .= '<small>
                                            Document:
                                            <a href="' . _BASE_URL_ . $cfg['FILES.ABSTRACT.REQUEST'] . $rowPayment['neft_document'] . '" target="_blank">View</a> |
                                            <a href="' . _BASE_URL_ . $cfg['FILES.ABSTRACT.REQUEST'] . $rowPayment['neft_document'] . '" download>Download</a>
                                        </small>';
                                    }
                                        $payMode= 'Upi';
                                    break;
                            }

                            if (!empty($rowPayment['payment_remark'])) {
                                $paymentDescription .= '<small>Remark: ' .
                                    $rowPayment['payment_remark'] . '</small>';
                            }

                            $paymentDescription .= '</div>';

                            // OUTPUT
                            echo $paymentDescription;
                        }
                        if($resPaymentDetails['has_to_set_payment'] == 'Yes' && $resPaymentDetails['slip_invoice_mode'] == 'OFFLINE' && ($totalNoOfUnpaidCount == 0)) {
                            $disablePay = 'no';
                        }else{
                            $disablePay = 'yes';
                        }
                        /////////////////payment Option////////
                       if ($resPaymentDetails['has_to_set_payment'] == 'Yes') {
                            if ($resPaymentDetails['slip_invoice_mode'] == 'ONLINE') {
                                $changeCompl = 'show';
                                $complOnlinepay = 'show';
                             }elseif ($resPaymentDetails['slip_invoice_mode'] == 'OFFLINE' && ($totalNoOfUnpaidCount == 0)) {
                                 $setPayTerm = "show";
                            }
                       }
                       if($rowPayment['payment_status'] == "UNPAID"){
                        if ($rowPayment['status'] == "D") {
                              $setPayTerm = "show";
                        }else{
                            $makePay = "show";
                             $disablePay = 'yes';
                        }
                       }
                        /////////////////////////////////////////
                        // echo "<pre>";
                        // print_r($resPaymentDetails);
                        if($resPaymentDetails['totalPendingAmount']>$resPaymentDetails['amount']){
                            $partialPay = 'yes';
                        }else{
                            $partialPay = 'no';
                        }
                        $disabledAttr = ($disablePay == 'yes') ? 'disabled' : '';
                       if(($rowFetchSlip['invoice_mode'] =='ONLINE' || $disablePay=='no') && ($resPaymentDetails['totalPendingAmount']>0)){
                        ?>
                        <div class="pv_box_mid badge_dark">
                            <?
                             if($rowFetchSlip['invoice_mode'] =='ONLINE'){
                            ?>
                            <a href="<?= _BASE_URL_ . "index.php?key=" . base64_encode($rowFetchUser['user_email_id']) ?>"  target="_blank" class="badge_padding badge_primary icon_hover action-transparent">Payment via Link </a>
                            <a href="<?= $cfg['SECTION_BASE_URL'] ?>registration.process.php?act=changePaymentMode&delegateId=<?= $rowFetchSlip['delegate_id'] ?>&slipId=<?= $rowFetchSlip['id'] ?>&paymentId=<?= $rowPayment['id'] ?>&registrationMode=OFFLINE" class="badge_padding badge_primary icon_hover action-transparent">Change Payment Mode To Offline</a>
                             <?   
                              }else{
                                ?>
                               <a href="<?= $cfg['SECTION_BASE_URL'] ?>registration.process.php?act=changePaymentMode&delegateId=<?= $rowFetchSlip['delegate_id'] ?>&slipId=<?= $rowFetchSlip['id'] ?>&paymentId=<?= $rowPayment['id'] ?>&registrationMode=ONLINE" class="badge_padding badge_primary icon_hover action-transparent">Change Payment Mode To Online</a>
                               <?
                              }
                            ?>
                            <a  class="badge_padding badge_primary icon_hover action-transparent"  href="<?= $cfg['SECTION_BASE_URL'] ?>registration.process.php?act=makeComplemantary&delegateId=<?= $rowFetchSlip['delegate_id'] ?>&slipId=<?= $rowFetchSlip['id'] ?>&paymentId=<?= $rowPayment['id'] ?>">Convert to Complementary </a>

                        </div>
                        <?php
                        }
                        ?>
                        <div class="accm_bottom spot_box_bottom">
                            <div class="spot_box_bottom_left">
                                <div class="action_div">
                                    <a href="invoice_send_mail.php" class="icon_hover badge_info br-5 w-auto action-transparent"><?php view() ?>Send Mail</a>
                                    <a href="invoice_send_sms.php" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?>Send SMS</a>
                                </div>
                            </div>
                            <div class="spot_box_bottom_right spot_box_bottom_right_edit">
                                <a href="#" class="badge_info showPaymentDiv" data-tab="<?= $rowFetchSlip['id'] ?>"><?php add(); ?>Make Payment</a>
                                <a href="<?= _BASE_URL_ ?>downloadFinalInvoice.php?delegateId=<?= $mycms->encoded($rowFetchUser['id']) ?>&slipId=<?= $mycms->encoded($rowFetchSlip['id']) ?>&original=true" target="_blank" class="print"><?php printi(); ?>Print PV</a>
                                <a href="<?= _BASE_URL_ ?>downloadSlippdf.php?delegateId=<?= $mycms->encoded($rowFetchUser['id']) ?>&slipId=<?= $mycms->encoded($rowFetchSlip['id']) ?>" target="_blank" class="badge_secondary"><?php bag(); ?>Download PV</a>
                                <a href="#" class="drp icon_hover badge_dark action-transparent">Invoice<?php down(); ?></a>
                                
                            </div>
                        </div>
                        <div class="accm_tariff spot_service_break">
                            <div class="service_breakdown_wrap mt-0">
                                <h4><?php invoive(); ?>Invoice Breakdown</h4>
                                <div class="table_wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="sl">#</th>
                                                <th>Invoice Details</th>
                                                <th>Invoice For</th>
                                                <th>Invoice Amount</th>
                                                <th class="action">Status</th>
                                                <th class="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
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
                                                            $type = "CONFERENCE REGISTRATION - " . $thisUserDetails['user_full_name'];
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
                                                                $type = $cfg['RESIDENTIAL_NAME'] . " - " . $thisUserDetails['user_full_name'];
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
                                                            $type = "ACCOMMODATION BOOKING - " . $thisUserDetails['user_full_name'];
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
                                            <tr>
                                                <td class="sl"><?= $invoiceCounter ?></td>
                                                <td>
                                                    <div class="regi_name">Invoice No <?= $rowFetchInvoice['invoice_number'] ?></div>
                                                    <div class="regi_contact">
                                                        <span>
                                                            <?php invoive(); ?><?= $rowFetchInvoice['invoice_mode'] ?>
                                                        </span>
                                                        <span>
                                                            <?php calendar(); ?>Invoice Date : <?= setDateTimeFormat2($rowFetchInvoice['invoice_date'], "D") ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    NATCON 2025-00033
                                                </td>
                                                <td>
                                                    <?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmount, 2) ?>
                                                </td>
                                                <td class="action text-right">
                                                   <?php
                                                    if ($rowFetchInvoice['payment_status'] == "COMPLIMENTARY") {
                                                    ?>
                                                        <span style="color:#5E8A26;">Complimentary</span>
                                                    <?php
                                                    } elseif ($rowFetchInvoice['payment_status'] == "ZERO_VALUE") {
                                                    ?>
                                                        <span style="color:#009900;">Zero Value </span>
                                                    <?php
                                                    } else if ($rowFetchInvoice['payment_status'] == "PAID") {
                                                    ?>
                                                        <span class="mi-1 badge_padding badge_success w-max-con text-uppercase"><?php paid() ?>Paid</span>
                                                    <?php
                                                    } else if ($rowFetchInvoice['payment_status'] == "UNPAID") {
                                                    ?>
                                                        <span class="mi-1 badge_padding badge_danger w-max-con text-uppercase"><?php unpaid() ?>UNPAID</span>
                                                        <?php
                                                        if ($rowFetchInvoice['invoice_mode'] == 'ONLINE') {
                                                        ?>
                                                            <!-- <br><a class="ticket ticket-important" operationMode="proceedPayment" onclick="changePaymentPopup('<?= $rowFetchSlip['id'] ?>','<?= $rowFetchUser['id'] ?>','OFFLINE')">Change Payment Mode</a>&nbsp; -->

                                                    <?php
                                                        }
                                                    }
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <div class="action_div">
                                                        <!-- <a href="#" class="icon_hover badge_primary br-5 w-auto action-transparent"><?php view() ?></a>
                                                        <a href="#" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a> -->
                                                        <?php
											if (($rowFetchInvoice['payment_status'] == "PAID" || $rowFetchInvoice['payment_status'] == "UNPAID")) {
											?>
												<a class="icon_hover badge_primary br-5 w-auto action-transparent" href="print.invoice.php?user_id=<?= $rowFetchUser['id'] ?>&invoice_id=<?= $rowFetchInvoice['id'] ?>" target="_blank">
													<?php view() ?></a>

											<?php
											}
											?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                                    }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="edit_registration_invoice" >
                            <div class="registration-pop_body_box_inner paymentDiv"  id="paymentDiv_<?= $rowFetchSlip['id'] ?>"  style="display:none;">
                                <h4 class="registration-pop_body_box_heading">
                                    <span><i class="fal fa-envelope"></i>Make Payment</span>
                                    <!-- <a class="add mi-1"><i class="fal fa-arrow-left"></i>Back</a> -->
                                </h4>
                                <div class="registration-pop_body p-0">
                                    <div class="registration-pop_body_box">
                                        <div class="registration-pop_body_box_inner">
                                        
                                            <div class="form_grid">
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Slip No</p>
                                                    <p class="typed_data"><?= $rowFetchSlip['slip_number'] ?></p>
                                                </div>
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Slip Date</p>
                                                    <p class="typed_data"><?= setDateTimeFormat2($rowFetchSlip['slip_date'], "D") ?></p>
                                                </div>
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Payment Mode</p>
                                                    <p class="typed_data"><?= $rowFetchSlip['invoice_mode'] ?></p>
                                                </div>
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Discount Amt.</p>
                                                    <p class="typed_data"><?= $rowFetchSlip['currency'] ?> <? $DiscountAmount = invoiceDiscountAmountOfSlip($rowFetchSlip['id'], true);
																										echo number_format($DiscountAmount, 2); ?></p>
                                                </div>
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Slip Amt.</p>
                                                    <p class="typed_data"><?= $rowFetchSlip['currency'] ?> <?= number_format($amount, 2) ?></p>
                                                </div>
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Paid Amt.</p>
                                                    <p class="typed_data"><?
                                                        if ($resPaymentDetails['totalAmountPaid'] > 0) {
                                                            echo number_format($resPaymentDetails['totalAmountPaid'], 2);
                                                        } else {
                                                            echo "0.00";
                                                        }
                                                        ?></p>
                                                </div>
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Payment Status</p>
                                                    <p class="typed_data"><?=$rowFetchSlip['payment_status']?></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="registration-pop_body_box">
                                        <div class="registration-pop_body_box_inner">
                                              <?php
                                                    $sqlFetchInvoice                = getRegistrationInvoiceCancelInvoiceDetails("", $edituserId, "");
                                                    $id =$edituserId;
                                                    // echo '<pre>'; print_r($sqlFetchInvoice);																
                                                    $resultFetchInvoice             = $mycms->sql_select($sqlFetchInvoice);
                                                    $totalAmountAll = 0;
                                                   
                                                    
                                                
                                                    if ($resultFetchInvoice) {
                                                            foreach ($resultFetchInvoice as $key => $rowFetchInvoice) {
                                                            $showTheRecord = true;
                                                            $resPaymentDetails      = paymentDetails($rowFetchInvoice['slip_id']);
                                                            $resFetchSlip	  = slipDetailsOfUser($edituserId, true);
                                                            // echo '<pre>'; print_r($resPaymentDetails ); echo '</pre>'; 

                                                            //  echo '<pre>'; print_r($resPaymentDetails ); echo '</pre>'; 
                                                            $thisUserDetails 	= getUserDetails($rowFetchInvoice[$edituserId]);
                                                            $thisUserClasfId 	= getUserClassificationId($rowFetchInvoice[$edituserId]);
                                                            $thisUserClasfName 	= getRegClsfName(getUserClassificationId($rowFetchInvoice[$edituserId]));
                                                    
                                                            $totalAmountAll += $totalAmount;
                                                                $showTheRecord = true;

                                                                $invoiceCounter++;
                                                                $slip = getInvoice($rowFetchInvoice['slip_id']);
											                    $totalNoOfUnpaidCount = unpaidCountOfPaymnet($slip);

                                                                $returnArray    = discountAmount($rowFetchInvoice['id']);
                                                                $percentage     = $returnArray['PERCENTAGE'];
                                                                $totalAmount    = $returnArray['TOTAL_AMOUNT'];
                                                                $discountAmount = $returnArray['DISCOUNT'];

                                                                //  echo '<pre>'; print_r($totalNoOfUnpaidCount ); echo '</pre>'; 

                                                                $thisUserDetails 	= getUserDetails($rowFetchInvoice[$id]);
                                                                $thisUserClasfId 	= getUserClassificationId($rowFetchInvoice[$id]);
                                                                $thisUserClasfName 	= getRegClsfName(getUserClassificationId($rowFetchInvoice[$id]));
                                                        
                                                                $totalAmountAll += $totalAmount;
                                                                
                                                                $type			 	= "";
                                                                if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                                                    $type = getInvoiceTypeSummary($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "CONFERENCE");
                                                                    $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-gift" aria-hidden="true"></i>&nbsp;Conference Registration';
                                                                }
                                                                if ($rowFetchInvoice['service_type'] == "DELEGATE_RESIDENTIAL_REGISTRATION") {
                                                                    $isResReg = true;
                                                                    $type = getInvoiceTypeSummary($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "RESIDENTIAL");
                                                                    $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-gift" aria-hidden="true"></i>&nbsp;' . $type;

                                                                    $sqlAccomm = array();
                                                                    $sqlAccomm['QUERY']    = " SELECT accomm.*, hotel.hotel_name
                                                                                                    FROM " . _DB_REQUEST_ACCOMMODATION_ . " accomm
                                                                                            INNER JOIN " . _DB_MASTER_HOTEL_ . " hotel
                                                                                                    ON accomm.hotel_id = hotel.id
                                                                                                    WHERE accomm.`user_id` = ?
                                                                                                    AND accomm.`refference_invoice_id` = ?";
                                                                    $sqlAccomm['PARAM'][]  = array('FILD' => 'user_id',  				'DATA' => $delegate_id,  			'TYP' => 's');
                                                                    $sqlAccomm['PARAM'][]  = array('FILD' => 'refference_invoice_id',  	'DATA' => $rowFetchInvoice['id'],  	'TYP' => 's');
                                                                    $resAccomm = $mycms->sql_select($sqlAccomm);

                                                                    foreach ($resAccomm as $kk => $row) {
                                                                        $serviceSummary[$rowFetchInvoice['id'] . 'accm'] = '';

                                                                        $accommodationRecords[$rowFetchInvoice['id']]['KEY'] 			= $rowFetchInvoice['id'] . 'accm';
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['BOOK-TYP'] 		= 'RES-PACK';
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['accomId'] 		= $row['id'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['packageId']	 	= $cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'] 	= $row['hotel_name'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['checkin_date'] 	= $row['checkin_date'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['checkout_date'] 	= $row['checkout_date'];

                                                                        $accommodationRecords[$rowFetchInvoice['id']]['WILL-SHARE'] 	= false;
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE'] 			= array();

                                                                        //$serviceSummary[$rowFetchInvoice['id'].'accm'] = '<i class="fa fa-building" aria-hidden="true" style="cursor:pointer;" onClick="openAccmDateEditPopup(this)" accomId="'.$row['id'].'" packageId="'.$cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId].'"></i>&nbsp;Accommodation @ '.$row['hotel_name'].' <span style="font-size:12px;">['.$row['checkin_date'].' to '.$row['checkout_date'].']</span>';

                                                                        if (in_array($thisUserClasfId, $cfg['RESIDENTIAL_SHARING_CLASF_ID'])) {
                                                                            $accommodationRecords[$rowFetchInvoice['id']]['WILL-SHARE'] 			= true;
                                                                            $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['KEY'] 			= $rowFetchInvoice['id'] . 'accmshr';
                                                                            $serviceSummary[$rowFetchInvoice['id'] . 'accmshr']						= '';

                                                                            if (trim($row['preffered_accommpany_name']) != '') {
                                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['accomId'] 		= $row['id'];
                                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefName'] 		= $row['preffered_accommpany_name'];
                                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefMobile'] 	= $row['preffered_accommpany_mobile'];
                                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['prefEmail'] 	= $row['preffered_accommpany_email'];
                                                                                /*$serviceSummary[$rowFetchInvoice['id'].'accmshr'] = '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o" aria-hidden="true" style="cursor:pointer;" onClick="openSharePrefEditPopup(this)" accomId="'.$row['id'].'" prefName="'.$row['preffered_accommpany_name'].'"  prefMobile="'.$row['preffered_accommpany_mobile'].'"  prefEmail="'.$row['preffered_accommpany_email'].'"></i>&nbsp;'.$row['preffered_accommpany_name'].'<br>
                                                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;'.$row['preffered_accommpany_mobile'].'<br>
                                                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;'.$row['preffered_accommpany_email'].'';*/
                                                                            } else {
                                                                                $accommodationRecords[$rowFetchInvoice['id']]['SHARE']['accomId'] = $row['id'];
                                                                                //$serviceSummary[$rowFetchInvoice['id'].'accmshr'] = '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o" aria-hidden="true" style="cursor:pointer;" onClick="openSharePrefEditPopup(this)" accomId="'.$row['id'].'"></i>&nbsp;-';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if ($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION") {
                                                                    $workShopDetails = getWorkshopDetails($rowFetchInvoice['refference_id'], true);
                                                                    $type = getInvoiceTypeSummary($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "WORKSHOP");
                                                                    if ($workShopDetails['showInInvoices'] != 'Y') {
                                                                        $showTheRecord 		= false;
                                                                    }
                                                                    $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp;' . $workShopDetails['classification_title'];
                                                                }
                                                                if ($rowFetchInvoice['service_type'] == "ACCOMPANY_CONFERENCE_REGISTRATION") {
                                                                    $type = getInvoiceTypeSummary($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "ACCOMPANY");
                                                                    $accompanyDetails = getUserDetails($rowFetchInvoice['refference_id']);
                                                                    if ($accompanyDetails['registration_request'] == 'GUEST') {
                                                                        $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-smile-o" aria-hidden="true"></i>&nbsp;Accompaning Guest - ' . $accompanyDetails['user_full_name'];
                                                                    } else {
                                                                        $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-users" aria-hidden="true"></i>&nbsp;Accompany - ' . $accompanyDetails['user_full_name'];
                                                                    }
                                                                }
                                                                if ($rowFetchInvoice['service_type'] == "DELEGATE_ACCOMMODATION_REQUEST") {
                                                                    $type = getInvoiceTypeSummary($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "ACCOMMODATION");
                                                                    //$serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-building" aria-hidden="true"></i>&nbsp;Accomodation';

                                                                    //$showTheRecord = false;
                                                                    $sqlAccomm = array();
                                                                    $sqlAccomm['QUERY']    = " SELECT accomm.*, hotel.hotel_name
                                                                                                    FROM " . _DB_REQUEST_ACCOMMODATION_ . " accomm
                                                                                            INNER JOIN " . _DB_MASTER_HOTEL_ . " hotel
                                                                                                    ON accomm.hotel_id = hotel.id
                                                                                                    WHERE accomm.`user_id` = ?
                                                                                                    AND accomm.`refference_invoice_id` = ?";
                                                                    $sqlAccomm['PARAM'][]  = array('FILD' => 'user_id',  				'DATA' => $delegate_id,  			'TYP' => 's');
                                                                    $sqlAccomm['PARAM'][]  = array('FILD' => 'refference_invoice_id',  	'DATA' => $rowFetchInvoice['id'],  	'TYP' => 's');
                                                                    $resAccomm = $mycms->sql_select($sqlAccomm);
                                                                    //echo "<pre>";print_r($resAccomm);echo "</pre>";
                                                                    foreach ($resAccomm as $kk => $row) {
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['BOOK-TYP'] = 'ACCOMMODATION';
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['accomId'] = $row['id'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['packageId'] = $row['package_id'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'] = $row['hotel_name'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['checkin_date'] = $row['checkin_date'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['checkout_date'] = $row['checkout_date'];
                                                                        $accommodationRecords[$rowFetchInvoice['id']]['SHARE'] = array();
                                                                        //$serviceSummary[$rowFetchInvoice['id'].'accm'] = '<i class="fa fa-building" aria-hidden="true" style="cursor:pointer;" onClick="openAccmDateEditPopup(this)" accomId="'.$row['id'].'" packageId="'.$cfg['RESIDENTIAL_PACKAGE_ARRAY'][$thisUserClasfId].'"></i>&nbsp;Accommodation @ '.$row['hotel_name'].' <span style="font-size:12px;">['.$row['checkin_date'].' to '.$row['checkout_date'].']</span>';
                                                                    }

                                                                    $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-building" aria-hidden="true"></i>&nbsp;Accommodation @ ' . $accommodationRecords[$rowFetchInvoice['id']]['hotel_name'];
                                                                }
                                                                if ($rowFetchInvoice['service_type'] == "DELEGATE_TOUR_REQUEST") {
                                                                    $tourDetails = getTourDetails($invoiceDetails['refference_id']);
                                                                    $type = getInvoiceTypeSummary($rowFetchInvoice['delegate_id'], $rowFetchInvoice['refference_id'], "TOUR");
                                                                    $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-bus" aria-hidden="true"></i>&nbsp;Tour';
                                                                }
                                                                if ($rowFetchInvoice['service_type'] == "DELEGATE_DINNER_REQUEST") {
                            
                                                                    $sqlDetails  = array();
                                                                    $sqlDetails['QUERY'] = "  SELECT dinnerReq.*,  
                                                                                                    dinner.dinner_classification_name, dinner.date AS dinnerDate,
                                                                                                    user.user_full_name, dinner.dinner_hotel_name,
                                                                                                    inv.id AS invoiceId
                                                                                                FROM "._DB_REQUEST_DINNER_." dinnerReq
                                                                                        INNER JOIN "._DB_DINNER_CLASSIFICATION_." dinner
                                                                                                ON dinner.id = dinnerReq.package_id
                                                                                        INNER JOIN "._DB_USER_REGISTRATION_." user
                                                                                                ON user.id = dinnerReq.refference_id
                                                                                    LEFT OUTER JOIN "._DB_INVOICE_." inv
                                                                                                ON inv.id = dinnerReq.refference_invoice_id
                                                                                                AND inv.status = 'A'
                                                                                                AND inv.service_type IN('DELEGATE_DINNER_REQUEST','DELEGATE_CONFERENCE_REGISTRATION','DELEGATE_RESIDENTIAL_REGISTRATION','ACCOMPANY_CONFERENCE_REGISTRATION')
                                                                                            WHERE dinnerReq.status = ?
                                                                                                AND dinnerReq.`refference_invoice_id` = ?";
                                                                                                
                                                                    $sqlDetails['PARAM'][]  = array('FILD' => 'status', 'DATA' =>'A',            	'TYP' => 's');
                                                                    $sqlDetails['PARAM'][]  = array('FILD' => 'refference_invoice_id', 'DATA' =>$rowFetchInvoice['id'],  		'TYP' => 's');
                                                                    
                                                                    $resDetails = $mycms->sql_select($sqlDetails);
                                                                
                                                                    $type =$resDetails[0]['dinner_classification_name']."-".$resDetails[0]['dinner_hotel_name']."<br>".$resDetails[0]['dinnerDate'];
                                                                                                                                
                                                                    $serviceSummary[$rowFetchInvoice['id']] = '<i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Dinner';
                                                                    
                                                                }
                                                                if (isset($rowFetchInvoice['Refund_status']) && $rowFetchInvoice['Refund_status'] == 'Not_refunded') {
                                                                    $rowBackGround = "#FFFFCA";
                                                                } elseif (isset($rowFetchInvoice['Refund_status']) && $rowFetchInvoice['Refund_status'] == 'Refunded') {
                                                                    $rowBackGround = "#FFCCCC";
                                                                } else {
                                                                    $rowBackGround = "#FFFFFF";
                                                                }

                                                                if ($rowFetchInvoice['payment_status'] == "COMPLIMENTARY") {
                                                                    $payment_status = ' <span style="color:#5E8A26;">Complimentary</span>';
                                                                ?>
                                                                <?php
                                                                } elseif ($rowFetchInvoice['payment_status'] == "ZERO_VALUE") {
                                                                    $payment_status =' <span style="color:#009900;">Zero Value</span>';
                                                                ?>
                                                                <?php
                                                                } else if ($rowFetchInvoice['payment_status'] == "PAID") {

                                                                    if (!($rowFetchInvoice['service_type'] == "DELEGATE_WORKSHOP_REGISTRATION" && $workShopDetails['display'] == 'N')) {
                                                                        $totalPaid += $totalAmount;
                                                                    }
                                                                    $paymentModeDisplay = $resPaymentDetails['payment_mode'] == 'NEFT' ? 'NEFT/UPI' : ($resPaymentDetails['payment_mode'] == 'Cheque' ? 'Cheque/DD' : $resPaymentDetails['payment_mode']);
                                                                    $payment_status = ' <span style="color:#5E8A26;">Paid</span>';
                                                                } else if ($rowFetchInvoice['payment_status'] == "UNPAID") {
                                                                    $hasUnpaidBill	 = true;
                                                                    $totalUnpaid 	+= $totalAmount;
                                                                    $payment_status= ' <span style="color:#C70505;">Unpaid</span>';
                                                                ?>
                                                                <?php
                                                                }

                                                                // if ($rowFetchInvoice['service_type'] == "DELEGATE_CONFERENCE_REGISTRATION") {
                                                                    
                                                    ?>
                                                    <p class="frm-head text_dark d-flex justify-content-between align-items-center"><?=$type?><span class="text-white"><?= $rowFetchInvoice['currency'] ?> <?= number_format($totalAmount, 2) ?></span></p>
                                                <?php
                                                    }
                                                    }
                                                    ?>
                                            <hr class="my-3" style="height: 0;border-top: 1px dashed currentColor;background: transparent;">
                                            <?
                                            if($resPaymentDetails['totalPendingAmount']>0 &&  $setPayTerm == "show"){
                                            ?>
                                            <p class="frm-head text_dark d-flex justify-content-between align-items-center" name="discountAmount" operationmode="spotdiscountAmount">Discount<span value="<? $DiscountAmount = invoiceDiscountAmountOfSlip($rowFetchSlip['id'], true);
																										echo number_format($DiscountAmount, 2); ?>" class="text-white">₹ <input class="dis_input" id="discountInput"  type="number"></span></p>
                                            <?php
                                            }
                                            ?>
                                            <hr class="my-3" style="height: 0;border-top: 1px dashed currentColor;background: transparent;">
                                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">Subtotal <span class="text-white"><?= $rowFetchSlip['currency'] ?> <?= number_format($amount, 2) ?></span></p>
                                            <p class="frm-head text_dark d-flex justify-content-between align-items-center">GST (18%) <span class="text-white">₹ 0.00</span></p>
                                            <h5 class="regi_total">
                                                Total<span id="totalAmount"><?= $rowFetchSlip['currency'] ?> <?= number_format($amount, 2) ?></span>
                                            </h5>
                                        </div>
                                    </div>
                                    <fieldset class="disableAtt">

                                    <div class="registration-pop_body_box" style="min-width: 300px;">
                                        <div class="registration-pop_body_box_inner">
                                            <div class="form_grid">
                                                 <?php
                                                    $offline_payments = json_decode($cfg['PAYMENT.METHOD']);

                                                    $sql_qr = array();
                                                    $sql_qr['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . "
                                                                                                WHERE `id`!='' AND `title`IN ('QR Code','Online Payment Logo')";
                                                    $result = $mycms->sql_select($sql_qr);
                                                    $onlinePaymentLogo = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['image'];
                                                    $QR_code = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[1]['image'];
                                                    // echo $offline_payments;
                                                    ?>
                                                    
                                                <div class="frm_grp span_4">
                                                    <p class="frm-head">Payment Mode</p>
                                                        <input type="hidden" id="disableMode" value="<?= $disablePay ?>">
                                                        <input type="hidden" id="paymode" value="<?= $payMode ?>">
                                                     <div class="cus_check_wrap ">
                                                        <?php if (in_array("Neft", $offline_payments)) { ?>
                                                        <label class="cus_check pay_check pay_check_mode" data-tab="neft">
                                                            <input type="radio" name="payment_mode" value="Neft"  <?= ($payMode == 'Neft') ? 'checked' : '' ?> >
                                                            <span class="checkmark">Neft</span>
                                                        </label>
                                                        <?php } ?>

                                                        <?php if (in_array("Upi", $offline_payments)) { ?>
                                                        <label class="cus_check pay_check pay_check_mode" data-tab="neft"  >
                                                            <input type="radio" value="Upi"  name="payment_mode" <?= ($payMode == 'Upi') ? 'checked' : '' ?>>
                                                            <span class="checkmark">UPI</span>
                                                        </label>
                                                        <?php } ?>
                                                        <?php if (in_array("Card", $offline_payments)) { ?>
                                                            <label class="cus_check pay_check pay_check_mode" data-tab="Card" >
                                                                <input type="radio" value="Card" name="payment_mode" <?= ($payMode == 'Card') ? 'checked' : '' ?>> 
                                                                <span class="checkmark">Card</span>
                                                            </label>
                                                        <?php } ?>

                                                        <?php if (in_array("Cheque/DD", $offline_payments)) { ?>
                                                        <label class="cus_check pay_check pay_check_mode" data-tab="dd">
                                                            <input type="radio" value="Cheque" name="payment_mode"  <?= ($payMode == 'Cheque') ? 'checked' : '' ?> >
                                                            <span class="checkmark">Cheque/DD</span>
                                                        </label>
                                                        <?php } ?>
                                                        <?php if (in_array("Cash", $offline_payments)) { ?>
                                                        <label class="cus_check pay_check pay_check_mode" data-tab="Cash" >
                                                            <input type="radio" value="Cash"  name="payment_mode" <?= ($payMode == 'Cash') ? 'checked' : '' ?> >
                                                            <span class="checkmark">Cash</span>
                                                        </label>
                                                        <?php } ?>
                                                        

                                                    </div>
                                                </div>
                                                <div class="payment_details span_4" id="neft">
                                                    <div class="form_grid">
                                                        <!-- <h6 class="d-flex justify-content-between align-items-center">Transfer via Net Banking or NEFT/IMPS.</h6> -->
                                                            <!-- <div>
                                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center">Bank<span class="text-white"><?= $cfg['INVOICE_BANKNAME'] ?></span></p>
                                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center">Account<span class="text-white"><?= $cfg['INVOICE_BANKACNO'] ?></span></p>
                                                                <p class="frm-head text_dark d-flex justify-content-between align-items-center mb-0">IFSC<span class="text-white"><?= $cfg['INVOICE_BANKIFSC'] ?></span></p>
                                                            </div> -->
                                                            <!-- <?php
                                                            if (in_array("Upi", $offline_payments)) {
                                                            ?>
                                                            <div class="text-center for-upi-only frm_grp span_4" >
                                                                <img style="margin-bottom: 10px; padding: 5px;border-radius: 5px; vertical-align: middle; background: white; width: 100px;height: 100px;" src="<?= $QR_code ?>" alt="">

                                                                <p>Scan QR</p>
                                                            </div>
                                                            <?php } ?> -->
                                                            <div class="frm_grp span_4 for-neft-rtgs-only">
                                                                <p class="frm-head">Drawee Bank</p>
                                                                <input type="text" class="form-control mandatory" value="<?=$resPaymentDetails['neft_bank_name']?>" name="neft_bank_name" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                                            </div>
                                                            <div class="frm_grp span_4 for-upi-only">
                                                                <p class="frm-head">Drawee Bank</p>
                                                                <input type="text" class="form-control mandatory"  value="<?=$resPaymentDetails['upi_bank_name']?>" name="upi_bank_name" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                                            </div>
                                                        <div class="frm_grp span_2 for-neft-rtgs-only">
                                                            <p class="frm-head">Date</p>
                                                           <input type="date" name="neft_date" value="<?=$resPaymentDetails['neft_date']?>" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                                        </div>
                                                         <div class="frm_grp span_2 for-upi-only">
                                                            <p class="frm-head">Date</p>
                                                            <input type="date" class="form-control mandatory"  value="<?=$resPaymentDetails['upi_date']?>" name="upi_date"  max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                                        </div>
                                                        <?php
                                                            if (in_array("Neft", $offline_payments)) {
                                                            ?>
                                                        <div class="frm_grp span_2 for-neft-rtgs-only">
                                                            <p class="frm-head">UTR Number</p>
                                                            <input type="text" class="form-control mandatory utrnft"  value="<?=$resPaymentDetails['neft_transaction_no']?>"  name="neft_transaction_no" id="neft_transaction_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                                                        </div>
                                                        <?php } ?>
                                                        <?php
                                                            if (in_array("Neft", $offline_payments)) {
                                                            ?>
                                                        <div class="frm_grp span_2 for-upi-only">
                                                            <p class="frm-head">UPI Transaction No.</p>
                                                            <input type="text" class="form-control mandatory utrnft"  value="<?=$resPaymentDetails['txn_no']?>"  name="txn_no" id="txn_no" validate="Please enter transaction number" placeholder="Enter Transaction Id">
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <!-- <div class="frm_grp span_4">
                                                            <p class="frm-head">Upload Payment Receipt</p>
                                                            <input type="file" accept="image/*,application/pdf"   value="<?=$resPaymentDetails['neft_document']?>" name="neft_document" id="neft_document" class="mandatory" validate="Please upload a image">
                                                            <span id="neft_file_name" style="display:none;"></span>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="payment_details span_4" id="Cash" >
                                                    <div class="form_grid">
                                                        <div class="frm_grp span_4">
                                                            <p class="frm-head">Date</p>
                                                            <input type="date" class="form-control mandatory"  value="<?=$resPaymentDetails['cash_deposit_date']?>" name="cash_deposit_date" id="cash_deposit_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select date" placeholder="Date">
                                                        </div>
                                                    
                                                        <!-- <div class="frm_grp span_4">
                                                            <p class="frm-head">Upload Payment Receipt</p>
                                                            <input type="file" accept="image/*,application/pdf" name="cash_document"  value="<?=$resPaymentDetails['cash_document']?>" class="mandatory" id="cash_document"  validate="Please upload a image">
                                                            <span id="cash_file_name" style="display:none;"></span>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="payment_details span_4" id="dd" >
                                                    <div class="form_grid">
                                                        <div class="frm_grp span_4">
                                                            <p class="frm-head">Drawee Bank</p>
                                                            <input type="text" class="form-control mandatory" value="<?=$resPaymentDetails['cheque_bank_name']?>" name="cheque_drawn_bank" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                                        </div>
                                                        <div class="frm_grp span_2">
                                                            <p class="frm-head">Date</p>
                                                            <input type="date" class="form-control mandatory" value="<?=$resPaymentDetails['cheque_date']?>" name="cheque_date" id="cheque_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                                        </div>
                                                        <div class="frm_grp span_2">
                                                            <p class="frm-head">DD No.</p>
                                                            <input type="number" class="form-control mandatory"  value="<?=$resPaymentDetails['cheque_number']?>"  name="cheque_number" id="cheque_number" validate="Please enter cheque/DD number" placeholder="Enter DD No." type="number" maxlength="6" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment_details span_4" id="Card">
                                                    <p>
                                                        <img src="<?= $onlinePaymentLogo ?>" style="width: 100%;    object-fit: contain;height: auto;background: transparent;filter: brightness(16.5); margin_bottom:0; padding-bottom:0;">
                                                        <!-- <img src=""> -->
                                                    </p>
                                                     <div class="form_grid">
                                                       <div class="frm_grp span_2">
                                                            <p class="frm-head">Card Number</p>
                                                            <input type="text" class="form-control mandatory"  value="<?=$resPaymentDetails['card_transaction_no']?>" name="card_number" validate="Please enter card number" placeholder="Enter card number">
                                                        </div>
                                                        <div class="frm_grp span_2">
                                                            <p class="frm-head">Date</p>
                                                            <input type="date" class="form-control mandatory" value="<?=$resPaymentDetails['card_payment_date']?>" name="card_date"  max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                                        </div>
                                                        </div>
                                                    <!-- <div class="frm_grp span_4">
                                                        <div class="frm_grp span_2">
                                                            <p class="frm-head">Card Number</p>
                                                            <input type="text" class="form-control mandatory" value="<?=$resPaymentDetails['cheque_bank_name']?>" name="cheque_drawn_bank" validate="Please enter drawn bank" placeholder="Enter Drawee Bank Name">
                                                        </div>
                                                        <div class="frm_grp span_2">
                                                            <p class="frm-head">Date</p>
                                                            <input type="date" class="form-control mandatory" value="<?=$resPaymentDetails['cheque_date']?>" name="cheque_date" id="cheque_date" max="<?= $mycms->cDate("Y-m-d") ?>" min="<?= $mycms->cDate("Y-m-d", "-6 Months") ?>" validate="Please select cheque date">
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_danger py-2 px-2">Balance Due<span id="balanceDue" class="text-white mt-0">₹ <?=$resPaymentDetails['totalPendingAmount']?></span></h6>
                                            <a href="#" class="due_balance badge_info p-2 mt-1 d-flex justify-content-center align-items-center">Auto-Fill Full Amount</a>
                                            <div class="frm_grp span_4 mt-3">
                                                <?php
                                                if($resPaymentDetails['totalPendingAmount']>0 &&  $disablePay =='yes' && $setPayTerm !='show'  && $partialPay == 'no' && $rowPayment['payment_status'] == "UNPAID" ){
                                                ?>
                                                <p class="frm-head">Payment Status</p>
                                                <div class="cus_check_wrap">
                                                    <label class="cus_check pay_check payment-status-radio" >
                                                        <input type="radio" name="paymentValue" value="discardPay">
                                                         <input type="hidden" name="delegateId" value="<?= $edituserId ?>">
                                                         <input type="hidden" name="slipId" value="<?= $rowFetchSlip['id'] ?>">
                                                         <input type="hidden" name="paymentId" value="<?= $resPaymentDetails['id'] ?>">
                                                        <span class="checkmark">Discard Payment</span>
                                                    </label>
                                                    <label class="cus_check pay_check payment-status-radio" >
                                                        <input type="radio" name="paymentValue" value="makePay" >
                                                         <input type="hidden" name="delegateId" value="<?= $edituserId ?>">
                                                         <input type="hidden" name="slipId" value="<?= $rowFetchSlip['id'] ?>">
                                                         <input type="hidden" name="paymentId" value="<?= $resPaymentDetails['id'] ?>">
                                                         <input type="hidden" name="userREGtype" value="">
                                              
                                                        <span class="checkmark">Make Payment</span>
                                                    </label>
                                                    
                                                </div>
                                                <?
                                                   
                                                }else if($setPayTerm =='show'  && $rowPayment['payment_status'] != "UNPAID" ){
                                                   
                                                    ?>
                                                    
                                                       <div class="cus_check_wrap">
                                                        <label>
                                                            <input type="number" name="amount" operationMode="amount" value="" onkeyup="amountValidation(this)" />
                                                        </label>
                                                        <label class="cus_check pay_check payment-status-radio" >
                                                            <input type="radio" name="paymentValue" value="setPaymentArea" >
                                                            <input type="hidden" name="delegateId" value="<?= $edituserId ?>">
                                                            <input type="hidden" name="slipId" value="<?= $rowFetchSlip['id'] ?>">
                                                            <input type="hidden" name="paymentId" value="<?= $resPaymentDetails['id'] ?>">
                                                            <input type="hidden" name="userREGtype" value="">
                                                
                                                            <span class="checkmark">Set Payment Terms</span>
                                                        </label>
                                                  </div>
                                                    <?
                                                }else if($makePay =='show' && $rowPayment['payment_status'] == "UNPAID")
                                                {
                                                    // echo "<pre>";
                                                    // print_r($rowPayment);
                        
                                                    ?>
                                                     <label class="cus_check_wrap">
                                                        <input   style="text-align:center;"  type="text" value="<?= $rowFetchSlip['currency'] ?> <?=number_format($rowPayment['amount'], 2)?>" disabled/>
                                                         <!-- <h5 class="regi_total">
                                                            Payable Amount<span><?= $rowFetchSlip['currency'] ?> <?= number_format($rowPayment['amount'], 2) ?></span>
                                                        </h5> -->
                                                    </label>
                                                     <div class="cus_check_wrap">
                                                   
                                                     <label class="cus_check pay_check payment-status-radio" >
                                                        <input type="radio" name="paymentValue" value="discardPay">
                                                         <input type="hidden" name="delegateId" value="<?= $edituserId ?>">
                                                         <input type="hidden" name="slipId" value="<?= $rowFetchSlip['id'] ?>">
                                                         <input type="hidden" name="paymentId" value="<?= $rowPayment['payment_id'] ?>">
                                                        <span class="checkmark">Discard Payment</span>
                                                    </label>
                                                    <label class="cus_check pay_check payment-status-radio" >
                                                       <input type="hidden" name="amount"  operationMode="amount" value="<?=$rowPayment['amount']?>" />
                                                        <input type="radio" name="paymentValue" value="makePay" >
                                                         <input type="hidden" name="delegateId" value="<?= $edituserId ?>">
                                                         <input type="hidden" name="slipId" value="<?= $rowFetchSlip['id'] ?>">
                                                         <input type="hidden" name="paymentId" value="<?= $rowPayment['payment_id'] ?>">
                                                         <input type="hidden" name="userREGtype" value="">
                                              
                                                        <span class="checkmark">Make Payment</span>
                                                    </label>
                                                    
                                                </div>
                                                <?

                                                }
                                                else if($resPaymentDetails['totalPendingAmount']<=0){
                                                    ?>
                                                     <label class="cus_check pay_check" >
                                                        <h5 class="regi_total">
                                                            PAID<span><?= $rowFetchSlip['currency'] ?> <?= number_format($amount, 2) ?></span>
                                                        </h5>
                                                    </label>
                                                    <?
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                    </fieldset>
                                      <style>
                                        .form-control:disabled, .form-control[readonly] {
                                                background-color: #2c2c2c!important;
                                                opacity: 1;
                                            }
                                        </style>
                                </div>
                            </div>

                        </div>
                    
                    </div>
                <?
                    }
                }
                ?>
                
                        
                    </div>
                </div>
                <div class="edit_registration_invoice" style="display:none;">
                    <div class="registration-pop_body_box_inner">
                        <h4 class="registration-pop_body_box_heading">
                            <span><i class="fal fa-envelope"></i>Send Mail</span>
                            <a class="add mi-1"><i class="fal fa-arrow-left"></i>Back</a>
                        </h4>
                        <div class=" com_info_wrap">
                            <div class="com_info_left">
                                <h6>Mail Topics</h6>
                                <button data-tab="acknowledgementmail" class="com_info_left_click icon_hover badge_primary active"><i class="fal fa-school"></i>Acknowledgement</button>
                                <button data-tab="workshopcertificatemail" class="com_info_left_click icon_hover badge_secondary action-transparent"><i class="fal fa-rupee-sign"></i>Workshop Certificate</button>
                                <button data-tab="certificatemail" class="com_info_left_click icon_hover badge_success action-transparent"><i class="fal fa-user"></i>Certificate</button>
                                <button data-tab="serviceconfirmationmail" class="com_info_left_click icon_hover badge_info action-transparent"><i class="fal fa-tv-alt"></i>Service Confirmation</button>
                            </div>
                            <div class="com_info_right">
                                <div class="com_info_box active" id="acknowledgementmail">
                                    <div class="com_info_box_grid">
                                        <div class="com_info_box_grid_box">
                                            <h5 class="com_info_box_head">
                                                <n><span class="text_primary"><i class="fal fa-envelope"></i></span> Acknowledgement</n>
                                            </h5>
                                            <div class="com_info_box_inner">
                                                <div class="form_grid g_6">
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Subject <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Name <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Mail ID <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_6">
                                                        <p class="frm-head">Mail Body <i class="mandatory">*</i></p>
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                    <div class="frm_grp span_6 d-flex justify-content-end gp-10">
                                                        <a href="#" class="badge_success formsubmit"><i class="fal fa-paper-plane"></i>Send Mail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="com_info_box" id="workshopcertificatemail">
                                    <div class="com_info_box_grid">
                                        <div class="com_info_box_grid_box">
                                            <h5 class="com_info_box_head">
                                                <n><span class="text_secondary"><i class="fal fa-envelope"></i></span> Workshop Certificate</n>
                                            </h5>
                                            <div class="com_info_box_inner">
                                                <div class="form_grid g_6">
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Subject <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Name <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Mail ID <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_6">
                                                        <p class="frm-head">Mail Body <i class="mandatory">*</i></p>
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                    <div class="frm_grp span_6 d-flex justify-content-end gp-10">
                                                        <a href="#" class="badge_success formsubmit"><i class="fal fa-paper-plane"></i>Send Mail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="com_info_box" id="certificatemail">
                                    <div class="com_info_box_grid">
                                        <div class="com_info_box_grid_box">
                                            <h5 class="com_info_box_head">
                                                <n><span class="text_success"><i class="fal fa-envelope"></i></span> Certificate</n>
                                            </h5>
                                            <div class="com_info_box_inner">
                                                <div class="form_grid g_6">
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Subject <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Name <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Mail ID <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_6">
                                                        <p class="frm-head">Mail Body <i class="mandatory">*</i></p>
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                    <div class="frm_grp span_6 d-flex justify-content-end gp-10">
                                                        <a href="#" class="badge_success formsubmit"><i class="fal fa-paper-plane"></i>Send Mail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="com_info_box" id="serviceconfirmationmail">
                                    <div class="com_info_box_grid">
                                        <div class="com_info_box_grid_box">
                                            <h5 class="com_info_box_head">
                                                <n><span class="text_success"><i class="fal fa-envelope"></i></span> Service Confirmation</n>
                                            </h5>
                                            <div class="com_info_box_inner">
                                                <div class="form_grid g_6">
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Subject <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Name <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Mail ID <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_6">
                                                        <p class="frm-head">Mail Body <i class="mandatory">*</i></p>
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                    <div class="frm_grp span_6 d-flex justify-content-end gp-10">
                                                        <a href="#" class="badge_success formsubmit"><i class="fal fa-paper-plane"></i>Send Mail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="edit_registration_invoice"  style="display:none;">
                    <div class="registration-pop_body_box_inner">
                        <h4 class="registration-pop_body_box_heading">
                            <span><i class="fal fa-envelope"></i>Send SMS</span>
                            <a class="add mi-1"><i class="fal fa-arrow-left"></i>Back</a>
                        </h4>
                        <div class="com_info_wrap">
                            <div class="com_info_left">
                                <h6>SMS Topics</h6>
                                <button data-tab="acknowledgementsms" class="com_info_left_click icon_hover badge_primary active"><i class="fal fa-school"></i>Acknowledgement</button>
                                <button data-tab="serviceconfirmationsms" class="com_info_left_click icon_hover badge_info action-transparent"><?php workshop() ?>Service Confirmation</button>
                            </div>
                            <div class="com_info_right">
                                <div class="com_info_box active" id="acknowledgementsms">
                                    <div class="com_info_box_grid">
                                        <div class="com_info_box_grid_box">
                                            <h5 class="com_info_box_head">
                                                <n><span class="text_primary"><?php email() ?></span> Acknowledgement</n>
                                            </h5>
                                            <div class="com_info_box_inner">
                                                <div class="form_grid g_6">
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Name <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Number <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_6">
                                                        <p class="frm-head">SMS Body <i class="mandatory">*</i></p>
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                    <div class="frm_grp span_6 d-flex justify-content-end gp-10">
                                                        <a href="#" class="badge_success formsubmit"><i class="fal fa-paper-plane"></i>Send SMS</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="com_info_box" id="serviceconfirmationsms">
                                    <div class="com_info_box_grid">
                                        <div class="com_info_box_grid_box">
                                            <h5 class="com_info_box_head">
                                                <n><span class="text_success"><?php email() ?></span> Service Confirmation</n>
                                            </h5>
                                            <div class="com_info_box_inner">
                                                <div class="form_grid g_6">
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Name <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Number <i class="mandatory">*</i></p>
                                                        <input>
                                                    </div>
                                                    <div class="frm_grp span_6">
                                                        <p class="frm-head">SMS Body <i class="mandatory">*</i></p>
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                    <div class="frm_grp span_6 d-flex justify-content-end gp-10">
                                                        <a href="#" class="badge_success formsubmit"><i class="fal fa-paper-plane"></i>Send SMS</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update Registration</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!-- Edit Registration pop up -->
        <!-- New accommodation booking pop up -->
        <div class="pop_up_body" id="newbooking">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>New Hotel Booking</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Guest Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Select Hotel</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check In</p>
                                    <input type="date">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check Out</p>
                                    <input type="date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Confirm Booking</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New accommodation booking pop up -->
        <!-- New session pop up -->
        <div class="pop_up_body " id="newsession">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Compose Session</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <h5 class="registration-pop_body_box_heading"><span>Session Details</span></h5>
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Date</p>
                                    <input type="date">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Start Time</p>
                                    <input type="time">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">End Time</p>
                                    <input type="time">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Hall</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Ref Color</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Type</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Chairpersons</p>
                                    <input date>
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <h5 class="registration-pop_body_box_heading"><span>Talks / Sub-Sessions</span><a class="add mi-1"><?php add() ?>Add</a></h5>
                            <div class="accm_add_wrap talk_sub">
                                <h6 class="accm_add_empty">No talks added yet.</h6>
                                <div class="accm_add_box">
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">Duration</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_7">
                                            <p class="frm-head sub-frm-head">Topic Title</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_5">
                                            <p class="frm-head sub-frm-head">Speaker</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_1">
                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete() ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="accm_add_box">
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">Duration</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_7">
                                            <p class="frm-head sub-frm-head">Topic Title</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_5">
                                            <p class="frm-head sub-frm-head">Speaker</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_1">
                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete() ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Compose Session</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New session pop up -->
        <!-- edit session pop up -->
        <div class="pop_up_body " id="editsession">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Session</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <h5 class="registration-pop_body_box_heading"><span>Session Details</span></h5>
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Date</p>
                                    <input type="date">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Start Time</p>
                                    <input type="time">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">End Time</p>
                                    <input type="time">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Hall</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Ref Color</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Type</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Session Chairpersons</p>
                                    <input date>
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <h5 class="registration-pop_body_box_heading"><span>Talks / Sub-Sessions</span><a class="add mi-1"><?php add() ?>Add</a></h5>
                            <div class="accm_add_wrap talk_sub">
                                <h6 class="accm_add_empty">No talks added yet.</h6>
                                <div class="accm_add_box">
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">Duration</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_7">
                                            <p class="frm-head sub-frm-head">Topic Title</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_5">
                                            <p class="frm-head sub-frm-head">Speaker</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_1">
                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete() ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="accm_add_box">
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">Duration</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_7">
                                            <p class="frm-head sub-frm-head">Topic Title</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_5">
                                            <p class="frm-head sub-frm-head">Speaker</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_1">
                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete() ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update Session</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit session pop up -->
        <!-- New exibitor pop up -->
        <div class="pop_up_body " id="newexibitor">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Exhibitor Registration</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <h5 class="registration-pop_body_box_heading"><span>Exhibitor Details</span></h5>
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Exhibitor Code</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Company Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Company Address</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">State</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">City</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Partnership Type</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Remarks / Reference</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Company GSTIN No</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Company PAN No</p>
                                    <select></select>
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <h5 class="registration-pop_body_box_heading"><span>Contact Persons</span><a class="add mi-1"><?php add() ?>Add</a></h5>
                            <div class="accm_add_wrap exibitor_sub">
                                <h6 class="accm_add_empty">No contact person added yet.</h6>
                                <div class="accm_add_box">
                                    <h5 class="frm_sub_head"><span>Contact Person 1</span><a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete() ?></a></h5>
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">First Name</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">Middle Name</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head sub-frm-head">Last Name</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_3">
                                            <p class="frm-head sub-frm-head">Mobile Number</p>
                                            <input>
                                        </div>
                                        <div class="frm_grp span_3">
                                            <p class="frm-head sub-frm-head">Email Id</p>
                                            <input>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Register Exibitor</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New exibitor pop up -->
        <!-- New guest pop up -->
        <div class="pop_up_body " id="newguest">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Create Guest User</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Full Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Guest Category</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mobile Number</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Email Address</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Organization / Affiliation</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Notes / Remarks</p>
                                    <input>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Create User</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New guest pop up -->
        <!-- Edit guest pop up -->
        <div class="pop_up_body " id="editguest">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Guest User</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Full Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Guest Category</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mobile Number</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Email Address</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Organization / Affiliation</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Notes / Remarks</p>
                                    <input>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update User</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit guest pop up -->
        <!-- Add registration Cutoff pop up -->
        <div class="pop_up_body" id="addregistrationcutoff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Registration Cutoff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_cutoff.process.php" id="frmtypeadd" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" value="insert" />
                    <input type="hidden" name="chk_country_add" id="chk_country_add" value="0" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Registration Cutoff Title</p>
                                        <input type="text" name="workshop_add" id="workshop_add" class="validate[required]" required="" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Start Date</p>
                                        <input type="date" name="seat_limit_add" id="seat_limit_add" class="validate[required]" onblur="countryAvailabilityAdd(this.value)" rel="splDate" required="" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">End Date</p>
                                        <input type="date" name="workshop_date_add" id="workshop_date_add" rel="splDate" required="" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add registration Cutoff pop up -->
        <!-- edit registration Cutoff pop up -->
        <div class="pop_up_body" id="editregistrationcutoff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Registration Cutoff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_cutoff.process.php" id="frmtypeadd" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" value="update" />
                    <input type="hidden" name="cutoff_id" id="cutoff_id" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Registration Cutoff Title</p>
                                        <input type="text" name="cutoff_title" id="cutoff_title" required />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Start Date</p>
                                        <input type="date" name="start_date" id="start_date" rel="splDate" required />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">End Date</p>
                                        <input type="date" name="end_date" id="end_date" rel="splDate" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- edit registration Cutoff pop up -->
        <!-- Add conference date pop up -->
        <div class="pop_up_body" id="addconferencedate">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Conference Date</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_cutoff.process.php" id="frmtypeadd" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" value="insertDate" />
                    <input type="hidden" name="chk_country_add" id="chk_country_add" value="0" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Conference Date</p>
                                        <input type="date" name="conf_date" id="conf_date" class="validate[required]" required="" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add conference date pop up -->
        <!-- Add workshop Cutoff pop up -->
        <div class="pop_up_body" id="addworkshopcutoff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Workshop Cutoff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_cutoff.process.php" id="frmtypeadd" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" value="insertWorkshop" />
                    <input type="hidden" name="chk_country_add" id="chk_country_add" value="0" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Workshop Cutoff Title</p>
                                        <input type="text" name="workshop_add" id="workshop_add" class="validate[required]" required="" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Start Date</p>
                                        <input type="date" name="seat_limit_add" id="seat_limit_add" class="validate[required]" onblur="countryAvailabilityAdd(this.value)" rel="splDate" required="" />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">End Date</p>
                                        <input type="date" name="workshop_date_add" id="workshop_date_add" rel="splDate" required="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add workshop Cutoff pop up -->
        <!-- edit workshop Cutoff pop up -->
        <div class="pop_up_body" id="editworkshopcutoff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Workshop Cutoff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>

                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_cutoff.process.php" id="frmtypeadd" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" value="updateWorkshop" />
                    <input type="hidden" name="cutoff_id" id="cutoff_id_workshp" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Workshop Cutoff Title</p>
                                        <input type="text" name="cutoff_title" id="cutoff_title_workshp" required />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Start Date</p>
                                        <input type="date" name="start_date" id="start_date_workshp" rel="splDate" required />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">End Date</p>
                                        <input type="date" name="end_date" id="end_date_workshp" rel="splDate" required />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- edit workshop Cutoff pop up -->
        <!-- Add workshop type pop up -->
        <div class="pop_up_body" id="addworkshoptype">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Workshop Type</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Workshop Type</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Status</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="workshopstatus">
                                            <span class="checkmark">Active</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="workshopstatus">
                                            <span class="checkmark">Inactive</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add workshop type pop up -->
        <!-- Add workshop pop up -->
        <form name="frmtypeadd"
            id="frmtypeadd"
            method="post"
            action="<?php echo $cfg['SECTION_BASE_URL']."manage_workshop.process.php"; ?>"
            onsubmit="return onSubmitAction();">

            <input type="hidden" name="act" value="insert">
            <input type="hidden" name="chk_country_add" id="chk_country_add" value="0">

            <?php foreach ($searchArray as $key => $val) { ?>
                <input type="hidden" name="<?= $key ?>" value="<?= $val ?>">
            <?php  } ?>

            <div class="pop_up_body" id="addworkshop">
                <div class="registration_pop_up">
                    <div class="registration-pop_heading">
                        <span>Add Workshop</span>
                        <p>
                            <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                        </p>
                    </div>
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Workshop Title <span class="mandatory">*</span></p>
                                        <input type="text" name="workshop_add" id="workshop_add"
                                            class="validate[required]" required="" />
                                    </div>
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Workshop Type <span class="mandatory">*</span></p>
                                        <select name="workshop_type" required="">
                                            <option value="">--select type--</option>
                                            <option value="MASTER CLASS">MASTER CLASS</option>
                                            <option value="WORKSHOP">WORKSHOP</option>
                                            <option value="NORMAL">NORMAL</option>
                                            <option value="BREAKFAST">BREAKFAST</option>
                                            <option value="CADAVER">CADAVER</option>
                                        </select>
                                    </div>
                                    <div class="frm_grp span_3">
                                        <p class="frm-head">Venue <span class="mandatory">*</span></p>
                                        <input type="text" name="venue" id="venue"
                                            required="" />
                                    </div>
                                    <div class="frm_grp span_1">
                                        <p class="frm-head">Seat Limit <span class="mandatory">*</span></p>
                                        <input type="text" name="seat_limit_add" id="seat_limit_add"
                                            class="validate[required]" required="" />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">WorkShop Date</p>
                                        <input type="date" name="workshop_date_add" id="workshop_date_add" rel="splDate" required="" />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Status <span class="mandatory">*</span></p>
                                        <div class="cus_check_wrap">
                                            <label class="cus_check gender_check">
                                                <input type="radio" name="workshopstatus" value="A">
                                                <span class="checkmark">Active</span>
                                            </label>
                                            <label class="cus_check gender_check">
                                                <input type="radio" name="workshopstatus" value="I">
                                                <span class="checkmark">Inactive</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Add workshop pop up -->
        <!-- Edit workshop pop up -->
        <div class="pop_up_body" id="editworkshop">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Workshop</span>
                    <p>
                        <a href="javascript:void(0)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>

                <!-- Form for editing -->
                <form name="frmtypeadd" method="post" action="<?=$cfg['SECTION_BASE_URL']?>manage_workshop.process.php" id="frmtypeadd">
                    <input type="hidden" name="act" value="update" />
                    <input type="hidden" name="workshop_id" id="workshop_id" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Workshop Title</p>
                                        <input type="text" name="workshop_Edit" id="workshop_Edit" class="validate[required]" required />
                                    </div>
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Workshop Type</p>
                                        <select id="workshop_type" name="workshop_type" required>
                                            <option value="MASTER CLASS">MASTER CLASS</option>
                                            <option value="WORKSHOP">WORKSHOP</option>
                                            <option value="NORMAL">NORMAL</option>
                                            <option value="BREAKFAST">BREAKFAST</option>
                                            <option value="CADAVER">CADAVER</option>
                                        </select>
                                    </div>
                                    <div class="frm_grp span_3">
                                        <p class="frm-head">Venue</p>
                                        <input type="text" name="venueEdit" id="venueEdit" required />
                                    </div>
                                    <div class="frm_grp span_1">
                                        <p class="frm-head">Seat Limit</p>
                                        <input type="text" name="seat_limit_Edit" id="seat_limit_Edit"
                                            class="validate[required]" required />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Workshop Date</p>
                                        <input type="date" name="workshop_date_Edit" id="workshop_date_Edit" rel="splDate" required />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Status</p>
                                        <div class="cus_check_wrap">
                                            <label class="cus_check gender_check">
                                                <input type="radio" id="edit_status_active" name="workshopstatus" value="A">
                                                <span class="checkmark">Active</span>
                                            </label>
                                            <label class="cus_check gender_check">
                                                <input type="radio" id="edit_status_inactive" name="workshopstatus" value="I">
                                                <span class="checkmark">Inactive</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit workshop pop up -->
        <!-- Edit workshop tariff pop up -->
        <div class="pop_up_body" id="editworkshoptariff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Update Workshop Tariff</span>
                    <p>
                        <a href="javascript:void(0)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmTariffEdit" id="frmTariffEdit" method="post" action="workshop_tariff.process.php" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" id="act" value="update" />
                    <input type="hidden" name="workshop_classification_id" value="<?= $WorkshopId ?>" />
                    <input type="hidden" name="registration_classification_id" value="<?= $RegClassId ?>" />

                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Workshop Title</p>
                                        <p class="typed_data"><?= $title ?></p>
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Workshop Type</p>
                                        <p class="typed_data"><?= $classification ?></p>
                                    </div>
                                    <?
                                    $sql    =    array();
                                    $sql['QUERY'] = "SELECT cutoff.cutoff_title,cutoff.id 
                                                    FROM " . _DB_WORKSHOP_CUTOFF_ . " cutoff
                                                    WHERE status = ?";
                                    $sql['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
                                    $res = $mycms->sql_select($sql);

                                    foreach ($res as $key => $title) {
                                        $rowsTariffAmount = [
                                            'inr_amount' => '',
                                            'usd_amount' => ''
                                        ];
                                    ?>
                                        <div class="registration-pop_body_box_inner span_2">

                                            <h4 class="registration-pop_body_box_heading">
                                                <span><?= strip_tags($title['cutoff_title']) ?></span>
                                            </h4>
                                            <?


                                            $sqlFetchTariffAmount1 = array();
                                            $sqlFetchTariffAmount1['QUERY'] = "SELECT * 
                                                                        FROM " . _DB_TARIFF_WORKSHOP_ . " 
                                                                        WHERE `workshop_id` = ? 
                                                                        AND `tariff_cutoff_id` = ?
                                                                        AND `registration_classification_id` = ?";
                                            $sqlFetchTariffAmount1['PARAM'][] = array('FILD' => 'workshop_id', 'DATA' => $WorkshopId, 'TYP' => 's');
                                            $sqlFetchTariffAmount1['PARAM'][] = array('FILD' => 'tariff_cutoff_id', 'DATA' => $title['id'], 'TYP' => 's');
                                            $sqlFetchTariffAmount1['PARAM'][] = array('FILD' => 'registration_classification_id', 'DATA' => $RegClassId, 'TYP' => 's');
                                            $resultFetchTariffAmount1 = $mycms->sql_select($sqlFetchTariffAmount1);
                                            $sqlRegClasf      = array();

                                            $sqlRegClasf['QUERY']    = "SELECT `classification_title`,`id`,`currency` 
                                                                    FROM " . _DB_REGISTRATION_CLASSIFICATION_ . " WHERE `id` = '" . $RegClassId . "'";
                                            $resRegClasf            = $mycms->sql_select($sqlRegClasf);

                                            if (!empty($resultFetchTariffAmount1)) {
                                                $rowsTariffAmount = $resultFetchTariffAmount1[0];
                                                // print_r($rowsTariffAmount);
                                            ?>
                                            <?
                                            } else {

                                                $rowsTariffAmount = [
                                                    'inr_amount' => '0.00',
                                                    'usd_amount' => '0.00',
                                                ];
                                            }

                                            $currency = !empty($resRegClasf) ? $resRegClasf[0]['currency'] : '';
                                            ?>

                                            <input type="hidden" name="tariff_cutoff_id_edit[]" id="tariff_cutoff_id_edit_<?= $title['id'] ?>" value="<?= $title['id'] ?>" />
                                            <input type="hidden" class="currencyClass" name="currency[<?= $title['id'] ?>]" id="currency_<?= $title['id'] ?>" value="<?= $currency ?>" />
                                            <div class="form_grid">
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">INR</p>
                                                    <input value="<?= $rowsTariffAmount['inr_amount'] ?>" name="tariff_inr_cutoff_id_edit[<?= $title['id'] ?>]" id="tariff_inr_first_cutoff_id_edit_<?= $title['id'] ?>">
                                                </div>
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">USD</p>
                                                    <input value="<?= $rowsTariffAmount['usd_amount'] ?>" name="tariff_usd_cutoff_id_edit[<?= $title['id'] ?>]" id="tariff_usd_first_cutoff_id_edit_<?= $title['id'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit workshop tariff pop up -->
       <!-- New hotel pop up -->
        <div class="pop_up_body" id="newhotel">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Hotel</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmInsert" id="frmInsert" action="<?= $cfg['SECTION_BASE_URL'] ?>hotel_listing.process.php" method="post" enctype="multipart/form-data" onsubmit="return onSubmitAction();">
	         	    <input type="hidden" name="act" value="insert" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Hotel Details</span>
                                </h4>
                                <div class="form_grid">
                                    <div class="frm_grp span_3">
                                        <p class="frm-head">Hotel Name</p>
                                        <input name="hotel_name_add" id="hotel_name_add" required="" />

                                    </div>
                                    <div class="frm_grp span_1">
                                        <p class="frm-head">Ratings</p>
                                         <select  name="hotelRatings">
                                            <option value="">Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>

                                        </select>
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Hotel Phone No</p>
                                        <input type="number" maxlength="10"  name="hotel_phone_add" id="hotel_phone_add" required="" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Distance From Venue (Km)</p>
                                        <input type="number" name="distance_from_venue_add" id="distance_from_venue_add" required="" />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Check In Date</p>
                                        <input type="date" name="check_in" id="check_in" required="" onchange="updateSeatLimits();" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Check Out Date</p>
                                        <input type="date" name="check_out" id="check_out" required="" onchange="updateSeatLimits();" />
                                    </div>
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Address</p>
                                        <input  name="hotel_address_add" id="hotel_address_add"  required="">
                                    </div>
                                </div>
                            </div>
                            <div class="registration-pop_body_box_inner" id="packageForm_1">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Packages</span>
                                    <a class="add mi-1" id="add_package_1"><?php add(); ?>Add</a>
                                </h4>
                                <!-- <div class="accm_add_wrap" id="accm_add_wrap_1">
                                    <h6 class="accm_add_empty" id="accm_add_empty_1">No Package Available</h6>
                                    <div class="accm_add_box" id="package_box" style="display:none;">
                                        <div class="form_grid">
                                            <div class="frm_grp span_4">
                                                <p class="frm-head">Package Name</p>
                                                <input name="package_name[]">
                                            </div>

                                            <a href="#" onclick="hidePackageBox(); return false;" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                        </div>
                                    </div>
                                  
                                </div> -->
                                 <div class="cus_check_wrap">
                                    <label class="cus_check gender_check">
                                        <input type="checkbox" name="package_name[]" value="Individual">
                                        <span class="checkmark">Individual</span>
                                    </label>
                                    <label class="cus_check gender_check">
                                        <input type="checkbox"name="package_name[]" value="Sharing">
                                        <span class="checkmark">Sharing</span>
                                    </label>
                                    <label class="cus_check gender_check">
                                        <input type="checkbox" name="package_name[]" value="Triple">
                                        <span class="checkmark">Triple</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner"  id="aminityForm_1">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Aminites</span>
                                    <a class="add mi-1" id="add_aminity_1"><?php add(); ?>Add</a>
                                </h4>
                                <div class="accm_add_wrap"  id="accm_add_wrap_2">
                                    <h6 class="accm_add_empty"  id="accm_add_empty_2">No Aminity Available</h6>
                                    <div class="accm_add_box" id="aminity_box" style="display:none;">
                                        <div class="form_grid">
                                            <div class="frm_grp span_3">
                                                <p class="frm-head">Aminity Name</p>
                                                <input name="accessories_name[]">
                                            </div>
                                           <div class="frm_grp span_1 iconBox">
                                                <p class="frm-head">Icon</p>

                                                <input type="file"
                                                    name="accessories_icon[]"
                                                    class="icon_input"
                                                    accept="image/*"
                                                    style="display:none;">

                                                <label class="frm-image uploadIcon">
                                                    <?php upload() ?>
                                                </label>

                                                <div class="frm_img_preview" style="display:none;">
                                                    <img class="iconPreview"
                                                        src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                                    <button type="button" class="removeIcon">
                                                        <?php delete() ?>
                                                    </button>
                                                </div>
                                            </div>

                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="registration-pop_body_box_inner" id="RoomForm_1">
                                <h4 class="registration-pop_body_box_heading">
                                    <input type="hidden" name="room_type_status" id="room_type_status" value="no">
                                    <span>Room Type<label class="toggleswitch">
                                        <input class="toggleswitch-checkbox toggleswitch-checkbox_add" type="checkbox">
                                        <div class="toggleswitch-switch"></div>
                                    </label></span>
                                    <a class="add mi-1" id="add_room_1"><?php add(); ?>Add</a>
                                </h4>
                                <div class="accm_add_wrap" id="accm_add_wrap_3">
                                    <h6 class="accm_add_empty" id="accm_add_empty_3">No Room Type Available</h6>
                                    <div class="accm_add_box accm_add_box_room" id="room_box" style="display:none;">
                                        <div class="form_grid">
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Room Type</p>
                                                <input name="room_type[]">
                                            </div>
                                            <div class="frm_grp span_2 roomImageBox">
                                                <p class="frm-head">Room Image</p>

                                                <input type="file"
                                                    name="room_type_image[]"
                                                    class="room_input"
                                                    accept="image/*"
                                                    style="display:none;">

                                                <label class="frm-image uploadRoomImage">
                                                    <?php upload() ?>
                                                </label>

                                                <div class="frm_img_preview" style="display:none;">
                                                    <img class="roomPreview"
                                                        src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                                    <button type="button" class="removeRoomImage">
                                                        <?php delete() ?>
                                                    </button>
                                                </div>
                                             
                                            </div>
                                            <div class="form_grid span_4 seat_limits_container_room">
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Date</p>
                                                    <p class="typed_data"></p>
                                                </div>
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Seat</p>
                                                    <input  name="seat_limit_room[]" required>
                                                </div>
                                            </div>
                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Seat Limits</span>
                                </h4>
                                <div class="form_grid">
                                    <div class="registration-pop_body_box_inner span_4">
                                        <div class="form_grid" id="seat_limits_container">
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <p class="typed_data"></p>
                                            </div>
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Seat</p>
                                                <input  name="seat_limit[]" required>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Hotel Images</span>
                                </h4>
                                <div class="com_info_branding_wrap form_grid g_2">
                                  <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage" type="button"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input type="file" name="slider_image[]" class="webmaster_background" style="display:none" accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel"><span><?php upload() ?></span></label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload" >
                                            <input style="display: none;"name="slider_image[]"  class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input style="display: none;" name="slider_image[]" class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input style="display: none;" name="slider_image[]" class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input style="display: none;" name="slider_image[]" class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Add Hotel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- New hotel pop up -->
          <!-- <div class="pop_up_body" id="edithotel">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Hotel</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmInsert" id="frmInsert" action="<?= $cfg['SECTION_BASE_URL'] ?>hotel_listing.process.php" method="post" enctype="multipart/form-data" onsubmit="return onSubmitAction();">
	         	    <input type="hidden" name="act" value="insert" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Hotel Details</span>
                                </h4>
                                <div class="form_grid">
                                    <div class="frm_grp span_3">
                                        <p class="frm-head">Hotel Name</p>
                                        <input name="hotel_name_add" id="hotel_name_add" required="" />

                                    </div>
                                    <div class="frm_grp span_1">
                                        <p class="frm-head">Ratings</p>
                                         <select  name="hotelRatings">
                                            <option value="">Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>

                                        </select>
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Hotel Phone No</p>
                                        <input type="number" name="hotel_phone_add" id="hotel_phone_add" required="" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Distance From Venue (Km)</p>
                                        <input type="number" name="distance_from_venue_add" id="distance_from_venue_add" required="" />
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Check In Date</p>
                                        <input type="date" name="check_in" id="check_in" required="" onchange="updateSeatLimits();" />

                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Check Out Date</p>
                                        <input type="date" name="check_out" id="check_out" required="" onchange="updateSeatLimits();" />
                                    </div>
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Address</p>
                                        <input  name="hotel_address_add" id="hotel_address_add"  required="">
                                    </div>
                                </div>
                            </div>
                            <div class="registration-pop_body_box_inner" id="packageForm_1">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Packages</span>
                                    <a class="add mi-1" id="add_package_1"><?php add(); ?>Add</a>
                                </h4>
                                <div class="accm_add_wrap" id="accm_add_wrap_1">
                                    <h6 class="accm_add_empty" id="accm_add_empty_1">No Package Available</h6>
                                    <div class="accm_add_box" id="package_box" style="display:none;">
                                        <div class="form_grid">
                                            <div class="frm_grp span_4">
                                                <p class="frm-head">Package Name</p>
                                                <input name="package_name[]">
                                            </div>

                                            <a href="#" onclick="hidePackageBox(); return false;" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner"  id="aminityForm_1">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Aminites</span>
                                    <a class="add mi-1" id="add_aminity_1"><?php add(); ?>Add</a>
                                </h4>
                                <div class="accm_add_wrap"  id="accm_add_wrap_2">
                                    <h6 class="accm_add_empty"  id="accm_add_empty_2">No Aminity Available</h6>
                                    <div class="accm_add_box" id="aminity_box" style="display:none;">
                                        <div class="form_grid">
                                            <div class="frm_grp span_3">
                                                <p class="frm-head">Aminity Name</p>
                                                <input name="accessories_name[]">
                                            </div>
                                           <div class="frm_grp span_1 iconBox">
                                                <p class="frm-head">Icon</p>

                                                <input type="file"
                                                    name="accessories_icon[]"
                                                    class="icon_input"
                                                    accept="image/*"
                                                    style="display:none;">

                                                <label class="frm-image uploadIcon">
                                                    <?php upload() ?>
                                                </label>

                                                <div class="frm_img_preview" style="display:none;">
                                                    <img class="iconPreview"
                                                        src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                                    <button type="button" class="removeIcon">
                                                        <?php delete() ?>
                                                    </button>
                                                </div>
                                            </div>

                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="registration-pop_body_box_inner" id="RoomForm_1">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Room Type</span>
                                    <a class="add mi-1" id="add_room_1"><?php add(); ?>Add</a>
                                </h4>
                                <div class="accm_add_wrap" id="accm_add_wrap_3">
                                    <h6 class="accm_add_empty" id="accm_add_empty_3">No Room Type Available</h6>
                                    <div class="accm_add_box" id="room_box" style="display:none;">
                                        <div class="form_grid">
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Room Type</p>
                                                <input name="room_type[]">
                                            </div>
                                            <div class="frm_grp span_2 roomImageBox">
                                                <p class="frm-head">Room Image</p>

                                                <input type="file"
                                                    name="room_type_image[]"
                                                    class="room_input"
                                                    accept="image/*"
                                                    style="display:none;">

                                                <label class="frm-image uploadRoomImage">
                                                    <?php upload() ?>
                                                </label>

                                                <div class="frm_img_preview" style="display:none;">
                                                    <img class="roomPreview"
                                                        src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                                    <button type="button" class="removeRoomImage">
                                                        <?php delete() ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Seat Limits</span>
                                </h4>
                                <div class="form_grid">
                                    <div class="registration-pop_body_box_inner span_4">
                                        <div class="form_grid" id="seat_limits_container">
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <p class="typed_data"></p>
                                            </div>
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Seat</p>
                                                <input  name="seat_limit[]" >
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="registration-pop_body_box_inner">
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Hotel Images</span>
                                </h4>
                                <div class="com_info_branding_wrap form_grid g_2">
                                  <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage" type="button"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input type="file" name="slider_image[]" class="webmaster_background" style="display:none" accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel"><span><?php upload() ?></span></label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload" >
                                            <input style="display: none;"name="slider_image[]"  class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input style="display: none;" name="slider_image[]" class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input style="display: none;" name="slider_image[]" class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="com_info_branding_box addBox">
                                        <div class="branding_image_preview">
                                            <img class="previewImage" src="images/Banner KTC BG.png" alt="">
                                            <button class="removeImage"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                        <div class="branding_image_upload">
                                            <input style="display: none;" name="slider_image[]" class="webmaster_background" type="file"  accept="image/*">
                                            <label for="webmaster_background" class="uploadLabel">
                                                <span><?php upload() ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success"><?php save(); ?>Add Hotel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> -->
        <!-- edit hotel pop up -->
        <div class="pop_up_body" id="edithotel">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Hotel</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmUpdate" id="frmUpdate" action="hotel_listing.process.php" method="post" enctype="multipart/form-data" onsubmit="return onSubmitAction();">
                <input type="hidden" name="act" id="act" value="update" />
                <input type="hidden" name="id" id="id" value="<?= $editHotelId?>" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span>Hotel Details</span>
                            </h4>
                              <?php
                                    $sqlFetchHotel				=	array();
                                    $sqlFetchHotel['QUERY']		=	"SELECT * 
                                                                    FROM " . _DB_MASTER_HOTEL_ . "
                                                                    WHERE `id` 		= 	 ? ";

                                    $sqlFetchHotel['PARAM'][]	=	array('FILD' => 'id', 		'DATA' => $editHotelId, 		'TYP' => 's');
                                    $resultFetchHotel    		= $mycms->sql_select($sqlFetchHotel);
                                    $room_type_status = $resultFetchHotel[0]['room_type_status'];
                                  	$sql1			=	array();
									$sql1['QUERY'] = "SELECT min(`check_in_date`) AS checkin								
										        		  FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . "
										        		  WHERE hotel_id = ?
										        		    AND status != ?";
									$sql1['PARAM'][]	=	array('FILD' => 'hotel_id', 'DATA' => $editHotelId, 'TYP' => 's');
									$sql1['PARAM'][]	=	array('FILD' => 'status', 	 'DATA' => 'D', 						'TYP' => 's');
									$result = $mycms->sql_select($sql1);
									$rowFetchcheckIn           = $result[0];

									$sql2			=	array();
									$sql2['QUERY'] = "SELECT max(`check_out_date`) AS checkout								
										        		  FROM " . _DB_ACCOMMODATION_CHECKOUT_DATE_ . "
										        		  WHERE hotel_id = ?
										        		    AND status != ?";

									$sql2['PARAM'][]	=	array('FILD' => 'hotel_id', 'DATA' => $editHotelId, 'TYP' => 's');
									$sql2['PARAM'][]	=	array('FILD' => 'status', 	 'DATA' => 'D', 						'TYP' => 's');
									$result = $mycms->sql_select($sql2);
									$rowFetchcheckOut           = $result[0];

                            
                                ?>
                            <div class="form_grid">
                                <div class="frm_grp span_3">
                                    <p class="frm-head">Hotel Name <i class="mandatory">*</i></p>
                                    <input name="hotel_name_update" id="hotel_name_update"  value="<?= $resultFetchHotel[0]['hotel_name'] ?>" required />

                                </div>
                               <div class="frm_grp span_1">
                                    <p class="frm-head">Ratings</p>
                                    <select name="hotelRatings">
                                        <option value="">Select</option>
                                        <?php
                                        $ratings = [1, 2, 3, 4, 5];
                                        $selectedRating = $resultFetchHotel[0]['hotelRatings'] ?? '';
                                        foreach ($ratings as $r) {
                                            $selected = ($r == $selectedRating) ? 'selected' : '';
                                            echo "<option value=\"$r\" $selected>$r</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Hotel Phone No <i class="mandatory">*</i></p>
                                    <input name="hotel_phone_update" id="hotel_phone_update" value="<?= $resultFetchHotel[0]['hotel_phone_no'] ?>" required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Distance From Venue (Km) <i class="mandatory">*</i></p>
                					<input name="distance_from_venue_update" id="distance_from_venue_update" value="<?=$resultFetchHotel[0]['distance_from_venue'] ?>" required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check In Date <i class="mandatory">*</i></p>
                                    <input type="date" name="check_in" id="check_in_Edit"  required="" value="<?= $rowFetchcheckIn['checkin'] ?>"  onchange="updateSeatLimitsEdit();" >
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Check Out Date <i class="mandatory">*</i></p>
                                    <input type="date" name="check_out" id="check_out_Edit" required="" value="<?= $rowFetchcheckOut['checkout'] ?>"  onchange="updateSeatLimitsEdit();" >
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Address <i class="mandatory">*</i></p>
                                    <input name="hotel_address_update" id="hotel_address_update" value="<?=$resultFetchHotel[0]['hotel_address'] ?>"  >
                                </div>
                            </div>
                        </div>
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span>Packages</span>
                                <a class="add mi-1" id="edit_package_1"><?php add(); ?>Add</a>
                            </h4>
                            
                            <div class="accm_add_wrap" id="accm_edit_wrap_1">

                                <!-- <div class="accm_add_box" id="package_template" style="display:none;">
                                    <div class="form_grid">
                                        <div class="frm_grp span_4">
                                            <p class="frm-head">Package Name</p>
                                            <input name="package_name[]" value="">
                                        </div>


                                    </div>
                                </div> -->
                               
                                 <div class="cus_check_wrap">
                                <?php
                                $allOptions = ['Individual', 'Sharing', 'Triple']; // your checkbox options
                                $sqlFetchPack = array();
                                $sqlFetchPack['QUERY'] = "SELECT `package_name`,`id` 
                                                        FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                        WHERE `status` = ? AND `hotel_id` = ?";

                                $sqlFetchPack['PARAM'][] = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');
                                $sqlFetchPack['PARAM'][] = array('FILD' => 'hotel_id', 'DATA' => $editHotelId, 'TYP' => 's');

                                $resultFetchPack = $mycms->sql_select($sqlFetchPack);
                                foreach ($allOptions as $option) {

                                    // Check if this option exists in fetched packages
                                    $isChecked = '';
                                    if (!empty($resultFetchPack)) {
                                        foreach ($resultFetchPack as $rowFetchPack) {
                                            if ($rowFetchPack['package_name'] == $option) {
                                                $isChecked = 'checked';
                                                $packageId = $rowFetchPack['id']; // get the ID to populate hidden input
                                                break;
                                            }
                                        }
                                    } else {
                                        $packageId = ''; // no package found
                                    }

                                    ?>
                                    <label class="cus_check gender_check">
                                        <input type="checkbox" name="package_name[]" value="<?= $option ?>" <?= $isChecked ?>>
                                        <input type="hidden" name="package_id[]" value="<?= $packageId ?>">
                                        <span class="checkmark"><?= $option ?></span>
                                    </label>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_body_box">
                       <div class="registration-pop_body_box_inner"  >
                                <h4 class="registration-pop_body_box_heading">
                                    <span>Aminites</span>
                                    <a class="add mi-1" id="edit_aminity_1"><?php add(); ?>Add</a>
                                </h4>
                                <div class="accm_add_wrap"  id="accm_edit_wrap_2">
                                    <div class="accm_add_box" id="aminity_box_edit" style="display:none;">
                                        <div class="form_grid">
                                            
                                            <div class="frm_grp span_3">
                                                <p class="frm-head">Aminity Name</p>
                                                <input name="accessories_name[]">
                                            </div>
                                           <div class="frm_grp span_1 iconBox_edit">
                                                <p class="frm-head">Icon</p>

                                                <input type="file"
                                                    name="accessories_icon[]"
                                                    class="icon_input_edit"
                                                    accept="image/*"
                                                    style="display:none;">
                                                    <input type="hidden" name="accessories_id[]" value="<?= $aminity['id'] ?? '' ?>">
                                                    <input type="hidden" name="accessories_exist_icon[]" value="<?= $aminity['accessories_icon'] ?? '' ?>">
                                                <label class="frm-image uploadIcon_edit">
                                                    <?php upload() ?>
                                                </label>

                                                <div class="frm_img_preview" style="display:none;">
                                                    <img class="iconPreview_edit"
                                                        src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                                    <button type="button" class="removeIcon_edit">
                                                        <?php delete() ?>
                                                    </button>
                                                </div>
                                            </div>

                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>

                                        </div>
                                    </div>
                                    <?php
                                        $sqlAcc = array();
                                        $sqlAcc['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $editHotelId . "' AND status='A' AND purpose='aminity'  ORDER BY `id` ASC";

                                        $queryAcc = $mycms->sql_select($sqlAcc, false);
                                        
                                    if ($queryAcc) { 
                                        foreach ($queryAcc as $keyqueryAcc => $aminity) {
                                         $icon = _BASE_URL_.'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $aminity['accessories_icon'];
                                    ?>
                                    <div class="accm_add_box">
                                        <div class="form_grid">
                                            <h6 class="accm_add_empty"  style="display:none;" id="accm_edit_empty_2">No Aminity Available</h6>

                                            <div class="frm_grp span_3">
                                                <p class="frm-head">Aminity Name</p>
                                                <input name="accessories_name[]" value="<?= $aminity['accessories_name'] ?>">
                                            </div>
                                           <div class="frm_grp span_1 iconBox_edit">
                                                <p class="frm-head">Icon</p>

                                                <input type="file"
                                                    name="accessories_icon[]"
                                                    class="icon_input_edit"
                                                    accept="image/*"
                                                    style="display:none;">
                                                <input type="hidden" name="accessories_id[]" value="<?= $aminity['id'] ?? '' ?>">
												<input type="hidden" name="accessories_exist_icon[]" value="<?= $aminity['accessories_icon'] ?>">
                                                <label class="frm-image uploadIcon_edit" style="display:none;">
                                                    <?php upload() ?>
                                                </label>

                                                <div class="frm_img_preview" style="display: block;">
                                                    <img class="iconPreview_edit iconPreview"
                                                        src="<?= $icon?>">
                                                    <button type="button" class="removeIcon_edit">
                                                        <?php delete() ?>
                                                    </button>
                                                </div>
                                            </div>

                                            <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>

                                        </div>
                                    </div>
                                 <?
                                }
                                }else{
                                   ?>
                                    <h6 class="accm_add_empty"  id="accm_edit_empty_2">No Aminity Available</h6>
                                   <?
                                
                                }
                                ?>
                                </div>
                            </div>
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span>Room Type<label class="toggleswitch">
                                    <input
                                        class="toggleswitch-checkbox toggleswitch-checkbox_edit"
                                        type="checkbox"
                                        id="roomToggleEdit"
                                        <?= (trim(strtolower($room_type_status)) === 'yes') ? 'checked' : '' ?>
                                    >

                                    <div class="toggleswitch-switch"></div>

                                    <!-- hidden MUST be after -->
                                    <input
                                        type="hidden"
                                        name="room_type_status"
                                        id="room_type_status_edit"
                                        value="<?= $room_type_status ?>"
                                    >
                                </label></span>
                                <a class="add mi-1" id="edit_room_1"><?php add(); ?>Add</a>
                            </h4>
                            <div class="accm_add_wrap" id="accm_edit_wrap_3">
                                <div class="accm_add_box accm_add_box_edit_room"  id="room_box_edit" style="display:none;">
                                    <div class="form_grid">
                                        <h6 class="accm_add_empty"  style="display:none;"  id="accm_edit_empty_3" >No Room Type Available</h6>
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">Room Type</p>
                                           <input name="room_type[]">
                                        </div>
                                        <div class="frm_grp span_2 roomImageBox_edit">
                                            <p class="frm-head">Room Image</p>
                                              <input type="file"
                                                    name="room_type_image[]"
                                                    class="room_input_edit"
                                                    accept="image/*"
                                                    style="display:none;">
                                              <input type="hidden" name="room_exist_icon[]" value=" ">
											 <input type="hidden" name="room_type_id[]" value="">

                                            <label  class="frm-image uploadRoomImage_edit"><?php upload() ?></label>
                                            <div class="frm_img_preview" style="display:none;">
                                                <img class="roomPreview_edit" src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                                <button  type="button" class="removeRoomImage_edit"><?php delete() ?></button>
                                            </div>
                                        </div>
                                         <div class="form_grid span_4 seat_limits_container_room_edit">
                                            <!-- <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <p class="typed_data"></p>
                                            </div>
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Seat</p>
                                                <input  name="seat_limit_room[]" >
                                            </div> -->
                                        </div>
                                        <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                    </div>
                                </div>
                                <?php
                                $sqlRoom = array();
                                $sqlRoom['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $editHotelId . "' AND status='A' AND purpose='room'  ORDER BY `id` ASC";

                                $queryRoom = $mycms->sql_select($sqlRoom, false);
                                if ($queryRoom) { 
                                    foreach ($queryRoom as $roomIndex  => $row) {
                                    $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];

                                ?>
                                <div class="accm_add_box accm_add_box_edit_room"  data-room-index="<?= $roomIndex ?>">
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">Room Type</p>
                                           <input name="room_type[<?= $roomIndex ?>]" value="<?= $row['accessories_name'] ?>">
                                        </div>
                                        <div class="frm_grp span_2 roomImageBox_edit" >
                                            <p class="frm-head">Room Image</p>
                                              <input type="file"
                                                    name="room_type_image[<?= $roomIndex ?>]"
                                                    class="room_input_edit"
                                                    accept="image/*"
                                                    style="display:none;">
											 <input type="hidden" name="room_exist_icon[<?= $roomIndex ?>]" value="<?= $row['accessories_icon'] ?>">
											 <input type="hidden" name="room_type_id[<?= $roomIndex ?>]" value="<?= $row['id'] ?>">

                                            <label  class="frm-image uploadRoomImage_edit" style="display:none;"><?php upload() ?></label>
                                            <div class="frm_img_preview" style="display:block;">
                                                <img class="roomPreview_edit" src="<?= $icon ?>">
                                                <button  type="button" class="removeRoomImage_edit"><?php delete() ?></button>
                                            </div>
                                        </div>
                                        <?php
                                        $sql = array();
                                        $sql['QUERY'] = "SELECT *
                                                        FROM `rcg_accommodation_seat_limit`
                                                        WHERE `hotel_id` = ?
                                                        AND `status` != ?
                                                        AND `room_id` = ? ";
                                        $sql['PARAM'][] = array('FILD'=>'hotel_id','DATA'=>$editHotelId,'TYP'=>'s');
                                        $sql['PARAM'][] = array('FILD'=>'status','DATA'=>'D','TYP'=>'s');
                                        $sql['PARAM'][] = array('FILD'=>'room_id','DATA'=>$row['id'],'TYP'=>'s');
                                        $result = $mycms->sql_select($sql);

                                        foreach ($result as $rowSeatLimitRoom) {
                                        ?>
                                        <div class="form_grid span_4 seat_limits_container_room_edit">
                                            
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Date</p>
                                                <p class="typed_data"><?= date('d/m/Y', strtotime($rowSeatLimitRoom['check_in_date'])) ?></p>
                                            </div>
                                            <div class="frm_grp span_2">
                                                <p class="frm-head">Seat</p>
                                                <input  name="seat_limit_room[<?= $roomIndex ?>][]" value="<?= $rowSeatLimitRoom['seat_limit'] ?>"  >
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><?php delete(); ?></a>
                                    </div>
                                </div>
                                 <?
                                }
                                }else{
                                   ?>
                                    <!-- <h6 class="accm_add_empty"  id="accm_edit_empty_3">No Room Type Available</h6> -->
                                   <?
                                
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                        <h4 class="registration-pop_body_box_heading">
                            <span>Seat Limits</span>
                        </h4>

                        <!-- SINGLE container -->
                        <div id="seat_limits_container_Edit">

                            <?php
                            $sql = array();
                            $sql['QUERY'] = "SELECT *
                                            FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . "
                                            WHERE hotel_id = ?
                                            AND status != ?";
                            $sql['PARAM'][] = array('FILD'=>'hotel_id','DATA'=>$editHotelId,'TYP'=>'s');
                            $sql['PARAM'][] = array('FILD'=>'status','DATA'=>'D','TYP'=>'s');
                            $result = $mycms->sql_select($sql);

                            foreach ($result as $rowSeatLimit) {
                            ?>
                            <input type="hidden" name="checkInid[]" id="" value=<?= $rowSeatLimit['id'] ?>>

                                <div class="registration-pop_body_box_inner span_4 seat-row">
                                    <div class="form_grid">
                                        <div class="frm_grp span_2">
                                            <p class="frm-head">Date</p>
                                            <p class="typed_data">
                                                <?= date('d/m/Y', strtotime($rowSeatLimit['check_in_date'])) ?>
                                            </p>
                                            <input type="hidden" name="seat_date[]" value="<?= $rowSeatLimit['check_in_date'] ?>">
                                        </div>

                                        <div class="frm_grp span_2">
                                            <p class="frm-head">Seat</p>
                                            <input type="number"
                                                name="seat_limit[]"
                                                value="<?= $rowSeatLimit['seat_limit'] ?>"
                                                min="0">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span>Hotel Images</span>
                            </h4>
                            <div class="com_info_branding_wrap com_info_branding_wrap1 form_grid g_2">
                           <?php
                                $maxImages = 5;

                                $sqlRoom = [];
                                $sqlRoom['QUERY'] = "
                                    SELECT * 
                                    FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . " 
                                    WHERE hotel_id = '".$editHotelId."' 
                                    AND status = 'A' 
                                    AND purpose = 'slider'
                                  ORDER BY `id` ASC";

                                $querySlider = $mycms->sql_select($sqlRoom, false);
                                $imageCount  = is_array($querySlider) ? count($querySlider) : 0;
                                ?>
                                <!-- EXISTING IMAGES -->
                                <?php if ($imageCount > 0): ?>
                                    <?php foreach ($querySlider as $row): ?>
                                        <?php
                                            $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];
                                        ?>
                                        <div class="com_info_branding_box editBox" >
                                            <div class="branding_image_preview" style="display:Block">
                                                <img class="editpreviewImage" src="<?= $icon ?>" alt="Hotel Image">
                                                <button class="editremoveImage" type="button" data-id="<?= $row['id'] ?>">
                                                    <i class="fal fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            <div class="branding_image_upload" style="display:none">
                                                <input style="display: none;"name="slider_image[]"  class="webmaster_background" type="file"  accept="image/*">
                                               	<input type="hidden" name="slider_exist_icon[]" value="<?= $row['accessories_icon'] ?>">
                                                <input type="hidden" name="slider_id[]" value="<?= $row['id'] ?>">
                                                <label for="webmaster_background" class="edituploadLabel">
                                                    <span><?php upload() ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                 <?php
                                    $remaining = $maxImages - $imageCount;
                                    
                                    for ($i = 0; $i < $remaining; $i++) {
                                        ?>
                                        <div class="com_info_branding_box editBox">
                                            <div class="branding_image_preview">
                                                <img class="editpreviewImage" src="images/Banner KTC BG.png" alt="">
                                                <button  type="button"  class="editremoveImage"><i class="fal fa-trash-alt"></i></button>
                                            </div>
                                            <div class="branding_image_upload" >
                                                <input style="display: none;"name="slider_image[]"  class="webmaster_background" type="file"  accept="image/*">
                                                <input type="hidden" name="slider_exist_icon[]" value="">
                                                <input type="hidden" name="slider_id[]" value="">
                                                <label for="webmaster_background" class="edituploadLabel">
                                                    <span><?php upload() ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                        
                            </div>
                        </div>

                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update Hotel</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- edit hotel pop up -->
        <!-- view hotel pop up -->
        <div class="pop_up_body" id="viewhotel">
            <div class="profile_pop_up">
                <div class="profile_pop_left">
                    <?php
                        $sqlFetchHotel				=	array();
                        $sqlFetchHotel['QUERY']		=	"SELECT * 
                                                        FROM " . _DB_MASTER_HOTEL_ . "
                                                        WHERE `id` 		= 	 ? ";

                        $sqlFetchHotel['PARAM'][]	=	array('FILD' => 'id', 		'DATA' => $hotelId, 		'TYP' => 's');
                        $resultFetchHotel    		= $mycms->sql_select($sqlFetchHotel);

                    ?>
                    <div class="profile_left_box text-center ">
                        <h5><?= $resultFetchHotel[0]['hotel_name'] ?></h5>
                        <h6 class="star fivestar"> <?php
                            $rating = (int)$resultFetchHotel[0]['hotelRatings'];

                            for ($i = 1; $i <= $rating; $i++) {
                                star();
                            }
                            ?></h6>
                        <!-- class name varied like "fivestar" "fourstar" "threestar" -->
                        <div class="regi_type justify-content-center">
                        <?php
                                $sqlFetchPack				=	array();
                                $sqlFetchPack['QUERY']		=	"SELECT `package_name` 
                                                                FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                                WHERE `status` 		= 	 ?
                                                                AND `hotel_id` 		= 	 ? ";

                                $sqlFetchPack['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'A', 		'TYP' => 's');
                                $sqlFetchPack['PARAM'][]	=	array('FILD' => 'hotel_id', 		'DATA' => $hotelId, 		'TYP' => 's');

                                $resultFetchPack    		= $mycms->sql_select($sqlFetchPack);
                            
                                if ($resultFetchPack) {
                                foreach ($resultFetchPack as $keyPack => $rowFetchPack) {
                            ?>
                            <span class="badge_padding badge_default"><?= $rowFetchPack['package_name'] ?></span>
                            <?php
                                 }

                               }
                           ?>
                        </div>
                    </div>
                    <div class="profile_left_box">
                        <ul>
                            <li>
                                <?php call(); ?>
                                <p>
                                    <b>Phone</b>
                                    <span><?= $resultFetchHotel[0]['hotel_phone_no'] ?></span>
                                </p>
                            </li>
                             <?php
                                $sql 		    	  =	array();
                                $sql['QUERY'] = "SELECT min(`check_in_date`) AS checkin								
                                                FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . "
                                                WHERE hotel_id = ?
                                                    AND status != ?";
                                $sql['PARAM'][]	=	array('FILD' => 'hotel_id', 	'DATA' => $hotelId, 'TYP' => 's');
                                $sql['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'D', 				 'TYP' => 's');
                                $result = $mycms->sql_select($sql);
                                $rowFetchcheckIn           = $result[0];

                                $sql 		    	  =	array();
                                $sql['QUERY'] = "SELECT max(`check_out_date`) AS checkout								
                                                FROM " . _DB_ACCOMMODATION_CHECKOUT_DATE_ . "
                                                WHERE hotel_id = ?
                                                    AND status !=?";

                                $sql['PARAM'][]	=	array('FILD' => 'hotel_id', 	'DATA' => $hotelId, 'TYP' => 's');
                                $sql['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'D', 				 'TYP' => 's');
                                $result = $mycms->sql_select($sql);
                                $rowFetchcheckOut           = $result[0];

                             ?>
                            <li>
                                <?php calendar(); ?>
                                <p>
                                    <b>Check In Date</b>
                                    <span><?= date('d-m-Y',strtotime($rowFetchcheckIn['checkin'])) ?></span>
                                </p>
                            </li>
                            <li>
                                <?php calendar(); ?>
                                <p>
                                    <b>Check Out Date</b>
                                    <span><?= date('d-m-Y',strtotime($rowFetchcheckOut['checkout'])) ?></span>
                                </p>
                            </li>
                            <li>
                                <?php address(); ?>
                                <p>
                                    <b>Address</b>
                                    <span><?= $resultFetchHotel[0]['hotel_address'] ?></span>
                                </p>
                            </li>
                            <li>
                                <?php address(); ?>
                                <p>
                                    <b>Distance From Venue (Km)</b>
                                    <span><?= $resultFetchHotel[0]['distance_from_venue'] ?></span>
                                </p>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="profile_pop_right">
                    <div class="profile_pop_right_heading">
                        <span>Hotel Details</span>
                        <p>
                            <!-- <a href="javascript:void(null)" class="icon_hover badge_primary action-transparent"><?php export(); ?></a> -->
                            <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                        </p>
                    </div>
                    <div class="profile_pop_right_body">
                        <ul class="profile_payments_grid_ul">
                            <?php
                            $sqlRoom = array();
                            $sqlRoom['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $hotelId . "' AND status='A' AND purpose='slider'  ORDER BY `id` ASC";

                            $querySlider = $mycms->sql_select($sqlRoom, false);
                            foreach ($querySlider as $k => $row) {
                                //echo '<pre>'; print_r($row);

                                $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];
                            ?>
                            <li class="p-0 overflow-hidden">
                                <img class="w-25" src="<?= $icon?>">
                                
                            </li>
                             <!-- <li class="p-0 overflow-hidden">
                                <img class="w-100" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                            </li>
                            <li class="p-0 overflow-hidden">
                                <img class="w-100" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                            </li>
                            <li class="p-0 overflow-hidden">
                                <img class="w-100" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                            </li>
                            <li class="p-0 overflow-hidden">
                                <img class="w-100" src="https://ruedakolkata.com/natcon_2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/MAILER_LOGO_0001_250526185918.png">
                            </li> -->
                            <?php
                            }
                            ?>
                           
                        </ul>
                        <div class="service_breakdown_wrap">
                            <h4>Seat Limit</h4>
                            <div class="table_wrap">
                                <table>
                                    <thead>
                                         
                                            <tr>
                                            <?php
                                                $sql 		    	  =	array();
                                                $sql['QUERY'] = "SELECT `check_in_date`,`seat_limit`								
                                                                            FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . "
                                                                            WHERE hotel_id = ?
                                                                                AND status != ?";
                                                $sql['PARAM'][]	=	array('FILD' => 'hotel_id', 	'DATA' => $hotelId, 'TYP' => 's');
                                                $sql['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'D', 				 'TYP' => 's');
                                                $result = $mycms->sql_select($sql);
                                                // $rowSeatLimit          = $result[0];
                                                foreach ($result as $key => $rowSeatLimit) {
                                                ?>
                                                    <th class="text-center"><?= date('d-m-Y',strtotime($rowSeatLimit['check_in_date'])) ?></th>
                                            <?
                                                }
                                            ?>
                                            </tr>
                                      
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                                $sql 		    	  =	array();
                                                $sql['QUERY'] = "SELECT `check_in_date`,`seat_limit`								
                                                                            FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . "
                                                                            WHERE hotel_id = ?
                                                                                AND status != ?";
                                                $sql['PARAM'][]	=	array('FILD' => 'hotel_id', 	'DATA' => $hotelId, 'TYP' => 's');
                                                $sql['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'D', 				 'TYP' => 's');
                                                $result = $mycms->sql_select($sql);
                                                // $rowSeatLimit          = $result[0];
                                                foreach ($result as $key => $rowSeatLimit) {
                                                ?>
                                                    <td class="text-center"><?= $rowSeatLimit['seat_limit'] ?></td>
                                                <?
                                                  }
                                                ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="service_breakdown_wrap">
                            <h4>Aminities</h4>
                            <ul class="accm_ul aminity_ul">
                                <?php
                                    $sqlAcc = array();
                                    $sqlAcc['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $hotelId . "' AND status='A' AND purpose='aminity'  ORDER BY `id` ASC";

                                    $queryAcc = $mycms->sql_select($sqlAcc, false);
                                    
                                if ($queryAcc) { 
                                    foreach ($queryAcc as $keyqueryAcc => $aminity) {
                                            $icon = _BASE_URL_.'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $aminity['accessories_icon'];
                                ?>
                                 <li><img src=<?= $icon?> alt=""><?= $aminity['accessories_name'] ?></li>
                               <?
                                    }
                                }    
                                ?>                              
                            </ul>
                        </div>
                        <div class="service_breakdown_wrap">
                            <h4>Room Type</h4>
                            <ul class="accm_ul room_ul">
                            <?php
                                $sqlRoom = array();
                                $sqlRoom['QUERY']    = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  WHERE `hotel_id` = '" . $hotelId . "' AND status='A' AND purpose='room'  ORDER BY `id` ASC";

                                $queryRoom = $mycms->sql_select($sqlRoom, false);
                                if ($queryRoom) { 
                                    foreach ($queryRoom as $k => $row) {
                                    $icon = _BASE_URL_ . 'uploads/EMAIL.HEADER.FOOTER.IMAGE/' . $row['accessories_icon'];

                                ?>
                                    <li><img src="<?= $icon ?>" alt=""><?= $row['accessories_name'] ?></li>
                                <?php
                                }
                                }
                             ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- view hotel pop up -->
        <!-- Hotel Tariff pop up -->
          <div class="pop_up_body" id="hoteltariff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Accommodation Tariff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                
                <form action="accomodation_tariff.process.php" method="post" onsubmit="return onSubmitAction();">
                <input type="hidden" name="act" value="edit"/>
                <input type="hidden" name="roomId" value="<?=$roomId?>"/>
                <input type="hidden" name="hotel_id" value="<?=$hotelTarrifId?>"/>
                   <?
                	$hotelId		  =	$hotelTarrifId;
                    $packageId       =$packageId;
                    // $cutoff_id  	  = $cutoff_id;
                    
            
                    $dates = array();	
                    $dCount = 0;		
                    $packageCheckDate = array();	
                    $packageCheckDate['QUERY'] = "SELECT * FROM "._DB_ACCOMMODATION_CHECKIN_DATE_." 
                                                        WHERE `hotel_id` = ?
                                                            AND `status` = ?
                                                        ORDER BY  check_in_date";
                        $packageCheckDate['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelId , 	'TYP' => 's');
                        $packageCheckDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 		'TYP' => 's');									    
                        $resCheckIns = $mycms->sql_select($packageCheckDate);
                        
                        foreach ($resCheckIns as $key => $rowCheckIn) {
                            $packageCheckoutDate = array();
                            $packageCheckoutDate['QUERY'] = "SELECT *, TIMESTAMPDIFF(DAY,'".$rowCheckIn['check_in_date']."',`check_out_date`) AS dayDiff
                                                            FROM "._DB_ACCOMMODATION_CHECKOUT_DATE_." 
                                                            WHERE `hotel_id` = ?
                                                                AND `status` = ?
                                                                AND `check_out_date` > ?
                                                        ORDER BY check_out_date";
                            $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelId , 	    'TYP' => 's');
                            $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 			'TYP' => 's');
                            $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'check_out_date' ,	'DATA' => $rowCheckIn['check_in_date'] , 			'TYP' => 's');
                            
                            
                            $resCheckOut = $mycms->sql_select($packageCheckoutDate);	
                            //echo '<pre>'; print_r($resCheckOut);
                            foreach ($resCheckOut as $key => $rowCheckOut) {
                                $dates[$dCount]['CHECKIN'] 	  =  $rowCheckIn['check_in_date'];
                                $dates[$dCount]['CHECKINID']  =  $rowCheckIn['id'];
                                $dates[$dCount]['CHECKOUT']   =  $rowCheckOut['check_out_date'];						
                                $dates[$dCount]['CHECKOUTID'] =  $rowCheckOut['id'];
                                $dates[$dCount]['DAYDIFF']    =  $rowCheckOut['dayDiff'];

                                $dCount++;
                            }		

                        }		
                    ?>	
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <?php
                                  $hotelId		  =	$hotelTarrifId;
                                  $roomId       =$roomId;
                                 
                                    $sqlFetchHotel				=	array();
                                    $sqlFetchHotel['QUERY']		=	"SELECT * 
                                                                    FROM " . _DB_MASTER_HOTEL_ . "
                                                                    WHERE `id` 		= 	 ? ";

                                    $sqlFetchHotel['PARAM'][]	=	array('FILD' => 'id', 		'DATA' => $hotelTarrifId, 		'TYP' => 's');
                                    $resultFetchHotel    		= $mycms->sql_select($sqlFetchHotel);
                                    $sqlFetchPack				=	array();
                                    $sqlFetchPack['QUERY']		=	"SELECT `package_name` ,`id`
                                                                    FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                                    WHERE `status` 		= 	 ?
                                                                    AND `hotel_id` 		= 	 ? ";

                                    $sqlFetchPack['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'A', 		'TYP' => 's');
                                    $sqlFetchPack['PARAM'][]	=	array('FILD' => 'hotel_id', 		'DATA' => $hotelTarrifId, 		'TYP' => 's');

                                    $resultFetchPack    		= $mycms->sql_select($sqlFetchPack);
                                    $sqlRoom = array();
                                    $sqlRoom['QUERY'] = "SELECT * FROM " . _DB_ACCOMMODATION_ACCESSORIES_ . "  
                                                        WHERE id = ? AND status='A' AND purpose='room' ORDER BY id ASC";
                                    $sqlRoom['PARAM'][] = array('DATA' => $roomId, 'TYP' => 's');
                                    $rooms = $mycms->sql_select($sqlRoom);

                                    ?>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Hotel Name</p>
                                    <p class="typed_data"><?=$resultFetchHotel[0]['hotel_name']?></p>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Room Type</p>
                                    <p class="typed_data"><?= $rooms[0]['accessories_name'] ?></p>
                                </div>
                                <div class="accm_add_wrap span_4">
                                       <? 
                
                                        $sql 	=	array();
                                        $sql['QUERY']	=	"SELECT id, cutoff.cutoff_title  
                                                                FROM "._DB_TARIFF_CUTOFF_." cutoff
                                                            WHERE status = ?";
                                        $sql['PARAM'][]	=	array('FILD' => 'status' , 		'DATA' => 'A' , 		'TYP' => 's');					   
                                        $resCutoff=$mycms->sql_select($sql);
                                        $cutOffsArray = array();
                                        
                                        foreach($resCutoff as $key=>$title)
                                        {	
                                        ?>	
                                    <div class="accm_add_box">
                                        <h4 class="registration-pop_body_box_heading">
                                            <span><?=strip_tags($title['cutoff_title'])?><span>
                                        </h4>
                                        <div class="registration-pop_body p-0">
                                            <?
                                            if($resultFetchPack){
                                              foreach ($resultFetchPack as $keyPack => $rowFetchPack) {
                                             
                                                ?>
                                            <div class="registration-pop_body_box_inner">
                                                
                                                    <!-- <div class="frm_grp span_2">
                                                        <p class="frm-head">Rate/Night(INR)</p>
                                                        <input type="number" name="rate_per_night_inr[<?=$title['id']?>]" class="rate_inr" value="<?=$resPackageCheckoutDate[0]['inr_amount']?>">

                                                    </div>
                                                    <div class="frm_grp span_2">
                                                        <p class="frm-head">Rate/Night(USD)</p>
                                                        <input type="number" name="rate_per_night_usd[<?=$title['id']?>]" class="rate_usd" value="<?=$resPackageCheckoutDate[0]['usd_amount']?>">

                                                    </div> -->
                                                    <?php
                                                    $sqlPackageCheckoutDate1	=	array();
                                                    // query in tariff table
                                                    $sqlPackageCheckoutDate1['QUERY'] = "select * 
                                                                                        FROM "._DB_TARIFF_ACCOMMODATION_." accomodation
                                                                                        WHERE status = ?
                                                                                        AND tariff_cutoff_id = ?
                                                                                        AND hotel_id = ?
                                                                                        AND roomTypeId = ?
                                                                                        AND package_id = ?";
                                                    $sqlPackageCheckoutDate1['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 					'TYP' => 's');
                                                    $sqlPackageCheckoutDate1['PARAM'][]	=	array('FILD' => 'tariff_cutoff_id' ,'DATA' => $title['id'] , 		'TYP' => 's');
                                                    $sqlPackageCheckoutDate1['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelTarrifId, 		'TYP' => 's');
                                                    $sqlPackageCheckoutDate1['PARAM'][]	=	array('FILD' => 'roomTypeId' , 		'DATA' =>$roomId, 		'TYP' => 's');									   
                                                    $sqlPackageCheckoutDate1['PARAM'][]	=	array('FILD' => 'package_id' , 		'DATA' =>$rowFetchPack['id'], 		'TYP' => 's');									   

                                                    $resPackageCheckoutDate1 = $mycms->sql_select($sqlPackageCheckoutDate1);
                                                    ?>
                                                    <div class="package-box" data-cutoff="<?= $title['id'] ?>" data-room="<?= $roomId ?>" data-package="<?= $rowFetchPack['id'] ?>">
                                                       <h4 class="registration-pop_body_box_heading">
                                                            <span><?=$rowFetchPack['package_name']?><span>
                                                        </h4>
                                                       <div class="form_grid">

                                                            <!-- mandatory hidden IDs -->
                                                            <input type="hidden"
                                                                name="tariff[<?= $title['id'] ?>][<?= $rowFetchPack['id'] ?>][hotel_id]"
                                                                value="<?= $hotelTarrifId ?>">

                                                            <input type="hidden"
                                                                name="tariff[<?= $title['id'] ?>][<?= $rowFetchPack['id'] ?>][cutoff_id]"
                                                                value="<?= $title['id'] ?>">

                                                            <input type="hidden"
                                                                name="tariff[<?= $title['id'] ?>][<?= $rowFetchPack['id'] ?>][room_id]"
                                                                value="<?= $roomId ?>">

                                                            <input type="hidden"
                                                                name="tariff[<?= $title['id'] ?>][<?= $rowFetchPack['id'] ?>][package_id]"
                                                                value="<?= $rowFetchPack['id'] ?>">

                                                            <div class="frm_grp span_2">
                                                                <p class="frm-head">Rate/Night (INR)</p>
                                                                <input type="number"
                                                                    step="0.01"
                                                                    required
                                                                    name="tariff[<?= $title['id'] ?>][<?= $rowFetchPack['id'] ?>][inr]"
                                                                    value="<?= $resPackageCheckoutDate1[0]['inr_amount'] ?? '' ?>" class="rate_inr">
                                                            </div>

                                                            <div class="frm_grp span_2">
                                                                <p class="frm-head">Rate/Night (USD)</p>
                                                                <input type="number"
                                                                    step="0.01"
                                                                    required
                                                                    name="tariff[<?= $title['id'] ?>][<?= $rowFetchPack['id'] ?>][usd]"
                                                                    value="<?= $resPackageCheckoutDate1[0]['usd_amount'] ?? '' ?>" class="rate_usd">
                                                            </div>

                                                        </div>
                                                      <a  href="javascript:void(0);"  value="Compose" class="accm_delet icon_hover badge_primary action-transparent composeBtn "><i class="fal fa-paper-plane"></i></a>

                                                    </div>

                                            </div>
                                            <?
                                                }
                                                }
                                            ?>
                                         
                                        </div>
                                        <div class="table_wrap mt-3">
                                            <table  class="table_wrap">
                                                <thead>
                                                    <tr>
                                                        <th>Check In Date</th>
                                                        <th>Check Out Date</th>
                                                        <th>Package</th>
                                                        <th>INR Rate</th>
                                                        <th>USD Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // 1️⃣ Fetch packages ONCE
                                                    $sqlFetchPack = [];
                                                    $sqlFetchPack['QUERY'] = "
                                                        SELECT id, package_name
                                                        FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                        WHERE status = ?
                                                        AND hotel_id = ?
                                                        ORDER BY id ASC
                                                    ";
                                                    $sqlFetchPack['PARAM'][] = ['DATA' => 'A', 'TYP' => 's'];
                                                    $sqlFetchPack['PARAM'][] = ['DATA' => $hotelTarrifId, 'TYP' => 's'];

                                                    $packages = $mycms->sql_select($sqlFetchPack);
                                                    $pkgCount = count($packages);
                                                  
                                                    // 2️⃣ Fetch tariff rows (date combinations)
                                                //    echo "<pre>";
                                                //     print_r($sqlPackageCheckoutDate);
                                                
                                                    foreach ($resPackageCheckoutDate1 as $accomodationTariff) {

                                                        // Fetch check-in date
                                                        $packageCheckinDate = [];
                                                        $packageCheckinDate['QUERY'] = "
                                                            SELECT check_in_date
                                                            FROM " . _DB_ACCOMMODATION_CHECKIN_DATE_ . "
                                                            WHERE id = ? AND status = ?
                                                        ";
                                                        $packageCheckinDate['PARAM'][] = ['DATA' => $accomodationTariff['checkin_date_id'], 'TYP' => 's'];
                                                        $packageCheckinDate['PARAM'][] = ['DATA' => 'A', 'TYP' => 's'];
                                                        $rowCheckin = $mycms->sql_select($packageCheckinDate)[0];
                                                            

                                                        // Fetch check-out date
                                                        $packageCheckoutDate = [];
                                                        $packageCheckoutDate['QUERY'] = "
                                                            SELECT check_out_date
                                                            FROM " . _DB_ACCOMMODATION_CHECKOUT_DATE_ . "
                                                            WHERE id = ? AND status = ?
                                                        ";
                                                        $packageCheckoutDate['PARAM'][] = ['DATA' => $accomodationTariff['checkout_date_id'], 'TYP' => 's'];
                                                        $packageCheckoutDate['PARAM'][] = ['DATA' => 'A', 'TYP' => 's'];

                                                        $rowCheckout = $mycms->sql_select($packageCheckoutDate)[0];

                                                        // 3️⃣ Loop packages
                                                        foreach ($packages as $pIndex => $package) {
                                                            $sqlPackageCheckoutDate	=	array();
                                                            // query in tariff table
                                                            $sqlPackageCheckoutDate['QUERY'] = "select * 
                                                                                                FROM "._DB_TARIFF_ACCOMMODATION_." accomodation
                                                                                                WHERE status = ?
                                                                                                AND tariff_cutoff_id = ?
                                                                                                AND hotel_id = ?
                                                                                                AND roomTypeId = ?
                                                                                                AND package_id = ?
                                                                                                AND checkin_date_id = ?
                                                                                                AND checkout_date_id = ?";
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 					'TYP' => 's');
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'tariff_cutoff_id' ,'DATA' => $title['id'] , 		'TYP' => 's');
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelTarrifId, 		'TYP' => 's');
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'roomTypeId' , 		'DATA' =>$roomId, 		'TYP' => 's');	
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'package_id' , 		'DATA' =>$package['id'], 		'TYP' => 's');	
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'checkin_date_id' , 		'DATA' =>$accomodationTariff['checkin_date_id'], 		'TYP' => 's');	
                                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'checkout_date_id' , 		'DATA' =>$accomodationTariff['checkout_date_id'], 		'TYP' => 's');	

                                                            $resPackageCheckoutDate = $mycms->sql_select($sqlPackageCheckoutDate);
                                                    ?>
                                                   <tr use="rateVal">

                                                        <?php if ($pIndex === 0) { ?>
                                                            <td rowspan="<?= $pkgCount ?>">
                                                                <?= $rowCheckin['check_in_date'] ?>
                                                                <input type="hidden"
                                                                    name="rates[<?= $title['id'] ?>][<?= $accomodationTariff['checkin_date_id'] ?>][<?= $accomodationTariff['checkout_date_id'] ?>][checkin_date_id]"
                                                                    value="<?= $accomodationTariff['checkin_date_id'] ?>">
                                                            </td>

                                                            <td rowspan="<?= $pkgCount ?>">
                                                                <?= $rowCheckout['check_out_date'] ?>
                                                                <input type="hidden"
                                                                    name="rates[<?= $title['id'] ?>][<?= $accomodationTariff['checkin_date_id'] ?>][<?= $accomodationTariff['checkout_date_id'] ?>][checkout_date_id]"
                                                                    value="<?= $accomodationTariff['checkout_date_id'] ?>">
                                                            </td>
                                                        <?php } ?>

                                                        <td>
                                                            <?= $package['package_name'] ?>

                                                            <input type="hidden"
                                                                name="rates[<?= $title['id'] ?>][<?= $accomodationTariff['checkin_date_id'] ?>][<?= $accomodationTariff['checkout_date_id'] ?>][packages][<?= $package['id'] ?>][package_id]"
                                                                value="<?= $package['id'] ?>">
                                                        </td>

                                                        <td>
                                                            <?=$resPackageCheckoutDate[0]['inr_amount'] ?>

                                                            <input type="hidden"
                                                                name="rates[<?= $title['id'] ?>][<?= $accomodationTariff['checkin_date_id'] ?>][<?= $accomodationTariff['checkout_date_id'] ?>][packages][<?= $package['id'] ?>][inr]"
                                                                value="<?= $resPackageCheckoutDate[0]['inr_amount'] ?>">
                                                        </td>

                                                        <td>
                                                            <?=$resPackageCheckoutDate[0]['usd_amount'] ?>

                                                            <input type="hidden"
                                                                name="rates[<?= $title['id'] ?>][<?= $accomodationTariff['checkin_date_id'] ?>][<?= $accomodationTariff['checkout_date_id'] ?>][packages][<?= $package['id'] ?>][usd]"
                                                                value="<?=$resPackageCheckoutDate[0]['usd_amount'] ?>">
                                                        </td>

                                                    </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                            </table>
                                        </div>
                                        <!-- <a href="#" class="accm_delet icon_hover badge_primary action-transparent"><i class="fal fa-paper-plane"></i></a> -->
                                    </div>
                                
                                    <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" id="confirmBtn" class="mi-1 badge_success"><?php save(); ?>Update Tariff</button>
                    </div>
                </div>
              </form>
              <script>
               var datesByCutoff = {}; // initialize an empty object

                // Populate it dynamically if needed
                <?php
                    foreach($resCutoff as $title) {
                        $cutoffId = $title['id'];
                        $cutoffDates = array();
                        foreach($dates as $vals) {
                            // You might want to filter dates if they belong to this cutoff
                            $cutoffDates[] = [
                                'checkin'   => $vals['CHECKIN'],
                                'checkinId' => $vals['CHECKINID'],
                                'checkout'  => $vals['CHECKOUT'],
                                'checkoutId'=> $vals['CHECKOUTID'],
                                'days'      => $vals['DAYDIFF']
                            ];
                        }
                        echo "datesByCutoff[$cutoffId] = " . json_encode($cutoffDates) . ";\n";
                    }
                    ?>
                       
               $(document).on('click', '.composeBtn', function(e) {
                    e.preventDefault();
                    $('#confirmBtn').prop('disabled', false);

                    let pkgBox = $(this).closest('.package-box');
                    let accmBox = pkgBox.closest('.accm_add_box');
                    let cutoffId = pkgBox.data('cutoff');
                    let tableBody = accmBox.find('tbody');
                    tableBody.empty();

                    let cutoffDates = datesByCutoff[cutoffId] || [];

                    // Fetch all packages in this cutoff
                    let packages = [];
                    accmBox.find('.package-box').each(function() {
                        let box = $(this);
                        let packageId = box.data('package'); // Make sure package-box has data-package
                        let packageName = box.find('h4 span').first().text().trim();
                        let INRrate = parseFloat(box.find('input.rate_inr').val() || 0);
                        let USDrate = parseFloat(box.find('input.rate_usd').val() || 0);

                        packages.push({
                            id: packageId,
                            name: packageName,
                            inr: INRrate,
                            usd: USDrate
                        });
                    });

                    // Loop over each check-in/check-out combination
                    $.each(cutoffDates, function(idx, date) {
                        let nights = parseInt(date.days);

                        $.each(packages, function(pIndex, pkg) {
                            let inrAmount = (pkg.inr * nights).toFixed(2);
                            let usdAmount = (pkg.usd * nights).toFixed(2);

                            let tr = `<tr use="rateVal">`;

                            if (pIndex === 0) {
                                tr += `
                                    <td rowspan="${packages.length}">
                                        ${date.checkin}
                                        <input type="hidden" name="rates[${cutoffId}][${date.checkinId}][${date.checkoutId}][checkin_date_id]" value="${date.checkinId}">
                                    </td>
                                    <td rowspan="${packages.length}">
                                        ${date.checkout}
                                        <input type="hidden" name="rates[${cutoffId}][${date.checkinId}][${date.checkoutId}][checkout_date_id]" value="${date.checkoutId}">
                                    </td>
                                `;
                            }

                            tr += `
                                <td>
                                    ${pkg.name}
                                    <input type="hidden" name="rates[${cutoffId}][${date.checkinId}][${date.checkoutId}][packages][${pkg.id}][package_id]" value="${pkg.id}">
                                </td>
                                <td>
                                    ${inrAmount}
                                    <input type="hidden" name="rates[${cutoffId}][${date.checkinId}][${date.checkoutId}][packages][${pkg.id}][inr]" value="${inrAmount}">
                                </td>
                                <td>
                                    ${usdAmount}
                                    <input type="hidden" name="rates[${cutoffId}][${date.checkinId}][${date.checkoutId}][packages][${pkg.id}][usd]" value="${usdAmount}">
                                </td>
                            </tr>`;

                            tableBody.append(tr);
                        });
                    });
                });
              
            </script>
            </div>
        </div>
        <div class="pop_up_body" id="hoteltariffOld">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Package Tariff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <?
                	$hotelId		  =	$hotelTarrifId;
                    $packageId       =$packageId;
                    // $cutoff_id  	  = $cutoff_id;
                    
            
                    $dates = array();	
                    $dCount = 0;		
                    $packageCheckDate = array();	
                    $packageCheckDate['QUERY'] = "SELECT * FROM "._DB_ACCOMMODATION_CHECKIN_DATE_." 
                                                        WHERE `hotel_id` = ?
                                                            AND `status` = ?
                                                        ORDER BY  check_in_date";
                        $packageCheckDate['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelId , 	'TYP' => 's');
                        $packageCheckDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 		'TYP' => 's');									    
                        $resCheckIns = $mycms->sql_select($packageCheckDate);
                        
                        foreach ($resCheckIns as $key => $rowCheckIn) {
                            $packageCheckoutDate = array();
                            $packageCheckoutDate['QUERY'] = "SELECT *, TIMESTAMPDIFF(DAY,'".$rowCheckIn['check_in_date']."',`check_out_date`) AS dayDiff
                                                            FROM "._DB_ACCOMMODATION_CHECKOUT_DATE_." 
                                                            WHERE `hotel_id` = ?
                                                                AND `status` = ?
                                                                AND `check_out_date` > ?
                                                        ORDER BY check_out_date";
                            $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelId , 	    'TYP' => 's');
                            $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 			'TYP' => 's');
                            $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'check_out_date' ,	'DATA' => $rowCheckIn['check_in_date'] , 			'TYP' => 's');
                            
                            
                            $resCheckOut = $mycms->sql_select($packageCheckoutDate);	
                            //echo '<pre>'; print_r($resCheckOut);
                            foreach ($resCheckOut as $key => $rowCheckOut) {
                                $dates[$dCount]['CHECKIN'] 	  =  $rowCheckIn['check_in_date'];
                                $dates[$dCount]['CHECKINID']  =  $rowCheckIn['id'];
                                $dates[$dCount]['CHECKOUT']   =  $rowCheckOut['check_out_date'];						
                                $dates[$dCount]['CHECKOUTID'] =  $rowCheckOut['id'];
                                $dates[$dCount]['DAYDIFF']    =  $rowCheckOut['dayDiff'];

                                $dCount++;
                            }		

                        }		
            ?>	
        
           
                <!-- <form action="accomodation_tariff.process.php" method="post" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" value="edit"/>
                    <input type="hidden" name="package_id" value="<?=$packageId?>"/>
                    <input type="hidden" name="hotel_id" value="<?=$hotelTarrifId?>"/>

                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <?php
                                        $sqlFetchHotel				=	array();
                                        $sqlFetchHotel['QUERY']		=	"SELECT * 
                                                                        FROM " . _DB_MASTER_HOTEL_ . "
                                                                        WHERE `id` 		= 	 ? ";

                                        $sqlFetchHotel['PARAM'][]	=	array('FILD' => 'id', 		'DATA' => $hotelTarrifId, 		'TYP' => 's');
                                        $resultFetchHotel    		= $mycms->sql_select($sqlFetchHotel);
                                        $sqlFetchPack				=	array();
                                        $sqlFetchPack['QUERY']		=	"SELECT `package_name` 
                                                                        FROM " . _DB_ACCOMMODATION_PACKAGE_ . "
                                                                        WHERE `status` 		= 	 ?
                                                                        AND `id` 		= 	 ? ";

                                        $sqlFetchPack['PARAM'][]	=	array('FILD' => 'status', 		'DATA' => 'A', 		'TYP' => 's');
                                        $sqlFetchPack['PARAM'][]	=	array('FILD' => 'id', 		'DATA' => $packageId, 		'TYP' => 's');

                                        $resultFetchPack    		= $mycms->sql_select($sqlFetchPack);
                                
                                    ?>
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Hotel Name</p>
                                        <p class="typed_data"><?=$resultFetchHotel[0]['hotel_name']?></p>
                                    </div>
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Package Name</p>
                                        <p class="typed_data"><?=$resultFetchPack[0]['package_name']?></p>
                                    </div>
                                    <div class="accm_add_wrap span_4">
                                        <? 
                
                                        $sql 	=	array();
                                        $sql['QUERY']	=	"SELECT id, cutoff.cutoff_title  
                                                                FROM "._DB_TARIFF_CUTOFF_." cutoff
                                                            WHERE status = ?";
                                        $sql['PARAM'][]	=	array('FILD' => 'status' , 		'DATA' => 'A' , 		'TYP' => 's');					   
                                        $resCutoff=$mycms->sql_select($sql);
                                        $cutOffsArray = array();
                                        
                                        foreach($resCutoff as $key=>$title)
                                        {	
                                            $sqlPackageCheckoutDate	=	array();
                                            // query in tariff table
                                            $sqlPackageCheckoutDate['QUERY'] = "select * 
                                                                                FROM "._DB_TARIFF_ACCOMMODATION_." accomodation
                                                                                WHERE status = ?
                                                                                AND tariff_cutoff_id = ?
                                                                                AND hotel_id = ?
                                                                                AND package_id = ?";
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 					'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'tariff_cutoff_id' ,'DATA' => $title['id'] , 		'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'hotel_id' , 		'DATA' => $hotelTarrifId, 		'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'package_id' , 		'DATA' => $packageId , 		'TYP' => 's');									   
                                            $resPackageCheckoutDate = $mycms->sql_select($sqlPackageCheckoutDate);

                                        ?>	
                                        
                                        <div class="accm_add_box" data-cutoff="<?=$title['id']?>">
                                            <h4 class="registration-pop_body_box_heading">
                                                <span><?=strip_tags($title['cutoff_title'])?><span>
                                            </h4>
                                            <input type="hidden" name="cutoff[<?=$title['id']?>]" value="<?=$title['id']?>"/>

                                            <div class="form_grid">
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Rate/Night(INR)</p>
                                                    <input type="number" name="rate_per_night_inr[<?=$title['id']?>]" class="rate_inr" value="<?=$resPackageCheckoutDate[0]['inr_amount']?>">
                                                </div>
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Rate/Night(USD)</p>
                                                    <input type="number" name="rate_per_night_usd[<?=$title['id']?>]" class="rate_usd" value="<?=$resPackageCheckoutDate[0]['usd_amount']?>">
                                                </div>
                                                
                                                <a  href="javascript:void(0);"  value="Compose" class="accm_delet icon_hover badge_primary action-transparent composeBtn "><i class="fal fa-paper-plane"></i></a>
                                            </div>
                                            <div class="table_wrap mt-3">
                                                <table use="rateDes">
                                                    <thead>
                                                        <tr>
                                                            <th>Check In Date</th>
                                                            <th>Check Out Date</th>
                                                            <th>INR Rate</th>
                                                            <th>USD Rate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($resPackageCheckoutDate as $key=>$accomodationTariff){ 
                                                        $packageCheckoutDate 	=	array();
                                                        $packageCheckoutDate['QUERY'] = "SELECT * 
                                                                                        FROM "._DB_ACCOMMODATION_CHECKOUT_DATE_." _DB_ACCOMMODATION_CHECKIN_DATE_
                                                                                        WHERE `id` = ?
                                                                                            AND `status` = ?
                                                                                    ORDER BY check_out_date";
                                                        $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'id' , 		'DATA' => $accomodationTariff['checkout_date_id'] , 	    'TYP' => 's');
                                                        $packageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 			'TYP' => 's');
                                                        $respackageCheckoutDate 		= $mycms->sql_select($packageCheckoutDate);
                                                        $rowpackageCheckoutDate			= $respackageCheckoutDate[0];

                                                        $packageCheckinDate 	=	array();
                                                        $packageCheckinDate['QUERY'] = "SELECT * 
                                                                                        FROM "._DB_ACCOMMODATION_CHECKIN_DATE_." 
                                                                                        WHERE `id` = ?
                                                                                            AND `status` = ?
                                                                                    ORDER BY check_in_date";
                                                        $packageCheckinDate['PARAM'][]	=	array('FILD' => 'id' , 				'DATA' => $accomodationTariff['checkin_date_id'] , 	    'TYP' => 's');
                                                        $packageCheckinDate['PARAM'][]	=	array('FILD' => 'status' , 			'DATA' => 'A' , 			'TYP' => 's');
                                                    
                                                        $respackageCheckinDate 		= $mycms->sql_select($packageCheckinDate);
                                                        $rowpackageCheckinDate			= $respackageCheckinDate[0];
                                                        ?>
                                                      
                                                        <tr use="rateVal">
                                                            <td>
                                                                <?=$rowpackageCheckinDate['check_in_date']?>
                                                                <input type="hidden"
                                                                    name="checkin_date[<?=$title['id']?>][]"
                                                                    value="<?=$accomodationTariff['checkin_date_id']?>">
                                                            </td>

                                                            <td>
                                                                <?=$rowpackageCheckoutDate['check_out_date']?>
                                                                <input type="hidden"
                                                                    name="checkout_date[<?=$title['id']?>][]"
                                                                    value="<?=$accomodationTariff['checkout_date_id']?>">
                                                            </td>

                                                            <td>
                                                                <?=$accomodationTariff['inr_amount']?>
                                                                <input type="hidden"
                                                                    name="INRAmt[<?=$title['id']?>][]"
                                                                    value="<?=$accomodationTariff['inr_amount']?>">
                                                            </td>

                                                            <td>
                                                                <?=$accomodationTariff['usd_amount']?>
                                                                <input type="hidden"
                                                                    name="USDAmt[<?=$title['id']?>][]"
                                                                    value="<?=$accomodationTariff['usd_amount']?>">
                                                            </td>
                                                        </tr>
                                                        <? } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?
                                        }
                                        ?>
                                
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" id="confirmBtn" disabled class="mi-1 badge_success"><?php save(); ?>Confirm Booking</button>
                        </div>
                    </div>
                </form> -->
                <!-- <script>
                        var datesByCutoff = {};
                        <?php
                        foreach($resCutoff as $title) {
                            $cutoffId = $title['id'];
                            $cutoffDates = array();
                            foreach($dates as $vals) {
                                // You might want to filter dates if they belong to this cutoff
                                $cutoffDates[] = [
                                    'checkin'   => $vals['CHECKIN'],
                                    'checkinId' => $vals['CHECKINID'],
                                    'checkout'  => $vals['CHECKOUT'],
                                    'checkoutId'=> $vals['CHECKOUTID'],
                                    'days'      => $vals['DAYDIFF']
                                ];
                            }
                            echo "datesByCutoff[$cutoffId] = " . json_encode($cutoffDates) . ";\n";
                        }
                        ?>
                        console.log(datesByCutoff);
                        </script>
                       <script>
                        $(document).on('click', '.composeBtn', function (e) {
                        e.preventDefault();
                         $('#confirmBtn').prop('disabled', false);

                        let container = $(this).closest('.accm_add_box');
                        let cutoffId = container.data('cutoff');

                        let INRrate = container.find('.rate_inr').val();
                        let USDrate = container.find('.rate_usd').val();
                        let rateTable = container.find("table[use=rateDes]");

                        if (INRrate === "") {
                            alert('Please enter rate!!!');
                            container.find('.rate_inr').focus();
                            return;
                        }

                        rateTable.find("tr[use=rateVal]").remove();
                       var cutoffDates = datesByCutoff[cutoffId] || [];


                        $.each(cutoffDates, function (i, value) {

                            let INRAmount = parseFloat(INRrate) * parseInt(value.days);
                            let USDAmount = parseFloat(USDrate) * parseInt(value.days);

                            let tr = `
                                <tr use="rateVal">
                                    <td>${value.checkin}
                                        <input type="hidden"
                                            name="checkin_date[${cutoffId}][]"
                                            value="${value.checkinId}">
                                    </td>
                                    <td>${value.checkout}
                                        <input type="hidden"
                                            name="checkout_date[${cutoffId}][]"
                                            value="${value.checkoutId}">
                                    </td>
                                    <td>${INRAmount.toFixed(2)}
                                        <input type="hidden"
                                            name="INRAmt[${cutoffId}][]"
                                            value="${INRAmount}">
                                    </td>
                                    <td>${USDAmount.toFixed(2)}
                                        <input type="hidden"
                                            name="USDAmt[${cutoffId}][]"
                                            value="${USDAmount}">
                                    </td>
                                </tr>
                            `;

                            rateTable.append(tr);
                        });

                        rateTable.show();
                    });
                </script> -->
            </div>
        </div>
        <!-- Hotel Tariff pop up -->
        <!-- New dinner pop up -->
        <div class="pop_up_body" id="adddinner">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Dinner</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmInsert" id="frmInsert" action="dinner_classificaton.process.php" method="post" enctype="multipart/form-data" onsubmit="return onSubmitAction();">
		     	<input type="hidden" name="act" value="insert" />		
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Select Hotel</p>
                                    <input type="text" name="dinner_hotel_name" id="dinner_hotel_name" required="" onchange="return checkInValid();" />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Dinner Classification Name</p>
                                    <input type="text" name="dinner_class_name" id="dinner_class_name"  required="" onchange="return checkInValid();" />
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Dinner Date</p>
                                    <input type="date" name="dinner_date" id="dinner_date" required >

                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Link</p>
                                    <input type="text" name="link"  required="" onchange="return checkInValid();" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!-- New dinner pop up -->
        <!-- edit dinner pop up -->
        <div class="pop_up_body" id="editdinner">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Dinner</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmUpdate" id="frmUpdate" action="dinner_classificaton.process.php" method="post" enctype="multipart/form-data" onsubmit="return updateConfirmation();">
			    <input type="hidden" name="act" id="act" value="update" />
			    <input type="hidden" name="id" id="classification_id" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Select Hotel</p>
                                    <input type="text" name="dinner_hotel_name" id="dinner_hotel_name"  required="" onchange="return checkInValid();" value="<?=$rowFetchDinner['dinner_hotel_name']?>"/>

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Dinner Classification Name</p>
                                    <input type="text" name="dinner_class_name" id="classification_name" required="" onchange="return checkInValid();" value="<?=$rowFetchDinner['dinner_classification_name']?>"/>

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Dinner Date</p>
									<input type="date" name="dinner_date" id="date" required >
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Link</p>
									<input type="text" name="link" id="link"  required=""  />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                    </div>
                </div>
             </form>
            </div>
        </div>
        <!-- edit dinner pop up -->
        <!-- Add accompany classification pop up -->
        <div class="pop_up_body" id="addaccompany">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Accompany</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_accompany.process.php" id="frmtypeadd" enctype="multipart/form-data" onsubmit="return onSubmitAction();">
		           <input type="hidden" name="act" value="add" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification Title</p>
                                    <input type="text" name="classification_title" id="classification_title" class="validate[required]" onblur="checkClassificationTitle(this)"  required />

                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Inclusion Lunch Date</p>
                                    <select  class="mySelect for" name="inclusion_lunch_date[]" id="inclusion_lunch_date" multiple="multiple" style="width:100%">
										<?php
										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Lunch'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {
										?>
											<option value="<?= date('d-m-Y', strtotime($rowsl['date'])) ?>"><?= date('d-m-Y', strtotime($rowsl['date'])) ?></option>
										<?php } ?>
									</select>
                                </div>
                                <div class="frm_grp span_3">
                                    <p class="frm-head">Inclusion Conference Dinner Date</p>
                                     <select  class="mySelect for" name="inclusion_dinner_date[]" id="inclusion_dinner_date" multiple="multiple" style="width:100%">
										<?php
										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Dinner'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {
										?>
											<option value="<?= date('d-m-Y', strtotime($rowsl['date'])) ?>"><?= date('d-m-Y', strtotime($rowsl['date'])) ?></option>
										<?php } ?>
									</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Scientific Halls</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_sci_hall" name="inclusion_sci_hall"  value="Y" >
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio"id="inclusion_sci_hall" name="inclusion_sci_hall"  value="N" >
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Exhibition Area</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area" value="Y" >
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area" value="N" >
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Tea/Coffee during the Conference</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_tea_coffee" name="inclusion_tea_coffee"  value="Y">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_tea_coffee" name="inclusion_tea_coffee"  value="N">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Kit</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio"  id="inclusion_conference_kit" name="inclusion_conference_kit" value="Y">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio"  id="inclusion_conference_kit" name="inclusion_conference_kit" value="N">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
        <!-- Add accompany classification pop up -->
          <!-- Edit accompany classification pop up -->
        <div class="pop_up_body" id="editaccompany">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Accompany</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
               <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_accompany.process.php" id="frmtypeadd" enctype="multipart/form-data" onsubmit="return onSubmitAction();">
		        <input type="hidden" name="act" value="update" />
		        <input type="hidden" name="id" id="id" value="<?= $accompanyId?>" />
                <?php
                    $sql 	=	array();
                    $sql['QUERY']	=	"SELECT * 
                                            FROM " . _DB_ACCOMPANY_CLASSIFICATION_ . " 
                                            WHERE `id` = ? ";
                    $sql['PARAM'][]		=	array('FILD' => 'id', 		  'DATA' => $accompanyId,				   'TYP' => 's');
                    $res_cal = $mycms->sql_select($sql);
                    $row    = $res_cal[0];

                    $inclusion_lunch_icon = '../../' . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['inclusion_lunch_icon'];
                    $inclusion_conference_kit_icon = '../../' . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['inclusion_conference_kit_icon'];
                    ?>

                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification Title</p>
									<input type="text" name="classification_title" id="classification_title" class="validate[required]" value="<?= $row['classification_title'] ?>" style="width:80%;" required />

                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Inclusion Lunch Date</p>
                                    <select  class="mySelect for" name="inclusion_lunch_date[]" id="inclusion_lunch_date" multiple="multiple" style="width:100%">
										<?php
										$selected_inclusion_lunch_date = json_decode($row['inclusion_lunch_date']);

										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Lunch'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {
											if (in_array(date('d-m-Y', strtotime($rowsl['date'])), $selected_inclusion_lunch_date)) {
												$selected = "selected";
											} else {
												$selected = "";
											}
										?>
											<option value="<?= date('d-m-Y', strtotime($rowsl['date'])) ?>" <?=$selected?>><?= date('d-m-Y', strtotime($rowsl['date'])) ?></option>
										<?php } ?>
									</select>
                                </div>
                                <div class="frm_grp span_3">
                                    <p class="frm-head">Inclusion Conference Dinner Date</p>
                                     <select  class="mySelect for" name="inclusion_dinner_date[]" id="inclusion_dinner_date" multiple="multiple" style="width:100%">
										<?php
										$selected_inclusion_dinner_date = json_decode($row['inclusion_dinner_date']);

										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Dinner'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {

											if (in_array(date('d-m-Y', strtotime($rowsl['date'])), $selected_inclusion_dinner_date)) {
												$selected = "selected";
											} else {
												$selected = "";
											}
										?>
											<option value="<?= date('d-m-Y', strtotime($rowsl['date'])) ?>" <?= $selected ?>><?= date('d-m-Y', strtotime($rowsl['date'])) ?></option>
										<?php } ?>
									</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Scientific Halls</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_sci_hall" name="inclusion_sci_hall"  value="Y" <? if ($row['inclusion_sci_hall'] == 'Y') {echo "checked";} ?> >
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio"id="inclusion_sci_hall" name="inclusion_sci_hall"  value="N"  <? if ($row['inclusion_sci_hall'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Exhibition Area</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area"  value="Y" <? if ($row['inclusion_exb_area'] == 'Y') {echo "checked";} ?>>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area"  value="N"  <? if ($row['inclusion_exb_area'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Tea/Coffee during the Conference</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio"  id="inclusion_tea_coffee" name="inclusion_tea_coffee"  value="Y" <? if ($row['inclusion_tea_coffee'] == 'Y') {echo "checked";} ?>>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_tea_coffee" name="inclusion_tea_coffee" value="N"  <? if ($row['inclusion_tea_coffee'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Kit</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_conference_kit" name="inclusion_conference_kit"  value="Y" <? if ($row['inclusion_conference_kit'] == 'Y') {echo "checked";} ?> required>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio"  id="inclusion_conference_kit" name="inclusion_conference_kit"  value="N"  <? if ($row['inclusion_conference_kit'] == 'N') {echo "checked";}?> required>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
        <!-- Add accompany classification pop up -->
        <!-- Edit Documents Header/ Footer pop up -->
        <div class="pop_up_body" id="editdocheaderfooter">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Image</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Document Header</p>
                                    <input style="display: none;" id="documentheader">
                                    <label for="documentheader" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Document Footer</p>
                                    <input style="display: none;" id="documentfooter">
                                    <label for="documentfooter" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mailer Logo</p>
                                    <input style="display: none;" id="mailerlogo">
                                    <label for="mailerlogo" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Site Logo</p>
                                    <input style="display: none;" id="sitelogo">
                                    <label for="sitelogo" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Documents Header/ Footer pop up -->
        <!-- Edit Scientific Section Mailer Setting pop up -->
        <div class="pop_up_body" id="editscisectionmailer">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Image</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Header Image</p>
                                    <input style="display: none;" id="sciheaderimage">
                                    <label for="sciheaderimage" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Sidebar</p>
                                    <input style="display: none;" id="scisidebarimage">
                                    <label for="scisidebarimage" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Footer Image</p>
                                    <input style="display: none;" id="scifooterimage">
                                    <label for="scifooterimage" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Scientific Section Mailer Setting pop up -->
        <!-- Edit Exhibitor Mailer Setting pop up -->
        <div class="pop_up_body" id="editexibitorimage">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Image</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Header Image</p>
                                    <input style="display: none;" id="exiheaderimage">
                                    <label for="exiheaderimage" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Sidebar</p>
                                    <input style="display: none;" id="exisidebarimage">
                                    <label for="exisidebarimage" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Footer Image</p>
                                    <input style="display: none;" id="exifooterimage">
                                    <label for="exifooterimage" class="frm-image"><i class="fal fa-plus"></i> Image</label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Exhibitor Mailer Setting pop up -->
        <!-- Edit Mail Setting Listing pop up -->
        <div class="pop_up_body" id="edimailsettinglisting">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Mail Setting</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mail Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mail Subject</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Mail Body</p>
                                    <textarea></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Mail Setting Listing pop up -->
        <!-- Edit Exhibitor Mail Setting Listing pop up -->
        <div class="pop_up_body" id="ediexibitormailsettinglisting">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Mail Setting</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mail Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mail Subject</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Mail Body</p>
                                    <textarea></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Exhibitor Mail Setting Listing pop up -->
        <!-- Edit Membership Mail Setting Listing pop up -->
        <div class="pop_up_body" id="edimembormailsettinglisting">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Mail Setting</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mail Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Mail Subject</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Mail Body</p>
                                    <textarea></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Membership Mail Setting Listing pop up -->
        <!-- New Country pop up -->
        <div class="pop_up_body" id="newcountry">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>New Country</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">

                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country Abbreviation</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country ISD Code</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Currency</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Country pop up -->
        <!-- edit Country pop up -->
        <div class="pop_up_body" id="editcountry">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Country</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">

                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country Abbreviation</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country ISD Code</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Currency</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit Country pop up -->
        <!-- New State pop up -->
        <div class="pop_up_body" id="newstate">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>New State</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">

                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Name</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_4">
                                    <div class="accm_add_box">
                                        <div class="form_grid">
                                            <div class="frm_grp span_4">
                                                <input>
                                            </div>
                                            <div class="frm_grp span_2">
                                                <div class="cus_check_wrap">
                                                    <label class="cus_check gender_check">
                                                        <input type="radio" name="food">
                                                        <span class="checkmark">Veg</span>
                                                    </label>
                                                    <label class="cus_check gender_check">
                                                        <input type="radio" name="food">
                                                        <span class="checkmark">Non Veg</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="frm_grp span_2">
                                                <a href="#" class="accm_delet icon_hover badge_danger action-transparent"><i class="fal fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New State pop up -->
        <!-- edit State pop up -->
        <div class="pop_up_body" id="editstate">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Country</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">

                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Name</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country Abbreviation</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Country ISD Code</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Country Currency</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit State pop up -->
        <!-- New combo pop up -->
        <div class="pop_up_body" id="newcombo">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Registration Combo Classification</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span>Regsitration Classification</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Package Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Cutoff <i class="mandatory">*</i></p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Registration Classification</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Registration Price <i class="mandatory">*</i></p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Workshop Price<i class="mandatory">*</i></p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Workshop Classification <i class="mandatory">*</i></p>
                                    <select class="mySelect for" multiple="multiple" style="width: 100%;">
                                        <option>TB & Critical Care Workshop</option>
                                        <option>TB & Critical Care Workshop</option>
                                        <option>TB & Critical Care Workshop</option>
                                        <option>TB & Critical Care Workshop</option>
                                    </select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Dinner Price</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Lunch Date</p>
                                    <input type="date">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Dinner Date</p>
                                    <input type="date">
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Scientific Halls</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Exhibition Area</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Tea/Coffee during the Conference</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Kit</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" name="food">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span>Hotel Details</span>
                            </h4>
                            <div class="form_grid">
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Hotel</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Room Type <i class="mandatory">*</i></p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Accommodation Price (Individual)</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Accommodation Price (Shared)</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2 accm_add_box pl-0 pt-0 pb-0 bg-transparent">
                                    <p class="frm-head">No. Of Night</p>
                                    <input>
                                    <a href="#" class="accm_delet icon_hover badge_primary action-transparent"><i class="fal fa-paper-plane"></i></a>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Seat limit</p>
                                    <input>
                                </div>
                                <div class="span_4 accm_add_box badge_padding">
                                    <div class="table_wrap">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Check In Date</th>
                                                    <th>Check Out Date</th>
                                                    <th>INR Rate</th>
                                                    <th>USD Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2026-01-17</td>
                                                    <td>2026-01-18</td>
                                                    <td>5000.00</td>
                                                    <td>16.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="frm_grp span_2">
                                    <p class="frm-head">Sequence By</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Currency</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Round Of price (Individual)</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Round Of price (Shared)</p>
                                    <input>
                                </div>
                            </div>
                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_danger py-2 px-2">Total Price (Individual)<span class="text-white mt-0">₹ 12,980</span></h6>
                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_danger py-2 px-2">Total Price (Shared)<span class="text-white mt-0">₹ 12,980</span></h6>
                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_success py-2 px-2">Total Round Of Price (Individual)<span class="text-white mt-0">₹ 12,980</span></h6>
                            <h6 class="due_balance mt-3 d-flex justify-content-between align-items-center badge_success py-2 px-2">Total Round Of Price (Shared)<span class="text-white mt-0">₹ 12,980</span></h6>
                        </div>

                    </div>

                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New combo pop up -->
        <!-- New registration classification pop up -->
        <div class="pop_up_body" id="newregistrationclassification">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Registration Classification</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_reg_classification.process.php" id="frmtypeadd" onsubmit="return onSubmitAction();" enctype="multipart/form-data">
		         <input type="hidden" name="act" value="add" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification Title <i class="mandatory">*</i></p>
                                    <input type="text" name="classification_title" id="classification_title" class="validate[required]" onblur="checkClassificationTitle(this)" required />
                                </div>
                                 <div class="frm_grp span_4">
                                    <p class="frm-head">Description<i class="mandatory">*</i></p>
                                     <input type="text" name="title_description" id="title_description" class="validate[required]" value=""  required />

                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification Type <i class="mandatory">*</i></p>
                                    <select name="type"  required="">
										<option value="DELEGATE">DELEGATE</option>
										<option value="ACCOMPANY">ACCOMPANY</option>
										<option value="COMBO">COMBO</option>
										<option value="FULL_ACCESS">FULL ACCESS</option>
										<option value="GUEST">GUEST</option>
									</select>
                                </div>
                                
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Seat limit <i class="mandatory">*</i></p>
                                     <input type="text" name="seat_limit_add" id="seat_limit_add" class="validate[required]" value=""  required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Sequence By <i class="mandatory">*</i></p>
                                    <input type="number" name="sequence_by" id="sequence_by" value="<?= $row['sequence_by'] ?>"  rel="splDate" required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Currency<i class="mandatory">*</i></p>
                                   <select name="currency"  required="">
										<option value="INR">INR</option>
										<option value="USD">USD</option>
									</select>
                                </div>
                                <div class="frm_grp span_2 iconBox_editclss">
                                    <p class="frm-head">Icon</p>
                                    <input style="display: none;" class="icon_input_clss" type="file"  name="icon" id="roomimage">
                                    <label  class="frm-image uploadIcon_class"><i class="fal fa-upload"></i></label>
                                    <div class="frm_img_preview ">
                                        <img class=" iconPreview_clss" src="">
                                        <button class="removeIcon_clss"><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Lunch Date</p>
                                    <select class="mySelect for" name="inclusion_lunch_date[]" multiple="multiple" style="width: 100%;">		
                                       <?php
										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Lunch'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {
										?>
											<option value="<?= $rowsl['date'] ?>"><?= $rowsl['date'] ?></option>
										<?php } ?>
									</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Dinner Date</p>
                                    <select class="mySelect for" name="inclusion_conference_kit_date[]" multiple="multiple" style="width: 100%;">		
                                       <?php
										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Dinner'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {
										?>
											<option value="<?= $rowsl['date'] ?>"><?= $rowsl['date'] ?></option>
										<?php } ?>
									</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Scientific Halls</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_sci_hall" name="inclusion_sci_hall"  value="Y">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_sci_hall" name="inclusion_sci_hall" value="N">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Exhibition Area</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area" value="Y">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area" value="N">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Tea/Coffee during the Conference</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_tea_coffee" name="inclusion_tea_coffee"  value="Y">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_tea_coffee" name="inclusion_tea_coffee"  value="N">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Kit</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_conference_kit" name="inclusion_conference_kit" value="Y">
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_conference_kit" name="inclusion_conference_kit" value="N">
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- New registration classification pop up -->
          <!-- New combo pop up -->
        <!-- New registration classification pop up -->
        <div class="pop_up_body" id="editRegistrationclassification">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit Registration Classification</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmtypeadd" method="post" action="<?= $cfg['SECTION_BASE_URL'] ?>manage_reg_process.php" id="frmtypeadd" onsubmit="return onSubmitAction();" enctype="multipart/form-data">
		        <input type="hidden" name="act" value="update" />
		        <input type="hidden" name="id" id="id" value="<?= $classificationId ?>" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                          <?php
                            $sql_cal			=	array();
                            $sql_cal['QUERY']	=	"SELECT * 
                                                        FROM " . _DB_REGISTRATION_CLASSIFICATION_ . "
                                                        WHERE `status` 	!= 		'D'
                                                        AND `id` = '".$classificationId."'
                                                        ORDER BY `sequence_by` ASC";


                            $res_cal = $mycms->sql_select($sql_cal);
                            $row = $res_cal[0];
                            $icon_image = '../../' . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['icon'];
		                    $inclusion_lunch_icon = '../../' . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['inclusion_lunch_icon'];
		                    $inclusion_conference_kit_icon = '../../' . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['inclusion_conference_kit_icon'];
                        ?>
                        <div class="registration-pop_body_box_inner">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification Title <i class="mandatory">*</i></p>
									<input type="text" name="classification_title" id="classification_title" class="validate[required]" value="<?= $row['classification_title'] ?>"  required />
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Classification Type <i class="mandatory">*</i></p>
                                     <select name="type" required="">
										<option <? if ($row['type'] == 'DELEGATE') {
													echo "selected";
												} ?> value="DELEGATE">DELEGATE</option>
										<option <? if ($row['type'] == 'ACCOMPANY') {
													echo "selected";
												} ?> value="ACCOMPANY">ACCOMPANY</option>
										<option <? if ($row['type'] == 'COMBO') {
													echo "selected";
												} ?> value="COMBO">COMBO</option>
										<option <? if ($row['type'] == 'FULL_ACCESS') {
													echo "selected";
												} ?> value="FULL_ACCESS">FULL ACCESS</option>
										<option <? if ($row['type'] == 'GUEST') {
													echo "selected";
												} ?> value="GUEST">GUEST</option>
									</select>
                                </div>
                                 <div class="frm_grp span_4">
                                    <p class="frm-head">Description<i class="mandatory">*</i></p>
                                     <input type="text" name="title_description" id="title_description" value="<?= $row['title_description'] ?>"  class="validate[required]" value=""  required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Seat limit <i class="mandatory">*</i></p>
									<input type="text" name="seat_limit_add" id="seat_limit_add" class="validate[required]" onblur="countryAvailabilityAdd(this.value)" value="<?= $row['seat_limit'] ?>"  required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Sequence By <i class="mandatory">*</i></p>
									<input type="number" name="sequence_by" id="sequence_by" value="<?= $row['sequence_by'] ?>"  rel="splDate" required />

                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Currency<i class="mandatory">*</i></p>
                                   <select name="currency" required="">
										<option <? if ($row['currency'] == 'INR') {
													echo "selected";
												} ?> value="INR">INR</option>
										<option <? if ($row['currency'] == 'USD') {
													echo "selected";
												} ?> value="USD">USD</option>
									</select>
                                </div>
                                <!-- <?
                                if($row['icon']!=''){
                                    ?>
                                <div class="frm_grp span_2 iconBox_editclss2">
                                    <p class="frm-head">Icon</p>
                                    <input style="display: none;" class="icon_input_clss2" type="file"  name="icon" id="roomimage">
                                    <label  class="frm-image uploadIcon_class2" style="display: none;"><i class="fal fa-upload"></i></label>
                                    <div class="frm_img_preview " style="display: block;">
                                        <img class=" iconPreview_clss2" src="<?php echo $icon_image; ?>">
                                        <button class="removeIcon_clss2"><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <?
                                }
                                else{
                                ?>
                                 <div class="frm_grp span_2 iconBox_editclss2">
                                    <p class="frm-head">Icon</p>
                                    <input style="display: none;" class="icon_input_clss2" type="file"  name="icon" id="roomimage2">
                                    <label  class="frm-image uploadIcon_class2"><i class="fal fa-upload"></i></label>
                                    <div class="frm_img_preview ">
                                        <img class=" iconPreview_clss2" src="">
                                        <button class="removeIcon_clss2"><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <?
                                }
                                ?> -->
                                <?php
                                    $uniqueId = 'roomimage_' . $row['id'] . '_' . uniqid();
                                    $hasIcon = !empty($row['icon']);
                                    $iconSrc = $hasIcon ? _BASE_URL_.$cfg['EMAIL.HEADER.FOOTER.IMAGE'].$row['icon'] : '';
                                    ?>
                                    <div class="frm_grp span_2 iconBox_editclss2">
                                        <p class="frm-head">Icon</p>
                                        <input type="file" id="<?= $uniqueId ?>" class="icon_input_clss2" name="icon" style="display: none;">
                                        <input type="hidden" name="iconExist" value="<?= $row['icon'] ?>" style="display: none;">
                                        <label for="<?= $uniqueId ?>" class="frm-image uploadIcon_class2" style="<?= $hasIcon ? 'display:none;' : 'display:block;' ?>">
                                            <i class="fal fa-upload"></i>
                                        </label>
                                        <div class="frm_img_preview" style="<?= $hasIcon ? 'display:block;' : 'display:none;' ?>">
                                            <img class="iconPreview_clss2" src="<?= $iconSrc ?>" data-default="<?= $iconSrc ?>">
                                            <button type="button" class="removeIcon_clss2"><i class="fal fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Lunch Date</p>
                                    <select  class="mySelect for" name="inclusion_lunch_date[]" id="inclusion_lunch_date" multiple="multiple" style="width:100%">
										<?php
										$selected_inclusion_lunch_date = json_decode($row['inclusion_lunch_date']);

										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Lunch'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {
											if (in_array(date('d-m-Y', strtotime($rowsl['date'])), $selected_inclusion_lunch_date)) {
												$selected = "selected";
											} else {
												$selected = "";
											}
										?>
											<option value="<?= date('d-m-Y', strtotime($rowsl['date'])) ?>" <?=$selected?>><?= date('d-m-Y', strtotime($rowsl['date'])) ?></option>
										<?php } ?>
										<!-- <?php
											$selected_inclusion_lunch_date = json_decode($row['inclusion_lunch_date']);
											if (count($selected_inclusion_lunch_date) > 0) {
												foreach ($selected_inclusion_lunch_date as $key => $value) {
											?>
												
												<option value="<?php echo $value; ?>"<?php if ($value != '') {
																							echo ' selected';
																						} ?>><?php echo $value; ?></option>
												<?php
												}
											} else {
											}
										?> -->
									</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Dinner Date</p>
                                    <select class="mySelect for" name="inclusion_conference_kit_date[]" id="inclusion_conference_kit_date" multiple="multiple" style="width:100%">
										<?php
										$selected_inclusion_conference_kit_date = json_decode($row['inclusion_conference_kit_date']);

										$sql_cal = array();
										$sql_cal['QUERY']	=	"SELECT *  
														FROM " . _DB_INCLUSION_DATE_ . " 
														WHERE status != 'D' AND `purpose`='Dinner'";
										$res_cal			=	$mycms->sql_select($sql_cal);
										$i = 1;

										foreach ($res_cal as $key => $rowsl) {

											if (in_array(date('d-m-Y', strtotime($rowsl['date'])), $selected_inclusion_conference_kit_date)) {
												$selected = "selected";
											} else {
												$selected = "";
											}
										?>
											<option value="<?= date('d-m-Y', strtotime($rowsl['date'])) ?>" <?= $selected ?>><?= date('d-m-Y', strtotime($rowsl['date'])) ?></option>
										<?php } ?>

				
									</select>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Scientific Halls</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_sci_hall" name="inclusion_sci_hall"  value="Y" <? if ($row['inclusion_sci_hall'] == 'Y') {echo "checked";} ?>>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_sci_hall" name="inclusion_sci_hall"  value="N"  <? if ($row['inclusion_sci_hall'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Entry to Exhibition Area</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area"  value="Y" <? if ($row['inclusion_exb_area'] == 'Y') {echo "checked";} ?>>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_exb_area" name="inclusion_exb_area"  value="N"  <? if ($row['inclusion_exb_area'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Tea/Coffee during the Conference</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_tea_coffee" name="inclusion_tea_coffee"  value="Y" <? if ($row['inclusion_tea_coffee'] == 'Y') {echo "checked";} ?>>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio"  id="inclusion_tea_coffee" name="inclusion_tea_coffee" value="N"  <? if ($row['inclusion_tea_coffee'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Inclusion Conference Kit</p>
                                    <div class="cus_check_wrap">
                                        <label class="cus_check gender_check">
                                            <input type="radio"  id="inclusion_conference_kit" name="inclusion_conference_kit"  value="Y" <? if ($row['inclusion_conference_kit'] == 'Y') {echo "checked";} ?>>
                                            <span class="checkmark">Yes</span>
                                        </label>
                                        <label class="cus_check gender_check">
                                            <input type="radio" id="inclusion_conference_kit" name="inclusion_conference_kit"  value="N"  <? if ($row['inclusion_conference_kit'] == 'N') {echo "checked";}?>>
                                            <span class="checkmark">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- New registration classification pop up -->
         <!-- Edit registration tariff pop up -->
        <div class="pop_up_body" id="editregistrationtariff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Update Registration Tariff</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <form name="frmTariffEdit" id="frmTariffEdit" method="post" action="registration_tariff.process.php" onsubmit="return onSubmitAction();">
			    <input type="hidden" name="act" id="act" value="update" />
			   <input type="hidden" name="classification_id" id="classification_id" value="<?=$classId?>" />
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="frm_grp">
                             <?php
                                $sqlRegClasf			= array();
                                $sqlRegClasf['QUERY']	= "SELECT `classification_title`,`id`,`currency`,`type` ,`isOffer`,icon, residential_hotel_id
                                                            FROM "._DB_REGISTRATION_CLASSIFICATION_." 
                                                            WHERE `id` = ? 
                                                             ";
                                $sqlRegClasf['PARAM'][]  = array('FILD' => 'id',  'DATA' =>$classId,  'TYP' => 's');			

                                $resRegClasf			 = $mycms->sql_select($sqlRegClasf);	
                                ?>
                            <p class="frm-head">Classification</p>
                            <p class="typed_data" ><?=$resRegClasf[0]['classification_title']?></p>
                        </div>
                         <? 
                            $sql = array();
                            $sql['QUERY']	=	"SELECT cutoff.cutoff_title,`id` 
                                                FROM "._DB_TARIFF_CUTOFF_." cutoff
                                                WHERE status = 'A'";
                            $res=$mycms->sql_select($sql);
                            foreach($res as $k=>$title)
                             {	 
                            ?>		
                        <div class="registration-pop_body_box_inner">
                            <h4 class="registration-pop_body_box_heading">
                                <span><?=strip_tags($title['cutoff_title'])?></span>
                            </h4>
                             <?php
                    
                                 $sqlTarrif				= array();
                                $sqlTarrif['QUERY'] 	= "SELECT *
                                                            FROM "._DB_TARIFF_REGISTRATION_." 
                                                            WHERE tariff_classification_id = ?
                                                            AND tariff_cutoff_id = ?";
                                $sqlTarrif['PARAM'][]   = array('FILD' => 'tariff_classification_id',  	'DATA' =>$classId,  'TYP' => 's');		
                                $sqlTarrif['PARAM'][]   = array('FILD' => 'tariff_cutoff_id',  			'DATA' =>$title['id'],  'TYP' => 's');		
                                $resTarrif				= $mycms->sql_select($sqlTarrif);
                               
                            ?>
                            <div class="frm_grp">
                                <p class="frm-head"><?=$resRegClasf[0]['currency']?></p>
                                <input type="hidden" name="currency[<?=$title['id']?>]" id="currency_<?=$title['id']?>" value="<?=$resRegClasf[0]['currency']?>"	/>						

                                <input  name="tariff_cutoff_id[<?=$title['id']?>]" id="tariff_first_cutoff_id_<?=$title['id']?>" value="<?=($resTarrif[0]['amount']!='')?$resTarrif[0]['amount']:'0.00';?>">
                            </div>
                        </div>
                        <?
                            }
                            ?>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                    </div>
                </div>
             </form>
            </div>
        </div>
        <!-- Edit registration tariff pop up -->
          <!-- Edit editDinnertariff pop up -->
        <!-- Edit Dinner tariff pop up -->
        <div class="pop_up_body" id="editDinnertariff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Update Dinner Tariff</span>
                    <p>
                        <a href="javascript:void(0)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                  <?
                    $dinnerId                       = $_REQUEST['dinnerId']; 					
                    $sql_cal	=	array();
                    $sql_cal['QUERY']		 =	"SELECT * 
                                                FROM "._DB_DINNER_CLASSIFICATION_." 
                                                WHERE status != ?
                                                    AND id = ? 
                                            ORDER BY `id` ASC";
                    $sql_cal['PARAM'][]  = array('FILD' => 'status',  'DATA' =>'D',  		'TYP' => 's');							
                    $sql_cal['PARAM'][]  = array('FILD' => 'id',  	  'DATA' =>$dinnerId,  'TYP' => 's');							
                    $res_cal=$mycms->sql_select($sql_cal);
                    $rowDinner =	$res_cal[0];
                    ?>
              		<form name="frmTariffEdit" id="frmTariffEdit" method="post" action="dinner_tariff.process.php" onsubmit="return onSubmitAction();">
			       <input type="hidden" name="act" id="act" value="update" />
			       <input type="hidden" name="dinner_classification_id" id="dinner_classification_id" value="<?=$rowDinner['id']?>" />
                  
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Dinner Classification Name</p>
                                        <p class="typed_data"><?=$rowDinner['dinner_classification_name']?></p>
                                    </div>
                                    <div class="frm_grp span_2">
                                        <p class="frm-head">Hotel Name</p>
                                        <p class="typed_data"><?=$rowDinner['dinner_hotel_name']?></p>
                                    </div>
                                    <?
                                    $sql    =    array();
                                    $sql['QUERY'] = "SELECT cutoff.cutoff_title,cutoff.id 
                                                    FROM " . _DB_TARIFF_CUTOFF_ . " cutoff
                                                    WHERE status = ?";
                                    $sql['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
                                    $res = $mycms->sql_select($sql);

                                    foreach ($res as $key => $title) {
                                        $rowsTariffAmount = [
                                            'inr_amount' => '',
                                            'usd_amount' => ''
                                        ];
                                    ?>
                                        <div class="registration-pop_body_box_inner span_2">
								          <input type="hidden" name="cutoff_id[<?=$title['id']?>]" id="cutoff_id<?=$title['id']?>" value="<?=$title['id']?>" />

                                            <h4 class="registration-pop_body_box_heading">
                                                <span><?= strip_tags($title['cutoff_title']) ?></span>
                                            </h4>
                                            <?

                                            $sqlPackageCheckoutDate	=	array();
                                            // query in tariff table
                                            $sqlPackageCheckoutDate['QUERY'] = "select * 
                                                                                FROM "._DB_DINNER_TARIFF_." accomodation
                                                                                WHERE status = ?
                                                                                AND cutoff_id = ?
                                                                                AND dinner_classification_id = ?";

                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 					 'DATA' => 'A' , 					'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'cutoff_id' ,				 'DATA' => $title['id'] , 		'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'dinner_classification_id' , 'DATA' => $dinnerId, 		'TYP' => 's');				   
                                            $resPackageCheckoutDate = $mycms->sql_select($sqlPackageCheckoutDate);
                                      
                                            if (!empty($resPackageCheckoutDate)) {
                                                $rowsTariffAmount = $resPackageCheckoutDate[0];
                                                // print_r($rowsTariffAmount);
                                            ?>
                                            <?
                                            } else {

                                                $rowsTariffAmount = [
                                                    'inr_amount' => '0.00',
                                                    'usd_amount' => '0.00',
                                                ];
                                            }

                                            $currency = !empty($resRegClasf) ? $resRegClasf[0]['currency'] : '';
                                            ?>

                                            <input type="hidden" name="tariff_cutoff_id_edit[]" id="tariff_cutoff_id_edit_<?= $title['id'] ?>" value="<?= $title['id'] ?>" />
                                            <input type="hidden" class="currencyClass" name="currency[<?= $title['id'] ?>]" id="currency_<?= $title['id'] ?>" value="<?= $currency ?>" />
                                            <div class="form_grid">
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">INR</p>
                                                    <input value="<?= $rowsTariffAmount['inr_amount']?$rowsTariffAmount['inr_amount']:'0.00' ?>" name="tariff_inr_cutoff_id_edit[<?=$title['id']?>]" id="tariff_inr_first_cutoff_id_edit_<?=$title['id']?>" >
                                                </div>
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">USD</p>
                                                    <input value="<?= $rowsTariffAmount['usd_amount']?$rowsTariffAmount['usd_amount']:'0.00' ?>" name="tariff_usd_cutoff_id_edit[<?= $title['id'] ?>]" id="tariff_usd_first_cutoff_id_edit_<?= $title['id'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Dinner tariff pop up -->
           <!-- Edit accompany tariff pop up -->
        <div class="pop_up_body" id="editaccompanytariff">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Update Accompany Tariff</span>
                    <p>
                        <a href="javascript:void(0)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                  <?
                    $sqlRegClasf			= array();
                    $sqlRegClasf['QUERY']	= "SELECT `classification_title`,`id`
                                                FROM "._DB_ACCOMPANY_CLASSIFICATION_." 
                                                WHERE status = ?
                                                AND `id` = ? ";
                    $sqlRegClasf['PARAM'][]  = array('FILD' => 'status',  'DATA' =>'A',  'TYP' => 's');	
                    $sqlRegClasf['PARAM'][]  = array('FILD' => 'id',  'DATA' =>$accompanytariffId,  'TYP' => 's');					
                    $resRegClasf			 = $mycms->sql_select($sqlRegClasf);			
                    $rowRegClasf =	$resRegClasf[0];
                    ?>
                    <form name="frmTariffEdit" id="frmTariffEdit" method="post" action="accompany_tariff.process.php" onsubmit="return onSubmitAction();">
                    <input type="hidden" name="act" id="act" value="update" />
                    <input type="hidden" name="classification_id" id="classification_id" value="<?=$accompanytariffId?>" />
                    <div class="registration-pop_body">
                        <div class="registration-pop_body_box">
                            <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                                <div class="form_grid">
                                    <div class="frm_grp span_4">
                                        <p class="frm-head">Accompany Classification Name</p>
                                        <p class="typed_data" id="accompanytitle"><?=$rowRegClasf['classification_title']?></p>
                                    </div>
                                    
                                    <?
                                    $sql    =    array();
                                    $sql['QUERY'] = "SELECT cutoff.cutoff_title,cutoff.id 
                                                    FROM " . _DB_TARIFF_CUTOFF_ . " cutoff
                                                    WHERE status = ?";
                                    $sql['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
                                    $res = $mycms->sql_select($sql);

                                    foreach ($res as $key => $title) {
                                        $rowsTariffAmount = [
                                            'inr_amount' => '',
                                            'usd_amount' => ''
                                        ];
                                    ?>
                                        <div class="registration-pop_body_box_inner span_2">
								          <input type="hidden" name="cutoff_id[<?=$title['id']?>]" id="cutoff_id<?=$title['id']?>" value="<?=$title['id']?>" />

                                            <h4 class="registration-pop_body_box_heading">
                                                <span><?= strip_tags($title['cutoff_title']) ?></span>
                                            </h4>
                                            <?

                                            $sqlPackageCheckoutDate	=	array();
                                            // query in tariff table
                                            $sqlPackageCheckoutDate['QUERY'] = "select * 
                                                                                FROM "._DB_TARIFF_ACCOMPANY_." accomodation
                                                                                WHERE status = ?
                                                                                AND tariff_cutoff_id = ?
                                                                                AND tariff_classification_id = ?";

                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'status' , 					 'DATA' => 'A' , 					'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'tariff_cutoff_id' ,				 'DATA' => $title['id'] , 		'TYP' => 's');
                                            $sqlPackageCheckoutDate['PARAM'][]	=	array('FILD' => 'tariff_classification_id' , 'DATA' => $accompanytariffId, 		'TYP' => 's');				   
                                            $resPackageCheckoutDate = $mycms->sql_select($sqlPackageCheckoutDate);
                                      
                                            if (!empty($resPackageCheckoutDate)) {
                                                $rowsTariffAmount = $resPackageCheckoutDate[0];
                                                // print_r($rowsTariffAmount);
                                            ?>
                                            <?
                                            } else {

                                                $rowsTariffAmount = [
                                                    'amount' => '0.00',
                                                  
                                                ];
                                            }

                                            $currency = !empty($resRegClasf) ? $resRegClasf[0]['currency'] : '';
                                            ?>

										    <input type="hidden" name="currency[<?=$title['id']?>]" id="currency_<?=$title['id']?>" value="<?=$valRegClasfDetails['CURRENCY']?>"	/>						
                                            <div class="form_grid">
                                                <div class="frm_grp span_4">
                                                    <!-- <p class="frm-head">INR</p> -->
                                                    <input value="<?= $rowsTariffAmount['amount']?$rowsTariffAmount['amount']:'0.00' ?>" name="tariff_cutoff_id[<?=$title['id']?>]" id="tariff_first_cutoff_id_<?=$title['id']?>" >
                                                </div>
                                                
                                            </div>
                                        </div>
                                    <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registration-pop_footer">
                        <div class="registration_btn_wrap">
                            <button class="popup_close badge_dark">Cancel</button>
                            <button type="submit" class="mi-1 badge_success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit accompany tariff pop up -->
         <!-- New User pop up -->
        <div class="pop_up_body" id="newuser">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>New User</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Email Id</p>
                                    <input type="email">
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Phone No</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Access Role</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Username</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Password</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User pop up -->
        <!-- edit User pop up -->
        <div class="pop_up_body" id="edituser">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Edit User</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Email Id</p>
                                    <input type="email">
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Phone No</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Access Role</p>
                                    <select></select>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Username</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Password</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit User pop up -->
             
        <!-- Add highlight speakers pop up -->
        <div class="pop_up_body" id="newspeaker">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Highlight Speaker</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_1">
                                    <p class="frm-head">Speaker Image</p>
                                    <input style="display: none;" id="accessoriesicon">
                                    <label for="accessoriesicon" class="frm-image"><i class="fal fa-upload"></i></label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_3">
                                    <p class="frm-head">Speaker Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Designation</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Hall Name</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_2">
                                    <p class="frm-head">Program Date</p>
                                    <input type="date">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add highlight speakers pop up -->
        <!-- Add program date pop up -->
        <div class="pop_up_body" id="newscientificdate">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Program Date</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_1">
                                    <p class="frm-head">Program Image</p>
                                    <input style="display: none;" id="accessoriesicon">
                                    <label for="accessoriesicon" class="frm-image"><i class="fal fa-upload"></i></label>
                                    <div class="frm_img_preview">
                                        <img src="https://ruedakolkata.com/natcon2025/uploads/EMAIL.HEADER.FOOTER.IMAGE/HOTELICON_0_0001_250107125112.png">
                                        <button><i class="fal fa-trash-alt"></i></button>
                                    </div>
                                </div>
                                <div class="frm_grp span_3">
                                    <p class="frm-head">Program Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Program Description</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Program Date</p>
                                    <input type="date">
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Program Highlights</p>
                                    <textarea></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add program date pop up -->
        <!-- Add scientific venue pop up -->
        <div class="pop_up_body" id="newscientificvenue">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Venue</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Venue Title</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add scientific venue pop up -->
        <!-- Add scientific participant type pop up -->
        <div class="pop_up_body" id="newscientificparticipanttype">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Participant Type</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Participant Type</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add scientific participant type pop up -->
        <!-- Add scientific hall pop up -->
        <div class="pop_up_body" id="newscientifichall">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Hall</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Hall Title</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Hall Tag</p>
                                    <input>
                                </div>
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Venue</p>
                                    <select>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="frm_grp span_4">
                                    <div class="form_grid">
                                        <div class="registration-pop_body_box_inner span_4">
                                            <div class="form_grid">
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Date & Time</p>
                                                    <p class="typed_data">2026-01-15 18:58:00</p>
                                                </div>
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Hall</p>
                                                    <input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="registration-pop_body_box_inner span_4">
                                            <div class="form_grid">
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Date & Time</p>
                                                    <p class="typed_data">2026-01-15 18:58:00</p>
                                                </div>
                                                <div class="frm_grp span_2">
                                                    <p class="frm-head">Hall</p>
                                                    <input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add scientific hall pop up -->
        <!-- Add scientific session pop up -->
        <div class="pop_up_body" id="addscientificSession">
            <div class="registration_pop_up">
                <div class="registration-pop_heading">
                    <span>Add Participant Type</span>
                    <p>
                        <a href="javascript:void(null)" class="popup_close icon_hover badge_danger action-transparent"><?php close(); ?></a>
                    </p>
                </div>
                <div class="registration-pop_body">
                    <div class="registration-pop_body_box">
                        <div class="registration-pop_body_box_inner p-0 bg-transparent border-0">
                            <div class="form_grid">
                                <div class="frm_grp span_4">
                                    <p class="frm-head">Session Type</p>
                                    <input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-pop_footer">
                    <div class="registration_btn_wrap">
                        <button class="popup_close badge_dark">Cancel</button>
                        <button type="submit" class="mi-1 badge_success"><?php save(); ?>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add scientific session pop up -->
    </div>
</div>
<script>
    document.addEventListener("click", function(e) {
        if (e.target.closest(".popup_close")) {
            e.preventDefault(); // stops form submit
            document.getElementById("editworkshoptariff").style.display = "none";
            $(".pop_up_wrap").hide(); // blur appears
            $(".pop_up_body").hide();
        }


    });
    
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const addBtn = document.getElementById("add_package_1");
    const wrapper = document.getElementById("accm_add_wrap_1");
    const empty = document.getElementById("accm_add_empty_1");
    const template = document.getElementById("package_box");

    addBtn.addEventListener("click", function (e) {
        e.preventDefault();

        empty.style.display = "none";

        const clone = template.cloneNode(true);
        clone.style.display = "block";
        clone.removeAttribute("id"); // VERY IMPORTANT

        wrapper.appendChild(clone);
    });

    wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            e.target.closest(".accm_add_box").remove();

            if (wrapper.querySelectorAll(".accm_add_box").length === 1) {
                empty.style.display = "block";
            }
        }
    });

});
</script>

<script>
  
function initEditHotelPackages() {

    const wrapper1  = document.getElementById("accm_edit_wrap_1");
    const template1 = document.getElementById("package_template");
    const empty1    = document.getElementById("accm_edit_empty_1");

    if (!wrapper1 || !template1) return;

    // prevent multiple bindings
    if (document.body.dataset.accmInit === "1") return;
    document.body.dataset.accmInit = "1";

    document.addEventListener("click", function (e) {

        // ADD
        if (e.target.closest("#edit_package_1")) {
            e.preventDefault();

            if (empty1) empty1.style.display = "none";

            const clone = template1.cloneNode(true);
            clone.style.display = "block";
            clone.removeAttribute("id");

            wrapper1.appendChild(clone);
        }

        // DELETE
        // const delBtn = e.target.closest(".accm_delet");
        // if (delBtn) {
        //     e.preventDefault();

        //     const box = delBtn.closest(".accm_add_box");
        //     if (box) box.remove();

        //     if (
        //         wrapper1.querySelectorAll(".accm_add_box").length === 0 &&
        //         empty1
        //     ) {
        //         empty1.style.display = "block";
        //     }
        // }
        wrapper1.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            e.target.closest(".accm_add_box").remove();

            if (wrapper1.querySelectorAll(".accm_add_box").length === 1) {
                empty1.style.display = "block";
            }
        }
    });
    });
}

// initial page load
document.addEventListener("DOMContentLoaded", initEditHotelPackages);
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const addBtn = document.getElementById("add_aminity_1");
    const wrapper = document.getElementById("accm_add_wrap_2");
    const empty = document.getElementById("accm_add_empty_2");
    const template = document.getElementById("aminity_box");

    addBtn.addEventListener("click", function (e) {
        e.preventDefault();

        empty.style.display = "none";

        const clone = template.cloneNode(true);
        clone.style.display = "block";
        clone.removeAttribute("id"); // VERY IMPORTANT

        wrapper.appendChild(clone);
    });

    wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            e.target.closest(".accm_add_box").remove();

            if (wrapper.querySelectorAll(".accm_add_box").length === 1) {
                empty.style.display = "block";
            }
        }
    });

});
</script>
<script>
      
function initEditHotelAminity() {

    const addBtn = document.getElementById("edit_aminity_1");
    const wrapper = document.getElementById("accm_edit_wrap_2");
    const empty = document.getElementById("accm_edit_empty_2");
    const template = document.getElementById("aminity_box_edit");

    addBtn.addEventListener("click", function (e) {
        e.preventDefault();
    console.log(addBtn);
        empty.style.display = "none";

        const clone = template.cloneNode(true);
        clone.style.display = "block";
        clone.removeAttribute("id"); // VERY IMPORTANT

        wrapper.appendChild(clone);
    });

    wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            e.target.closest(".accm_add_box").remove();

            if (wrapper.querySelectorAll(".accm_add_box").length === 1) {
                empty.style.display = "block";
            }
        }
    });
    /////////////for Aminities Icon Edit///////////////////////

    document.addEventListener('click', function (e) {

        const box = e.target.closest('.iconBox_edit');
        if (!box) return;

        const input = box.querySelector('.icon_input_edit');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.iconPreview_edit');

        // Upload click
        if (e.target.closest('.uploadIcon_edit')) {
            input.click();
            return;
        }

        // Remove icon
        if (e.target.closest('.removeIcon_edit')) {
            input.value = "";
            previewImg.src = "";
            previewBox.style.display = "none";
            box.querySelector('.uploadIcon_edit').style.display = "block";
            return;
        }
    });

    // File change
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('icon_input_edit')) return;

        const input = e.target;
        const box = input.closest('.iconBox_edit');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.iconPreview_edit');

        const file = input.files[0];
        if (!file || !file.type.startsWith('image/')) {
            alert('Please select an image file');
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (evt) {
            previewImg.src = evt.target.result;
            previewBox.style.display = "block";
            box.querySelector('.uploadIcon_edit').style.display = "none";
        };
        reader.readAsDataURL(file);
    });
    //////////////////////end////////////////
}

// initial page load
document.addEventListener("DOMContentLoaded", initEditHotelAminity);
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const addBtn = document.getElementById("add_room_1");
    const wrapper = document.getElementById("accm_add_wrap_3");
    const empty = document.getElementById("accm_add_empty_3");
    const template = document.getElementById("room_box");

    addBtn.addEventListener("click", function (e) {
        e.preventDefault();

        empty.style.display = "none";

        const clone = template.cloneNode(true);
        clone.style.display = "block";
        clone.removeAttribute("id"); // VERY IMPORTANT

        wrapper.appendChild(clone);
    });

    wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            e.target.closest(".accm_add_box").remove();

            if (wrapper.querySelectorAll(".accm_add_box").length === 1) {
                empty.style.display = "block";
            }
        }
    });

});
function updateSeatLimits() {
    const checkIn = document.getElementById('check_in')?.value;
    const checkOut = document.getElementById('check_out')?.value;
    ensureRoomIndexes();
    const seatContainer = document.getElementById('seat_limits_container');
    const roomBoxes = document.querySelectorAll('.accm_add_box_room');

    if (!checkIn || !checkOut) return;

    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);

    if (endDate <= startDate) {
        alert("Check-out date must be after check-in date!");
        return;
    }

    // Format date
    function formatDate(date) {
        return `${String(date.getDate()).padStart(2,'0')}/${
            String(date.getMonth()+1).padStart(2,'0')}/${date.getFullYear()}`;
    }

    // ---------- NORMAL SEAT ----------
    if (seatContainer) {
        seatContainer.innerHTML = '';
        let d = new Date(startDate);

        while (d < endDate) {
            seatContainer.innerHTML += `
                <div class="registration-pop_body_box_inner span_4">
                    <div class="form_grid">
                        <div class="frm_grp span_2">
                            <p class="frm-head">Date</p>
                            <p class="typed_data">${formatDate(d)}</p>
                        </div>
                        <div class="frm_grp span_2">
                            <p class="frm-head">Seat</p>
                            <input name="seat_limit[]" type="number" min="0">
                        </div>
                    </div>
                </div>
            `;
            d.setDate(d.getDate() + 1);
        }
    }

    // ---------- ROOM-WISE SEAT ----------
    roomBoxes.forEach(roomBox => {
        const roomIndex = roomBox.getAttribute('data-room-index');
        const container = roomBox.querySelector('.seat_limits_container_room');

        if (!container) return;

        container.innerHTML = '';
        let d = new Date(startDate);

        while (d < endDate) {
            container.innerHTML += `
                <div class="registration-pop_body_box_inner span_4">
                    <div class="form_grid">
                        <div class="frm_grp span_2">
                            <p class="frm-head">Date</p>
                            <p class="typed_data">${formatDate(d)}</p>
                        </div>
                        <div class="frm_grp span_2">
                            <p class="frm-head">Seat</p>
                            <input 
                                type="number"
                                min="0"
                                name="seat_limit_room[${roomIndex}][]"
                                
                            >
                        </div>
                    </div>
                </div>
            `;
            d.setDate(d.getDate() + 1);
        }
    });
}
function ensureRoomIndexes() {
    document.querySelectorAll('.accm_add_box_room').forEach((box, i) => {
        box.setAttribute('data-room-index', i);
    });
}
document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.querySelector('.toggleswitch-checkbox_add');
    const roomWrap = document.getElementById('accm_add_wrap_3');
    const emptyMsg = document.getElementById('accm_add_empty_3');
    const statusInput = document.getElementById('room_type_status');

    function disableRoomFields() {
        roomWrap.querySelectorAll('input').forEach(input => {
            input.required = false;
        });
    }

    // function enableRoomFields() {
    //     roomWrap.querySelectorAll('input').forEach(input => {
    //         if (input.name && input.name.includes('seat_limit_room')) {
    //             input.required = true;
    //         }
    //     });
    // }

    // INITIAL STATE (unchecked)
    disableRoomFields();
    emptyMsg.style.display = 'block';

    toggle.addEventListener('change', function () {
        if (this.checked) {
            // ✅ ON
            statusInput.value = 'yes';

            emptyMsg.style.display = 'none';
            roomWrap.style.display = 'block';

            enableRoomFields();
        } else {
            // ❌ OFF
            statusInput.value = 'no';

            // hide all room boxes
            roomWrap.querySelectorAll('.accm_add_box_room').forEach(box => {
                box.style.display = 'none';
            });

            emptyMsg.style.display = 'block';
            disableRoomFields();
        }
    });

});
document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.querySelector('.toggleswitch-checkbox_edit');
    const roomWrap = document.getElementById('accm_edit_wrap_3');
    const emptyMsg = document.getElementById('accm_edit_empty_3');
    const statusInput = document.getElementById('room_type_status_edit');
    const roomBoxes = roomWrap.querySelectorAll('.accm_add_box_edit_room');

    function disableRoomFields() {
        roomWrap.querySelectorAll('input').forEach(input => {
            input.required = false;
        });
    }

    function showRooms() {
        roomBoxes.forEach(box => box.style.display = 'block');
        emptyMsg.style.display = 'none';
        statusInput.value = 'yes';
    }

    function hideRooms() {
        roomBoxes.forEach(box => box.style.display = 'none');
        emptyMsg.style.display = 'block';
        statusInput.value = 'no';
        disableRoomFields();
    }

    // ✅ INITIAL STATE (RESPECT PHP checked value)
    if (toggle.checked) {
        showRooms();
    } else {
        hideRooms();
    }

    // ✅ TOGGLE CHANGE
    toggle.addEventListener('change', function () {
        if (this.checked) {
            showRooms();
        } else {
            hideRooms();
        }
    });

});
// function updateSeatLimits() {
//     const checkIn = document.getElementById('check_in').value;
//     const checkOut = document.getElementById('check_out').value;
//     const container = document.getElementById('seat_limits_container');
    
//     // Clear previous rows
//     container.innerHTML = '';

//     if (!checkIn || !checkOut) return;

//     const startDate = new Date(checkIn);
//     const endDate = new Date(checkOut);

//     if (endDate < startDate) {
//         alert("Check-out date must be after check-in date!");
//         return;
//     }

//     // Function to format date as dd/mm/yyyy
//     function formatDate(date) {
//         const day = String(date.getDate()).padStart(2, '0');
//         const month = String(date.getMonth() + 1).padStart(2, '0');
//         const year = date.getFullYear();
//         return `${day}/${month}/${year}`;
//     }

//     // Loop through all dates
//     let currentDate = new Date(startDate);
//     while (currentDate < endDate) {
//         const row = document.createElement('div');
//         row.className = 'registration-pop_body_box_inner span_4';
//         row.innerHTML = `
//             <div class="form_grid">
//                 <div class="frm_grp span_2">
//                     <p class="frm-head">Date</p>
//                     <p class="typed_data">${formatDate(currentDate)}</p>
//                 </div>
//                 <div class="frm_grp span_2">
//                     <p class="frm-head">Seat</p>
//                     <input name="seat_limit[]" type="number" min="0" />
//                 </div>
//             </div>
//         `;
//         container.appendChild(row);

//         // Move to next day
//         currentDate.setDate(currentDate.getDate() + 1);
//     }
// }
//////////////For edit form/////////
function updateSeatLimitsEdit() {
    const checkIn = document.getElementById('check_in_Edit')?.value;
    const checkOut = document.getElementById('check_out_Edit')?.value;
    ensureRoomIndexesEdit();
    const seatContainer = document.getElementById('seat_limits_container_Edit');
    // const roomBoxes = document.querySelectorAll('.accm_add_box_edit_room');
    const roomBoxes = document.querySelectorAll('.accm_add_box_edit_room:not(#room_box_edit)');

    if (!checkIn || !checkOut) return;

    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);

    if (endDate <= startDate) {
        alert("Check-out date must be after check-in date!");
        return;
    }

    // Format date
    function formatDate(date) {
        return `${String(date.getDate()).padStart(2,'0')}/${
            String(date.getMonth()+1).padStart(2,'0')}/${date.getFullYear()}`;
    }

    // ---------- NORMAL SEAT ----------
    if (seatContainer) {
        seatContainer.innerHTML = '';
        let d = new Date(startDate);

        while (d < endDate) {
            seatContainer.innerHTML += `
                <div class="registration-pop_body_box_inner span_4 seat-row">
                    <div class="form_grid">
                        <div class="frm_grp span_2">
                            <p class="frm-head">Date</p>
                            <p class="typed_data">${formatDate(d)}</p>
                        </div>
                        <div class="frm_grp span_2">
                            <p class="frm-head">Seat</p>
                            <input name="seat_limit[]" type="number" min="0">
                        </div>
                    </div>
                </div>
            `;
            d.setDate(d.getDate() + 1);
        }
    }

    // ---------- ROOM-WISE SEAT ----------
      roomBoxes.forEach((roomBox, roomIndex) => {

        // const roomIndex = roomBox.getAttribute('data-room-index');
        const container = roomBox.querySelector('.seat_limits_container_room_edit');

        if (!container) return;
        roomBox.querySelectorAll('.seat_limits_container_room_edit')
        .forEach(c => c.innerHTML = '')
        // container.innerHTML = '';
        let d = new Date(startDate);

        while (d < endDate) {
            container.innerHTML += `
                <div class="registration-pop_body_box_inner span_4">
                    <div class="form_grid">
                        <div class="frm_grp span_2">
                            <p class="frm-head">Date</p>
                            <p class="typed_data">${formatDate(d)}</p>
                        </div>
                        <div class="frm_grp span_2">
                            <p class="frm-head">Seat</p>
                            <input 
                                type="number"
                                min="0"
                                name="seat_limit_room[${roomIndex}][]"
                                
                            >
                        </div>
                    </div>
                </div>
            `;
            d.setDate(d.getDate() + 1);
        }
    });
}
function ensureRoomIndexesEdit() {
    document.querySelectorAll('.accm_add_box_edit_room').forEach((box, i) => {
        box.setAttribute('data-room-index', i);
    });
}
function updateSeatLimitsEditOld() {
    const checkIn = document.getElementById('check_in_Edit').value;
    const checkOut = document.getElementById('check_out_Edit').value;
    const container = document.getElementById('seat_limits_container_Edit');

    if (!checkIn || !checkOut) return;

    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);

    if (endDate < startDate) {
        alert("Check-out date must be after check-in date!");
        return;
    }

    container.innerHTML = '';

    function formatDate(date) {
        const d = String(date.getDate()).padStart(2, '0');
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const y = date.getFullYear();
        return `${d}/${m}/${y}`;
    }

    let currentDate = new Date(startDate);

    while (currentDate < endDate) {
        const isoDate = currentDate.toISOString().split('T')[0];

        container.innerHTML += `
            <div class="registration-pop_body_box_inner span_4 seat-row">
                <div class="form_grid">
                    <div class="frm_grp span_2">
                        <p class="frm-head">Date</p>
                        <p class="typed_data">${formatDate(currentDate)}</p>
                        <input type="hidden" name="seat_date[]" value="${isoDate}">
                    </div>
                    <div class="frm_grp span_2">
                        <p class="frm-head">Seat</p>
                        <input name="seat_limit[]" type="number" min="0">
                    </div>
                </div>
            </div>
        `;

        currentDate.setDate(currentDate.getDate() + 1);
    }
}
</script>
<script>
    /////////////for reg classification Icon///////////////////////
function initEditregClass() {

    document.addEventListener('click', function (e) {

        const box = e.target.closest('.iconBox_editclss');
        if (!box) return;

        // OPEN FILE DIALOG (REQUIRED)
        if (e.target.closest('.uploadIcon_class')) {
            e.preventDefault();
            box.querySelector('.icon_input_clss').click();
            return;
        }

        // REMOVE ICON
        if (e.target.closest('.removeIcon_clss')) {
            e.preventDefault();

            const input = box.querySelector('.icon_input_clss');
            const previewBox = box.querySelector('.frm_img_preview');
            const previewImg = box.querySelector('.iconPreview_clss');

            input.value = "";
            previewImg.src = previewImg.dataset.default || "";
            previewBox.style.display = "none";
            box.querySelector('.uploadIcon_class').style.display = "block";
        }
    });

    // FILE CHANGE
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('icon_input_clss')) return;

        const input = e.target;
        const box = input.closest('.iconBox_editclss');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.iconPreview_clss');

        const file = input.files[0];
        if (!file || !file.type.startsWith('image/')) {
            alert('Please select an image file');
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (evt) {
            previewImg.src = evt.target.result;
            previewBox.style.display = "block";
            box.querySelector('.uploadIcon_class').style.display = "none";
        };

        reader.readAsDataURL(file);
    });

    // //////////////////edit/////////////
    //   document.addEventListener('click', function (e) {

    //     const box = e.target.closest('.iconBox_editclss2');
    //     if (!box) return;

    //     // OPEN FILE DIALOG (REQUIRED)
    //     if (e.target.closest('.uploadIcon_class2')) {
    //         e.preventDefault();
    //         box.querySelector('.icon_input_clss2').click();
    //         return;
    //     }

    //     // REMOVE ICON
    //     if (e.target.closest('.removeIcon_clss2')) {
    //         e.preventDefault();

    //         const input = box.querySelector('.icon_input_clss2');
    //         const previewBox = box.querySelector('.frm_img_preview');
    //         const previewImg = box.querySelector('.iconPreview_clss2');

    //         input.value = "";
    //         previewImg.src = previewImg.dataset.default || "";
    //         previewBox.style.display = "none";
    //         box.querySelector('.uploadIcon_class2').style.display = "block";
    //     }
    // });

    // // FILE CHANGE
    // document.addEventListener('change', function (e) {
    //     if (!e.target.classList.contains('icon_input_clss2')) return;

    //     const input = e.target;
    //     const box = input.closest('.iconBox_editclss2');
    //     const previewBox = box.querySelector('.frm_img_preview');
    //     const previewImg = box.querySelector('.iconPreview_clss2');

    //     const file = input.files[0];
    //     if (!file || !file.type.startsWith('image/')) {
    //         alert('Please select an image file');
    //         input.value = "";
    //         return;
    //     }

    //     const reader = new FileReader();
    //     reader.onload = function (evt) {
    //         previewImg.src = evt.target.result;
    //         previewBox.style.display = "block";
    //         box.querySelector('.uploadIcon_class2').style.display = "none";
    //     };

    //     reader.readAsDataURL(file);
    // });
    // Keep track of click locks per box
document.addEventListener('click', function(e) {
    const box = e.target.closest('.iconBox_editclss2');
    if (!box) return;

    // REMOVE ICON
    if (e.target.closest('.removeIcon_clss2')) {
        e.preventDefault();

        const input = box.querySelector('.icon_input_clss2');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.iconPreview_clss2');
        const uploadLabel = box.querySelector('.uploadIcon_class2');

        if (input) input.value = "";
        if (previewImg) previewImg.src = previewImg.dataset.default || "";
        if (previewBox) previewBox.style.display = "none";
        if (uploadLabel) uploadLabel.style.display = "block";
    }
});

// FILE CHANGE (preview)
document.addEventListener('change', function(e) {
    if (!e.target.classList.contains('icon_input_clss2')) return;

    const input = e.target;
    const box = input.closest('.iconBox_editclss2');
    const previewBox = box.querySelector('.frm_img_preview');
    const previewImg = box.querySelector('.iconPreview_clss2');
    const uploadLabel = box.querySelector('.uploadIcon_class2');

    const file = input.files[0];
    if (!file || !file.type.startsWith('image/')) {
        alert('Please select an image file');
        input.value = "";
        return;
    }

    const reader = new FileReader();
    reader.onload = function(evt) {
        previewImg.src = evt.target.result;
        previewBox.style.display = "block";
        if (uploadLabel) uploadLabel.style.display = "none";
    };
    reader.readAsDataURL(file);
});
}

document.addEventListener("DOMContentLoaded", initEditregClass);
    //////////////////////end////////////////
    /////////////for Images///////////////////////

document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.com_info_branding_wrap');
    if (!container) return;

    // Event delegation for clicks
    container.addEventListener('click', function(e) {
        const box = e.target.closest('.addBox');
        if (!box) return;

        const input = box.querySelector('.webmaster_background');
        const preview = box.querySelector('.previewImage');
    console.log('Input element found:', input); // should log input element

        // Remove button
        if (e.target.closest('.removeImage')) {
            preview.src = "images/Banner KTC BG.png";
            input.value = "";
             box.querySelector('.branding_image_upload').style.display = 'block';
             box.querySelector('.branding_image_preview').style.display = 'none';
            return;
        }

        // Upload label
       if (e.target.closest('.uploadLabel') || e.target.tagName === 'SPAN') {
    input.click();
    return;
}
    });

    // Event delegation for file input changes
   container.addEventListener('change', function(e) {
    const input = e.target;
    if (!input.classList.contains('webmaster_background')) return;

    const box = input.closest('.addBox');
    const preview = box.querySelector('.previewImage');

    if (input.files && input.files[0]) {
        const file = input.files[0];

        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            input.value = "";
            return;
        }

        const reader = new FileReader();

        reader.onload = function(evt) {
            preview.src = evt.target.result; // <- THIS sets the preview
            // console.log('Preview updated for:', file.name);
            // console.log('Ievt.target.result:', evt.target.result); // should log input element
           box.querySelector('.branding_image_upload').style.display = 'none';
           box.querySelector('.branding_image_preview').style.display = 'block';

        };

        reader.readAsDataURL(file); // <- converts File to base64
    }
});

});
/////////////////////end//////////////////////////

/////////////for Aminities Icon///////////////////////
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function (e) {

        const box = e.target.closest('.iconBox');
        if (!box) return;

        const input = box.querySelector('.icon_input');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.iconPreview');

        // Upload click
        if (e.target.closest('.uploadIcon')) {
            input.click();
            return;
        }

        // Remove icon
        if (e.target.closest('.removeIcon')) {
            input.value = "";
            previewImg.src = "";
            previewBox.style.display = "none";
            box.querySelector('.uploadIcon').style.display = "block";
            return;
        }
    });

    // File change
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('icon_input')) return;

        const input = e.target;
        const box = input.closest('.iconBox');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.iconPreview');

        const file = input.files[0];
        if (!file || !file.type.startsWith('image/')) {
            alert('Please select an image file');
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (evt) {
            previewImg.src = evt.target.result;
            previewBox.style.display = "block";
            box.querySelector('.uploadIcon').style.display = "none";
        };
        reader.readAsDataURL(file);
    });

});
////////////////end///////////////////////////////


/////////////for room images///////////////////////

document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function (e) {

        const box = e.target.closest('.roomImageBox');
        if (!box) return;

        const input = box.querySelector('.room_input');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.roomPreview');

        // Upload click
        if (e.target.closest('.uploadRoomImage')) {
            input.click();
            return;
        }

        // Remove icon
        if (e.target.closest('.removeRoomImage')) {
            input.value = "";
            previewImg.src = "";
            previewBox.style.display = "none";
            box.querySelector('.uploadRoomImage').style.display = "block";
            return;
        }
    });

    // File change
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('room_input')) return;

        const input = e.target;
        const box = input.closest('.roomImageBox');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.roomPreview');

        const file = input.files[0];
        if (!file || !file.type.startsWith('image/')) {
            alert('Please select an image file');
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (evt) {
            previewImg.src = evt.target.result;
            previewBox.style.display = "block";
            box.querySelector('.uploadRoomImage').style.display = "none";
        };
        reader.readAsDataURL(file);
    });

});
</script>
<script>
function formatDate(date) {
    return `${String(date.getDate()).padStart(2,'0')}/${
        String(date.getMonth()+1).padStart(2,'0')}/${date.getFullYear()}`;
}
function initEditHotelRoomType() {
    const addBtn = document.getElementById("edit_room_1");
    const wrapper = document.getElementById("accm_edit_wrap_3");
    const empty = document.getElementById("accm_edit_empty_3");
    const template = document.getElementById("room_box_edit");

    addBtn.addEventListener("click", function (e) {
        e.preventDefault();

        empty.style.display = "none";

        // 1️⃣ Clone template
        const clone = template.cloneNode(true);
        clone.style.display = "block";
        clone.removeAttribute("id"); // VERY IMPORTANT

        // 2️⃣ Assign a new room index
        // Only count **existing visible rooms**, not the hidden template
        const roomBoxes = wrapper.querySelectorAll('.accm_add_box_edit_room:not(#room_box_edit)');
        const newIndex = roomBoxes.length;
        clone.setAttribute("data-room-index", newIndex);

        // 3️⃣ Update input names & clear values
        clone.querySelectorAll("input, select, textarea").forEach(input => {
            if (!input.name) return;
            input.name = input.name.replace(/\[\d*\]/, `[${newIndex}]`);
            if (input.type === "text" || input.type === "number") input.value = "";
            if (input.type === "hidden") input.value = "";
            if (input.type === "file") input.value = "";
        });

        // 4️⃣ Generate seat limits for new room if dates are set
        const checkIn = document.getElementById('check_in_Edit')?.value;
        const checkOut = document.getElementById('check_out_Edit')?.value;

        const seatContainer = clone.querySelector(".seat_limits_container_room_edit");
        if (seatContainer && checkIn && checkOut) {
            const startDate = new Date(checkIn);
            const endDate = new Date(checkOut);
            let d = new Date(startDate);

            while (d < endDate) {
                seatContainer.innerHTML += `
                    <div class="form_grid span_4 seat-row">
                        <div class="frm_grp span_2">
                            <p class="frm-head">Date</p>
                            <p class="typed_data">${formatDate(d)}</p>
                        </div>
                        <div class="frm_grp span_2">
                            <p class="frm-head">Seat</p>
                            <input type="number" min="0" name="seat_limit_room[${newIndex}][]">
                        </div>
                    </div>
                `;
                d.setDate(d.getDate() + 1);
            }
        }

        // 5️⃣ Append the new room
        wrapper.appendChild(clone);
    });

    // Delete room handler
    wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            const box = e.target.closest(".accm_add_box_edit_room");
            if (box) box.remove();

            if (wrapper.querySelectorAll(".accm_add_box_edit_room:not(#room_box_edit)").length === 0) {
                empty.style.display = "block";
            }

            // Re-index remaining rooms
            ensureRoomIndexesEdit();
        }
    });
  document.addEventListener('click', function (e) {

        const box = e.target.closest('.roomImageBox_edit');
        if (!box) return;

        const input = box.querySelector('.room_input_edit');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.roomPreview_edit');

        // Upload click
        if (e.target.closest('.uploadRoomImage_edit')) {
            input.click();
            return;
        }

        // Remove icon
        if (e.target.closest('.removeRoomImage_edit')) {
            input.value = "";
            previewImg.src = "";
            previewBox.style.display = "none";
            box.querySelector('.uploadRoomImage_edit').style.display = "block";
            return;
        }
    });

    // File change
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('room_input_edit')) return;

        const input = e.target;
        const box = input.closest('.roomImageBox_edit');
        const previewBox = box.querySelector('.frm_img_preview');
        const previewImg = box.querySelector('.roomPreview_edit');
        console.log(box);
        const file = input.files[0];
        if (!file || !file.type.startsWith('image/')) {
            alert('Please select an image file');
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (evt) {
            previewImg.src = evt.target.result;
            previewBox.style.display = "block";
            box.querySelector('.uploadRoomImage_edit').style.display = "none";
        };
        reader.readAsDataURL(file);
    });

}

// initial page load
document.addEventListener("DOMContentLoaded", initEditHotelRoomType);
</script>
<script>
function initEditHotelSlider() {

            ///////For slider images/////////
    const container = document.querySelector('.com_info_branding_wrap1');

    if (!container) return;
        console.log('container element found:', container); // should log input element

    // Event delegation for clicks
    container.addEventListener('click', function(e) {
        const box = e.target.closest('.editBox');

        if (!box) return;

        const input = box.querySelector('.webmaster_background');
        const preview = box.querySelector('.editpreviewImage');
        console.log('Input element found:', input); // should log input element

        // Remove button
    //    if (e.target.closest('.editremoveImage')) {
    //        preview.src = "images/Banner KTC BG.png";
    //        input.value = "";
    //        box.querySelector('.branding_image_upload').style.display = 'block';
    //        box.querySelector('.branding_image_preview').style.display = 'none';
    //     return;
    //     }
        if (e.target.closest('.editremoveImage')) {

            preview.src = "images/Banner KTC BG.png";
            input.value = "";

            // 🔥 CLEAR HIDDEN FIELDS (CRITICAL)
            const existIcon = box.querySelector('input[name="slider_exist_icon[]"]');
            const sliderId  = box.querySelector('input[name="slider_id[]"]');

            if (existIcon) existIcon.value = '';
            if (sliderId)  sliderId.value = '';

            box.querySelector('.branding_image_upload').style.display = 'block';
            box.querySelector('.branding_image_preview').style.display = 'none';

            return;
        }
        // Upload label
    if (e.target.closest('.edituploadLabel') || e.target.tagName === 'SPAN') {
    input.click();
    return;
    }
    });

        // Event delegation for file input changes
    container.addEventListener('change', function(e) {
        const input = e.target;
        if (!input.classList.contains('webmaster_background')) return;

        const box = input.closest('.editBox');
        const preview = box.querySelector('.editpreviewImage');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                input.value = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(evt) {
                preview.src = evt.target.result; // <- THIS sets the preview
                // console.log('Preview updated for:', file.name);
                // console.log('Ievt.target.result:', evt.target.result); // should log input element
            box.querySelector('.branding_image_upload').style.display = 'none';
            box.querySelector('.branding_image_preview').style.display = 'block';

            };

            reader.readAsDataURL(file); // <- converts File to base64
        }
    });
}
// initial page load
document.addEventListener("DOMContentLoaded", initEditHotelSlider);
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const addBtn = document.getElementById("add_accompany_1");
    const wrapper = document.getElementById("accm_add_wrap_5");
    const empty = document.getElementById("accm_add_empty5");
    const template = document.getElementById("package_box5");

    let accompanyIndex = 0; // keep track of the index

   addBtn.addEventListener("click", function (e) {
    e.preventDefault();
    empty.style.display = "none";

    const clone = template.cloneNode(true);
    clone.style.display = "block";
    clone.removeAttribute("id"); // prevent duplicate IDs

    accompanyIndex++;

    // Update all inputs in the cloned box
    clone.querySelectorAll("input").forEach(input => {
        // Update name indexes
            if (input.name.includes("[0]")) {
                input.name = input.name.replace("[0]", `[${accompanyIndex}]`);
            }

            // Ensure onkeyup triggers tariff calculation
            if (input.hasAttribute("onkeyup")) {
                input.setAttribute("onkeyup", "calculateRegistrationTariff(this)");
            }

            // Clear the text input value for new box
            if (input.type === "text") {
                input.value = ""; // make blank
            }

            // Uncheck radio buttons and hidden checkboxes
            if (input.type === "checkbox" || input.type === "radio") {
                input.checked = false;
            }

            // Update IDs if needed
            if (input.id) {
                input.id = input.id + "_" + accompanyIndex;
            }
             // Increment value for the hidden accompany_selected_add input
            if (input.name.includes("accompany_selected_add")) {
                input.value = accompanyIndex; // 0, 1, 2, 3...
            }
        });

        // Append the new box
        wrapper.appendChild(clone);
    });

   wrapper.addEventListener("click", function (e) {
        if (e.target.closest(".accm_delet")) {
            e.preventDefault();
            const boxToRemove = e.target.closest(".accm_add_box");
            if (boxToRemove) boxToRemove.remove();

            if (wrapper.querySelectorAll(".accm_add_box").length === 1) {
                empty.style.display = "block";
            }

            // ✅ Recalculate total after deletion
            calculateRegistrationTariff();
        }
    });

});

$(document).ready(function() {
    $("input[operationMode=discountAmount]").keyup(function() {
        //alert(serviceType);
            calculateRegistrationTariff();
    });
    // When the toggle changes
    $('#selectAllWorkshops').click(function(e) {
        e.preventDefault(); // prevent page jump

        // Check all workshop checkboxes
        $("input[type=checkbox][operationMode='workshopId']").prop('checked', true);

        // Optional: trigger change if you have event listeners
        $("input[type=checkbox][operationMode='workshopId']").trigger('change');
    });
    $('#workshopToggle').change(function() {
        var regClsfId = '8'; // only workshop id

        if ($(this).is(':checked')) {
            $('#registration_request').val('ONLYWORKSHOP');
              $('.noWorkshop').hide();

            // Loop over each label
            $(".work_category .cus_check").each(function() {
                if ($(this).attr("use") == regClsfId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Show all work_category divs that have visible labels
            $("..work_category .cus_check").each(function() {
                if ($(this).find(".cus_check:visible").length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Check hidden backend inputs
            $("input[spUse='regClsId']").prop('checked', true).attr('chkstat', 'true');
            $("#workshop_id").prop('checked', true);
        } else {
                $('.noWorkshop').show();
            $('#registration_request').val('GENERAL');

            // Show all categories and all workshops
            $(".work_category .cus_check").hide();

            // Uncheck hidden backend inputs
            $("input[spUse='regClsId']").prop('checked', false).attr('chkstat', 'false');
            $("#workshop_id").prop('checked', false);
        }
    });
});
$(document).ready(function() {
    // When a payment radio is clicked
    $("input[type=radio][name=payment_mode]").click(function() {
        var val = $(this).val(); // Get selected payment value

        // Set registrationMode based on ONLINE/OFFLINE
        if (val === 'Card') {
            $('#registrationMode').val('OFFLINE');
        } else {
            $('#registrationMode').val('OFFLINE');
        }

        // Optional: Handle special case for UPI
        if (val === 'Upi') {
            $('.for-upi-only').show();
            $('.for-neft-rtgs-only').hide();
            $('#neft_transaction_no').removeClass('mandatory').val('');

        } else {
            $('.for-upi-only').hide();
            $('.for-neft-rtgs-only').show();
            $('#neft_transaction_no').addClass('mandatory');

        }
    });

    // Trigger click on page load if you want default selection
   var neftRadio = $("input[type=radio][name=payment_mode][value='Neft']");
    if(neftRadio.length) {
        neftRadio.trigger('click');
    }
      $('#neft_document').on('change', function() {

      var file = this.files[0];
      if (file) {

        $('#neft_file_name').html(file['name']);
      } else {
        $('#neft_file_name').html('');
      }
    })

    $('#cash_document').on('change', function() {
      
      var file = this.files[0];

      if (file) {
        $('#cash_file_name').html(file['name']);
      } else {
        $('#cash_file_name').html('');
      }
    })

});
///////////
$(document).on('click', '.showPaymentDiv', function(e) {
    e.preventDefault();

    let slipId = $(this).data('tab');
    let targetDiv = $('#paymentDiv_' + slipId);

    if (!targetDiv.length) {
        console.error('Payment div not found for slipId:', slipId);
        return;
    }

    if (targetDiv.is(':visible')) {
        // If already open → close it
        targetDiv.slideUp(300);
    } else {
        // Close all others first
        $('.paymentDiv').slideUp(300);

        // Open clicked one
        targetDiv.slideDown(300);
    }
});
/////////////////////////
function updateBillSummary() {
   

	

	//alert(amt);
}
//////////////////////
function initEditregistration() {
    
    let accompanyIndex = Date.now();

    $(document).on("click", '.add_accompany', function (e) {

        e.preventDefault();

        let $form = $(this).closest(".registration-form");

        let $lastName = $form.find(".accompany_box:last")
            .find("input[name^='accompany_name_add']");

        if ($lastName.val().trim() === '') {
            alert("Please enter accompany name first");
            $lastName.focus();
            return;
        }

        accompanyIndex++;

        let $clone = $form.find(".accompany_box:first").clone();

        // Hidden field
        $clone.find("input[name^='accompany_selected_add']")
            .attr('name', 'accompany_selected_add[' + accompanyIndex + ']')
            .val(accompanyIndex)
            .attr('data-existing', '0');

        // Name
        $clone.find("input[name^='accompany_name_add']")
            .attr('name', 'accompany_name_add[' + accompanyIndex + ']')
            .val('');

        // Food
        $clone.find("input[name^='accompany_food_choice']").each(function () {
            $(this)
                .attr('name', 'accompany_food_choice[' + accompanyIndex + ']')
                .prop('checked', $(this).val() === 'VEG');
        });
        let deleteBtn = `
            <div class="frm_grp span_4">
                <a href="javascript:void(0)"
                class="accm_delet icon_hover badge_danger action-transparent rmv_accompany">
                <i class='fal fa-trash-alt'></i>
                </a>
            </div>
        `;

        // Append delete button inside clone
        $clone.append(deleteBtn);

        $form.find(".accompany_box:last").after($clone);

        updateBillSummary($form);
    });


    /* ==============================
        REMOVE ACCOMPANY
    ============================== */
    $(document).on("click", ".rmv_accompany", function (e) {
        e.preventDefault();

        let $form = $(this).closest(".registration-form");

        if ($form.find(".accompany_box").length === 1) return;

        $(this).closest(".accompany_box").remove();

        // AUTO RENUMBER
        $form.find(".accompany_box").each(function (i) {

            let index = i + 1;

            $(this).find("input[name^='accompany_selected_add']")
                .val(index);

            $(this).find("input[name^='accompany_name_add']")
                .attr('name', 'accompany_name_add[' + index + ']')
                .attr('id', 'accompany_name_add_' + index);

            $(this).find("input[name^='accompany_food_choice']").each(function () {
                $(this).attr('name', 'accompany_food_choice[' + index + ']');
            });
        });

        updateBillSummary($form);
    });

    $(document).on("input", "input[name^='accompany_name_add']", function () {
        let $form = $(this).closest(".registration-form");
        updateBillSummary($form);
    });
    $('.hotel_check').click(function() {
        var tabId = $(this).attr('data-tab');
        $(".hotel_box").hide();
        $(".hotel_check").removeClass("active");
        $('#' + tabId).toggle();
        $(this).toggleClass('active');
    });
          $('.hotel_link_owl').owlCarousel({
        loop: false,
        margin: 6,
        autoWidth: true,
        items: 3,
        dots: false,
        dotsData: false,
        nav: false,
        navText: [
            '<i class="fal fa-angle-left"></i>',
            '<i class="fal fa-angle-right"></i>'
        ],
        mouseDrag: true,
 
    });
    $('.pay_check[data-tab]').click(function() {
        var tabId = $(this).attr('data-tab');
        $(".payment_details").hide();
        $('#' + tabId).show();
    });
    
 $(document).ready(function() {
     $('.spot_box_bottom_right_edit .drp').click(function(e) {
        e.preventDefault(); // prevent default anchor behavior

        var $this = $(this);
        var $table = $this.closest('.accm_bottom').next('.accm_tariff');
       
        if ($this.hasClass("active")) {
             console.log($table);
            $table.slideUp();
            $this.removeClass("active");
        } else {
            // Close all other tables
            $('.spot_service_break').slideUp();
            $('.spot_box_bottom_right_edit .drp').removeClass("active");
            // Open only this table
            $table.slideDown();
            $this.addClass("active");
        }
    });
    // When a payment radio is clicked
    var disableMode = $('#disableMode').val();
    var lockedValue = $('#paymode').val();

    // Always set the locked radio
    $('input[name="payment_mode"]').each(function(){
        $(this).prop('checked', $(this).val() === lockedValue);
    });

    if(disableMode === 'yes') {
         $('fieldset.disableAtt')
            .find('input, select, textarea')
            .not('.payment-status-radio input') // the three radios
            .not('#actInput')                  // hidden act field
            .prop('disabled', true);

            // Optional: visually grey out disabled fields
        $('fieldset.disableAtt')
        .find('input:disabled, select:disabled, textarea:disabled')
        .css('opacity', 0.6);
        // Disable labels so user cannot change
        $('.cus_check.pay_check_mode').css('pointer-events', 'none');

        // Show the corresponding div (UPI/NEFT/Cash) for locked value
        if(lockedValue === 'Upi'){
            $('.for-upi-only').show();
            $('.for-neft-rtgs-only').hide();
            $('#neft_transaction_no').removeClass('mandatory').val('');
        } else if(lockedValue === 'Neft'){
            $('.for-upi-only').hide();
            $('.for-neft-rtgs-only').show();
            $('#neft_transaction_no').addClass('mandatory');
        } else {
            $('.for-upi-only, .for-neft-rtgs-only').hide();
        }
    } else {
        // Enable labels if disable = no
        $('.cus_check.pay_check_mode').css('pointer-events', '');
        $('fieldset.disableAtt')
        .find(':disabled')
        .prop('disabled', false);
    }
    $("input[type=radio][name=payment_mode]").click(function() {
        var val = $(this).val(); // Get selected payment value
     
        // Set registrationMode based on ONLINE/OFFLINE
        if (val === 'Card') {
            $('#registrationMode').val('OFFLINE');
        } else {
            $('#registrationMode').val('OFFLINE');
        }

        // Optional: Handle special case for UPI
        if (val === 'Upi') {
            $('.for-upi-only').show();
            $('.for-neft-rtgs-only').hide();
            $('#neft_transaction_no').removeClass('mandatory').val('');

        } else {
            $('.for-upi-only').hide();
            $('.for-neft-rtgs-only').show();
            $('#neft_transaction_no').addClass('mandatory');

        }
    });
    $("input[name='payment_mode']:checked").each(function() {
        $(this).trigger('click'); // This will show the correct payment details div
    });
    // Trigger click on page load if you want default selection
//    var neftRadio = $("input[type=radio][name=payment_mode][value='Neft']");
//     if(neftRadio.length) {
//         neftRadio.trigger('click');
//     }
      $('#neft_document').on('change', function() {

      var file = this.files[0];
      if (file) {

        $('#neft_file_name').html(file['name']);
      } else {
        $('#neft_file_name').html('');
      }
    })

    $('#cash_document').on('change', function() {
      
      var file = this.files[0];

      if (file) {
        $('#cash_file_name').html(file['name']);
      } else {
        $('#cash_file_name').html('');
      }
    })

});
// $(document).ready(function(){
//   const $discountInput = $('#discountInput');
//     const $paymentInput = $('input[operationMode="amount"]');

//     const $totalSpan = $('#totalAmount');
//     const $balanceSpan = $('#balanceDue');

//     // Parse currency strings like "₹ 12,980" to numbers
//     function parseCurrency(str){
//         return parseFloat(str.replace(/[^0-9.-]+/g,"")) || 0;
//     }

//     // Store original values
//     let originalTotal = parseCurrency($totalSpan.text());
//     let originalBalance = parseCurrency($balanceSpan.text());

//     function updateTotals() {
//         let discount = parseFloat($discountInput.val()) || 0;
//         let payment = parseFloat($paymentInput.val()) || 0;

//         let newTotal = Math.max(0, originalTotal - discount);
//         let newBalance = Math.max(0, originalBalance - discount - payment);

//         $totalSpan.text('₹ ' + newTotal.toFixed(2));
//         $balanceSpan.text('₹ ' + newBalance.toFixed(2));
//     }

//     // Trigger on input
//     $discountInput.on('input', updateTotals);
//     $paymentInput.on('input', updateTotals);

//     // Initialize totals on page load
//     updateTotals();

// });
$(document).ready(function(){
    const $discountInput = $('#discountInput');
    const $paymentInput = $('input[operationMode="amount"]');

    const $totalSpan = $('#totalAmount');
    const $balanceSpan = $('#balanceDue');

    // Parse currency strings like "₹ 12,980" to numbers
    function parseCurrency(str){
        return parseFloat(str.replace(/[^0-9.-]+/g,"")) || 0;
    }

    // Store original values
    let originalTotal = parseCurrency($totalSpan.text());
    let originalBalance = parseCurrency($balanceSpan.text());

    function updateTotals() {
        let discount = parseFloat($discountInput.val()) || 0;
        let payment = parseFloat($paymentInput.val()) || 0;

        let newTotal = Math.max(0, originalTotal - discount);
        let newBalance = Math.max(0, originalBalance - discount - payment);

        $totalSpan.text('₹ ' + newTotal.toFixed(2));
        $balanceSpan.text('₹ ' + newBalance.toFixed(2));

        // Validate payment does not exceed balance
        if(payment > originalBalance - discount){
            alert(`Payment cannot be greater than ₹${(originalBalance - discount).toFixed(2)}`);
            $paymentInput.val('');
            updateTotals(); // recalc after clearing
        }
    }

    // Trigger on input
    $discountInput.on('input', updateTotals);
    $paymentInput.on('input', updateTotals);

    // Initialize totals on page load
    updateTotals();
});
$(document).ready(function () {

    // 1️⃣ Disable clicking on registration modes
    $('.registration_cutoff').css('pointer-events', 'none');

    // 2️⃣ Hide all category sections
    $('.regi_category').hide();

    // 3️⃣ Open only the selected tab's category
    var selected = $('.registration_cutoff input[type="radio"]:checked');

    if (selected.length > 0) {
        var tabId = selected.closest('.registration_cutoff').data('tab');
        $('#' + tabId).css('display', 'block');
    }

});

}
document.addEventListener("DOMContentLoaded", initEditregistration);
// function amountValidation(input) {
//     // Get entered amount
//     const enteredAmount = parseFloat(input.value);

//     // Get balance due (remove ₹ and commas)
//     const balanceText = document.getElementById('balanceDue').textContent;
//     const balanceAmount = parseFloat(balanceText.replace(/[₹, ]/g, ''));

//     // If entered amount is greater than balance
//     if (!isNaN(enteredAmount) && enteredAmount > balanceAmount) {
//         alert(`Amount cannot be greater than ₹${balanceAmount}`);
//         input.value = ''; // Clear the input
//     }
// }
</script>

