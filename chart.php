<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
  require_once('util/checkLogin.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-6"><canvas id="allYear"></canvas></div>
        <div class="col-md-6"><canvas id="allTypesCanvas1"></canvas></div>
      </div>
      <div class="row">
        <div class="col-md-6"><canvas id="yearComparison"></canvas></div>
        <div class="col-md-6"><canvas id="allTypesCanvas2"></canvas></div>
      </div>
    	<script>
        var username = "<?php echo getSessionUser(); ?>";

        $.getJSON("chartapi.php?data=allYearLabels&username=" + encodeURIComponent(username), function(allYearLabels) {
          $.getJSON("chartapi.php?data=allYearData&username=" + encodeURIComponent(username), function(allYearData) {

            var allYearChart = {
          		labels : allYearLabels,
          		datasets : [
          			{
          				fillColor : "rgba(151,187,205,0.5)",
          				strokeColor : "rgba(151,187,205,0.8)",
          				highlightFill : "rgba(151,187,205,0.75)",
          				highlightStroke : "rgba(151,187,205,1)",
          				data : allYearData
          			}
          		]
          	};

            var ctx0 = document.getElementById("allYear").getContext("2d");
        		window.myBar = new Chart(ctx0).Bar(allYearChart, {
        			responsive : true,
              scaleShowVerticalLines : false,
              animationSteps : 100,
              scaleFontSize: 12
        		});
          });
        });

        $.getJSON("chartapi.php?data=thisYearData&username=" + encodeURIComponent(username), function(thisYearData) {
          $.getJSON("chartapi.php?data=lastYearData&username=" + encodeURIComponent(username), function(lastYearData) {
            var yearComparisonChart = {
              labels : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
              datasets : [
                {
                  fillColor : "rgba(220,220,220,0.5)",
                  strokeColor : "rgba(220,220,220,0.8)",
                  highlightFill: "rgba(220,220,220,0.75)",
                  highlightStroke: "rgba(220,220,220,1)",
                  data : lastYearData
                },
                {
                  fillColor : "rgba(151,187,205,0.5)",
                  strokeColor : "rgba(151,187,205,0.8)",
                  highlightFill : "rgba(151,187,205,0.75)",
                  highlightStroke : "rgba(151,187,205,1)",
                  data : thisYearData
                }
              ]
            };

          var ctx2 = document.getElementById("yearComparison").getContext("2d");
      		window.myBar = new Chart(ctx2).Bar(yearComparisonChart, {
      			responsive : true,
            scaleShowVerticalLines : false,
            animationSteps : 100,
            scaleFontSize: 12,
            datasetFill : false
            });
          });
        });

        $.getJSON("chartapi.php?data=allTypesData&username=" + encodeURIComponent(username), function(allTypes) {
          console.log(allTypes);
          var ctx1 = document.getElementById("allTypesCanvas1").getContext("2d");
      		window.myBar = new Chart(ctx1).Doughnut(allTypes, {responsive : true});

          var ctx3 = document.getElementById("allTypesCanvas2").getContext("2d");
          window.myBar = new Chart(ctx3).Pie(allTypes, {responsive : true});
        });
    	</script>
    </div>
  </body>
</html>
