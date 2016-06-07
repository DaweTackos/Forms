<?php

namespace Utils;

/**
 * Static class for creating and operate with html element.
 */
class Html
{

    /** @var string */
    private $name;

    /** @var boolean */
    private $isEmpty;

    /** @var array */
    private $attrs = [];

    /** @var array */
    protected $children = [];

    /** @var array */
    public static $emptyElements = ['img'=>1, 'hr'=>1, 'br'=>1, 'input'=>1, 'meta'=>1, 'area'=>1, 'embed'=>1
                                    , 'keygen'=>1, 'source'=>1, 'base'=>1, 'col'=>1, 'link'=>1, 'param'=>1
                                    , 'basefont'=>1, 'frame'=>1, 'isindex'=>1, 'wbr'=>1, 'command'=>1, 'track'=>1];


    /**
     * Create static class of html element.
     *
     * @param  string $name
     *
     * @return Html
     */
    public static function el($name)
    {
        $el = new static;
        $el->setName($name);

        return $el;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param  string $name
     *
     * @return Html
     *
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        if ($name !== null && !is_string($name)) {
            throw new \InvalidArgumentException(sprintf('Name must be string or NULL, %s given.', gettype($name)));
        }
        $this->name = $name;
        $this->isEmpty = isset(static::$emptyElements[$name]) ? true : false;

        return $this;
    }


    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->isEmpty;
    }


    /**
     * Renders element's start tag, content and end tag.
     *
     * @return string
     */
    public function render()
    {
        $s = $this->startTag();

        foreach ($this->children as $child) {
            if ($child instanceof Html) {
                $child = $child->render();
            }
            $s .= $child;
        }
        $s .= $this->endTag();

        return $s;
    }


    /**
     * Returns element's start tag.
     * @return string
     */
    public function startTag()
    {
        if ($this->name) {
            return '<' . $this->name . $this->attributes() . ($this->isEmpty ? ' />' : '>');
        } else {
            return '';
        }
    }


    /**
     * Returns element's end tag.
     * @return string
     */
    public function endTag()
    {
        return $this->name && !$this->isEmpty ? '</' . $this->name . '>' : '';
    }


    /**
     * Sets element's attribute.
     *
     * @param  string $name
     * @param  mixed $value
     *
     * @return self
     */
    public function setAttribute($name, $value)
    {
        $this->attrs[$name] = $value;

        return $this;
    }


    /**
     * Returns element's attribute.
     * @param  string
     * @return mixed
     */
    public function getAttribute($name)
    {
        return isset($this->attrs[$name]) ? $this->attrs[$name] : null;
    }


    /**
     * Unset element's attribute.
     *
     * @param  string
     *
     * @return self
     */
    public function removeAttribute($name)
    {
        unset($this->attrs[$name]);
        return $this;
    }

    /**
     * Return string of element attributes.
     *
     * @return string
     */
    public function attributes()
    {
        if (!is_array($this->attrs)) {
            return '';
        }

        $attrs = $this->attrs;
        $s = sizeof($attrs) > 0 ? ' ' : '';

        foreach ($attrs as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }
            $s .= $key . '="' . $value . '" ';
        }

        return $s;
    }


    /**
     * Sets element's textual content.
     *
     * @param  string
     *
     * @return self
     */
    public function setText($text)
    {
        if (!is_array($text) && !$text instanceof self) {
          $text = htmlspecialchars((string) $text, ENT_NOQUOTES, 'UTF-8');
        }
        return $this->setHtml($text);
    }


    /**
     * Sets element's HTML content.
     *
     * @param  string raw HTML string
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setHtml($html)
    {
        if (is_array($html)) {
            throw new \InvalidArgumentException(sprintf('Textual content must be a scalar, %s given.', gettype($html)));
        }
        $this->removeChildren();
        $this->children[] = (string) $html;

        return $this;
    }


    /**
     * Removes all children.
     *
     * @return void
     */
    public function removeChildren()
    {
        $this->children = [];
    }


    /**
     * Get all children.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }



    /**
     * Add child to element.
     *
     * @param  Html $element
     *
     * @return self
     */
    public function addChild($element)
    {
        if (!($element instanceof Html)) {
            $element = Html::el($element);
        }
        $this->children[] = $element;

        return $this;
    }

}
