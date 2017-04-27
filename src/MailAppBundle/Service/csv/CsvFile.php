<?php

namespace MailAppBundle\Service\csv;

class CsvFile
{
    private $header = [];
    private $rows = [];

    /**
     * @param bool $withHeader
     * @return array
     * @throws InvalidCsvDataException
     */
    public function getContent($withHeader = true)
    {
        if (!$this->isValid()) {
            throw new InvalidCsvDataException();
        }

        if (!$withHeader) {
            return $this->rows;
        }

        return array_merge([$this->header], $this->rows);
    }

    /**
     * @param array $header
     */
    public function setHeader(array $header = [])
    {
        $this->header = $header;
    }

    /**
     * Add all rows at once
     * @param array $data
     */
    public function setData(array $data = [])
    {
        $this->rows = $data;
    }

    /**
     * Add single row
     * @param array $row
     */
    public function addRow(array $row = [])
    {
        $this->rows[] = $row;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if (empty($this->rows)) {
            return true;
        }

        if (empty($this->header)) {
            $columns = count($this->rows[0]);
        } else {
            $columns = count($this->header);

            if ($columns != count($this->rows[0])) {
                return false;
            }
        }

        foreach ($this->rows as &$row) {
            if (!is_array($row)) {
                return false;
            }

            if (count($row) != $columns) {
                return false;
            }
        }

        return true;
    }
}
