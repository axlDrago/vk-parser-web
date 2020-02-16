# vk-parser-web Yii2

Веб приложение Парсер ВК. Планируется к добавлению Instagram с автопостингом.

В файле param.php указать данные приложения ВК:<br/> 
'client_id' => '', <br/> 
'redirect_uri' => '', можно указать ip адрес контейнера<br/> 
'client_secret' => '',<br/> 

# Старт приложения:
из корня<br/> 
	1. composer install<br/> 
	2. docker-compose up -d<br/> 
	3. docker-compose run php migrate<br/> 

Приложение доступно по адресу localhost:8000
