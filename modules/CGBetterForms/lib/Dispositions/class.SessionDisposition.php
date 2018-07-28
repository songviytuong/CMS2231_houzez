<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class SessionDisposition extends Disposition
{
    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $resp)
    {
        // yep, it's that trivial.
        $_SESSION[$form->name] = $resp;
    }

} // end of class
