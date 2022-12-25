@extends('dashboard.template')

@section('konten')
    <section class="inner-header parallax-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b>FAQ</b></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 15vh auto;">
            <div class="row">
                <div class="col-sm-12 col-md-9">
                    <?= $dt_isi; ?>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div data-toggle="datepicker"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-faq').addClass("active");
            $('[data-toggle="datepicker"]').datepicker({inline:true, language: 'in-INA'});
        });
    </script>
@endsection
