<?php
/*
Class navbar
Copyright Joao Prado Maia (jpm@musicalidade.net)

Sweet little class to build dynamic navigation links. Please
notice the beautiful simplicity of the code. This code is 
free in any way you can imagine. If you use it on your own 
script, please leave the credits as it is. Also, send me an 
e-mail if you do, it makes me happy :)
 
Below goes an example of how to use this class:
===============================================
<?php 
$nav = new navbar;
$nav->numrowsperpage = 3;
$sql = "SELECT * FROM links ";
$result = $nav->execute($sql, $db, "mysql");
$rows = mysql_num_rows($result);
for ($y = 0; $y < $rows; $y++) {
  $data = mysql_fetch_object($result);
  echo $data->url . "<br>\n";
}
echo "<hr>\n";
$links = $nav->getlinks("all", "on");
for ($y = 0; $y < count($links); $y++) {
  echo $links[$y] . "&nbsp;&nbsp;";
}
?>
*/

class navbar {
  // Default values for the navigation link bar
  var $nav_numrowsperpage = 10;
  var $str_previous = "Prev";
  var $str_next = "Next";
  // Variables used internally
  var $file;
  var $nav_total_records;

  // The next function runs the needed queries.
  // It needs to run the first time to get the total
  // number of rows returned, and the second one to
  // get the limited number of rows.
  //
  // $sql parameter :
  //  . the actual SQL query to be performed
  //
  // $db parameter :
  //  . the database connection link
  //
  // $type parameter :
  //  . "mysql" - uses mysql php functions
  //  . "pgsql" - uses pgsql php functions
  function execute($sql, $db, $type = "mysql") {
    global $nav_total_records, $nav_page, $nav_numbertoshow;

    $nav_numbertoshow = $this->nav_numrowsperpage;
    if (!isset($nav_page)) $nav_page = 0;
    $start = $nav_page * $nav_numbertoshow;
    if ($type == "mysql") {
      $result = mysql_query($sql, $db);
      $nav_total_records = mysql_num_rows($result);
      $sql .= " LIMIT $start, $nav_numbertoshow";
      $result = mysql_query($sql, $db);
    } elseif ($type == "pgsql") {
      $result = pg_Exec($db, $sql);
      $nav_total_records = pg_NumRows($result);
      $sql .= " LIMIT $nav_numbertoshow, $start";
      $result = pg_Exec($db, $sql);
    }
    return $result;
  }

  // This function creates a string that is going to be
  // added to the url string for the navigation links.
  // This is specially important to have dynamic links,
  // so if you want to add extra options to the queries,
  // the class is going to add it to the navigation links
  // dynamically.
  function build_geturl()
  {
    global $REQUEST_URI, $REQUEST_METHOD, $HTTP_GET_VARS, $HTTP_POST_VARS;

    list($fullfile, $voided) = explode("?", $REQUEST_URI);
    $this->file = $fullfile;
    $cgi = $REQUEST_METHOD == 'GET' ? $HTTP_GET_VARS : $HTTP_POST_VARS;
    reset ($cgi);
    while (list($key, $value) = each($cgi)) {
      if ($key != "row")
        $query_string .= "&" . $key . "=" . $value;
    }
    return $query_string;
  }

  // This function creates an array of all the links for the
  // navigation bar. This is useful since it is completely
  // independent from the layout or design of the page.
  // The function returns the array of navigation links to the
  // caller php script, so it can build the layout with the
  // navigation links content available.
  //
  // $option parameter (default to "all") :
  //  . "all"   - return every navigation link
  //  . "pages" - return only the page numbering links
  //  . "sides" - return only the 'Next' and / or 'Previous' links
  //
  // $show_blank parameter (default to "off") :
  //  . "off" - don't show the "Next" or "Previous" when it is not needed
  //  . "on"  - show the "Next" or "Previous" strings as plain text when it is not needed
  function getlinks($option = "all", $show_blank = "off") {
    global $nav_total_records, $nav_page, $nav_numbertoshow;

    $extra_vars = $this->build_geturl();
    $file = $this->file;
    $number_of_pages = ceil($nav_total_records / $nav_numbertoshow);
    $subscript = 0;
    for ($current = 0; $current < $number_of_pages; $current++) {
      if ((($option == "all") || ($option == "sides")) && ($current == 0)) {
        if ($nav_page != 0)
          $array[0] = '<A HREF="' . $file . '?page=' . ($nav_page - 1) . $extra_vars . '">' . $this->str_previous . '</A>';
        elseif (($nav_page == 0) && ($show_blank == "on"))
          $array[0] = $this->str_previous;
      }

      if (($option == "all") || ($option == "pages")) {
        if ($nav_page == $current)
          $array[++$subscript] = ($current > 0 ? ($current + 1) : 1);
        else
          $array[++$subscript] = '<A HREF="' . $file . '?page=' . $current . $extra_vars . '">' . ($current + 1) . '</A>';
      }

      if ((($option == "all") || ($option == "sides")) && ($current == ($number_of_pages - 1))) {
        if ($nav_page != ($number_of_pages - 1))
          $array[++$subscript] = '<A HREF="' . $file . '?page=' . ($nav_page + 1) . $extra_vars . '">' . $this->str_next . '</A>';
        elseif (($nav_page == ($number_of_pages - 1)) && ($show_blank == "on"))
          $array[++$subscript] = $this->str_next;
      }
    }
    return $array;
  }
}
?>