<?php
namespace App\Http\Controllers\Upload;
use App\Http\Controllers\Controller;
use Qiniu\Auth;


/**
 * Created by PhpStorm.
 * User: lock
 * Date: 16/1/14
 * Time: 23:49
 */
class UploadController extends Controller{

    /**
     * 执行上传
     */
    public function execute(){
        $accessKey = \Config::get('qiniu.qiniu.accessKey');
        $secretKey = \Config::get('qiniu.qiniu.secretKey');
        $auth = new Auth($accessKey,$secretKey);
        //类型限制
        $allowTypes = array('image/gif',
            'image/jpg',
            'image/png',
            'image/bmp',
            'image/jpeg',
        );
        //大小限制
        $fsizeLimit = 5*1024*1024;
        //保存在七牛的文件名
        $newKey = $this->generateKey(111111);
        $bucketZone = \Config::get('qiniu.qiniu.bucket.public');
        $policy = array(
            'returnUrl' => "http://www.gittest.com/upload/success",
            'scope' => $bucketZone. ':' . $newKey,
            'saveKey'=>$newKey,
            'returnBody' => '{
                    "key":"' . $newKey . '",
                    "time":' . time() . ',
                    "bucket":$(bucket),
                    "fsize":$(fsize),
                    "imageInfo":$(imageInfo),
                    "exif":$(exif)
                }',
            //这里注意添加自定义的变量
            'mimeLimit'=>implode(';',$allowTypes),
            'fsizeLimit'=>$fsizeLimit,
        );
        $bucket = $bucketZone;
        $token = $auth->uploadToken($bucket,null,3600,$policy);
        return view('upload.execute',array('token'=>$token));
    }

    /**
     * 完成上传的http 303 ,分两种形式,1->回调 2->303跳转
     * 此处写上传后的 业务逻辑 ,保存路径到数据库
     */
    public function success(){
        $codeMap=array(
            413=>'图片大小不能超过5M',
            403=>'文件格式错误',
        );
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            $msg = isset($codeMap[$code])?$codeMap[$code]:$_GET['error'];
            throw new \Exception($msg,$code);
        }

        $uploadRet=$_GET['upload_ret'];
        $result  = json_decode(\Qiniu\base64_urlSafeDecode($uploadRet),1);
        var_dump($result);
        echo 'success';
        die;
    }

    private function generateKey($uid) {
        //分两级  例如 123456  => 56/34/123456/
        $s = substr($uid,-2,2).'/';
        if(strlen($uid)>4){
            $s .= substr($uid,-4,2).'/';
        }
        return 'user/user/'.$s. $uid.'/'.time();
    }
}
