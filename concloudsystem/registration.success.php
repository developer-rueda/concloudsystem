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
include_once("includes/source.php");
$sql1 = array();
$sql1['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
                WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]  = array('FILD' => 'status' ,         'DATA' => 'A' ,                   'TYP' => 's');          
$result = $mycms->sql_select($sql1);
$row    = $result[0];

$header_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $row['header_image'];
if ($row['header_image'] != '') {
  $emailHeader  = $header_image;
}
  $sqlLogo = array();
  $sqlLogo['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
      WHERE status = 'A'
     AND title = 'Registration Processing Image'

      ORDER BY id DESC";

  $resultLogo = $mycms->sql_select($sqlLogo);
  $rowLogo    = $resultLogo[0];
  if($rowLogo['title']=='Registration Processing Image'){
   $process_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $rowLogo['image'];
  }
  ///////////////
   $sqlLogosucc = array();
  $sqlLogosucc['QUERY'] = "SELECT * FROM " . _DB_LANDING_FLYER_IMAGE_ . " 
      WHERE status = 'A'
     AND title = 'Registration Online Success Image'

      ORDER BY id DESC";

  $resultLogosucc = $mycms->sql_select($sqlLogosucc);
  $rowLogosucc    = $resultLogosucc[0];
  if($rowLogosucc['title']=='Registration Online Success Image'){
   $success_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $rowLogosucc['image'];
  }
  ////////////////
$userEmailId  = $_REQUEST['email'];
$userId     = base64_decode($userEmailId);

$delegateId   = $mycms->decoded($_REQUEST['did']);


$sqlInvoice   = array();
$sqlInvoice['QUERY']   = "SELECT *                        
                  FROM " . _DB_INVOICE_ . " 
                   WHERE slip_id =?
                   AND status = ?";

$sqlInvoice['PARAM'][]  = array('FILD' => 'slip_id', 'DATA' => $mycms->getSession('TEMP_SLIP_ID'),  'TYP' => 's');
$sqlInvoice['PARAM'][]  = array('FILD' => 'status',  'DATA' => 'A',                                 'TYP' => 's');

$resultInvoice = $mycms->sql_select($sqlInvoice);
// echo "<pre>"; print_r($resultInvoice);
$totalRoundPrc = 0;
$paymentStatus = '';

foreach ($resultInvoice as $key => $rowInvoice) {

  //echo '<pre>'; print_r($rowInvoice);

  $serviceType = $rowInvoice['service_type'];
  $invoice_mode = $rowInvoice['invoice_mode'];
  $totalRoundPrc += $rowInvoice['service_roundoff_price'];
  $paymentStatus = $rowInvoice['payment_status'];
  $delegateId = $rowInvoice['delegate_id'];
}

$userDetails  = getUserDetails($delegateId);

// echo "<pre>"; print_r($userDetails);

$resPaymentDetails      = paymentDetails($mycms->getSession('TEMP_SLIP_ID'));

$paymentMode = '';
foreach ($resPaymentDetails['paymentDetails'] as $key => $rowPayment) {
  //echo '<pre>';print_r($rowPayment);

  $paymentMode = $rowPayment['payment_mode'];
  $paymentModeDisplay = $rowPayment['payment_mode'] == 'NEFT' ? 'NEFT/UPI' : ($rowPayment['payment_mode'] == 'Cheque' ? 'Cheque/DD' : $rowPayment['payment_mode']);

  if ($rowPayment['payment_mode'] == "Cash") {
    $paymentDescription = "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                           Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                           Date of Deposit: <b>" . setDateTimeFormat2($rowPayment['cash_deposit_date'], "D") . "</b>.";
  }
  if ($rowPayment['payment_mode'] == "Online") {
    $paymentDescription = "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                           Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                           Date of Payment: <b>" . setDateTimeFormat2($rowPayment['payment_date'], "D") . "</b>.<br>
                           Transaction Number: <b>" . $rowPayment['atom_atom_transaction_id'] . "</b>.<br>
                           Bank Transaction Number: <b>" . $rowPayment['atom_bank_transaction_id'] . "</b>.";
  }
  if ($rowPayment['payment_mode'] == "Card") {
    $paymentDescription = 
                      "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                      Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                      Reference Number: <b>" . $rowPayment['card_transaction_no'] . "</b>.<br>
                      Date of Payment: <b>" . setDateTimeFormat2($rowPayment['card_payment_date'], "D") . "</b>.
                      Remarks: <b>" . $rowPayment['payment_remark'] . "</b> ";
  }
  if ($rowPayment['payment_mode'] == "Draft") {
    $paymentDescription = 
                      " Amount: <b>" .$totalRoundPrc. "</b>.<br>
                       Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                       Draft Number: <b>" . $rowPayment['draft_number'] . "</b>.<br>
                       Draft Date: <b>" . setDateTimeFormat2($rowPayment['draft_date'], "D") . "</b>.
                       Draft Drawee Bank: <b>" . $rowPayment['draft_bank_name'] . "</b>.";
  }
  if ($rowPayment['payment_mode'] == "NEFT") {
    $paymentDescription = 
                       
                       "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                       Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                       Transaction Number: <b>" . $rowPayment['neft_transaction_no'] . "</b>.<br>
                       Transaction Date: <b>" . setDateTimeFormat2($rowPayment['neft_date'], "D") . "</b>.<br>
                       Transaction Bank: <b>" . $rowPayment['neft_bank_name'] . "</b>.";
  }
  if ($rowPayment['payment_mode'] == "RTGS") {
    $paymentDescription = 
                      "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                       Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                       RTGS Transaction Number: <b>" . $rowPayment['rtgs_transaction_no'] . "</b>.<br>
                       Transaction Date: <b>" . setDateTimeFormat2($rowPayment['rtgs_date'], "D") . "</b>.<br>
                       Transaction Bank: <b>" . $rowPayment['rtgs_bank_name'] . "</b>.";
  }
  if ($rowPayment['payment_mode'] == "Cheque") {
    $paymentDescription = 
                       "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                        Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                        Cheque/DD Number: <b>" . $rowPayment['cheque_number'] . "</b>.<br>
                        Date: <b>" . setDateTimeFormat2($rowPayment['cheque_date'], "D") . "</b>.
                        Drawee Bank: <b>" . $rowPayment['cheque_bank_name'] . "</b>.";
  }
  if ($rowPayment['payment_mode'] == "UPI") { //echo '3';
    $paymentDescription = 
                      "Amount: <b>" .$totalRoundPrc. "</b>.<br>
                       Mode of Payment: <b>" . $paymentModeDisplay. "</b>.<br>
                       UPI Number: <b>" . $rowPayment['txn_no'] . "</b>.<br>
                       UPI Date: <b>" . setDateTimeFormat2($rowPayment['upi_date'], "D") . "</b>";
  }
}

//echo $delegateId;

// $loginDetails    = login_session_control();

$find = ['[USER]', '[AMOUNT]', '[PAYMENT_MODE]', '[PAYPENT_DESCRIPTION]'];

$replacement = [$userDetails['user_full_name'], $totalRoundPrc, $paymentModeDisplay, $paymentDescription];


$result = str_replace($find, $replacement, $cfg['PROCESS_PAGE_INFO']);
?>

<!DOCTYPE html>
<html>

<?php
setTemplateStyleSheet();
setTemplateBasicJS();
backButtonOffJS();




include_once("header.php");

?>
<script language="javascript">
  // Disable context menu (right-click)
  document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
  });

  // Function to handle back button
  function preventBack() {
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function(event) {
      history.pushState(null, null, location.href);
    });
  }

  // Execute the function
  preventBack();
</script>
<!-- <body>
    <div class="registration_wrap">
        <div class="registration_inner">
            <div class="regi_noti_left">
                <img src="<?= _BASE_URL_ ?>images/susses.png" alt="" />
                 <?php
                  if (!empty($paymentStatus) && $paymentStatus == 'UNPAID') {
                  ?>
                    <h2>Registration Processing!</h2>
                  <?php
                  } else {
                  ?>
                    <h2>Registration Successful!</h2>
                  <?php
                  }
                  ?>
            </div>
              <?php
        if (!empty($paymentStatus) && $paymentStatus == 'UNPAID') {
        ?>
           <div class="regi_noti_right">
               <div class="regi_noti_right_top">
                    <?php echo str_replace($find, $replacement, $cfg['PROCESS_PAGE_INFO']); ?>
                </div>
                <div class="regi_noti_right_bottom">
                    <a href="<?= _BASE_URL_ ?>downloadSlippdf.php?delegateId=<?= $mycms->encoded($resultInvoice[0]['delegate_id']) ?>&slipId=<?= $mycms->encoded($resultInvoice[0]['slip_id']) ?>" class="note-btns" target="blank"><i class="fal fa-download"></i>Payment Voucher</a>
                     <?php if($mycms->getSession('ABSTRACT_LOGGEDIN')=='YES' || $mycms->getSession('LOGGED.USER.ID')==$resultInvoice[0]['delegate_id']) { ?>
                      <a href="profile.php" class="note-btns" target="blank"><?php view() ?>Profile</a>
                      <?php } else { ?>
                      <a href="<?= $cfg['SITE_LINK'] ?>" class="note-btns" target="blank"><?php view() ?>Visit Website</a>
                      <?php } ?>
                </div>
            </div>
        </div>
        <?php
        } else {
        ?>
           <div class="regi_noti_right">
                <div class="regi_noti_right_top">
                    <?php echo str_replace($find, $replacement, $cfg['PROCESS_PAGE_INFO']); ?>
                </div>
                <div class="regi_noti_right_bottom">
                    <a href="<?= _BASE_URL_ ?>downloadSlippdf.php?delegateId=<?= $mycms->encoded($resultInvoice[0]['delegate_id']) ?>&slipId=<?= $mycms->encoded($resultInvoice[0]['slip_id']) ?>" class="note-btns" target="blank"><i class="fal fa-download"></i>Payment Voucher</a>
                     <?php if($mycms->getSession('ABSTRACT_LOGGEDIN')=='YES' || $mycms->getSession('LOGGED.USER.ID')!='') { ?>
                      <a href="profile.php" class="note-btns" target="blank"><?php view() ?>Profile</a>
                      <?php } else { ?>
                      <a href="<?= $cfg['SITE_LINK'] ?>" class="note-btns" target="blank"><?php view() ?>Visit Website</a>
                      <?php } ?>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
           
    </div>
</body> -->
<body class="success_page">
  <?php
    if (!empty($paymentStatus) && $paymentStatus == 'UNPAID') {
    ?>
    <div class="success_page_inner pending">
        <img src="images/regifail.png" alt="" class="success_page_bk">
        <div class="success_page_box">
            <img src="<?=$process_image?>" alt="">
            <h3>Registration Pending...</h3>
            <p><?php echo str_replace($find, $replacement, $cfg['PROCESS_PAGE_INFO']); ?></p>
            <div class="success_btn_class">
              <?php if($mycms->getSession('ABSTRACT_LOGGEDIN')=='YES' || $mycms->getSession('LOGGED.USER.ID')==$resultInvoice[0]['delegate_id']) { ?>
              <a href="<?= _BASE_URL_ ?>downloadSlippdf.php?delegateId=<?= $mycms->encoded($resultInvoice[0]['delegate_id']) ?>&slipId=<?= $mycms->encoded($resultInvoice[0]['slip_id']) ?>"  target="blank" >Payment Voucher<i class="fal fa-download"></i></a>
              <?php
              } else { ?>
                <a href="<?= $cfg['SITE_LINK'] ?>" class="note-btns" target="blank"><?php view() ?>Visit Website</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    }else{
    ?>
    <div class="success_page_inner success">
        <img src="images/regifail.png" alt="" class="success_page_bk">
        <div class="success_page_box">
            <img src="<?=$success_image?>" alt="">
            <h3>Registration Successfull</h3>
            <p><?php echo str_replace($find, $replacement, $cfg['PROCESS_PAGE_INFO']); ?> </p>
             <div class="success_btn_class">
               <a href="profile.php" class="note-btns" target="blank" >Visit Profile<?php view() ?></a>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="success_page_inner fail d-none">
        <img src="images/regifail.png" alt="" class="success_page_bk">
        <div class="success_page_box">
            <img src="images/regifail.png" alt="">
            <h3>Registration Failed!</h3>
            <p>Lorem IsumLorem IsumLorem IsumLorem IsumLorem IsumLorem </p>
            <a href="#">Retry Payment<?php reseti() ?></a>
        </div>
    </div>
    <div class="registration_wrap d-none">
        <div class="registration_inner">
            <div class="regi_noti_left">
                <img src="" alt="">
                <h2>Registartion Processing</h2>
            </div>
            <div class="regi_noti_right">
                <div class="regi_noti_right_top">
                    <h4>Dr Name</h4>
                    <h6>Transaction Pending</h6>
                    <p>Your Data</p>
                    <p>You Have Slected</p>
                </div>
                <div class="regi_noti_right_bottom">
                    <a href=""><i class="fal fa-download"></i>Payment Voucher</a>
                    <a href=""><?php view() ?>Profile</a>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include_once("includes/js-source.php"); ?>

</html>
<?php


?>