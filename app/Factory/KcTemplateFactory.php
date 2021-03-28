<?php
/**
 *
 * Created by PhpStorm.
 * Filename: KcTemplateFactory.php
 * User: Tomáš Babický
 * Date: 27.03.2021
 * Time: 3:13
 */

namespace App\Factory;

use Latte\Engine;
use Latte\Runtime\FilterInfo;
use Nette\Application\UI;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;
use Nette\Bridges\ApplicationLatte\LatteFactory;
use Nette\Bridges\ApplicationLatte\SnippetBridge;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Bridges\ApplicationLatte\UIMacros;
use Nette\Bridges\CacheLatte\CacheMacro;
use Nette\Bridges\FormsLatte\FormMacros;
use Nette\Caching\Storage;
use Nette\Http\IRequest;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Security\User;
use Nette\SmartObject;
use Nette\Utils\Arrays;
use Nette\Utils\DateTime;
use Traversable;

class KcTemplateFactory implements UI\TemplateFactory
{
    use SmartObject;

    /** @var array<callable(Template): void>  Occurs when a new template is created */
    public $onCreate = [];

    /** @var LatteFactory */
    private $latteFactory;

    /** @var IRequest|null */
    private $httpRequest;

    /** @var User|null */
    private $user;

    /** @var Storage|null */
    private $cacheStorage;

    /** @var string */
    private $templateClass;

    public function __construct(
        LatteFactory $latteFactory,
        IRequest $httpRequest = null,
        User $user = null,
        Storage $cacheStorage = null,
        $templateClass = null
    ) {
        $this->latteFactory = $latteFactory;
        $this->httpRequest = $httpRequest;
        $this->user = $user;
        $this->cacheStorage = $cacheStorage;
        if ($templateClass && (!class_exists($templateClass) || !is_a($templateClass, Template::class, true))) {
            throw new  InvalidArgumentException("Class $templateClass does not implement " . Template::class . ' or it does not exist.');
        }
        $this->templateClass = $templateClass ?: DefaultTemplate::class;
    }

    /** @return Template */
    public function createTemplate(UI\Control $control = null, string $class = null): UI\Template
    {
        $class = $class ?? $this->templateClass;
        if (!is_a($class, Template::class, true)) {
            throw new InvalidArgumentException("Class $class does not implement " . Template::class . ' or it does not exist.');
        }

        $latte = $this->latteFactory->create();
        $template = new $class($latte);

        $presenter = $control ? $control->getPresenterIfExists() : null;

        // KC IMPROVEMENT BEGIN
        $dirName = dirname($presenter->getReflection()->getFileName());
        $layoutFile = str_replace('Presenters', 'templates', $dirName) . '\@layout.latte';

        $template->add('layoutFile', $layoutFile);
        // KC IMPROVEMENT END

        if ($latte->onCompile instanceof Traversable) {
            $latte->onCompile = iterator_to_array($latte->onCompile);
        }

        array_unshift($latte->onCompile, function (Engine $latte) use ($control, $template): void {
            if ($this->cacheStorage) {
                $latte->getCompiler()->addMacro('cache', new CacheMacro);
            }
            UIMacros::install($latte->getCompiler());
            if (class_exists(FormMacros::class)) {
                FormMacros::install($latte->getCompiler());
            }
            if ($control) {
                $control->templatePrepareFilters($template);
            }
        });

        $latte->addFilter('modifyDate', function ($time, $delta, $unit = null) {
            return $time
                ? DateTime::from($time)->modify($delta . $unit)
                : null;
        });

        if (!isset($latte->getFilters()['translate'])) {
            $latte->addFilter('translate', function (FilterInfo $fi): void {
                throw new InvalidStateException('Translator has not been set. Set translator using $template->setTranslator().');
            });
        }

        if ($presenter) {
            $latte->addFunction('isLinkCurrent', [$presenter, 'isLinkCurrent']);
            $latte->addFunction('isModuleCurrent', [$presenter, 'isModuleCurrent']);
        }

        // default parameters
        $baseUrl = $this->httpRequest
            ? rtrim($this->httpRequest->getUrl()->withoutUserInfo()->getBaseUrl(), '/')
            : null;
        $flashes = $presenter instanceof Presenter && $presenter->hasFlashSession()
            ? (array) $presenter->getFlashSession()->{$control->getParameterId('flash')}
            : [];

        $params = [
            'user' => $this->user,
            'baseUrl' => $baseUrl,
            'basePath' => $baseUrl ? preg_replace('#https?://[^/]+#A', '', $baseUrl) : null,
            'flashes' => $flashes,
            'control' => $control,
            'presenter' => $presenter,
        ];

        foreach ($params as $key => $value) {
            if ($value !== null && property_exists($template, $key)) {
                $template->$key = $value;
            }
        }

        if ($control) {
            $latte->addProvider('uiControl', $control);
            $latte->addProvider('uiPresenter', $presenter);
            $latte->addProvider('snippetBridge', new SnippetBridge($control));
            if ($presenter) {
                $header = $presenter->getHttpResponse()->getHeader('Content-Security-Policy')
                    ?: $presenter->getHttpResponse()->getHeader('Content-Security-Policy-Report-Only');
            }
            $nonce = $presenter && preg_match('#\s\'nonce-([\w+/]+=*)\'#', (string) $header, $m) ? $m[1] : null;
            $latte->addProvider('uiNonce', $nonce);
        }
        $latte->addProvider('cacheStorage', $this->cacheStorage);

        Arrays::invoke($this->onCreate, $template);

        return $template;
    }
}