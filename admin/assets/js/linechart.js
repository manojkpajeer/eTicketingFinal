$(document).ready(function(){
	$.ajax({
	  url : "./ajax-page/line-data.php",
	  type : "GET",
	  success : function(data){ 
		new Chart(document.getElementById("linechart"), {
			type: 'line',
			data: {
				labels: data['day'],
				datasets: [{
					label: 'Sold',
					backgroundColor: window.chartColors.danger,
					borderColor: window.chartColors.danger,
					data: data['quantity'],
					fill: false,
				}
			
			]
			},
			options: {
				legend:false,
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
						}
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true,
							precision: 0
						},
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Ticket Sold'
						}
					}]
				}
			}
		});
	  }
	});
  });