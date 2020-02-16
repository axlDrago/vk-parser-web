<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Parsing';
?>
<div class="container">
    <div id="createPostId" class="row center-align">
        <div class="col offset-xl4 xl4 offset-l3 l6 offset-m2 m8 s12">
            <div class="createPost">
                <h5>Создание новой Загрузки</h5>
                <form action="#" id="createBuyForm">
                    <p>Выберите группу:</p>
                    <div class="row" id="changeGroupList">
                        <div class="input-field col s12">
                            <select name="groupList" id="groupList" class=" browser-default">
                                <option value="" disabled selected>Выберите группу:</option>
                            </select>
                        </div>
                    </div>

<!--                    <button id="getGroupsBtn" type="button" class="waves-effect waves-light btn-large createBuy">Загрузить список групп</button>-->

                    <p>Создать новый альбом?</p>
                    <div class="switch">
                        <label>
                            Да
                            <input type="checkbox" id="getAlbums">
                            <span class="lever"></span>
                            Нет
                        </label>
                    </div>

                    <div class="row" id="changeListGroup" hidden>
                        <div class="input-field col s12">
                            <select name="albumGroupList" id="albumGroupList" class=" browser-default">
                                <option value="" disabled selected>Выберите альбом:</option>
                            </select>
                        </div>
                    </div>

                    <div id="titleAndDescription">
                        <div class="row">
                            <div class="input-field">
                                <input id='namepost' name="nameAlbum" type="text">
                                <label for="namepost">Название альбома</label>
                                <span id="helperText"  class="helper-text">Название альбома</span>
                            </div>
                        </div>
                        <p>
                            <label>
                                <input id="radioCommentForProduct" type="checkbox"/>
                                <span>Добавить описание альбома?</span>
                            </label>
                        </p>
                        <div class="row">
                            <div id="yourComments" class="input-field" hidden>
                                <input id="yourCommentsInput" type="text" name="description">
                                <label for="yourCommentsInput">Добавить описание альбома</label>
                                <span id="helperText"  class="helper-text">Добавить описание альбома</span>
                            </div>
                        </div>
                    </div>

                    <div id="anchorAddFieldPost"></div> <!--Якорь для #controlAddLinkPost при переключении-->

                    <div class="row createPost__caption_text" id="controlAddLinkPost">
                        <h5>Добавьте ссылки на посты:</h5>
                        <a id="addFieldPost" class="btn-floating btn-medium waves-effect waves-light red"><i class="material-icons">add</i></a>
                        <a id="deleteFieldPost" class="btn-floating btn-medium waves-effect waves-light red"><i class="material-icons">do_not_disturb_on</i></a>
                    </div>
                    <div class="row">
                        <div id="inputFieldPostDiv" class="input-field">
                            <input id="inputFieldPost" type="text" name="post0" placeholder="https://vk.com/id482039293?w=wall482039293_1747">
                        </div>
                    </div>

                    <button id="createPost" type="button" class="waves-effect waves-light btn-large createBuy">Загрузить фото</button>
                </form>
            </div>
        </div>
    </div>
</div>