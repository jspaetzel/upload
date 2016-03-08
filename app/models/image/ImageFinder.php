<?php
class ImageFinder
{
    /** @type DB $db */
    private $db;
    /** @type ImageFactory $imageFactory */
    private $imageFactory;
    /**
     * @param DB $db
     * @param ImageFactory $imageFactory
     */
    public function __construct(DB $db, ImageFactory $imageFactory)
    {
        $this->db = $db;
        $this->imageFactory = $imageFactory;
    }
    /**
     * Get single Image by field value
     *
     * @param string $key  Name of table field
     *
     * @return Image|null
     * @throws Exception  Only if field = id and no record found
     */
    public function findImage($key)
    {
        $id = NameGenerator::alphaID($key, true);
        $query = "SELECT * FROM images WHERE id = '$id'";

        $imageRow = $this->db->select_single($query);
        if (empty($imageRow)) {
            throw new Exception('Image not found');
        }
        $imageObject = null;
        if (!empty($imageRow)) {
            $imageObject = $this->load($imageRow);
        }
        return $imageObject;
    }

    /**
     * Hydrate Image object with data from DB
     *
     * @param array $imageRow
     *
     * @return Image
     */
    private function load($imageRow)
    {
        $imageObject = $this->imageFactory->getInstance();
        $imageObject->setId($imageRow['id']);
        $imageObject->setName($imageRow['name']);
        $imageObject->setCreated($imageRow['created']);
        return $imageObject;
    }
}