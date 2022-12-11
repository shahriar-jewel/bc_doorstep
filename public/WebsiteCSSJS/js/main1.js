var $ = jQuery.noConflict();

$('nav#secondaryNav ul.secondaryNav a').removeClass('active');

$(document).ready(function () {

  $('.webform-client-form select:not(".chosen-processed")').each(function(){
    $(this).wrap('<div class="select-wrapper"></div>');
  });

  if($('body.node-type-food-menu-items').length) {
          $(window).resize(function() {
              if ($(window).width() > 768) {
                 $('.ds-1col.node-offers img').not(":first").each(function( index ) {
              $( this ).hide();
          });
             $('.ds-1col.node-offers img').eq(0).show();
          } else {
              $('.ds-1col.node-offers img').eq(0).hide();
              $('.ds-1col.node-offers img').not(":first").css('width','100%').show();
         }
      });
  };


  if ($('.language-ph').length) {
    
    $('.language-ph ul.language-switcher-locale-url > li.active').each(function(){
      var active_list = $(this).removeClass('last').addClass('first').clone();
      $(this).remove();
      $('.language-ph ul.language-switcher-locale-url > li').first().removeClass('first').addClass('last');
      active_list.insertBefore('.language-ph ul.language-switcher-locale-url > li');
    });
    
    $($('.language-ph .content').contents()).appendTo('.language-switcher');

    $(".language-switcher li").first().append("<ul class='ls-menu'> </ul>");
    $(".language-switcher li.first ul").toggle();
    $(".language-switcher li a").first().replaceWith(function(){ return $(this).text() });
    $(".language-switcher li").not(":first").each(function( index ) {
        $(".language-switcher li > ul").first().append($( this ) );
        $( this ).appendTo(".language-switcher > li > ul");
    });
  }

  if($(".language-switcher").length) {
    $(".language-switcher li.first").click(function() {
      $(".language-switcher li.first > ul").toggle();
    });
  }

  if($('body').hasClass('page-menu')) {
   $('nav#secondaryNav ul.secondaryNav a').removeClass('active');
   $('nav#secondaryNav ul.secondaryNav li').each(function(){

      var term = $(this).attr('class').split(' ').pop();
      var pattern = new RegExp(term);
      if($('body').attr('class').match(pattern)) {
        $(this).find('a').addClass('active');
      }
    });

  }

 //  if($('body').hasClass('page-node')) {
    // var doc = $('.node-documents-area');
    // if(doc.length) {
    //   $('#nutrition-footnote').html(doc.html())
    // }
 //  }

if($('body.node-type-food-menu-items').length) {
  if ($('.nutrition-info').length) {
    var document_area = $('.node-documents-area').html();
    $('.node-documents-area').hide();
    if (document_area) {
      $('.nutrition-info').append('<div class="nutrition-documents">' + document_area + '</div>');
    }
  }
}

BK = function () {
    var _mqMobile = window.matchMedia('screen and (max-width: 767px)'),
        _mqTablet = window.matchMedia('screen and (max-width: 1199px)'),
        _mqDesktop = window.matchMedia('screen and (min-width: 1200px)');
    return {
    
        init: function () {

            BK.initTracking();
            BK.nav.init();
            BK.productDetail.init();
            BK.mymeal.init();
            BK.initAppBanners();
            BK.initAlertSignupPopup();
            
            // TODO: 
            // Use a more consistent test to see what page the user is on.
            // This will depend on what Drupal is capable of outputting
            
            if ($('body').hasClass('home')) {
                BK.home.init();                
            }
            if ($('.food-item').not('.skip-expand').length) {
                BK.menu.init();
            }
            if($('body').hasClass('other')) {
                BK.other.init();
            }
            if($('.MadeToOrder-slider').length) {
                BK.initMadeToOrderSlider();
            }
            if($('.OurStory-slider').length) {
                BK.initOurStorySlider();
            }

            $('.food-item.skip-expand').click(function(e){
                var product_id = $(this).data('productId');
                window.location = BK_MENU_PRODUCTS[product_id]['url'];
            });  
        },

        /**
         * @method getMq
         * @memberOf BK
         * 
         * get media query matches
         * 
         * @param  {string} mq string representing a specific breakpoint
         * @return {object}     match objects from MatchMedia
         */
        getMq: function(mq) {
            switch (mq) {
                case 'mobile':
                    return _mqMobile;
                    break;
                case 'tablet':
                    return _mqTablet;
                    break;
                case 'desktop':
                    return _mqDesktop;
                    break;
                default:
                    return null;
            }
        },

        /**
         * Initialize Analytics based on delegation of the click events on the page body
         * @return {void} 
         */
        initTracking: function() {
            $('body').on('click', '[data-ga]', function(e) {
                var args = $(this).data('ga').split(',');
                var outboundUrl = $(this).data('gaOutboundUrl');

                if(args.length) {
                    if(outboundUrl) {
                        e.preventDefault();
                        BK.analytics.track(args, function() {
                            window.location = outboundUrl;
                        });
                    } else {
                        BK.analytics.track(args);
                    }
                }

            });
        },
        /**
         * A Popup, links to /alert-signup page
         * @return {void} 
         */
        initAlertSignupPopup: function() {
            var mqDesktopMatch = BK.getMq('desktop').matches;
            if (mqDesktopMatch) {
                var timerFirstClick;
                var timerSecondClick;
                
                // Attach event
                $("li.alert-signup-popup a#btnLetter").on('click', function(){
                    var cl = $(this).attr('class');
                                            
                    if(cl == 'active')
                    {
                        $(this).removeClass('active');
                        $(this).next().removeClass('active');
                        $("li.alert-signup-popup .popup").fadeOut(200);
                        
                        if(timerSecondClick)
                            window.clearTimeout(timerSecondClick);
                    }
                    else
                    {
                        $(this).addClass('active');
                        $(this).next().addClass('active');
                        $("li.alert-signup-popup .popup").fadeIn(200);
                        

                    }
                
                });
                
                $("li.alert-signup-popup .popup a#lnkClose").on('click', function(){
                    $("li.alert-signup-popup a#btnLetter").click();
                });
                
                // Showing automatically
                /*var firstTimeSeePopup = ($.cookie('bk_seenAlertSignupPopup') == null);
                if(firstTimeSeePopup)
                {
                    $.cookie('bk_seenAlertSignupPopup', 'true', {expires: 30 , path: '/'} );
                    timerFirstClick = setTimeout(function() { 
                        $("li.alert-signup-popup a#btnLetter").click();
                    }, 2000);
                    
                    timerSecondClick = setTimeout(function() { 
                        $("li.alert-signup-popup a#btnLetter").click();
                    }, 7000);
                }*/
            } 
            
            
        },
        /**
         * Initialize the app banner, Both iOS and Android
         * @return {void} 
         */
        initAppBanners: function() {
            
            // iOS version < 6 or Android
            // if ( !(/(iPad|iPhone|iPod).*OS [6-8].*AppleWebKit.*Mobile.*Safari/.test(navigator.userAgent)) ||
            //   /Android/.test(navigator.userAgent)) {
        if(Drupal.settings.banner.smartBannerMobile == true) { 
              $.smartbanner({
                title: 'BURGER KING® App',
                author: 'BURGER KING',
                layer: true,
                button: 'INSTALL',
                icon: 'http://a3.mzstatic.com/us/r30/Purple1/v4/b1/d9/7c/b1d97cfe-5eb0-75da-6b01-5b62a978eae9/icon175x175.jpeg',
                googlePlayDirectURL: Drupal.settings.banner.smartBannerAndroidURI,
                appStoreDirectURL: Drupal.settings.banner.smartBannerAppleURI
              });
              
            //}
            }
        },

        /**
         * @method initMadeToOrderSlider
         * @memberOf BK
         *
         * Initialize the 'Made to Order slider', Only in Made to order page
         * 
         * @return {void} 
         */
        initMadeToOrderSlider: function() {
            var madeToOrderSlider = $('.MadeToOrder-slider .owl-carousel');
            
            madeToOrderSlider.on('initialized.owl.carousel', function(event) {
                var mqMobileMatch = BK.getMq('mobile').matches;
                if (mqMobileMatch) {
                    BK.adjustMadeToOrderArrows();
                } 
                
            });
            madeToOrderSlider.owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                center: true,
                navText: [ '<div class="hover"></div><div class="arrow"></div>', '<div class="hover"></div><div class="arrow"></div>' ],
                responsiveClass: true,
                responsive:{
                    0:{
                        margin: 0,
                        autoWidth: false,
                        items: 1
                    },
                    768:{
                        margin: -75,
                        autoWidth: true
                    }
                }
            });
            
        },
        /**
         * @method adjustOurStoryArrows
         * @memberOf BK
         *
         * Adjust arrows of 'Our story slider',
         * 
         * @return {void} 
         */
        adjustMadeToOrderArrows: function() {
            var madeToOrderSlider = $('.MadeToOrder-slider .owl-carousel');
            var itemH = $($('.owl-item .item', madeToOrderSlider)[0]).height();
            var imageH = $('.owl-item.center .item img', madeToOrderSlider).height();
            
            var bottom = (itemH - imageH) + (imageH / 2) * 0.8;
            // console.log('adjustArrows - bottom: '+bottom);
            $('.owl-controls .owl-nav .owl-prev .arrow', madeToOrderSlider).css('bottom', bottom + 'px');
            $('.owl-controls .owl-nav .owl-next .arrow', madeToOrderSlider).css('bottom', bottom + 'px');
        },
        /**
         * @method adjustOurStoryArrows
         * @memberOf BK
         *
         * Adjust arrows of 'Our story slider',
         * 
         * @return {void} 
         */
        adjustOurStoryArrows: function() {
            var ourStorySlider = $('.OurStory-slider .owl-carousel');
            var itemH = $($('.owl-item .item', ourStorySlider)[0]).height();
            var imageH = $('.owl-item.center .item img', ourStorySlider).height();
            // console.log('adjustArrows - itemH: '+itemH+', imageH: '+imageH);
            var bottom = itemH - imageH - 42;

            $('.owl-controls .owl-nav .owl-prev .arrow', ourStorySlider).css('bottom', bottom + 'px');
            $('.owl-controls .owl-nav .owl-next .arrow', ourStorySlider).css('bottom', bottom + 'px');
        },
        /**
         * @method initOurStorySlider
         * @memberOf BK
         *
         * Initialize the 'Our story slider',
         * 
         * @return {void} 
         */
        initOurStorySlider: function() {
            var ourStorySlider = $('.OurStory-slider .owl-carousel');
            
            ourStorySlider.on('initialized.owl.carousel', function(event) {
                var mqMobileMatch = BK.getMq('mobile').matches;
                if (mqMobileMatch) {
                    BK.adjustOurStoryArrows();
                } 
                
            });
            
            ourStorySlider.on('resized.owl.carousel', function(event) {
                var mqMobileMatch = BK.getMq('mobile').matches;
                if (mqMobileMatch) {
                    BK.adjustOurStoryArrows();
                } 
                else
                {
                    // Reset
                    $('.owl-controls .owl-nav .owl-prev .arrow', ourStorySlider).css('bottom', '');
                    $('.owl-controls .owl-nav .owl-next .arrow', ourStorySlider).css('bottom', '');
                }
                
            });
            ourStorySlider.owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                center: true,
                navText: [ '<div class="hover"></div><div class="arrow"></div>', '<div class="hover"></div><div class="arrow"></div>' ],
                responsiveClass: true,
                responsive:{
                    0:{
                        margin: 0,
                        autoWidth: false,
                        items: 1
                    },
                    768:{
                        margin: 10,
                        autoWidth: true
                    }
                }
            });
            
            
        },

        templates: {
            'mymeal-modal': '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a href="#" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon icon_close-gray"></i></a><h4 class="modal-title" id="myModalLabel">' + Drupal.t('My Meal') + '</h4></div><div class="modal-body"><span>' + Drupal.t('Click on an item to customize with premium ingredients.') + '</span>{{{items}}}{{{nutrition}}}</div><div class="modal-footer"><a href="#" onclick="sendMail()" class="bk-btn bk-btn-lightBrown btn-default bk-btn-email" data-dismiss="modal" data-ga="send,event,myMealModal,click,emailShare">'+ Drupal.t('Send By Email') + '<i class="icon icon_email-white"></i></a><a href="#" class="bk-btn bk-btn-orange btn-primary bk-btn-print" data-dismiss="modal" data-ga="send,event,myMealModal,click,printMeal">' + Drupal.t('Print') + '<i class="icon icon_print-white"></i></a></div></div></div></div>',
            'mymeal-items': '<table class="items-table"><thead><tr><th colspan="2">' + Drupal.t('Items') + '</th><th>' + Drupal.t('Calories') + '</th></tr></thead><tbody>{{#items}}<tr><td class="action"><a class="delete" data-item-index="{{idx}}"><i class="icon icon_close-gray"></i></a></td><td class="item"><a href="{{url}}{{#params}}{{/params}}" data-ga="send,event,myMealModal,click,customize" data-ga-outbound-url="{{url}}{{#params}}{{/params}}">{{{label}}}</a></td><td class="calories">{{roundedCalories}}</td></tr>{{/items}}{{^items}}<tr><td colspan="2" class="action"><span>' + Drupal.t('No items') + '</span></td><td class="calories">0</td></tr>{{/items}}</tbody><tfoot><tr><td colspan="2" class="label">' + Drupal.t('Total') + '</td><td class="calories">{{totalCalories}}</td></tr></tfoot></table>',
            'mymeal-nutrition': '<div class="nutrition-content"{{^isVisible}} style="display: none;"{{/isVisible}}>{{#nutrition}}<div class="nutrition-data">{{#isMyMeal}}<h3>' + Drupal.t('Meal Nutrition') + '</h3>{{/isMyMeal}}<div class="col-sm-4"><ul><li class="calories"><h5 class="label">' + Drupal.t('Calories') + '</h5><p class="value"><span class="number">{{calories}}</span></p></li><li class="protein"><h5 class="label">' + Drupal.t('Protein') + '</h5><p class="value"><span class="number">{{protein}}</span><abbr class="unit">g</abbr></p></li><li class="carbohydrates"><h5 class="label">' + Drupal.t('Carbohydrates') + '</h5><p class="value"><span class="number">{{carbohydrates}}</span><abbr class="unit">g</abbr></p></li></ul></div><div class="col-sm-4"><ul><li class="sugar"><h5 class="label">' + Drupal.t('Sugar') + '</h5><p class="value"><span class="number">{{sugar}}</span><abbr class="unit">g</abbr></p></li><li class="fat"><h5 class="label">' + Drupal.t('Fat') + '</h5><p class="value"><span class="number">{{fat}}</span><abbr class="unit">g</abbr></p></li><li class="saturatedfat"><h5 class="label">' + Drupal.t('Saturated Fat') + '</h5><p class="value"><span class="number">{{saturatedfat}}</span><abbr class="unit">g</abbr></p></li></ul></div><div class="col-sm-4"><ul><li class="transfat"><h5 class="label">' + Drupal.t('Trans Fat') + '</h5><p class="value"><span class="number">{{transfat}}</span><abbr class="unit">g</abbr></p></li><li class="cholesterol"><h5 class="label">' + Drupal.t('Cholesterol') + '</h5><p class="value"><span class="number">{{cholesterol}}</span><abbr class="unit">mg</abbr></p></li><li class="sodium"><h5 class="label">' + Drupal.t('Sodium') + '</h5><p class="value"><span class="number">{{sodium}}</span><abbr class="unit">mg</abbr></p></li></ul></div></div>{{/nutrition}}<p class="allergens">{{#allergens}}<span class="allergens-list"><strong>' + Drupal.t('Allergens') + ':</strong> {{.}}</span>{{/allergens}}</div>',
            'product-detail': '<section id="product-dropdown" data-product-id="{{id}}" class="col-xs-12 dropdown"><div class="wrapper"><div class="container-fluid product-hero"><div class="row content clearfix"><a class="close" href="#" data-ga="send,event,product,click,detailsClose"><i class="icon icon_close-gray">' + Drupal.t('Close') + '</i></a><hgroup class="col-sm-6 text-left title-group"><h1 class="title">{{{title}}}</h1><h2 class="subtitle">{{{subtitle}}}</h2></hgroup><div class="image col-xs-12 col-sm-6 text-right"><img src="{{{image}}}" /></div><div class="description col-sm-6 text-left hidden-xs">{{{description}}}</div><div class="action col-xs-12 col-sm-6 text-center"><a href="{{url}}" class="bk-btn bk-btn-orange" data-ga="send,event,product,click,detailsCTA">' + Drupal.t('Info &amp; Nutrition') + '<i class="icon icon_fork-white"></i></a></div></div></div></div></section>',
            'flip-card': '<ul id="flick" class="flick">{{#items}}<li class="item"><div class="flipContainer" data-ga="send,event,socialTiles,click,flip"><div class="back"><div class="bgFlip" style="background-image:url({{{imgsrc}}});"></div><div class="content"><div class="header"><i class="icon icon_logo-main"></i>' + Drupal.t('BURGER KING') + '</div><div class="text">{{{description}}}</div><div class="actions">{{#isTwitter}}<span class="reply"><a href="https://twitter.com/intent/tweet?in_reply_to={{id}}" target="_blank"><i class="icon icon_reply-brown"></i>' + Drupal.t('Reply') + '</a></span><span class="retweet"><a href="https://twitter.com/intent/retweet?tweet_id={{id}}" target="_blank"><i class="icon icon_retweet-brown"></i>' + Drupal.t('Retweet') + '</a></span><span class="favorite"><a href="https://twitter.com/intent/favorite?tweet_id={{id}}" target="_blank"><i class="icon icon_favorite-clicked-brown"></i>' + Drupal.t('Favorite') + '</a></span>{{/isTwitter}}{{^isTwitter}}<span class="like"><a href="{{link}}" target="_blank"><i class="icon icon_like-brown"></i>' + Drupal.t('Like') + '</a></span>{{/isTwitter}}</div></div></div><div class="front" style="background-image: url({{{imgsrc}}});"></div></div></li>{{/items}}</ul>'
        },
        
        util: {
            // inspired by underscore's "_.result()"
            resultOf: function(object, property) {
                if (object == null) return void 0;
                var value = object[property];
                return $.isFunction(value) ? object[property]() : value;
            },
            getUniqueArray: function( arr ) {
                var i = 0, a = [], obj = {};
                do {
                    if(!(arr[i] in obj)) {
                        a.push(arr[i]);
                        obj[arr[i]] = true;
                    }
                } while(arr[++i]);

                return a;
            }
        }
    }
}();

BK = BK || {};
BK.analytics = function() {
    var _timer = 0;
    var hasGA = false;

    function _track( options, callback ) {
        if(hasGA) {
            if(callback !== undefined) {
                options.push({ hitCallback: function() {
                    window.clearTimeout(_timer);
                    callback();
                }});
            }

            window.ga.apply(window, options);
        } else {
            if(callback !== undefined) callback();
        }
    }

    if(window.ga !== undefined) {
        hasGA = true;
    }

    return {
        track: _track
    }
}();

BK = BK || {};
BK.home = function() {
    var bkFlicker,
        templates = {};

    return {
        /**
         * @method init
         * @memberOf BK.home
         * 
         * Execute the home initilization
         * This used to set up the home location map (now commented out)
         * 
         * @return {void}
         */
        init: function() {

            templates = {
                card: function() {
                    var tmpl = BK.templates['flip-card'];
                    Mustache.parse(tmpl);
                    return tmpl;
                }()
            }

            BK.home.setupHero();
            BK.home.setupTweets();
        },

        /**
         * @method attachEventHandlers
         * @memberOf BK.home
         * 
         * set up the map on the home page if 'google' isn't undefined
         * 
         * @return {void}
         */
        attachEventHandlers: function() {
            if (typeof google !== 'undefined')
                BK.home.setupMap();
        },

        /**
         * @method setupHero
         * @memberOf BK.home
         * 
         * Set up the homepage hero carousel
         * 
         * @return {void}
         */
        setupHero: function() {
        // Only load in the correct images for Mobile or Desktop when appropriate
        // Lazy load the other images when/if required
        if ($(window).width() < 768) {
                $('.carouselItem .mainImage img.mobile-img').each(function( index ) {
                $( this ).attr("src", $(this).data('src'));     
            });
            } else {
                $('.carouselItem .mainImage img.big-img').each(function( index ) {
                $( this ).attr("src", $(this).data('src'));     
            });
        }
            
        $(window).resize(function() {
            if ($(window).width() < 768) {
                $('.carouselItem .mainImage img.mobile-img').each(function( index ) {
                    $( this ).attr("src", $(this).data('src'));     
                });
            } else {
                $('.carouselItem .mainImage img.big-img').each(function( index ) {
                    $( this ).attr("src", $(this).data('src'));     
                });
            }  
        });            
            
            var itemsCount = $(".heroCarousel").children().length;
            $(".heroCarousel").owlCarousel({
                loop: itemsCount <= 1 ? false : true,
                nav: true,
                center: true,
                items: 1,
                navText: itemsCount <= 1 ?  [] : [ '<div class="hover"></div><div class="arrow"></div>', '<div class="hover"></div><div class="arrow"></div>' ],
                margin: 0,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: false,
                smartSpeed: 500,
                dotsSpeed: 500
            });

            
            // var owl = $('.heroCarousel').data('owlCarousel');
              
            $('.heroCarousel .owl-controls .owl-dots .owl-dot').on('click', function(e) {
                // ga('send','event','carousel','click','browse');
                BK.analytics.track(['send','event','carousel','click','browse']);
            });
            
            $('.carouselItem .mainImage img.big-img').first().load(function(){
            
                // Adjust arrows after image is loaded.
                //var itemH  = $('.heroCarousel .owl-item.center').height();
                var itemH = $('.carouselItem .mainImage img.big-img').first().height();
                var arrowH = $('.heroCarousel .owl-controls .owl-prev .arrow').height();
                
                // Should divide by 2. But use 1.6 to move up a bit.
                var bottom = (itemH - arrowH) / 1.6;
                $('.heroCarousel .owl-controls .owl-nav .owl-prev .arrow').css('bottom', bottom + 'px');
                $('.heroCarousel .owl-controls .owl-nav .owl-next .arrow').css('bottom', bottom + 'px');
            });
            
        },


        setupTweets: function() {
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
        var isIphone = (ua.indexOf('iphone') != -1);
        var isIpod = (ua.indexOf('ipod') != -1);
        var iphone4 = (window.screen.height <= (960 / 2)); // iPhone4 or Below
        var iphone5 = (window.screen.height >= (1136 / 2)); // iPhone5+
        if (isIphone && iphone4 || isIpod || isAndroid) {
              $('#flickWrapper').hide();
              $('.homeSocial').hide();
              } else {
                if($('#flickWrapper').length){  // build flicker only when the Social Home is published
                  BK.home.buildFlicker();
                }
              

                      };
        },

        buildFlicker: function() {
            var $wrapper = $('#flickWrapper');
            var mqMobileMatch = BK.getMq('mobile').matches;
            var mqTabletMatch = BK.getMq('tablet').matches;
            
            $.when($.getJSON(Drupal.settings.basePath + Drupal.settings.pathPrefix + 'instagram_feed'))
                .then(function(instagramResponse) {
                    var instas = instagramResponse[0], items = [], i = 0, a, b;
                    a = instagramResponse;
                    
                    // if(instas.length > tweets.length) {
                        // a = instas;
                        // b = tweets;
                    // } else {
                        // a = tweets;
                        // b = instas;
                    // }

                    for(;i<a.length;i++) {
                        // Limit to 10 items only for mobile and tablet
                        if((mqMobileMatch || mqTabletMatch) && items.length >= 10)
                            continue;
                            
                        items.push(a[i]);
                        // if(b[i]) items.push(b[i]);

                        items[i].isTwitter = (items[i].source === 'twitter');
                    }

                    $wrapper.append(Mustache.render(templates.card, { items: items }));
                })
                .done(function() {
                    var $ul = $wrapper.find('ul'),
                        $li = $wrapper.find('li'),
                        totalWidth = $li.length * $li.eq(0).outerWidth(true);

                    $ul.width(totalWidth);

                    bkFlicker = new Inflickity($wrapper[0], { friction: 0.05, animationDuration: 300 });

                    $wrapper.on('click touchend', '.flipContainer', BK.home.checkScroll);

                });
        },

        checkScroll: function() {
            var $clickedEl = $(this);
            setTimeout(function() { BK.home.flipCard($clickedEl) }, 50);
        },

        flipCard: function($clickedEl) {
            if (bkFlicker.isScrolling === false || bkFlicker.isScrolling === 'undefined') {
                var index = $clickedEl.parent().index();

                $('.flick').find('> .item:eq(' + index + ') > .flipContainer').toggleClass('hover');
            }
        }
    }
}();

BK = BK || {};
BK.other = function() {
    return {
        init: function() {

            BK.other.setupHero();
        },

        setupHero: function() {
            $(".heroCarousel").owlCarousel({
                autoPlay: 4000,
                slideSpeed: 500,
                paginationSpeed: 500,
                singleItem: true
            });
        }
    }
}();

// TODO: Move this into a separate file
BK = BK || {};
BK.nav = function() {

    var $mainNav = $('.mainNav');

    return {
        init: function() {
            BK.nav.attachEventHandlers();
        },
        working: function(tf){
            if (tf) {
                $('body').addClass('wait');
                $(this).addClass('wait');
            } else {
                $('body').removeClass('wait').addClass('doneWait');
                $(this).removeClass('wait').addClass('doneWait');
            };
        },
        attachEventHandlers: function() {
            var mqMobileMatch = BK.getMq('mobile').matches;

            // Ensures the nav will always display when moving from mobile to tablet
            BK.getMq('mobile').addListener(function(mql) {
                mqMobileMatch = mql.matches;

                if (mqMobileMatch) {
                    $mainNav.find('.formArea').removeAttr('style');
                    $mainNav.find('.navInput').removeAttr('style');
                } else {
                    $mainNav.show();
                    $mainNav.find('.subNav').hide().parent('li').removeClass('expanded');
                }
            });


            $('.mobileMenu').on('click', function() {
                var $mainNav = $('.mainNav');

                if ($mainNav.is(':visible')) {
                    $mainNav.slideUp();
                    $(this).removeClass('expanded');
                }
                else{
                    $mainNav.slideDown();
                    $(this).addClass('expanded');
                }

            });

            $('.subNavToggle').on('click', function(e) {
                if (mqMobileMatch) {
                    e.preventDefault();
                    $(this).parent('li').toggleClass('expanded').find('> .subNav').slideToggle();
                }
            })

            $('#mainNav .site-search.hasForm').on('click', '> a', function(e) {
                e.preventDefault();

                var $closestLi  = $(this).closest('li'),
                    $formArea   = $(this).next(),
                    $formInput  = $formArea.find('.navInput'),
                    $formSubmit = $formArea.find('.navInputSubmit');

                if ($closestLi.hasClass('formVisible')) {
                    $formArea.animate({
                        left:'100%',
                        avoidCSSTransitions:true
                    });
                    $closestLi.removeClass('formVisible');
                }
                else{
                    if(!mqMobileMatch) {
                      $formInput.outerWidth( $closestLi.outerWidth() - $formSubmit.outerWidth() );
                      $formArea.outerWidth( $formInput.outerWidth() + $formSubmit.outerWidth() );
                    }
                    
                    $formArea.animate({
                        left:'0',
                        avoidCSSTransitions:true
                    });
                    $closestLi.addClass('formVisible');
                }

            });

            $('.footerLinks h4').on('click', function(e) {
                if (mqMobileMatch) {
                    $(this).toggleClass('expanded').next().slideToggle();    
                }
            });

            $('#toTop').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            });
        }
    }
}();

BK = BK || {};
BK.productDetail = function() { 

    return {
        init: function() {

            BK.productDetail.attachEventHandlers();
            
            $('.nutrition-form').each(function() {
                new BKNutritionInfo(this);
            });

            $('.select-menu').each(function() {
                $(this).data('selectMenu', new BKSelectMenu(this));
            });

        },
        attachEventHandlers: function() {
        },
        showNutritionInfo: function( id ) {
            $('.nutrition-info').removeClass('active');
            $('#'+id).addClass('active');
        }
    } 
}();    

BKNutritionInfo = function(el) {
    this.$el = $(el);
    this.$items = this.$el.find('.nutrition-item');
    this.allergens = [];
    this.calc = new BKNutritionCalc();

    this.productHasVariants = this.$el.data('productHasVariants') || false;
    this.productHasIngredients = this.$el.data('productHasIngredients') || false;
    if(this.productHasIngredients) {
        this.ingredientCalc = new BKNutritionCalc();
    }

    this.templates = {
        nutrition: function() {
            var tmpl = BK.templates['mymeal-nutrition'];
            Mustache.parse(tmpl);

            return tmpl;
        }()
    };

    this.attachEventHandlers();

    var query = window.location.search;
    if(query && query.length > 1) {
        this.$el.addClass('isUpdate');

        var allParams = query.substr(1).split('&'), i = 0;
        for(;allParams[i];i++) {
            var param = allParams[i].split('=');

            if(param[0] === 'idx') {
                this.idx = param[1];
            }

            if(param[0] === 'excluded') {
               this.setExcludedIngredients(param[1]);
            }

            if(param[0] === 'variant') {
                this.$el.find('.nutrition-info-set-variant[value='+param[1]+']').trigger('click');
            }
        }
    }

    this.setData().render();

    return this;
};

BKNutritionInfo.prototype = {
    attachEventHandlers: function() {
        var self = this;

        self.$el.on('submit', function _onNutritionFormSubmit(e) {
            e.preventDefault();
        });

        self.$el.on('click', '.nutrition-add', function _onNutritionAddClick(e) {
            e.preventDefault();

            self.addToMeal();
        });

        self.$el.on('click', '.nutrition-update', function _onNutritionUpdateClick(e) {
            e.preventDefault();

            self.updateMeal();
        });

        self.$el.on('click', '.nutrition-info-set-variant', function _onNutritionNavClick(e) {
            e.preventDefault();
            var $this = $(this);
            self.$el.find('.nutrition-info-set-variant').removeClass('active');
            $this.addClass('active');

            self.setNutritionInfoVariant($this.val());
            self.setData().render();
        });

        self.$el.on('change', '.nutrition-item', function _onNutritionItemChange(e) {
            var $this = $(this);
            self.setData().render();
        });

        return self;
    },
    getExcludedIngredients: function() {
        var self = this, a = [];
        
        self.$items.filter('input[type=checkbox].nutrition-ingredient').not('input:checked').each(function() {
            a.push(BK_PRODUCT_NUTRITION[this.value]['id']);
        });

        return a;
    },
    setExcludedIngredients: function( str ) {
        var excluded = str.split(','), i = 0;
        for(;excluded[i];i++) {
            this.$el.find('input[value='+excluded[i]+']').trigger('click');
        }
    },
    getCustomProduct: function( data, excludes ) {
        var self = this;

        self.ingredientCalc.clear();
        self.ingredientCalc.addItem(data);

        var i = 0, j = excludes.length;
        for(;i<j;i++) {
            self.ingredientCalc.subtractItem(BK_PRODUCT_NUTRITION[excludes[i]]);
        }

        var customSandwich = $.extend({}, data, self.ingredientCalc.getTotals());
        customSandwich.label += ' (Custom)';

        return customSandwich;
    },
    getData: function() {
        var items = [];

        if(this.productHasVariants) {
            var variants = this.$items.filter('input.nutrition-variant-item:checked'), i = 0, variantData;

            for(;variants[i];i++) {
                variantData = BK_PRODUCT_NUTRITION[variants[i].value];
                if(variantData) items.push(variantData);
            }
        }

        if(this.productHasIngredients) {
            var productId = this.$items.filter('input.nutrition-ingredient-parent').val();
            var productData = BK_PRODUCT_NUTRITION[productId];
            var excludes = this.getExcludedIngredients();

            if(excludes.length) {
                productData = this.getCustomProduct( productData, excludes );
            }

            if(productData) items.push(productData);
        }

        return items;
    },
    setData: function() {
        var self = this;
        self.calc.clear();
        self.$items.each(function _forEachNutritionItem() {
            var $item = $(this);

            if(
                $item.is('input[type=hidden].nutrition-ingredient') ||
                $item.is('input.nutrition-variant-item:checked') ||
                $item.is('input.nutrition-ingredient:checked')
            ) {
                var data = BK_PRODUCT_NUTRITION[$item.val()];

                if('allergens' in data) {
                    self.allergens = self.allergens.concat(data.allergens);
                }

                self.calc.addItem(data);
            } else if ($item.is('input.nutrition-ingredient-parent')){
                // this entire elseif branch is a hack to get allergens to display when no ingredients have
                // allergen data attached to them in the CMS.  
                var data = BK_PRODUCT_NUTRITION[$item.val()];
                if('allergens' in data) {
            
                    self.allergens = self.allergens.concat(data.allergens);
                }
            }
        });

        return self;
    },
    setNutritionInfoVariant: function( size ) {
        this.$items.each(function _forEachOption() { 
            var $option = $(this), id = $option.data(size + 'Id');

            if(id) {
                $option.val(id);

                if($option.is('.select-menu-option-input')) {
                    $option.next('.select-menu-option-label').text(BK_PRODUCT_NUTRITION[ id ].label);

                    if($option.is('input:checked')) {
                        $option.closest('.select-menu').find('.select-menu-label').text(BK_PRODUCT_NUTRITION[ id ].label);
                    }
                }
            }
        });

        return this;
    },
    addToMeal: function() {
        BK.mymeal.addItems(this.getData(), true).render();

        return this;
    },
    updateMeal: function() {
        BK.mymeal.updateItem(this.getData()[0], this.idx).render();

        return this;
    },
    render: function() {
        var nutrition = Mustache.render(this.templates.nutrition, {
            nutrition: this.calc.getRoundedTotals(),
            allergens: BK.util.getUniqueArray( this.allergens ).join(", "),
            isMyMeal: false,
            isVisible: true
        });
        this.$el.next('.nutrition-content').replaceWith(nutrition);

        return this;
    }
};

function BKSelectMenu(el) {
    this.$el = $(el);
    this.$label = this.$el.find('.select-menu-label');
    this.$value = this.$el.find('.select-menu-value');
    this.attachEventHandlers();

    return this;
};

BKSelectMenu.prototype = {
    attachEventHandlers : function() {
        var self = this;
 
        self.$el.on('change', '.select-menu-option-input', function() {
            var $option = $(this);
                $label = $option.next();

            self.$value.val($option.val());
            self.$label.text($label.text()).trigger('click');
        });

        return self;
    }
};

BK = BK || {};
BK.mymeal = function() {

    var store = window.sessionStorage,
        templates = {},
        cachedData = [],
        calc = new BKNutritionCalc();

    return {
        $el: null,
        init: function() {

            // Get the templates
            templates = {
                modal: function() {
                    var tmpl = BK.templates['mymeal-modal'];
                    Mustache.parse(tmpl);
                    return tmpl;
                }(),
                items: function() {
                    var tmpl = BK.templates['mymeal-items'];
                    Mustache.parse(tmpl);
                    return tmpl;
                }(),
                nutrition: function() {
                    var tmpl = BK.templates['mymeal-nutrition'];
                    Mustache.parse(tmpl);
                    return tmpl;
                }()
            };

            this.addItems(BK.mymeal.getStoredData()).render();

            return this;
        },
        attachEventHandlers: function() {
            var self = this;

            self.$el.on('click', '.delete', function _onMyMealItemDelete(e) {
                e.preventDefault();

                self.deleteItem($(this).data('itemIndex')).render();
            });

            self.$el.on('shown.bs.modal', function _onBSModalShown(e) {
                $('body').addClass('mymeal-is-active');
            });

            self.$el.on('hide.bs.modal', function _onBSModalShown(e) {
                $('body').removeClass('mymeal-is-active');
            });

            self.$el.on('click', '.bk-btn-print', function _onPrintClick(e) {
                 window.print();
            });

            return this;
        },
        getStoredData: function() {
            return JSON.parse(store.getItem('bk_mymeal_data')) || [];
        },
        setStoredData: function() {
            store.setItem('bk_mymeal_data', JSON.stringify(cachedData));
            return this;
        },
        addItems: function( items, store ) {
            if(items.length) {
                var i = 0, j = items.length;

                for(;i<j;i++) {
                    calc.addItem(items[i]);
                    cachedData.push(items[i]);
                }

                if(store) this.setStoredData();
            }

            return this;
        },
        updateItem: function( item, index ) {
            calc.subtractItem(cachedData[index]);
            cachedData[index] = item;
            calc.addItem(cachedData[index]);
            this.setStoredData();

            return this;
        },
        deleteItem: function( index ) {            
            if(cachedData[index]) {
                calc.subtractItem(cachedData[index]);
                cachedData.splice(index, 1);
                this.setStoredData();
            }

            return this;
        },
        render: function() {
            if(this.$el) {
                this.$el.find('.items-table').replaceWith(this.renderItems());
                this.$el.find('.nutrition-content').replaceWith(this.renderNutrition());
            } else {
                var modal = Mustache.render(templates.modal, {
                    nutrition: this.renderNutrition(),
                    items: this.renderItems()
                });

                this.$el = $(modal);
                this.$el.appendTo('body');
                this.attachEventHandlers();
            }

            return this;
        },
        renderItems: function() {

            for(var i in cachedData) {
                cachedData[i]['idx'] = Number(i);
                cachedData[i]['roundedCalories'] = calc.round('calories', cachedData[i].calories);
            }

            return Mustache.render(templates.items, {
                items: cachedData,
                totalCalories: calc.getRoundedTotals('calories'),
                params: function() {
                    return function(text, render) {
                        var out = '', p = [];

                        p.push('idx='+this.idx);

                        if(this.variant) p.push('variant='+this.variant);
                        if(this.excluded && this.excluded.length) p.push('excluded=' + this.excluded.join(','));

                        out = '?'+p.join('&');

                        return render(out);
                    }
                }
            });
        },
        renderNutrition: function() {
            var allergens = [];
            for(var i in cachedData) {
                if('allergens' in cachedData[i]) {
                    allergens = allergens.concat(cachedData[i].allergens);
                }
            }

            return Mustache.render(templates.nutrition, {
                nutrition: calc.getRoundedTotals(),
                allergens: BK.util.getUniqueArray( allergens ).join(", "),
                isVisible: !!cachedData.length,
                isMyMeal: true
            });
        }
    };
}();

BK = BK || {};
BK.menu = function() {

    var templates = {};

    function findRightMost( item ) {
        var top = item.offset().top,
            rightMost;

        BK.menu.items.filter(function(index) {
            if ( $(this).offset().top === top ) {
                rightMost = this;
            }
        });

        return $(rightMost);
    }

    return {
        items: false,
        detail: {
            $el: false,
            open: function( $item ) {
                var html = BK.menu.render(BK_MENU_PRODUCTS[$item.data('productId')]);
                findRightMost($item).after(html);

                BK.menu.detail.$el = $('#product-dropdown');
                BK.menu.detail.$el.offset();
                BK.menu.detail.$el.show().animate({ height: BK.menu.detail.$el.css('max-height') },500,'swing');
                $('html,body').animate({scrollTop: $(BK.menu.detail.$el).offset().top}, 500);
                BK.menu.items.removeClass('active');
                $item.addClass('active');
            },
            close: function( callback ) {
                var callback = callback || function() { return };

                BK.menu.detail.$el.animate({ height: 0 },500,'swing',function() {
                    BK.menu.items.removeClass('active');
                    BK.menu.detail.$el.remove();

                    callback();
                });
            }
        },
        init: function() {
            // pre-cache items to prevent excessive DOM traversal
            this.items = $('.food-item');
            // pre-cache template
            templates = {
                detail: function() {
                    var tmpl = BK.templates['product-detail'];
                    Mustache.parse(tmpl);
                    return tmpl;
                }()
            };

            this.attachEventHandlers();
        },
        attachEventHandlers: function() {
            var self = this;
            self.items.on('click', self.handleMenuItem);

            BK.getMq('mobile').addListener(function(mql) {
                if(self.items.filter('.active').length) {
                    self.detail.$el.hide().remove();
                    self.detail.open(BK.menu.items.filter('.active'));
                }
            });

            $('body').on('click', '#product-dropdown .close', self.handleItemDetailClose);
        },
        handleItemDetailClose: function(e) {
            e.preventDefault();

            BK.menu.detail.close();
        },
        handleMenuItem: function(e) {
            var $this = $(this),
                self = BK.menu;

            self.detail.$el = $('#product-dropdown');

            if ( self.detail.$el.length ) {
                self.detail.close(function() {
                    if(self.detail.$el.data('productId') !== $this.data('productId')) {
                        self.detail.open($this);
                    }
                });
            }
            else {
                self.detail.open($this);
            }
        },
        render: function( data ) {
            return Mustache.render(templates.detail, data);
        }
    }
}();

window.onload = BK.init;
});

function sendMail() {

window.open("http://api.addthis.com/oexchange/0.8/forward/email/offer?url=" + window.location);
}

function contactUsIframe_ME_onLoad(iframe) {
    
    // Move focus to top of the page
    window.scrollTo(0,0);
}
