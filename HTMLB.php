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


    public static function closeForm($label)
    {
        echo "<input type=\"submit\" value=\"$label\">
          </form>";
    }

    public static function writeFooter()
    {
        echo "</body></html>";
    }

}