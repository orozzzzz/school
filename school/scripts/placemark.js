ymaps.ready(init);

function init() {
    var request = new XMLHttpRequest();
    request.open("GET", "http://school/req/query.php", false);
    request.send();
    var status = request.status;
    if(status==200){
        var answer = request.responseText;
        var a = JSON.parse(answer);
          var myMap = new ymaps.Map("map", {
            center: [55.786273, 49.135735],
            zoom: 12,
            controls:  ['zoomControl','fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        });

        for (index in a){
             myMap.geoObjects
            .add(new ymaps.Placemark([a[index].cor1, a[index].cor2], {
                balloonContentHeader: a[index].name,
                balloonContentBody: "Приём заявок с "+a[index].startdate + " по "+a[index].enddate,
                balloonContentFooter: "<a href='http://school/?page=school&id="+a[index].id+"'>Перейти на страницу школы</a>"
            }, {
                preset: 'islands#redEducationCircleIcon',
                iconColor: '#0095b6'
            }));
        }
        
    }
   
}
