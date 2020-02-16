<?php

namespace app\models\system;

use app\models\Vk;
use VK\Client\VKApiClient;
use VK\Client\VKApiError;
use VK\Exceptions\Api\ExceptionMapper;
use VK\Exceptions\Api\VKApiAuthException;
use VK\Exceptions\VKApiException;
use VK\TransportClient\Curl\CurlHttpClient;
use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\FileHelper;

/**
 * Dashboard is the model profile user
 */
class Parsing extends Model
{
    protected $access_token;
    public $arrErr = array();

    /**
     * Метод получения токена из сессии
     *
     * @return mixed
     */
    public function getToken()
    {
        $this->access_token = Yii::$app->session['access_token'];
        return $this->access_token;
    }

    /**
     * Метод получения списка групп
     *
     * @return false|string
     * @throws VKApiException
     * @throws \VK\Exceptions\Api\VKApiAccessGroupsException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getGroup() {
        $vk = new VKApiClient();
        $response = $vk->groups()->get($this->getToken(), array(
            'filter' => 'editor',
            'fields' => array('name', 'is_admin'),
            'extended' => '1'
        ));

        return json_encode($response);
    }

    /**
     * Метод получения списка альбомов
     *
     * @return false|string
     * @throws VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getAlbum() {
        if(Yii::$app->request->post('groupList'))
        {
            $groupId = Yii::$app->request->post('groupList');
            $groupId = explode('__id__', $groupId)[1];

            $vk = new VKApiClient();
            $response = $vk->photos()->getAlbums($this->getToken(), array(
                'owner_id' => '-' . $groupId,
            ));

            $result = ['result' => 'success', 'items' => $response['items'],];
        } else {
            $result = ['result' => 'notFoundGroup'];
        }

        return json_encode($result);
    }

    /**
     * Метод обработки ссылок на стену, создание массива с ссылками и описанием фото
     *
     * @return false|string
     * @throws VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function startParsing()
    {
        $post = '';
        foreach (Yii::$app->request->post() as $key => $value) {
            if (preg_match('/post/', $key) != 0 && preg_match('/wall/', $value) != 0) {
                $value = explode('wall', $value);
                if (!empty($value[0])) {
                    $post .= end($value) . ',';
                }
            }
        };

        $this->arrErr[] = [
            'links_photo' => $post,
            'flagAlbum' => Yii::$app->request->post('albumFlag')
        ];
        $this->logErr();

        if (Yii::$app->request->post('albumFlag') == 1 && $post != '') {
            $albumId = Yii::$app->request->post('albumGroupList');
            $albumId = explode('__id__', $albumId)[1];;
            return $this->getPhotos($post, $albumId);

        } else if (Yii::$app->request->post('albumFlag') == 0 && $post != '')
        {
            return $this->createAlbum($post);
        } else if ($post == '')
        {
             $post = ['result' => 'Field empty'];
        }

        return json_encode($post);
    }

    /**
     * Метод создания альбома
     *
     * @param $post
     * @return false|string
     * @throws VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function createAlbum($post)
    {
        $groupId = Yii::$app->request->post('groupList');
        $groupId = explode('__id__', $groupId)[1];

        $vk = new VKApiClient();
        $response = $vk->photos()->createAlbum($this->getToken(),[
            'title' => Yii::$app->request->post('nameAlbum'),
            'description' => Yii::$app->request->post('description'),
            'group_id' => $groupId,
        ]);

        $this->arrErr[] = ['createAlbum' => $response];
        $this->logErr();

        return $this->getPhotos($post, $response['id']);
//        return json_encode([
//            'idAlbum' => $response['id'],
//        ]);
    }

    /**
     * Метод получения ссылок на фото и текст из загруженных ссылок со стены
     *
     * @param $post
     * @return false|string
     * @throws VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getPhotos($post, $albumId)
    {
        $groupId = Yii::$app->request->post('groupList');
        $groupId = explode('__id__', $groupId)[1];

        $vk = new VKApiClient();
        $response = $vk->wall()->getById($this->getToken(), array(
            'posts' => $post
        ));

        $imageArr = array();
        $textArr = array();

        for ($j = 0; $j < count($response); $j++) {
            if(array_key_exists ('copy_history', $response[$j])) {
                for ($i = 0; $i < count($response[$j]['copy_history'][0]['attachments']); $i++) {
                    if (isset($response[$j]['copy_history'][0]['attachments'][$i]['photo']) != false) {
                        $responseImg = end($response[$j]['copy_history'][0]['attachments'][$i]['photo']['sizes']);
                        $imageArr[] = $responseImg['url'];
                        $textArr[] = $response[$j]['copy_history'][0]['text'];
                    }
                }
            }

        }

        for ($j = 0; $j < count($response); $j++) {
            if(array_key_exists ('attachments', $response[$j])) {
                for ($i = 0; $i < count($response[$j]['attachments']); $i++) {
                    if (isset($response[$j]['attachments'][$i]['photo']) != false) {
                        $responseImg = end($response[$j]['attachments'][$i]['photo']['sizes']);
                        $imageArr[] = $responseImg['url'];
                        $textArr[] = $response[$j]['text'];
                    }
                }
            }

        }


        return json_encode([
            'result' => 'success',
            'response' => $imageArr,
            'text' => $textArr,
            'albumId' => $albumId,
            'groupId' => $groupId,
        ]);
    }

    /**
     * Метод загрузки фото в альбом
     * @return false|string
     * @throws VKApiException
     * @throws \VK\Exceptions\Api\VKApiParamAlbumIdException
     * @throws \VK\Exceptions\Api\VKApiParamHashException
     * @throws \VK\Exceptions\Api\VKApiParamServerException
     * @throws \VK\Exceptions\VKClientException
     */
    public function sendPhoto()
    {
        $result = 'success';
        $idPhoto = Yii::$app->request->post('idPhoto');
        $photoSrc = Yii::$app->request->post('srcImg');

        $vk = new VKApiClient();
        $address = $vk->photos()->getUploadServer($this->getToken(), [
            'album_id' => Yii::$app->request->post('idAlbum'),
            'group_id' => Yii::$app->request->post('groupId'),
        ]);

        $path = md5(uniqid(rand(),1));
        file_put_contents(Yii::getAlias('@app') . '/' . Yii::$app->params['webroot'] . '/userdata/shipping/' . $path . '.jpg', file_get_contents($photoSrc));
        $file1 = Yii::getAlias('@app') . '/' . Yii::$app->params['webroot'] . '/userdata/shipping/' . $path . '.jpg';

        $photo = $vk->getRequest()->upload($address['upload_url'], 'file1', $file1);

        $response_save_photo = $vk->photos()->save($this->getToken(), array(
            'album_id' => $photo['aid'],
            'group_id' => $photo['gid'],
            'server' => $photo['server'],
            'photos_list' => $photo['photos_list'],
            'hash' => $photo['hash'],
            'caption' => Yii::$app->request->post('innerText'),
        ));

        FileHelper::unlink($file1);

        $this->arrErr['sendPhoto'] = $photo;
        $this->arrErr['responseSavePhoto'] = $response_save_photo;

        $this->logErr();

        return json_encode([
            'result' => $result,
            'idPhoto' => $idPhoto,
        ]);
    }

    /**
     * Создание лога с ошибками в формате txt
     * @throws \yii\base\Exception
     */
    function logErr()
    {
        FileHelper::createDirectory(Yii::getAlias('@app') . '/' . Yii::$app->params['webroot'] . '/userdata/log/' . Yii::$app->session['username'], 0777, true);
        $logFile = fopen(Yii::getAlias('@app') . '/' . Yii::$app->params['webroot'] . '/userdata/log/' . Yii::$app->session['username'] .'/'. 'log.txt', 'a+');
        fwrite($logFile, "\r\n" . '-------------------------------------------'.date('r').'-------------------------------------------------------------------------------------');
        fwrite($logFile, "\r\n" . json_encode($this->arrErr)."\r\n");
        fwrite($logFile, '-------------------------------------------'.date('r').'-------------------------------------------------------------------------------------');
        fclose($logFile);
    }

}
