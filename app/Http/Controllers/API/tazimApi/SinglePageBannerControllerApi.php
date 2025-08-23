<?php

namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SinglePageBanner;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class SinglePageBannerControllerApi extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }

    public function banner1()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(1)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }

    public function banner2()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(2)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner3()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(3)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner4()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(4)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner5()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(5)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner6()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(6)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner7()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(7)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner8()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(8)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner9()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(9)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner10()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(10)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner11()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(11)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
    public function banner12()
    {
        $data = SinglePageBanner::select(
            'id',
            'title',
            'image'
        )->whereId(12)->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }
}
