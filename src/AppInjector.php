<?php
namespace Polidog\Todo;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\AppMeta\AppMeta;
use BEAR\AppMeta\Exception\NotWritableException;
use BEAR\Package\AppMetaModule;
use BEAR\Package\Exception\InvalidContextException;
use Ray\Compiler\DiCompiler;
use Ray\Compiler\Exception\NotCompiled;
use Ray\Compiler\ScriptInjector;
use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;
use Ray\Di\Name;

final class AppInjector implements InjectorInterface
{
    /**
     * @var InjectorInterface
     */
    private $injector;

    public function __construct($name, $contexts)
    {
        $this->injector = $this->getInjector(new AppMeta($name, $contexts), $contexts);
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance($interface, $name = Name::ANY)
    {
        return $this->injector->getInstance($interface, $name);
    }

    /**
     * @param AbstractAppMeta $appMeta
     * @param string          $contexts
     *
     * @return InjectorInterface
     */
    private function getInjector(AbstractAppMeta $appMeta, $contexts)
    {
        $module = $this->newModule($appMeta, $contexts);
        $module->override(new AppMetaModule($appMeta));
        $tmpDir = $appMeta->appDir . '/tests/tmp/' . $contexts;
        if (! @mkdir($tmpDir) && ! is_dir($tmpDir)) {
            throw new NotWritableException($tmpDir);
        }
        try {
            $injector = (new ScriptInjector($tmpDir))->getInstance(InjectorInterface::class);
        } catch (NotCompiled $e) {
            $compiler = new DiCompiler($module, $tmpDir);
            $compiler->compile();
            $injector = (new ScriptInjector($tmpDir))->getInstance(InjectorInterface::class);
            register_shutdown_function(function () use ($tmpDir) {
                foreach (new \RecursiveDirectoryIterator($tmpDir, \FilesystemIterator::SKIP_DOTS) as $file) {
                    unlink($file);
                }
                rmdir($tmpDir);
            });
        }

        return $injector;
    }

    /**
     * Return configured module
     *
     * @param AbstractAppMeta $appMeta
     * @param string          $contexts
     *
     * @return AbstractModule
     */
    private function newModule(AbstractAppMeta $appMeta, $contexts)
    {
        $contextsArray = array_reverse(explode('-', $contexts));
        $module = null;
        foreach ($contextsArray as $context) {
            $class = $appMeta->name . '\Module\\' . ucwords($context) . 'Module';
            if (!class_exists($class)) {
                $class = 'BEAR\Package\Context\\' . ucwords($context) . 'Module';
            }
            if (! is_a($class, AbstractModule::class, true)) {
                throw new InvalidContextException($class);
            }
            /* @var $module AbstractModule */
            $module = new $class($module);
        }

        return $module;
    }
}
