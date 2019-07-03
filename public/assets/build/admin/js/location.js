$(function(){
    'use strict';
    var table_dynamic_location = $('.table-dynamic-location').DataTable({
		"processing": true,
		"ajax": "../../../../data/location.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
            {"data": "num_notify"},
			{"data": "point"},
			{"data": null}
		],
		"columnDefs": [
            {
				targets: [0, 2],
				class: 'text-center'
			},
			{
				orderable: false,
				targets: [-1],
				class: 'text-center',
				render: function (data, type, row, meta) {
					return  ' <span class="btn-action table-action-edit cursor-pointer tx-success" data-id="' + data.id + '"><i' +
							' class="fa fa-edit"></i></span>' +
							' <span class="btn-action table-action-delete cursor-pointer tx-danger" data-id="' + data.id + '"><i' +
							' class="fa fa-trash"></i></span>';
				}
			}
		]
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(document).on('click', '.table-dynamic-location .table-action-delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#confirm-delete-modal #id').val(id);
        $('#confirm-delete-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
    });
    $(document).on('click', '#addLocation', function (e) {
		e.preventDefault();
		$('#modal-location #ttlModal').html('Add location');
		$('#modal-location').modal('show');
    });
    $(document).on('click', '#btnLocation', function (e) {
        e.preventDefault();
        $('#LocForm').submit();
    });
    $("#LocationForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
    var isdraw = true;
    var drawingManager;
    var all_overlays = [];
    var selectedShape;
    var colors = ['#1E90FF'];
    var selectedColor;
    var colorButtons = {};

    function clearSelection() {
        if (selectedShape) {
            selectedShape.setEditable(false);
            selectedShape = null;
        }
    }

    function setSelection(shape) {
        clearSelection();
        selectedShape = shape;
        shape.setEditable(false);
        selectColor(shape.get('fillColor') || shape.get('strokeColor'));
    }

    function drawPolygon() {
        if(isdraw) {
            drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        }
    }

    function deleteSelectedShape() {
        if (selectedShape) {
            selectedShape.setMap(null);
            // drawingManager.setOptions({
            // drawingControl: true
            // });
            isdraw = true;
        }
    }

    function deleteAllShape() {
        for (var i = 0; i < all_overlays.length; i++) {
            all_overlays[i].overlay.setMap(null);
        }
        all_overlays = [];
        isdraw = true;
    }

    function selectColor(color) {
        selectedColor = color;
        for (var i = 0; i < colors.length; ++i) {
            var currColor = colors[i];
            colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
        }
        var polylineOptions = drawingManager.get('polylineOptions');
        polylineOptions.strokeColor = color;
        drawingManager.set('polylineOptions', polylineOptions);

        var rectangleOptions = drawingManager.get('rectangleOptions');
        rectangleOptions.fillColor = color;
        drawingManager.set('rectangleOptions', rectangleOptions);

        var circleOptions = drawingManager.get('circleOptions');
        circleOptions.fillColor = color;
        drawingManager.set('circleOptions', circleOptions);

        var polygonOptions = drawingManager.get('polygonOptions');
        polygonOptions.fillColor = color;
        drawingManager.set('polygonOptions', polygonOptions);
    }

    function setSelectedShapeColor(color) {
        if (selectedShape) {
            if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
                selectedShape.set('strokeColor', color);
            } else {
                selectedShape.set('fillColor', color);
            }
        }
    }

    function makeColorButton(color) {
        var button = document.createElement('span');
        button.className = 'color-button';
        button.style.backgroundColor = color;
        google.maps.event.addDomListener(button, 'click', function() {
            selectColor(color);
            setSelectedShapeColor(color);
        });

        return button;
    }

    function buildColorPalette() {
        var colorPalette = document.getElementById('color-palette');
        for (var i = 0; i < colors.length; ++i) {
            var currColor = colors[i];
            var colorButton = makeColorButton(currColor);
            colorPalette.appendChild(colorButton);
            colorButtons[currColor] = colorButton;
        }
        selectColor(colors[0]);
    }

    function initialize() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: new google.maps.LatLng(22.344, 114.048),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true
        });

        // SEARCH BOX
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });
        var markers = [];
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        //DRAW POLYGON
        var polyOptions = {
            strokeWeight: 0,
            fillOpacity: 0.45,
            editable: false
        };
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: false,
            drawingControlOptions: {
                drawingModes: [
                    google.maps.drawing.OverlayType.POLYGON
                ]
            },
            markerOptions: {
                draggable: true
            },
            polylineOptions: {
                editable: false
            },
            rectangleOptions: polyOptions,
            circleOptions: polyOptions,
            polygonOptions: polyOptions,
            map: map
        });
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
            if (event.type == google.maps.drawing.OverlayType.CIRCLE) {
                var radius = event.overlay.getRadius();
            }
        });
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
            all_overlays.push(e);
            if (e.type != google.maps.drawing.OverlayType.MARKER) {
                // Switch back to non-drawing mode after drawing a shape.
                drawingManager.setDrawingMode(null);
                // To hide:
                drawingManager.setOptions({
                    drawingControl: false
                });

                // Add an event listener that selects the newly-drawn shape when the user
                // mouses down on it.
                var newShape = e.overlay;
                newShape.type = e.type;
                google.maps.event.addListener(newShape, 'click', function() {
                    setSelection(newShape);
                });
                setSelection(newShape);
            }
        });
        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
            isdraw = false;
            var point = '';
            var polygonArray = [];
            // document.getElementById('info').innerHTML += "<div class='form-control-label mg-b-5'>Polygon points</div>";
            for (var i = 0; i < polygon.getPath().getLength(); i++) {
                // document.getElementById('info').innerHTML += "" + polygon.getPath().getAt(i).toUrlValue(6) + ";";
                polygonArray.push(polygon.getPath().getAt(i).toUrlValue(6));
                point += polygon.getPath().getAt(i).toUrlValue(6) + ";";
            }
            document.getElementById("point").value = point;
            console.log(polygonArray);
        });
        google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
        google.maps.event.addListener(map, 'click', clearSelection);
        google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteAllShape);
        // google.maps.event.addDomListener(document.getElementById('delete-all-button'), 'click', deleteAllShape);
        google.maps.event.addDomListener(document.getElementById('draw-button'), 'click', drawPolygon);

        buildColorPalette();
    }
    google.maps.event.addDomListener(window, 'load', initialize);
});
