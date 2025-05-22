@php
    $footer = config('navigation.footer');
@endphp

<footer class="section-footer">
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-center">
            <div class="footer_nav-wrapper col-12 col-sm-6 col-md-3">
                <h6 class="fw-bold text-uppercase">Adresa a kontakt</h6>
                <ul class="list-unstyled contact-list">
                    <li>ŠÚKL</li>
                    <li>Kvetná 11</li>
                    <li>825 08 Bratislava 26</li>
                    <li>Ústredňa:</li>
                    <li>+421-2-50701 111</li>
                </ul>
                @foreach ([$footer[0], $footer[1]] as $category)
                    <h6 class="fw-bold text-uppercase">{{ $category['category'] }}</h6>
                    <ul class="list-unstyled">
                        @foreach ($category['links'] as $link)
                            <li><a href="#">{{ $link['title'] }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
            </div>

            <div class="footer_nav-wrapper col-12 col-sm-6 col-md-3">
                @foreach ([$footer[2]] as $category)
                    <h6 class="fw-bold text-uppercase">{{ $category['category'] }}</h6>
                    <ul class="list-unstyled">
                        @foreach ($category['links'] as $link)
                            <li><a href="#">{{ $link['title'] }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
            </div>

            <div class="footer_nav-wrapper col-12 col-sm-6 col-md-3">
                @foreach ([$footer[3], $footer[4]] as $category)
                    <h6 class="fw-bold text-uppercase">{{ $category['category'] }}</h6>
                    <ul class="list-unstyled">
                        @foreach ($category['links'] as $link)
                            <li><a href="#">{{ $link['title'] }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
            </div>

            <div class="footer_nav-wrapper col-12 col-sm-6 col-md-3">
                @foreach ([$footer[5], $footer[6]] as $category)
                    <h6 class="fw-bold text-uppercase">{{ $category['category'] }}</h6>
                    <ul class="list-unstyled">
                        @foreach ($category['links'] as $link)
                            <li><a href="#">{{ $link['title'] }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
                <h6 class="fw-bold text-uppercase text-primary">Rapid Alert System</h6>
                <ul class="list-unstyled text-primary">
                    <li><a href="#">Rýchla výstraha vyplývajúca<br>z nedostatkov v kvalite liekov</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
