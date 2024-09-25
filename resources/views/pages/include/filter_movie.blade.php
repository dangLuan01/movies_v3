<div class="col-md-4 col-sm-12 col-xs-12">
    <div class="sidebar">
        <div class="searh-form">
            <h4 class="sb-title">Tìm kiếm</h4>
            <form class="form-style-1" action="{{ route('locphim') }}" method="GET">
                <div class="row">
                    <div class="col-md-12 form-it">
                        <label>Tên phim</label>
                        <input type="text" name="movie" placeholder="Nhập tên phim" value="{{ isset($_GET['movie']) ? $_GET['movie'] : '' }}">
                    </div>
                    <div class="col-md-12 form-it">
                        <label>Loại phim</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="category">
                                    <option value="">Chọn loại phim</option>
                                    @foreach($category as $cate)
                                    <option value="{{ $cate->id }}" {{ isset($_GET['category']) && $_GET['category'] == $cate->id ? 'selected' : '' }}>{{ $cate->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 form-it">
                        <label>Thể loại</label>
                        <div class="group-ip">
                            <select name="genre[]" multiple="multiple" class="ui fluid dropdown">
                                <option value="" selected>Chọn thể loại</option>
                                @foreach($genre as $gen)
                                <option value="{{ $gen->slug }}" {{ isset($_GET['genre']) && in_array($gen->slug, $_GET['genre']) ? 'selected' : '' }}>{{ $gen->title }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 form-it">
                        <label>Quốc gia</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="country">
                                    <option value="">Chọn quốc gia</option>
                                    @foreach($country as $coun)
                                    <option value="{{ $coun->id }}" {{ isset($_GET['country']) && $_GET['country'] == $coun->id ? 'selected' : '' }}>{{ $coun->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 form-it">
                        <label>Năm</label>
                        <div class="row">
                            <div class="col-md-6">
                                <select name="year">
                                    <option value="">Năm</option>
                                    @for($i=2010; $i<= now()->year + 1; ++$i )
                                        <option value="{{ $i }}" {{ isset($_GET['year']) && $_GET['year'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor

                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <input class="submit" type="submit" value="Tìm ngay">
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>