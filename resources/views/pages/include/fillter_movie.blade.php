<div class="section-bar clearfix">
    <style>
        .stylish_filter {
            text-align: center;
            border: 0;
            background: none;
            color: #fff;
            font-size: 20px;
            width: 18%;
        }

        .btn_filter {
            border: 0;
            background: #fff;
            color: #000;
            font-size: 20px;
            width: 5%;
            border-radius: 3.25px;
        }

        .btn-option {
            background: none;
            color: #000;
        }

        @media (max-width: 601px) {
            .m-t-20 {
                margin-bottom: 20px;
            }
            .btn_filter {
                font-size: 15px;
            }
            .stylish_filter {
                font-size: 15px;
            }
        }
    </style>
    <form style="padding-left: 1%;padding-right: 1%;" action="{{ route('locphim') }}" method="GET">



        <select class="stylish_filter" name="order" id="exampleFormControlSelec">
            <option class="btn-option" value="">--Sắp xếp--</option>
            <option class="btn-option" value="created_at">Đăng mới nhất</option>
            <option class="btn-option" value="title">Tên A-Z</option>
            <option class="btn-option" value="count_views">Xem nhiều</option>
        </select>


        <select class="stylish_filter" name="category" id="exampleFormControlSelect1">
            <option class="btn-option" value="">--Danh mục--</option>
            @foreach ($category as $key => $cate)
                <option class="btn-option"
                    {{ isset($_GET['category']) && $_GET['category'] == $cate->id ? 'selected' : '' }}
                    value="{{ $cate->id }}">{{ $cate->title }}</option>
            @endforeach

        </select>


        <select class="stylish_filter" name="genre" id="exampleFormControlSelect2">
            <option class="btn-option" value="">--Thể loại--</option>
            @foreach ($genre as $key => $gen)
                <option class="btn-option" {{ isset($_GET['genre']) && $_GET['genre'] == $gen->id ? 'selected' : '' }}
                    value="{{ $gen->id }}">{{ $gen->title }}</option>
            @endforeach

        </select>




        <select class="stylish_filter" name="country" id="exampleFormControlSelect3">
            <option class="btn-option" value="">--Quốc gia--</option>
            @foreach ($country as $key => $count)
                <option class="btn-option"
                    {{ isset($_GET['country']) && $_GET['country'] == $count->id ? 'selected' : '' }}
                    value="{{ $count->id }}">{{ $count->title }}</option>
            @endforeach
        </select>



        <select class="stylish_filter" name="year" id="exampleFormControlSelect4">
            <option class="btn-option" value="">--Năm--</option>
            @for ($year = 2000; $year <= now()->year; $year++)
                <option class="btn-option">{{ $year }}</option>
            @endfor


            <input type="submit" class="btn_filter" value="LỌC">

    </form>

</div>

<script>
    function keepSelectedValue() {
        var year = document.getElementById("exampleFormControlSelect4");
        year.addEventListener("change", function() {
            var selectedValue = year.options[year.selectedIndex].value;
            localStorage.setItem("selectedYear", selectedValue);
        });
        var selectedYear = localStorage.getItem("selectedYear");
        if (selectedYear !== null) {
            year.value = selectedYear;
        }
    }
    keepSelectedValue();
</script>
<script>
    if (window.innerWidth <= 600) {
        document.getElementById("exampleFormControlSelec").options[0].innerText = "SX";
        document.getElementById("exampleFormControlSelect1").options[0].innerText = "Loại";
        document.getElementById("exampleFormControlSelect2").options[0].innerText = "TL";
        document.getElementById("exampleFormControlSelect3").options[0].innerText = "QG";
        document.getElementById("exampleFormControlSelect4").options[0].innerText = "N";
        document.querySelector(".btn_filter").value = "L";
    }
</script>
