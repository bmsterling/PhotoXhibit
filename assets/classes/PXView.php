<?php
// http://codereview.stackexchange.com/questions/19460/is-this-a-proper-way-of-loading-views-in-php
class PXView implements ArrayAccess {
    /**
     * View file to include
     * @var string
     */
    private $file;

    /**
     * View data
     * @var array
     */
    private $data;

    /**
     * Layout to include (optional)
     * @var string
     */
    private $layout;

    /**
     * Constructor
     *
     * @param string $file file to include
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * render Renders the view using the given data
     *
     * @param array $data
     * @return void
     */
    public function render($data)
    {
        $this->data = $data;
        $this->layout = null;

        ob_start();

        include ($this->file);

        // If we did not set a layout
        if (null === $this->layout)
        {
            // flush view output
            ob_end_flush();
        }
        // We set a layout
        else
        {
            // Ignore view output
            ob_end_clean();

            // Include the layout
            $this->include_file($this->layout);
        }
    }

    /**
     * fetch Fetches the view result intead of sending it to the output buffer
     *
     * @param array $data
     * @return string The rendered view content
     */
    public function fetch($data)
    {
        ob_start();
        $this->render($data);
        return ob_get_clean();
    }

    /**
     * get_data Returns the view data
     *
     * @return array
     */
    public function get_data()
    {
        return $this->data;
    }

    /**
     * include_file Used by view to include sub-views
     *
     * @param string $file
     * @return void
     */
    protected function include_file($file)
    {
        $v = new View($file);
        $v->render($this->data);
        $this->data = $v->get_data();
    }

    /**
     * set_layout Used by view to indicate the use of a layout.
     *
     * If a layout is selected, the normal output of the view wil be
     * discarded.  The only way to send data to the layout is via
     * capture()
     *
     * @param string $file
     * @return void
     */
    protected function set_layout($file)
    {
        $this->layout = $file;
    }

    /**
     * capture Used by view to capture output.
     *
     * When a view is using a layout (via set_layout()), the only way to pass
     * data to the layout is via capture(), but the view can use capture()
     * to capture text any time, for any reason, even if the view is not using
     * a layout
     *
     * @return void
     */
    protected function capture()
    {
        ob_start();
    }

    /**
     * end_capture Used by view to signal end of a capture().
     *
     * The content of the capture is stored under $name
     *
     * @param string $name
     * @return void
     */
    protected function end_capture($name)
    {
        $this->data[$name] = ob_get_clean();
    }

    /* ArrayAccess methods */
    public function offsetExists($offset)      { return isset($this->data[$offset]); }
    public function offsetGet($offset)         { return $this->data[$offset]; }
    public function offsetSet($offset, $value) { $this->data[$offset] = $value; }
    public function offsetUnset($offset)       { unset($this->data[$offset]); }

}