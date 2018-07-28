<?php

if (!isset($gCms))
    exit;

if (!$this->CheckAccess('manage translator_mle')) {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
}

if (mle_tools::is_ajax() && $_POST['aAction'] == 'SetDefaultMle')
    Translation::setDefaultMle($_POST);

exit;
?>