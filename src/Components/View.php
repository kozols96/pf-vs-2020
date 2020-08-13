<?php


namespace Project\Components;


use Exception;

class View
{

    private string $viewName;
    private array $data;
    private string $layoutName = '';

    /**
     * View constructor.
     * @param string $layoutName
     * @param string $viewName
     * @param array $data
     */
    public function __construct(string $viewName, array $data, string $layoutName)
    {
        $this->viewName = $viewName;
        $this->data = $data;
        $this->layoutName = $layoutName;
    }


    public function render(): string
    {
        $filePath = $this->resolveFilePath();

        extract($this->data);

        ob_start();
        include $filePath;
        $content = ob_get_clean();

        return $content;
    }

    private function resolveFilePath(): string
    {
        $filePath = PROJECT_VIEW_DIR . '/' . $this->viewName . '.php';

        if (!$this->viewName || !file_exists($filePath)) {
            throw new Exception ("View '{$this->viewName}' not found");
        }

        return $filePath;
    }
}