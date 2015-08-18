<?php

namespace ArjanSchouten\HTMLMin;

class MinifyContext
{
    /**
     * @var \ArjanSchouten\HTMLMin\PlaceholderContainer
     */
    private $placeholderContainer;

    /**
     * @var string
     */
    private $contents;

    /**
     * @param  \ArjanSchouten\HTMLMin\PlaceholderContainer  $placeholderContainer
     */
    public function __construct(PlaceholderContainer $placeholderContainer)
    {
        $this->placeholderContainer = $placeholderContainer;
    }

    /**
     * Get the placeholdercontainer.
     *
     * @return \ArjanSchouten\HTMLMin\PlaceholderContainer
     */
    public function getPlaceholderContainer()
    {
        return $this->placeholderContainer;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param  string  $contents
     * @return $this
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }
}