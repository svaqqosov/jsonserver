<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->makeMacro('success', 'OK');
        $this->makeMacro('error', 'ERROR');
        $this->makeMacro('warning', 'WARN');
        $this->makeMacro('authErr', 'AUTH_ERROR');
        $this->makeMacro('authExpired', 'AUTH_EXPIRED');
    }

    public function makeMacro($name, $status)
    {
        $header = array(
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );
        Response::macro($name, function ($res) use ($header, $status) {
            $data['status'] = $status;
            if (isset($res['data'])) $data['data'] = $res['data'];
            if (isset($res['msg_code'])) $data['msg_code'] = $res['msg_code'];
            if (isset($res['errors'])) $data['errors'] = $res['errors'];
            return Response::json($data, (isset($res['code'])) ? $res['code'] : 200, $header, JSON_UNESCAPED_UNICODE
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
