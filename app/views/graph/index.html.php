<h4>Graph</h4>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load('visualization', '1', {packages: ['annotatedtimeline']});
    function drawVisualization() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Avg Price');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');
      data.addColumn('number', 'High');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');
      data.addColumn('number', 'Low');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');
      data.addColumn('number', '$=INR');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');
      data.addColumn('number', 'Vol\'K');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');
      data.addRows([<?=$data?>]);
    
      var annotatedtimeline = new google.visualization.AnnotatedTimeLine(
          document.getElementById('visualization'));
      annotatedtimeline.draw(data, {'displayAnnotations': true});
    }
    
    google.setOnLoadCallback(drawVisualization);
  </script>
  <div id="visualization" style="width: 800px; height: 400px;"></div>
