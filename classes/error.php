<?php

/**
 * This class is used for error control and important messages sent to the user.
 */
class Error
{

    /**
     *
     * <p>We are generating an error message in this function.</p>
     * <p>This method is NOT declared outside this file, however.</p>
     * 
     * @param type $msg <p>The error message.</p>
     * @return string <p>The error is returned.</p>
     */
    public function doMSG($msg)
    {
        // Print the error.
        $func = exit("<html><body style='background-color: white; font-size: 20px; font-weight: bold; color: black;'><div style='text-align: center;'>" . $msg . "</div></body></html>");
        // Return the function.
        return $func;
    }

    /**
     *
     * Here, we are getting ready to redirect the user to a different page.
     * 
     * @param type $to <p>The url in which we are going to.</p>
     * @param type $msg <p>The message to be displayed.</p>
     */
    public function doGo($to, $msg)
    {
        // Redirect.
        @header("refresh: 1; url=" . $to);
        // Print the message.
        echo $this->doMSG($msg);
    }
}

?>