<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('include/head.html');
  printBodyTag();
  showNavigation();
?>
    <div class="panel-body">
<?
  if(getSessionUser() == "") {
?>
    <div class='panel panel-info'>
      <div class='panel-heading'>Not logged in</div>
      <div class='panel-body'>Please 'log in' on the top right corner.</div>
    </div>
<?
  } else {
?>
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

        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", "chartapi.php?data=allYearLabels&username=" + encodeURIComponent(username), false); // false for synchronous request
        xmlHttp.send(null);
        var allYearLabels = JSON.parse(xmlHttp.responseText);

        xmlHttp.open("GET", "chartapi.php?data=allYearData&username=" + encodeURIComponent(username), false); // false for synchronous request
        xmlHttp.send(null);
        var allYearData = JSON.parse(xmlHttp.responseText);

        xmlHttp.open("GET", "chartapi.php?data=allTypesData&username=" + encodeURIComponent(username), false); // false for synchronous request
        xmlHttp.send(null);
        var allTypes = JSON.parse(xmlHttp.responseText);

        xmlHttp.open("GET", "chartapi.php?data=lastYearData&username=" + encodeURIComponent(username), false); // false for synchronous request
        xmlHttp.send(null);
        var lastYearData = JSON.parse(xmlHttp.responseText);

        xmlHttp.open("GET", "chartapi.php?data=thisYearData&username=" + encodeURIComponent(username), false); // false for synchronous request
        xmlHttp.send(null);
        var thisYearData = JSON.parse(xmlHttp.responseText);

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
      	}


      	window.onload = function(){
          var ctx0 = document.getElementById("allYear").getContext("2d");
      		window.myBar = new Chart(ctx0).Bar(allYearChart, {
      			responsive : true,
            scaleShowVerticalLines : false,
            animationSteps : 100,
            scaleFontSize: 12
      		});

      		var ctx1 = document.getElementById("allTypesCanvas1").getContext("2d");
      		window.myBar = new Chart(ctx1).Doughnut(allTypes, {responsive : true});

          var ctx2 = document.getElementById("yearComparison").getContext("2d");
      		window.myBar = new Chart(ctx2).Bar(yearComparisonChart, {
      			responsive : true,
            scaleShowVerticalLines : false,
            animationSteps : 100,
            scaleFontSize: 12,
            datasetFill : false
      		});

          var ctx3 = document.getElementById("allTypesCanvas2").getContext("2d");
          window.myBar = new Chart(ctx3).Pie(allTypes, {responsive : true});
      	}
    	</script>
<?
    }
?>
    </div>
  </body>
</html>
