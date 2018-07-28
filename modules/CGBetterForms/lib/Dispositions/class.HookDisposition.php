<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class HookDisposition extends Disposition
{
    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response )
    {
        \CMSMS\HookManager::do_hook('CGBetterForms::dispose', $response );
    }
} // end of class
