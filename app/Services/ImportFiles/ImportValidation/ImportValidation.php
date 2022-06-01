<?php


namespace App\Services\ImportFiles\ImportValidation;

use App\Services\ImportFiles\ImportFactory;
use App\Services\ImportFiles\ImportTemplate\Template;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ImportValidation
{

    private $_type; // see constant in ImportConstants
    private $_file;

    /**
     * ImportValidation constructor.
     * @param $type
     * @param $file
     */
    public function __construct($type, $file)
    {
        $this->_type = $type;
        $this->_file = $file;
    }

    /**
     * @return mixed
     * get file headers
     */

    public function getFileContent()
    {
        $array = Excel::toArray(new ImportFactory($this->_type), $this->_file);

        if (isset($array[0])) {
            return $array[0];
        } else {
            return [];
        }
    }

    public function getFileHeader()
    {
        $headings = (new HeadingRowImport)->toArray($this->_file);
        // $array = Excel::toArray(new ImportFactory($this->_type), $this->_file);
        if (isset($headings[0][0])) {
            return $headings[0][0];
        } else {
            return [];
        }
    }

    /**
     * @return bool
     * check if file has valid headers
     * @throws Exception
     */
    public function isValidFileTemplate(): bool
    {

        if (empty($this->getMissingFields())) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     * @throws Exception
     * return missing fields
     */
    public function getMissingFields(): array
    {
        $array = $this->getFileHeader();
        $fileTemplate = (new Template($this->_type))->getTemplate()->mandatoryColumns();
        return array_values(array_diff($fileTemplate, $this->getFileHeader()));
    }

    public function getFileFirstRow(): array
    {
        $array = Excel::toArray(new ImportFactory($this->_type), $this->_file);
        return $array[0][1];
    }

    /**
     * @return bool
     * check if file is empty
     */
    public function isEmptyFile(): bool
    {

        if (empty($this->getFileHeader())) {
            return true;
        }
        return false;
    }
}
