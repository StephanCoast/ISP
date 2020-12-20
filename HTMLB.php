<?php


class HTMLB
{

    //HTML-Bausteine

    public function writeHeader()
    {
        echo "<!DOCTYPE html>
          <html lang=\"de\">
          <head><title>Wocheneinteilung</title>
          </head>
          <body>";
    }

    public function writeHeadline($headline)
    {
        echo "<h1>$headline</h1>";
    }

    public function startForm($method, $url)
    {
        echo "<form method=\"$method\" action=\"$url\">";
    }

    public function closeForm($label)
    {
        echo "<input type=\"submit\" value=\"$label\">
          </form>";
    }


    public function writeInputField($text, $name, $typ)

    {
        echo "<label for=\"$name\">$text: </label>
          <input type=\"$typ\" name=\"$name\" id=\"$name\">";
    }

    //SELECT-ELEMENT VARIABEL FÜLLEN

    public function openselectElement($name) {

        echo "<select name=\"$name\">";
    }

    public function fillselectElement($value, $text) {

        echo "<option value=\"$value\">$text</option>";
    }

    public function closeselectElement() {

        echo "</select>";
    }

    //TABELLE KONSTRUIEREN

    public function responsiveTable($mitarbeiter, $von, $bis) {


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


    public function addLinkButton($text, $name, $link) {

        echo "<input type=button onClick=\"parent.location='$link'\" name=\"$name\" value=\"$text\">";
    }

    public function writeFooter()
    {
        echo "</body></html>";
    }

}