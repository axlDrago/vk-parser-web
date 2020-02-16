# vk-parser-web Yii2

Веб приложение Парсер ВК. Планируется к добавлению Instagram с автопостингом.

В файле param.php указать данные приложения ВК:
'client_id' => '',
'redirect_uri' => '', можно указать ip адрес контейнера
'client_secret' => '',

# Старт приложения:
из корня
	1. composer install
	2. docker-compose up -d
	3. docker-compose run php migrate

Приложение доступно по адресу localhost:8000