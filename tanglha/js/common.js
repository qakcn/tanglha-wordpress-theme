angular.module('tanglha', [])

.directive('autoloadBackground', ['$document', function($document){
    return {
        restrict: 'A',
        scope: {},
        link: function(scope, element, attrs) {
            element.css('backgroundImage', "linear-gradient(to bottom, rgba(255,255,255,0.6) 0%,rgba(255,255,255,0.6) 100%),url("+attrs.autoloadBackground+")");

            scope.reposition = function() {
                var body = element[0];
                var doc = $document[0].documentElement;
                var scrollTop = doc.scrollTop || body.scrollTop;
                var percent = scrollTop*100 / (body.scrollHeight - doc.clientHeight);
                element.css('backgroundPosition', '50% '+percent+'%');
            };

            scope.reposition();

            angular.element($document).bind('scroll', function(){
                scope.reposition();
            });
        }
    }
}])

.directive('globalMenuButton', ['$rootScope', function($rootScope){
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.on('click', function(){
                $rootScope.$broadcast('global-menu-toggle');
            });
        }
    }
}])

.directive('globalMenu', [ function(){
    return {
        restrict: 'A',
        scope: {},
        link: function(scope, element, attrs) {

            scope.toggle = function() {
                element.toggleClass('hide show');
            };

            scope.$on('global-menu-toggle', scope.toggle);
        }
    }
}])

.directive('globalOverlay', ['$document', '$rootScope', function($document, $rootScope){
    return {
        restrict: 'A',
        scope: {},
        link: function(scope, element, attrs) {

            scope.toggle = function(e, data) {
                scope.last=e.name;
                if(!data) {
                    if(scope.fuck) {
                        angular.element(scope.fuck).remove();
                        scope.fuck=false;
                    }
                }else {
                    scope.fuck=data;
                }
                element.toggleClass('hide show');
            };

            scope.$on('global-menu-toggle', scope.toggle);
            scope.$on('image-overlay-toggle', scope.toggle);

            angular.element($document).bind('click', function(e){
                if(e.target == element[0]) {
                    $rootScope.$broadcast(scope.last);
                }
            });
        }
    }
}])

.directive('submenu', ['$rootScope', function($rootScope){
    return {
        restrict: 'A',
        scope: {},
        controller: ['$scope', '$element', '$attrs', function(scope, element, attrs) {
            scope.$on('submenu-toggle', function(e, id){
                if(id==attrs.id) {
                    element.toggleClass('submenu-expan');
                }
            });
        }],

        link: function(scope, element, attrs) {
            element.addClass('submenu');

            if(attrs.submenu=='expanded') {
                $rootScope.$broadcast('submenu-toggle', attrs.id);
            }

            element.on('click', function(){
                $rootScope.$broadcast('submenu-toggle', attrs.id);
            });
        }
    }
}])

.directive('submenuFor', [function(){
    return {
        restrict: 'A',
        scope: {},
        controller: ['$scope', '$element', '$attrs', function(scope, element, attrs) {
            scope.$on('submenu-toggle', function(e, id){
                if(id==attrs.submenuFor) {
                    if(!element.hasClass('submenu-expan')) {
                        element.css('height', scope.submenuHeight);
                    }else {
                        element.css('height', 0);
                    }
                    element.toggleClass('submenu-expan');
                }
            });
        }],
        link: function(scope, element, attrs) {
            scope.submenuHeight = element.find('ul')[0].scrollHeight+'px';
        }
    }
}])

.directive('a', ['$document', '$rootScope', function($document, $rootScope){
    return {
        restrict: 'E',
        scope: {},
        link: function(scope, element, attrs) {
            scope.image_dragstart={};
            element.on('click', function(e){
                if(attrs.href.match(/^.*\.(jpg|jpeg|jpe|jfif|jfi|jif|gif|png|svg)(\?.*)?$/)) {
                    e.preventDefault();
                    var img = new Image();
                    img.src = loading_image;
                    img.dataset.url = attrs.href;
                    img.id = "image-overlay";
                    img.onwheel=function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        var that = angular.element(this);
                        var scale = 1,
                            oldWidth = this.offsetWidth,
                            oldHeight = this.offsetHeight,
                            offsetX = e.offsetX || e.layerX,
                            offsetY = e.offsetY || e.layerY;

                        if(e.deltaY < 0) {
                            scale = 1.1111;
                        }else if (e.deltaY > 0) {
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
                    };
                    img.onmousedown=img.ontouchstart=function(e) {
                        e.preventDefault();
                        scope.image_dragstart.down = true;
                        if (e.touches) {
                            if(e.touches.length == 1) {
                                e.stopPropagation();
                                var touch = e.touches[0];
                                scope.image_dragstart.x = touch.clientX;
                                scope.image_dragstart.y = touch.clientY;
                            }
                        }else {
                            scope.image_dragstart.x =  e.clientX;
                            scope.image_dragstart.y = e.clientY;
                        }
                    };
                    img.onmousemove=img.ontouchmove=function(e){
                        if(scope.image_dragstart.down) {
                            if (e.changedTouches || e.touches) {
                                if(e.changedTouches.length == 1 || e.touches.length ==1) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    var touch = e.changedTouches[0] || e.touches[0];
                                    var moveX = touch.clientX - scope.image_dragstart.x;
                                    var moveY = touch.clientY - scope.image_dragstart.y;
                                    scope.image_dragstart.x = touch.clientX;
                                    scope.image_dragstart.y = touch.clientY;
                                }else {
                                    scope.image_dragstart.down = false;
                                }
                            }else {
                                var moveX = e.clientX - scope.image_dragstart.x;
                                var moveY = e.clientY - scope.image_dragstart.y;
                                scope.image_dragstart.x = e.clientX;
                                scope.image_dragstart.y = e.clientY;
                            }
                            var that=angular.element(this);
                            that.css({
                                left: (parseFloat(that.css('left'))+moveX)+'px',
                                top: (parseFloat(that.css('top'))+moveY)+'px'
                            });
                        }
                    };
                    img.onmouseup=img.ontouchend=img.ontouchcancel=function(e){
                        scope.image_dragstart.down = false;
                    };
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
                            $document[0].body.appendChild(this);
                            $rootScope.$broadcast('image-overlay-toggle', this);
                            this.style.display = 'block';
                            this.src = this.dataset.url;
                        }
                    };
                }
            });
        }
    }
}])

.directive('searchForm', [function(){
    return {
        restrict: 'A',
        controller: ['$scope', '$element', '$document', '$window', function($scope, $element, $document, $window){
            $scope.inputinit=(innerWidth > 600);
            $scope.inputshowed=false;
            $scope.submit=function(e){
                if(!$scope.inputshowed && !$scope.inputinit) {
                    $scope.inputshowed = true;
                    e.preventDefault();
                }
            }
            $document.on('click', function(e){
                if(e.target!=$element.find('input')[0] && e.target!=$element.find('input')[1] && !$scope.inputinit) {
                    $scope.inputshowed = false;
                    $scope.$apply();
                }
            });
            angular.element($window).on('resize', function(e){
                $scope.inputinit=(innerWidth > 600);
            });
        }]
    }
}])
