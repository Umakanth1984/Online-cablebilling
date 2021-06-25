<!-- jQuery 2.2.3 -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://themefiles.digitalrupay.com/theme/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="https://themefiles.digitalrupay.com/theme/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="https://themefiles.digitalrupay.com/theme/dist/js/demo.js"></script>
<!-- FLOT CHARTS -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/flot/jquery.flot.min.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/flot/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/flot/jquery.flot.categories.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    /*
     * BAR CHART MONTHLY
     * ---------
     */

    var bar_data = {
      data: [<?php echo $empIdList; ?>],
      color: "#3c8dbc"
    };
    $.plot("#bar-chart", [bar_data], {
      grid: {
        borderWidth: 1,
        borderColor: "#f3f3f3",
        tickColor: "#f3f3f3"
      },
      series: {
        bars: {
          show: true,
          barWidth: 0.5,
          align: "center"
        }
      },
      xaxis: {
        mode: "categories",
        tickLength: 0
      }
    });
    /* END BAR CHART */

  });

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + "<br>"
        + Math.round(series.percent) + "%</div>";
  }
</script>



</body>
</html>