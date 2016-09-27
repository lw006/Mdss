<?php 
/**
* 定义文件上传类
*/
class Upload{
    //定义静态属性 $error  上传错误信息
    public static $error;
    /*
     *定义静态方法singleUpload()
     *@param1 要上传的文件，从表单获取的数据$_FILE['img']
     *@param2 目标路径，没有声明的情况下，默认是当前路径
     *@param3 上传的图片size的最大值
     *@param4 定义允许的图片格式
     */
    public static function singleUpload($file,$path=null,$size=2048000,$allow=array()){
        $path=isset($path)?$path:'fileUpload/';//只能用相对路径
        //isset($allow)  返回true
        $allow = !empty($allow) ? $allow : array('image/jpg','image/gif','image/png','image/jpeg','image/bmp');
        if ($file['error']!==0) {
            switch ($file['error']) {
                case '1':
                    self::$error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                    return false;
                case '2':
                    self::$error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                    return false;
                case '3':
                    self::$error = '文件只有部分被上传';
                    return false;
                case '4':
                    self::$error = '没有文件被上传';
                    return false;
                case '6':
                    self::$error = '找不到临时文件夹';
                    return false;
                case '7':
                    self::$error = '文件写入失败';
                    return false;
                default:break;
                }
        }
        /* 判断是否满足 文件自定义的图片上传大小要求 */
        if ($file['size']>2048000) {
            self::$error = "图片不得超过2M";
            return false;
        }
        /* 判断是否符合 文件自定义的图片格式 */
        if (!in_array($file['type'],$allow)) {
            self::$error = "图片格式不正确";
            return false;
        }
        /* 获取上传后的新文件名字*/
        $newName=self::getName($file['name']);
        /*使用copy()函数进行上传*/
        if (copy($file['tmp_name'], $path.$file['name'])) {
            self::$error = '上传成功！';
            return $path.$file['name'];
        }else{
            return 'Uploads Filed';
        }
    }
    private static function getName($filename){
        $name=date('YmdHis',time());
        $str=implode('',range('a','z'));
        for ($i=0; $i <6; $i++) { 
            $name.=$str[rand(0,strlen($str)-1)];
        }
        $name.=strrchr($filename,'.');
        return $name;
    }
}
 ?>