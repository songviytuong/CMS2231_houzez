<?php



   if (! $this->CheckPermission("ErrorLogger_View")) {
      echo '<h3>'.$this->Lang('accessdenied').'</h3>';
      return false;
   }

   echo '<h2>Testmode</h2>';

   echo '<p>'.PHP_EOL;
   echo '<ul>'.PHP_EOL;
   echo '<li>trigger_error(E_NOTICE)</li>'.PHP_EOL;
   #trigger_error($this->GetName().' - Testmessage for a notice', E_NOTICE);
   trigger_error($this->GetName().' - Testmessage for a notice', E_USER_NOTICE);
   echo '<li>trigger_error(E_WARNING)</li>'.PHP_EOL;
   #trigger_error($this->GetName().' - Testmessage for a warning', E_WARNING);
   trigger_error($this->GetName().' - Testmessage for a user warning', E_USER_WARNING);
   echo '<li>trigger_error(E_ERROR)</li>'.PHP_EOL;
   #trigger_error($this->GetName().' - Testmessage for an error', E_ERROR);
   trigger_error($this->GetName().' - Testmessage for an user error', E_USER_ERROR);
   #echo '<li>throw Exception</li>'.PHP_EOL;
   #throw new Exception($this->GetName().' - Testmessage for an Exception');
   echo '</ul>'.PHP_EOL;
   echo '</p>'.PHP_EOL;

   echo '<hr />'.$this->CreateLink($id, 'defaultadmin', '', ' &laquo; go back to list');
   echo '<p>&nbsp;</p>';

?>