<?php

if (!function_exists('SuccessMessage')) {

    function CreateMessage($message)
    {
        return "$message Successfully created.";
    }
    function UpdateMessage($message)
    {
        return "$message Successfully updated.";
    }
    function DeleteMessage($message)
    {
        return "$message Successfully deleted.";
    }

    function ErrorMessage()
    {
        return "Opps! something went wrong.";
    }
    function StatusMessage($message, $status)
    {
        return " Your $message status update was successfully $status";
    }
};
