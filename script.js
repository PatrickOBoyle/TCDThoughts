function fillFormData(self){
    var place_value = self.value;
    
    // fill in form data with presets
    switch(place_value){
        case "tcd":
            var lat = 53.343;
            var long = -6.2545;
            var radius = 1;
            setValues(lat, long, radius);
            break;
        case "london":
            var lat = 51.5072;
            var long = -0.1275;
            var radius = 15;
            setValues(lat, long, radius);
            break;
        case "dublin":
            var lat = 53.3475;
            var long = -6.2541342;
            var radius = 10;
            setValues(lat, long, radius);
            break;
        case "sf":
            var lat = 37.7833;
            var long = -122.4167;
            var radius = 15;
            setValues(lat, long, radius);
            break;
        case "paris":
            var lat = 48.8567;
            var long = 2.3508;
            var radius = 15;
            setValues(lat, long, radius);
            break;
        case "nyc":
            var lat = 40.7127;
            var long = -74.0059;
            var radius = 20;
            setValues(lat, long, radius);
            break;
    }
}

function setValues(lat, long, radius){
    $('#lat').val(lat);
    $('#long').val(long);
    $('#radius').val(radius);
}