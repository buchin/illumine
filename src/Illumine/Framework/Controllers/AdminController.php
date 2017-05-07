<?php namespace Illumine\Framework\Controllers;
class AdminController extends BaseController
{

    public $data, $attributes, $parameters;
    protected $this;

    /**
     * AdminController constructor.
     * @param $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct($attributes['plugin']['config']->get('namespace'));
        $this->attributes = $attributes;

    }

    /**
     * Flush Cache
     * @param $path
     * @return boolean
     */
    public function flushCache($path)
    {

        if ($path == 'sessions' && $this->config()->get('session.driver') == 'database') {

            $database = $this->database();
            $database->table($this->config()->get('session.table'))->truncate();
            return true;

        } elseif ($path == 'objects' && $this->config()->get('cache.default') == 'database') {

            $database = $this->database();
            $database->table($this->config()->get('cache.stores.database.table'))->truncate();
            return true;

        } elseif (isset($this->attributes['paths'][$path])) {

            if ($path == 'routes' && $this->files()->isFile($this->attributes['paths'][$path])) {

                return $this->files()->delete($this->attributes['paths'][$path]);

            } elseif ($this->files()->isDirectory($this->attributes['paths'][$path])) {

                return $this->files()->cleanDirectory($this->attributes['paths'][$path]);
            }
        }
        return false;
    }

    /**
     * Format File Sizes
     * @return string
     */
    public function calcDiskSize($path)
    {
        $bytes = 0;

        if ($this->files()->exists($path)) {

            if ($this->files()->isDirectory($path)) {

                foreach ($this->files()->allFiles($path) as $file) {
                    $bytes += $file->getSize();
                }
            } else {
                $bytes = $this->files()->size($path);
            }

        }
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        $size = round($bytes, 2);

        return ($size == 0 ? '-' : $size . ' ' . $units[$i]);
    }
}

