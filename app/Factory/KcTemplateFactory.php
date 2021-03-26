<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace App\Factory;

use Latte;
use Nette;
use Nette\Application\UI;
use Nette\Bridges\ApplicationLatte\LatteFactory;


/**
 * Latte powered template factory.
 */
class KcTemplateFactory extends Nette\Bridges\ApplicationLatte\TemplateFactory
{

    /** @return Template */
    public function createTemplate(UI\Control $control = null, string $class = null): UI\Template
    {
        $class = $class ?? $this->templateClass;
        if (!is_a($class, Template::class, true)) {
            throw new Nette\InvalidArgumentException("Class $class does not implement " . Template::class . ' or it does not exist.');
        }

        $latte = $this->latteFactory->create();
        $template = new $class($latte);
        $presenter = $control ? $control->getPresenterIfExists() : null;

        if ($latte->onCompile instanceof \Traversable) {
            $latte->onCompile = iterator_to_array($latte->onCompile);
        }

        array_unshift($latte->onCompile, function (Latte\Engine $latte) use ($control, $template): void {
            if ($this->cacheStorage) {
                $latte->getCompiler()->addMacro('cache', new Nette\Bridges\CacheLatte\CacheMacro);
            }
            UIMacros::install($latte->getCompiler());
            if (class_exists(Nette\Bridges\FormsLatte\FormMacros::class)) {
                Nette\Bridges\FormsLatte\FormMacros::install($latte->getCompiler());
            }
            if ($control) {
                $control->templatePrepareFilters($template);
            }
        });

        $latte->addFilter('modifyDate', function ($time, $delta, $unit = null) {
            return $time
                ? Nette\Utils\DateTime::from($time)->modify($delta . $unit)
                : null;
        });

        if (!isset($latte->getFilters()['translate'])) {
            $latte->addFilter('translate', function (Latte\Runtime\FilterInfo $fi): void {
                throw new Nette\InvalidStateException('Translator has not been set. Set translator using $template->setTranslator().');
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
        $flashes = $presenter instanceof UI\Presenter && $presenter->hasFlashSession()
            ? (array) $presenter->getFlashSession()->{$control->getParameterId('flash')}
            : [];

        $params = [
            'user' => $this->user,
            'baseUrl' => $baseUrl,
            'basePath' => $baseUrl ? preg_replace('#https?://[^/]+#A', '', $baseUrl) : null,
            'flashes' => $flashes,
            'control' => $control,
            'presenter' => $presenter,
            'templateDir' => 'z',
        ];

     //   list(, $presenter) = Helpers::splitName($this->getName());
        $dir = dirname($presenter->getReflection()->getFileName());
        bdump($dir);
        //$dir = is_dir("$dir/templates") ? $dir : dirname($dir);
       // return [
         //   "$dir/templates/$presenter/$this->view.latte",
           // "$dir/templates/$presenter.$this->view.latte",
       // ];

        foreach ($params as $key => $value) {
            if ($value !== null && property_exists($template, $key)) {
                $template->$key = $value;
            }
        }

        if ($control) {
            $latte->addProvider('uiControl', $control);
            $latte->addProvider('uiPresenter', $presenter);
            $latte->addProvider('snippetBridge', new Nette\Bridges\ApplicationLatte\SnippetBridge($control));
            if ($presenter) {
                $header = $presenter->getHttpResponse()->getHeader('Content-Security-Policy')
                    ?: $presenter->getHttpResponse()->getHeader('Content-Security-Policy-Report-Only');
            }
            $nonce = $presenter && preg_match('#\s\'nonce-([\w+/]+=*)\'#', (string) $header, $m) ? $m[1] : null;
            $latte->addProvider('uiNonce', $nonce);
        }
        $latte->addProvider('cacheStorage', $this->cacheStorage);

        Nette\Utils\Arrays::invoke($this->onCreate, $template);

        return $template;
    }
}
