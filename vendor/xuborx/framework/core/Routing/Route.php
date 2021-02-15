<?php
declare(strict_types=1);

/**
 * Class of route
 */
namespace Xuborx\Framework\Routing;

class Route
{

    /**
     * @var string
     */
    private string $type = 'GET';

    /**
     * @var string
     */
    private string $prefix = '';

    /**
     * @var string
     */
    private string $query = '';

    /**
     * @var string
     */
    private string $controller = '';

    /**
     * @var string
     */
    private string $action = '';

    /**
     * @var string
     */
    private string $inscpector = '';

    public function __construct(
        string $type = 'GET',
        string $prefix = '',
        string $query = '',
        string $controller = '',
        string $action = '',
        string $inspector = ''
    ) {
        $this->type = $type;
        $this->prefix = $prefix;
        $this->query = $query;
        $this->controller = $controller;
        $this->action = $action;
        $this->inscpector = $inspector;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getInscpector(): string
    {
        return $this->inscpector;
    }


}