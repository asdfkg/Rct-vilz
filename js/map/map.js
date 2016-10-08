var map = {
    AJAX_URI: "/ajax.php",
	IMAGE_URI: "/img/reservations/property/%propertyName%.jpg", 
	MARKER_IMAGE_URI: "/img/destinations/v-drk-brown-sprite.png",
	MARKER_CLUSTER_IMAGE_URI: "/img/destinations/v-cluster-drk-brown.png",
	INFO_BOX_HTML: "<a class='btn' href=''><div class='thumb shadowed'><img src='%image_src%' alt='%image_alt%' style='opacity:0;' /></div><div class='info-bar'><span id='property-name'></span></div><div class='triangle'></div></a>",
	PROPERTY_LINK_URI: "%dest_name%-rental-villas/villa-%propertyName%",
	MARKER_ID_BASE: "marker-",
	DESTINATION: {
		SAINT_TROPEZ: "Saint-Tropez",
		MIAMI: "Miami",
		ASPEN: "Aspen"
	},
	INIT_ZOOM: 2,
	INIT_CENTER: new google.maps.LatLng(37.1233269,0),
	ACTIVE_CLASS: "active",
	ANIMATE_CLASS: "animate",
	DEGREE_PADDING_NORTH: 0.05,
	BTN_DEST_PROPERTIES_REPLACE: "%destination%",
	BTN_DEST_PROPERTIES_LINK_BASE_URI: "/rental-villas/",
	dest_name: "",
	cur_dest_name: "",
	degree_padding_north: "",
	btn_dest_properties_html: "",
	//animation_inc: 0,
	map_styles: [
	 {
	    "elementType": "geometry.fill",
	    "stylers": [
	     { "color": "#ead28e" }
	    ]
	  },{
	    "featureType": "administrative",
	    "elementType": "labels",
	    "stylers": [
	      { "visibility": "off" }
	    ]
	  },{
	    "featureType": "administrative.locality",
	    "elementType": "labels",
	    "stylers": [
	      { "visibility": "on" }
	    ]
	  },{
	    "featureType": "administrative.locality",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#787878" },
	      { "visibility": "simplified" }
	    ]
	  },{
	    "featureType": "road",
	    "stylers": [
	      { "visibility": "off" }
	    ]
	  },{
	    "featureType": "landscape",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#6C6C6C" },
	      { "visibility": "simplified" }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#bca462" },
	      { "lightness": -15 }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "visibility": "off" }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "labels",
	    "stylers": [
	      { "visibility": "on" }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#6C6C6C" },
	      { "visibility": "simplified" }
	    ]
	  },{
	    "featureType": "road.arterial",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#bca462" },
	      { "lightness": -15 }
	    ]
	  },{
	    "featureType": "road.arterial",
	    "elementType": "labels",
	    "stylers": [
	      { "visibility": "on" }
	    ]
	  },{
	    "featureType": "road.arterial",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#6C6C6C" },
	      { "visibility": "simplified" }
	    ]
	  },{
	    "featureType": "road.local",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#bca462" },
	      { "lightness": -8 }
	    ]
	  },{
	    "featureType": "road.local",
	    "elementType": "labels",
	    "stylers": [
	      { "visibility": "on" }
	    ]
	  },{
	    "featureType": "road.local",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#6C6C6C" },
	      { "visibility": "simplified" }
	    ]
	  },{
	    "featureType": "transit",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#ead28e" },
	    ]
	  },{
	    "featureType": "transit",
	    "elementType": "labels.text",
	    "stylers": [
	      { "visibility": "simplified" },
	      { "color": "#6C6C6C" }
	    ]
	  },{
	    "featureType": "water",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#FFFFFF" }
	    ]
	  },{
	    "featureType": "water",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#644630" },
	      { "visibility": "simplified" }
	    ]
	  },{
	    "featureType": "landscape",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#bca462" },
	      { "lightness": 15 }
	    ]
	  },{
	    "featureType": "landscape.man_made",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#bca462" },
	      { "lightness": 15 }
	    ]
	  },{
	    "featureType": "administrative",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "visibility": "off" }
	    ]
	  },{
	    "featureType": "administrative.province",
	    "elementType": "geometry",
	    "stylers": [
	      { "visibility": "off" }
	    ]
	  },{
	    "featureType": "administrative.province",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#f4f4f4" }
	    ]
	  },{
	    "featureType": "administrative",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#bca462" }
	    ]
	  },{
	  	"featureType": "administrative.country",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "visibility": "on" },
	      { "color": "#f4f4f4" }
	    ]
	  },{
	    "featureType": "poi",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#bca462" },
	      { "lightness": 29 }
	    ]
	  },{
	    "featureType": "poi",
	    "elementType": "labels.text",
	    "stylers": [
	      { "color": "#6C6C6C" },
	      { "visibility": "simplified" }
	    ]
	  },
	  {
	    "featureType": "landscape.natural.terrain",
	    "elementType": "geometry",
	    "stylers": [
	     { "color": "#bca462" }
	    ]
	  }
	],
	map_options:  {
		 backgroundColor: '#ffffff',
         mapTypeId: google.maps.MapTypeId.ROADMAP,
         zoomControl: false,
         panControl: false,
         streetViewControl: false,
         mapTypeControl: false,
         zoom: 2,
         minZoom: 2,
         draggable:true,
         scrollwheel: false,
         center: new google.maps.LatLng(37.1233269,0),
         disableDoubleClickZoom: true
    },
    info_temp_hidden: false,
    current_marker_id: -1,
    previous_marker_id: -1,
    num_markers_added: 0,
    map_is_enabled: true,
    map_initiated: false,
    // ----------------- init
    init: function(){
    	var self = this;
    	var dest_str = "";
    	
    	this.map_is_enabled = this.isMapEnabled();

		//need to pull ajax data of the locations
		//this.fetchPropertyLocations();
		this.fetchDestinationOffsets();
		setTimeout(function(){
			self.createMap();
			
			$('#buttonStTropez').click(function(){
			    if(self.map_is_enabled) self.fitToDestination(self.DESTINATION.SAINT_TROPEZ);
				else self.navigateToDestPage(self.DESTINATION.SAINT_TROPEZ);
				
				return false;
			});
			$('#buttonMiami').click(function(){
				if(self.map_is_enabled) self.fitToDestination(self.DESTINATION.MIAMI);
				else self.navigateToDestPage(self.DESTINATION.MIAMI);

				return false;
			});
			$('#buttonAspen').click(function(){
				if(self.map_is_enabled) self.fitToDestination(self.DESTINATION.ASPEN);
				else self.navigateToDestPage(self.DESTINATION.ASPEN);

				return false;
			});
						
			self.btn_refresh_el = $('.btn-refresh');
			self.btn_refresh_el.css('opacity', '0');
			self.btn_refresh_el.click(function(){
				//set the zoom
				//&  the cenetr to 
				//the initial values
				self.fitToDefault();
				return false;
			});
			
			self.btn_dest_properties_el = $('.btn-dest-properties');
			if(self.btn_dest_properties_el){
    			self.btn_dest_properties_el.css('opacity', '0');
    			self.btn_dest_properties_html = self.btn_dest_properties_el.html();
    			self.btn_dest_properties_el.click(function(){
    				//self.cur_dest_name
    				/*dest_str = self.cur_dest_name;
    				dest_str = dest_str.toLowerCase();
    				dest_str = dest_str.replace(" ", "-");
    				window.location.assign(self.BTN_DEST_PROPERTIES_LINK_BASE_URI + dest_str);*/
    				self.navigateToDestPage(self.cur_dest_name);
    				return false;
    			});
			}
		}, 1000);
	},
	// ----------------- fetchPropertyLocations
	fetchPropertyLocations: function(){
		var self = this;
		$.ajax({
			type: 'POST',
			url: self.AJAX_URI,
			data: 'action=getPropertyAltLocations',
			dataType: 'json',
			success: function(data)
			{	
				if(data.result && data.result.success){
					self.locations = data.result.value;
					console.log("self.locations = " + JSON.stringify(self.locations));
					//if map already created at this point
					if(self.map_initiated) self.addMarkers();
				}	
				else if(data.result && data.result.error){
					console.log("error getting property locations: " + data.result.error);
				}	
				else{
					console.log("error getting property locations: " + JSON.stringify(data));
				}	
			},
			error: function(jqXHR, text, error)
			{
				console.log("error getting property locations - error: " + error);
			}
		});
	},
	// ----------------- fetchDestinationOffsets
	fetchDestinationOffsets: function(){
		var self = this;
		$.ajax({
			type: 'POST',
			url: self.AJAX_URI,
			data: 'action=getDestinationOffsets',
			dataType: 'json',
			success: function(data)
			{	
				if(data.result && data.result.success){
					self.destination_offsets = data.result.value;
					console.log(JSON.stringify(self.destination_offsets));
					//console.log("self.destination_offsets[0].destMapNorthOffset = " + self.destination_offsets[0].destMapNorthOffset);
					//if map already created at this point
					self.fetchPropertyLocations();
				}	
				else if(data.result && data.result.error){
					console.log("error getting destination offsets: " + data.result.error);
				}	
				else{
					console.log("error getting destination offsets: " + JSON.stringify(data));
				}	
			},
			error: function(jqXHR, text, error)
			{
				console.log("error getting destination offsets - error: " + error);
			}
		});
	},
	// ----------------- navigateToDestPage
	navigateToDestPage: function(dest_name){
		dest_name = dest_name.toLowerCase();
		dest_name = dest_name.replace(" ", "-");
		window.location.assign(this.BTN_DEST_PROPERTIES_LINK_BASE_URI + dest_name);
	},
	// ----------------- isMapEnabled
	isMapEnabled: function(){
			var user_agent = navigator.userAgent.toLowerCase();
			var version = 0;
			var version_arr;
			var is_enabled = true;
			//if safari version 5 or lower
			if(user_agent.indexOf('safari') > -1){
				//if version 5 or less
				version_arr = user_agent.split("version/");
				if(version_arr.length > 1) console.log("version_arr[1] = " + version_arr[1]);
				if(version_arr.length > 1) version = version_arr[1]; 
				else return is_enabled;
				version_arr = version.split(" ");
				if(version_arr.length > 0) version = parseFloat(version_arr[0]);
				else return is_enabled;
				//is_enabled = false;
				if(version < 6.0) is_enabled = false;
			}
			return is_enabled;
	},
    // ----------------- createMap
    createMap: function(){
	     var self = this;
	    	    
         this.map_canvas_el = $('.map', this.el);
         this.map_canvas_el.gmap(this.map_options).bind('init', function(evt, map) {
			map.setOptions({styles: self.map_styles});
			self.map = map;
			
			self.onMapInit();
			if(self.locations) self.addMarkers();
			self.map_initiated = true;
			
			$(map).click(function(){
                console.log("map click");
                if( self.current_marker_id > -1 ) {
                   self.hideCurrentInfo();
                }
                return false;
             });
        }).bind('zoom_changed', function(evt, map) {
             console.log("zoom_changed");
        });
        this.map_added = true;
    },
    // ----------------- removeMarkers
    removeMarkers: function() {
         this.map_canvas_el.gmap('clear', 'markers');
     	 if(this.marker_clusterer) this.marker_clusterer.clearMarkers();
    },
    // ----------------- onMapInit
    onMapInit: function() {
    //marker settings
	     marker_img_uri = this.MARKER_IMAGE_URI;
         marker_img_width = 25;
         marker_img_height = 24;
         
         //marker_cluster settings
         marker_cluster_img_path = this.MARKER_CLUSTER_IMAGE_URI;
         marker_cluster_width = 37;
         marker_cluster_height = 23;
         marker_cluster_anchor = [-12, -14];
         //marker_cluster_anchor_icon = [-12, -12];
         marker_cluster_anchor_icon = [6, -12];
         marker_clusterer_max_zoom = 8;
         marker_clusterer_grid_size = 10;
         
         //info box settings
         infobox_bg_width = '260px';
         infobox_bg_height = '223px';
         infobox_offset_x= -133;
         infobox_offset_y = -35;
         
         var infoBoxOptions = {
	         alignBottom: true,
	         disableAutoPan: true,
	         pixelOffset: new google.maps.Size(infobox_offset_x, infobox_offset_y),
	         zIndex: null,
	         boxClass: "map-info-box-content",
	         closeBoxMargin: '',
	         closeBoxURL: '',
	         infoBoxClearance: new google.maps.Size(1, 1),
	         isHidden: false,
	         pane: "floatPane",
	         enableEventPropagation: true
	    };
	    this.infoBox = new InfoBox(infoBoxOptions);
	    
	    this.markerCluster_options = {	averageCenter: true,
	                                    zoomOnClick: false,
	                                    maxZoom: marker_clusterer_max_zoom,
	                                    minimumClusterSize: 2,
	                                    gridSize: marker_clusterer_grid_size,
	                                    ignoreHidden: false,
	                                    styles: [ { url: marker_cluster_img_path,
	                                    backgroundPosition: '0 0',
	                                    height: marker_cluster_height,
	                                    width: marker_cluster_width,
	                                    anchor: marker_cluster_anchor,
	                                    offsetX: marker_cluster_anchor_icon[0],
	                                    offsetY: marker_cluster_anchor_icon[1],
	                                    textSize: 1  } ] };

	    this.markerImage = new google.maps.MarkerImage( 
	    	marker_img_uri, 
	    	new google.maps.Size(marker_img_width, marker_img_height), 
	    	new google.maps.Point(0, 0), 
	    	new google.maps.Point(12, 20),
	    	new google.maps.Size(marker_img_width, marker_img_height*2) 
	    );
	    
	    this.markedMarkerImage = new google.maps.MarkerImage( 
	    	marker_img_uri, 
	    	new google.maps.Size(marker_img_width, marker_img_height), 
	    	new google.maps.Point(0, marker_img_height), 
	    	new google.maps.Point(12, 20), 
	    	new google.maps.Size(marker_img_width, marker_img_height*2) 
	    );
    },
    // ----------------- addMarkers
    addMarkers: function() {
    	 this.num_markers_added = 0;
    	 this.markers = [];
	     this.addMarker();
    },
    // ----------------- addMarker
    addMarker: function() {
         var self = this;
         var location = this.locations[this.num_markers_added];
         var lat = location.propertyMapAltLat;
         var lng = location.propertyMapAltLong;
         var dest_name = location.destName;
         var pos_str = String(lat + ', ' + lng);
         var anim_type = google.maps.Animation.NONE;
         
         this.map_canvas_el.gmap('addMarker',
             { id: this.num_markers_added,
               'position': pos_str,
               icon: this.markerImage,
               animation: anim_type,
               optimized: true,
               name:  this.MARKER_ID_BASE + this.num_markers_added,
               dest_name:  dest_name },
               function(map, marker){
               		if(Modernizr.touch) {
	               		$(marker).click(function(){
			               	var marker_id = this.name;
			                marker_id = marker_id.replace(self.MARKER_ID_BASE, "");
					   		self.showInfo(marker_id);
	               		});
	               	}
	               	else{
		               	$(marker).mouseover(function(){
			               	var marker_id = this.name;
			                marker_id = marker_id.replace(self.MARKER_ID_BASE, "");
					   		self.showInfo(marker_id);
	               		});
				   		$(marker).mouseout(function(){
		               		var marker_id = this.name;
			                marker_id = marker_id.replace(self.MARKER_ID_BASE, "");
					   		self.hideCurrentInfo();
	               		});
	               		$(marker).click(function(){
			               	var id = parseInt(this.name.replace(self.MARKER_ID_BASE, ""));
						   	self.openDestPage(id);
	               		});
	               	}
        } );
		var marker = this.map_canvas_el.gmap('get', 'markers >' + this.num_markers_added);
		this.markers.push(marker);
		this.num_markers_added++;
		
		//add next markers
		if(this.num_markers_added < this.locations.length) this.addMarker();
		
		//add to the marker clusterer as they are added
		else if(this.num_markers_added == this.locations.length){
		 		self.createClusterer(self.markers);
		}
    },
    // ----------------- createClusterer
    createClusterer: function(markers) {
    	console.log("createClusterer");
     	 var self = this;
     	 var offset = 0;
     	 var bounds, markers, dest_name;
     	 var btn_copy = "";
         this.map_canvas_el.gmap('set', 'MarkerClusterer', new MarkerClusterer(this.map, markers, this.markerCluster_options));
         this.marker_clusterer = this.map_canvas_el.gmap('get', 'MarkerClusterer');
         this.clusterClickListener = google.maps.event.addListener(this.marker_clusterer, 'clusterclick', function(cluster) {
         	   //need to attach offset to the marker so that 
         	   //we can reference it
         	   //grab the first  marker
         	   //get it's offset so that we can 
         	   //extend the bounds by it
         	     markers = cluster.getMarkers();
	         	 dest_name = markers[0].dest_name;
	         	   
         	   if(self.map_is_enabled){
	         	   markers = cluster.getMarkers();
	         	   dest_name = markers[0].dest_name;
	         	   self.cur_dest_name = dest_name;
	         	   //set the btn to display the dest name
				   if(self.btn_dest_properties_html) btn_copy = self.btn_dest_properties_html.replace(self.BTN_DEST_PROPERTIES_REPLACE, dest_name);
				   self.btn_dest_properties_el.html(btn_copy);
	               self.map.panTo(cluster.getCenter());
	               cur_zoom = self.map.getZoom();
		    	   self.init_zoom = cur_zoom;
		    	   bounds = cluster.getBounds();
		    	   bounds = self.getExtendedBounds(bounds, dest_name);
		    	   //self.animation_inc = 0;
	               self.animateFit(bounds, function(){self.addMarkers();});
	               self.removeMarkers();
               }
               else{
					/*dest_name = dest_name.toLowerCase();
					dest_name = dest_name.replace(" ", "-");
					window.location.assign(self.BTN_DEST_PROPERTIES_LINK_BASE_URI + dest_name);*/
					self.navigateToDestPage(dest_name);
               }
         });
         this.clusterMouseOverListener = google.maps.event.addListener(this.marker_clusterer, 'mouseover', function(cluster) {
               console.log("mouseover");
         });
         this.clusterMouseOverListener = google.maps.event.addListener(this.marker_clusterer, 'mouseover', function(cluster) {
               console.log("mouseout");
         });
         this.clusterMouseOverListener = google.maps.event.addListener(this.marker_clusterer, 'clusteringend', function(cluster) {
               console.log("clusteringend");
               //traverse all clusters
               // if any cluster has a info box open 
               //close it
               self.checkClusters();
         });
    },
    // ----------------- animateFit
    animateFit: function(bounds, callback) {
    	var self = this;
    	var cur_zoom;
		setTimeout(function(){
	  	  cur_zoom = self.map.getZoom();
	  	  //only want to zoom
	  	  //a few levels
	  	  //so that not as many tiles are loading
	  	  //
		  if(cur_zoom > 10){
			 self.map.fitBounds(bounds);
			 self.showBtns();
			 if(callback) callback();
		  } 
		  else{
		  	cur_zoom++;
		  	if(cur_zoom == self.INIT_ZOOM+3) cur_zoom = 9;
		  	 self.map.setZoom(cur_zoom);
			 self.animateFit(bounds, callback); 
		  } 
		}, 40);
	},
	// ----------------- almostAnimateToDefault
    almostAnimateToDefault: function(callback) {
		this.hideBtns();
		var cur_zoom;
    	//animate out to INIT_ZOOM
		var self = this;
		setTimeout(function(){
	  	  cur_zoom = self.map.getZoom();
		  if( (self.init_zoom - 2) <= 0 || cur_zoom <= (self.init_zoom - 2) ){
			 self.map.setCenter(self.INIT_CENTER);
			 if(callback) callback();
			 //if no markers
			 //readd the markers
		  } 
		  else{	
		 	 //on second time here
		 	 //jump to larger zoom
		 	 //so that zoom in is quicker
		  	//remove the markers
		  	self.map.setZoom(cur_zoom-1);
			self.almostAnimateToDefault(callback); 
		  } 
		}, 100);
	},
	// ----------------- animateToDefault
    animateToDefault: function(callback) {
        var cur_zoom;
		this.hideBtns();
    	//animate out to INIT_ZOOM
		var self = this;
		setTimeout(function(){
	  	  cur_zoom = self.map.getZoom();
		  if(cur_zoom == self.INIT_ZOOM){
			 self.map.setCenter(self.INIT_CENTER);
			 if(callback) callback();
			 //if no markers
			 //readd the markers
		  } 
		  else{	
		 	 //on second time here
		 	 //jump to larger zoom
		 	 //so that zoom in is quicker
		 	 if(cur_zoom == (self.init_zoom - 1)) cur_zoom = self.INIT_ZOOM + 2;
		 	 	  	
		  	//remove the markers
		  	self.map.setZoom(cur_zoom-1);
			self.animateToDefault(callback); 
		  } 
		}, 100);
	},
	 // ----------------- fitToDestination
    fitToDestination: function(dest_name){
    	var cur_zoom;
    	var self = this;
    	var btn_copy = "";
    	if(dest_name != this.cur_dest_name) {
    		//hide the current infobox
    		this.hideCurrentInfo();
	    	var dest_markers = [];
	    	
    		//set the btn to display the dest name
			btn_copy = self.btn_dest_properties_html.replace(self.BTN_DEST_PROPERTIES_REPLACE, dest_name);
			self.btn_dest_properties_el.html(btn_copy);
				
	    	//traverse all markers
	    	//filter by dest 
	    	for(var i=0;i<this.markers.length;i++){
		    	if(this.markers[i].dest_name == dest_name) dest_markers.push(this.markers[i]);
	    	}
		    //get all markers of the destination 
	    	var bounds = this.getBounds(dest_markers);
	    	bounds = this.getExtendedBounds(bounds, dest_name);
	    	
	    	this.removeMarkers();
			this.init_zoom = this.map.getZoom();
			
			//change to not go to default, but to 
	    	this.almostAnimateToDefault( function(){
	    	    self.map.panTo(bounds.getCenter());
	    	    cur_zoom = self.map.getZoom();
	    	    self.init_zoom = cur_zoom;
		    	self.animateFit(bounds, function(){
			    	self.addMarkers();
		    	});
	    	} );
    	}
    	this.cur_dest_name = dest_name;
    },
     // ----------------- fitToDefault
    fitToDefault: function(){
    	var self = this;
    	this.removeMarkers();
		setTimeout(function(){
			self.hideCurrentInfo();
			self.init_zoom = self.map.getZoom();
	    	self.animateToDefault( function(){
		    	self.addMarkers();
	    	});
			self.cur_dest_name = "";
		}, 100);
    },
    // ----------------- showBtns
    showBtns: function() {
         var self = this;
    	 this.btn_refresh_el.animate({
			 opacity: 1
		 }, 150 );
		 this.showBtnsTimeout = setTimeout(function(){
			 self.btn_dest_properties_el.animate({
				opacity: 1
			}, 150 );
		 }, 150);
    },
    // ----------------- hideBtns
    hideBtns: function() {
    	var self = this;
    	clearTimeout(this.showBtnsTimeout);
    	this.btn_refresh_el.animate({
			opacity: 0
		}, 150 );
		this.btn_dest_properties_el.animate({
			opacity: 0
		}, 150 );
    },
    // ----------------- showInfo
    showInfo: function(id) {
    	var self = this;
		this.hideCurrentInfo();
    	id = parseInt(id);
    	var location = this.locations[id];
        var lat = location.propertyMapAltLat;
        var lng = location.propertyMapAltLong;
      	//restore the infoBox
        this.infoBox.setPosition(new google.maps.LatLng(lat, lng));
		var html = this.INFO_BOX_HTML;
		var image_uri = this.IMAGE_URI;
		var unformatted_name = location.propertyName;
		
		this.info_temp_hidden = false;
		unformatted_name = unformatted_name.toLowerCase();
		unformatted_name = unformatted_name.replace(" ", "-", "g");
		image_uri = image_uri.replace("%propertyName%", unformatted_name);
		html = html.replace("%image_alt%", location.propertyName);
		html = html.replace("%property_name%", location.propertyName);
		
         //set infoBox disableAutoPan back to false
         this.infoBox.setContent(html);
         this.infoBox.open(this.map_canvas_el.gmap('get', 'map'));
         this.map_canvas_el.gmap('get', 'markers >' + String(id)).setIcon(this.markedMarkerImage);
         
         this.current_marker_id = id;
         
         setTimeout(function(){
         	 //set the info ox scale to 0
         	 $('.map-info-box-content .btn').attr("id", self.MARKER_ID_BASE + id);
         	 $('.map-info-box-content .btn img').css('opacity', '0');
         	 $('.map-info-box-content .btn img').attr('src', image_uri);
         	 if( $('.map-info-box-content .btn img')[0].complete ) self.handleImageLoad( $('.map-info-box-content .btn img') );
         	 $('.map-info-box-content .btn img').load(function(){
	         	 self.handleImageLoad(this);
         	 });
	         $('.map-info-box-content .btn', self.map_canvas_el).click(function(){
		     	var id = parseInt($(this).attr("id").replace(self.MARKER_ID_BASE, ""));
		     	self.openDestPage(id);
		     	return false;
	         });
	         $('.map-info-box-content').addClass(self.ANIMATE_CLASS);
		     $('.map-info-box-content').addClass(self.ACTIVE_CLASS);
         }, 100);
      },
      // ----------------- openDestPage
	  openDestPage: function(id){
 	    	var location = this.locations[id];
 	    	var dest_name = location.destName.toLowerCase();
 	    	dest_name = dest_name.replace(" ", "-", "g");
 	    	var property_name = location.propertyName.toLowerCase();
 	    	property_name = property_name.replace(" ", "-", "g");
 			var uri = this.PROPERTY_LINK_URI;
 			uri = uri.replace("%dest_name%", dest_name);
 			uri = uri.replace("%propertyName%", property_name);
 			window.location.href = uri;
	  },
      // ----------------- handleImageLoad
	  handleImageLoad: function(image){
	   		$(image).animate({
				    opacity: 1
			}, 350 );
	  },
      // ----------------- hideCurrentInfo
	  hideCurrentInfo: function(){
		 $('.map-info-box-content .btn', this.map_canvas_el).off();
		 if(this.infoBox){
		     this.infoBox.close();
		 }

		 if(this.current_marker_id > -1) var marker = this.map_canvas_el.gmap('get', 'markers >' + this.current_marker_id);
		 if(marker) marker.setIcon(this.markerImage);
		 this.current_marker_id = -1;
		 this.previous_marker_id = -1;
	  },
	  // ----------------- checkClusters
      checkClusters: function() {
        var self = this;
        if(self.current_marker_id >= 0){
            //grab the clusters of the clusterer
            //check if current marker is inside one of the  clusteres
            //if so, hide the hide the current info and clear current marker
            var markers_arr = [];
            //get zoom level of the map
            var map_zoom = this.map.getZoom();
            var i, j, marker_id, lat, lng, bounds;
            //if the zoom level of the map is at or below the
            //maxZoom of the clusterer
            self.checkZoomTimeout = setTimeout(function(){
                 var cluster_max_zoom = self.marker_clusterer.getMaxZoom();
                 var cluster_arr = self.marker_clusterer.getClusters();
                 var clusterer_markers_arr = self.marker_clusterer.getMarkers();
                 if(map_zoom <= cluster_max_zoom){
                     var min_cluster_size = self.marker_clusterer.getMinimumClusterSize();
                     self.checkInfoBoxTimeout = setTimeout(function(){
                       if(cluster_arr.length == 0){
                           //show the info if hidden
                           for(i=0;i<clusterer_markers_arr.length;i++){
                               if(clusterer_markers_arr[i].id == self.current_marker_id && self.info_temp_hidden){
                                   marker_id = clusterer_markers_arr[i].name;
                                   marker_id = marker_id.replace("marker_", "");
                                   self.restoreInfo(self.current_marker_id);
                               }
                            }
                        }
                        else{
                           for(i=0;i<cluster_arr.length;i++){
                               markers_arr = cluster_arr[i].getMarkers();
                               if(markers_arr.length >= min_cluster_size){
                                   //search the markers array for the marker with the current_marker_id
                                   for(j=0;j<markers_arr.length;j++){
                                       marker_id = markers_arr[j].name;
                                       marker_id = marker_id.replace("marker_", "");
                                       if(markers_arr[j].id == self.current_marker_id && !self.info_temp_hidden){
                                               self.tempHideCurrentInfo();
                                       }
                                 }
                               }
                               else{
                                   //show the info if hidden
                                   for(j=0;j<markers_arr.length;j++){
                                       if(markers_arr[j].id == self.current_marker_id && self.info_temp_hidden){
                                           marker_id = markers_arr[j].name;
                                           marker_id = marker_id.replace("marker_", "");
                                           self.restoreInfo(self.current_marker_id);
                                       }
                                   }
                               }
                           }
                        }
                    }, 100);
                 }
                 else{
                     // if self.current_marker_id is in the clusterer
                     //show the info if hidden
                     self.checkInfoBoxTimeout = setTimeout(function(){
                           if(cluster_arr.length == 0){
                               for(i=0;i<clusterer_markers_arr.length;i++){
                                   marker_id = clusterer_markers_arr[i].name;
                                   marker_id = marker_id.replace("marker_", "");
                                   if(clusterer_markers_arr[i].id == self.current_marker_id && self.info_temp_hidden){
                                       self.restoreInfo(self.current_marker_id);
                                   }
                               }
                           }
                           else{
                               for(i=0;i<cluster_arr.length;i++){
                                   markers_arr = cluster_arr[i].getMarkers();
                                   for(j=0;j<markers_arr.length;j++){
                                       marker_id = markers_arr[j].name;
                                       marker_id = marker_id.replace("marker_", "");
                                       if(markers_arr[j].id == self.current_marker_id && self.info_temp_hidden){
                                           self.restoreInfo(self.current_marker_id);
                                       }
                                    }
                               }
                           }
                    }, 100);
                }
            }, 100);
        }
    },
    // ----------------- restoreInfo
    restoreInfo: function(id) {
    	 this.showInfo(id);
    },
	// ----------------- tempHideCurrentInfo
    tempHideCurrentInfo: function(){
          if(this.infoBox){
              this.infoBox.close();
          }
         this.info_temp_hidden = true;
         this.previous_marker_id = -1;
    },
    // ----------------- getBounds
    getBounds: function(markers){
        //var center = this.map.getCenter();
	    var bounds = new google.maps.LatLngBounds();
		for (var i = 0; i < markers.length; i++) {
			bounds.extend(markers[i].getPosition());
		}
		return bounds;
    },
    // ----------------- getExtendedBounds
    getExtendedBounds: function(bounds, dest_name){
    	//extend the bounds with a fake
    	//northmost point  to allow for
    	//openning of window boxes without
    	//moving the map
    	//get the offset based upon the dest_name
    	var offset = 0;
    	
    	for(var i=0;i<this.destination_offsets.length;i++){
	    	if(this.destination_offsets[i].destName == dest_name){
		    	offset = parseFloat(this.destination_offsets[i].destMapNorthOffset);
		    	break;
	    	}  
    	}
    	var northEast = bounds.getNorthEast();
    	var fake_north_point_lat = northEast.lat();
    	var fake_north_point_lng = northEast.lng();
    	fake_north_point_lat += offset;
    	var fake_north_point = new google.maps.LatLng(fake_north_point_lat, fake_north_point_lng);
    	bounds = bounds.extend(fake_north_point);

    	return bounds;
    }
};

$(document).ready(function(){
	map.init();
});

if (!window.console) {
  var noOp = function(){}; // no-op function
  console = {
    log: noOp,
    warn: noOp,
    error: noOp
  }
}
