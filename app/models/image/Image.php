<?php
class Image extends ActiveRecord
{
    /** @type string $name */
    private $name;
    /** @type string $created */
    private $created;
    /** @type array $mimeTypes  Allowed extensions & related mime types */
    public static $mimeTypes = [
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    ];
    /**
     * Get an array of allowed filename extensions
     *
     * @param bool $string  If true, return a string of filename extensions joined with '|'
     *
     * @return array|string
     */
    public static function getAllowedExtensions($string = false)
    {
        $allowedExtensions = array_keys(self::$mimeTypes);
        if ($string == true) {
            $allowedExtensions = implode('|', $allowedExtensions);
        }
        return $allowedExtensions;
    }
    /**
     * Show Image
     */
    public function show() {
        $imgPath = '/../files/';
        $fullPath = __DIR__ . $imgPath . $this->getName();
        if (file_exists($fullPath)) {
            $fileExtension = pathinfo($this->getName(), PATHINFO_EXTENSION);
            if (isset(self::$mimeTypes[$fileExtension])) {
                $mimeType = self::$mimeTypes[$fileExtension];
            }
            else {
                $mimeType = 'application/octet-stream';
            }
            header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 3600));
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($fullPath)) . ' GMT', true, 200);
            header('Content-type:' . $mimeType);
            readfile($fullPath);
            exit();
        }
    }

    /**
     * @return bool|int|string
     */
    public function insert()
    {
        $query = 'INSERT INTO images (created) VALUES (NOW())';
        return $this->db->insert($query);
    }

    public function update()
    {
        return;
    }

    public function delete()
    {
        return;
    }

    /**
     * @param string $name  Name corresponding to image file with extension
     *
     * @throws Exception  If extension is not allowed - see $mimeTypes
     */
    public function setName($name)
    {
        $this->checkIfEmpty($name);
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($extension, self::getAllowedExtensions())) {
            throw new Exception('Wrong name of a file');
        }
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }
    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }
}