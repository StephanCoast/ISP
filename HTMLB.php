<?php


class HTMLB
{

    //HTML-Bausteine

    public static function writeHeader()
    {
        echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Wocheneinteilung</title>
          </head>
          <body>";
    }

    public static function writeHeadline($headline)
    {
        echo "<h1>$headline</h1>";
    }

    public static function startForm($method, $url)
    {
        echo "<form method=\"$method\" action=\"$url\">";
    }

    public static function closeForm($label)
    {
        echo "<input type=\"submit\" value=\"$label\">
          </form>";
    }


    public static function writeInputField($text, $name, $typ)

    {
        echo "<label for=\"$name\">$text: </label>
          <input type=\"$typ\" name=\"$name\" id=\"$name\">";
    }

    //SELECT-ELEMENT VARIABEL FÜLLEN

    public static function openselectElement($name) {

        echo "<select name=\"$name\">";
    }

    public static function fillselectElement($value, $text) {

        echo "<option value=\"$value\">$text</option>";
    }

    public static function closeselectElement() {

        echo "</select>";
    }

    //TABELLE KONSTRUIEREN

    public static function responsiveTable($mitarbeiter, $von, $bis) {


        echo "<div style=\"overflow-x:auto;\">
                <table>
              <tr>
                <th>Mitarbeiter</th>
                <th>Datum</th>
              </tr>";


        for ($i=0; $i<count($mitarbeiter); $i++) {
            $nameMA = $mitarbeiter[$i]['nachname'] . ", " . $mitarbeiter[$i]['vorname'];

            echo  " <tr>
                <td>$nameMA</td>
                <td>Event1</td>
              </tr>";
        }


        echo   "</table>
            </div> ";
    }


    public static function addLinkButton($text, $name, $link) {

        echo "<input type=button onClick=\"parent.location='$link'\" name=\"$name\" value=\"$text\">";
    }

    public static function writeFooter()
    {
        echo "</body></html>";
    }

}