ymaps.ready(init);

var myMap;
mX = 53.8963;
mY = 27.5580;
fzoom = 11;
var loc = "";
var loc1 = "";

function init(){
    if(loc == 'http://findtofind/showvacancy.php')
    {
        myMap = new ymaps.Map('map', {
            center: [mX, mY],
            zoom: fzoom
        }, {
            searchControlProvider: 'yandex#search'
        }),

        // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),

        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            hintContent: 'Местоположение вакансии'
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: 'images/marker.png',
            // Размеры метки.
            iconImageSize: [38, 40],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-19, -40]
        });


        myMap.geoObjects
        .add(myPlacemark);
    }
    else if(document.location == "http://findtofind/addvac.php")
    {
        var myPlacemark,
        myMap = new ymaps.Map('map', {
            center: [53.9020, 27.5591],
            zoom: 11
        }, {
            searchControlProvider: 'yandex#search'
        });

        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            if(coords) $("input[type='text'][name='coord']").val(coords);
            getAddress(coords);
        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                var coordis = firstGeoObject.properties.get("text");
                var str1 = coordis.split(", ");
                if(str1[0]) $("input[type='text'][name='country']").val(str1[0]);
                if(str1[1]) $("input[type='text'][name='city']").val(str1[1]);
                if(str1[2]) $("input[type='text'][name='street']").val(str1[2]);
                if(str1[3]) $("input[type='text'][name='house']").val(str1[3]);
                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }
    }
    else if(loc1 == "http://findtofind/updatevacancy.php")
    {
        var myPlacemark,
        myMap = new ymaps.Map('map', {
            center: [mX, mY],
            zoom: fzoom
        }, {
            searchControlProvider: 'yandex#search'
        });

        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            if(coords) $("input[type='text'][name='coord']").val(coords);
            getAddress(coords);
        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                var coordis = firstGeoObject.properties.get("text");
                var str1 = coordis.split(", ");
                if(str1[0]) $("input[type='text'][name='country']").val(str1[0]);
                if(str1[1]) $("input[type='text'][name='city']").val(str1[1]);
                if(str1[2]) $("input[type='text'][name='street']").val(str1[2]);
                if(str1[3]) $("input[type='text'][name='house']").val(str1[3]);
                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }

        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            hintContent: 'Местоположение вакансии'
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: 'images/marker.png',
            // Размеры метки.
            iconImageSize: [38, 40],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-19, -40]
        });


        myMap.geoObjects
        .add(myPlacemark);
    }
}

