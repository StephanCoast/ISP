<?php


class HTMLB
{

    //HTML-Bausteine

    public function writeHeader()
    {
        echo "<!DOCTYPE html>
          <html lang=\"de\">
            <head><title>Wocheneinteilung</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                <style>
                    table {
                        border-collapse: collapse;
                        border-spacing: 0;
                        width: 100%;
                        border: 1px solid #ddd;
                    }
            
                    th, td {
                        text-align: left;
                        padding: 8px;
                    }
            
                    tr:nth-child(even){background-color: #f2f2f2}
                </style>
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

    public function responsiveTable($mitarbeiter, $von, $bis)
    {
        $j = 0;
        echo "<div style=\"overflow-x:auto;\">
                <table id='wocheneinteilung'>
              <tr>
                <th>Nachname</th>
                <th>Vorname</th>";


            for ($date=$von; $date<=$bis; $date++) {
                echo "<th>$date</th>";
            }

            echo  "</tr>";


            for ($i = 1; $i <= count($mitarbeiter); $i++) {
                $nachnameMA = $mitarbeiter[$i-1]['nachname'];
                $vornameMA = $mitarbeiter[$i-1]['vorname'];

                echo " <tr>
                    <td>$nachnameMA</td>
                    <td>$vornameMA</td>";

                    for ($date=$von; $date<=$bis; $date++) {
                            $j++;
                            echo "<td id=\"Z$i;S$j\"></td>";
                        }

                echo "</tr>";
            }


        echo   "</table>
            </div> ";
    }


    public function addLinkButton($text, $name, $link) {

        echo "<input type=button onClick=\"parent.location='$link'\" name=\"$name\" value=\"$text\">";
    }


    public function writeJavascript()
    {


        echo "<script>

              eventsJSON = document.getElementById('hidden').innerHTML;
              let events = JSON.parse(eventsJSON);
              //console.log(events);
              
              let table = document.getElementById('wocheneinteilung');
              let datediff = 0;
              
              for (let i=0; i < table.rows.length; i++) {
              
                  for (let e=0; e< events.length; e++) {  
                      
                      if (table.rows[i].cells[0].innerHTML === events[e]['nachname'] && table.rows[i].cells[1].innerHTML === events[e]['vorname']) {
                          
                          datediff = (((Date.parse(events[e]['datum']) - Date.parse(table.rows[0].cells[2].innerHTML)))/1000/60/60/24+2);
                          //console.log(datediff);
                          table.rows[i].cells[datediff].innerHTML = events[e]['eventname'];
                      }
                      
                  }
              }
              
              </script>";
    }

    public function echoEventsJSON($events)
    {
        echo "<div id=\"hidden\" style=display:none>$events</div>";
    }


    public function writeFooter()
    {
        echo "</body></html>";
    }

}