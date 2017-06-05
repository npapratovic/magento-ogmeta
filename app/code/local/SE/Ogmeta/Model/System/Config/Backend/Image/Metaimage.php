<?php 

/**
 * System config image field backend model for Zend PDF generator
 */
class SE_Ogmeta_Model_System_Config_Backend_Image_Metaimage extends Mage_Adminhtml_Model_System_Config_Backend_Image
{
    /**
     * The tail part of directory path for uploading
     */
    const UPLOAD_DIR = 'ogmeta';

    /**
     * Token for the root part of directory path for uploading
     */
    const UPLOAD_ROOT = 'media';

    /**
     * Return path to directory for upload file
     * @return string
     * @throw Mage_Core_Exception
     */
    protected function _getUploadDir()
    {
        $uploadDir  = $this->_appendScopeInfo(self::UPLOAD_DIR);
        $uploadRoot = $this->_getUploadRoot(self::UPLOAD_ROOT);
        $uploadDir  = $uploadRoot . '/' . $uploadDir;
        return $uploadDir;
    }

    /**
     * Makes a decision about whether to add info about the scope.
     * @return boolean
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }

    /**
     * Getter for allowed extensions of uploaded files.
     * @return array
     */
    protected function _getAllowedExtensions()
    {
        return ['png', 'gif', 'jpg', 'jpeg', 'apng', 'svg'];
    }

    /**
     * Get real media dir path
     * @param  $token
     * @return string
     */
    protected function _getUploadRoot($token)
    {
        return Mage::getBaseDir($token);
    }
}