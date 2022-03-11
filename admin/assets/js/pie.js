$.ajax({
    url:"./ajax-page/pie-data.php",
    method:"GET",
    success:function(data)  {
        var category = [];
        var seats = [];

        for(var count = 0; count < data.length; count++)
        {
            category.push(data[count].category);
            seats.push(data[count].seats);
        }
    
    var ctx = document.getElementById('piechart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
            label: 'Category',
            data: seats,
            backgroundColor: [
                window.chartColors.danger,
                window.chartColors.purple,
                window.chartColors.green,
                window.chartColors.navy,
                window.chartColors.blue,
                window.chartColors.grey,
                window.chartColors.black,
            ],
        }],
        labels: category
    },
    options: {
        responsive: true
    }
    
    });
    
    },
    });