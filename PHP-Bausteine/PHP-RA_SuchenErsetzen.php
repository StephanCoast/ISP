<?php
 /**
  * Kleines Script zum Testen von Regulaeren Ausdruecken in PHP
  *
  * @author Thorsten 'stepotronic' Hallwas
  * @copyright 2009 Thorsten 'stepotronic' Hallwas
  */

 //Formulardaten einlesen
 $subject     = (empty($_POST['subject'])     ? ''    : $_POST['subject']);
 $pattern     = (empty($_POST['pattern'])     ? ''    : $_POST['pattern']);
 $replacement = (empty($_POST['replacement']) ? ''    : $_POST['replacement']);
 $replace     = (empty($_POST['replace'])     ? false : true);
 $all         = (empty($_POST['all'])         ? false : true);
 if (get_magic_quotes_gpc())
 {
   $subject     = stripslashes($subject);
   $pattern     = stripslashes($pattern);
   $replacement = stripslashes($replacement);

 }
 //formular auswerten
 if (strlen($subject) && strlen($pattern)) {
   $message = "Kein Treffer!";

   if ($replace) {
     $replacement = (empty($_POST['replacement']) ? '' : $_POST['replacement']);
     $newSubject = preg_replace($pattern, $replacement, $subject, ($all ? -1 : 1), $count);
     $message = "{$count} Ersetzungen vorgenommen. Neuer String:<br><pre>{$newSubject}</pre>";
   } else {
     if ($all) {
       $result = preg_match_all($pattern, $subject, $matches);
       if ($error === false) {
         $message = "Fehlerhafte Ausdr&uuml;cke";
       } else {
         $message = "Gesamt: {$result}";
         $message .= "<br>Treffer als print_r:
 <pre>".print_r($matches, true)."</pre>";
       }
     } else {
       $result = preg_match($pattern, $subject, $matches);
       if ($result === null) {
         $message = "Fehlerhafte Ausdr&uuml;cke";
       } else {
         $message = "Treffer: ".$matches[0];
       }
     }
   }
 }

 print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
 <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
     \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
 <html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"de\" xml:lang=\"de\">
 <head>
 <title>Testen Regul&auml;rer Ausdr&uuml;cke</title>
 <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
 </head>
 <body style=\"font-family:\'Tahoma\',Verdana,sans-serif\">
 <h3>Bitte geben Sie hier Ihren regul&auml;ren Ausdruck ein!</h3>
 <form method=\"post\" enctype =\"multipart/form-data\" action=\"?\">
 <table cellspacing=\"3\" cellpadding=\"5\">
 <tr>
 <td>Zu testender String:</td>
 <td><textarea name=\"subject\" cols=\"50\" rows=\"5\">{$subject}</textarea></td>
 </tr>
 <tr>
 <td>Regul&auml;rer Ausdruck:</td>
 <td><input type=\"text\" name=\"pattern\" size=\"50\" value=\"{$pattern}\" /></td>
 </tr>
 <tr>
 <td>Ersatz:</td>
 <td><input type=\"checkbox\" name=\"replace\"".($replace ? " checked=\"checked\"" : "")." />Ersetzen<br />
 <input type=\"text\" name=\"replacement\" size=\"50\" value=\"{$replacement}\" />
 </td>
 </tr>
 <tr>
 <td colspan=\"2\"><input type=\"checkbox\" name=\"all\"".($all ? " checked=\"checked\"" : "")." />Alle Treffer</td>
 </tr>
 <tr>
 <td><input type=\"submit\" value=\"Anwenden\" /></td>
 <td><input type=\"reset\" value=\"Zur&uuml;cksetzen\" /></td>
 </tr>
 </table>
 <p>{$message}</p>
 </form>
 </body>
 </html>";
 ?>