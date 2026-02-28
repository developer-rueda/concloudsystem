<?php
include_once("includes/frontend.init.php");
include_once("includes/function.registration.php");
include_once("includes/function.delegate.php");
include_once("includes/function.invoice.php");
include_once("includes/function.workshop.php");
include_once("includes/function.dinner.php");
include_once("includes/function.accompany.php");
?>
<!DOCTYPE html>
<html lang="en">

<?php
setTemplateStyleSheet();
setTemplateBasicJS();
backButtonOffJS();
include_once('header.php');

global $cfg;
?>

<?php
$loginDetails 	 = login_session_control();
$delegateId 	 = $loginDetails['DELEGATE_ID'];

$operate 		 = false;

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


$sqlHeader 	=	array();
$sqlHeader['QUERY'] = "SELECT * FROM " . _DB_EMAIL_SETTING_ . " 
											WHERE `status`='A' order by id desc limit 1";
//$sql['PARAM'][]	=	array('FILD' => 'status' ,     		 'DATA' => 'A' ,       	           'TYP' => 's');					 
$resultHeader = $mycms->sql_select($sqlHeader);
$rowHeader    		 = $resultHeader[0];

$header_image = _BASE_URL_ . $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $rowHeader['logo_image'];
if ($rowHeader['logo_image'] != '') {
	$emailHeader  = $header_image;
}

//to get abstract file types
$sqlInfo  = array();
$sqlInfo['QUERY']    = "SELECT * FROM " . _DB_COMPANY_INFORMATION_ . " 
             WHERE `status` = ?";
$sqlInfo['PARAM'][] = array('FILD' => 'status',         'DATA' => 'A',                   'TYP' => 's');
$resultInfo      = $mycms->sql_select($sqlInfo);
$rowInfo         = $resultInfo[0];
$hod_consent_file_types = $rowInfo['hod_consent_file_types']; //JSON array
$abstract_file_types = $rowInfo['abstract_file_types'];
$hod_consent_file_types_decoded = json_decode($rowInfo['hod_consent_file_types']);




$operate			  = true;
$resultAbstractType	  = false;
if ($delegateId != '') {
	$title1 = $mycms->getSession('USER_DETAILS_FRONT');
	$title = $title1['TITLE'];
	$rowUserDetails   = getUserDetails($delegateId);

	$sql  			  = array();
	$sql['QUERY']     = " SELECT * 
								FROM " . _DB_ABSTRACT_REQUEST_ . " 
							   WHERE `status` = ?
								 AND `applicant_id` = ? AND id = ?";
	//AND `abstract_child_type` IN ('Oral','Poster')

	$sql['PARAM'][]   = array('FILD' => 'status',         'DATA' => 'A',          'TYP' => 's');
	$sql['PARAM'][]   = array('FILD' => 'applicant_id',   'DATA' => $delegateId ? $delegateId : trim($_GET['user_id']), 'TYP' => 's');
	$sql['PARAM'][]   = array('FILD' => 'id',   'DATA' => trim($_GET['abstract_id']), 'TYP' => 's');
	$resultAbstractType = $mycms->sql_select($sql);

	//echo '<pre>'; print_r($resultAbstractType);





	if ($resultAbstractType[0]['abstract_author_email_id'] != "") {
		$author_email = $resultAbstractType[0]['abstract_author_email_id'];
		$author_fname = $resultAbstractType[0]['abstract_author_first_name'];
		$author_lname = $resultAbstractType[0]['abstract_author_last_name'];
		$author_title = $resultAbstractType[0]['abstract_author_title'];
		$author_countryId = $resultAbstractType[0]['abstract_author_country_id'];
		$author_stateId = $resultAbstractType[0]['abstract_author_state_id'];
		$author_city = $resultAbstractType[0]['abstract_author_city'];
		$author_pin = $resultAbstractType[0]['abstract_author_pin'];
		$author_mobile = $resultAbstractType[0]['abstract_author_phone_no'];
		$abstract_author_department = $resultAbstractType[0]['abstract_author_department'];
		$abstract_author_institute_name = $resultAbstractType[0]['abstract_author_institute_name'];
	} else {
		$author_email = $rowUserDetails['user_email_id'];
		$author_fname = $rowUserDetails['user_first_name'];
		$author_lname = $rowUserDetails['user_last_name'];
		$author_title = $rowUserDetails['user_title'];
		$author_countryId = $rowUserDetails['user_country_id'];
		$author_stateId = $rowUserDetails['user_state_id'];
		$author_city = $rowUserDetails['user_city'];
		$author_pin = $rowUserDetails['user_pincode'];
		$author_mobile = $rowUserDetails['user_mobile_no'];
		$abstract_author_department = $rowUserDetails['user_department'];
		$abstract_author_institute_name = $rowUserDetails['user_institute_name'];
	}

	//echo '<pre>'; print_r($resultAbstractType);

}

$sqlAbstractTopic			  =	array();
$sqlAbstractTopic['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_TOPIC_CATEGORY_ . " 
																  WHERE `status` IN ('A')
															   ORDER BY `category` ASC";

$resultAbstractTopic = $mycms->sql_select($sqlAbstractTopic);

$sqlAbstractSubmission			  =	array();
$sqlAbstractSubmission['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_SUBMISSION_ . " 
									  WHERE `status` IN ('A') 
								   ORDER BY `category` ASC";


$resultAbstractSubmission = $mycms->sql_select($sqlAbstractSubmission);



?>

<body class="no-bg cart-sade-bar">
	<style>
		.blur_bw {
			filter: blur(1.5px) grayscale(1);
			pointer-events: none;
		}
	</style>


	<main>

		<!-- <div class="cart">
      <img src="<?= _BASE_URL_ ?>images/cart.png" alt="" />
    </div> -->
		<form name="abstractRequestForm" id="abstractRequestForm" action="<?= _BASE_URL_ ?>abstract_request.process.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="act" value="abstractUpdate" />
			<input type="hidden" name="applicantId" id="applicantId" value="<?= $delegateId ?>" />
			<input type="hidden" name="report_data" id="report_data" value="Abstract" />
			<input type="hidden" name="abstract_id" value="<?= $_REQUEST['abstract_id'] ?>">



			<section class="dashbord-main">
				<div class="custom-dashbord-inner">
					<!-- <div class="left-menu open">
						<ul>
							<li><a href="<?= _BASE_URL_ ?>profile.php"><img src="<?= _BASE_URL_ ?>images/home.png" alt="" /></a></li>
							<li><a href="<?= _BASE_URL_ ?>profile.php"><img src="<?= _BASE_URL_ ?>images/cat-ic-1.png" alt="" /></a></li>
							<li><a href="<?= _BASE_URL_ . "profile-add.php?section=3" ?>"><img src="<?= _BASE_URL_ ?>images/cat-ic-2.png" alt="" /></a></li>
							<li><a href="<?= _BASE_URL_ . "profile-add.php?section=4" ?>"><img src="<?= _BASE_URL_ ?>images/cat-ic-3.png" alt="" /></a></li>

							<li><a href="<?= _BASE_URL_ . "profile-add.php?section=5" ?>"><img src="<?= _BASE_URL_ ?>images/cat-ic-5.png" alt="" /></a></li>
							<li><a href="<?= _BASE_URL_ . "profile-add.php?section=6" ?>"><img src="<?= _BASE_URL_ ?>images/cat-ic-6.png" alt="" /></a></li>

							<li>
								<a href="<?= _BASE_URL_ ?>login.process.php?action=logout" class="btn logout" style="margin-top: 12px;"><img src="<?= _BASE_URL_ ?>images/log-out.png">
								</a>
							</li>
						</ul>
					</div> -->

					<?php $sql   =  array();
					$sqlIcon['QUERY'] = "SELECT * FROM " . _DB_ICON_SETTING_ . " 
									WHERE `id`!='' AND `purpose`='Profile Side Panel Icon'  AND status IN ('A', 'I') ORDER BY `id`";
					// $sql['PARAM'][]	=	array('FILD' => 'status' ,  'DATA' => 'A' , 'TYP' => 's');					 
					$result    = $mycms->sql_select($sqlIcon);
					if ($result) {
					?>
						<div class="left-menu open">
							<!-- <div class="dot-menu"><img src="<?= _BASE_URL_ ?>images/more.png" alt="" /></div> -->
							<ul>
								<li><a href="<?= _BASE_URL_ ?>profile.php"><img src="<?= _BASE_URL_ ?>images/home.png" alt="" /></a></li>

								<li><a href="<?= _BASE_URL_ ?>profile.php" title="Profile"><img src="<?= _BASE_URL_ ?>images/cat-ic-1.png" alt="" /></a></li>
								<?php if (count($workshopDetailsArray) > 0) { ?>
									<li><a href="<?= _BASE_URL_ . "profile-add.php?section=3" ?>" title="<?= $result[0]['title'] ?>"><img src="<?= $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[0]['icon']; ?>" alt="" /></a></li>
								<?php }
								if (!empty($registrationAccompanyAmount) && $registrationAccompanyAmount > 0) { ?>
									<li><a href="<?= _BASE_URL_ . "profile-add.php?section=4" ?>" title="<?= $result[1]['title'] ?>"><img src="<?= $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[1]['icon']; ?>" alt="" /></a></li>
								<?php }
								if (sizeof($delgDinner) > 0) { ?>
									<li><a href="<?= _BASE_URL_ . "profile-add.php?section=5" ?>" title="<?= $result[2]['title'] ?>"><img src="<?= $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[2]['icon']; ?>" alt="" /></a></li>
								<?php }
								if ($countAcc) { ?>
									<li><a href="<?= _BASE_URL_ . "profile-add.php?section=6" ?>" title="<?= $result[3]['title'] ?>"><img src="<?= $cfg['EMAIL.HEADER.FOOTER.IMAGE'] . $result[3]['icon']; ?>" alt="" /></a></li>
								<?php } ?>
								<li><a href="<?= _BASE_URL_ ?>login.process.php?action=logout" class="btn logout" style="margin-top: 12px;" title="Logout"><img src="<?= _BASE_URL_ ?>images/log-out.png">
									</a> </li>
							</ul>
						</div>
					<?php } ?>

					<div class="accomodation-one">
						<div class="dash-menus">
							<div class="user-name"><span><?= $rowUserDetails['user_full_name'] ?></span> <img src="<?= _BASE_URL_ ?>images/user.png" alt="" />
							</div>
							<div class="dash-notification"><img src="<?= _BASE_URL_ ?>images/notification.png" alt="" /></div>
							<div class="dash-logo"><a href="#"><img src="<?= $header_image ?>" style="    height: 72px;width: 204px;background: white;padding: 12px;" alt="" /></a></div>
						</div>


						<div class="dr-details-sec">
							<div class="author-details author-fold-1">
								<div class="author-close">
									<div class="close-auth"><!-- <img src="<?= _BASE_URL_ ?>images/auth-close.png" alt="" /> Close --></div>
								</div>

								<div class="auth-scroll">
									<div class="accordion" id="accordionExample">
										<div class="accordion-item" id="authorSection">
											<h2 class="accordion-header" id="headingOne">
												<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
														<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
													</svg> Author Details
												</button>
											</h2>

											<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
												<div class="accordion-body" id="accordion-body-presenter">
													<div class="form-floating mb-3">
														<label for="floatingInput">E-mail</label>
														<div class="d-flex">
															<span><img src="images/email-R.png" alt=""></span>
															<input type="text" name="abstract_presenter_email" id="abstract_presenter_email" class="form-control" style="text-transform:lowercase;" usefor="email" value="<?= $rowUserDetails['user_email_id'] ?>" validate="Please enter the email id">
														</div>
													</div>

													<div class="form-floating mb-3">
														<label for="floatingInput">Mobile</label>
														<div class="d-flex">
															<span><img src="images/phone-R.png" alt=""></span>
															<input type="text" class="form-control" id="abstract_presenter_mobile" name="abstract_presenter_mobile" placeholder="" value="<?= $rowUserDetails['user_mobile_no'] ?>" validate="Please enter the mobile No" onkeypress="return isNumber(event)" maxlength="10">
														</div>
													</div>

													<div class="form-floating mb-3">
														<label for="floatingInput">Title</label>
														<div class="d-flex">
															<span><img src="images/Name-R.png" alt=""></span>
															<div class="checkbox-wrap">

																<label class="custom-radio">
																	<input type="radio" name="abstract_presenter_title" value="DR" <?php if ($rowUserDetails['user_title'] == 'DR') {
																																		echo 'checked';
																																	} ?>> Dr.<span class="checkmark"></span> </label>
																<label class="custom-radio"><input type="radio" name="abstract_presenter_title" value="PROF" <?php if ($rowUserDetails['user_title'] == 'PROF') {
																																									echo 'checked';
																																								} ?>> Prof. <span class="checkmark"></label>
																<label class="custom-radio"><input type="radio" name="abstract_presenter_title" value="MR" <?php if ($rowUserDetails['user_title'] == 'MR') {
																																								echo 'checked';
																																							} ?>> Mr.<span class="checkmark"></label>
																<label class="custom-radio"><input type="radio" name="abstract_presenter_title" value="MRS" <?php if ($rowUserDetails['user_title'] == 'MRS') {
																																								echo 'checked';
																																							} ?>> Mrs.<span class="checkmark"></label>
																<label class="custom-radio"><input type="radio" name="abstract_presenter_title" value="MS" <?php if ($rowUserDetails['user_title'] == 'MS') {
																																								echo 'checked';
																																							} ?>> Ms.<span class="checkmark"></label>



															</div>
														</div>
													</div>
													<div class="form-floating mb-3">
														<label for="floatingInput">First name</label>
														<div class="d-flex">
															<span><img src="images/Name-R.png" alt=""></span>
															<input type="text" class="form-control" id="abstract_presenter_first_name" name="abstract_presenter_first_name" placeholder="" value="<?= $rowUserDetails['user_first_name'] ?>" validate="Please enter the first name">
														</div>
													</div>
													<div class="form-floating mb-3">
														<label for="floatingInput">Last Name</label>
														<div class="d-flex">
															<span><img src="images/Name-R.png" alt=""></span>
															<input type="text" class="form-control" id="abstract_presenter_last_name" name="abstract_presenter_last_name" placeholder="" value="<?= $rowUserDetails['user_last_name'] ?>" validate="Please enter the last name">
														</div>
													</div>
													<div class="form-floating mb-3">
														<label for="floatingSelect">Country</label>
														<div class="d-flex">
															<span><img src="images/country-R.png" alt=""></span>
															<select class="form-control select" name="abstract_presenter_country" id="abstract_presenter_country" forType="country" style="text-transform:uppercase;" required validate="Please select country">
																<option value="0">-- Select Country --</option>
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
																		<option value="<?= $rowFetchCountry['country_id'] ?>" <?php if ($rowFetchCountry['country_id'] == $rowUserDetails['user_country_id']) {
																																	echo 'selected';
																																} ?>><?= $rowFetchCountry['country_name'] ?></option>
																<?php
																	}
																}
																?>
															</select>
														</div>
													</div>
													<div class="form-floating mb-3">
														<label for="floatingSelect">State</label>
														<div class="d-flex">
															<span><img src="images/state-R.png" alt=""></span>
															<?php
															$sqlFetchState   = array();
															$sqlFetchState['QUERY']    = "SELECT * FROM " . _DB_COMN_STATE_ . " 
	                                                         WHERE `status` =? AND `country_id`=?
	                                                      	ORDER BY `state_name` ASC";

															$sqlFetchState['PARAM'][]   = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');
															$sqlFetchState['PARAM'][]   = array('FILD' => 'country_id', 'DATA' => $rowUserDetails['user_country_id'], 'TYP' => 's');

															$resultFetchState = $mycms->sql_select($sqlFetchState);
															//echo '<pre>'; print_r($resultFetchState);	
															//echo $rowUserDetails['user_state_id']; 
															?>

															<!-- <select class="form-control select" name="abstract_authors_state" id="abstract_presenter_state" use="country" forType="state" style="text-transform:uppercase;" required validate="Please select state"> -->
															<select class="form-control select" name="abstract_presenter_state" id="abstract_presenter_state" forType="country" style="text-transform:uppercase;" required validate="Please select state">
																<option value="0">-- Select State --</option>
																<?php

																if ($resultFetchState) {
																	foreach ($resultFetchState as $keyState => $rowFetchState) {
																?>
																		<option value="<?= $rowFetchState['st_id'] ?>" <?php if ($rowUserDetails['user_state_id'] == $rowFetchState['st_id']) {
																															echo 'selected';
																														} ?>><?= $rowFetchState['state_name'] ?></option>
																<?php
																	}
																}
																?>
															</select>
														</div>

													</div>


													<div class="form-floating mb-3">
														<label for="floatingInput">City</label>
														<div class="d-flex">
															<span><img src="images/city-R.png" alt=""></span>
															<input type="text" class="form-control" id="abstract_presenter_city" name="abstract_presenter_city" placeholder="" value="<?= $rowUserDetails['user_city'] ?>" validate="Please enter the city">
														</div>
													</div>
													<div class="form-floating mb-3">
														<label for="floatingInput">Postal Code</label>
														<div class="d-flex">
															<span><img src="images/postal-R.png" alt=""></span>
															<input type="text" class="form-control" id="abstract_presenter_pincode" name="abstract_presenter_pincode" placeholder="" value="<?= $rowUserDetails['user_pincode'] ?>" validate="Please enter the postal code">
														</div>
													</div>
													<div class="form-floating mb-3">
														<label for="floatingInput">Institute</label>
														<div class="d-flex">
															<span><img src="images/postal-R.png" alt=""></span>
															<input type="text" class="form-control" use="Institute" id="abstract_author_institute" name="abstract_author_institute_name" placeholder="" validate="Please enter the institute" autocomplete="nope" value="<?= $abstract_author_institute_name ?>">
														</div>
													</div>
													<div class="form-floating">
														<label for="floatingInput">Department</label>
														<div class="d-flex">
															<span><img src="images/postal-R.png" alt=""></span>
															<input type="text" class="form-control" use="Department" id="abstract_author_department" name="abstract_author_department" placeholder="" validate="Please enter the Department" autocomplete="nope" value="<?= $abstract_author_department ?>">
														</div>
													</div>

												</div>
											</div>
										</div>


										<div class="accordion-item" id="coAuthorSection" style="display:none">
											<h2 class="accordion-header" id="headingTwo">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
														<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
													</svg> Co-author Details
												</button>
											</h2>
											<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
												<div class="accordion-body" id="accordion-body-coauthor">

													<?php
													$sqlCoAuthor   = array();
													$sqlCoAuthor['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_COAUTHOR_ . " 
                                                         WHERE `status` =? 
                                                         AND `abstract_id` =?
                                                      ORDER BY `id` ASC";

													$sqlCoAuthor['PARAM'][]   = array('FILD' => 'status', 'DATA' => 'A', 'TYP' => 's');
													$sqlCoAuthor['PARAM'][]   = array('FILD' => 'abstract_id', 'DATA' => $_REQUEST['abstract_id'], 'TYP' => 's');

													$resultCoAuthor = $mycms->sql_select($sqlCoAuthor);

													if ($resultCoAuthor) {
														$i = 1;
														foreach ($resultCoAuthor as $k => $val) {


															$drChecked = ($val['abstract_coauthor_title'] == 'Dr') ? "checked" : "";
													?>

															<div class="add_coathor accordion-item" style="margin-bottom: 22px;">
																<!-- <h5>Co Auther - <span id="coCount"><?= $i ?></span></h5> -->
																<h5 class="accordion-header" id="ca1">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
																		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
																			<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
																		</svg> Co Auther - <span id="coCount"><?= $i ?></span>
																	</button>
																</h5>
																<div id="collapseTwo1" class="accordion-collapse collapse show " aria-labelledby="headingTwo1" data-bs-parent="#accordion-body-coauthor">
																	<div class="form-floating mb-3">
																		<label for="floatingInput">E-mail</label>
																		<div class="d-flex">
																			<span><img src="images/email-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details" use="Email" id="abstract_coauthor_email" name="abstract_coauthor_email[<?= $k ?>]" value="<?= $val['abstract_coauthor_email'] ?>" placeholder="" validate="Please enter the coauthor email" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">Mobile</label>
																		<div class="d-flex">
																			<span><img src="images/phone-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="Mobile" id="abstract_coauthor_mobile" name="abstract_coauthor_mobile[<?= $k ?>]" value="<?= $val['abstract_coauthor_phone_no'] ?>" placeholder="" onkeypress="return isNumber(event)" maxlength="10" validate="Please enter the coauthor mobile" onkeypress="return isNumber(event)" maxlength="10" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">Title</label>
																		<div class="d-flex">
																			<span><img src="images/Name-R.png" alt=""></span>
																			<div class="checkbox-wrap">
																				<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[<?= $k ?>]" <?= $val['abstract_coauthor_title'] == 'Dr' ? "checked" : "" ?> value="Dr"> Dr.<span class="checkmark"></label>
																				<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[<?= $k ?>]" <?= $val['abstract_coauthor_title'] == 'Prof' ? "checked" : "" ?> value="Prof"> Prof.<span class="checkmark"></label>
																				<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[<?= $k ?>]" <?= $val['abstract_coauthor_title'] == 'Mr' ? "checked" : "" ?> value="Mr"> Mr.<span class="checkmark"></label>
																				<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[<?= $k ?>]" <?= $val['abstract_coauthor_title'] == 'Mrs' ? "checked" : "" ?> value="Mrs"> Mrs.<span class="checkmark"></label>
																				<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[<?= $k ?>]" <?= $val['abstract_coauthor_title'] == 'Ms' ? "checked" : "" ?> value="Ms"> Ms.<span class="checkmark"></label>
																			</div>
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">First name</label>
																		<div class="d-flex">
																			<span><img src="images/Name-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="First Name" id="abstract_coauthor_first_name" name="abstract_coauthor_first_name[<?= $k ?>]" value="<?= $val['abstract_coauthor_first_name'] ?>" placeholder="" validate="Please enter the coauthor first name" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">Last Name</label>
																		<div class="d-flex">
																			<span><img src="images/Name-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="Last Name" id="abstract_coauthor_last_name" name="abstract_coauthor_last_name[<?= $k ?>]" value="<?= $val['abstract_coauthor_last_name'] ?>" placeholder="" validate="Please enter the coauthor last name" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingSelect">Country</label>
																		<div class="d-flex">
																			<span><img src="images/country-R.png" alt=""></span>
																			<select class="form-control select coauther_details " use="Country" name="abstract_coauthor_country[<?= $k ?>]" id="abstract_coauthor_country" forType="country" style="text-transform:uppercase;" required validate="Please select the coauthor country">
																				<option value="0">-- Select Country --</option>
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
																						<option value="<?= $rowFetchCountry['country_id'] ?>" <?= $val['abstract_coauthor_country_id'] ==  $rowFetchCountry['country_id'] ? "selected" : "" ?>><?= $rowFetchCountry['country_name'] ?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingSelect">State</label>
																		<div class="d-flex">
																			<span><img src="images/state-R.png" alt=""></span>
																			<select class="form-control select coauther_details " use="State" name="abstract_coauthor_state[<?= $k ?>]" id="abstract_coauthor_state" forType="state" style="text-transform:uppercase;" required validate="Please select the coauthor state">
																				<option value="0" selected>Select State</option>
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
																						<option value="<?= $rowFetchState['st_id'] ?>" <?= $val['abstract_coauthor_state_id'] ==  $rowFetchState['st_id'] ? "selected" : "" ?>><?= $rowFetchState['state_name'] ?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">City</label>
																		<div class="d-flex">
																			<span><img src="images/city-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="City" id="abstract_coauthor_city" name="abstract_coauthor_city[<?= $k ?>]" value="<?= $val['abstract_coauthor_city_name'] ?>" placeholder="" validate="Please enter the coauthor city" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">Postal Code</label>
																		<div class="d-flex">
																			<span><img src="images/postal-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="Postal Code" id="abstract_coauthor_pincode" name="abstract_coauthor_pincode[<?= $k ?>]" value="<?= $val['abstract_coauthor_pincode'] ?>" placeholder="" validate="Please enter the coauthor pincode" onkeypress="return isNumber(event)" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating mb-3">
																		<label for="floatingInput">Institute</label>
																		<div class="d-flex">
																			<span><img src="images/postal-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="Institute" id="abstract_coauthor_institute" name="abstract_coauthor_institute[<?= $k ?>]" placeholder="" value="<?= $val['abstract_coauthor_institute_name'] ?>" validate="Please enter the institute" autocomplete="nope">
																		</div>
																	</div>
																	<div class="form-floating">
																		<label for="floatingInput">Department</label>
																		<div class="d-flex">
																			<span><img src="images/postal-R.png" alt=""></span>
																			<input type="text" class="form-control coauther_details " use="Department" id="abstract_coauthor_department" name="abstract_coauthor_department[<?= $k ?>]" placeholder="" value="<?= $val['abstract_coauthor_department'] ?>" validate="Please enter the Department" autocomplete="nope">
																		</div>
																	</div>
																	<input type="hidden" name="coAuthorCounts" id="coAuthorCounts" value="<?= $i ?>">
																</div>
															</div>
														<?php
															$i++;
														}
														?>
														<input type="hidden" id="existingCoAuthorNum" value=<?= $i - 1 ?>>
													<?php
													} else {	// if co author exists end
													?>
														<div class="add_coathor accordion-item" id="newCoAuthor" style="margin-bottom: 22px;">
															<!-- <h5>Co Auther - <span id="coCount">1</span></h5> -->
															<h5 class="accordion-header" id="ca1">
																<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
																	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
																		<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
																	</svg> Co Auther - <span id="coCount">1</span>
																</button>
															</h5>
															<div id="collapseTwo1" class="accordion-collapse collapse show " aria-labelledby="headingTwo1" data-bs-parent="#accordion-body-coauthor">
																<div class="form-floating mb-3">
																	<label for="floatingInput">E-mail</label>
																	<div class="d-flex">
																		<span><img src="images/email-R.png" alt=""></span>
																		<input type="email" class="form-control coauther_details " use="Email" id="abstract_coauthor_email" name="abstract_coauthor_email[0]" placeholder="" validate="Please enter the coauthor email">
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">Mobile</label>
																	<div class="d-flex">
																		<span><img src="images/phone-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="Mobile" id="abstract_coauthor_mobile" name="abstract_coauthor_mobile[0]" placeholder="" onkeypress="return isNumber(event)" maxlength="10" validate="Please enter the coauthor mobile" onkeypress="return isNumber(event)" maxlength="10">
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">Title</label>
																	<div class="d-flex">
																		<span><img src="images/Name-R.png" alt=""></span>
																		<div class="checkbox-wrap">
																			<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[0]" value="Dr"> Dr.<span class="checkmark"></span></label>
																			<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[0]" value="Prof"> Prof.<span class="checkmark"></span></label>
																			<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[0]" value="Mr"> Mr.<span class="checkmark"></span></label>
																			<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[0]" value="Mrs"> Mrs.<span class="checkmark"></span></label>
																			<label class="custom-radio"><input type="radio" name="abstract_coauthor_title[0]" value="Ms"> Ms.<span class="checkmark"></span></label>
																		</div>
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">First name</label>
																	<div class="d-flex">
																		<span><img src="images/Name-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="First Name" id="abstract_coauthor_first_name" name="abstract_coauthor_first_name[0]" placeholder="" validate="Please enter the coauthor first name">
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">Last Name</label>
																	<div class="d-flex">
																		<span><img src="images/Name-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="Last Name" id="abstract_coauthor_last_name" name="abstract_coauthor_last_name[0]" placeholder="" validate="Please enter the coauthor last name">
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingSelect">Country</label>
																	<div class="d-flex">
																		<span><img src="images/country-R.png" alt=""></span>
																		<select class="form-control select coauther_details " use="Country" name="abstract_coauthor_country[0]" id="abstract_coauthor_country" forType="country" style="text-transform:uppercase;" required validate="Please select the coauthor country">
																			<option value="0">-- Select Country --</option>
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
																<div class="form-floating mb-3">
																	<label for="floatingSelect">State</label>
																	<div class="d-flex">
																		<span><img src="images/state-R.png" alt=""></span>
																		<select class="form-control select coauther_details " use="State" name="abstract_coauthor_state[0]" id="abstract_coauthor_state" forType="state" style="text-transform:uppercase;" required validate="Please select the coauthor state">
																			<option value="0" selected>Select State</option>
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
																					<option value="<?= $rowFetchState['st_id'] ?>"><?= $rowFetchState['state_name'] ?></option>
																			<?php
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">City</label>
																	<div class="d-flex">
																		<span><img src="images/city-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="City" id="abstract_coauthor_city" name="abstract_coauthor_city[0]" placeholder="" validate="Please enter the coauthor city">
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">Postal Code</label>
																	<div class="d-flex">
																		<span><img src="images/postal-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="Postal Code" id="abstract_coauthor_pincode" name="abstract_coauthor_pincode[0]" placeholder="" validate="Please enter the coauthor pincode" onkeypress="return isNumber(event)">
																	</div>
																</div>
																<div class="form-floating mb-3">
																	<label for="floatingInput">Institute</label>
																	<div class="d-flex">
																		<span><img src="images/postal-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="Institute" id="abstract_coauthor_institute" name="abstract_coauthor_institute[0]" placeholder="" validate="Please enter the institute" autocomplete="nope">
																	</div>
																</div>
																<div class="form-floating">
																	<label for="floatingInput">Department</label>
																	<div class="d-flex">
																		<span><img src="images/postal-R.png" alt=""></span>
																		<input type="text" class="form-control coauther_details " use="Department" id="abstract_coauthor_department" name="abstract_coauthor_department[0]" placeholder="" validate="Please enter the Department" autocomplete="nope">
																	</div>
																</div>
																<input type="hidden" name="coAuthorCounts" id="coAuthorCounts" value="1">
															</div>
														</div>

													<?php } ?>
													<!-- <button class="delete-coauthor-btn" count="1">Delete</button> -->
													<!-- <button class="delete-coauthor-btn">Delete</button>  -->
													<!-- x -->

												</div>
												<button class="btn" id="add-coauthor-btn" style="margin-top: 9px;">Add More</button>
											</div>
										</div>
									</div>
								</div>

								<div class="bottom-btn-wrap">
									<a id="firstAthrBtn" class="btn next-btn"><i class="fa-solid fa-chevron-right"></i></a>
									<a id="firstBtn" class="btn next-btn next" style="display:none"><i class="fa-solid fa-chevron-right"></i></a>
								</div>
							</div>




							<div class="author-details author-fold-2 blur_bw">
								<div class="author-close">
									<div class="close-auth"><!-- <img src="<?= _BASE_URL_ ?>images/auth-close.png" alt="" /> Close --></div>
								</div>

								<div class="auth-scroll">
									<div class="accordion" id="accordionExample2">
										<div class="accordion-item">
											<h2 class="accordion-header" id="headingOne1">
												<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
														<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
													</svg> Submission Category
												</button>
											</h2>

											<div id="collapseOne1" class="accordion-collapse collapse show" aria-labelledby="headingOne1" data-bs-parent="#accordionExample2">
												<div class="accordion-body custom-radio-holder" id="abstract_details">

													<?php
													$Abs_cat_id = $resultAbstractType[0]['abstract_cat'];
													$abs_sub_cat_id = $resultAbstractType[0]['abstract_parent_type'];
													if (count($resultAbstractType) < 10) {

														$sqlAbstractTopic			  =	array();
														$sqlAbstractTopic['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_TOPIC_CATEGORY_ . " 
																					  WHERE `status` IN ('A')
																				   ORDER BY `category` ASC";


														$resultAbstractTopic = $mycms->sql_select($sqlAbstractTopic);
														$topicId = $resultAbstractType[0]['abstract_topic_id'];

														$sqlAbstractSubmission			  =	array();
														$sqlAbstractSubmission['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_SUBMISSION_ . " 
																					  WHERE  `status` IN ('A')
																				   ORDER BY `category` ASC";


														$resultAbstractSubmission = $mycms->sql_select($sqlAbstractSubmission);

														$sqlAbstractPresentation			 =	array();
														$sqlAbstractPresentation['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_PRESENTATION_ . " 
																					  WHERE `status` ='A'
																				   ORDER BY `id` ASC";


														$resultAbstractPresentation = $mycms->sql_select($sqlAbstractPresentation);


														//echo '<pre>'; print_r($resultAbstractTopic);
														foreach ($resultAbstractTopic as $key => $value) {
															$sqlAbstractSubcat['QUERY']    = "SELECT * FROM " . _DB_AWARD_MASTER_ . " 
																								WHERE `related_category_id`='" . $value['id'] . "' AND `related_topic_id`='' AND
																								`status` = 'A' ORDER BY `id` ASC";

															$resultAbstractSubcat = $mycms->sql_select($sqlAbstractSubcat);
															$nomination_ids = array();
															if ($resultAbstractSubcat) {
																foreach ($resultAbstractSubcat as $key => $nomination) {
																	array_push($nomination_ids, $nomination['id']);
																}
															}
															$nomination_ids = json_encode($nomination_ids);

															if (in_array(trim($value['id']), $abstractCatArray)) {

																$checked = 'checked';
																$disabled = 'disabled';
															} else {

																$checked = '';
																$disabled = '';
															}
													?>

															<div class="form-check">
																<label class="custom-radio" for="flexCheckDefault1<?= $value['id'] ?>">
																	<input class="custom-radio trigger_subCategory" type="radio" value="<?= $value['id'] ?>" id="flexCheckDefault1<?= $value['id'] ?>" name="abstract_category" onclick="abstractTypeChange(this,'<?= $value['id'] ?>','<?php echo implode(',', json_decode($value['category_fields'])); ?>','<?php echo implode(',', json_decode($nomination_ids)); ?>')" <?= $value['id'] == $resultAbstractType[0]['abstract_cat'] ? "checked" : "" ?> disabled readonly required>
																	<?= $value['category'] ?><span class="checkmark"></span>
																</label>
															</div>
													<?php

														}
													}

													?>
													<!-- <input type="hidden" name="absCatTitle" id="absCatTitle"> -->


												</div>
											</div>
										</div>
										<?php if ($resultAbstractSubmission) { ?>
											<div class="accordion-item">
												<h2 class="accordion-header" id="headingTwo2">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
															<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
														</svg> Submission Sub Category
													</button>
												</h2>
												<div id="collapseTwo2" class="accordion-collapse collapse show" aria-labelledby="headingTwo2" data-bs-parent="#accordionExample2">
													<div class="accordion-body custom-radio-holder" id="abstract_details">

														<?php
														if (count($resultAbstractType) < 10) {
															//echo '<pre>'; print_r($resultAbstractSubmission);
															foreach ($resultAbstractSubmission as $key => $value) {

														?>
																<div class="form-check submissionTypeRadio<?= $value['category'] ?> hidesub" style="display:none;">
																	<label class="custom-radio" for="flexCheckDefault<?= $value['id'] ?>">
																		<input class="custom-radio" type="radio" id="flexCheckDefault<?= $value['id'] ?>" name="abstract_parent_type" value="<?= $value['id'] ?>" titleWordCountLimit="<?= $cfg['ABSTRACT.TITLE.WORD.LIMIT'] ?>" contentWordCountLimit="<?= $cfg['ABSTRACT.FREE.PAPER.SESSION.WORD.LIMIT'] ?>" relatedSubmissionSubType="" onclick="abstractSubmissionType(this,'<?php echo $value['category']; ?>','<?php echo $value['id']; ?>')" disabled="disabled" relatedSubmissionSubType="" readonly disabled="disabled" <?= strtoupper($value['id']) == trim($resultAbstractType[0]['abstract_parent_type']) ? "checked" : "" ?>>
																		<?= $value['abstract_submission'] ?><span class="checkmark"></span>
																	</label>
																</div>

														<?php
															}
														}
														?>
														<!-- <input type="hidden" name="abssubCatTitle" id="abssubCatTitle"> -->

													</div>
												</div>
											</div>
										<?php } ?>

									</div>
								</div>
								<div class="btn-holder-right" style="text-align: right; margin-right:15px;">
									<a id="secondBtnPrev" class="btn next-btn prev" style="display: none;"><svg class="icon-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
											<path d="M34.5 239L228.9 44.7c9.4-9.4 24.6-9.4 33.9 0l22.7 22.7c9.4 9.4 9.4 24.5 0 33.9L131.5 256l154 154.8c9.3 9.4 9.3 24.5 0 33.9l-22.7 22.7c-9.4 9.4-24.6 9.4-33.9 0L34.5 273c-9.4-9.4-9.4-24.6 0-33.9z" />
										</svg></a>
									<a id="secondBtn" class="btn next-btn next" style="display: none;"><svg class="icon-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
											<path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
										</svg></a>
								</div>
							</div>



							<div class="author-details author-fold-3 blur_bw">
								<!-- <div class="author-close"></div> -->
								<div class="auth-scroll">
								<?php
									$sqlAbstractTopic			  =	array();
									$sqlAbstractTopic['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_TOPIC_ . " 
																											  WHERE `status` = ? 
																										   ORDER BY `id` ASC";

									$sqlAbstractTopic['PARAM'][]  = array('FILD' => 'status', 'DATA' => 'A',  'TYP' => 's');
									$resultAbstractTopic = $mycms->sql_select($sqlAbstractTopic);
									// print_r($resultAbstractTopic);

									if ($resultAbstractTopic) {
									?>
									<div class="choose-topic">
										<h2><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
												<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
											</svg> Chose Your Topic</h2>
										<div class="choose-drop" id="abstract_details_2">

											<select name="abstract_topic_id" id="abstract_topic_id" class="form-control select" style="text-transform:uppercase; height:60px;" required="required" validate="Please select the topic">
												<option value="">--Select Topic--</option>
												<?php
												$sqlAbstractTopic			  =	array();
												$sqlAbstractTopic['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_TOPIC_ . " 
																				  WHERE `status` = ? 
																			   ORDER BY `id` ASC";

												$sqlAbstractTopic['PARAM'][]  = array('FILD' => 'status', 'DATA' => 'A',  'TYP' => 's');
												$resultAbstractTopic = $mycms->sql_select($sqlAbstractTopic);

												if ($resultAbstractTopic) {
													foreach ($resultAbstractTopic as $keyAbstractTopic => $rowAbstractTopic) {
												?>
														?>
														<option value="<?= $rowAbstractTopic['id'] ?>" <?= $rowAbstractTopic['id'] == $resultAbstractType[0]['abstract_topic_id'] ? "selected" : "" ?>><?= $rowAbstractTopic['abstract_topic'] ?></option>
												<?php
													}
												}
												?>
											</select>

											<?php if ($cfg['ABSTRACT.GUIDELINE.PDF.FLAG'] != 0) { ?>
												<a href="<?= $cfg['ABSTRACT.GUIDELINE.PDF.FLAG'] == '1' ? $cfg['ABSTRACT.GUIDELINE.PDF'] : _BASE_URL_ . "uploads/FILES.ABSTRACT.REQUEST/" . $cfg['ABSTRACT.GUIDELINE.PDF.FILE'] ?>" target="_blank"><img src="<?= _BASE_URL_ ?>images/gide.png" alt=""></a>
											<?php }	?>
										</div>
									</div>
									<?php } ?>
									<div class="accordion" id="accordionExample3" use="abstractDetails">

										<div class="accordion-item">
											<h2 class="accordion-header" id="headingOne10">
												<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne10" aria-expanded="true" aria-controls="collapseOne">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
														<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
													</svg> Title
												</button>
											</h2>

											<div id="collapseOne10" class="accordion-collapse collapse show" aria-labelledby="headingOne10" data-bs-parent="#accordionExample3">
												<div class="accordion-body p-0" id="abstract_details_2">

													<?php

													if ($cfg['ABSTRACT.TITLE.WORD.TYPE'] == 'character') {
														$abstract_title_length = strlen(trim($resultAbstractType[0]['abstract_title']));
													} else {
														$abstract_title_length = str_word_count(trim($resultAbstractType[0]['abstract_title']));
													}
													?>
													<div class="auth-textarea">
														<textarea class="form-co................................ntrol" name="abstract_title" id="abstract_title" checkFor="wordCount" spreadInGroup="abstractTitle" displayText="abstract_title_word_count" style="text-transform:uppercase;" validate="Please enter the abstract title" required><?= $resultAbstractType[0]['abstract_title'] ?></textarea>
														<div class="alert alert-success" style="display:block;">
															<span use="abstract_title_word_count" limit="<?= $cfg['ABSTRACT.TITLE.WORD.LIMIT'] ?>">
																<span use="total_word_entered"><?= $abstract_title_length; ?></span> /
																<span use="total_word_limit"><?= $cfg['ABSTRACT.TITLE.WORD.LIMIT'] ?></span>
																<span style="color: #D41000;">(Title should be within <?= $cfg['ABSTRACT.TITLE.WORD.LIMIT'] ?> <?= $cfg['ABSTRACT.TITLE.WORD.TYPE'] ?>s.)</span>
															</span>
														</div>


													</div>
												</div>
											</div>
											<?php
											$sqlAbstractFields			  =	array();
											$sqlAbstractFields['QUERY']    = "SELECT * FROM " . _DB_ABSTRACT_FIELDS_ . " 
																		  WHERE `status` = ?";

											$sqlAbstractFields['PARAM'][]  = array('FILD' => 'status', 'DATA' => 'A',  'TYP' => 's');

											$resultAbstractFields = $mycms->sql_select($sqlAbstractFields);

											foreach ($resultAbstractFields as $key => $value) {


												$sqlAbstractFieldsVal			  =	array();
												$sqlAbstractFieldsVal['QUERY']    = "SELECT COUNT(*) AS COUNTDATA FROM " . _DB_ABSTRACT_REQUEST_ . " 
																		  WHERE " . $value['field_key'] . "!='NULL' AND id='" . $resultAbstractType[0]['id'] . "'";

												$resultAbstractFieldsVal = $mycms->sql_select($sqlAbstractFieldsVal);
												//echo '<pre>'; print_r( $resultAbstractFieldsVal[0]['COUNTDATA']);

												if ($resultAbstractFieldsVal[0]['COUNTDATA'] > 0) {

													$msg = "Please enter the " . strtolower($value['display_name']);


											?>
													<div class="col-xs-12 form-group input-material" actAs='fieldContainer' relatedSubmissionType="" relatedSubmissionSubType="">
														<label for="user_mobile"><?= $value['display_name'] ?></label>
														<textarea class="form-control" name="<?= $value['field_key'] ?>[]" id="fieldVal_<?= $value['id'] ?>" checkFor="wordCount" spreadInGroup="abstractContent" displayText="abstract_total_word_display" validate="<?= $msg ?>" title="<?= $value['display_name'] ?>"><?= $resultAbstractType[0][$value['field_key']] ?></textarea>

													</div>
											<?php
												}
											}
											?>

											<div class="col-xs-12 form-group input-material" id="wordCountList" style="display:none">
												<!-- <div class="checkbox"> -->
												<label class="select-lable">Total Word Count</label>
												<span use="abstract_total_word_display" limit="<?= $cfg['ABSTRACT.FREE.PAPER.SESSION.WORD.LIMIT'] ?>">
													<span use="total_word_entered">0</span> /
													<span use="total_word_limit"><?= $cfg['ABSTRACT.FREE.PAPER.SESSION.WORD.LIMIT'] ?></span>
													<span style="color: #ffff;">(Total <?= $cfg['ABSTRACT.FREE.PAPER.SESSION.WORD.LIMIT'] ?> are <?= $cfg['ABSTRACT.TOTAL.WORD.TYPE'] ?>s allowed.)</span>
												</span>
												<!-- </div> -->
											</div>

										</div><?php
												$sqlAbstractSubcat    = array();
												$sqlAbstractSubcat['QUERY']    = "SELECT * 
																		  FROM " . _DB_AWARD_MASTER_ . " 
																		 WHERE `status` = ? 
																	  ORDER BY `id` ASC";

												$sqlAbstractSubcat['PARAM'][]   = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');

												$resultAbstractSubcat = $mycms->sql_select($sqlAbstractSubcat);

												$sqlSelectedNomination    = array();
												$sqlSelectedNomination['QUERY']    = "SELECT * FROM " . _DB_AWARD_REQUEST_ . " 
																		 WHERE `status` = ? AND `submission_code`= ?  ";

												$sqlSelectedNomination['PARAM'][]   = array('FILD' => 'status',  'DATA' => 'A',  'TYP' => 's');
												$sqlSelectedNomination['PARAM'][]   = array('FILD' => 'submission_code',  'DATA' => $resultAbstractType[0]['abstract_submition_code'],  'TYP' => 's');

												$resultSelectedNomination = $mycms->sql_select($sqlSelectedNomination);
												if ($resultSelectedNomination) {
													$award_id = $resultSelectedNomination[0]['award_id'];
													// $checkStatus= 'checked';
												}

												// echo '<pre>'; print_r($resultAbstractType);

												if ($resultAbstractSubcat) {
												?>
											<div class="accordion" id="accordianNomination" ishidden="0" style="display:none">
												<div class="accordion-item">
													<h2 class="accordion-header" id="headingOne101">
														<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne101" aria-expanded="true" aria-controls="collapseOne">
															<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
																<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
															</svg> Bursary Programme
														</button>
													</h2>

													<div id="collapseOne101" class="accordion-collapse collapse show" aria-labelledby="headingOne10" data-bs-parent="#accordianNomination">
														<div class="accordion-body p-0" id="abstract_details_2">

															<div class="custom-radio-holder" id="nomination_holder" style="padding:0px 0px">
																<?php
																foreach ($resultAbstractSubcat as $keyAbstractTopic => $rowAbstractTopic) {
																?>
																	<div class="form-check nomination_list" style="padding:0px 0px;display:none" id="nomination_holder_<?= $rowAbstractTopic['id'] ?>">
																		<label class="custom-radio " for="nomination_name_<?= $rowAbstractTopic['id'] ?>">
																			<input class=" custom-radio " type="radio" value="<?= $rowAbstractTopic['id'] ?>" <?= $rowAbstractTopic['id'] == $resultSelectedNomination[0]['award_id'] ? "checked" : "" ?> id="nomination_name_<?= $rowAbstractTopic['id'] ?>" name="award_request">
																			<?= "I want to opt for " . $rowAbstractTopic['award_name'] ?><span class="checkmark"></span>
																			<br><br><span><i>
																					It is mandatory for all bursary applicants to REGISTER FOR
																					THE CONFERENCE PRIOR TO THE LAST DATE OF
																					ABSTRACT SUBMISSION otherwise their bursary application
																					will not be considered.</i>
																			</span>
																		</label>
																	</div>
																<?php } ?>

															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>

										<div class="auth-file-upload-wrap">
											<?php
											if ($hod_consent_file_types !== 'null') {
											?>
												<div class="auth-file-upload">
													<img src="<?= _BASE_URL_ ?>images/uplod.png" alt="" />
													<input type="hidden" name="sessionId" id="sessionId" use="sessionId" value="<?= session_id() ?>" />
													<div class="file-up-dtls">
														<h5>Only one image/graph/table/illustration may be included</h5>
														<input type="hidden" name="hod_consent_file_types" id="hod_consent_file_types" value=<?= $hod_consent_file_types ?> />
														<input type="hidden" name="abstractId" value="<?= $resultAbstractType[0]['id'] ?>" />
														<input type="hidden" name="original_consent_file_name" id="original_consent_file_name" use="upload_original_fileName" />
														<input type="hidden" name="temp_consent_filename" id="temp_consent_filename">
														<input class="form-control" type="file" id="formFileHod" name="upload_consent_abstract_file">
														<?php $type = $hod_consent_file_types_decoded; ?>
														<h5><?= ($type[0] != '') ? strtoupper($type[0]) . " | " : '' ?><?= ($type[1] != '') ? ucfirst($type[1]) : '' ?><?= ($type[2] != '') ? " | " . ucfirst($type[2]) : '' ?></h5>
														<span id=concentFileNameUploaded></span><br>
														<?php
														if (!empty($resultAbstractType[0]['abstract_consent_file'])) {
														?>
															<input type="hidden" id="inserted_abstract_consent_filename_original" value="<?= $resultAbstractType[0]['abstract_consent_original_file_name'] ?>" />
															<input type="hidden" id="inserted_abstract_consent_file" value="<?= $resultAbstractType[0]['abstract_consent_file'] ?>" />
															<a href="<?= $cfg['FILES.ABSTRACT.REQUEST'] . $resultAbstractType[0]['abstract_consent_file'] ?>" target="_blank">Download</a>
														<?php
														}
														?>
													</div>
												</div>
											<?php }
											if ($abstract_file_types !== 'null') { ?>
												<div class="auth-file-upload">
													<img src="<?= _BASE_URL_ ?>images/uplod.png" alt="" />
													<div class="file-up-dtls">
														<h5>Abstract</h5>
														<input type="hidden" name="abstract_file_types" id="abstract_file_types" value=<?= $abstract_file_types ?> />
														<input type="hidden" name="original_abstract_file_name" id="original_abstract_file_name" use="upload_original_fileName" />
														<input type="hidden" name="temp_abstract_filename" id="temp_abstract_filename">
														<input class="form-control" type="file" id="formFileAbstract" name="upload_abstract_file">
														<?php $type = json_decode($abstract_file_types); ?>
														<h5><?= ($type[0] != '') ? strtoupper($type[0]) . " | " : '' ?><?= ($type[1] != '') ? ucfirst($type[1]) : '' ?><?= ($type[2] != '') ? " | " . ucfirst($type[2]) : '' ?></h5>
														<span id=abstractFileNameUploaded></span><br>
														<?php
														if (!empty($resultAbstractType[0]['abstract_file'])) {
														?>
															<input type="hidden" id="inserted_abstract_filename_original" value="<?= $resultAbstractType[0]['abstract_original_file_name'] ?>" />
															<input type="hidden" id="inserted_abstract_file" value="<?= $resultAbstractType[0]['abstract_file'] ?>" />
															<a href="<?= $cfg['FILES.ABSTRACT.REQUEST'] . $resultAbstractType[0]['abstract_file'] ?>" target="_blank">Download</a>
														<?php
														}
														?>
													</div>
												</div>
											<?php } ?>
										</div>



									</div>

									<div class="auth-bottom-last">
										<!-- <text>Lorem Ipsum Lorem Ipsum Lorem Ipsum</text> -->
										<!-- <div class="auth-last-btn"><a href=""><img src="<?= _BASE_URL_ ?>images/eye.png" alt="" /></a></div> -->
										<div class="auth-last-btn" style="background: none;"><a href="javascript:void(0)" onclick="openPreview()"><img src="<?= _BASE_URL_ ?>images/eye.png" alt="" /></a></div>

										<a id="thirdBtnPrev" class="btn next-btn prev" type="third" style="display: none;"><svg class="icon-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
												<path d="M34.5 239L228.9 44.7c9.4-9.4 24.6-9.4 33.9 0l22.7 22.7c9.4 9.4 9.4 24.5 0 33.9L131.5 256l154 154.8c9.3 9.4 9.3 24.5 0 33.9l-22.7 22.7c-9.4 9.4-24.6 9.4-33.9 0L34.5 273c-9.4-9.4-9.4-24.6 0-33.9z" />
											</svg></a>

										<div class="auth-last-btn fix" style="background: none;">
											<a id="thirdBtn" class="next" style="display: none;cursor: pointer;background: none;">Submit</a>
										</div>
									</div>
								</div>
								

							</div>

						</div>
					</div>
			</section>





		</form>

	</main>
	<div class="checkout-main-wrap" id="previewModal">
		<div class="checkout-popup add-inclusion" style="max-width: 1100px;padding: 30px 30px;">
			<div class="card-details" style="width: 1000px">
				<div class="" id="details">

					<h4 style="color:#0d3859">Authorship Details</h4>
					<b>Name: </b><span id="author_name"></span><br>
					<b>Mobile: </b><span id="author_mobile"></span><br>
					<b>Institute Name: </b><span id="author_institute_name"></span>&nbsp;&nbsp;&nbsp;
					<b>Department: </b><span id="author_department"></span><br>
					<b>City: </b><span id="author_city"></span>&nbsp;&nbsp;&nbsp;
					<b>State: </b><span id="author_state_id"></span>&nbsp;&nbsp;&nbsp;
					<b>Country: </b><span id="author_country"></span><br>
					<hr>
					<!-- CO-AUTHOR DERAILS -->
					<div id="previewData">
					</div>

					<div id="abstractData">

					</div>

				</div>
				<a class="close-check"><span>&#10005;</span> close</a>

			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			var selected_topic_id = $('#abstract_topic_id').val();
			var cat_id = <?= $Abs_cat_id ?>;
			var naomination_id = '<?= $resultSelectedNomination[0]['award_id'] ?>';
			// alert(naomination_id)
			$('#flexCheckDefault1' + cat_id).click();
			$('input[type=radio][name=abstract_category]:checked').click();
			$('#nomination_name_' + naomination_id).prop('checked', true);

			var sub_cat = <?= $abs_sub_cat_id == "" ? 0 : $abs_sub_cat_id ?>;
			// alert(sub_cat);
			if (sub_cat == 0) {
				$.ajax({
					type: "POST",
					url: "abstract_request.process.php",
					data: {
						action: 'generateTopic',
						topic: cat_id
					},
					dataType: "html",
					async: false,
					success: function(JSONObject) {
						if (JSONObject) {
							if (JSONObject.trim() == 'empty') {
								$('#topicDetails').hide();
								//document.getElementById("abstract_topic_id").required = false;
								$('#abstract_topic_id').html("")
								$('#abstract_topic_id').attr('required', false);
							} else {
								$('#topicDetails').show();
								$('#abstract_topic_id').html(JSONObject)
							}
						}
						// $('#abstract_topic_id').val(selected_topic_id).change();
						$('#abstract_topic_id').find('option[value^="' + selected_topic_id + '"]').prop('selected', true);




					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
					}
				});
			} else {
				$.ajax({
					type: "POST",
					url: "abstract_request.process.php",
					data: {
						action: 'generateCatSubTopic',
						cat_id: cat_id,
						submission_id: sub_cat,
					},
					dataType: "html",
					async: false,
					success: function(JSONObject) {
						if (JSONObject.trim() == 'empty') {
							$('#topicDetails').hide();
							//document.getElementById("abstract_topic_id").required = false;
							$('#abstract_topic_id').attr('required', false);
						} else {
							$('#topicDetails').show();
							$('#abstract_topic_id').html(JSONObject)
						}
						$('#abstract_topic_id').find('option[value^="' + selected_topic_id + '"]').prop('selected', true);


					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
					}

				});
			}
			// var topic_id=<?= $topicId ?>;
			// $('#abstract_topic_id').val(topic_id);
		})

		function getArrayFieldValues() {
			var values = [];
			var myObj = {};

			$(".coauther_details").each(function() {
				var fieldValue = $(this).val();
				var usefor = $(this).attr('use');
				if (fieldValue !== '') {
					console.log('key=' + usefor + ',values=' + fieldValue)
					myObj[usefor] = fieldValue;
					/*var keyValueArray = {
		  usefor: fieldValue
		 
		};*/

				}
				//values.push(fieldValue);
			});

			console.log(myObj);
			// return keyValueArray;
		}

		function openPreview() {

			// ================ TO GET AUTHOR DETAILS VALUES ==========================
			var presenter_name = $("#abstract_presenter_first_name").val() + " " + $("#abstract_presenter_last_name").val();
			var presenter_email = $("#abstract_presenter_email").val();
			var presenter_mobile = $("#abstract_presenter_mobile").val();
			var presenter_country = $("#abstract_presenter_country option:selected").text();
			var presenter_state = $("#abstract_presenter_state option:selected").text();
			var presenter_city = $("#abstract_presenter_city").val();
			var presenter_pin = $("#abstract_presenter_pincode").val();

			$('#details').empty();

			// var absCatTitle = $('#absCatTitle').val();
			// Get the text of the checked category
			var absCatTitle = $('input[type="radio"][name="abstract_category"]:checked').closest('label').text().trim();

			var abssubCatTitle = $('input[type="radio"][name="abstract_parent_type"]:checked').closest('label').text().trim();
			// var abstract_topic_id = $('#abstract_topic_id').children("option:selected").text();
			var abstract_topic_id = $('#abstract_topic_id option:selected').text();
			if (abstract_topic_id == '-- Select Topic --') {
				abstract_topic_id = 'No topic chosen';
			}
			console.log("abstract_topic_id= " + abstract_topic_id);
			var result = abstract_topic_id.split('-');


			var msg = '';
			// ===================== AUTHOR DETAILS =====================
			msg += "<h4 style='text-align: center;'>Author Details</h4>";
			msg += "<b>Name: </b><span id='presenter_name'>" + presenter_name + "</span><br>";
			msg += "<b>Email id: </b>" + presenter_email + "<br>";
			msg += "<b>Mobile: </b>" + presenter_mobile + "<br>";
			msg += "<b>City: </b><span id=''>" + presenter_city + "</span>&nbsp;&nbsp;&nbsp;";
			msg += "<b>Postal Code: </b><span id=''>" + presenter_pin + "</span><br>";
			msg += "<b>State: </b><span id=''>" + presenter_state + "</span>&nbsp;&nbsp;&nbsp;";
			msg += "<b>Country: </b><span id=''></span>" + presenter_country + "<br><hr>";

			// ===================== C0-AUTHOR DETAILS =====================
			var totalCoAuthor = $("#coAuthorCounts").val();
			var arrayValues = getArrayFieldValues();
			console.log($('#abstract_coauthor_email').val());
			if ($('#abstract_coauthor_email').val() != "" && $('#abstract_coauthor_first_name').val() != "" && $('#abstract_coauthor_last_name').val() != "") {
				// if (totalCoAuthor > 0) {
				// msg+='<div class="item">';
				msg += '<h4 style="text-align: center;">Co-Author Details</h4>';
				msg += '<div class="row">';
				var i = 1;
				var values = [];

				var myObj = {};
				var i = 1;
				var k = 0;
				$(".coauther_details").each(function() {
					var fieldValue = $(this).val();
					var usefor = $(this).attr('use');
					console.log("usefor= " + usefor);
					console.log("fieldValue= " + fieldValue);
					if ((k % 10 == 0 || k == 0) && fieldValue !== "") {
						msg += '<div class="col-md-12"><h5><b style="color:#f5eaf1;">Co-Author: ' + i + '</b></h5></div>';
					}
					if (fieldValue !== '') {
						console.log('key' + usefor + 'values=' + fieldValue);
						k++;
						console.log("k= " + k);
						myObj[usefor] = fieldValue;
						if (usefor == 'Country' || usefor == 'State') {
							var text = $(this).find("option:selected").text();
							msg += '<div class="col-md-6"><p><strong>' + usefor + ':</strong> ' + text + ' </p></div>';
						} else {
							msg += '<div class="col-md-6"><p><strong>' + usefor + ':</strong> ' + fieldValue + ' </p></div>';
						}
					}

					if (k % 10 == 0 && fieldValue !== '') {
						i++;
					}
				});

				msg += '</div>';
				msg += '</div><hr>';
				// console.log("msg= " + msg);
				// $('#previewData').html(preview);
			}

			// ===================== ABSTRACT DETAILS =====================
			msg += "<h4 style='text-align: center;'>Abstract Details</h4>";
			msg += "<strong>Category: </strong>" + absCatTitle + "<br>";
			if (abssubCatTitle) {
				msg += "<strong>Sub Category: </strong>" + abssubCatTitle + "<br>";
			}
			msg += "<strong>Topic: </strong>" + abstract_topic_id + "<br>";
			msg += "<strong>Abstract Title: </strong>" + $('#abstract_title').val() + "<br>";
			$('textarea[spreadingroup]').each(function() {
				// Get the value of the textarea
				var textareaValue = $(this).val();
				var displayName = $(this).attr('title');

				if (textareaValue != undefined && textareaValue != '' && displayName != undefined && displayName != '') {

					msg += "<strong>" + displayName + ":</strong><br>";
					msg += textareaValue + "<br>";

				}


				// console.log('title=' + displayName + 'val=' + textareaValue);
			});

			var consent_file_name = $('#original_consent_file_name').val();
			var abstract_file_name = $('#original_abstract_file_name').val();

			var tempConsentFileName = $("#temp_consent_filename").val();
			var tempAbstractFileName = $("#temp_abstract_filename").val();

			if (consent_file_name != "" && consent_file_name != undefined) {
				msg += "<hr><strong>Abstract File: </strong><a href='" + '<?= _BASE_URL_ ?>' + "uploads/FILES.ABSTRACT.REQUEST/TEMP/" + tempConsentFileName + "' download  style='background-color:#8f909142;border-radius: 20px;padding: 3px 8px;' >" + consent_file_name + "</a><br>";
			} else if ($("#inserted_abstract_consent_file").val() != undefined && $("#inserted_abstract_consent_file").val() != "") {
				var inserted_abstract_consent_file = $("#inserted_abstract_consent_file").val();
				var inserted_abstract_consent_filename_original = $("#inserted_abstract_consent_filename_original").val();
				msg += "<hr><strong>Abstract File: </strong><a href='" + '<?= _BASE_URL_ ?>' + "uploads/FILES.ABSTRACT.REQUEST/" + inserted_abstract_consent_file + "' download  style='background-color:#8f909142;border-radius: 20px;padding: 3px 8px;' >" + inserted_abstract_consent_filename_original + "</a><br>";

			}

			if (abstract_file_name != "" && abstract_file_name != undefined) {
				msg += "<hr><strong>Abstract File: </strong><a href='" + '<?= _BASE_URL_ ?>' + "uploads/FILES.ABSTRACT.REQUEST/TEMP/" + tempAbstractFileName + "' download style='background-color:#8f909142;border-radius: 20px;padding: 3px 8px;' >" + abstract_file_name + "</a><br>";
			} else if ($("#inserted_abstract_file").val() != undefined && $("#inserted_abstract_file").val() != "") {
				var inserted_abstract_file = $("#inserted_abstract_file").val();
				var inserted_abstract_filename_original = $("#inserted_abstract_filename_original").val();

				msg += "<hr><strong>Abstract File: </strong><a href='" + '<?= _BASE_URL_ ?>' + "uploads/FILES.ABSTRACT.REQUEST/" + inserted_abstract_file + "' download style='background-color:#8f909142;border-radius: 20px;padding: 3px 8px;' >" + inserted_abstract_filename_original + "</a><br>";
			}


			$('#details').append(msg);
			// $('#abstractData').html(msg);

			//alert(result[1]);
			$('#abstitle').text($('#abstract_title').val());
			$('#cat').text(absCatTitle);
			$('#subcat').text(abssubCatTitle);
			$('#topic').text(abstract_topic_id);

			if (absCatTitle != '' && abstract_topic_id != '' && msg != '') {
				$('#previewModal').show();
			}

		}



		function addCoauthor() {
			var coAuthorCounts = $('#coAuthorCounts').val();
			// alert(coAuthorCounts);
			if (coAuthorCounts == 0) { // X
				$('#accordion-body-coauthor').show();
				$('#coAuthorCounts').val(1);
				return;
			}
			var existingCoAuthor = $('#existingCoAuthorNum').val();
			// alert(existingCoAuthor);
			if (isNaN(existingCoAuthor)) {
				var accompanyCount = $('#coAuthorCounts').val();
				// alert('1')
				if (isNaN(Number(accompanyCount))) {
					accompanyCount = 0;
				}
				console.log("acc= " + accompanyCount);
				var incrementedCount = Number(accompanyCount) + 1;
				console.log("inc== " + incrementedCount);
				// alert(incrementedCount);
			} else {
				// alert('2')
				// var accompanyCount = $('#coAuthorCounts').val(); 
				var incrementedCount = Number(existingCoAuthor) + 1;
				console.log(incrementedCount);
				console.log("incElse== " + incrementedCount);
				$('#existingCoAuthorNum').val(incrementedCount);
				// alert(incrementedCount);
			}
			console.log("incrementedCount== " + incrementedCount);

			$('#coAuthorCounts').val(incrementedCount);
			if (incrementedCount == 1) {
				var accompanyCount = 1;
			} else {
				var accompanyCount = $('#coAuthorCounts').val();
				console.log("coAuthorCounts== " + accompanyCount);
			}

			$("#accompanyCount").val(incrementedCount);
			// $('#coCount').text(incrementedCount);

			var newAccompany = $(".add_coathor:first").clone();
			newAccompany.find("span#coCount").text(accompanyCount);
			newAccompany.find("input[type='email']").val(""); // Clear the input field
			newAccompany.find("input[type='text']").val(""); // Clear the input field
			newAccompany.find("input[type='radio']").prop("checked", false);
			newAccompany.find("select").val('');

			//$("#radioOption1").prop("checked", false);

			var fieldSerializeCount = Number(incrementedCount) - 1;

			//alert(fieldSerializeCount);
			newAccompany.find("input[id='abstract_coauthor_email']").attr("name", "abstract_coauthor_email[" + fieldSerializeCount + "]");
			newAccompany.find("input[id='abstract_coauthor_mobile']").attr("name", "abstract_coauthor_mobile[" + fieldSerializeCount + "]");
			newAccompany.find("input[id='abstract_coauthor_first_name']").attr("name", "abstract_coauthor_first_name[" + fieldSerializeCount + "]");
			newAccompany.find("input[id='abstract_coauthor_last_name']").attr("name", "abstract_coauthor_last_name[" + fieldSerializeCount + "]");
			newAccompany.find("input[id='abstract_coauthor_city']").attr("name", "abstract_coauthor_city[" + fieldSerializeCount + "]");
			newAccompany.find("input[id='abstract_coauthor_pincode']").attr("name", "abstract_coauthor_pincode[" + fieldSerializeCount + "]");

			newAccompany.find("select#abstract_coauthor_country").attr("name", "abstract_coauthor_country[" + fieldSerializeCount + "]");
			newAccompany.find("select#abstract_coauthor_state").attr("name", "abstract_coauthor_state[" + fieldSerializeCount + "]");

			newAccompany.find("input[type='text']").attr("countindex", fieldSerializeCount);
			newAccompany.find("input[type='radio']").attr("name", "abstract_coauthor_title[" + fieldSerializeCount + "]");

			newAccompany.find("input[type='radio'][name='abstract_coauthor_title[" + fieldSerializeCount + "]']").each(function(index, element) {

				var inputType = $(element).attr("type");
				var inputId = $(element).attr("id");
				//alert(inputId)
			});

			$("#accordion-body-coauthor").append(newAccompany);


			newAccompany.append('<button class="delete-coauthor-btn" count="' + accompanyCount + '">Delete</button>');

		}

		$("#add-coauthor-btn").on("click", function(e) {
			e.preventDefault();
			addCoauthor();
		});

		$("#accordion-body-coauthor").on("click", ".delete-coauthor-btn", function(e) {
			e.preventDefault();
			var nextElement = $(this).parent().next();
			var accompanyCount = $('#coAuthorCounts').val();
			if (accompanyCount == 1) {
				$(this).parent().hide();
			} else {
				$(this).parent().remove();
			}
			$('#coAuthorCounts').val(Number(accompanyCount) - 1);
			console.log("coAthrCountdel= " + accompanyCount - 1);

			$(this).find("span#coCount").text(Number(accompanyCount) - 1);

			while (nextElement.length > 0) {
				var count = nextElement.find("span#coCount").text();
				nextElement.find("span#coCount").text(count - 1);
				nextElement = nextElement.next();
			}

			var accompanyAmount = $('#accompanyAmount').val();

			var amountIncludedDay = parseFloat(accompanyAmount) * parseInt(Number(accompanyCount) - 1);
			//$('#accompanyAmount').val(amountIncludedDay);

			$("#accompanyCount").attr("amount", amountIncludedDay);
			$("#accompanyCount").val(Number(accompanyCount) - 1);
		});


		// First Author section button click function
		$('#firstAthrBtn').click(function() {
			// alert(1)
			var flag = 0;
			$("div[id='accordion-body-presenter']  input[type='text'], div[id='accordion-body-presenter'] input[type='date'], div[id='accordion-body-presenter'] input[type='radio']").each(function() {

				if ($(this).attr('type') === 'radio') {

					if (!$("input[type='radio'][name='abstract_presenter_title']:checked").length) {

						toastr.error('Please select the title', 'Error', {
							"progressBar": true,
							"timeOut": 5000,
							"showMethod": "slideDown",
							"hideMethod": "slideUp"
						});
						flag = 1;
						return false;
					}
				} else {

					var textBoxValue = $(this).val();
					if (textBoxValue === '') {
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
			console.log("flag= " + flag);
			if (flag == 0) {
				$('#collapseOne').removeClass('show');
				$('#coAuthorSection').show();
				$('#firstAthrBtn').hide();
				$('#firstBtn').show();
				//disable 1st section
				// $('#collapseOne :input, #collapseOne button').prop('disabled', true);
			}

		});

		$('#firstBtn').click(function() {
			//alert(12);
			var flag = 0;


			if (flag == 0) {
				$('#collapseOne').removeClass('show');
				$('#collapseTwo').addClass('show');
				//disable 1st section
				$('#collapseTwo :input, #collapseTwo button').prop('disabled', true);
				$('#collapseOne :input, #collapseOne button').prop('disabled', true);
				$('.author-fold-1').addClass('blur_bw');
				//enable second section
				$("input[name='abstract_category']").prop('disabled', false);
				$("input[name='abstract_parent_type']").prop('disabled', false);
				$('.author-fold-2').removeClass('blur_bw');

				//co-author validation
				// $("div[id='accordion-body-coauthor']  input[type='text'], div[id='accordion-body-coauthor'] input[type='date'], div[id='accordion-body-coauthor'] input[type='radio'], div[id='accordion-body-coauthor'] select").each(function() {
				// 	if($(this).attr('type')==='text')
				// 	{
				// 		var textBoxValue = $(this).val();
				// 		if (textBoxValue === '') 
				// 		{
				// 			toastr.error($(this).attr('validate'), 'Error', {
				// 			"progressBar": true,
				// 			"timeOut": 5000, 
				// 			"showMethod": "slideDown", 
				// 			"hideMethod": "slideUp"    
				// 			});


				// 			flag = 1;   
				// 		return false;   
				// 		}
				// 	}
				// 	else if($(this).attr('type')==='radio')
				// 	{
				// 		if (!$("input[name='" + $(this).attr('name') + "']:checked").length) 
				// 		{
				// 			toastr.error('Please select the title', 'Error', {
				// 			"progressBar": true,
				// 			"timeOut": 3000, // 3 seconds
				// 			"showMethod": "slideDown", // Animation method for showing
				// 			"hideMethod": "slideUp"    // Animation method for hiding
				// 			});

				// 			flag = 1;   
				// 			return false;
				// 		}
				// 	}
				// 	else if ($(this).is('select')) 
				// 	{
				// 	if ($.trim($(this).val()) == '') {

				// 		var msg = $(this).attr('validate');
				// 		toastr.error(msg, 'Error', {
				// 					"progressBar": true,
				// 					"timeOut": 3000, 
				// 					"showMethod": "slideDown", 
				// 					"hideMethod": "slideUp"    
				// 				});

				// 			flag = 1;   
				// 			return false;

				// 	}
				// }

				// });

			}
			if (flag == 0) {
				/*$('.author-details').removeClass("full-active");
				jQuery('.author-fold-2').addClass("full-active");*/

				var currentActive = $(".author-details.full-active");
				currentActive.removeClass("full-active");
				var previousElement = currentActive.next(".author-details");
				if (previousElement.length > 0) {
					previousElement.addClass("full-active");
					// previousElement.find(".next").show();
					//currentActive.find(".next").hide();
					// currentActive.find(".prev").hide();
				}
				$('#firstBtn').hide();
				$('#secondBtn').show();
				$('#secondBtnPrev').show();
			}
		});

		$('#secondBtn').click(function() {
			var flag = 0;

			$("div[id='abstract_details'] input[type='radio'], div[id='abstract_details'] select").each(function() {

				if ($(this).attr('type') === 'radio') {

					//alert($(this).attr('name'));

					if ($(this).attr('name') == 'abstract_category') {
						if (!$("input[name='" + $(this).attr('name') + "']:checked").length) {

							toastr.error('Please select category', 'Error', {
								"progressBar": true,
								"timeOut": 3000, // 3 seconds
								"showMethod": "slideDown", // Animation method for showing
								"hideMethod": "slideUp" // Animation method for hiding
							});

							flag = 1;
							return false;

						}
					}

					if ($(this).attr('name') == 'abstract_parent_type') {
						if (!$("input[name='" + $(this).attr('name') + "']:checked").length) {

							toastr.error('Please select submission sub category', 'Error', {
								"progressBar": true,
								"timeOut": 3000, // 3 seconds
								"showMethod": "slideDown", // Animation method for showing
								"hideMethod": "slideUp" // Animation method for hiding
							});

							flag = 1;
							return false;

						}
					}


				}
			});

			if (flag == 0) {
				//alert('succ');
				$('#secondBtn').hide();
				$('#secondBtnPrev').hide();
				$('#thirdBtn').show();
				$('#thirdBtnPrev').show();
				//enable third section
				$('#all_abstractDetails :input, #all_abstractDetails button').prop('disabled', false);
				$('.author-fold-3').removeClass('blur_bw');

				//disable second section
				$("input[name='abstract_category']").prop('disabled', true);
				$("input[name='abstract_parent_type']").prop('disabled', true);
				$('.author-fold-2').addClass('blur_bw');

				var currentActive = $(".author-details.full-active");
				currentActive.removeClass("full-active");
				var previousElement = currentActive.next(".author-details");
				if (previousElement.length > 0) {
					previousElement.addClass("full-active");

				}
			}
		});

		// after clicking any category radio button Find all radio buttons of sub category and remove their checked state
		// $('.trigger_subCategory').click(function() {
		// 	$("input[name='abstract_parent_type']").prop('checked', false);
		// });

		$('#thirdBtn').click(function() {

			var flag = 0;

			$("div[id='abstract_details_2'] input[type='radio'], div[id='abstract_details_2'] select, div[id='abstract_details_2'] textarea").each(function(index) {
				if ($(this).is('select')) {

					if ($.trim($(this).val()) == '') {

						var msg = $(this).attr('validate');
						toastr.error(msg, 'Error', {
							"progressBar": true,
							"timeOut": 3000,
							"showMethod": "slideDown",
							"hideMethod": "slideUp"
						});

						flag = 1;
						return false;

					}
				} else {

					if (!$(this).hasClass('hideitem')) {
						//alert(index);
						if ($.trim($(this).val()) == '') {

							var idVal = $(this).attr('id').split('_');;

							$('#collapseOne1' + idVal[1]).addClass('show');

							var msg = $(this).attr('validate');
							toastr.error(msg, 'Error', {
								"progressBar": true,
								"timeOut": 3000,
								"showMethod": "slideDown",
								"hideMethod": "slideUp"
							});

							flag = 1;
							return false;

						}
					}
				}


			});
			var totalWordEnteredTitle = $('[use="total_word_entered"]:first').text();
			var totalWordLimitTitle = $('[use="total_word_limit"]:first').text();
			var totalWordEnteredabstract = $('[use="total_word_entered"]:eq(1)').text();
			var totalWordLimitAbstract = $('[use="total_word_limit"]:eq(1)').text();
			console.log(totalWordLimitTitle + " , " + totalWordLimitAbstract);
			console.log(totalWordEnteredTitle + " , " + totalWordEnteredabstract);
			if (Number(totalWordEnteredTitle) > Number(totalWordLimitTitle)) {
				toastr.error('Title should be within ' + totalWordLimitTitle + ' words', 'Error', {
					"progressBar": true,
					"timeOut": 3000,
					"showMethod": "slideDown",
					"hideMethod": "slideUp"
				});
				flag = 1;
				return false;

			}
			if (Number(totalWordEnteredabstract) > Number(totalWordLimitAbstract)) {
				toastr.error('Abstract details should be within ' + totalWordLimitAbstract + ' words', 'Error', {
					"progressBar": true,
					"timeOut": 3000,
					"showMethod": "slideDown",
					"hideMethod": "slideUp"
				});
				flag = 1;
				return false;

			}

			if (flag == 0) {
				//alert('succ');
				$("input[name='abstract_category']").prop('disabled', false);
				$("input[name='abstract_parent_type']").prop('disabled', false);
				$('#collapseTwo :input, #collapseTwo button').prop('disabled', false);
				$('#collapseOne :input, #collapseOne button').prop('disabled', false);
				$("#abstractRequestForm").submit()
			}

		});

		//=========================== Third PREVIOUS button click function ==================================
		$('#thirdBtnPrev').click(function() {
			//disable third section
			$('#all_abstractDetails :input, #all_abstractDetails button').prop('disabled', true);
			$('.author-fold-3').addClass('blur_bw');
			//enable second section
			$("input[name='abstract_category']").prop('disabled', false);
			$("input[name='abstract_parent_type']").prop('disabled', false);
			$('.author-fold-2').removeClass('blur_bw');
			$('#secondBtn').show();
			$('#secondBtnPrev').show();
		})

		//=========================== second PREVIOUS next button click function ==================================
		$('#secondBtnPrev').click(function() {
			//enable 1st section
			$('#collapseTwo :input, #collapseTwo button').prop('disabled', false);
			$('#collapseOne :input, #collapseOne button').prop('disabled', false);
			$('.author-fold-1').removeClass('blur_bw');
			$('#firstBtn').show();
			$('#firstAthrBtn').hide();
			//disable second section
			$("input[name='abstract_category']").prop('disabled', true);
			$("input[name='abstract_parent_type']").prop('disabled', true);
			$('.author-fold-2').addClass('blur_bw');
		})

		function getTopicWiseNomination(obj) {
			var topic = $(obj).val();
			var topicId = topic.split('-')[0].trim(); // Extracts id before the first hyphen

			var catId = $('input[name="abstract_category"]:checked').val();
			// alert(catId);

			$.ajax({
				type: "POST",
				url: "abstract_request.process.php",
				data: {
					act: 'getNominationByTopic',
					catId: catId,
					topicId: topicId
				},

				async: false,
				success: function(JSONObject) {
					// alert(JSONObject)
					if (JSONObject) {
						var nominationIdsArray = JSON.parse(JSONObject);
						if (nominationIdsArray.length > 0) {
							for (let i = 0; i < nominationIdsArray.length; i++) {
								$('#accordianNomination').show();
								$('#nomination_holder_' + nominationIdsArray[i]).show();
								$('#nomination_holder_' + nominationIdsArray[i]).addClass('wasActive');
								$('#nomination_name_' + nomination_ids[i]).addClass('wasCheck');

							}
						} else {
							$('.wasCheck').prop('checked', false);
							$('.wasActive').hide();
							var ishidden = $('#accordianNomination').attr('ishidden');
							if (ishidden == 0) {
								$('#accordianNomination').hide();
							}

						}

					}


				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
				}
			});

		}


		function abstractTypeChange(obj, cat_id, fieldArr, nomination_ids) {


			if (nomination_ids) {
				$('#nomination_holder input[type="radio"]').prop('checked', false);
				for (var i = 0; i < nomination_ids.length; i += 2) {
					$('#accordianNomination').show();
					$('#accordianNomination').attr('ishidden', '1');
					// $('.wasCheck').prop('checked', false);
					$('.wasActive').hide();
					$('.catActive').hide();
					$('#nomination_holder_' + nomination_ids[i]).show();
					$('#nomination_holder_' + nomination_ids[i]).addClass('catActive');
					$('#nomination_name_' + nomination_ids[i]).addClass('wasCheck');
				}
			} else {
				$('#accordianNomination').hide();
				$('#accordianNomination').attr('ishidden', '0');

				$('.nomination_list').hide();
			}

			var submissionSubType = $(obj).val();
			prev_cat_id = <?= $Abs_cat_id ?>;
			if (cat_id != prev_cat_id) {
				// alert(prev_cat_id);
				$('#collapseTwo2 input[type="radio"]').prop('checked', false);
			}
			//alert(cat_id);
			fieldArr = fieldArr.split(",");

			$('.commn-absfields').hide();
			localStorage.setItem("subCat", submissionSubType);
			$('#abstract_description').addClass('hideitem');

			$('.hidesub').hide();
			$('.hideFieldVal').hide();



			//alert(submissionSubType);
			if (submissionSubType === "Free Paper") {

				$('.submissionTypeRadio' + cat_id).show();
				var submissionTypeContainer = $("li[use=leftAccordionSubmissionType]");
				$(submissionTypeContainer).find("input[type=radio]").prop("disabled", false);
				$(submissionTypeContainer).find("input[type=radio]").prop("checked", false);

				$('.abs-submission-type').show();
				$('.abs-sub-submission-type').show();


				$('#upload_abstract_file').parent().show();
				$('#upload_abstract_file').addClass('hideitem')


			}

			if (submissionSubType === "Poster Presentation") {
				$('#topicDetails').hide();
			} else {

				//alert(cat_id);
				$('#absCatTitle').val($(obj).attr('title'));
				$('.commn').addClass('hideitem');
				$('.submissionTypeRadio' + cat_id).show();
				$('#collapseTwo2').addClass('show');
				$('#wordCountList').show();
				var submissionTypeContainer = $("div[class=accordion-body]");
				$(submissionTypeContainer).find("input[type=radio]").prop("disabled", false);
				//$(submissionTypeContainer).find("input[type=radio]").prop("checked",false);

				$('.abs-submission-type').show();
				$('.abs-sub-submission-type').show();

				//disableAllFileds($("li[use=abstractPresenterDetails]"));

				$('#upload_abstract_file').parent().show();
				$('#upload_abstract_file').removeClass('hideitem')


				localStorage.setItem("subSType", '');
				localStorage.setItem("subType", '');

				$('#topicDetails').show();


				for (var i = 0; i < fieldArr.length; i++) {

					//alert(fieldArr[i]);
					$('#fields_' + fieldArr[i]).show();
					$('#fieldVal_' + fieldArr[i]).removeClass("hideitem");
				}
			}

			// if (submissionSubType !== '' && cat_id != prev_cat_id) {
			if (cat_id != '') {


				$.ajax({
					type: "POST",
					url: "abstract_request.process.php",
					data: {
						action: 'generateTopic',
						topic: cat_id
					},
					dataType: "html",
					async: false,
					success: function(JSONObject) {
						if (JSONObject) {
							if (JSONObject.trim() == 'empty') {
								$('#topicDetails').hide();
								//document.getElementById("abstract_topic_id").required = false;
								$('#abstract_topic_id').html("")
								$('#abstract_topic_id').attr('required', false);
							} else {
								$('#topicDetails').show();
								$('#abstract_topic_id').html(JSONObject)
							}
						}


					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
					}
				});

				var submission_id = $('input[name="abstract_parent_type"]:checked').val();

				if (submission_id != '' && cat_id != '') {
					$.ajax({
						type: "POST",
						url: "abstract_request.process.php",
						data: {
							action: 'generateCatSubTopic',
							cat_id: cat_id,
							submission_id: submission_id
						},
						dataType: "html",
						async: false,
						success: function(JSONObject) {
							if (JSONObject.trim() == 'empty') {
								$('#topicDetails').hide();
								//document.getElementById("abstract_topic_id").required = false;
								$('#abstract_topic_id').attr('required', false);
							} else {
								$('#topicDetails').show();
								$('#abstract_topic_id').html(JSONObject)
							}

						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
						}
					});
				} else {
					$.ajax({
						type: "POST",
						url: "abstract_request.process.php",
						data: {
							action: 'checkSubCat',
							cat_id: cat_id,
							delegateId: '<?php echo $delegateId; ?>'
						},
						dataType: "html",
						async: false,
						success: function(JSONObject) {
							if (JSONObject) {

							}


						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
						}
					});
				}


			}
		}

		function abstractSubmissionType(obj, cat_id, submission_id) {
			var submissionType = $(obj).val();
			// set data in localstorage
			localStorage.setItem("subType", submissionType);
			//alert('cat='+cat_id+'sub='+submission_id+'submissionType='+submissionType);
			//$('.hidesub').hide();
			//$('.hideFieldVal').hide();

			if (cat_id != '' && submission_id != '') {
				$('#abssubCatTitle').val($(obj).attr('title'));
				$.ajax({
					type: "POST",
					url: "abstract_request.process.php",
					data: {
						action: 'generateCatSubTopic',
						cat_id: cat_id,
						submission_id: submission_id
					},
					dataType: "html",
					async: false,
					success: function(JSONObject) {
						if (JSONObject.trim() == 'empty') {
							$('#topicDetails').hide();
							//document.getElementById("abstract_topic_id").required = false;
							$('#abstract_topic_id').attr('required', false);
						} else {
							$('#topicDetails').show();
							$('#abstract_topic_id').html(JSONObject);
						}

					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(jqXHR + '--' + textStatus + '--' + errorThrown)
					}
				});
			}
		}

		function truncateWords(str, no_words) {
			//return str.split(" ").splice(0,no_words).join(" ");
			const words = str.split(' ');

			if (no_words >= words.length) {
				return str;
			}

			const truncated = words.slice(0, no_words);
			return `${truncated.join(' ')}`;
		}


		function truncateCharacters(str, no_words) {
			//return str.split(" ").splice(0,no_words).join(" ");
			const words = str.length;

			if (no_words >= words.length) {
				console.log('str=' + str);
				return str;
			}

			//const truncated = words.slice(0, no_words);
			//return `${truncated.join(' ')}`;
		}

		function countWords(stringValue) {
			//console.log("Length="+stringValue.length);
			s = stringValue;
			s = s.replace(/(^\s*)|(\s*$)/gi, "");
			s = s.replace(/[ ]{2,}/gi, " ");
			s = s.replace(/\n /, "\n");

			return s.split(' ').length;
		}

		function wordLimitCounter(obj) {
			var totalWordCount = 0;
			var totalCharacterCount = 0;
			var parent = $("div[use=abstractDetails]");
			var wordCount = parseInt($(obj).attr("wordcount"));

			var group = $(obj).attr("spreadInGroup");
			var showWordCount = $(parent).find("span[use='" + $(obj).attr("displayText") + "']");
			var wordLimit = parseInt($(showWordCount).attr('limit'));
			var count = wordLimit;
			var totalCharacter = '';

			var word_type = '<?= $cfg['ABSTRACT.TOTAL.WORD.TYPE'] ?>';

			//console.log(count);
			$(parent).find("textarea[spreadInGroup='" + group + "']").each(function() {
				if ($(this).val() != "") {

					totalWordCount = parseInt(totalWordCount) + parseInt(countWords($(this).val()));
					totalCharacterCount = parseInt(totalCharacterCount) + parseInt($(this).val().length);

					if ($("textarea[spreadInGroup='" + group + "']").length > 1) {

						count = wordLimit - totalWordCount

						countCharacter = parseInt(wordLimit) - parseInt(totalCharacterCount);

						totalCharacter += $(this).val();

						//console.log('countCharacter='+countCharacter);

					}

					if (word_type == 'word') {
						if (totalWordCount > wordLimit) {
							// prevent max word
							//$(obj).val(truncateWords($.trim($(obj).val()),wordLimit));
							$(showWordCount).css("color", "#D41000");
							// $(this).val(truncateWords($.trim($(this).val()), count));
						} else {
							$(showWordCount).css("color", "");
						}
					} else {
						if (totalCharacterCount > wordLimit) {
							console.log(1212);
							console.log('totalCharacter=' + totalCharacterCount + 'wordLimit=' + wordLimit);

							$(showWordCount).css("color", "#D41000");
							//$(this).val(truncateCharacters($.trim($(this).val()),countCharacter));
							if ($(this).val().length >= wordLimit) {
								$(this).val($(this).val().substring($(this).val(), wordLimit));
							} else if (countCharacter < wordLimit) {

								$(this).val($(this).val().substring(0, countCharacter));
								//$(this).val("");
							} else {
								//alert(2);
								$(this).val("");
							}

						} else {
							$(showWordCount).css("color", "");
						}
					}


				}
			});

			$(showWordCount).find("span[use=total_word_entered]").text("");

			if (word_type == 'word') {

				$(showWordCount).find("span[use=total_word_entered]").text(totalWordCount);
			} else {
				$(showWordCount).find("span[use=total_word_entered]").text(totalCharacterCount);
			}



		}

		$("textarea[checkFor=wordCount]").keyup(function() {
			wordLimitCounter(this);
		});
		$("textarea[checkFor=wordCount]").blur(function() {
			wordLimitCounter(this);
		});

		$('#abstract_title').on('keyup', function() {
			console.log('abstarct=' + this.value.length);
			jQuery('#abstract_total_word_entered').text(this.value.length);
		});

		$(document).ready(function() {
			//$('.submissionTypeRadio').hide();	
			var catId = '<?= $resultAbstractTopic[0]['id'] ?>';

			$('.submissionTypeRadio' + catId).show();

			function uploadFile(file, dynamic_name_prefix, prevFile) {

				var formData = new FormData();
				formData.append('file', file);
				formData.append('dynamic_name_prefix', dynamic_name_prefix);
				formData.append('prevFile', prevFile);

				$.ajax({
					url: 'abstract.user.entrypoint.process.php',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						console.log("RES= " + response);
					},
					error: function(xhr, status, error) {
						console.error("Error: ", error);
					}
				});
			}

			function deleteTempFile(tempFile) {

				var formData = new FormData();
				formData.append('tempFile', tempFile);
				formData.append('delete', "1");

				$.ajax({
					url: 'abstract.user.entrypoint.process.php',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						console.log("RES= " + response);
					},
					error: function(xhr, status, error) {
						console.error("Error: ", error);
					}
				});
			}

			$('#formFileAbstract').on('change', function() {
				var file = this.files[0];
				flag = 0;
				if (file) {
					var fileSize = file.size; // in bytes
					var fileType = file.type;

					var validExtensions = new Array();
					var abstract_file_types = $('#abstract_file_types').val();
					if (abstract_file_types.includes("pdf")) {
						validExtensions.push("pdf");
					}
					if (abstract_file_types.includes("image")) {
						validExtensions.push("jpg");
						validExtensions.push("jpeg");
						validExtensions.push("png");
					}
					if (abstract_file_types.includes("word")) {
						validExtensions.push("doc");
						validExtensions.push("docx");
					}
					var jsonString = JSON.stringify(validExtensions).replace(/[\[\]"]/g, '');
					var fileTypeErr = "Only " + jsonString + " files are allowed";
					// var validExtensions = ["doc", "docx", "pdf"]
					var fileName = file.name.split('.').pop();

					console.log(fileName);

					if (fileSize > 5 * 1024 * 1024) {

						var prevFile = $('#temp_abstract_filename').val();
						if (prevFile != '') {
							deleteTempFile(prevFile);
						}
						$('#temp_abstract_filename').val('');
						$('#original_abstract_file_name').val('');
						$('#abstractFileNameUploaded').text('');

						toastr.error('File size exceeds 5MB limit.', 'Error', {
							"progressBar": true,
							"timeOut": 5000,
							"showMethod": "slideDown",
							"hideMethod": "slideUp"
						});
						this.value = ''; // Clear the file input
						flag = 1;
						return;
					}

					if (validExtensions.indexOf(fileName) == -1) {
						var prevFile = $('#temp_abstract_filename').val();
						if (prevFile != '') {
							deleteTempFile(prevFile);
						}
						$('#temp_abstract_filename').val('');
						$('#original_abstract_file_name').val('');
						$('#abstractFileNameUploaded').text('');

						toastr.error(fileTypeErr, 'Error', {
							"progressBar": true,
							"timeOut": 5000,
							"showMethod": "slideDown",
							"hideMethod": "slideUp"
						});


						this.value = '';
						flag = 1;
						return;
					}
					// File is valid
					$('#fileError').text('');
				} else {
					var prevFile = $('#temp_abstract_filename').val();
					if (prevFile != '') {
						deleteTempFile(prevFile);
					}
					$('#temp_abstract_filename').val('');
					$('#original_abstract_file_name').val('');
					$('#abstractFileNameUploaded').text('');
					toastr.error('Please select a file to upload.', 'Error', {
						"progressBar": true,
						"timeOut": 4000,
						"showMethod": "slideDown",
						"hideMethod": "slideUp"
					});

					flag = 1;
				}
				if (flag == 0) {

					var sessionId = $('#sessionId').val();
					var d = new Date();
					var uploadTime = d.getTime();
					var prevFile = $('#temp_abstract_filename').val();
					// createDynamicFileName
					var dynamicFileName = 'ABSTRACT_' + sessionId + uploadTime + '_' + file['name'];
					// alert(dynamicFileName);
					$('#temp_abstract_filename').val(dynamicFileName);
					$('#original_abstract_file_name').val(file['name']);
					$('#abstractFileNameUploaded').text(file['name']);
					uploadFile(file, 'ABSTRACT_' + sessionId + uploadTime, prevFile); // Upload the file
					toastr.success('File uploaded successfully.', 'Success', {
						"progressBar": true,
						"timeOut": 2000,
						"showMethod": "slideDown",
						"hideMethod": "slideUp"
					});

				}
			});

			$('#formFileHod').on('change', function() {
				var file = this.files[0];
				var flag = 0;
				if (file) {
					var fileSize = file.size; // in bytes
					var fileType = file.type;

					var validExtensions = new Array();

					var hod_consent_file_types = $('#hod_consent_file_types').val();
					if (hod_consent_file_types.includes("pdf")) {
						validExtensions.push("pdf");
					}
					if (hod_consent_file_types.includes("image")) {
						validExtensions.push("jpg");
						validExtensions.push("jpeg");
						validExtensions.push("png");
					}
					if (hod_consent_file_types.includes("word")) {
						validExtensions.push("doc");
						validExtensions.push("docx");
					}

					var jsonString = JSON.stringify(validExtensions).replace(/[\[\]"]/g, '');
					var fileTypeErr = "Only " + jsonString + " files are allowed";
					// var validExtensions = ["jpg", "pdf", "jpeg", "gif", "png", "pdf"]
					var fileName = file.name.split('.').pop();

					console.log(fileName);

					if (fileSize > 5 * 1024 * 1024) {
						var prevFile = $('#temp_consent_filename').val();
						if (prevFile != '') {
							deleteTempFile(prevFile);
						}
						$('#temp_consent_filename').val('');
						$('#original_consent_file_name').val('');
						$('#concentFileNameUploaded').text('');

						toastr.error('File size exceeds 5MB limit.', 'Error', {
							"progressBar": true,
							"timeOut": 3000,
							"showMethod": "slideDown",
							"hideMethod": "slideUp"
						});
						this.value = ''; // Clear the file input
						flag = 1;
						return;

					}
					if (validExtensions.indexOf(fileName) == -1) {
						var prevFile = $('#temp_consent_filename').val();
						if (prevFile != '') {
							deleteTempFile(prevFile);
						}
						$('#temp_consent_filename').val('');
						$('#original_consent_file_name').val('');
						$('#concentFileNameUploaded').text('');

						toastr.error(fileTypeErr, 'Error', {
							"progressBar": true,
							"timeOut": 4000,
							"showMethod": "slideDown",
							"hideMethod": "slideUp"
						});


						this.value = '';
						flag = 1;
						return;
					}
					// File is valid
					$('#fileError').text('');
				} else {
					var prevFile = $('#temp_consent_filename').val();
					if (prevFile != '') {
						deleteTempFile(prevFile);
					}
					$('#temp_consent_filename').val('');
					$('#original_consent_file_name').val('');
					$('#concentFileNameUploaded').text('');

					toastr.error('Please select a file to upload.', 'Error', {
						"progressBar": true,
						"timeOut": 4000,
						"showMethod": "slideDown",
						"hideMethod": "slideUp"
					});
					flag = 1;
				}
				console.log(flag);
				if (flag == 0) {
					var sessionId = $('#sessionId').val();
					var d = new Date();
					var uploadTime = d.getTime();
					var prevFile = $('#temp_consent_filename').val();
					// createDynamicFileName
					var dynamicFileName = 'CONSENT_' + sessionId + uploadTime + '_' + file['name'];
					// alert(dynamicFileName);
					$('#temp_consent_filename').val(dynamicFileName);
					$('#original_consent_file_name').val(file['name']);
					$('#concentFileNameUploaded').text(file['name']);
					uploadFile(file, 'CONSENT_' + sessionId + uploadTime, prevFile); // Upload the file

					toastr.success('File uploaded successfully.', 'Success', {
						"progressBar": true,
						"timeOut": 2000,
						"showMethod": "slideDown",
						"hideMethod": "slideUp"
					});
				}
			});

			// $('.author-details').removeClass('full-active');     
			// $('.author-fold-3').addClass('full-active');    
		});
	</script>

</body>

</html>