@extends('sub.template')

@section('konten')
    <section class="bg-partikel-2" style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>ABSTRACT STATISTICS</b></h3>
            <hr class="hr-title"/>
            <div class="row pt-5">
                <div class="col-sm-12">
                    <div class="card border-0 mb-3 shadow">
                        <div class="card-body">
                            <div id="cart-abstrak" style="height: 100vh"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-statistik').addClass("active");
            setCart();
        });
        function setCart(){
            Highcharts.chart('cart-abstrak', {
                chart: {type: 'column'},
                title: {text: 'SCOPE CATEGORY ABSTRACT'},
                subtitle: {text: 'Source: TEGAL INTERNATIONAL CONFERENCE'},
                Axis: {categories: <?= $gr_category; ?>, crosshair: true},
                yAxis: {min: 0, title: {text: 'TOTAL NUMBER'}},
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>', shared: true, useHTML: true
                },
                plotOptions: {column: {pointPadding: 0.2, borderWidth: 0, borderRadius: 5}},
                series: <?= $gr_category_data; ?>
            });
        }
    </script>
@endsection
