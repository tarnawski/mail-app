<?php
namespace ApiBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class EmlResponse extends Response
{
    protected $data;
    protected $filename  = 'email.eml';

    /**
     * {@inheritdoc}
     */
    public function __construct($content = '', $status = 200, array $headers = array())
    {
        parent::__construct($content, $status, $headers);

        $this->data = $content;
        $this->update();
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
            $this->headers->set('Content-Type', 'message/rfc822');

            // cookie required by jquery.filedownload.js extension
            $this->headers->setCookie(new Cookie('fileDownload', 'true', 0, '/', null, false, false));
        }

        return $this->setContent($this->data);
    }
}
