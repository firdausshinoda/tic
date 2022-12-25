@extends('sub.template')

@section('konten')
    <section style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>COMMITTEE</b></h3>
            <hr class="hr-title"/>
            <div class="row pt-5">
                <div class="col-sm-12">
                    @if($slug=="applied-sciences")
                        <h2><u>Advisory Board</u></h2>
                        <ol>
                            <li>Prof. Dr. Astrid Seltrecht (Otto von Guericke University Magdeburg, Germany)</li>
                            <li>Prof. Dr. Ade Gafar Abdullah, S.Pd., M.Si (Universitas Pendidikan Indonesia)</li>
                            <li>Prof. Dr. Anton Satria Prabuwono (King Abdul Aziz University, Kingdom of Saudi Arabia)</li>
                            <li>Assc. Prof. Dr. Sukree Langputeh (Fatoni University, Thailand)</li>
                            <li>Agung Hendarto, SE, MA (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Apt. Heru Nurcahyo, M.Sc (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Erni Unggul Sedya Utami, S.E., M.Si (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Kusnadi, M.Pd (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                        </ol>
                        <h2><u>Scientific committee</u></h2>
                        <ol>
                            <li>Prof. Dr. Frank Bunning (Otto von Guericke University Magdeburg, Germany)</li>
                            <li>Prof. Dr. Kamisah Osman (Universiti Kebangsaan Malaysia, Malaysia)</li>
                            <li>Prof. Dr. Abdul Rohman, M.Si.,Apt. (Universitas Gadjah Mada Yogyakarta, Indonesia)</li>
                            <li>Siti Aisyah, Ph.D (Universitas Pendidikan Indonesia)</li>
                            <li>Dr Muji Setiyo, ST., MT (Universitas Muhammadiyah Magelang, Indonesia)</li>
                            <li>Moh Sanni Mufti Alamsyah, M.Pd (Otto Von Guericke University Magdeburg, Germany)</li>
                        </ol>
                        <h2><u>Organizing Committee</u></h2>
                        <p>
                            <strong>Conference Chair:</strong> Iin Indrayanti, M.Pd (Politeknik Harapan Bersama Tegal, Indonesia)<br />
                            <strong>Co-Conference Chair:</strong> Nur Aidi Ariyanto, M.T (Politeknik Harapan Bersama Tegal, Indonesia)<br />
                            <strong>Members:</strong>
                        </p>
                        <ol>
                            <li>Syarifudin, M.T (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>M. Taufik Qurohman, M.Pd (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Asrofi Langgeng N.S., S.Pd., M.Si, CTT (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Riky Ardiyanto, S.Pd (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                        </ol>
                    @else
                        <h2><u>Advisory Board</u></h2>
                        <ol>
                            <li>Prof. Dr. Astrid Seltrecht (Otto von Guericke University Magdeburg, Germany)</li>
                            <li>Prof. Dr. Ade Gafar Abdullah, S.Pd., M.Si (Universitas Pendidikan Indonesia)</li>
                            <li>Prof. Dr. Anton Satria Prabuwono (King Abdul Aziz University, Kingdom of Saudi Arabia)</li>
                            <li>Assc. Prof. Dr. Sukree Langputeh (Fatoni University, Thailand)</li>
                            <li>Agung Hendarto, SE, MA (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Apt. Heru Nurcahyo, M.Sc (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Erni Unggul Sedya Utami, S.E., M.Si (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Kusnadi, M.Pd (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                        </ol>
                        <h2><u>Scientific committee</u></h2>
                        <ol>
                            <li>Associate Professor. Dr. Razana Zuhaida Johari ( Universiti Teknologi MARA, Malaysia)</li>
                            <li>Prof. Djoko Suhardjanto, M.Com (HONS).,Ph.D (Universitas Sebelas Maret, Indonesia)</li>
                            <li>Prof. Dr. Rudi Hartono, M.Pd (Universitas Negeri Semarang, Indonesia)</li>
                            <li>Prof. Dr. H. Eman Suparman, S.H., M.H (Universitas Padjadjaran Bandung, Indonesia)</li>
                            <li>Amalia Sustkarini, Ph.D (Universitas Bina Nusantara, Indonesia)</li>
                            <li>Dr. Suharto Linuwih, M. Si. (Universitas Negeri Semarang, Indonesia)</li>
                            <li>Dr. Handika Dany Rahmayanti, M.Si (Politeknik Negeri Media Kreatif Jakarta, Indonesia)</li>
                        </ol>
                        <h2><u>Organizing Committee</u></h2>
                        <p>
                            <strong>Conference Chair:</strong> Iin Indrayanti, M.Pd (Politeknik Harapan Bersama Tegal, Indonesia)<br />
                            <strong>Co-Conference Chair:</strong> Nur Aidi Ariyanto, M.T (Politeknik Harapan Bersama Tegal, Indonesia)<br />
                            <strong>Members:</strong>
                        </p>
                        <ol>
                            <li>Syarifudin, M.T (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>M. Taufik Qurohman, M.Pd (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Asrofi Langgeng N.S., S.Pd., M.Si, CTT (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                            <li>Riky Ardiyanto, S.Pd (Politeknik Harapan Bersama Tegal, Indonesia)</li>
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-committee').addClass("active");
        });
    </script>
@endsection
