<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\Helpers;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Nette\Http;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Tracy\ILogger;

/**
 * Class ErrorPresenter
 *
 * @package App\Presenters
 */
final class ErrorPresenter implements IPresenter
{
	use Nette\SmartObject;

    /**
     * @var ILogger $logger
     */
	private ILogger $logger;

    /**
     * ErrorPresenter constructor.
     *
     * @param ILogger $logger
     */
	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function run(Request $request): Response
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof BadRequestException) {
			[$module, , $sep] = Helpers::splitName($request->getPresenterName());
			return new ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);

		return new CallbackResponse(function (IRequest $httpRequest, IResponse $httpResponse): void {
			if (preg_match('#^text/html(?:;|$)#', (string) $httpResponse->getHeader('Content-Type'))) {
				require __DIR__ . '/templates/Error/500.phtml';
			}
		});
	}
}
