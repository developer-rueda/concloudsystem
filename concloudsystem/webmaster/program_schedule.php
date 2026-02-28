<?php include_once("includes/source.php"); ?>

<body>
    <?php include_once("includes/left-menu.php"); ?>
    <header>
        <h2>General Registration</h2>
        <?php include_once("includes/header_right.php"); ?>
    </header>

    <div class="body_wrap">
        <div class="page_top_wrap mb-3">
            <div class="page_top_wrap_left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Scientific Program</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Program Schedule</li>
                    </ol>
                </nav>
                <h2>Program Schedule</h2>
                <h6>Manage conference sessions and speakers.</h6>
            </div>
        </div>
        <div class="regi_search_wrap mb-3">
            <div class="tracking_analytic_tab">
                <button data-tab="date1" class="active">Thu, Dec 18</button>
                <button data-tab="date2">Fri, Dec 19</button>
                <button data-tab="date3">Sat, Dec 20</button>
                <button data-tab="date4">Sun, Dec 21</button>
            </div>
            <div class="regi_search_wrap_btn_box">
                <a href="javascript:void(null)" data-tab="newsession" class="popup-btn add"><?php add(); ?>New Session</a>
            </div>
        </div>
        <div class="tracking_analytic_box active" id="date1">
            <div class="pg_shdl_wrap">
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall B</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--secondary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_secondary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--info2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_info2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall C</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--success2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_success">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--danger2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_danger">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tracking_analytic_box" id="date2">
              <div class="pg_shdl_wrap">
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall B</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--secondary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_secondary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--info2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_info2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall C</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--success2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_success">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--danger2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_danger">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tracking_analytic_box" id="date3">
              <div class="pg_shdl_wrap">
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall B</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--secondary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_secondary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--info2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_info2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall C</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--success2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_success">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--danger2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_danger">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tracking_analytic_box" id="date4">
              <div class="pg_shdl_wrap">
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall B</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--secondary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_secondary">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--info2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_info2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pg_shdl_box">
                    <h5 class="pg_shdl_box_head ">
                        <g class="mi-1"><?php address() ?>Hall C</g>
                    </h5>
                    <ul>
                        <li style="border-left-color: var(--success2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_success">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--danger2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_danger">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li style="border-left-color: var(--primary2)">
                            <div class="pg_shdl_time">
                                <?php clock() ?><p><span>09:00</span><span>-</span><span>10:00</span></p>
                            </div>
                            <div class="pg_shdl_details">
                                <span class="badge_padding badge_primary2">Session</span>
                                <div class="regi_name">AIRWAYS</div>
                                <div class="regi_contact">
                                    <span>
                                        <?php user() ?>Dr. Asim Kumar Majumdar
                                    </span>
                                </div>
                            </div>
                            <div class="pg_shdl_action">
                                <button>3 Talks<?php down() ?></button>
                                <div class="action_div action">
                                    <a href="javascript:void(null)" data-tab="editsession" class="icon_hover badge_secondary br-5 w-auto action-transparent popup-btn"><?php edit() ?></a>
                                    <a href="javascript:void(null)" class="icon_hover badge_danger br-5 w-auto action-transparent"><?php delete() ?></a>
                                </div>
                            </div>

                            <div class="pg_shdl_tals_wrap">
                                <div class="pg_shdl_talk_box">
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                    <p>
                                        <n>15m</n>
                                        <g>The noise of the silent zone in lungs<span>Dr. A. Kumar</span></g>
                                    </p>
                                </div>
                            </div>
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
    
    $('.pg_shdl_action button').click(function() {
        if ($(this).hasClass("active")) {
            $(".pg_shdl_action button").removeClass('active');
            $(".pg_shdl_box ul li").removeClass('active');
            $(".pg_shdl_tals_wrap").slideUp();
        } else {
            $(".pg_shdl_action button").removeClass('active');
            $(".pg_shdl_box ul li").removeClass('active');
            $(".pg_shdl_tals_wrap").slideUp();
            $(this).parent().parent('li').toggleClass('active');
            $(this).parent().parent().find('.pg_shdl_tals_wrap').slideToggle();
            $(this).toggleClass('active');

        }
    });
</script>

</html>