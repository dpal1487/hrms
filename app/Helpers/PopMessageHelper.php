<?php

if (!function_exists('SuccessMessage')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function CreateMessage()
    {
        return "Successfully created.";
    }
    function UpdateMessage($message)
    {
        return "$message Successfully updated.";
    }
    function DeleteMessage()
    {
        return "Successfully deleted.";
    }

    function ErrorMessage()
    {
        return "Opps! something went wrong.";
    }
    function StatusMessage($message, $status)
    {
        return "$message status update was successful $status";
    }
};
