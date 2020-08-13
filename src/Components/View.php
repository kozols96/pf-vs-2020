<?php


namespace Project\Components;

use Exception;

class View
{

    private string $viewName;
    private array $data;
    private string $layoutName;

    public const LAYOUT_DEFAULT = 'default';

    /**
     * @var string  Included view content
     */
    protected string $content = '';

    protected string $title = 'Default title';

    /**
     * View constructor.
     * @param string $layoutName
     * @param string $viewName
     * @param array $data
     */
    public function __construct(string $viewName, array $data, string $layoutName = self::LAYOUT_DEFAULT)
    {
        $this->viewName = $viewName;
        $this->data = $data;
        $this->layoutName = $layoutName;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function render(): string
    {

        $this->content = $this->renderViewContent();

        $layoutViewPath = $this->resolveLayoutFilePath();

        ob_start();

        include $layoutViewPath;

        return ob_get_clean();
    }

    /**
     * @return string
     * @throws Exception
     */
    private function renderViewContent(): string
    {
        $viewFilePath = $this->resolveViewFilePath();

        extract($this->data);

        ob_start();

        include $viewFilePath;

        return ob_get_clean();
    }

    /**
     * @return string
     * @throws Exception
     */
    private function resolveLayoutFilePath(): string
    {
        return $this->resolveFilePath(PROJECT_LAYOUT_DIR,$this->layoutName);
    }

    /**
     * @return string
     * @throws Exception
     */
    private function resolveViewFilePath(): string
    {
        return $this->resolveFilePath(PROJECT_VIEW_DIR, $this->viewName);
    }

    /**
     * @param string $fileDirectory
     * @param string $fileName
     * @return string
     * @throws Exception
     */
    private function resolveFilePath(string $fileDirectory, string $fileName): string
    {
        $filePath = "$fileDirectory/$fileName.php";

        if (!$fileName || !file_exists($filePath)) {
            throw new Exception ("View '{$fileName}' not found");
        }

        return $filePath;
    }
}