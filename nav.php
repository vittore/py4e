<?php
$OUTPUT->bodyStart();
$R = $CFG->apphome . '/';
$T = $CFG->wwwroot . '/';
$adminmenu = isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true";
$set = new \Tsugi\UI\MenuSet();
$set->setHome($CFG->servicename, $CFG->apphome);
$set->addLeft('Iniziare', $R.'install');
$set->addLeft('Lezioni', $R.'lessons');
if ( isset($_SESSION['id']) ) {
    $set->addLeft('Compiti', $R.'assignments');
    // $set->addLeft('Discuss', $R.'group');
    // If both are set we go to discuss.php
    // if ( isset($CFG->disqushost) ) $set->addLeft('Discuss', $T.'discuss');
    // else if ( isset($CFG->disquschannel) ) $set->addLeft('Discuss', $CFG->disquschannel);
} else {
    $set->addLeft('Materiali', $R.'materials');
}

if ( isset($_SESSION['id']) ) {
    $submenu = new \Tsugi\UI\Menu();
    $submenu->addLink('Profilo', $R.'profile');
    if ( isset($CFG->google_map_api_key) ) {
        $submenu->addLink('Mappa', $R.'map');
    }

    $submenu->addLink('Badge', $R.'badges');
    $submenu->addLink('Materiali', $R.'materials');
    if ( $CFG->providekeys ) {
        $submenu->addLink('Integrazioni con LMS', $T . 'settings');
    }
    if ( isset($CFG->google_classroom_secret) ) {
        $submenu->addLink('Google Classroom', $T.'gclass/login');
    }
    $submenu->addLink('App Store gratuito', 'https://www.tsugicloud.org');
    $submenu->addLink('Valuta questo corso', 'https://www.class-central.com/mooc/7363/python-for-everybody');
    $submenu->addLink('Privacy', $R.'privacy');
    if ( isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true" ) {
        $submenu->addLink('Amministra', $T . 'admin/');
    }
    $submenu->addLink('Esci', $R.'logout');

    if ( isset($_SESSION['avatar']) ) {
        $set->addRight('<img src="'.$_SESSION['avatar'].'" style="height: 2em;"/>', $submenu);
        // htmlentities($_SESSION['displayname']), $submenu);
    } else {
        $set->addRight(htmlentities($_SESSION['displayname']), $submenu);
    }
} else {
    $set->addRight('Accedi', $R.'login');
}

$imenu = new \Tsugi\UI\Menu();

$imenu->addLink('Insegnante', 'http://www.dr-chuck.com');
$imenu->addLink('Office Hours', 'http://www.dr-chuck.com/office/');
$set->addRight('Libro', $R . 'book');
$set->addRight('Insegnante', $imenu);

// Set the topNav for the session
$OUTPUT->topNavSession($set);

$OUTPUT->topNav();
$OUTPUT->flashMessages();
