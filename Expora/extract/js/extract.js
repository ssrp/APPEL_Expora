// Contains the array of distinct words
var WORDS = [];

// Contains the number of times the corresponding word has come.
var COUNT = [];

// This function is used to extract all the words from the database.
function extractWords()
{
	var query = "select cible_textes from petitions";
	$.ajax(
					{
						url:"php/extractWords.php", //the page containing php script
						type: "POST", //request type
						data:{query: query}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							processWords(result);
						}
					}
				);
}

// This function is used to add a new word in the corpora if it is not present. Otherwise, increament the value of corresponding count.
function addWord(word)
{
	var i = WORDS.indexOf(word);
	if(i > -1)
	{
		COUNT[i] = COUNT[i] + 1;
	}
	else
	{
		WORDS.push(word);
		COUNT.push(1);
	}
}

function processWords(words)
{
	words = words.toLowerCase();
	words = words.replace(",", " ");
	words = words.replace(";", " ");
	words = words.replace("'", " ");
	words = words.replace("?", " ");
	words = words.replace("\"", " ");
	words = words.replace(".", " ");

	var str = words.split(" ");
	for (var i = 0, len = str.length; i < len; i++) {
 		addWord(str[i]);
	}
}
function showOutput()
{

	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawMultSeries);
}

function drawMultSeries() {
	var data = google.visualization.arrayToDataTable([
		 ['Element', 'Count', { role: 'style' }],
		 [' ', 0, 'black']
		 ]);
/*
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Element');
	data.addColumn('number', 'Count');
	data.addColumn('', {role:'style'});
	*/

	document.getElementById("button").style.display = "none";
	var div = document.getElementById("output");
	var output = "<table style = 'border: 0.1em solid black; padding: 0.2em'><th style = 'border: 0.1em solid black; padding: 0.1em'>WORDS</th><th style = 'border: 0.1em solid black; padding: 0.1em'>COUNT</th>"


   for(var i = 0; i < WORDS.length; i++)
	{
		var num = COUNT[i];
		var c1 = (1*i % 10 + 2)%10;
		var c2 = (7*i % 10 + 2)%10;
		var c3 = (4*i % 10 + 2)%10;
		var c4 = (1*i % 10 + 2)%10;
		var c5 = (2*i % 10 + 2)%10;
		var c6 = (3*i % 10 + 2)%10;
		var color = "#".concat(c1.toString()).concat(c2.toString()).concat(c3.toString()).concat(c4.toString()).concat(c5.toString()).concat(c6.toString());
		output = output.concat("<tr><td style = 'border: 0.1em solid black; padding: 0.1em'>").concat(WORDS[i]).concat("</td><td style = 'border: 0.1em solid black; padding: 0.1em'>").concat(COUNT[i]).concat("</td>");
		

		data.addRow([WORDS[i], num,color]);

	}
	output = output.concat("</table>");
	div.innerHTML = output;

      var options = {
        title: 'Extraction of Words From the Corpora',
        chartArea: {width: '30%'},
        hAxis: {
          title: 'Count',
          minValue: 0
        },
        vAxis: {
          title: 'Words'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
   }