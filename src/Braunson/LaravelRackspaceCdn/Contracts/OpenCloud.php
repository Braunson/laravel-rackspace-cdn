<?php

/**
 * @author Artem Molotov https://github.com/ArtemMolotov
 * @datetime 11.10.2017 16:09
 */

namespace Braunson\LaravelRackspaceCdn\Contracts;

interface OpenCloud
{
    /**
     * Get the object store variable
     */
    public function getObjectStore();

    /**
     * Get/set our container
     */
    public function getContainer($name);

    /**
     * Return objects from the cloud in a specified container
     */
    public function getFile($container, $filename);

    /**
     * Upload files to a set container
     */
    public function upload($container, $file, $name = null);

    /**
     * Create and archive and upload a whole directory
     *
     * $dir - Directory to upload
     * $cdnDir - Directory on the CDN to upload to
     * $dirTrim - Path segments to trim from the dir path when on the CDN
     */
    public function uploadDir($container, $dir, $cdnDir = '', $dirTrim = '');

    public function exists($container, $file);

    public function createDataObject($container, $filePath, $fileName = null, $extract = null);

    public function deleteTEMP($container, $file);

}
