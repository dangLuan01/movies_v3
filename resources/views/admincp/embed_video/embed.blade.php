<head>
    <style>
        * {
            margin: 0;
            padding: 0
        }

        body {

            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }
    </style>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://ssl.p.jwpcdn.com/player/v/8.21.1/jwplayer.js"></script>
</head>

<body>
    <div id="jwplayer"></div>
    <script>
        // Lấy domain chính chủ mong muốn

        // var expectedDomain = "{!! route('homepage') !!}";
        // var indexOfDoubleSlash = expectedDomain.indexOf("//");

        // var domain = expectedDomain.substring(indexOfDoubleSlash + 2);

        // Kiểm tra xem domain có khớp không

        function getQuery(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
        var currentVolume;
        var skipDelay = 0,
            displaySkip = false,
            skipTimeOut = false,
            reloadTimes = 0,
            timeToSeek = 0,
            manualSeek = false,
            seekTimeOut, playTimeout, playAds = 0,
            maxAds = 1;
        var firstSource = [{
            file: "{{ asset('embed/store/intro.mp4') }}",
            type: "mp4",
            label: "360p",
            default: true
        }];
        var link = getQuery('link');
        var advertising = {
            client: 'vast',
            admessage: 'Quảng cáo còn XX giây.',
            skipoffset: 1,
            skiptext: 'Bỏ qua quảng cáo',
            skipmessage: 'Bỏ qua sau xxs',
            width: '100%',
            height: '100%',
            autostart: true,
            schedule: {
                preroll1: {
                    offset: 'pre',
                    //tag: '/urlads/ads.xml',
                    tag: '{{ asset('embed/urlads/ads.xml') }}',
                },
                // preroll2:{
                // 	offset: 'pre',
                // 	tag: '/urlads/ads2.xml',
                // }

            }
        };
        var playerInstance = jwplayer('jwplayer');

        function setupVideo() {
            if (playAds < maxAds) {
                playAds++;
                playerInstance.setup({
                    key: "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=",
                    width: '100%',
                    height: '100%',
                    sources: firstSource,
                    startparam: 'start',
                    primary: 'html5',
                    preload: 'auto',
                    autostart: true,
                    volume: 70,
                    captions: {
                        color: '#fff',
                        fontSize: 20,
                        backgroundOpacity: 0,
                        fontfamily: 'Helvetica',
                        edgeStyle: 'raised'
                    },
                    advertising: advertising,
                });
                setUpVideoEvent();
            } else {
                playAds++;
                jQuery("#jwplayer").html(
                    '<iframe width="100%" height="100%" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" src="' +
                    link + '" frameborder="0" allowfullscreen=""></iframe>');
            }
        }


        this.setUpVideoEvent = function() {
            playerInstance.on("ready", function() {
                    if (seekTimeOut != null) {
                        clearTimeout(seekTimeOut);
                    }

                    if (timeToSeek > 8) seekTimeOut = setTimeout(function() {
                        playerInstance.seek(timeToSeek);
                        manualSeek = false;
                    }, 500);

                    if (playTimeout != null) {
                        clearTimeout(playTimeout);
                        playTimeout = null;
                    }
                    playTimeout = setTimeout(function() {
                        playerInstance.play(true);
                        manualSeek = false;
                    }, 1000);
                }).on("error", function(message) {
                    var time = playerInstance.getPosition();
                    if (time > 8 && (manualSeek == false)) timeToSeek = time;
                    if (reloadTimes < 5) {
                        reloadTimes++;
                        if (message["message"] == "Error loading media: File could not be played") {
                            setTimeout(function() {
                                jQuery("#embed-player").find(".jw-title-primary").text(
                                    "Có chút vấn đề khi load phim. Đang thử lại...").show();
                            }, 100);
                        }
                        setTimeout(function() {
                            playerInstance.remove();
                            setupVideo();
                        }, 2000);
                    } else {
                        if (message["message"] == "Error loading media: File could not be played") {
                            setTimeout(function() {
                                jQuery("#embed-player").find(".jw-title-primary").text(
                                    "Có chút vấn đề khi load phim").show();
                                jQuery("#embed-player").find(".jw-title-secondary").text(
                                    "Chạy lại trang (ấn F5) hoặc mở link khác bên dưới").show();
                            }, 100);
                        }
                    }
                })
                .on("adPlay", function() {
                    currentVolume = playerInstance.getVolume();
                    playerInstance.setVolume(50);
                    skipTimeOut = setTimeout(function() {
                        if (displaySkip == false) {
                            $("#skipad-inner").show();
                            $("#skipad-inner").click(function() {
                                $("#skipad-inner").hide();
                                playerInstance.remove();
                                setupVideo();
                            });
                            displaySkip = true;
                        }
                    }, 1000 + skipDelay * 1000);
                })
                .on("play", function() {
                    playerInstance.setCurrentCaptions(1);
                    $("#skipad-inner").hide();
                    clearTimeout(skipTimeOut);
                    if (playAds <= maxAds) {
                        playerInstance.remove();
                        setupVideo();
                    } else {
                        if (currentVolume > 0) {
                            playerInstance.setVolume(currentVolume);
                            currentVolume = 0
                        }
                    }
                })
                .on("seek", function(event) {
                    manualSeek = true;
                    timeToSeek = event.offset;
                })
                .on("seeked", function(event) {
                    manualSeek = false;
                })
                .on("adTime", function(event) {
                    if (event.position > skipDelay && (displaySkip == false)) {
                        $("#skipad-inner").show();
                        setTimeout(function() {
                            $("#skipad-inner").hide();
                        }, 10000);
                        $("#skipad-inner").click(function() {
                            $("#skipad-inner").hide();
                            playerInstance.remove();
                            setupVideo();
                        });
                        displaySkip = true;
                    }
                })
                .on("adSkipped", function(event) {
                    $("#skipad-inner").hide();
                    displaySkip = true;
                })
                .on("adComplete", function(event) {
                    $("#skipad-inner").hide();
                    displaySkip = true;
                });
        }
        setupVideo();
    </script>
</body>
