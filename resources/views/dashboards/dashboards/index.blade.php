@extends('app')
@section('content')
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Employee</h4>
            </div>
            <div class="card-body">
                <canvas id="myChart" data-height="275"></canvas>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        var data = {!! $empType !!};

        var labels = data.map(function (e){
            return e.name;
        });

        var data = data.map(function (e){
            return e.jumlah;
        });

        for (var i in data) {
            randomColor.push(dynamicColors());
        }

        var ctx = document.getElementById('myChart'); // node
        var ctx = document.getElementById('myChart').getContext('2d'); // 2d context
        var ctx = $('#myChart'); // jQuery instance
        var ctx = 'myChart'; // element id

        var myChart = new Chart(ctx, {
            type: 'pie',
            options: {
                responsive: true,
                // maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
                // cutoutPercentage: 60,
            //     // legend: { display: true },
            //     tooltips: {
            //         callbacks: {
            //             label: function (tooltipItem, data) {
            //                 var label = data.datasets[0].labels[tooltipItem.index] || '',
            //                     value = data.datasets[0].data[tooltipItem.index];
            //                 var output = ' ' + label + ' : ' + value + ' %';
            //                 return output;
            //             }
            //         },
            //         // Updated default tooltip UI
            //         shadowOffsetX: 1,
            //         shadowOffsetY: 1,
            //         shadowBlur: 8,
            //         shadowColor: tooltipShadow,
            //         backgroundColor: window.colors.solid.white,
            //         titleFontColor: window.colors.solid.black,
            //         bodyFontColor: window.colors.solid.black
            },
            data: {
                labels:labels,
                datasets: [
                    {
                        // labels: labels,
                        data: data,
                        backgroundColor: randomColor,
                        borderWidth: 0,
                        pointStyle: 'rectRounded'
                    }
                ]
            }
        });
    </script>
@endsection
