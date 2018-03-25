  <style>
    #progress {
      width: 0px;
      border: 1px solid #aaa;
	  background-color: #ccc;
      height: 20px;
    }
	.change{
	    background-color: coral;
	}
  </style>
<div id="progress"></div>
<h3 id="count"></h3>
<script>
var es;
var maxprogress     = 100;
var currentprogress = 0;
function startTask() {
    es = new EventSource('progress.php');

	//a message is received
	es.addEventListener('message', function(e) {
		var result = JSON.parse( e.data );

		console.log(result.message);       
		var pBar   = document.getElementById('progress');
		document.getElementById('count').innerHTML = result.progress;
		pBar.style.width = result.message+"%";
		pBar.style.transition = "all 1s";
		if(e.lastEventId == 'CLOSE') {
			console.log('closed');
			es.close();
		}
		else {
			//console.log(response); //your progress bar action
		}
	});

	es.addEventListener('error', function(e) {
		console.log('error');
		es.close();
	});

}
startTask();
</script>