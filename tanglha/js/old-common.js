jQuery(function($){
    var touchstart = {};
    var image_dragstart = {down: false};

    var win = $(window);
    var doc = $(document);
    var gam = $('#ga-main');
    var gbm = $('#gb-main');
    var gm = $('#global-menu');

    /* Hide article on mobile */
    if(doc.width() < 600) {
        $('article.post section.entry').addClass('hide').each(function() {$(this).after('<a class="read-post iconfont" href="javascript:void(0);">\ue602</a>');});
        doc.addClass('small-screen');
    }

    /* Background */
    var img = new Image();
    img.src = $('#header-image').attr('src');
    $(img).on('load', function() {
        var bgcolor=$('body').css('background-color');
        var canvas = $('#background')[0];
        var win_ratio = win.width() / win.height();
        var pic_ratio = this.naturalWidth / this.naturalHeight;

        if(win_ratio<pic_ratio) {
            $(canvas).css({'height':'100%','width':'auto'});

        }else {
            $(canvas).css({'width':'100%','height':'auto'});
        }

        canvas.width = this.naturalWidth;
        canvas.height = this.naturalHeight;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(this,0,0)
        var grd=ctx.createLinearGradient(0,0,0,canvas.height);
        var trbgcolor = bgcolor.replace(/rgb\((.*)\)/, 'rgba($1, 0.1)');
        grd.addColorStop(0,trbgcolor);
        grd.addColorStop(1,bgcolor);
        ctx.fillStyle=grd;
        ctx.fillRect(0,0,canvas.width,canvas.height);
    });

    win.on('resize', function(){ /* Hide or show article when resize */
        var sec = $('article.post section.entry');
        if(win.width() < 600) {
            doc.addClass('small-screen');
            if(!sec.hasClass('hide')) {
                sec.slideUp(200, 'easeInOutCirc').addClass('hide').each(function() {$(this).after('<a class="read-post iconfont" href="javascript:void(0);">\ue602</a>');});
            }
        }else if(win.width() > 600) {
            doc.removeClass('small-screen');
            if(sec.hasClass('hide')) {
                sec.slideDown(200, 'easeInOutCirc').removeClass('hide').next('a.read-post').remove();
            }
        }
        var win_ratio = win.width() / win.height();
        var canvas = $('#background');
        var pic_ratio =  canvas.attr('width') / canvas.attr('height');
        if(win_ratio<pic_ratio) {
            canvas.css({'height':'100%','width':'auto'});

        }else {
            canvas.css({'width':'100%','height':'auto'});
        }
    }).on('wheel', function(){
        var canvas = $('#background');
        if(canvas.height()>win.height()) {
            var percent = doc.scrollTop() / (doc.height() - win.height());
            var oldTop = parseFloat(canvas.css('top'));
            canvas.css('Top', (oldTop - (oldTop-win.height())*percent)+'px');
        }
    });

    /* Functions to show or hide menu */
    var showmenu = function(){
        $('#overlay').removeClass('hide');
        gm.removeClass('hide');
    };
    var hidemenu = function(){
        if(!$('#image-overlay').length) {
            $('#overlay').addClass('hide');
        }
        gm.addClass('hide');
    };


    doc.on('click', 'a.read-post', function() { /* Show article */
        var that = $(this);
        if(!that.hasClass('expand')) {
            that.addClass('expand').html('\ue603').prev('section.entry').slideDown(200, 'easeInOutCirc');
        }else {
            that.removeClass('expand').html('\ue602').prev('section.entry').slideUp(200, 'easeInOutCirc', function() {doc.scrollTop($(this).parent().offset().top-$('#global-actionbar').height());});
        }
    }).on('touchstart',function(e){ /* Swipe to hide or show menu start */
        e = e.originalEvent;
        if (e.touches && e.touches.length == 1) {
            var touch = e.touches[0];
            touchstart.x = touch.clientX;
            touchstart.y = touch.clientY;
        }
    }).on('touchend touchcancel',function(e){ /* Swipe to hide or show menu end */
        e = e.originalEvent;
        if (e.changedTouches && e.changedTouches.length || e.touches && e.touches.length) {
            var touch = e.changedTouches[0] || e.touches[0];
            var touchdirect = {};
            touchdirect.x = touch.clientX - touchstart.x;
            touchdirect.y = touch.clientY - touchstart.y;

            if(touchdirect.x < -50 && Math.abs(touchdirect.x) > Math.abs(touchdirect.y)) {
                e.preventDefault();
                if(!gm.hasClass('hide')) {
                    hidemenu();
                }
            }else if(touchdirect.x > 50 && Math.abs(touchdirect.x) > Math.abs(touchdirect.y)) {
                e.preventDefault();
                if(gm.hasClass('hide')) {
                    showmenu();
                }
            }
        }
        touchstart = {};
    }).on('click',function(e) { /* Hide all overlay elements */
        if(gbm.hasClass('expand')) {
            gbm.siblings().css('bottom', '0.3333em');
            gbm.removeClass('expand');
        }
        if(!gm.hasClass('hide')) {
            hidemenu();
        }
        $('#search-form.show').removeClass('show');
        $('#ga-search.show').removeClass('show');
        if($('#image-overlay') && !$(e.target).is('#image-overlay')) {
            $('#image-overlay').remove();
            $('#overlay').addClass('hide');
            $('.main,#global-button').removeClass('blur');
        }
    }).on('click','a,a.image-link',function(e){ /* Show overlay when click a link to image */
        if($(this).attr('href').match(/^.*\.(jpg|jpeg|jpe|jfif|jfi|jif|gif|png|svg)(\?.*)?$/)) {
            e.preventDefault();
            var img = new Image();
            img.src = loading_image;
            img.dataset.url = $(this).attr('href');
            img.id = "image-overlay";
            img.onload=function() {
                var window_ratio = innerWidth / innerHeight;
                var img_ratio = this.naturalWidth / this.naturalHeight;
                if(this.naturalWidth > innerWidth || this.naturalHeight > innerHeight) {
                    if(window_ratio >= img_ratio) {
                        this.style.height = innerHeight + 'px';
                        this.style.width = (this.naturalWidth * innerHeight / this.naturalHeight) + 'px';
                    }else {
                        this.style.width = innerWidth + 'px';
                        this.style.height = (this.naturalHeight * innerWidth / this.naturalWidth) + 'px';
                    }
                }else {
                    this.style.height = this.naturalHeight + 'px';
                    this.style.width = this.naturalWidth + 'px';
                }
                this.style.position = 'fixed';
                this.style.top = ((innerHeight - parseFloat(this.style.height)) / 2) + 'px';;
                this.style.zIndex = '9998';
                this.style.left = ((innerWidth - parseFloat(this.style.width)) / 2) + 'px';
                if(decodeURI(this.src) != this.dataset.url ) {
                    $('body').append($(this));
                    $('#overlay').removeClass('hide');
                    $('.main,#global-button').addClass('blur');
                    this.style.display = 'block';
                    this.src = this.dataset.url;
                }
            };
        }
    }).on('wheel', '#image-overlay', function(e) { /* Resize image when wheel on image overlay */
        e.preventDefault();
        e.stopPropagation();
        var that = $(this);
        var scale = 1,
            oldWidth = that.width(),
            oldHeight = that.height(),
            offsetX = e.originalEvent.offsetX || e.originalEvent.layerX,
            offsetY = e.originalEvent.offsetY || e.originalEvent.layerY;

        if(e.originalEvent.deltaY < 0) {
            scale = 1.1111;
        }else if (e.originalEvent.deltaY > 0) {
            scale = 0.9;
        }
        var newWidth = oldWidth * scale;
        var newHeight = oldHeight * scale;
        var changeLeft = (oldWidth - newWidth) * (offsetX / oldWidth);
        var changeTop = (oldHeight - newHeight) * (offsetY / oldHeight);
        that.css({
            left: (parseFloat(that.css('left'))+changeLeft)+'px',
            top: (parseFloat(that.css('top'))+changeTop)+'px',
            width: newWidth + 'px',
            height: newHeight + 'px'
        });
    }).on('mousedown touchstart', '#image-overlay', function(e) { /* Drag image overlay start */
        e.preventDefault();
        image_dragstart.down = true;
        if (e.originalEvent.touches) {
            if(e.originalEvent.touches.length == 1) {
                e.stopPropagation();
                var touch = e.originalEvent.touches[0];
                image_dragstart.x = touch.clientX;
                image_dragstart.y = touch.clientY;
            }
        }else {
            image_dragstart.x =  e.clientX;
            image_dragstart.y = e.clientY;
        }
    }).on('mousemove touchmove', '#image-overlay', function(e) { /* Drag image overlay moveing */
        if(image_dragstart.down) {
            if (e.originalEvent.changedTouches || e.originalEvent.touches) {
                if(e.originalEvent.changedTouches.length == 1 || e.originalEvent.touches.length ==1) {
                    e.preventDefault();
                    e.stopPropagation();
                    var touch = e.originalEvent.changedTouches[0] || e.originalEvent.touches[0];
                    var moveX = touch.clientX - image_dragstart.x;
                    var moveY = touch.clientY - image_dragstart.y;
                    image_dragstart.x = touch.clientX;
                    image_dragstart.y = touch.clientY;
                }else {
                    image_dragstart.down = false;
                }
            }else {
                var moveX = e.clientX - image_dragstart.x;
                var moveY = e.clientY - image_dragstart.y;
                image_dragstart.x = e.clientX;
                image_dragstart.y = e.clientY;
            }

            $('#image-overlay').css({
                left: (parseFloat($('#image-overlay').css('left'))+moveX)+'px',
                top: (parseFloat($('#image-overlay').css('top'))+moveY)+'px',
            });
        }
    }).on('mouseup touchend touchcancel', '#image-overlay', function(e) { /* Drag image overlay end */
        image_dragstart.down = false;
    });

    /* Return to head when click top bar */
    $('#global-actionbar').on('click', function() {
        doc.scrollTop(0);
    });

    /* Hide or show submenu */
    $('#global-menu nav dl dt.submenu').on('click', function(){
        $(this).toggleClass('submenu-expan').next('dd').slideToggle(200, 'easeInOutCirc');
    });

    /* Disable hide menu when click on menu */
    gm.on('click', function(e) {
        e.stopPropagation();
    });

    /* Show menu when click menu button */
    gam.on('click', function(e) {
        e.stopPropagation();
        showmenu();
    });

    /* Show search bar when click search button */
    $('#global-actionbar button#ga-search').on('click', function(e){
        e.stopPropagation();
        $(this).addClass('show');
        $('#search-form').addClass('show');
    });

    /* Disable hide menu when click on search bar */
    $('#search-form').on('click', function(e){
        e.stopPropagation();
    });

    /* Open a new window when click a link button */
    $('#global-button button.link').on('click', function(e) {
        e.stopPropagation();
        var link=$(this).data('action');
        window.open(link);
    });

    /* Hide or show buttons */
    gbm.on('click', function(e){
        e.stopPropagation();
        var that = $(this);
        if(!that.hasClass('expand')) {
            that.siblings().each(function(index){
                var that = $(this);
                var num = that.siblings().length;
                var dis = (num - index)*(parseFloat(that.css('padding-top'))*2+parseFloat(that.height())+parseFloat(that.css('bottom')))+parseFloat(that.css('bottom'));
                that.css('bottom', dis+'px');
            });
            that.addClass('expand');
        }else {
            that.siblings().css('bottom', that.css('bottom'));
            that.removeClass('expand');
        }
    });

});
