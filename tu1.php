<?php  
    error_reporting(0);
    define("ROOTDIR", 'D:\www\ha');  
    define("DSDIR", "D:\www\ha\q");  
    define("SEPARATER", '\\');  
    $watermark = imagecreatefrompng('ha\2.jpg'); //水印文件  
    $wsx = imagesx($watermark); //水印宽度  
    $wsy = imagesy($watermark); //水印高度  
    $filenames = scandir(ROOTDIR); //读取文件夹下的所有文件  
    $i = 0;  
    //遍历所有文件  
    echo '遍历文件图片<br>';  
    foreach($filenames as $name){  
        switch ($name) {  
            case '.': //文件夹本身不处理  
                break;  
            case '..': //上级文件夹不处理  
                break;  
            default: // 读取图片文件(png,jpg)  
                if('png'==strstr($name, 'png')){  
                    $image = imagecreatefrompng(ROOTDIR.SEPARATER.$name);  
                }else{  
                    $image = imagecreatefromjpeg(ROOTDIR.SEPARATER.$name);  
                }  
                  
                $isx = imagesx($image);  
                $isy = imagesy($image);  
                //图片缩小所需变量  
                $per = 1;  
                $n_x = $isx;  
                $n_y = $isy;  
                //图片宽度大于1140的按比例缩小到1140  
                if($isx>1140){  
                    $n_x = 1140;  
                    $per = $n_x/$isx; //计算缩放比例  
                    $n_y = (int)($isy*$per);//等比例缩小高度  
                    $n_image = imagecreatetruecolor($n_x, $n_y);  
                    imagecopyresized($n_image, $image, 0, 0, 0, 0, $n_x, $n_y, $isx, $isy);//缩小原来图片  
                    imagedestroy($image);//内存回收  
                    //将原来的图片数据进行修改  
                    $image = $n_image;  
                    $isx = $n_x;  
                    $isy = $n_y;  
                    echo 'resize image<br>';  
                }  
                $flag = imagecopy($image, $watermark, $isx-$wsx-20, $isy-$wsy-20, 0, 0, $wsx, $wsy);  
                if($flag){  
                    imagejpeg($image,DSDIR.SEPARATER.$name); //保存文件  
                    imagedestroy($image);//内存回收  
                }else{  
                    echo '失败';  
                }  
        }  
    }  
      
?>  