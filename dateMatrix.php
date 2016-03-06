<?
  require_once('general.php');
  require_once('connection.php');
  require_once('logger.php');
  require_once('checkLogin.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
   <div class="panel-body">
<?
  $january = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $february = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $march = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $april = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $may = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $june = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $july = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $august = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $september = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $october = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $november = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $december = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
  $year = array();
  $year[0] = $january;
  $year[1] = $february;
  $year[2] = $march;
  $year[3] = $april;
  $year[4] = $may;
  $year[5] = $june;
  $year[6] = $july;
  $year[7] = $august;
  $year[8] = $september;
  $year[9] = $october;
  $year[10] = $november;
  $year[11] = $december;

  $results = DB::query("SELECT DISTINCT
                          month(log.created) as 'month',
                          day(log.created) as 'day'
                        FROM
                          geocache, log, logtype, user, type
                        WHERE
                          geocache.id = log.geocache AND
                          log.user = user.id AND
                          type.id = geocache.type AND
                          log.type = logtype.id AND
                          (logtype.type = 'Found it' OR logtype.type = 'Attended' OR logtype.type = 'Webcam Photo Taken') AND
                          user.username = %s
                        ORDER BY
                          log.created DESC,
                          log.id DESC", getSessionUser());

  $total = 0;
  foreach ($results as $row) {
    $month = $row['month'] - 1;
    $day = $row['day'] - 1;
    $year[$month][$day] = 1;
    $total++;
  }

  function printMonth($month) {
    foreach ($month as $day) {
      if($day == '1') {
        echo '<td style="background-color: #D0F5A9;"><i class="fa fa-calendar-check-o"></i></td>';
      } else {
        echo '<td style="background-color: #F5D0A9;"><i class="fa fa-calendar-minus-o"></i></td>';
      }
    }
  }
?>
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Finds by Date</div>
    <table class="table table-bordered" style="table-layout: fixed;">
      <tr>
        <th>&nbsp;</th>
        <th>01</th>
        <th>02</th>
        <th>03</th>
        <th>04</th>
        <th>05</th>
        <th>06</th>
        <th>07</th>
        <th>08</th>
        <th>09</th>
        <th>10</th>
        <th>11</th>
        <th>12</th>
        <th>13</th>
        <th>14</th>
        <th>15</th>
        <th>16</th>
        <th>17</th>
        <th>18</th>
        <th>19</th>
        <th>20</th>
        <th>21</th>
        <th>22</th>
        <th>23</th>
        <th>24</th>
        <th>25</th>
        <th>26</th>
        <th>27</th>
        <th>28</th>
        <th>29</th>
        <th>30</th>
        <th>31</th>
      </tr>
      <tr>
        <th>Jan</th><? printMonth($year[0]); ?>
      </tr>
      <tr>
        <th>Feb</th><? printMonth($year[1]); ?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th>Mar</th><? printMonth($year[2]); ?>
      </tr>
      <tr>
        <th>Apr</th><? printMonth($year[3]); ?>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th>May</th><? printMonth($year[4]); ?>
      </tr>
      <tr>
        <th>Jun</th><? printMonth($year[5]); ?>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th>Jul</th><? printMonth($year[6]); ?>
      </tr>
      <tr>
        <th>Aug</th><? printMonth($year[7]); ?>
      </tr>
      <tr>
        <th>Sep</th><? printMonth($year[8]); ?>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th>Oct</th><? printMonth($year[9]); ?>
      </tr>
      <tr>
        <th>Nov</th><? printMonth($year[10]); ?>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th>Dec</th><? printMonth($year[11]); ?>
      </tr>
    </table>
    <div class="panel-footer">You found a geocache on <? echo $total; ?> of 365 days (<? echo round($total / 365 * 100, 2); ?>%).</div>
  </div>
<?
  function removeFoundDates($month) {
    foreach(array_keys($month, '-1') as $key) {
      unset($month[$key]);
    }
    return $month;
  }

?>
    </div>
    <script type="text/javascript">geolookup();</script>
  </body>
</html>
