<?php

namespace ApiBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CsvResponse extends Response
{
    protected $data;
    protected $filename  = 'export.csv';
    protected $delimiter = ',';
    protected $enclosure = '"';
    protected $escape    = '\\';

    /**
     * @inheritdoc
     * @param array $options Supported options: delimiter = ',', enclosure = '"', escape = '\'
     */
    public function __construct(array $data = [], $status = 200, $headers = [], array $options = [])
    {
        parent::__construct('', $status, $headers);

        if (!empty($options['delimiter'])) {
            $this->delimiter = $options['delimiter'];
        }

        if (!empty($options['enclosure'])) {
            $this->enclosure = $options['enclosure'];
        }

        if (!empty($options['escape'])) {
            $this->escape = $options['escape'];
        }

        $this->setData($data);
    }

    /**
     * Sets the data to be sent as CSV.
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data = [])
    {
        $output = fopen('php://temp', 'r+');

        foreach ($data as $row) {
            fputcsv($output, $row, $this->delimiter, $this->enclosure, $this->escape);
        }

        rewind($output);
        $this->data = stream_get_contents($output);
        fclose($output);

        return $this->update();
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this->update();
    }

    /**
     * @return $this
     */
    protected function update()
    {
        $this->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $this->filename));
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', 'text/csv');

            // cookie required by jquery.filedownload.js extension
            $this->headers->setCookie(new Cookie('fileDownload', 'true', 0, '/', null, false, false));
        }

        return $this->setContent($this->data);
    }
}
