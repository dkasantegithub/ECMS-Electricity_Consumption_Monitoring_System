// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';


$(document).ready(function () {
    get_data();
    setInterval(function () {
        get_data()
    }, 5000);

    function get_data() {
        jQuery.ajax({
            url: "http://localhost/ecms/admin/customer/regional_consumption.php",
            method: "GET",
            success: function (data) {
                var total = [];
                var region = [];

                for (var i in data) {
                    total.push(data[i].total);
                    region.push(data[i].region);
                }

                // Total Consumption In Regions Pie Chart
                var ctx = document.getElementById("regionalChart").getContext('2d');
                var regionalChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: region,
                        datasets: [{
                            data: total,
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true
                        },
                        cutoutPercentage: 80,
                    },
                });
            },
            error: function (data) {},
        });
    }
});