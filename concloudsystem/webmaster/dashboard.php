<?php 
include_once("includes/source.php");
include_once('includes/init.php');
include_once('includes/function.workshop.php');
?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>Dashboard</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>
    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav class="dashboard_nav">Natcon 2025 • Command Center</nav>
                <h2 class="dashboard_head">System Health Overview</h2>
                <div class="dashboard_date">
                    <div class="display-date">
                        <span id="day">day</span>,
                        <span id="daynum">00</span>
                        <span id="month">month</span>
                        <span id="year">0000</span>
                    </div>
                    • <span class="text_success">142 Desk Active</span>
                </div>
            </div>
            <div class="page_top_wrap_right">
                <div class="dashboard_time">
                    <?php clock() ?>
                    <div class="display-time"></div>
                </div>
                <a href="#" class="badge_default"><?php add() ?>New Entry</a>
            </div>
        </div>

        <div class="form_grid dash_grid g_3">
            <div class="dash_top span_3">
                <div class="dash_top_left">
                    <h5>Mission Revenue</h5>
                    <h2>₹ 0.33L</h2>
                    <h6><span class="badge_success">+12% Target</span>Real-time gateway sync</h6>
                </div>
                <div class="dash_top_right">
                    <div class="dash_top_right_box">
                        <h6>Registration</h6>
                        <h4>₹ 0.23L</h4>
                        <div class="progress-bar-wrap">
                            <div class="progress">
                                <div class="progress-done bg_info" data-progress="20"></div>
                            </div>
                        </div>
                    </div>
                    <div class="dash_top_right_box">
                        <h6>Registration</h6>
                        <h4>₹ 0.23L</h4>
                        <div class="progress-bar-wrap">
                            <div class="progress">
                                <div class="progress-done bg_info" data-progress="20"></div>
                            </div>
                        </div>
                    </div>
                    <div class="dash_top_right_box">
                        <h6>Registration</h6>
                        <h4>₹ 0.23L</h4>
                        <div class="progress-bar-wrap">
                            <div class="progress">
                                <div class="progress-done bg_info" data-progress="20"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dash_mid span_3">
                <ul class="regi_data_grid_ul accm_data_grid_ul">
                    <a href="#">
                        <li>
                            <div class="dash_mid_top">
                                <span class="badge_primary"><?php user() ?></span>
                                <h4>Registration</h4>
                            </div>
                            <ol>
                                <li class="text_primary"><i>Total</i>200</li>
                                <li><i>Unpaid</i>200</li>
                                <li><i>Comp</i>200</li>
                            </ol>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <div class="dash_mid_top">
                                <span class="badge_info"><?php workshop() ?></span>
                                <h4>Workshop Registration</h4>
                            </div>
                            <ol>
                                <li class="text_info"><i>Total</i>200</li>
                                <li><i>Unpaid</i>200</li>
                                <li><i>Comp</i>200</li>
                            </ol>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <div class="dash_mid_top">
                                <span class="badge_secondary"><?php duser() ?></span>
                                <h4>Accompanying Person</h4>
                            </div>
                            <ol>
                                <li class="text_secondary"><i>Total</i>200</li>
                                <li><i>Unpaid</i>200</li>
                                <li><i>Comp</i>200</li>
                            </ol>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <div class="dash_mid_top">
                                <span class="badge_danger"><?php hotel() ?></span>
                                <h4>Accommodation</h4>
                            </div>
                            <ol>
                                <li class="text_danger"><i>Total</i>200</li>
                                <li><i>Unpaid</i>200</li>
                                <li><i>Comp</i>200</li>
                            </ol>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <div class="dash_mid_top">
                                <span class="badge_default"><?php exibitor() ?></span>
                                <h4>Exhibitor Stalls</h4>
                            </div>
                            <ol>
                                <li class="text_deafult"><i>Total</i>200</li>
                                <li><i>Unpaid</i>200</li>
                                <li><i>Comp</i>200</li>
                            </ol>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <div class="dash_mid_top">
                                <span class="badge_dark"><?php duser() ?></span>
                                <h4>Abstract</h4>
                            </div>
                            <ol>
                                <li class="text_dark"><i>Total</i>200</li>
                                <li><i>Unpaid</i>200</li>
                                <li><i>Comp</i>200</li>
                            </ol>
                        </li>
                    </a>
                </ul>
            </div>
            <div class="dash_left span_2">
                <div class="form_grid dash_grid g_2">
                    <a href="#" class="shrtcut badge_primary shrtcut_hover">
                        <span class="badge_primary"><?php printi() ?></span>
                        <p>ID Card Printing
                            <n class="text_dark">Bulk Badge Management</n>
                        </p>
                    </a>
                    <a href="#" class="shrtcut badge_secondary shrtcut_hover">
                        <span class="badge_secondary"><?php printi() ?></span>
                        <p>ID Card Printing
                            <n class="text_dark">Bulk Badge Management</n>
                        </p>
                    </a>


                    <div class="wrkshp_status span_2">
                        <h4 class="dash_head">Current Scientific Session</h4>
                        <div class="form_grid dash_grid g_2 wrkshp_status_wrap">
                            <div class="wrkshp_status_box">
                                <h6>Hall A • Main Auditorium</h6>
                                <h4>TB Management in 2025</h4>
                                <h5>Speaker: Dr. Rajesh K<span class='timer'></span></h5>
                                <div class="timerbar">
                                    <div class="bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dash_right span_1">
                <div class="monitor_right w-100">
                    <h5 class="monitor_right_head">Live Activity Feed<span>Real-time</span></h5>
                    <ul>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_info"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                        <li>
                            <span class="badge_success"><i class="fal fa-print"></i></span>
                            <p>Badge Printed for Dr. Asim Majumdar<b><i class="fal fa-clock"></i>10:42 AM • System</b></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/popup.php"); ?>
</body>
<?php include_once("includes/js-source.php"); ?>
<script>
    function timer(timeleft, timetotal, $element) {
        var progressBarWidth = timeleft * $element.width() / timetotal;
        $element.find('div.bar').animate({
            width: progressBarWidth
        }, timeleft == timetotal ? 0 : 1000, "linear");
        if (timeleft > 0) {
            setTimeout(function() {
                timer(timeleft - 1, timetotal, $element);
            }, 1000);
        }
        var date = new Date(null);
        date.setSeconds(timeleft);
        var timeString = date.toISOString().substr(11, 8);
        var newtimeleft = timeString

        $('.timer').text(newtimeleft)
    };

    timer(3600, 3600, $('.timerbar'));
    const displayTime = document.querySelector(".display-time");
    // Time
    function showTime() {
        let time = new Date();
        displayTime.innerText = time.toLocaleTimeString("en-US", {
            hour12: false
        });
        setTimeout(showTime, 1000);
    }

    showTime();

    // Date
    function updateDate() {
        let today = new Date();

        // return number
        let dayName = today.getDay(),
            dayNum = today.getDate(),
            month = today.getMonth(),
            year = today.getFullYear();

        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];
        const dayWeek = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ];
        // value -> ID of the html element
        const IDCollection = ["day", "daynum", "month", "year"];
        // return value array with number as a index
        const val = [dayWeek[dayName], dayNum, months[month], year];
        for (let i = 0; i < IDCollection.length; i++) {
            document.getElementById(IDCollection[i]).firstChild.nodeValue = val[i];
        }
    }

    updateDate();
</script>

</html>