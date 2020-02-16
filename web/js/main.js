document.addEventListener('DOMContentLoaded', function () {

    M.AutoInit();
});
function CreatePost() {
    this.resultAddBase;
    this.i = 0;
    this.data;
    this.getAlbumFlag = 0;
    this.displayToastLength = 2000; // Продолжительность тостов в мс
}

CreatePost.prototype.control = function () {
    const control = this;

    if($('select').is('#groupList')){
        setTimeout(function () {
            control.getGroupAJAX();
        }, 500);
    }

    $('#getGroupsBtn').on('click', function () {
        control.getGroupAJAX();
    });

    $('#addFieldPost').on('click', function(){
        control.addFieldPost();
        control.inputPostHandler();
    });

    $('#deleteFieldPost').on('click', function(){
        control.deleteFieldPost();
    });

    $('#radioCommentForProduct').on('click', function(){
        control.addCommentForProduct()
    });

    $('#createPost').bind('click', function() {
        control.actionStart();
    });

    $('#getAlbums').on('change', function () {

        if ($('#getAlbums').is(':checked')) {
            $('#changeListGroup').prop('hidden', false);
            $('#titleAndDescription').prop('hidden', true);
            control.getAlbumFlag = 1;
            control.getAlbumAJAX();
        } else {
            $('#changeListGroup').prop('hidden', true);
            $('#titleAndDescription').prop('hidden', false);
            $('#albumGroupList').children().remove();
            control.getAlbumFlag = 0;
        }

    });

    this.inputPostHandler();
    this.preloaderCursor();
};

/**
 * Метод запуска закупки
 */
CreatePost.prototype.actionStart = function () {
    if(confirm('Начать парсить?') === true) {
        this.closeInputBtn();
        this.createPostAJAX();
    }
};

/**
 * Проверка введенных ссылок на посты
 */
CreatePost.prototype.inputPostHandler = function () {
    $("input[name*='post']").each(function (count, element) {
        $(element).bind('keyup change', function () {
            if(this.value.search(/wall/) !== -1){
                $(element).removeClass('invalid').addClass('valid');
            } else {
                $(element).removeClass('valid').addClass('invalid');
            }
        });
    });

};

/**
 * Добавление поля для поста
 */
CreatePost.prototype.addFieldPost = function (){
    const inputFieldPostDiv = $('#inputFieldPostDiv');
    $('#inputFieldPost').clone().val('').removeAttr('id').attr('name', 'post' + ++this.i).appendTo(inputFieldPostDiv);

    if($(inputFieldPostDiv).children().length > 15) {
        $('#controlAddLinkPost').appendTo(inputFieldPostDiv);
    }
};

/**
 * Удаление поля для поста
 */
CreatePost.prototype.deleteFieldPost = function (){
    const inputFieldPostDiv = $('#inputFieldPostDiv');
    if($(inputFieldPostDiv).children().length < 18) {
        $('#controlAddLinkPost').appendTo($('#anchorAddFieldPost'));
    }

    if($(inputFieldPostDiv).children().length > 1){
        $('#inputFieldPostDiv input:last').remove();
        --this.i;
    } else {
        M.toast({html: 'В закупке должны быть товары!'});
    }
};

/**
 * Preloader
 */
CreatePost.prototype.preloaderCursor = function () {
    $('<div/>', {
        class: "preloader-wrapper",
        id: "preloaderDiv",
        html:
            '<div class="spinner-layer spinner-red-only">\n' +
            '  <div class="circle-clipper left">\n' +
            '    <div class="circle"></div>\n' +
            '  </div>' +
            '  <div class="gap-patch">\n' +
            '    <div class="circle"></div>\n' +
            '  </div>' +
            '</div>\n',
    }).appendTo($('.createPost'));
};

/**
 * Проверка на ввод комментария
 */
CreatePost.prototype.addCommentForProduct = function(){
    if($('#radioCommentForProduct').prop('checked') === true) {
        $('#yourComments').prop('hidden', false);
    }else {
        $('#yourComments').prop('hidden', true);
    }
};

/**
 * Запрещение на ввод данных
 */
CreatePost.prototype.closeInputBtn = function () {
    $('.btn-floating, #createPost').addClass('disabled');
    $('input').prop('readonly', true);

    $('#preloaderDiv').addClass('active');

    $('#getAlbums').prop('disabled', true);
};

/**
 * Разрешение на ввод данных
 */
CreatePost.prototype.openInputBtn = function () {
    $('.btn-floating, #createPost').removeClass('disabled');
    $('input').prop('readonly', false);

    $('#preloaderDiv').removeClass('active');

    $('#getAlbums').prop('disabled', false);
};

/**
 * Создание альбома, старт закупки
 */
CreatePost.prototype.createPostAJAX = function() {
    const createAlbumAJAX = this;
    this.closeInputBtn();
    M.toast({html: 'Обработка ссылок', 'displayLength' : this.displayToastLength});

    const $msg = $('#createBuyForm').serialize() + '&albumFlag=' + this.getAlbumFlag;
    
    var groupName = $('#groupList').val();
    if (($.trim(groupName)).length == 0) {
    	this.openInputBtn();
    	return M.toast({html: 'Выберите группу', 'displayLength' : this.displayToastLength});
    }
    var albumInputName = $('#namepost').val();
    if(this.getAlbumFlag == 0 && ($.trim(albumInputName)).length == 0) {
    	this.openInputBtn();
    	return M.toast({html: 'Имя альбома не может быть пустым', 'displayLength' : this.displayToastLength});
    }
    // console.log($msg);
    $.post({
        url: '/system/start-parsing',
        async: true,
        data: $msg,
        success: function (data) {
            // console.log(data);
            var data = JSON.parse(data);

            if(data.result == 'Field empty') {
                M.toast({html: 'Заполните название альбома ссылку на пост-ВК!'});
                createAlbumAJAX.openInputBtn();
            } else if(data.result == 'success') {
                createAlbumAJAX.openInputBtn();
                M.toast({
                    html: 'Ссылки обработаны. Загружаем фото!',
                    'displayLength': createAlbumAJAX.displayToastLength
                });

                createAlbumAJAX.renderPostLinks(data.response, data.text, data.albumId, data.groupId);
            } else {
                M.toast({html: 'Ошибка! Сообщите в поддержку!'});
                createAlbumAJAX.openInputBtn();
            }
        },
        error: function (data) {
            M.toast({html: 'Ошибка! Сообщите в поддержку!'});
            console.log(data.responseText);
        }
    });
};


/**
 *Рендер выбранных ссылок
 *
 */
CreatePost.prototype.renderPostLinks = function(links, text, albumId, groupId)
{
    $('#createPostId').children().remove();

    $('#createPostId').append('<h5 class="albumId" id="' + groupId + '__id__' + albumId + '">Выберите фото для загрузки</h5>' +
        '<div class="row">' +
        '<button id="deleteTextArea" type="button" class="waves-effect waves-light btn-small">' +
        'Удалить все описание' +
        '</button>' +
        '<button id="activeAllBtn" type="button" class="waves-effect waves-light btn-small">' +
        'Выбрать все фото' +
        '</button>'+
        '</div>');

    for(i = 0; i<links.length; i++)
    {
        $('#createPostId').append(
            '    <div class="col s12 m6 l4 xl4" id="cardPostLink__id__' + i + '">\n' +
            '      <div class="card">\n' +
            '        <div class="card-image disableCard waves-effect waves-block waves-light">\n' +
            '          <img style="height: 40vh" src=' + links[i] + '>\n' +
            '        </div>\n' +
            '        <div class="card-content">\n' +
            '          <textarea placeholder="Описание фотографии" style="min-height: 150px">' + text[i] + '</textarea>\n' +
            '        </div>' +
            '      </div>\n' +
            '    </div>\n'
        );
        // console.log(links[i]);
    }

    $('<div class="row center-align">' +
        '<button id="sendImagesBtn" type="button" class="waves-effect waves-light btn-large createBuy">' +
            'Загрузить в группу' +
        '</button>' +
        '</div>'
    ).insertAfter($('#createPostId'));

    var $this = this;


    $('.card-image').on('click', function () {
        $(this).toggleClass('disableCard activeCard');
    });

    $('#deleteTextArea').on('click', function () {
        $('textarea').val('');
    });

    $('#activeAllBtn').on('click', function () {
        $('.card-image').toggleClass('disableCard activeCard');
        var text = $(this).text();
        $(this).text(text == "Снять выделение" ? "Выбрать все фото" : "Снять выделение");
    });

    $('#sendImagesBtn').on('click', function(){
        $(this).addClass('hide');
        $('<div class="loadDiv center-align">' +
            '<h1 style="margin-top: 25%">Идет загрузка изображений</h1>' +
            '<div class="progress preload_div">' +
            '<div class="indeterminate preload_div__strip"></div>'+
            '</div>'+
            '</div>').prependTo($('main'));
        $this.sendImagesAlbum();
    });
};

/**
 * Загрузка фото в альбом
 */
CreatePost.prototype.sendImagesAlbum = function(count = 0, i = 0) {
    const $this = this;
    M.toast({html: 'Отправляем фото в альбом!', 'displayLength' : $this.displayToastLength});

    var album = $('.albumId').attr('id');
    idAlbum = album.split('__id__')[1];
    groupId = album.split('__id__')[0];
    
    var photo = $('.activeCard').toArray();
    if(photo.length == 0) {
        $('.loadDiv').remove();
        $('#sendImagesBtn').removeClass('hide');
        return M.toast({html: 'Ошибка! Фотографии не выбраны!', 'displayLength' : $this.displayToastLength});
    }
    var srcImg = $(photo[i]).children()[0]['currentSrc'];
    var innerText = $(photo[i]).next().html($('textarea').val())[0]['innerText'];
    var idPhoto = photo[i].parentElement.parentElement.id;

    // console.log();

    $msg = 'groupId=' + groupId + '&idAlbum=' + idAlbum + '&srcImg=' + srcImg + '&innerText=' + innerText + '&idPhoto='+  idPhoto;

    this.sendPhotoAJAX($msg, count, i, photo.length);
};

/**
 * Метод загрузки фото в альбом
 *
 * @param $msg
 * @param count
 * @param i
 * @param photoLength
 */
CreatePost.prototype.sendPhotoAJAX = function($msg, count, i, photoLength) {
    const $this = this;

    $.post ({
        url: '/system/send-photo',
        data: $msg,
        success: function (data) {
            var data = JSON.parse(data);
            // console.log(data);
            count ++;
            i++;
            if(data.result == 'success') {
                M.toast({html: 'Фото загружено!', 'displayLength' : $this.displayToastLength});
                $('#' + data.idPhoto).addClass('green lighten-2');
                if(count != photoLength) {
                    setTimeout(function () {
                        $this.sendImagesAlbum(count, i);
                    }, 1000);
                    
                }
            } else {
                M.toast({html: 'Ошибка!', 'displayLength' : $this.displayToastLength});
                $('#' + data.idPhoto).addClass('red');
                $this.sendImagesAlbum(count, i);
            }
            if(count == photoLength) {
                $('.loadDiv').remove();
                
                    $('<div class="row center-align">' +
                    '<button onclick="location.href=\'/system/parsing\'" type="button" class="waves-effect waves-light btn-large createBuy">' +
                    'Загрузить другие фотографии' +
                    '</button>' +
                    '</div>').insertAfter($('#createPostId'));
    
                M.toast({html: 'Все фотографии загружены!', 'displayLength' : $this.displayToastLength});
            }
                    },
        error: function (data) {
            console.log(data);
            $('.loadDiv').remove();
            $('sendImagesBtn').removeClass('hide');
            M.toast({html: 'Ошибка загрузки!', 'displayLength' : $this.displayToastLength});
        }
    });
};

/**
 * Метод получения групп
 */
CreatePost.prototype.getGroupAJAX = function () {
    const $this = this;
    M.toast({html: 'Загружаем список групп', 'displayLength' : 2000});

    $.post({
        url: '/system/get-group',
        success: function (data) {
            var data = JSON.parse(data);
            // console.log(data);
            if(data.result = 'success') {
                M.toast({html: 'Группы загружены', 'displayLength' : 2000});
                $this.groupGroupRender(data.items);
            } else if(data.result = 'error') {
                M.toast({html: 'Ошибка загрузки групп', 'displayLength' : this.displayToastLength});
            } else {

            }
        },
        error: function (data) {
            // console.log(data.responseText);
            if(data.responseText.search(/invalid access_token/i))
            {
                M.toast({html: 'Ошибка, переавторизуйте страницу ВК', 'displayLength' : this.displayToastLength});
            } else {
                M.toast({html: 'Ошибка загрузки групп', 'displayLength' : this.displayToastLength});
            }
        }
    });
};

/**
 * Метод получения альбомов AJAX
 */
CreatePost.prototype.getAlbumAJAX = function () {
    const $this = this;

    $msg = $('#createBuyForm').serialize();

    M.toast({html: 'Загружаем список альбомов', 'displayLength' : 2000});
    $.post({
        url: '/system/get-album',
        data: $msg,
        success: function (data) {
            var data = JSON.parse(data);
            // console.log(data);
            if(data.result == 'success') {
                M.toast({html: 'Альбомы загружены', 'displayLength' : 2000});
                $this.groupAlbumRender(data.items);
            } else if(data.result == 'error') {
                M.toast({html: 'Ошибка загрузки альбомов', 'displayLength' : this.displayToastLength});
            } else if(data.result == 'notFoundGroup') {
                M.toast({html: 'Ошибка! Группа не выбрана!'});
            }
        },
        error: function (data) {
            // console.log(data.responseText);
            if(data.responseText.search(/invalid access_token/i))
            {
                M.toast({html: 'Ошибка, переавторизуйте страницу ВК', 'displayLength' : this.displayToastLength});
            } else {
                M.toast({html: 'Ошибка загрузки альбомов', 'displayLength' : this.displayToastLength});
            }
        }
    });
};

/**
 * Метод  рендера списка групп
 * @param data
 */
CreatePost.prototype.groupGroupRender = function (data) {
    const dataList = $('#groupList');

    $(dataList).children().remove();
    for(i=0; i<data.length; i++) {
        $('<option/>', {
            text: data[i]['name'],
            value: data[i]['name'] + '__id__' + data[i]['id']
        }).appendTo(dataList);

    }
};

/**
 * Метод  рендера списка альбомов
 * @param data
 */
CreatePost.prototype.groupAlbumRender = function (data) {
    const dataList = $('#albumGroupList');

    $(dataList).children().remove();
    for(i=0; i<data.length; i++) {
        $('<option/>', {
            text: data[i]['title'],
            value: data[i]['title'] + '__id__' + data[i]['id']
        }).appendTo(dataList);

    }
};

const createPost = new CreatePost();
createPost.control();