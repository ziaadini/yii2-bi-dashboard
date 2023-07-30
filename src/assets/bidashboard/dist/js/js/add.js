$('#AddDatepicker').on('click', AddDatepicker);
$('#RemoveDatepicker').on('click', removeDatepicker);
$('#RemoveHeadlines').on('click', removeHeadlines);
$('#AddHeadlines').on('click', AddHeadlines);

function AddHeadlines() {
    var childs = document.getElementsByClassName("AddHeadlines");
    var number=childs.length;
    $('<div class="AddHeadlines">' +
        '<label>سرفصل </label>'+
        '<input type="text" id="event-headlines" class="form-control" name="Event[headlines]['+number+'][\'title\']" maxlength="255" aria-required="true" aria-invalid="true">' +
        '<label>محتوای هر سر فصل </label>'+
        '<input type="text" id="event-headlines" class="form-control" name="Event[headlines]['+number+'][\'description\']" maxlength="255" aria-required="true" aria-invalid="true">' +
        '</div>'
    ).appendTo('#number-headlines');
}

function removeHeadlines() {
    var childs = document.getElementsByClassName("AddHeadlines");
    if(childs.length > 0) {
        childs[childs.length - 1].remove();
    }
}

function removeDatepicker() {
    var childs = document.getElementsByClassName("someInput");
    if(childs.length > 0) {
        childs[childs.length - 1].remove();
    }
}
$('#dropdown').change( function(){
    $.ajax({
        type: "POST",
        url: "activity/change",
        data: {'id' : event.target.id,'value': event.target.value },
        success: function (data) {
            alert(data);
        },
        error: function (errormessage) {

            //do something else
            alert("not working");

        }
    });
});
$('#button-collapse').click(function (){
    if ( document.getElementById("logo-expand").style.display=="block") {
        document.getElementById("logo-close").style.display = "block";
        document.getElementById("logo-expand").style.display = "none";
    }else{
        document.getElementById("logo-close").style.display = "none";
        document.getElementById("logo-expand").style.display = "block";
    }
});
function createMap($model, $latitude=30.289358507458676,$longitude=57.04063207695452) {
    let config = {
        minZoom: 7,
        maxZoom: 18,
    };
    // magnification with which the map will start
    const zoom = 18;
    var lat=$latitude;
    var lng=$longitude;
    // co-ordinate
    const map = L.map("map", config).setView([lat, lng], zoom);
    var marker = L.marker([lat, lng]).addTo(map);
    map.on("click", function (e) {
        map.removeLayer(marker);
        const markerPlace = document.querySelector(".marker-position");
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map).bindPopup("Center Warsaw");
        document.getElementById($model+"-latitude").value=e.latlng.lat;
        document.getElementById($model+"-longitude").value=e.latlng.lng;
    });

    // Used to load and display tile layers on the map
    // Most tile servers require attribution, which you can set under `Layer`
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

}
function viewMap() {
    let config = {
        minZoom: 7,
        maxZoom: 18,
    };
    // magnification with which the map will start
    const zoom = 18;
    // co-ordinates
    const lat = document.getElementById("map-latitude").value;
    const lng = document.getElementById("map-longitude").value;
    const map = L.map("map", config).setView([lat, lng], zoom);
    var marker = L.marker([lat, lng]).addTo(map);
    // Used to load and display tile layers on the map
    // Most tile servers require attribution, which you can set under `Layer`
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);
}
$(document).ready(function() {
    // Reload pjax container when a tab is shown
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var target = $(e.target).attr("http://backend.ince.local/businesses/get-block"); // Get the target tab
        var pjaxContainer = $(target + ' .yii2-pjax-container'); // Get the pjax container inside the tab
        if (pjaxContainer.length) {
            $.pjax.reload({container: pjaxContainer.attr('id'), timeout: 10000});
        }
    });
});


