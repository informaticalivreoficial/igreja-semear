<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configuracoes as ConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Support\Cropper;
use App\Models\Template;
use Carbon\Carbon;

class ConfigController extends Controller
{
    public function editar()
    {
        $config = Config::where('id', '1')->first();        

        $templates = Template::orderBy('created_at', 'DESC')
                ->available()
                ->get();

        $sitemap = Carbon::createFromFormat('Y-m-d', $config->sitemap_data);
        $datahoje = Carbon::now();
        $diferenca = $datahoje->diffInDays($sitemap); // saída: X dias

        $feeddata = Carbon::createFromFormat('Y-m-d', $config->rss_data);
        $feeddatahoje = Carbon::now();
        $feeddatadiferenca = $feeddatahoje->diffInDays($feeddata); // saída: X dias

        return view('admin.configuracoes',[
            'config' => $config,            
            'diferenca' => $diferenca,
            'templates' => $templates,
            'feeddatadiferenca' => $feeddatadiferenca
        ]);
    }    

    public function update(ConfigRequest $request, $id)
    {
        $config = Config::where('id', $id)->first(); 

        if(!empty($request->file('metaimg'))){
            !is_null($config->metaimg) && Storage::delete($config->metaimg);
            $config->metaimg = null;
        }
        
        if(!empty($request->file('logo'))){
            !is_null($config->logo) && Storage::delete($config->logo);
            $config->logo = null;
        }
        
        if(!empty($request->file('logo_admin'))){
            !is_null($config->logo_admin) && Storage::delete($config->logo_admin);
            $config->logo_admin = null;
        }
        
        if(!empty($request->file('favicon'))){
            !is_null($config->favicon) && Storage::delete($config->favicon);
            $config->favicon = null;
        }
        
        if(!empty($request->file('watermark'))){
            !is_null($config->watermark) && Storage::delete($config->watermark);
            $config->watermark = null;
        }
        
        if(!empty($request->file('imgheader'))){
            !is_null($config->imgheader) && Storage::delete($config->imgheader);
            $config->imgheader = null;
        }
        
        $config->fill($request->all());
        
        if(!empty($request->file('metaimg'))){
            $config->metaimg = $request->file('metaimg')->storeAs(env('AWS_PASTA') . 'config', 'metaimg-'.Str::slug($request->app_name)  . '.' . $request->file('metaimg')->extension());
        }
        
        if(!empty($request->file('logo'))){
            $config->logo = $request->file('logo')->storeAs(env('AWS_PASTA') . 'config', 'logo-'.Str::slug($request->app_name)  . '.' . $request->file('logo')->extension());
        }
        
        if(!empty($request->file('logo_admin'))){
            $config->logo_admin = $request->file('logo_admin')->storeAs(env('AWS_PASTA') . 'config', 'logo-admin-'.Str::slug($request->app_name)  . '.' . $request->file('logo_admin')->extension());
        }
        
        if(!empty($request->file('favicon'))){
            $config->favicon = $request->file('favicon')->storeAs(env('AWS_PASTA') . 'config', 'favivon-'.Str::slug($request->app_name)  . '.' . $request->file('favicon')->extension());
        }
        
        if(!empty($request->file('watermark'))){
            $config->watermark = $request->file('watermark')->storeAs(env('AWS_PASTA') . 'config', 'watermark-'.Str::slug($request->app_name)  . '.' . $request->file('watermark')->extension());
        }
        
        if(!empty($request->file('imgheader'))){
            $config->imgheader = $request->file('imgheader')->storeAs(env('AWS_PASTA') . 'config', 'imgheader-'.Str::slug($request->app_name)  . '.' . $request->file('imgheader')->extension());
        }
        
        if(!$config->save()){
            return redirect()->back()->withInput()->withErrors('Erro');
        }

        return redirect()->route('configuracoes.editar', $config->id)->with([
            'color' => 'success', 
            'message' => 'Configurações atualizadas com sucesso!'
        ]);
    }
}
