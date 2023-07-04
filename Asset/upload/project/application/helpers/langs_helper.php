<?php
function LoadLang(){
    switch ($_SESSION['language']) {
    case 'English':
        include_once APPPATH. "language/english.php";
        break;
    case 'العربية':
        include_once APPPATH. "language/arabic.php";
        break;
    default:
        $_SESSION['language'] = "العربية";
        include_once APPPATH. "language/arabic.php";
        break;
    }
}
?>
