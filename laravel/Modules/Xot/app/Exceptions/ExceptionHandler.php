<?php

/**
 * @see https://dev.to/jackmiras/laravels-exceptions-part-2-custom-exceptions-1367
 */

declare(strict_types=1);

namespace Modules\Xot\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Modules\Xot\Actions\View\GetViewPathAction;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionHandler 
{
    public static function handles(Exceptions $exceptions)
    {
        
        $exceptions->render(function (HttpException $e,Request $request) {
            $status_code=$e->getStatusCode();
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $status_code);
            }
            

            $view='pub_theme::errors.'.$status_code;
            if(!view()->exists($view)){
                throw new \Exception('view not found: ['.$view.'] view path:'.app(GetViewPathAction::class)->execute($view));    
                
            }
            $view_params=['exception'=>$e];
            return response()->view($view, $view_params, $status_code);
        });
    }
}
