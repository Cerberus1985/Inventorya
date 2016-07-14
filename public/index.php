<?php

include '../core/core.php';
if (isset($_SESSION['loggin'])) {
    if ($_SESSION['loggin'] == 'true') {
        $smarty->display('index.tpl');
    }
} else {
    $smarty->display('login.tpl');
}
