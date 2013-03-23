<?php

namespace Access\DataTable\Element\HtmlElement;

use Access\DataTable\Element\HtmlElement\AbstractElement;

/**
 *
 */
class AImgElement extends AbstractElement
{
    /**
     * @var ImgElement
     */
    private $img;

    /**
     * @param string $attributesForA
     * @param array $dbColumnsForA
     * @param array $attributesForImg
     * @param array $dbColumnsForImg
     * @param array|bool $requirement
     */
    function __construct(
        $attributesForA,
        $dbColumnsForA = array(),
        $attributesForImg,
        $dbColumnsForImg = array(),
        $requirement = false
    ) {
        parent::__construct($attributesForA, $dbColumnsForA, $requirement);
        $this->img = new ImgElement($attributesForImg, $dbColumnsForImg, false);
    }

    //TODO : Set a type in doc for attribute $line;
    /**
     * @param $line
     * @return string
     */
    public function getValueToPrint($line)
    {
        $replacedAttributes = $this->attributes;
        foreach ($this->dbColumns as $key => $columnName) {
            $replacedAttributes = str_replace($key, $line[$columnName], $replacedAttributes);
        }

        $value = "";
        if ($this->canBePrinted($line)) {
            $value = "<a ";
            $value .= $replacedAttributes;
            $value .= " >";
            $value .= $this->img->getValueToPrint($line);
            $value .= " </a>";
        }

        return $value;
    }
}
