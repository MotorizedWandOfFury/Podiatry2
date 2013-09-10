<?php

/**
 * This class is used to help set up various inputs in the project.
 */
class Input
{

    /**
     *
     * This object is used for readonly purposes. No values can
     * be changed.
     * 
     * @param type $class <p>Class name for the object.</p>
     * @param type $name <p>The name of this object.</p>
     * @param type $val <p>The value for this object.</p>
     * @return string <p>input type = text</p>
     */
    public function readonly($class, $name, $val)
    {
        return "<input class='" . $class . "' type='text' name='" . $name . "' value='" . $val . "' readonly='true' />";
    }

    /**
     *
     * This object is used for text field purposes. Values can be
     * changed.
     * 
     * @param type $class <p>The class name for the object.</p>
     * @param type $name <p>The name of this object</p>
     * @return string <p>input type = text</p>
     */
    public function text($class, $name)
    {
        return "<input class='" . $class . "' type='text' name='" . $name . "' id='" .$name. "' />";
    }
	
	//input field for password
	public function textPass($class, $name)
    {
        return "<input class='" . $class . "' type='password' name='" . $name . "' id='" .$name. "' />";
    }
    
    
    public function in_text($class, $name, $val)
    {
        return "<input class='" . $class . "' type='text' name='" . $name . "' value='" . $val . "' />";
    }

    /**
     *
     * This object is used for multiple choice purposes.
     * 
     * @param type $name <p>The name of this object.</p>
     * @param type $val <p>The value for this object.</p>
     * @return string <p>input type = radio</p>
     */
    public function radio($name, $val)
    {
        return "<input type='radio' value='" . $val . "' name='" . $name . "' />";
    }
    
    /**
     *
     * This object is used for multiple choice purposes.
     * 
     * @param type $name <p>The name of this object.</p>
     * @param type $val <p>The value for this object.</p>
     * @return string <p>input type = checkbox</p>
     */
    public function checkbox($name, $val)
    {
        return "<input type='checkbox' name='" . $name . "' value='" . $val . "' />";   
    }

}

?>