<?php

namespace Service;

use Exception;
use Medoo\Medoo;
use Service\Entity\EntityManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Utopia\Locale\Locale;
use Service\Controller\Controller;
use Service\Controller\Index;
use Service\Template\Core;
use Service\Util\Database;
use Service\Util\ReadOnlyArray;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class App
{

    protected static ?App $instance = null;
    private static ?Locale $locale = null;

    /**
     * @throws Exception
     */
    public static function getInstance(array $config = []): ?App
    {
        if (is_null(self::$instance))
        {
            foreach ($config['locales'] as $locale)
            {
                Locale::setLanguageFromJSON($locale, 'lang/' . $locale . '.json');
            }

            self::setLocale($config['locale']);
            self::$instance = new App($config);
        }

        return self::$instance;
    }

    public static function locale(): Locale
    {
        return self::$locale;
    }

    public static function phrase(string $name, array $placeholders = []): Phrase
    {
        return new Phrase($name, $placeholders);
    }

    /**
     * @throws Exception
     */
    public static function setLocale(string $name): void
    {
        self::$locale = new Locale($name);
    }

    private Database $database;
    private ReadOnlyArray $config;
    private Environment $environment;

    protected function __construct(array $config)
    {
        // Configure Database
        $this->database = new Database($config['database']);

        // Save Configuration Without Database Details
        unset($config['database']);
        $this->config = new ReadOnlyArray($config);

        $loader = new FilesystemLoader($this->config['template']['templateDir']);

        $envOptions = [];
        if ($this->config['template']['useCache'])
        {
            $envOptions['cache'] = $this->config['template']['cacheDir'];
        }
        $this->environment = new Environment($loader, $envOptions);
        $this->environment->addExtension(new Core());
    }

    public function config(): ReadOnlyArray
    {
        return $this->config;
    }

    public function controller(string $name): Controller
    {
        if (@class_exists('Service\\Controller\\' . $name))
        {
            return new ('Service\\Controller\\' . $name)($this);
        }
        else
        {
            return new Index($this);
        }
    }

    public function db(): Medoo
    {
        return $this->database;
    }

    public function response(string $templateName, array $variables = []): Response
    {
        return new Response($this, $templateName, $variables);
    }

    public function router(): Router
    {
        return new Router($this);
    }

    public function route(string $controller = 'index', string $action = 'index'): Route
    {
        return new Route($this, $controller, $action);
    }

    public function templateEnvironment(): Environment
    {
        return $this->environment;
    }

    public function em(): EntityManager
    {
        return new EntityManager($this);
    }

    public function buildLink(string $link, array $args)
    {
        $queryString = '';
        foreach ($args as $key => $value)
        {
            $queryString .= $key . (strlen($value) > 0 ? '=' . $value : '');
        }

        return rtrim($this->config['baseUrl'], '/') .
            DIRECTORY_SEPARATOR .
            ($this->config['prettyUrl'] ?
                $link . ($queryString ? '?' . $queryString : '') :
                'index.php?' . $link . ($queryString ? '&' . $queryString : '')
            );
    }

}