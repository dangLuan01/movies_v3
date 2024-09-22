<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Post New</span>

            </div>
        </div>
        <section class="tab-content">
            <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                <div class="halim-ajax-popular-post-loading hidden"></div>
                <div id="halim-ajax-popular-post" class="popular-post">
                    @foreach ($movie_new as $mov)
                        <div class="item post-37176">
                            <a href="{{ route('movie', $mov->slug) }}" title="{{ $mov->title }}">
                                <div class="item-link">

                                    @php
                                        $image_check = substr($mov->image, 0, 5);
                                    @endphp
                                    @if ($image_check == 'https')
                                        <img src="{{ $mov->image }}" class="post-thumb" title="{{ $mov->title }}">
                                    @else
                                        <img src="{{ asset('uploads/movie/' . $mov->image) }}" class="post-thumb"
                                            title="{{ $mov->title }}">
                                    @endif
                                    <span class="is_trailer">
                                        @if ($mov->quality == 1)
                                            Bluray
                                        @elseif ($mov->quality == 2)
                                            HD
                                        @else
                                            FHD
                                        @endif
                                    </span>
                                </div>
                                <p class="title">{{ $mov->title }}
                                </p>

                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">
                                @if ($mov->count_views > 999 && $mov->count_views < 999999)
                                    {{ round($mov->count_views / 1000, 2) }}K views
                                @elseif ($mov->count_views > 999999)
                                    {{ round($mov->count_views / 1000000, 2) }}M views
                                @else
                                    {{ $mov->count_views }} views
                                @endif
                            </div>
                            <div style="float: left;">
                                <span class="user-rate-image post-large-rate stars-large-vang"
                                    style="display: block;/* width: 100%; */">
                                    <span style="width: 0%"></span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
    </div>
</aside>
