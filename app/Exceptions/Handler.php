<?php

namespace App\Exceptions;

use App;
use App\Services\LanguageServices\AlternativeUrlService;
use SEO;
use SEOMeta;
use App\Model\Project;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
		$locale = App::getLocale();

		$projects = Project::where([
			['lang',$locale],
			['isHide',0],
			['status_id','<>',3],
			['status_id','<>',10],
			['type','<>','only-blogger'],
		])->orderBy('start_registration_time','desc')->limit(3)->get();


        $routes = AlternativeUrlService::generateReplyRoutes('');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		if ($this->isHttpException($exception)) {
			if ($exception->getStatusCode() == 401) {
				SEO::setTitle('Unauthorized');
				return response()->view('errors.' . '401', ['projects' => $projects,
					'alternativeUrls'	=> $alternativeUrls], 401);
			}
			if ($exception->getStatusCode() == 403) {
				SEO::setTitle('Forbidden');
				return response()->view('errors.' . '403', ['projects' => $projects,
					'alternativeUrls'	=> $alternativeUrls], 403);
			}
			if ($exception->getStatusCode() == 404) {
				SEO::setTitle('Page not found');
				return response()->view('errors.' . '404', ['projects' => $projects,
					'alternativeUrls'	=> $alternativeUrls], 404);
			}
			if ($exception->getStatusCode() == 419) {
				SEO::setTitle('Page Expired');
				return response()->view('errors.' . '419', ['projects' => $projects,
					'alternativeUrls'	=> $alternativeUrls], 419);
			}
			if ($exception->getStatusCode() == 429) {
				SEO::setTitle('Too Many Requests');
				return response()->view('errors.' . '429', ['projects' => $projects,
					'alternativeUrls'	=> $alternativeUrls], 429);
			}

			if ($exception->getStatusCode() == 500) {
				SEO::setTitle('Error');
				return response()->view('errors.' . '500', ['alternativeUrls'	=> $alternativeUrls], 500);
			}
			if ($exception->getStatusCode() == 503) {
				SEO::setTitle('Service Unavailable');
				return response()->view('errors.' . '503', ['alternativeUrls'	=> $alternativeUrls], 503);
			}
		}


        return parent::render($request, $exception);
    }
}
