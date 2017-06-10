<?php
/**
 * FileController.class.php
 *
 * @Description: 报表文件管理控制器
 * @Author     : liebert
 * @Date       : 2017/03/01
 */

namespace Report\Controller;
use Think\Controller;
class FileController extends Controller {
    /**
     * 读取报表涉及文件
     */
    public function getReportFile(){
        /*
        $filename = dirname($_SERVER['SCRIPT_FILENAME']).'/plugins/gridreport/grf/'.$_GET['url'];

        if ( !$handle = fopen($filename, 'r') ) {
            print "不能打开文件 $filename，可能是文件不存在或WEB服务用户不具有相关权限";
            exit;
        }

        $contents = fread($handle, filesize($filename));
        fclose($handle);

        $str = file_get_contents($filename);
        echo $str;
        */

        $id = $_GET['id'];
        $data = M('report_tables')->where('id='.$id)->find();
        $grf = $data['grf'];
        echo $grf;
    }

    /**
     * saveReportDesignFile
     * 保存报表设计文件
     */
    public function saveReportFile(){
        /*$filename = dirname($_SERVER['SCRIPT_FILENAME']).$_GET['url'];
        $content = file_get_contents("php://input");

        if ( !$handle = fopen($filename, 'w') ) {
            print "不能打开文件 $filename，可能是WEB服务用户不具有目录的写入权限";
            exit;
        }

        // 将$content写入到我们打开的文件中。
        if ( !fwrite($handle, $content) ) {
           print "不能写入到文件 $filename";
           exit;
        }

        fclose($handle);
        */
        $id = $_GET['id'];
        $content = file_get_contents("php://input");

        M('report_tables')->where('id='.$id)->data(array(
            'grf' => $content
        ))->save();
    }
}