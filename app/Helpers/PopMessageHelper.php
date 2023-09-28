<?php

if (!function_exists('SuccessMessage')) {

    function CreateMessage($message)
    {
        return "$message successfully created.";
    }
    function UpdateMessage($message)
    {
        return "$message successfully updated.";
    }
    function FailedUpdateMessage($message)
    {
        return "Failed to update $message.";
    }
    function DeleteMessage($message)
    {
        return "$message successfully deleted.";
    }
    function FailedDeleteMessage($message)
    {
        return "Failed to update $message.";
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
