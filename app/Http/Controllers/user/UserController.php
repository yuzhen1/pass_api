<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function reg(){
        $data = file_get_contents('php://input');
        $after_str = base64_decode($data);
        $method = 'AES-256-CBC';
        $key = 'abcdefg';
        $options = OPENSSL_RAW_DATA;
        $iv = 'd89fb057f6d44r5z';
        $enc_str = openssl_decrypt($after_str,$method,$key,$options,$iv);
        $arr = json_decode($enc_str,true);
        //入库数据
        $data=[
            'user_name'=>$arr['uname'],
            'pwd'=>password_hash($arr['pwd'],1)
        ];
        $res = DB::table('login_user')->insert($data);
        if($res){
            $arr=[
                'code'=>1,
                'image'=>'注册成功'
            ];
        }else{
            $arr=[
                'code'=>2,
                'image'=>'注册失败'
            ];
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
}
