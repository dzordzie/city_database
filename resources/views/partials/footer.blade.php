<footer class="bg-light py-4 mt-5">
    <div class="container">
        <div class="row">
            @foreach (config('navigation.footer') as $category)
                <div class="col-6 col-md-3 mb-3">
                    <h5 class="fw-bold">{{ $category['category'] }}</h5>
                    <ul class="list-unstyled">
                        @foreach ($category['links'] as $link)
                            <li>{{ $link['title'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</footer>
