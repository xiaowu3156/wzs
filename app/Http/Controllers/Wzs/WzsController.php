<?php
/**
 * Created by PhpStorm.
 * User: sunwoo
 * Date: 2018/1/2
 * Time: 上午9:26
 */

namespace App\Http\Controllers\Wzs;


use App\Events\Wzs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WzsController extends Controller{

    public function index() {
        echo 'hello php.....';

        $id = 101;

        event(new Wzs(['id' => $id]));


        $list = DB::table('user')->get();

        dd($list);


        echo 'hello laravel...';


    }
}
