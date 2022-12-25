@extends('sub.template')

@section('konten')
    <section class="bg-partikel-2" style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>USER STATISTICS </b></h3>
            <hr class="hr-title"/>
            <div class="row pt-5">
                <div class="col-sm-12 col-md-6">
                    <div class="card border-0 mb-3 shadow">
                        <div class="card-body">
                            <div id="cart-country"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card border-0 mb-3 shadow">
                        <div class="card-body">
                            <div id="cart-school"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card border-0 mb-3 shadow">
                        <div class="card-body">
                            <div id="cart-title"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card border-0 mb-3 shadow">
                        <div class="card-body">
                            <div id="cart-gender"></div>
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
            setCartCountry();
            setCartSchool();
            setCartTitle();
            setCartGender();
        });
        function setCartCountry(){
            Highcharts.chart('cart-country', {
                chart: {type: 'column'},
                title: {text: 'COUNTRY'},
                subtitle: {text: 'Source: TEGAL INTERNATIONAL CONFERENCE'},
                Axis: {categories: <?= $gr_country?>, crosshair: true},
                yAxis: {min: 0, title: {text: 'TOTAL NUMBER'}},
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>', shared: true, useHTML: true
                },
                plotOptions: {column: {pointPadding: 0.2, borderWidth: 0, borderRadius: 5}},
                series: <?= $gr_country_data; ?>
            });
        }
        function setCartSchool(){
            Highcharts.chart('cart-school', {
                chart: {type: 'column'},
                title: {text: 'EDUCATION'},
                subtitle: {text: 'Source: TEGAL INTERNATIONAL CONFERENCE'},
                Axis: {categories: <?= $gr_education?>, crosshair: true},
                yAxis: {min: 0, title: {text: 'TOTAL NUMBER'}},
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>', shared: true, useHTML: true
                },
                plotOptions: {column: {pointPadding: 0.2, borderWidth: 0, borderRadius: 5}},
                series: <?= $gr_education_data?>
            });
        }
        function setCartTitle(){
            Highcharts.chart('cart-title', {
                chart: {type: 'column'},
                title: {text: 'DEGREE'},
                subtitle: {text: 'Source: TEGAL INTERNATIONAL CONFERENCE'},
                Axis: {categories: <?= $gr_degree?>, crosshair: true},
                yAxis: {min: 0, title: {text: 'TOTAL NUMBER'}},
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>', shared: true, useHTML: true
                },
                plotOptions: {column: {pointPadding: 0.2, borderWidth: 0, borderRadius: 5}},
                series: <?= $gr_degree_data?>
            });
        }
        function setCartGender(){
            Highcharts.chart('cart-gender', {
                chart: {type: 'column'},
                title: {text: 'GENDER'},
                subtitle: {text: 'Source: TEGAL INTERNATIONAL CONFERENCE'},
                Axis: {categories: <?= $gr_gender?>, crosshair: true},
                yAxis: {min: 0, title: {text: 'TOTAL NUMBER'}},
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>', shared: true, useHTML: true
                },
                plotOptions: {column: {pointPadding: 0.2, borderWidth: 0, borderRadius: 5}},
                series: <?= $gr_gender_data?>
            });
        }
    </script>
@endsection
