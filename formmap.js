"use strict";
let map, theMarker, map2, theMarker2;

function initMap() {
    const here ={lat: -33.4575, lng: -70.663472};
    map = new google.maps.Map(document.getElementById("map"), {
        center: here,
        zoom: 14,
        streetViewControl: false,
        mapTypeControl: false,
        fullScreenControl: false
    });
    map2 = new google.maps.Map(document.getElementById("map2"), {
        center: here,
        zoom: 14,
        streetViewControl: false,
        mapTypeControl: false,
        fullScreenControl: false
    });

    theMarker = new google.maps.Marker({
        position: here,
        map:map,
        title: 'You are here',
        draggable: true
    });

    theMarker2 = new google.maps.Marker({
        position: here,
        map:map2,
        title: 'You are here',
        draggable: true
    });

    const geocoder = new google.maps.Geocoder;
    const InfoWindow = new google.maps.InfoWindow();
    const geocoder2 = new google.maps.Geocoder;
    const InfoWindow2 = new google.maps.InfoWindow();

    document.getElementById("submit").addEventListener("click", () => {
        const address = document.getElementById("address").value;
        if (address!=""){
            geocodeAddress(geocoder, map, theMarker, InfoWindow,address,"d");
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Dirección en blanco',
                text: 'Escriba una dirección e intentelo nuevamente'
            })
        }
    });

    document.getElementById("submit2").addEventListener("click", () => {
        const address = document.getElementById("address2").value;
        if (address!=""){
            geocodeAddress(geocoder2, map2, theMarker2, InfoWindow2,address,"t");
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Dirección en blanco',
                text: 'Escriba una dirección e intentelo nuevamente'
            });
        }
    });

    theMarker.addListener('dragend',function(){
        geodecodeAddress(geocoder, map, theMarker, InfoWindow,"d");
    });

    theMarker2.addListener('dragend',function(){
        geodecodeAddress(geocoder2, map2, theMarker2, InfoWindow2,"t");
    });

    function geodecodeAddress(geocoder, resultsMap, resultsMarker,infowindow,i) {
        const position = resultsMarker.position;
        geocoder.geocode(
            {
                location: position
            },
            (results, status) => {
                let n = (i=="d")?"":"2";
                if (status === "OK") {
                    if (results[0]) {
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(resultsMap, resultsMarker);
                        document.getElementById("address"+n).value = results[0].formatted_address;
                        document.getElementById("coo"+i).value = "("+results[0].geometry.location.lat()+","+results[0].geometry.location.lng()+")";
                        document.getElementById("comuna"+i).value = results[0].address_components[results[0].address_components.length-4].long_name;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Dirección no encontrada'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Geocode ha fallado',
                        text: 'Status = '+status
                    });
                }
            }
        );
    }

    function geocodeAddress(geocoder, resultsMap, resultsMarker, InfoWindow,address,i) {
        geocoder.geocode(
            {address: address},
            (results, status) => {
                let n = (i=="d")?"":"2";
                if (status === "OK") {
                    document.getElementById("coo"+i).value = "("+results[0].geometry.location.lat()+","+results[0].geometry.location.lng()+")";
                    document.getElementById("address"+n).value = results[0].formatted_address;
                    document.getElementById("comuna"+i).value = results[0].address_components[results[0].address_components.length-4].long_name;
                    resultsMap.setCenter(results[0].geometry.location);
                    resultsMarker.setPosition(results[0].geometry.location);
                    resultsMarker.setMap(resultsMap);
                    InfoWindow.setContent(results[0].formatted_address);
                    InfoWindow.open(resultsMap, resultsMarker);
                }
                else if (status === "ZERO_RESULTS") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Dirección no encontrada',
                        text: 'Añada mas información a la dirección e intentelo nuevamente'
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Geocode ha fallado',
                        text: 'Status = '+status
                    });
                }
            }
        );
    }

    //Ubicacion actual
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                geocoder.geocode(
                    {location: pos},
                    (results, status) => {
                        if (status === "OK") {
                            if (results[0]) {
                                InfoWindow.setContent(results[0].formatted_address);
                                InfoWindow.open(map, theMarker);
                                InfoWindow2.setContent(results[0].formatted_address);
                                InfoWindow2.open(map2, theMarker2);
                                document.getElementById("DirCarro").value = results[0].formatted_address;
                                document.getElementById("CoorCarro").value = "("+pos.lat+","+pos.lng+")";
                            }
                        }
                        else {
                            handleLocationError(true, InfoWindow, map.getCenter());
                        }
                    }
                );
                map.setCenter(pos);
                theMarker.setPosition(pos);
                map2.setCenter(pos);
                theMarker2.setPosition(pos);
            },
            () => {handleLocationError(true, InfoWindow, map.getCenter());}
        );
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, InfoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, InfoWindow, pos) {
    InfoWindow.setPosition(pos);
    InfoWindow.setContent(
        browserHasGeolocation
            ? "Error: El servicio de Geolocalización ha fallado."
            : "Error: Tu navegador no soporta Geolocalización."
    );
    InfoWindow.open(map);
}