<?php

namespace App\Controller;

use Fly\Core\Controller;
use App\Model\Test;

class TestController extends Controller
{
    public function test($id)
    {
        list($id_1, $id_2, $id_3) = explode(',', $id);
        try {
//            $result_2 = yield Test::select(['id', 'fuck' => 'name', 'uri'])->where('id', $id_1)->first();
//            $result_1 = yield Test::select(['id', 'name', 'uri'])->where('id', $id_2, '!=')->first();
//            $result_3 = yield Test::select(['*'])->where('id', $id_3)->first();

            $multi = $this->multi();
            $multi->add('id_1', Test::select(['id', 'name', 'uri'])->where('id', 1)->first());
            $multi->add('id_2', Test::select(['id', 'name', 'uri'])->where('id', 2)->first());
            $multi->add('id_3', Test::select(['id', 'name', 'uri'])->where('id', 3)->first());
            $result_1 = yield $multi;

            $multi = $this->multi();
            $multi->add('id_4', Test::select(['id', 'name', 'uri'])->where('id', 4)->first());
            $multi->add('id_5', Test::select(['id', 'name', 'uri'])->where('id', 5)->first());
            $multi->add('id_6', Test::select(['id', 'name', 'uri'])->where('id', 6)->first());
            $result_2 = yield $multi;
        }
        catch (\Exception $e) {
            print_r($e->getMessage());
        }

        $this->send($result_1, $result_2);
    }
}
