// MEC Single Event Displayer
var mecSingleEventDisplayer = {
    getSinglePage: function(id, occurrence, ajaxurl, layout)
    {
        if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
        jQuery('.mec-modal-result').addClass('mec-modal-preloader');

        jQuery.ajax(
        {
            url: ajaxurl,
            data: "action=mec_load_single_page&id="+id+(occurrence != null ? "&occurrence="+occurrence : "")+"&layout="+layout,
            type: "get",
            success: function(response)
            {
                jQuery('.mec-modal-result').removeClass("mec-modal-preloader");
                lity(response);
            },
            error: function()
            {
            }
        });
    }
};

// MEC SEARCH FORM PLUGIN
(function($)
{
    $.fn.mecSearchForm = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            search_form_element: '',
            atts: '',
            callback: function()
            {
            }
        }, options);
        
        $("#mec_sf_category_"+settings.id).on('change', function(e)
        {
            search();
        });
        
        $("#mec_sf_location_"+settings.id).on('change', function(e)
        {
            search();
        });
        
        $("#mec_sf_organizer_"+settings.id).on('change', function(e)
        {
            search();
        });
        
        $("#mec_sf_label_"+settings.id).on('change', function(e)
        {
            search();
        });
        
        $("#mec_sf_s_"+settings.id).on('change', function(e)
        {
            search();
        });

        $("#mec_sf_month_"+settings.id).on('change', function(e)
        {
            search();
        });

        $("#mec_sf_year_"+settings.id).on('change', function(e)
        {
            // Change Month to January if it's set to ignore date and year changed
            if($("#mec_sf_month_"+settings.id).val() === 'ignore_date') $("#mec_sf_month_"+settings.id).val('01');
            
            search();
        });
        
        function search()
        {
            var s = $("#mec_sf_s_"+settings.id).length ? $("#mec_sf_s_"+settings.id).val() : '';
            var category = $("#mec_sf_category_"+settings.id).length ? $("#mec_sf_category_"+settings.id).val() : '';
            var location = $("#mec_sf_location_"+settings.id).length ? $("#mec_sf_location_"+settings.id).val() : '';
            var organizer = $("#mec_sf_organizer_"+settings.id).length ? $("#mec_sf_organizer_"+settings.id).val() : '';
            var label = $("#mec_sf_label_"+settings.id).length ? $("#mec_sf_label_"+settings.id).val() : '';
            var month = $("#mec_sf_month_"+settings.id).length ? $("#mec_sf_month_"+settings.id).val() : '';
            var year = $("#mec_sf_year_"+settings.id).length ? $("#mec_sf_year_"+settings.id).val() : '';
            var skip_date = false;
            
            if(month === 'ignore_date') skip_date = true;

            // Skip filter by date
            if(skip_date === true)
            {
                month = '';
                year = '';
            }
            
            var atts = settings.atts+'&sf[s]='+s+'&sf[month]='+month+'&sf[year]='+year+'&sf[category]='+category+'&sf[location]='+location+'&sf[organizer]='+organizer+'&sf[label]='+label;
            settings.callback(atts);
        }
    };
    
}(jQuery));

// MEC GOOGLE MAPS PLUGIN
(function($)
{
    $.fn.mecGoogleMaps = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            latitude: 0,
            longitude: 0,
            autoinit: true,
            zoom: 14,
            icon: '../img/m-01.png',
            markers: {},
            sf: {},
            HTML5geolocation: 0,
            getDirection: 0,
            directionOptions:
            {
                form: '#mec_get_direction_form',
                reset: '.mec-map-get-direction-reset',
                addr: '#mec_get_direction_addr',
                destination: {},
            },
        }, options);

        var bounds;
        var map;
        var infowindow;
        var loadedMarkers = new Array();

        var canvas = this;
        var DOM = canvas[0];

        // Init the Map
        if(settings.autoinit) init();
        
        function init()
        {
            // Search Widget
            if(settings.sf.container !== '')
            {
                $(settings.sf.container).mecSearchForm(
                {
                    id: settings.id,
                    atts: settings.atts,
                    callback: function(atts)
                    {
                        settings.atts = atts;
                        getMarkers();
                    }
                });
            }

            // Create the options
            bounds = new google.maps.LatLngBounds();
            var center = new google.maps.LatLng(settings.latitude, settings.longitude);

            var mapOptions = {
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: center,
                zoom: settings.zoom,
                styles: settings.styles,
            };

            // Init map
            map = new google.maps.Map(DOM, mapOptions);

            // Init Infowindow
            infowindow = new google.maps.InfoWindow(
            {
                pixelOffset: new google.maps.Size(0, -37)
            });

            // Load Markers
            loadMarkers(settings.markers);

            // Initialize get direction feature
            if(settings.getDirection === 1) initSimpleGetDirection();
            else if(settings.getDirection === 2) initAdvancedGetDirection();

            // Geolocation
            if(settings.HTML5geolocation && navigator.geolocation)
            {
                navigator.geolocation.getCurrentPosition(function(position)
                {
                    var center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    var zoom = map.getZoom();

                    if(zoom <= 6) zoom = zoom + 5;
                    else if(zoom <= 10) zoom = zoom + 3;
                    else if(zoom <= 14) zoom = zoom + 2;
                    else if(zoom <= 18) zoom = zoom + 1;

                    map.panTo(center);
                    map.setZoom(zoom);
                });
            }
        }
        
        function loadMarkers(markers)
        {
            var f = 0;
            for(var i in markers)
            {
                f++;
                var dataMarker = markers[i];

                var marker = new RichMarker(
                {
                    position: new google.maps.LatLng(dataMarker.latitude, dataMarker.longitude),
                    map: map,
                    event_ids: dataMarker.event_ids,
                    infowindow: dataMarker.infowindow,
                    lightbox: dataMarker.lightbox,
                    icon: (dataMarker.icon ? dataMarker.icon : settings.icon),
                    content: '<div class="mec-marker-container"><span class="mec-marker-wrap"><span class="mec-marker">'+dataMarker.count+'</span><span class="mec-marker-pulse-wrap"><span class="mec-marker-pulse"></span></span></span></div>',
                    shadow: 'none'
                });

                // Marker Info-Window
                google.maps.event.addListener(marker, 'mouseover', function(event)
                {
                    infowindow.close();
                    infowindow.setContent(this.infowindow);
                    infowindow.open(map, this);
                });

                // Marker Lightbox
                google.maps.event.addListener(marker, 'click', function(event)
                {
                    lity(this.lightbox);
                });

                // extend the bounds to include each marker's position
                bounds.extend(marker.position);
                
                // Added to Markers
                loadedMarkers.push(marker);
            }
            
            if(f > 1) map.fitBounds(bounds);

            // Set map center if only 1 marker found
            if(f === 1)
            {
                map.setCenter(new google.maps.LatLng(dataMarker.latitude, dataMarker.longitude));
            }
        }
        
        function getMarkers()
        {
            // Add loader
            $("#mec_googlemap_canvas"+settings.id).addClass("mec-loading");
            
            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_map_get_markers&"+settings.atts,
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    // Remove Markers
                    removeMarkers();
                    
                    // Load Markers
                    loadMarkers(response.markers);
                    
                    // Remove loader
                    $("#mec_googlemap_canvas"+settings.id).removeClass("mec-loading");
                },
                error: function()
                {
                    // Remove loader
                    $("#mec_googlemap_canvas"+settings.id).removeClass("mec-loading");
                }
            });
        }
        
        function removeMarkers()
        {
            bounds = new google.maps.LatLngBounds();
            
            if(loadedMarkers)
            {
                for(i=0; i < loadedMarkers.length; i++) loadedMarkers[i].setMap(null);
                loadedMarkers.length = 0;
            }
        }
        
        var directionsDisplay;
        var directionsService;
        var startMarker;
        var endMarker;

        function initSimpleGetDirection()
        {
            $(settings.directionOptions.form).on('submit', function(event)
            {
                event.preventDefault();

                var from = $(settings.directionOptions.addr).val();
                var dest = new google.maps.LatLng(settings.directionOptions.destination.latitude, settings.directionOptions.destination.longitude);

                // Reset the direction
                if(typeof directionsDisplay !== 'undefined')
                {
                    directionsDisplay.setMap(null);
                    startMarker.setMap(null);
                    endMarker.setMap(null);
                }

                // Fade Google Maps canvas
                $(canvas).fadeTo(300, .4);

                directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
                directionsService = new google.maps.DirectionsService();

                var request = {
                    origin: from, 
                    destination: dest,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };

                directionsService.route(request, function(response, status)
                {
                    if(status === google.maps.DirectionsStatus.OK)
                    {
                        directionsDisplay.setDirections(response);
                        directionsDisplay.setMap(map);

                        var leg = response.routes[0].legs[0];
                        startMarker = new google.maps.Marker(
                        {
                            position: leg.start_location,
                            map: map,
                            icon: settings.directionOptions.startMarker,
                        });

                        endMarker = new google.maps.Marker(
                        {
                            position: leg.end_location,
                            map: map,
                            icon: settings.directionOptions.endMarker,
                        });
                    }

                    // Fade Google Maps canvas
                    $(canvas).fadeTo(300, 1);
                });

                // Show reset button
                $(settings.directionOptions.reset).removeClass('mec-util-hidden');
            });

            $(settings.directionOptions.reset).on('click', function(event)
            {
                $(settings.directionOptions.addr).val('');
                $(settings.directionOptions.form).submit();

                // Hide reset button
                $(settings.directionOptions.reset).addClass('mec-util-hidden');
            });
        }

        function initAdvancedGetDirection()
        {
            $(settings.directionOptions.form).on('submit', function(event)
            {
                event.preventDefault();

                var from = $(settings.directionOptions.addr).val();
                var url = 'https://maps.google.com/?saddr='+encodeURIComponent(from)+'&daddr='+settings.directionOptions.destination.latitude+','+settings.directionOptions.destination.longitude;

                window.open(url);
            });
        }

        return {
            init: function()
            {
                init();
            }
        };
    };
    
}(jQuery));

// MEC FULL CALENDAR PLUGIN
(function($)
{
    $.fn.mecFullCalendar = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            ajax_url: '',
            sf: {},
            skin: '',
        }, options);
        
        // Set onclick Listeners
        setListeners();
        
        var sf;
        function setListeners()
        {
            // Search Widget
            if(settings.sf.container !== '')
            {
                sf = $(settings.sf.container).mecSearchForm(
                {
                    id: settings.id,
                    atts: settings.atts,
                    callback: function(atts)
                    {
                        settings.atts = atts;
                        search();
                    }
                });
            }
            
            // Add the onclick event
            $("#mec_skin_"+settings.id+" .mec-totalcal-box .mec-totalcal-view span").on('click', function(e)
            {
                e.preventDefault();
                var skin = $(this).data('skin');

                $(this).addClass('mec-totalcalview-selected').siblings().removeClass('mec-totalcalview-selected');
                
                loadSkin(skin);
            });
        }
        
        function loadSkin(skin)
        {
            // Set new Skin
            settings.skin = skin;
            
            // Add Loading Class
        if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
        jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_full_calendar_switch_skin&skin="+skin+"&"+settings.atts+"&apply_sf_date=1&sed="+settings.sed_method,
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    $("#mec_full_calendar_container_"+settings.id).html(response);
                    
                    // Remove loader
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");
                },
                error: function()
                {
                }
            });
        }
        
        function search()
        {
            // Add Loading Class
        if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
        jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');
            
            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_full_calendar_switch_skin&skin="+settings.skin+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    $("#mec_full_calendar_container_"+settings.id).html(response);
                    
                    // Remove loader
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");
                },
                error: function()
                {
                }
            });
        }
    };
    
}(jQuery));

// MEC YEARLY VIEW PLUGIN
(function($)
{
    $.fn.mecYearlyView = function(options)
    {
        var active_year;

        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            today: null,
            id: 0,
            events_label: 'Events',
            event_label: 'Event',
            year_navigator: 0,
            atts: '',
            next_year: {},
            sf: {},
            ajax_url: '',
        }, options);

        // Initialize Year Navigator
        if(settings.year_navigator) initYearNavigator();

        // Load Next Year in background
        if(settings.year_navigator) setYear(settings.next_year.year, true);

        // Set onclick Listeners
        setListeners();

        // load more
        $(document).on("click", "#mec_skin_events_"+settings.id+" .mec-load-more-button", function()
        {
            var year = $(this).parent().parent().parent().data('year-id');
            loadMoreButton(year);
        });

        // Search Widget
        if(settings.sf.container !== '')
        {
            sf = $(settings.sf.container).mecSearchForm(
            {
                id: settings.id,
                atts: settings.atts,
                callback: function(atts)
                {
                    settings.atts = atts;
                    search(active_year);
                }
            });
        }

        function initYearNavigator()
        {
            // Remove the onclick event
            $("#mec_skin_"+settings.id+" .mec-load-year").off("click");

            // Add onclick event
            $("#mec_skin_"+settings.id+" .mec-load-year").on("click", function()
            {
                var year = $(this).data("mec-year");
                setYear(year);
            });
        }

        function search(year)
        {
            // Add Loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_yearly_view_load_year&mec_year="+year+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    active_year = response.current_year.year;

                    // Append Year
                    $("#mec_skin_events_"+settings.id).html('<div class="mec-year-container" id="mec_yearly_view_year_'+settings.id+'_'+response.current_year.id+'" data-year-id="'+response.current_year.id+'">'+response.year+'</div>');

                    // Append Year Navigator
                    $("#mec_skin_"+settings.id+" .mec-yearly-title-sec").append('<div class="mec-year-navigator" id="mec_year_navigator_'+settings.id+'_'+response.current_year.id+'">'+response.navigator+'</div>');

                    // Re-initialize Year Navigator
                    initYearNavigator();

                    // Set onclick Listeners
                    setListeners();

                    // Toggle Year
                    toggleYear(response.current_year.id);

                    // Remove loading Class
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");
                        
                },
                error: function()
                {
                }
            });
        }

        function setYear(year, do_in_background)
        {
            if(typeof do_in_background === "undefined") do_in_background = false;

            var year_id = year;
            active_year = year;

            // Year exists so we just show it
            if($("#mec_yearly_view_year_"+settings.id+"_"+year_id).length)
            {
                // Toggle Year
                toggleYear(year_id);
            }
            else
            {
                if(!do_in_background)
                {
                    // Add Loading Class
                    if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
                    jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');
                }

                $.ajax(
                {
                    url: settings.ajax_url,
                    data: "action=mec_yearly_view_load_year&mec_year="+year+"&"+settings.atts+"&apply_sf_date=0",
                    dataType: "json",
                    type: "post",
                    success: function(response)
                    {
                        // Append Year
                        $("#mec_skin_events_"+settings.id).append('<div class="mec-year-container" id="mec_yearly_view_year_'+settings.id+'_'+response.current_year.id+'" data-year-id="'+response.current_year.id+'">'+response.year+'</div>');

                        // Append Year Navigator
                        $("#mec_skin_"+settings.id+" .mec-yearly-title-sec").append('<div class="mec-year-navigator" id="mec_year_navigator_'+settings.id+'_'+response.current_year.id+'">'+response.navigator+'</div>');

                        // Re-initialize Year Navigator
                        initYearNavigator();

                        // Set onclick Listeners
                        setListeners();

                        if(!do_in_background)
                        {
                            // Toggle Year
                            toggleYear(response.current_year.id);

                            // Remove loading Class
                            $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                            // Set Year Filter values in search widget
                            $("#mec_sf_year_"+settings.id).val(year);
                        }
                        else
                        {
                            $("#mec_yearly_view_year_"+settings.id+"_"+response.current_year.id).hide();
                            $("#mec_year_navigator_"+settings.id+"_"+response.current_year.id).hide();
                        }
                    },
                    error: function()
                    {
                    }
                });
            }
        }

        function toggleYear(year_id)
        {
            // Toggle Year Navigator
            $("#mec_skin_"+settings.id+" .mec-year-navigator").hide();
            $("#mec_year_navigator_"+settings.id+"_"+year_id).show();

            // Toggle Year
            $("#mec_skin_"+settings.id+" .mec-year-container").hide();
            $("#mec_yearly_view_year_"+settings.id+"_"+year_id).show();
        }

        var sf;
        function setListeners()
        {
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-agenda-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);
                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }

        function loadMoreButton(year)
        {
            var $max_count, $current_count = 0;
            $max_count = $("#mec_yearly_view_year_"+settings.id+"_"+year+ " .mec-yearly-max").data('count');
            $current_count = $("#mec_yearly_view_year_"+settings.id+"_"+year+ " .mec-util-hidden").length;

            if($current_count > 10)
            {
                for(var i = 0; i < 10; i++)
                {
                    $("#mec_yearly_view_year_"+settings.id+"_"+year+ " .mec-util-hidden").slice(0, 2).each(function()
                    {
                        $(this).removeClass('mec-util-hidden');
                    });
                }
            }

            if($current_count < 10 && $current_count != 0)
            {
                for(var j = 0; j < $current_count; j++)
                {
                    $("#mec_yearly_view_year_"+settings.id+"_"+year+ " .mec-util-hidden").slice(0, 2).each(function()
                    {
                        $(this).removeClass('mec-util-hidden');
                        $("#mec_yearly_view_year_"+settings.id+"_"+year+ " .mec-load-more-wrap").css('display', 'none');
                    });
                }
            }
        }
    };

}(jQuery));

// MEC MONTHLY VIEW PLUGIN
(function($)
{
    $.fn.mecMonthlyView = function(options)
    {
        var active_month;
        var active_year;
        
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            today: null,
            id: 0,
            events_label: 'Events',
            event_label: 'Event',
            month_navigator: 0,
            atts: '',
            active_month: {},
            next_month: {},
            sf: {},
            ajax_url: '',
        }, options);

        // Initialize Month Navigator
        if(settings.month_navigator) initMonthNavigator();
        
        // Load Next Month in background
        setMonth(settings.next_month.year, settings.next_month.month, true);

        active_month = settings.active_month.month;
        active_year = settings.active_month.year;
        
        // Set onclick Listeners
        setListeners();
        
        // Search Widget
        if(settings.sf.container !== '')
        {
            sf = $(settings.sf.container).mecSearchForm(
            {
                id: settings.id,
                atts: settings.atts,
                callback: function(atts)
                {
                    settings.atts = atts;
                    search(active_year, active_month);
                }
            });
        }
        
        function initMonthNavigator()
        {
            // Remove the onclick event
            $("#mec_skin_"+settings.id+" .mec-load-month").off("click");

            // Add onclick event
            $("#mec_skin_"+settings.id+" .mec-load-month").on("click", function()
            {
                var year = $(this).data("mec-year");
                var month = $(this).data("mec-month");

                setMonth(year, month);
            });
        }
        
        function search(year, month)
        {
            // Add Loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');
            
            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_monthly_view_load_month&mec_year="+year+"&mec_month="+month+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    active_month = response.current_month.month;
                    active_year = response.current_month.year;
            
                    // Append Month
                    $("#mec_skin_events_"+settings.id).html('<div class="mec-month-container" id="mec_monthly_view_month_'+settings.id+'_'+response.current_month.id+'" data-month-id="'+response.current_month.id+'">'+response.month+'</div>');

                    // Append Month Navigator
                    $("#mec_skin_"+settings.id+" .mec-skin-monthly-view-month-navigator-container").html('<div class="mec-month-navigator" id="mec_month_navigator_'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                    // Append Events Side
                    $("#mec_skin_"+settings.id+" .mec-calendar-events-side").html('<div class="mec-month-side" id="mec_month_side_'+settings.id+'_'+response.current_month.id+'">'+response.events_side+'</div>');

                    // Re-initialize Month Navigator
                    initMonthNavigator();

                    // Set onclick Listeners
                    setListeners();

                    // Toggle Month
                    toggleMonth(response.current_month.id);

                    // Remove loading Class
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                },
                error: function()
                {
                }
            });
        }
        
        function setMonth(year, month, do_in_background)
        {
            if(typeof do_in_background === "undefined") do_in_background = false;
            var month_id = year+""+month;

            if(!do_in_background)
            {
                active_month = month;
                active_year = year;
            }
            
            // Month exists so we just show it
            if($("#mec_monthly_view_month_"+settings.id+"_"+month_id).length)
            {
                // Toggle Month
                toggleMonth(month_id);
            }
            else
            {
                if(!do_in_background)
                {

                // Add Loading Class
                if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
                jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');
                }

                $.ajax(
                {
                    url: settings.ajax_url,
                    data: "action=mec_monthly_view_load_month&mec_year="+year+"&mec_month="+month+"&"+settings.atts+"&apply_sf_date=0",
                    dataType: "json",
                    type: "post",
                    success: function(response)
                    {
                        // Append Month
                        $("#mec_skin_events_"+settings.id).append('<div class="mec-month-container" id="mec_monthly_view_month_'+settings.id+'_'+response.current_month.id+'" data-month-id="'+response.current_month.id+'">'+response.month+'</div>');
                        
                        // Append Month Navigator
                        $("#mec_skin_"+settings.id+" .mec-skin-monthly-view-month-navigator-container").append('<div class="mec-month-navigator" id="mec_month_navigator_'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                        // Append Events Side
                        $("#mec_skin_"+settings.id+" .mec-calendar-events-side").append('<div class="mec-month-side" id="mec_month_side_'+settings.id+'_'+response.current_month.id+'">'+response.events_side+'</div>');

                        // Re-initialize Month Navigator
                        initMonthNavigator();

                        // Set onclick Listeners
                        setListeners();

                        if(!do_in_background)
                        {
                            // Toggle Month
                            toggleMonth(response.current_month.id);

                            // Remove loading Class
                            $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                            
                            // Set Month Filter values in search widget
                            $("#mec_sf_month_"+settings.id).val(month);
                            $("#mec_sf_year_"+settings.id).val(year);
                        }
                        else
                        {
                            $("#mec_monthly_view_month_"+settings.id+"_"+response.current_month.id).hide();
                            $("#mec_month_navigator_"+settings.id+"_"+response.current_month.id).hide();
                            $("#mec_month_side_"+settings.id+"_"+response.current_month.id).hide();
                        }
                    },
                    error: function()
                    {
                    }
                });
            }
        }

        function toggleMonth(month_id)
        {
            var active_month = $("#mec_skin_"+settings.id+" .mec-month-container-selected").data("month-id");
            var active_day = $("#mec_monthly_view_month_"+settings.id+"_"+active_month+" .mec-selected-day").data("day");

            if(active_day <= 9) active_day = "0"+active_day;

            // Toggle Month Navigator
            $("#mec_skin_"+settings.id+" .mec-month-navigator").hide();
            $("#mec_month_navigator_"+settings.id+"_"+month_id).show();

            // Toggle Month
            $("#mec_skin_"+settings.id+" .mec-month-container").hide();
            $("#mec_monthly_view_month_"+settings.id+"_"+month_id).show();

            // Add selected class
            $("#mec_skin_"+settings.id+" .mec-month-container").removeClass("mec-month-container-selected");
            $("#mec_monthly_view_month_"+settings.id+"_"+month_id).addClass("mec-month-container-selected");

            // Toggle Events Side
            $("#mec_skin_"+settings.id+" .mec-month-side").hide();
            $("#mec_month_side_"+settings.id+"_"+month_id).show();
        }
        
        var sf;
        function setListeners()
        {
            // Remove the onclick event
            $("#mec_skin_"+settings.id+" .mec-has-event").off("click");

            // Add the onclick event
            $("#mec_skin_"+settings.id+" .mec-has-event").on('click', function(e)
            {
                e.preventDefault();
                
                // define variables
                var $this = $(this), data_mec_cell = $this.data('mec-cell'), month_id = $this.data('month');

                $("#mec_monthly_view_month_"+settings.id+"_"+month_id+" .mec-calendar-day").removeClass('mec-selected-day');
                $this.addClass('mec-selected-day');

                $('#mec_month_side_'+settings.id+'_'+month_id+' .mec-calendar-events-sec:not([data-mec-cell=' + data_mec_cell + '])').slideUp();
                $('#mec_month_side_'+settings.id+'_'+month_id+' .mec-calendar-events-sec[data-mec-cell=' + data_mec_cell + ']').slideDown();

                $('#mec_monthly_view_month_'+settings.id+'_'+month_id+' .mec-calendar-events-sec:not([data-mec-cell=' + data_mec_cell + '])').slideUp();
                $('#mec_monthly_view_month_'+settings.id+'_'+month_id+' .mec-calendar-events-sec[data-mec-cell=' + data_mec_cell + ']').slideDown();
            });
            
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }
        
        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);
                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
    };

}(jQuery));

// MEC WEEKLY VIEW PLUGIN
(function($)
{
    $.fn.mecWeeklyView = function(options)
    {
        var active_year;
        var active_month;
        var active_week;
        var active_week_number;
        
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            today: null,
            week: 1,
            id: 0,
            changeWeekElement: '.mec-load-week',
            month_navigator: 0,
            atts: '',
            ajax_url: '',
            sf: {}
        }, options);
        
        // Search Widget
        if(settings.sf.container !== '')
        {
            $(settings.sf.container).mecSearchForm(
            {
                id: settings.id,
                atts: settings.atts,
                callback: function(atts)
                {
                    settings.atts = atts;
                    search(active_year, active_month, active_week);
                }
            });
        }
            
        // Set The Week
        setThisWeek(settings.month_id+settings.week);
        
        // Set Listeners
        setListeners();
        
        // Initialize Month Navigator
        if(settings.month_navigator) initMonthNavigator(settings.month_id);
        
        function setListeners()
        {
            $(settings.changeWeekElement).off('click').on('click', function()
            {
                var week = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active').data('week-id');
                var max_weeks = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active').data('max-weeks');
                var new_week_number = active_week_number;
                
                if($(this).hasClass('mec-previous-month'))
                {
                    week = parseInt(week)-1;
                    new_week_number--;
                }
                else
                {
                    week = parseInt(week)+1;
                    new_week_number++;
                }
                
                if(new_week_number <= 1 || new_week_number >= max_weeks)
                {
                    // Disable Next/Previous Button
                    $(this).css({'opacity': .6, 'cursor': 'default'});
                    $(this).find('i').css({'opacity': .6, 'cursor': 'default'});
                }
                else
                {
                    // Enable Next/Previous Buttons
                    $('#mec_skin_'+settings.id+' .mec-load-week, #mec_skin_'+settings.id+' .mec-load-week i').css({'opacity': 1, 'cursor': 'pointer'});
                }
                
                // Week is not in valid range
                if(new_week_number === 0 || new_week_number > max_weeks)
                {
                }
                else
                {
                    setThisWeek(week);
                }
            });
            
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }
        
        function setThisWeek(week)
        {
            // Week is not exists
            if(!$('#mec_weekly_view_week_'+settings.id+'_'+week).length)
            {
                return setThisWeek((parseInt(week)-1));
            }

            // Set week to active in week list
            $('#mec_skin_'+settings.id+' .mec-weekly-view-week').removeClass('mec-weekly-view-week-active');
            $('#mec_weekly_view_week_'+settings.id+'_'+week).addClass('mec-weekly-view-week-active');
            
            // Show related events
            $('#mec_skin_'+settings.id+' .mec-weekly-view-date-events').addClass('mec-util-hidden');
            $('.mec-weekly-view-week-'+settings.id+'-'+week).removeClass('mec-util-hidden');

            active_week = week;
            active_week_number = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active').data('week-number');

            $('#mec_skin_'+settings.id+' .mec-calendar-d-top').find('.mec-current-week').find('span').remove();
            $('#mec_skin_'+settings.id+' .mec-calendar-d-top').find('.mec-current-week').append('<span>'+active_week_number+'</span>');

            if(active_week_number === 1)
            {
                // Disable Previous Button
                $('#mec_skin_'+settings.id+' .mec-previous-month.mec-load-week').css({'opacity': .6, 'cursor': 'default'});
                $('#mec_skin_'+settings.id+' .mec-previous-month.mec-load-week').find('i').css({'opacity': .6, 'cursor': 'default'});
            }
        }

        function initMonthNavigator(month_id)
        {
            $('#mec_month_navigator'+settings.id+'_'+month_id+' .mec-load-month').off('click');
            $('#mec_month_navigator'+settings.id+'_'+month_id+' .mec-load-month').on('click', function()
            {
                var year = $(this).data('mec-year');
                var month = $(this).data('mec-month');

                setMonth(year, month, active_week);
            });
        }
        
        function search(year, month, week)
        {
            var week_number = (String(week).slice(-1));

                // Add Loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_weekly_view_load_month&mec_year="+year+"&mec_month="+month+"&mec_week="+week_number+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    // Remove Loading Class
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                    // Append Month
                    $("#mec_skin_events_"+settings.id).html('<div class="mec-month-container" id="mec_weekly_view_month_'+settings.id+'_'+response.current_month.id+'">'+response.month+'</div>');

                    // Append Month Navigator
                    $("#mec_skin_"+settings.id+" .mec-skin-weekly-view-month-navigator-container").html('<div class="mec-month-navigator" id="mec_month_navigator'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                    // Set Listeners
                    setListeners();

                    // Toggle Month
                    toggleMonth(response.current_month.id);

                    // Set active week
                    setThisWeek(response.week_id);
                },
                error: function()
                {
                }
            });
        }
        
        function setMonth(year, month, week)
        {
            var month_id = ''+year+month;
            var week_number = (String(week).slice(-1));
            
            active_month = month;
            active_year = year;

            // Month exists so we just show it
            if($("#mec_weekly_view_month_"+settings.id+"_"+month_id).length)
            {
                // Toggle Month
                toggleMonth(month_id);

                // Set active week
                setThisWeek(''+month_id+week_number);
            }
            else
            {
                // Add Loading Class
                if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
                jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

                $.ajax(
                {
                    url: settings.ajax_url,
                    data: "action=mec_weekly_view_load_month&mec_year="+year+"&mec_month="+month+"&mec_week="+week_number+"&"+settings.atts+"&apply_sf_date=0",
                    dataType: "json",
                    type: "post",
                    success: function(response)
                    {
                        // Remove Loading Class
                         $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Append Month
                        $("#mec_skin_events_"+settings.id).append('<div class="mec-month-container" id="mec_weekly_view_month_'+settings.id+'_'+response.current_month.id+'">'+response.month+'</div>');

                        // Append Month Navigator
                        $("#mec_skin_"+settings.id+" .mec-skin-weekly-view-month-navigator-container").append('<div class="mec-month-navigator" id="mec_month_navigator'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                        // Set Listeners
                        setListeners();

                        // Toggle Month
                        toggleMonth(response.current_month.id);

                        // Set active week
                        setThisWeek(response.week_id);
                        
                        // Set Month Filter values in search widget
                        $("#mec_sf_month_"+settings.id).val(month);
                        $("#mec_sf_year_"+settings.id).val(year);
                    },
                    error: function()
                    {
                    }
                });
            }
        }

        function toggleMonth(month_id)
        {
            // Show related events
            $('#mec_skin_'+settings.id+' .mec-month-container').addClass('mec-util-hidden');
            $('#mec_weekly_view_month_'+settings.id+'_'+month_id).removeClass('mec-util-hidden');

            $('#mec_skin_'+settings.id+' .mec-month-navigator').addClass('mec-util-hidden');
            $('#mec_month_navigator'+settings.id+'_'+month_id).removeClass('mec-util-hidden');

            // Initialize Month Navigator
            if(settings.month_navigator) initMonthNavigator(month_id);
        }
        
        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
    };
    
}(jQuery));

// MEC DAILY VIEW PLUGIN
(function($)
{
    $.fn.mecDailyView = function(options)
    {
        var active_month;
        var active_year;
        var active_day;
        
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            today: null,
            id: 0,
            changeDayElement: '.mec-daily-view-day',
            events_label: 'Events',
            event_label: 'Event',
            month_navigator: 0,
            atts: '',
            ajax_url: '',
            sf: {},
        }, options);
        
        active_month = settings.month;
        active_year = settings.year;
        active_day = settings.day;
            
        // Set Today
        setToday(settings.today);

        // Set Listeners
        setListeners();

        // Initialize Month Navigator
        if(settings.month_navigator) initMonthNavigator(settings.month_id);
        
        // Initialize Days Slider
        initDaysSlider(settings.month_id);
        
        // Search Widget
        if(settings.sf.container !== '')
        {
            $(settings.sf.container).mecSearchForm(
            {
                id: settings.id,
                atts: settings.atts,
                callback: function(atts)
                {
                    settings.atts = atts;
                    search(active_year, active_month, active_day);
                }
            });
        }
        
        function setListeners()
        {
            $(settings.changeDayElement).on('click', function()
            {
                var today = $(this).data('day-id');
                setToday(today);
            });
            
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        var current_monthday;
        function setToday(today)
        {
            // For caring about 31st, 30th and 29th of some months
            if(!$('#mec_daily_view_day'+settings.id+'_'+today).length)
            {
                setToday(parseInt(today)-1);
                return false;
            }

            // Set day to active in day list
            $('.mec-daily-view-day').removeClass('mec-daily-view-day-active mec-color');
            $('#mec_daily_view_day'+settings.id+'_'+today).addClass('mec-daily-view-day-active mec-color');

            // Show related events
            $('.mec-daily-view-date-events').addClass('mec-util-hidden');
            $('#mec_daily_view_date_events'+settings.id+'_'+today).removeClass('mec-util-hidden');

            // Set today label
            var weekday = $('#mec_daily_view_day'+settings.id+'_'+today).data('day-weekday');
            var monthday = $('#mec_daily_view_day'+settings.id+'_'+today).data('day-monthday');
            var count = $('#mec_daily_view_day'+settings.id+'_'+today).data('events-count');
            var month_id = $('#mec_daily_view_day'+settings.id+'_'+today).data('month-id');

            $('#mec_today_container'+settings.id+'_'+month_id).html('<h2>'+monthday+'</h2><h3>'+weekday+'</h3><div class="mec-today-count">'+count+' '+(count > 1 ? settings.events_label : settings.event_label)+'</div>');

            if(monthday <= 9) current_monthday = '0'+monthday;
            else current_monthday = monthday;
        }

        function initMonthNavigator(month_id)
        {
            $('#mec_month_navigator'+settings.id+'_'+month_id+' .mec-load-month').off('click');
            $('#mec_month_navigator'+settings.id+'_'+month_id+' .mec-load-month').on('click', function()
            {
                var year = $(this).data('mec-year');
                var month = $(this).data('mec-month');

                setMonth(year, month, current_monthday);
            });
        }

        function initDaysSlider(month_id, day_id)
        {
            // Check RTL website
            if ($('body').hasClass('rtl')) {
                var owl_rtl = true;
            } else {
                var owl_rtl = false;
            }

            // Init Days slider
            var owl = $("#mec-owl-calendar-d-table-"+settings.id+"-"+month_id);
            owl.owlCarousel(
            {
                items : 22, //22 items above 1000px browser width
                responsiveClass: true,
                responsive: {
                    479: {
                        items: 4,
                    },
                    767: {
                        items: 7,
                    },
                    960: {
                        items: 14,
                    },
                    1000: {
                        items: 19,
                    }
                },
                dots: false,
                loop: false,
                rtl: owl_rtl,
            });

            // Custom Navigation Events
            $("#mec_daily_view_month_"+settings.id+"_"+month_id+" .mec-table-d-next").click(function(e)
            {
                e.preventDefault();
                owl.trigger('next.owl.carousel');
            });

            $("#mec_daily_view_month_"+settings.id+"_"+month_id+" .mec-table-d-prev").click(function(e)
            {
                e.preventDefault();
                owl.trigger('prev.owl.carousel');
            });

            if(typeof day_id === 'undefined') day_id = $('.mec-daily-view-day-active').data('day-id');

            var today_str = day_id.toString().substring(6,8);
            var today_int = parseInt(today_str);

            owl.trigger('owl.goTo', [today_int]);
        }
        
        function search(year, month, day)
        {
            // Add Loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_daily_view_load_month&mec_year="+year+"&mec_month="+month+"&mec_day="+day+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    // Remove Loading Class
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                    // Append Month
                    $("#mec_skin_events_"+settings.id).html('<div class="mec-month-container" id="mec_daily_view_month_'+settings.id+'_'+response.current_month.id+'">'+response.month+'</div>');

                    // Append Month Navigator
                    $("#mec_skin_"+settings.id+" .mec-calendar-a-month.mec-clear").html('<div class="mec-month-navigator" id="mec_month_navigator'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                    // Set Listeners
                    setListeners();
                    
                    active_year = response.current_month.year;
                    active_month = response.current_month.month;
                    active_day = '01';
                    
                    // Toggle Month
                    toggleMonth(response.current_month.id, ''+active_year+active_month+active_day);

                    // Set Today
                    setToday(''+active_year+active_month+active_day);
                },
                error: function()
                {
                }
            });
        }
        
        function setMonth(year, month, day)
        {
            var month_id = '' + year + month;
            
            active_month = month;
            active_year = year;
            active_day = day;
            
            // Month exists so we just show it
            if($("#mec_daily_view_month_"+settings.id+"_"+month_id).length)
            {
                // Toggle Month
                toggleMonth(month_id);

                // Set Today
                setToday(''+month_id+day);
            }
            else
            {
                // Add Loading Class
                if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
                jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

                $.ajax(
                {
                    url: settings.ajax_url,
                    data: "action=mec_daily_view_load_month&mec_year="+year+"&mec_month="+month+"&mec_day="+day+"&"+settings.atts+"&apply_sf_date=0",
                    dataType: "json",
                    type: "post",
                    success: function(response)
                    {
                        // Remove Loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Append Month
                        $("#mec_skin_events_"+settings.id).append('<div class="mec-month-container" id="mec_daily_view_month_'+settings.id+'_'+response.current_month.id+'">'+response.month+'</div>');

                        // Append Month Navigator
                        $("#mec_skin_"+settings.id+" .mec-calendar-a-month.mec-clear").append('<div class="mec-month-navigator" id="mec_month_navigator'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                        // Set Listeners
                        setListeners();

                        // Toggle Month
                        toggleMonth(response.current_month.id, ''+year+month+'01');

                        // Set Today
                        setToday(''+year+month+'01');
                        
                        // Set Month Filter values in search widget
                        $("#mec_sf_month_"+settings.id).val(month);
                        $("#mec_sf_year_"+settings.id).val(year);
                    },
                    error: function()
                    {
                    }
                });
            }
        }

        function toggleMonth(month_id, day_id)
        {
            // Show related events
            $('#mec_skin_'+settings.id+' .mec-month-container').addClass('mec-util-hidden');
            $('#mec_daily_view_month_'+settings.id+'_'+month_id).removeClass('mec-util-hidden');

            $('#mec_skin_'+settings.id+' .mec-month-navigator').addClass('mec-util-hidden');
            $('#mec_month_navigator'+settings.id+'_'+month_id).removeClass('mec-util-hidden');

            // Initialize Month Navigator
            if(settings.month_navigator) initMonthNavigator(month_id);

            // Initialize Days Slider
            initDaysSlider(month_id, day_id);
        }
        
        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
    };
    
}(jQuery));

// MEC TIMETABLE PLUGIN
(function($)
{
    $.fn.mecTimeTable = function(options)
    {
        var active_year;
        var active_month;
        var active_week;
        var active_week_number;
        var active_day;

        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            today: null,
            week: 1,
            active_day: 1,
            id: 0,
            changeWeekElement: '.mec-load-week',
            month_navigator: 0,
            atts: '',
            ajax_url: '',
            sf: {}
        }, options);

        // Search Widget
        if(settings.sf.container !== '')
        {
            $(settings.sf.container).mecSearchForm(
            {
                id: settings.id,
                atts: settings.atts,
                callback: function(atts)
                {
                    settings.atts = atts;
                    search(active_year, active_month, active_week, active_day);
                }
            });
        }

        // Set The Week
        setThisWeek(settings.month_id+settings.week, settings.active_day);

        // Set Listeners
        setListeners();

        // Initialize Month Navigator
        if(settings.month_navigator) initMonthNavigator(settings.month_id);

        function setListeners()
        {
            // Change Week Listener
            $(settings.changeWeekElement).off('click').on('click', function()
            {
                var week = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active').data('week-id');
                var max_weeks = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active').data('max-weeks');
                var new_week_number = active_week_number;

                if($(this).hasClass('mec-previous-month'))
                {
                    week = parseInt(week)-1;
                    new_week_number--;
                }
                else
                {
                    week = parseInt(week)+1;
                    new_week_number++;
                }

                if(new_week_number <= 1 || new_week_number >= max_weeks)
                {
                    // Disable Next/Previous Button
                    $(this).css({'opacity': .6, 'cursor': 'default'});
                    $(this).find('i').css({'opacity': .6, 'cursor': 'default'});
                }
                else
                {
                    // Enable Next/Previous Buttons
                    $('#mec_skin_'+settings.id+' .mec-load-week, #mec_skin_'+settings.id+' .mec-load-week i').css({'opacity': 1, 'cursor': 'pointer'});
                }

                // Week is not in valid range
                if(new_week_number === 0 || new_week_number > max_weeks)
                {
                }
                else
                {
                    setThisWeek(week);
                }
            });

            // Change Day Listener
            $('#mec_skin_'+settings.id+' .mec-weekly-view-week dt').not('.mec-timetable-has-no-event').off('click').on('click', function()
            {
                var day = $(this).data('date-id');
                setDay(day);
            });

            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        function setThisWeek(week, day)
        {
            // Week is not exists
            if(!$('#mec_weekly_view_week_'+settings.id+'_'+week).length)
            {
                return setThisWeek((parseInt(week)-1), day);
            }

            // Set week to active in week list
            $('#mec_skin_'+settings.id+' .mec-weekly-view-week').removeClass('mec-weekly-view-week-active');
            $('#mec_weekly_view_week_'+settings.id+'_'+week).addClass('mec-weekly-view-week-active');

            setDay(day);

            active_week = week;
            active_week_number = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active').data('week-number');

            $('#mec_skin_'+settings.id+' .mec-calendar-d-top').find('.mec-current-week').find('span').remove();
            $('#mec_skin_'+settings.id+' .mec-calendar-d-top').find('.mec-current-week').append('<span>'+active_week_number+'</span>');

            if(active_week_number === 1)
            {
                // Disable Previous Button
                $('#mec_skin_'+settings.id+' .mec-previous-month.mec-load-week').css({'opacity': .6, 'cursor': 'default'});
                $('#mec_skin_'+settings.id+' .mec-previous-month.mec-load-week').find('i').css({'opacity': .6, 'cursor': 'default'});
            }
        }

        function setDay(day)
        {
            // Find the date automatically
            if(typeof day === 'undefined')
            {
                day = $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active dt').not('.mec-timetable-has-no-event').first().data('date-id');
            }

            // Activate the date element
            $('#mec_skin_'+settings.id+' dt').removeClass('mec-timetable-day-active');
            $('#mec_skin_'+settings.id+' .mec-weekly-view-week-active dt[data-date-id="'+day+'"]').addClass('mec-timetable-day-active');

            // Show related events
            $('#mec_skin_'+settings.id+' .mec-weekly-view-date-events').addClass('mec-util-hidden');
            $('#mec_weekly_view_date_events'+settings.id+'_'+day).removeClass('mec-util-hidden');
        }

        function initMonthNavigator(month_id)
        {
            $('#mec_month_navigator'+settings.id+'_'+month_id+' .mec-load-month').off('click').on('click', function()
            {
                var year = $(this).data('mec-year');
                var month = $(this).data('mec-month');

                setMonth(year, month, active_week);
            });
        }

        function search(year, month, week)
        {
            var week_number = (String(week).slice(-1));

            // Add Loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_timetable_load_month&mec_year="+year+"&mec_month="+month+"&mec_week="+week_number+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    // Remove Loading Class
                    $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                    // Append Month
                    $("#mec_skin_events_"+settings.id).html('<div class="mec-month-container" id="mec_timetable_month_'+settings.id+'_'+response.current_month.id+'">'+response.month+'</div>');

                    // Append Month Navigator
                    $("#mec_skin_"+settings.id+" .mec-skin-weekly-view-month-navigator-container").html('<div class="mec-month-navigator" id="mec_month_navigator'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                    // Set Listeners
                    setListeners();

                    // Toggle Month
                    toggleMonth(response.current_month.id);

                    // Set active week
                    setThisWeek(response.week_id);
                },
                error: function()
                {
                }
            });
        }

        function setMonth(year, month, week)
        {
            var month_id = ''+year+month;
            var week_number = (String(week).slice(-1));

            active_month = month;
            active_year = year;

            // Month exists so we just show it
            if($("#mec_timetable_month_"+settings.id+"_"+month_id).length)
            {
                // Toggle Month
                toggleMonth(month_id);

                // Set active week
                setThisWeek(''+month_id+week_number);
            }
            else
            {
                // Add Loading Class
                if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
                jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

                $.ajax(
                {
                    url: settings.ajax_url,
                    data: "action=mec_timetable_load_month&mec_year="+year+"&mec_month="+month+"&mec_week="+week_number+"&"+settings.atts+"&apply_sf_date=0",
                    dataType: "json",
                    type: "post",
                    success: function(response)
                    {
                        // Remove Loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Append Month
                        $("#mec_skin_events_"+settings.id).append('<div class="mec-month-container" id="mec_timetable_month_'+settings.id+'_'+response.current_month.id+'">'+response.month+'</div>');

                        // Append Month Navigator
                        $("#mec_skin_"+settings.id+" .mec-skin-weekly-view-month-navigator-container").append('<div class="mec-month-navigator" id="mec_month_navigator'+settings.id+'_'+response.current_month.id+'">'+response.navigator+'</div>');

                        // Set Listeners
                        setListeners();

                        // Toggle Month
                        toggleMonth(response.current_month.id);

                        // Set active week
                        setThisWeek(response.week_id);

                        // Set Month Filter values in search widget
                        $("#mec_sf_month_"+settings.id).val(month);
                        $("#mec_sf_year_"+settings.id).val(year);
                    },
                    error: function()
                    {
                    }
                });
            }
        }

        function toggleMonth(month_id)
        {
            // Show related events
            $('#mec_skin_'+settings.id+' .mec-month-container').addClass('mec-util-hidden');
            $('#mec_timetable_month_'+settings.id+'_'+month_id).removeClass('mec-util-hidden');

            $('#mec_skin_'+settings.id+' .mec-month-navigator').addClass('mec-util-hidden');
            $('#mec_month_navigator'+settings.id+'_'+month_id).removeClass('mec-util-hidden');

            // Initialize Month Navigator
            if(settings.month_navigator) initMonthNavigator(month_id);
        }

        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-timetable-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
    };

}(jQuery));

// MEC WEEKLY PROGRAM PLUGIN
(function($)
{
    $.fn.mecWeeklyProgram = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            sf: {}
        }, options);

        console.log(settings);

        // Set Listeners
        setListeners();

        function setListeners()
        {
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
    };

}(jQuery));

// MEC MASONRY VIEW PLUGIN
(function($)
{
    $.fn.mecMasonryView = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            ajax_url: '',
            sf: {},
            end_date: '',
            offset: 0,
            start_date: '',
        }, options);

        // Set onclick Listeners
        setListeners();

        // Init Masonry
        jQuery(window).load(function(){
            initMasonry();
        });
        function initMasonry()
        {
            var $container = $("#mec_skin_"+settings.id+" .mec-event-masonry");
            $container.isotope(
            {
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });

            $("#mec_skin_"+settings.id+" .mec-events-masonry-cats a").click(function()
            {
                var selector = $(this).attr('data-filter');
                $container.isotope(
                {
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });

                return false;
            });

            var $optionSets = $("#mec_skin_"+settings.id+" .mec-events-masonry-cats"),
                $optionLinks = $optionSets.find('a');

            $optionLinks.click(function()
            {
                var $this = $(this);

                // don't proceed if already selected
                if($this.hasClass('selected')) return false;

                var $optionSet = $this.parents('.mec-events-masonry-cats');
                $optionSet.find('.mec-masonry-cat-selected').removeClass('mec-masonry-cat-selected');
                $this.addClass('mec-masonry-cat-selected');
            });
        }

        function setListeners()
        {
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a, #mec_skin_"+settings.id+" .mec-booking-button").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
    };

}(jQuery));


// MEC LIST VIEW PLUGIN
(function($)
{
    $.fn.mecListView = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            ajax_url: '',
            sf: {},
            current_month_divider: '',
            end_date: '',
            offset: 0,
        }, options);
        
        // Set onclick Listeners
        setListeners();
        
        var sf;
        function setListeners()
        {
            // Search Widget
            if(settings.sf.container !== '')
            {
                sf = $(settings.sf.container).mecSearchForm(
                {
                    id: settings.id,
                    atts: settings.atts,
                    callback: function(atts)
                    {
                        settings.atts = atts;
                        search();
                    }
                });
            }
            
            $("#mec_skin_"+settings.id+" .mec-load-more-button").on("click", function()
            {
                loadMore();
            });

            // Accordion Toggle
            if(settings.style === 'accordion') accordion();
            
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        function accordion()
        {
            // Accordion Toggle
            $("#mec_skin_"+settings.id+" .mec-toggle-item-inner").off("click").on("click", function(event)
            {
                event.preventDefault();

                var $this = $(this);
                $(this).parent().find(".mec-content-toggle").slideToggle("fast", function()
                {
                    $this.children("i").toggleClass("mec-sl-arrow-down mec-sl-arrow-up");
                });

                // Trigger Google Map
                var unique_id = $(this).parent().find(".mec-modal-wrap").data('unique-id');

                window['mec_init_gmap'+unique_id]();
            });
        }
        
        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a, #mec_skin_"+settings.id+" .mec-booking-button, #mec_skin_"+settings.id+" .mec-detail-button").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
        
        function loadMore()
        {
            // Add loading Class
            $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-load-more-loading");

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_list_load_more&mec_start_date="+settings.end_date+"&mec_offset="+settings.offset+"&"+settings.atts+"&current_month_divider="+settings.current_month_divider+"&apply_sf_date=0",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    if(response.count == "0")
                    {
                        // Remove loading Class
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-load-more-loading");

                        // Hide load more button
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");
                    }
                    else
                    {
                        // Show load more button
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-util-hidden");
                        
                        // Append Items
                        $("#mec_skin_events_"+settings.id).append(response.html);

                        // Remove loading Class
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-load-more-loading");

                        // Update the variables
                        settings.end_date = response.end_date;
                        settings.offset = response.offset;
                        settings.current_month_divider = response.current_month_divider;
                        
                        // Single Event Method
                        if(settings.sed_method != '0')
                        {
                            sed();
                        }

                        // Accordion Toggle
                        if(settings.style === 'accordion') accordion();
                    }
                },
                error: function()
                {
                }
            });
        }
        
        function search()
        {
            // Hide no event message
            $("#mec_skin_no_events_"+settings.id).addClass("mec-util-hidden");
            
            // Add loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_list_load_more&mec_start_date="+settings.start_date+"&"+settings.atts+"&current_month_divider=0&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    if(response.count == "0")
                    {
                        // Append Items
                        $("#mec_skin_events_"+settings.id).html('');
                        
                        // Remove loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Hide it
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");
                        
                        // Show no event message
                        $("#mec_skin_no_events_"+settings.id).removeClass("mec-util-hidden");
                    }
                    else
                    {
                        // Append Items
                        $("#mec_skin_events_"+settings.id).html(response.html);

                        // Remove loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Show load more button
                        if(response.count >= settings.limit) $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-util-hidden");
                        // Hide load more button
                        else $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");

                        // Update the variables
                        settings.end_date = response.end_date;
            			settings.offset = response.offset;
                        settings.current_month_divider = response.current_month_divider;
                        
                        // Single Event Method
                        if(settings.sed_method != '0')
                        {
                            sed();
                        }

                        // Accordion Toggle
                        if(settings.style === 'accordion') accordion();
                    }
                },
                error: function()
                {
                }
            });
        }
    };
    
}(jQuery));

// MEC GRID VIEW PLUGIN
(function($)
{
    $.fn.mecGridView = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            ajax_url: '',
            sf: {},
            end_date: '',
            offset: 0,
            start_date: '',
        }, options);
        
        // Set onclick Listeners
        setListeners();
        
        var sf;
        function setListeners()
        {
            // Search Widget
            if(settings.sf.container !== '')
            {
                sf = $(settings.sf.container).mecSearchForm(
                {
                    id: settings.id,
                    atts: settings.atts,
                    callback: function(atts)
                    {
                        settings.atts = atts;
                        search();
                    }
                });
            }
            
            $("#mec_skin_"+settings.id+" .mec-load-more-button").on("click", function()
            {
                loadMore();
            });
            
            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }
        
        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-event-title a, #mec_skin_"+settings.id+" .mec-booking-button").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }
        
        function loadMore()
        {
            // Add loading Class
            $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-load-more-loading");

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_grid_load_more&mec_start_date="+settings.end_date+"&mec_offset="+settings.offset+"&"+settings.atts+"&apply_sf_date=0",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    if(response.count == "0")
                    {
                        // Remove loading Class
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-load-more-loading");

                        // Hide load more button
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");
                    }
                    else
                    {
                        // Show load more button
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-util-hidden");
                        
                        // Append Items
                        $("#mec_skin_events_"+settings.id).append(response.html);

                        // Remove loading Class
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-load-more-loading");

                        // Update the variables
                        settings.end_date = response.end_date;
                        settings.offset = response.offset;
                        
                        // Single Event Method
                        if(settings.sed_method != '0')
                        {
                            sed();
                        }
                    }
                },
                error: function()
                {
                }
            });
        }
        
        function search()
        {
            // Hide no event message
            $("#mec_skin_no_events_"+settings.id).addClass("mec-util-hidden");
                        
            // Add loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_grid_load_more&mec_start_date="+settings.start_date+"&"+settings.atts+"&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    if(response.count == "0")
                    {
                        // Append Items
                        $("#mec_skin_events_"+settings.id).html('');
                        
                        // Remove loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Hide it
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");
                        
                        // Show no event message
                        $("#mec_skin_no_events_"+settings.id).removeClass("mec-util-hidden");
                    }
                    else
                    {
                        // Append Items
                        $("#mec_skin_events_"+settings.id).html(response.html);

                        // Remove loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Show load more button
                        if(response.count >= settings.limit) $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-util-hidden");
                        // Hide load more button
                        else $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");

                        // Update the variables
                        settings.end_date = response.end_date;
			            settings.offset = response.offset;
                        
                        // Single Event Method
                        if(settings.sed_method != '0')
                        {
                            sed();
                        }
                    }
                },
                error: function()
                {
                }
            });
        }
    };
    
}(jQuery));

// MEC AGENDA VIEW PLUGIN
(function($)
{
    $.fn.mecAgendaView = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            ajax_url: '',
            sf: {},
            current_month_divider: '',
            end_date: '',
            offset: 0,
        }, options);

        // Set onclick Listeners
        setListeners();

        var sf;
        function setListeners()
        {
            // Search Widget
            if(settings.sf.container !== '')
            {
                sf = $(settings.sf.container).mecSearchForm(
                {
                    id: settings.id,
                    atts: settings.atts,
                    callback: function(atts)
                    {
                        settings.atts = atts;
                        search();
                    }
                });
            }

            $("#mec_skin_"+settings.id+" .mec-load-more-button").on("click", function()
            {
                loadMore();
            });

            // Single Event Method
            if(settings.sed_method != '0')
            {
                sed();
            }
        }

        function sed()
        {
            // Single Event Display
            $("#mec_skin_"+settings.id+" .mec-agenda-event-title a").off('click').on('click', function(e)
            {
                e.preventDefault();
                var href = $(this).attr('href');

                var id = $(this).data('event-id');
                var occurrence = get_parameter_by_name('occurrence', href);

                mecSingleEventDisplayer.getSinglePage(id, occurrence, settings.ajax_url, settings.sed_method);
            });
        }

        function loadMore()
        {
            // Add loading Class
            $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-load-more-loading");

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_agenda_load_more&mec_start_date="+settings.end_date+"&mec_offset="+settings.offset+"&"+settings.atts+"&current_month_divider="+settings.current_month_divider+"&apply_sf_date=0",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    if(response.count == "0")
                    {
                        // Remove loading Class
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-load-more-loading");

                        // Hide load more button
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");
                    }
                    else
                    {
                        // Show load more button
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-util-hidden");

                        // Append Items
                        $("#mec_skin_events_"+settings.id+" .mec-events-agenda-container").append(response.html);

                        // Remove loading Class
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-load-more-loading");

                        // Update the variables
                        settings.end_date = response.end_date;
                        settings.offset = response.offset;
                        settings.current_month_divider = response.current_month_divider;

                        // Single Event Method
                        if(settings.sed_method != '0')
                        {
                            sed();
                        }
                    }
                },
                error: function()
                {
                }
            });
        }

        function search()
        {
            // Hide no event message
            $("#mec_skin_no_events_"+settings.id).addClass("mec-util-hidden");

            // Add loading Class
            if(jQuery('.mec-modal-result').length === 0) jQuery('.mec-wrap').append('<div class="mec-modal-result"></div>');
            jQuery('.mec-modal-result').addClass('mec-month-navigator-loading');

            $.ajax(
            {
                url: settings.ajax_url,
                data: "action=mec_agenda_load_more&mec_start_date="+settings.start_date+"&"+settings.atts+"&current_month_divider=0&apply_sf_date=1",
                dataType: "json",
                type: "post",
                success: function(response)
                {
                    if(response.count == "0")
                    {
                        // Append Items
                        $("#mec_skin_events_"+settings.id+" .mec-events-agenda-container").html('');

                        // Remove loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");
                    
                        // Hide it
                        $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");

                        // Show no event message
                        $("#mec_skin_no_events_"+settings.id).removeClass("mec-util-hidden");
                    }
                    else
                    {
                        // Append Items
                        $("#mec_skin_events_"+settings.id+" .mec-events-agenda-container").html(response.html);

                        // Remove loading Class
                        $('.mec-modal-result').removeClass("mec-month-navigator-loading");

                        // Show load more button
                        if(response.count >= settings.limit) $("#mec_skin_"+settings.id+" .mec-load-more-button").removeClass("mec-util-hidden");
                        // Hide load more button
                        else $("#mec_skin_"+settings.id+" .mec-load-more-button").addClass("mec-util-hidden");

                        // Update the variables
                        settings.end_date = response.end_date;
                        settings.offset = response.offset;
                        settings.current_month_divider = response.current_month_divider;

                        // Single Event Method
                        if(settings.sed_method != '0')
                        {
                            sed();
                        }
                    }
                },
                error: function()
                {
                }
            });
        }
    };
}(jQuery));

// MEC CAROUSEL VIEW PLUGIN
(function($)
{
    $.fn.mecCarouselView = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            ajax_url: '',
            sf: {},
            items: 3,
            autoplay:'',
            style: 'type1',
            start_date: ''
        }, options);
        
        // Init Sliders
        initSlider();
        
        function initSlider()
        {
            // Check RTL website
            if ($('body').hasClass('rtl')) {
                var owl_rtl = true;
            } else {
                var owl_rtl = false;
            }

            if(settings.style === 'type1')
            {   
                
                // Start carousel skin
                var owl = $("#mec_skin_"+settings.id+" .mec-event-carousel-type1 .mec-owl-carousel");

                owl.owlCarousel(
                {
                    autoplay: true,
                    autoplayTimeout: settings.autoplay, // Set AutoPlay to 3 seconds
                    loop: true,
                    items: settings.items,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        979: {
                            items: 2,
                        },
                        1199: {
                            items: settings.count,
                        }
                    },
                    dots: true,
                    nav: false,
                    autoplayHoverPause:true,
                    rtl: owl_rtl,
                });
                owl.bind(
                    "mouseleave",
                    function (event) {
                        $("#mec_skin_" + settings.id + " .mec-owl-carousel").trigger('play.owl.autoplay');
                    }
                );
            }
            else
            {
                $("#mec_skin_"+settings.id+" .mec-owl-carousel").owlCarousel(
                {
                    autoplay: true,
                    loop: true,
                    autoplayTimeout: settings.autoplay,
                    items: settings.items,
                    dots: false,
                    nav: true,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        979: {
                            items: 2,
                        },
                        1199: {
                            items: settings.count,
                        }
                    },
                    autoplayHoverPause:true,
                    navText: ["<i class='mec-sl-arrow-left'></i>"," <i class='mec-sl-arrow-right'></i>"],
                    rtl: owl_rtl,
                });
                $("#mec_skin_" + settings.id + " .mec-owl-carousel").bind(
                    "mouseleave",
                    function (event) {
                        $( "#mec_skin_" + settings.id + " .mec-owl-carousel" ).trigger( 'play.owl.autoplay' );
                    }
                );
            }
        }
    };
    
}(jQuery));

// MEC SLIDER VIEW PLUGIN
(function($)
{
    $.fn.mecSliderView = function(options)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            id: 0,
            atts: '',
            autoplay: false,
            ajax_url: '',
            sf: {},
            start_date: ''
        }, options);

        // Init Sliders
        initSlider();
        function initSlider()
        {   
            // Check RTL website
            if ($('body').hasClass('rtl')) {
                var owl_rtl = true;
            } else {
                var owl_rtl = false;
            }

            $("#mec_skin_"+settings.id+" .mec-owl-carousel").owlCarousel(
            {
                autoplay: true,
                autoplayTimeout: settings.autoplay,
                loop: true,
                items: 1,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    960: {
                        items: 1,
                    },
                    1200: {
                        items: 1,
                    }
                },
                dots: false,
                nav: true,
                autoplayHoverPause: true,
                navText: ["<i class='mec-sl-arrow-left'></i>", " <i class='mec-sl-arrow-right'></i>"],
                rtl: owl_rtl,
            });
        }
    };

}(jQuery));

// MEC COUNTDOWN MODULE
(function($)
{
    $.fn.mecCountDown = function(options, callBack)
    {
        // Default Options
        var settings = $.extend(
        {
            // These are the defaults.
            date: null,
            format: null
        }, options);

        var callback = callBack;
        var selector = $(this);
        
        startCountdown();
        var interval = setInterval(startCountdown, 1000);
        
        function startCountdown()
        {
            var eventDate = Date.parse(settings.date) / 1000;
            var currentDate = Math.floor($.now() / 1000);

            if(eventDate <= currentDate)
            {
                callback.call(this);
                clearInterval(interval);
            }

            var seconds = eventDate - currentDate;

            var days = Math.floor(seconds / (60 * 60 * 24)); 
            seconds -= days * 60 * 60 * 24; 

            var hours = Math.floor(seconds / (60 * 60));
            seconds -= hours * 60 * 60; 

            var minutes = Math.floor(seconds / 60);
            seconds -= minutes * 60;
            
            if(days == 1) selector.find(".mec-timeRefDays").text(mecdata.day);
            else selector.find(".mec-timeRefDays").text(mecdata.days);
            
            if(hours == 1) selector.find(".mec-timeRefHours").text(mecdata.hour);
            else selector.find(".mec-timeRefHours").text(mecdata.hours);
            
            if(minutes == 1) selector.find(".mec-timeRefMinutes").text(mecdata.minute);
            else selector.find(".mec-timeRefMinutes").text(mecdata.minutes);
            
            if(seconds == 1) selector.find(".mec-timeRefSeconds").text(mecdata.second);
            else selector.find(".mec-timeRefSeconds").text(mecdata.seconds);

            if(settings.format === "on")
            {
                days = (String(days).length >= 2) ? days : "0" + days;
                hours = (String(hours).length >= 2) ? hours : "0" + hours;
                minutes = (String(minutes).length >= 2) ? minutes : "0" + minutes;
                seconds = (String(seconds).length >= 2) ? seconds : "0" + seconds;
            }

            if(!isNaN(eventDate))
            {
                selector.find(".mec-days").text(days);
                selector.find(".mec-hours").text(hours);
                selector.find(".mec-minutes").text(minutes);
                selector.find(".mec-seconds").text(seconds);
            }
            else
            {
                clearInterval(interval);
            }
        }
    };
    
}(jQuery));

function mec_gateway_selected(gateway_id)
{
    // Hide all gateway forms
    jQuery('.mec-book-form-gateway-checkout').addClass('mec-util-hidden');
    
    // Show selected gateway form
    jQuery('#mec_book_form_gateway_checkout'+gateway_id).removeClass('mec-util-hidden');
}

function mec_wrap_resize()
{
    var $mec_wrap = jQuery('.mec-wrap'), mec_width = $mec_wrap.width();
    if(mec_width < 959)
    {
        $mec_wrap.addClass('mec-sm959');
    }
    else
    {
        $mec_wrap.removeClass('mec-sm959');
    }
}

function get_parameter_by_name(name, url)
{
    if(!url)
    {
        url = window.location.href;
    }
    
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);

    if(!results) return null;
    if(!results[2]) return '';
    
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// TODO must be cleaned JS codes
(function($)
{
    $(document).ready(function()
    {
        // Check RTL website
        if ($('body').hasClass('rtl')) {
            var owl_rtl = true;
        } else {
            var owl_rtl = false;
        }

        // MEC WIDGET CAROUSEL
        $(".mec-widget .mec-event-grid-classic").addClass('mec-owl-carousel mec-owl-theme');
        $(".mec-widget .mec-event-grid-classic").owlCarousel(
        {
            autoplay: true,
            autoplayTimeout: 3000, // Set AutoPlay to 3 seconds
            autoplayHoverPause: true,
            loop: true,
            dots: false,
            nav: true,
            navText: ["<i class='mec-sl-arrow-left'></i>", " <i class='mec-sl-arrow-right'></i>"],
            items: 1,
            autoHeight: true,
            responsiveClass: true,
            rtl: owl_rtl,
        });
        
        // add mec-sm959 class if mec-wrap div size < 959
        mec_wrap_resize();
        
        jQuery(window).bind('resize', function()
        {
            mec_wrap_resize();
        });

        // Fixed: social hover in iphone
        $('.mec-event-sharing-wrap').hover(function()
        {
            $(this).find('.mec-event-sharing').show(0);
        },
        function()
        {
            $(this).find('.mec-event-sharing').hide(0);
        });

        // Register Booking Smooth Scroll
        $('a[href="#mec-events-meta-group-booking"]').click(function()
        {
            if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname)
            {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                if(target.length)
                {
                    var scrollTopVal = target.offset().top - 30;

                    $('html, body').animate(
                    {
                        scrollTop: scrollTopVal
                    }, 600);

                    return false;
                }
            }
        });
    });
})(jQuery);